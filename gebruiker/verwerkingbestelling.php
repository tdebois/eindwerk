<?php
session_start();

ob_start();

//connectie invoegen
include_once "../include/connectie.php";
//paginatoegang controleren
include_once "includes/pageaccess.php";
//formvalidatie invoegen
include_once "includes/formvalidatie.php";

//als de actie uit de URL ingesteld is en niet leeg is, de actie in een variabele plaatsen
if (isset($_GET['action']) && !empty($_GET['action'])) {
    $action = $_GET['action'];
}
//anders terugsturen naar de startpagina
else {
    header('location:../index.php');
    die();
}
?>

<?php

////////////////////
//switch uitbouwen//
////////////////////

switch ($action) {
    /////////////////////////
    //afleveradres wijzigen//
    /////////////////////////

    case 'wijzigafleveradres':

        //adresgegevens ophalen uit het formulier en in een variabele plaatsen
        $straat = $_POST['straat'];
        $huisnr = $_POST['huisnr'];
        $postcode = $_POST['postcode'];
        $gemeente = $_POST['gemeente'];

        //formvalidatie via de functie veldleeg (controleren of de adresgegevens niet leeg zijn)
        veldleeg($straat, 'straat');
        veldleeg($huisnr, 'huisnr');
        veldleeg($postcode, 'postcode');
        veldleeg($gemeente, 'gemeente');

        //array message koppelen aan de sessie
        //sessie error beschikbaar stellen op andere pagina's
        $_SESSION['error'] = $message;

        if (isset($_SESSION['error'])) {
            header("location:../paginas/afleveradreswijzigen.php");
            die();
        }

        //variabelen in de sessie's plaatsen
        //waarom telkens 2? omdat er bij de registratie ook gebruik gemaakt wordt straat, huisnr ...
        $_SESSION['straat2'] = $straat;
        $_SESSION['huisnr2'] = $huisnr;
        $_SESSION['postcode2'] = $postcode;
        $_SESSION['gemeente2'] = $gemeente;

        //doorsturen naar de pagina bevestiging
        header('location:../index.php');
        die();

     ////////////
    //bestellen//
    /////////////

    case 'bestellen':

        //als de checkbox akkoord (algemene voorwaarden) niet is ingesteld terugsturen naar de pagina bevestiging
        //met de melding in de URL dat de checkbox akkoord niet aangevinkt is
        if (!isset($_POST['akkoord'])) {
            header("location:../paginas/bevestiging.php?akkoord=neen");
            die();
        }

        ///////////////////////////////////
        //gegevens in variabelen plaatsen//
        ///////////////////////////////////

        //IP-adres in een variabele plaatsen
        $ipadres = $_SERVER['HTTP_HOST'];

        //session ID in een variabele plaatsen
        $sessionid = session_id();

        //de sessie's leveringsmethode, betalingsmethode en gebruikersid in een variabele plaatsen
        $leveringsmethodeid = $_SESSION['leveringsmethode'];
        $betalingsmethodeid = $_SESSION['betalingsmethode'];

        $gebruikersid = $_SESSION['gebruikersid'];

        //de sessie's met de adresgegevens in een variabele plaatsen
        //waarom telkens 2? omdat er bij de registratie ook gebruik gemaakt wordt straat, huisnr ...
        $afleverstraat = $_SESSION['straat2'];
        $afleverhuisnr = $_SESSION['huisnr2'];
        $afleverpostcode = $_SESSION['postcode2'];
        $aflevergemeente = $_SESSION['gemeente2'];

        ///////////////////////////////
        //invoegen in tblbestellingen//
        ///////////////////////////////

        //query uitbouwen, gegevens van de bestelling invoeren in tblbestellingen
        $querybesteltoevoegen = "INSERT INTO tblbestellingen
                        (KlantID, Status, LeveringsmethodeID, BetalingsmethodeID, AdresIP, LeveringsStraat, LeveringsNr, LeveringsPostcode, LeveringsGemeente)
                        VALUES (
                        '".$gebruikersid."', 1, '".$leveringsmethodeid."', '".$betalingsmethodeid."', '".$ipadres."', '".$afleverstraat."', '".$afleverhuisnr."', '".$afleverpostcode."', '".$aflevergemeente."')";

        //uitvoeren van de query
        mysql_query($querybesteltoevoegen) or die (mysql_error());

        //met de functie mysql_insert_id de bestelid van de bestelling onthouden
        $bestelid = mysql_insert_id();

        //bestelid in een sessie plaatsen om in overzichtbestelling.php die sessie aan te spreken
        $_SESSION['bestelid'] = $bestelid;

        /////////////////////////////////////
        //invoegen in tblbestellingendetail//
        /////////////////////////////////////

        //om undefined variable foutmelding te vermijden het totaal van de bestelling instellen op 0
        $totaalbestelling = 0;

        //vraag aan de database stellen, selecteer het boekid, prijs, aantal, aantal verkocht en voorraad
        //uit de tabellen tbltempbesteldetail en tblboeken waar de session ID gelijk is aan de session ID van de gebruiker
        $querybestelling = "SELECT tbltempbestellingendetail.ProductID, tbltempbestellingendetail.ProductPrijs, tbltempbestellingendetail.ProductAantal, tblproducten.ProductAantalVerkocht, tblproducten.ProductVoorraad
                            FROM tbltempbestellingendetail
                            INNER JOIN tblproducten
                            ON tbltempbestellingendetail.ProductID = tblproducten.ProductID
                            WHERE SessionID = '".$sessionid."'";

        //query uitvoeren
        $resultsbestelling = mysql_query($querybestelling) or die(mysql_error());

        //lus starten, rijen herhalen zolang er boeken in de database zitten
        while($row = mysql_fetch_array($resultsbestelling)) {

            $boekid = $row['ProductID'];
            $boekprijs = $row['ProductPrijs'];
            $boekaantal = $row['ProductAantal'];

            //query uitbouwen het bestelid, boekid, boekprijs en boekaantal toevoegen in de tabel tblbestellingdetail
            $querybesteldetailtoevoegen = "INSERT INTO tblbestellingendetail
                                   (BestellingID, ProductID, ProductPrijs, ProductAantal)
                                   VALUES (
                                   '".$bestelid."', '".$boekid."', '".$boekprijs."', '".$boekaantal."')";

            //query uitvoeren
            mysql_query($querybesteldetailtoevoegen) or die (mysql_error());

            ////////////////////////////////////
            //aantal verkochte boeken verhogen//
            ////////////////////////////////////

            $boekaantalverkocht = $row['ProductAantalVerkocht'];
            $boekaantalverkocht += $boekaantal;

            //query uitbouwen, het aantal verkochte boeken verhogen
            $queryverhoogaantalverkocht = "UPDATE tblproducten SET ProductAantalVerkocht = '".$boekaantalverkocht."' WHERE ProductID = '".$boekid."'";

            //query uitvoeren
            mysql_query($queryverhoogaantalverkocht) or die (mysql_error());

            /////////////////////
            //voorraad verlagen//
            /////////////////////

            $boekvoorraad = $row['ProductVoorraad'];

            $boekvoorraad -= $boekaantal;

            //query uitbouwen, de voorraad verlagen
            $queryverlaagvoorraad = "UPDATE tblproducten SET ProductVoorraad = '".$boekvoorraad."' WHERE ProductID = '".$boekid."'";

            //uitvoeren van de query
            mysql_query($queryverlaagvoorraad) or die (mysql_error());
        }

        ////////////////////////////////////////////////////////
        //e-mail sturen met gegevens bestelling (enkel online)//
        ////////////////////////////////////////////////////////

        //als je niet op de localhost surft (online) een e-mail versturen
        if ($ipadres != 'localhost' && $ipadres != '127.0.0.1') {

            //////////////////////////////
            //gegevens gebruiker ophalen//
            //////////////////////////////

            //vraag aan de database stellen, selecteer de gegevens van de gebruiker uit de tabel tblklanten en tbllanden
            //waar het gebruikersid gelijk is aan de gebruikersid uit de sessie
            $querygebruiker = "SELECT tblklanten.Email, tblklanten.Voornaam, tblklanten.Familienaam,
                           tblklanten.Straat, tblklanten.Nummer, tblklanten.Postcode, tblklanten.Gemeente, tbllanden.LandNaam
                           from tblklanten
                           INNER JOIN tbllanden
                           ON tblklanten.LandID = tbllanden.LandID
                           WHERE KlantID = '".$gebruikersid."'";

            //query uitvoeren
            $resultsgebruiker = mysql_query($querygebruiker) or die(mysql_error());

            //lus starten, rijen herhalen zolang er gebruikers in de database ziten (1 gebruiker)
            while($row = mysql_fetch_array($resultsgebruiker)) {

                $voornaam = $row['Voornaam'];
                $familienaam = $row['Familienaam'];
                $emailadres = $row['Email'];
                $straat = $row['Straat'];
                $huisnr = $row['Nummer'];
                $postcode = $row['Postcode'];
                $gemeente = $row['Gemeente'];
                $landnaam = $row['LandNaam'];
            }


            //het bestelnummer bestaat uit de bestelid, gebruikersid, en de datum zonder streepjes
            $bestelnummer = $bestelid.$gebruikersid;

            ////////////////////
            //e-mail opstellen//
            ////////////////////

            //een e-mail zenden naar de gebruiker
            $headers = "From: Nv Scrivere \r\n";
            $headers .= "X-Sender: <thomas.debois@gmail.com>\r\n";
            $headers .= "X-Mailer: PHP\r\n";
            $headers .= "X-Priority: 3\r\n";
            $headers .= "Return-Path: <".$emailadres.">\r\n";
            $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

            $onderwerp = "Uw factuur met bestelnummer ".$bestelnummer;

            $bericht = "
            <html>
                <body>
                    <p>Beste ".$voornaam." ".$familienaam."
                    <p>Hierbij ontvangt u de factuur voor uw bestelling van ".$datum.".</p>
                    <p>
                        <b>Bestelnummer:</b> ".$bestelnummer."<br />
                    <p>

                    <table>
                        <tr>
                            <td><b>Titel</b></td>
                            <td><b>Aantal</b></td>
                            <td><b>Prijs/stuk</b></td>
                            <td><b>Totaalprijs</b></td>
                        </tr>";

            //$totaal op nul zetten of een undefined variable te vermijden
            $totaalprijs = 0;

            ///////////////////////////////
            //gegevens bestelling ophalen//
            ///////////////////////////////

            //vraag aan de database stellen, selecteer de prijs, het aantal en de titel van de tabel boeken en bestellingen
            //waar het bestelid uit de tabel bestellingen gelijk is aan de variabele $bestelid
            $querybestelling = "SELECT tblbestellingendetail.ProductPrijs, tblbestellingendetail.ProductAantal, tblproducten.ProductNaam
                                FROM tblklanten
                                INNER JOIN tblbestellingen ON tblklanten.KlantID = tblbestellingen.KlantID
                                INNER JOIN tblbestellingendetail ON tblbestellingen.BestellingID = tblbestellingendetail.BestellingID
                                INNER JOIN tblproducten ON tblbestellingendetail.ProductID = tblproducten.ProductID
                                WHERE tblbestellingen.BestellingID = '".$bestelid."'";

            //query uitvoeren
            $resultsbestelling = mysql_query($querybestelling)
                or die(mysql_error());

            //lus starten, rijen herhalen zolang er gebruikers in de database zitten (1 gebruiker)
            while($row = mysql_fetch_array($resultsbestelling)) {

                $boekprijs = number_format($row['ProductPrijs'], 2) ;
                $boekaantal = $row['ProductAantal'];
                $boektitel = $row['ProductNaam'];

                //de totaalprijs van het soort boek is de prijs van het boek * het aantal
                $boektotaalprijs = $boekaantal * $boekprijs;

                //de totaalprijs per soort boek wordt telkens opgeteld bij de totaalprijs
                $totaalprijs += $boektotaalprijs;

                //e-mail opstellen//

                $bericht .=
                "<tr>
                      <td>".$boektitel."</td>
                      <td>".$boekaantal."</td>
                      <td>&#8364; ".number_format($boekprijs, 2)."</td>
                      <td>&#8364; ".number_format($boektotaalprijs, 2)."</td>
                 </tr>";
            }


            //de prijs exclusief BTW berekenen
            $totaalexclbtw = ($totaalprijs / 106) * 100;

            //de BTW berekenen
            $btw = $totaalprijs - $totaalexclbtw;

            //e-mail opstellen//

            $bericht .=
                "<tr>
                    <td colspan='4' style='height: 20px'></td>
                </tr>
                <tr>
                    <td colspan='3'>Totaal excl BTW</td>
                    <td>&#8364; ".number_format($totaalexclbtw, 2)."</td>
                 </tr>

                <tr>
                    <td colspan='3'>Totaal BTW</td>
                    <td>&#8364; ".number_format($btw, 2)."</td>
                </tr>

                <tr>
                    <td colspan='3'>Totaal incl BTW</td>
                    <td>&#8364; ".number_format($totaalprijs, 2)."</td>
                </tr>";

            //vraag aan de database stellen, selecteer de gegevens van de leveringsmethode uit de tabel tblleveringsmethodes
            //waar het bestelid uit de tabel bestellingen gelijk is aan de variabele $bestelid
            $queryleveringsmethode = "SELECT tblleveringsmethodes.LeveringsmethodeNaam, tblleveringsmethodes.LeveringsKosten
                                      FROM tblleveringsmethodes
                                      INNER JOIN tblbestellingen ON tblleveringsmethodes.LeveringsmethodeID = tblbestellingen.LeveringsmethodeID
                                      WHERE tblbestellingen.BestellingID = '".$bestelid."'";

            //query uitvoeren
            $resultsleveringsmethode = mysql_query($queryleveringsmethode)
                or die(mysql_error());

            //lus starten, rijen herhalen zolang er leveringsmethodes in de database zitten (1 leveringsmethode)
            while($row = mysql_fetch_array($resultsleveringsmethode)) {

                $leveringsmethodenaam = $row['LeveringsmethodeNaam'];
                $leveringskosten = $row['LeveringsKosten'];

            }

            //vraag aan de database stellen, selecteer de gegevens van de betalingsmethode uit de tabel tblbestelingsmethodes
            //waar het bestelid uit de tabel bestellingen gelijk is aan de variabele $bestelid
            $querybetalingsmethode = "SELECT tblbetalingsmethodes.BetalingsmethodeNaam, tblbetalingsmethodes.Kosten
                                      FROM tblbetalingsmethodes
                                      INNER JOIN tblbestellingen ON tblbetalingsmethodes.BetalingsmethodeID = tblbestellingen.BetalingsmethodeID
                                      WHERE tblbestellingen.BestellingID = '".$bestelid."'";

            //query uitvoeren
            $resultsbetalingsmethode = mysql_query($querybetalingsmethode)
                or die(mysql_error());

            //lus starten, rijen herhalen zolang er bestellingen in de database zitten
            while($row = mysql_fetch_array($resultsbetalingsmethode)) 			{

                $betalingsmethodenaam = $row['BetalingsmethodeNaam'];
                $betaalkosten = $row['Kosten'];
            }

            //het totaal van de bestelling zijn de leveringskosten + de betaalkosten + de totale prijs
            $totaal = $leveringskosten + $betaalkosten + $totaalprijs;

            //als er geen betaalkosten zijn krijgt de variabele betaalkosten de waarde gratis
            if ($betaalkosten == 0) {
                $betaalkosten = 'Gratis';
            } else {
                $betaalkosten = "&#8364; ".$betaalkosten;
            }

            //e-mail opstellen//

            $bericht .=
                        "<tr>
                            <td colspan='4' style='height: 20px'></td>
                        </tr>
                        <tr>
                            <td colspan='3'>Levering door ".$leveringsmethodenaam."</td>
                            <td>&#8364; ".$leveringskosten."</td>
                        </tr>
                        <tr>
                            <td colspan='3'>Betaalt met ".$betalingsmethodenaam."</td>
                            <td>".$betaalkosten."</td>
                        </tr>
                        <tr>
                            <td colspan='3'><b>Totaalbedrag:<b/></td>
                            <td><b>&#8364; ".number_format($totaal, 2)."<b/></td>
                        </tr>
                    </table>

                    <p>
                        <table>
                            <tr>
                                <td><b>Afleveradres<b/></td>
                                <td><b>Factuuradres<b/></td>
                            </tr>
                            <tr>
                                <td>".$voornaam." ".$familienaam."</td>
                                <td>".$voornaam." ".$familienaam."</td>
                            </tr>
                            <tr>
                                <td>".$afleverstraat." ".$afleverhuisnr."</td>
                                <td>".$straat." ".$huisnr."</td>
                            </tr>
                            <tr>
                                <td>".$aflevergemeente." ".$afleverpostcode."</td>
                                <td>".$gemeente." ".$postcode."</td>
                            </tr>
                            <tr>
                                <td>".$landnaam."</td>
                                <td>".$landnaam."</td>
                            </tr>
                        </table>
                    </p>

                     <p>
                        Met vriendelijke groeten<br />
						Thomas Debois
                    </p>
                </body>
            </html>";

            ////////////////////
            //e-mail versturen//
            ////////////////////

            mail ($emailadres,$onderwerp,$bericht,$headers);
        }

        //////////////////////////
        //winkelmandje leegmaken//
        //////////////////////////

        //session id van de gebruiker in een variabele plaatsen
        $sessionid = session_id();

        //verwijder in tbltempbesteldetail//

        //query uitbouwen, verwijder alle details van de bestellingen waar het sessionid gelijk is aan de session id van de gebruiker
        $queryleegwinkelmandjedetail = "DELETE FROM tbltempbestellingendetail WHERE SessionID = '".$sessionid."'";

        //uitvoeren van de query
        mysql_query($queryleegwinkelmandjedetail) or die (mysql_error());

        //verwijder in tbltempbestel//

        //query uitbouwen, verwijder de bestelling waar het sessionid gelijk is aan de session id van de gebruiker
        $queryleegwinkelmandje = "DELETE FROM tbltempbestellingen WHERE SessionID = '".$sessionid."'";

        //uitvoeren van de query
        mysql_query($queryleegwinkelmandje) or die (mysql_error());

        //sessie's leegmaken die na deze pagina niet meer worden gebruikt
        unset($_SESSION['straat2']);
        unset($_SESSION['huisnr2']);
        unset($_SESSION['postcode2']);
        unset($_SESSION['gemeente2']);

        unset($_SESSION['leveringsmethode']);
        unset($_SESSION['betalingsmethode']);

        //nadat er bestelt wordt is het winkelmandje terug leeg
        unset($_SESSION['sessionid']);
        //doorsturen naar het overzicht van de bestelling
		
        //terugsturen naar de startpagina
        header("location:../paginas/overzichtbestelling.php");
		die();
		
		default:
		header("location:../index.php");
		die();
}
?>
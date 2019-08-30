<?php
session_start();
//sessie's mogelijk maken

//connectie invoegen
include_once "includes/connectie.php";

//als de actie uit de URL ingesteld is en niet leeg is, de actie in een variabele plaatsen
if (isset($_GET['action']) or !empty($_GET['action'])) {
    $action = $_GET['action'];

//anders terugsturen naar het winkelmandje winkelmandje
} else {
    header('location:../paginas/winkelmandje.php');
    die();
}

//als het boekid uit de URL is ingesteld en niet leeg is, het boekid in een variabel plaatsen
if (isset($_GET['productid']) or !empty($_GET['productid'])) {
    $productid = $_GET['productid'];

//anders terugsturen naar het winkelwagentje
} else {
    header('location:../paginas/winkelmandje.php');
    die();
}

//de sessions ID in een variabele plaatsen
$sessionid = session_id();

////////////////////
//switch uitbouwen//
////////////////////

switch ($action) {

    ////////////////////
    //item verwijderen//
    ////////////////////

    case 'delete':

        //query uitbouwen, verwijder in de tabel tbltempbesteldetail waar de sessionid gelijk is aan de variabele $sessionid
        //en het boekid gelijk is aan het boekid uit de URL
        $qrydelete = "DELETE FROM tbltempbestellingendetail WHERE SessionID = '".$sessionid."' AND ProductID = '".$productid."'";

        //query uitvoeren
        mysql_query($qrydelete) or die (mysql_error());

        //terugsturen naar het winkelwagentje
        header('location:../paginas/winkelwagentje.php');
        die();

    ///////////////////
    //aantal verhogen//
    ///////////////////

    case 'verhoog':

        //vraag aan de database stellen, selecteer het boekaantal uit de tabel tbltempbesteldetail
        //waar de sessionid gelijk is aan de variabele $sessionid
        //en het boekid gelijk is aan het boekid uit de URL
        $qryaantalproducten = "SELECT ProductAantal FROM tbltempbestellingendetail WHERE SessionID = '".$sessionid."' AND ProductID = '".$productid."'" ;

        //query uitvoeren
        $resultsaantalproducten = mysql_query($qryaantalproducten)
            or die(mysql_error());

        //lus starten, rijen herhalen zolang er temp bestellingen in de database zitten (1 boek)
        while($row = mysql_fetch_array($resultsaantalproducten)) {

            $productaantal = $row['ProductAantal'];

            //opgehaald boekaantal verhogen met 1
            $productaantal += 1;

            //query uitbouwen, verhoog het boekaantal waar de sessionid gelijk is aan de variabele $sessionid
            //en het boekid gelijk is aan het boekid uit de URL
            $qryaantalwijzigen = "UPDATE tbltempbestellingendetail
						SET ProductAantal = '".$productaantal."'
						WHERE SessionID = '".$sessionid."' AND ProductID = '".$productid."'";

            //query uitvoeren
            mysql_query($qryaantalwijzigen) or die (mysql_error());
        }

        //terugsturen naar het winkelwagentje
        header('location:../paginas/winkelwagentje.php');
        die();

    ///////////////////
    //aantal verlagen//
    ///////////////////

    case 'verlaag':

        //vraag aan de database stellen, selecteer het boekaantal uit de tabel tbltempbesteldetail
        //waar de sessionid gelijk is aan de variabele $sessionid
        //en het boekid gelijk is aan het boekid uit de URL
        $qryaantalproducten = "SELECT ProductAantal FROM tbltempbestellingendetail WHERE SessionID = '".$sessionid."' AND ProductID = '".$productid."'" ;

        //query uitvoeren
        $resultsaantalproducten = mysql_query($qryaantalproducten)
            or die(mysql_error());

        //lus starten, rijen herhalen zolang er temp bestellingen in de database zitten (1 boek)
        while($row = mysql_fetch_array($resultsaantalproducten)) {

            $productaantal = $row['ProductAantal'];

            //opgehaald boekaantal verlagen met 1
            $productaantal -= 1;

            //als het boekaantal lager is dan 0 terugsturen naar het winkelwagentje (aantal boeken kan niet 0 zijn)
            if ($productaantal < 1) {
                header('location:../index.php?page=winkelwagentje');
                die();
            }

            //query uitbouwen, verlaag het boekaantal waar de sessionid gelijk is aan de variabele $sessionid
            //en het boekid gelijk is aan het boekid uit de URL
            $qryaantalwijzigen = "UPDATE tbltempbestellingendetail
						SET ProductAantal = '".$productaantal."'
						WHERE SessionID = '".$sessionid."' AND ProductID = '".$productid."'";

            //query uitvoeren
            mysql_query($qryaantalwijzigen) or die (mysql_error());
        }

        //terugsturen naar het winkelwagentje
        header('location:../paginas/winkelwagentje.php');
        die();

    //////////////////
    //item toevoegen//
    //////////////////

    case 'toevoegen':

        //IP-adres in een variabele plaatsen
        $ipadres = $_SERVER['HTTP_HOST'];

        //standaard tijdzone instellen op Brussel (GMT + 2)
        date_default_timezone_set('Europe/Brussels');

        //de datum en tijd in een variabele plaatsen
        $datumuur =  date('Y/m/d H:i:s');

        //gegevens invoeren in tbltempbestel//

        //vraag aan de database stellen, selecteer de sessionid van de tabel tbltempbestel waar de sessionid gelijk is aan de variabele $sessionsid
        $querytempbestel = "SELECT SessionID FROM tbltempbestellingen WHERE SessionID = '".$sessionid."'";

        //uitvoeren van de query
        $resultstempbestel = mysql_query($querytempbestel)
            or die(mysql_error()); // zet je niets tussen de haakjes krijg je foutmelding uit de database

        //aantal rijen van de query in een variabele plaatsen
        $aantalrijen = mysql_num_rows($resultstempbestel);

        //als de gebruiker in een nieuwe sessie zit, de gegevens toevoegen aan tbltempbestel
        if ($aantalrijen == 0) {

            //query uitbouwen, voeg in de tabel tbltempbestel het sessionid, de besteldatum en het IP-adres toevoegen
            $querytemptoevoegen = "INSERT INTO tbltempbestellingen (SessionID, TempBestelDatum, AdresIP)
                                   VALUES ('".$sessionid."', '".$datumuur."', '".$ipadres."')";

            //query uitvoeren
            mysql_query($querytemptoevoegen) or die (mysql_error());

        }

        //gegevens invoeren in tbltempbesteldetail//

        //vraag aan de database stellen selecteer de prijs en de promoprijs van het boek uit de tabel tblboeken
        //waar het boekid gelijk is aan het boekid uit de URL
        $queryboek = "SELECT ProductPrijs, ProductPromoPrijs FROM tblproducten WHERE ProductID = ".$productid;

        //uitvoeren van de query
        $resultsboek = mysql_query($queryboek)
            or die(mysql_error()); // zet je niets tussen de haakjes krijg je foutmelding uit de database

        //het aantal rijen van de query in een variabele plaatsen
        $aantalrijen = mysql_num_rows($resultsboek);

        //lus starten, rijen herhalen zolang er boeken in de database zitten
        while($rowboek = mysql_fetch_array($resultsboek)) {
            $productprijs = $rowboek['ProductPrijs'];
            $productpromoprijs = $rowboek['ProductPromoPrijs'];

            //als er een promoprijs is, de promoprijs in een variabale plaatsen
            if ($productpromoprijs != 0) {
                $prijs = $productpromoprijs;

            //indien niet de prijs van het boek in een variabele plaatsen
            } else {
                $prijs = $productprijs;
            }

            //controleren of het boek reeds in tbltempbesteldetail zit//

            //vraag aan de database stellen, selecteer het boekid en boekaantal uit de tabel tbltempbesteldetail
            //waar de sessionid gelijk is aan de variabele $sessionid
            //en het boekid gelijk is aan het boekid uit de URL
            $querytempdetail = "SELECT ProductID, ProductAantal FROM tbltempbestellingendetail WHERE SessionID = '".$sessionid."' AND ProductID = '".$productid."'";

            //query uitvoeren
            $resultstempdetail = mysql_query($querytempdetail)
                or die(mysql_error()); // zet je niets tussen de haakjes krijg je foutmelding uit de database

            //aantal rijen van de query opslaan in een variabele
            $aantalrijen = mysql_num_rows($resultstempdetail);

            //als het boek nog niet in tbltempbesteldetail zit, het boek toevoegen
            if ($aantalrijen == 0) {

                //query uitbouwen, voeg de sessionis het boekid, het aantal (1) en de prijs toe aan de tabel tbltempbesteldetail
                $querytempdetailtoevoegen = "INSERT INTO tbltempbestellingendetail
                            (SessionID, ProductID, ProductAantal, ProductPrijs)
			                 VALUES (
                             '".$sessionid."', '".$productid."', 1,'".$prijs."')";
                //query uitvoeren
                mysql_query($querytempdetailtoevoegen) or die (mysql_error());

            //als het boek al in de tbltempbesteldetail zit, het aantal van het boek verhogen
            } else {

                //lus starten, rijen herhalen zolang er temp detail bestellingen in de database zitten
                while($rowtempdetail = mysql_fetch_array($resultstempdetail)) {
                    $productaantal = $rowtempdetail['ProductAantal'];
                }

                //het aantal van het opgehaalde boek verhogen met 1
                $productaantal += 1;

                //query uitbouwen, wijzig het aantal boeken waar de sessionid gelijk is aan de variabele $sessionid
                //en de het boekid gelijk is aan het boekid uit de URL
                $querytempdetailwijzigen = "UPDATE tbltempbestellingendetail
						SET ProductAantal = '".$productaantal."'
						WHERE SessionID = '".$sessionid."' AND ProductID = '".$productid."'";

                //query uitvoeren
                mysql_query($querytempdetailwijzigen) or die (mysql_error());
            }
        }

        //als de pagina voor deze pagina niet ingesteld is terugsturen naar de startpagina
        //welke situatie? als je na het opstarten van de browser naar deze pagina surft
        //met de ingestelde action voegitem toe en een boekid in de URL wordt er teruggestuurd naar de startpagina
        if (!isset($_SERVER['HTTP_REFERER'])) {
            header("location:../index.php");
            die();

        } else {
            //na de verwerking van het winkelmandje wordt er terug naar de pagina voor deze pagina gestuurd
            header('location:'.$_SERVER['HTTP_REFERER']);
            die();
        }

    ///////////////////
    //andere gevallen//
    ///////////////////

    default:
        //terugsturen naar de startpagina
        header("location:../index.php");
}

?>
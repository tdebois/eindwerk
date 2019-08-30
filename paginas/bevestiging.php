<?php 
	include_once "includes/connectie.php";
	
	session_start();
	
	//paginatoegang controleren
include_once "includes/pageaccess.php";
?>
<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
<meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title>Thomas Debois welkom op mijn website...</title>
        <meta charset="utf-8">
    <meta name="Description" CONTENT="Name: Thomas Debois">
		<meta name="keywords" content="thomas debois,thomas-debois,portfolio,thomasdubois,thomas-dubois,thomas dubois,thomas,debois,dubois,wordpress,bootstrap,thomas de bois,thomas de bois portfolio,de bois thomas,de bois thomas website">
		<meta name="description" content="Thomas Debois active job-applicant">
		<meta name="Author" content="Thomas Debois, Thomas Debois Wordpress">
		<meta name="viewport" content="width=device-width, maximum-scale=1, initial-scale=1, user-scalable=0">


        <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->

        <link rel="stylesheet" href="../css/app.css">
        <link rel="stylesheet" href="../css/normalize.css">
        <link rel="stylesheet" href="../css/main.css">

        <script src="../js/vendor/modernizr-2.6.2.min.js"></script>
    </head>
    <body>
        <!--[if lt IE 7]>
            <p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to improve your experience.</p>
        <![endif]-->

        <!-- Add your site or application content here -->
        <div id="wrap">

       <div class="header">
       		<div class="logo"></div>
            <div id="zoeken">
                    <form id="form1" name="form1" method="post" action="../gebruiker/zoeken.php">
                        <p><input type="text" name="zoek" id="zoek" placeholder="Trefwoord, titel, auteur ..." class="zoekveld" value=""/>
                        <input type="submit" name="zoekknop" id="zoekknop" class="zoekknop" value="Zoeken" /></p>
                    </form>
                </div>           
        <div id="menu">
            <ul>                                                                       
            <li><a href="../index.php">home</a></li>
            <li><a href="../voorwaarden.php">voorwaarden</a></li>
            <li><a href="../onsbedrijf.php">ons bedrijf</a></li>
            <li><a href="../contact.php">contact</a></li>
            
            <?php

                    if (isset($_SESSION['emailadres']) && isset($_SESSION['wachtwoord']) && isset($_SESSION['voornaamgeb'])) {
                        $voornaam = $_SESSION['voornaamgeb'];
                        ?>
                            <li><a href="gebruiker/uitloggen.php">uitloggen</a></li>

                        <?php
                    } else {
                        ?>
                        <li><a href="paginas/registreren.php">registreren</a></li>
            			<li><a href="paginas/inloggen.php">inloggen</a></li>
            
                        <?php
                    }
                    ?>
            </ul>
        </div>     
            
       </div> 
       
       
       <div class="center_content">
       	<div class="left_content">
<?php


//de session id in een variabele plaatsen
$sessionid = session_id();

?>
<h1>Bevestiging</h1>
<h1>Totaalprijs producten</h1>

<table width="330" height="59">
    <tr>
        <td>Titel boek</td>
        <td>Aantal</td>
        <td>Prijs/stuk</td>
        <td>Totaalprijs</td>
    </tr>

<?php

//de totaalprijs op 0 zetten om een undefined variabele te voorkomen
//later in de code $totaalprijs += $boektotaalprijs --> mogelijkheid dat de totaalprijs nog niet gedefineerd is
$totaalprijs = 0;

//vraag aan de database stellen, selecteer het detail van de bestelling (met titel boek)
//waar de sessionid van tbltempbesteldetail gelijk is aan de opgehaalde sessions id
$querygoederen = "SELECT tblproducten.ProductNaam, tbltempbestellingendetail.ProductAantal, tbltempbestellingendetail.ProductPrijs FROM tblproducten
                  INNER JOIN tbltempbestellingendetail ON tblproducten.ProductID = tbltempbestellingendetail.ProductID
                  WHERE tbltempbestellingendetail.SessionID = '".$sessionid."'";

//query uitvoeren
$resultsgoederen = mysql_query($querygoederen)
    or die(mysql_error()); //zet je niets tussen de haakjes krijg je foutmelding uit de database

//het aantal rijen van de query in een variabele plaatsen
$aantalrijen = mysql_num_rows($resultsgoederen);

//als het aantal rijen gelijk is aan 0, terugsturen naar het winkelwagentje
//doet zich voor als er op vanop de pagina overzichtbestelling.php op vorige wordt geklikt
if ($aantalrijen == 0) {
    header('location:winkelwagentje.php');
    die();
}

//lus starten, rijen herhalen zolang er details van de bestelling in de database zitten
while($row = mysql_fetch_array($resultsgoederen)) {

    $productnaam = $row['ProductNaam'];
    $productaantal = $row['ProductAantal'];
    $productprijs = $row['ProductPrijs'];

    //de totaalprijs van het soort boek is de prijs van het boek * het aantal
    $producttotaalprijs = $productprijs * $productaantal;

    //de totaalprijs per soort boek wordt telkens opgeteld bij de totaalprijs
    $totaalprijs += $producttotaalprijs;

    ?>

    <tr>
        <td><?php echo $productnaam; ?></td>
        <td><?php echo $productaantal;  ?></td>
        <td><?php echo "&#8364; ".number_format($productprijs, 2); ?></td>
        <td><?php echo "&#8364; ".number_format($producttotaalprijs, 2); ?></td>
    </tr>

    <?php
}

?>
</table>
<?php

//de prijs exclusief BTW berekenen
$totaalexclbtw = ($totaalprijs / 106) * 100;

//de BTW berekenen
$btw = $totaalprijs - $totaalexclbtw;

?>

<h1>Subtotaal</h1>

<table width="253" height="93">
    <tr>
        <td width="106">Totaal excl BTW:</td>
        <td width="135"><?php echo "&#8364; ".number_format($totaalexclbtw, 2); ?></td>
    </tr>

    <tr>
        <td>Totaal BTW:</td>
        <td><?php echo "&#8364; ".number_format($btw, 2); ?></td>
    </tr>

    <tr>
        <td>Totaal incl BTW:</td>
        <td><?php echo "&#8364; ".number_format($totaalprijs, 2); ?></td>
    </tr>
</table>

<h1>Totaal</h1>

<?php

    //als de leveringsmethode en de betalingsmethode opgehaald zijn uit het formulier, ze in een variabele plaatsen
    if (isset($_POST['leveringsmethode']) || isset($_POST['betalingsmethode'])) {
        $leveringsmethodeid =  $_POST['leveringsmethode'];
        $betalingsmethodeid = $_POST['betalingsmethode'];

        //leveringsmethode en betalingsmethode in een session plaatsen zodat er bij de foutmelding van de algmene voorwaarden
        //de leveringsmethode opnieuw kan worden opgevraagd zonder post
        $_SESSION['leveringsmethode'] = $leveringsmethodeid;
        $_SESSION['betalingsmethode'] = $betalingsmethodeid;

    //indien niet, bij de foutmelding van de algemene voorwaarden, de sessie's in de leveringsmethode en betalingsmethode plaatsen
    } else {
        $leveringsmethodeid = $_SESSION['leveringsmethode'];
        $betalingsmethodeid = $_SESSION['betalingsmethode'];
    }

//vraag aan de database stellen, selecteer de naam van de leveringsmethode en de kosten waar
//het id van de leveringsmethode gelijk is aan de leveringsmethode van het formulier of de sessie
$queryleveringsmethode = "SELECT LeveringsmethodeNaam, LeveringsKosten FROM tblleveringsmethodes WHERE LeveringsmethodeID = '".$leveringsmethodeid."'";

//query uitvoeren
$resultsleveringsmethode = mysql_query($queryleveringsmethode)
or die(mysql_error()); //zet je niets tussen de haakjes krijg je foutmelding uit de database

//lus starten, rijen herhalen zolang er leveringsmethodes in de database zitten (1 leveringsmethode)
while($row = mysql_fetch_array($resultsleveringsmethode)) {

    $leveringsmethodenaam = $row['LeveringsmethodeNaam'];
    $leveringskosten = $row['LeveringsKosten'];
}

//vraag aan de database stellen, selecteer de naam van de betalingsmethode en de kosten waar
//het id van de betalingsmethode gelijk is aan de betalingsmethode van het formulier of de sessie
$querybetalingsmethode = "SELECT BetalingsmethodeNaam, Kosten FROM tblbetalingsmethodes WHERE BetalingsmethodeID = '".$betalingsmethodeid."'";
$resultsbetalingsmethode = mysql_query($querybetalingsmethode) or die(mysql_error());

//lus starten, rijen herhalen zolang er betalingsmethodes in de database zitten (1 betalingsmethode)
while($row = mysql_fetch_array($resultsbetalingsmethode)) {

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
?>

<table width="253" height="89">
    <tr>
        <td width="107">Levering door <?php echo $leveringsmethodenaam; ?>:</td>
        <td width="134"><?php echo "&#8364; ".$leveringskosten; ?></td>
    </tr>

    <tr>
        <td>Betaalt met <?php echo $betalingsmethodenaam; ?>:</td>
        <td><?php echo $betaalkosten ?></td>
    </tr>

    <tr>
        <td><b>Totaal:</b></td>
        <td><b><?php echo "&#8364; ".number_format($totaal, 2); ?></b></td>
    </tr>
</table>

<h1>Afleveradres</h1>
<?php
//als de sessies straat2, huisnr2 ... ingesteld zijn, ze in een variabele plaatsen (de sessie's worden ingesteld bij de pagina afleveradreswijzigen.php)

//waarom telkens 2? omdat er bij de registratie ook gebruik gemaakt wordt straat, huisnr ...
//bv. wanneer je registreert stel je de sessie's in en maak je ze daarna terug leeg
//als ik niet met straat2, huisnr2 ... werk zullen de adresgegevens leeg worden ingevuld
if (isset($_SESSION['straat2']) || isset($_SESSION['huisnr2']) || isset($_SESSION['postcode2']) || isset($_SESSION['gemeente2'])) {

    $straat = $_SESSION['straat2'];
    $huisnr = $_SESSION['huisnr2'];
    $postcode = $_SESSION['postcode2'];
    $gemeente = $_SESSION['gemeente2'];

//indien niet, straat, huisnr ... ophalen uit de database
} else {

    //de gebruikersid van de gebruiker die ingelogd heeft in een variabele plaatsen
    $gebruikersid = $_SESSION['gebruikersid'];

    //vraag aan de database stellen, selecteer de adresgegevens van tblgebruikers waar de gebruikersid gelijk is aan de gebruikersid uit de sessie
    $gegevensgebruiker = "SELECT Straat, Nummer, Postcode, Gemeente FROM tblklanten WHERE KlantID = '".$gebruikersid."'";
    $resultsgegevensgebruiker = mysql_query($gegevensgebruiker) or die(mysql_error());

    //lus starten, rijen herhalen zolang er gebruikers in de database zitten (1 gebruiker)
    while($rowgegevensgebruiker = mysql_fetch_array($resultsgegevensgebruiker)) {

        $straat = $rowgegevensgebruiker['Straat'];
        $huisnr = $rowgegevensgebruiker['Nummer'];
        $postcode = $rowgegevensgebruiker['Postcode'];
        $gemeente = $rowgegevensgebruiker['Gemeente'];

        //de straat, huisnr ... in sessie's plaatsen zodat ze bij op de pagina afleveradreswijzigen.php opgehaald kunnen worden
        $_SESSION['straat2'] = $straat;
        $_SESSION['huisnr2'] = $huisnr;
        $_SESSION['postcode2'] = $postcode;
        $_SESSION['gemeente2'] = $gemeente;

    }
}
?>

<table width="253" height="60">
    <tr>
        <td width="136">Straat + nr:</td>
        <td width="105">
            <?php echo $straat." ".$huisnr; ?>
        </td>
    </tr>

    <tr>
        <td>Postcode en gemeente:</td>
        <td>
            <?php echo $postcode." ".$gemeente; ?>
        </td>
    </tr>
</table>

<p><a href="afleveradreswijzigen.php">Wijzig afleveradres</a></p>

<h1>Algemene voorwaarden</h1>

<form id="form1" name="form1" method="post" action="../gebruiker/verwerkingbestelling.php?action=bestellen">
    <p>
        <input type="checkbox" name="akkoord" id="akkoord"/>&nbsp; Ik ga akkoord met de <a href="algemenevoorwaarden.php" target="_blank">algemene voorwaarden</a>
    </p>
    <?php

    //als de waarde akkoort uit de URL is ingesteld een foutmelding geven (de waarde is ingesteld als de checkbox akkoord niet aangevinkt is)
    if (isset($_GET['akkoord'])) {
        echo "<p>Om een bestelling te plaatsen moet je akkoord gaan met de algemene voorwaarden</p>";
    }
    ?>

    <p><input type="submit" name="bestellen" id="bestellen" value="Bestellen" /></p>
</form>

            
        
        </div><!--end of left content-->
        
        <div class="right_content">
        	<div class="languages_box">
            <span class="red">Talen:</span>
            <a href="#" class="selected"><img src="../images/de.gif" alt="" title="" border="0" /></a>
            <a href="#"><img src="../images/fr.gif" alt="" title="" border="0" /></a>
            </div>

                
                
              <div class="cart">
                  <div class="title"><span class="title_icon"><img src="../images/cart.gif" alt="" title="" /></span>Shop</div>
                  <div class="home_cart_content">
                  <?php
                  $sessionid = session_id();
                    $querytempbesteldetail = "SELECT ProductAantal, tempBestellingDetailID FROM tbltempbestellingendetail WHERE SessionID = '".$sessionid."'";

                    $resultstempbesteldetail = mysql_query($querytempbesteldetail)
                        or die(mysql_error());

                    $numrows = mysql_num_rows($resultstempbesteldetail);
                    if ($numrows == 0) {

                        ?>
                        0 x items in winkelmandje
                  </div>
                        <?php

                    } else {

                        $aantal = 0;

                        //lus starten, rijen herhalen zolang er boeken in de database zitten
                        while($row = mysql_fetch_array($resultstempbesteldetail)) {
                            $productaantal = $row['ProductAantal'];
                            $aantal += $productaantal;

                        }

                        ?>
                    	
                        <?php echo $aantal; ?> x items in winkelmandje
                  </div>
                            
                        <?php
                    
					
					}

                    ?>
                  
                  
                  <a href="winkelwagentje.php" class="view_cart">uw bestelling</a>
              
              </div>
                       
            	
        
        
             <div class="title"><span class="title_icon"><img src="../images/bullet3.gif" alt="" title="" /></span>Ons bedrijf</div> 
             <div class="about">
             <p>
             <img src="../images/about.gif" alt="" title="" class="right" />
             Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud.
             </p>
             
             </div>
             
             <div class="right_box">
             
             	<div class="title"><span class="title_icon"><img src="../images/bullet5.gif" alt="" title="" /></span>Categories</div> 
                <?php
				//vraag aan database stellen, geef alle categorieÃ«n weer
$qrycategorie = "SELECT CategorieID, CategorieNaam FROM tblcategorie WHERE Status = 1";

$resultscategorie = mysql_query($qrycategorie)
    or die(mysql_error()); 

$numrows = mysql_num_rows($resultscategorie);

                    if ($numrows != 0) {

                        ?><ul class="list"><?php
                        while($row = mysql_fetch_array($resultscategorie)) {

                            $categorieid = $row['CategorieID'];
                            $categorienaam = $row['CategorieNaam'];
                            ?>

                            <li>
                                <a href="boekencategorieen.php?categorieid=<?php echo $categorieid; ?>">
                                    <?php echo $categorienaam ?>
                                </a>
                            </li>

                        <?php
                        }

                        ?>
                        </ul>
                        <?php

                    }
                    else {
                         echo "<p>Geen categorie&#235;n</p>";

                    }
                    ?>                
             
             </div>         
             
        
        </div><!--end of right content-->
        
        
       
       
       <div class="clear"></div>
       </div><!--end of center content-->
       
              
       <div class="footer">
       	<div class="left_footer"><a href="#"><img src="../images/logoscrivere.png" width="63" height="74" border="0" /></a></div>
        <div class="right_footer">
        <a href="../index.php">home</a>
        <a href="../onsbedrijf.php">ons bedrijf</a>
        <a href="../voorwaarden.php">voorwaarden</a>
        <a href="../privacy.php">privacy policy</a>
        <a href="../contact.php">contact</a>
       
        </div>
        
       
       </div>
    

</div>
    </body>
</html>
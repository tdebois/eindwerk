<?php 
	include_once "includes/connectie.php";
	
	session_start();
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
                        <li><a href="registreren.php">registreren</a></li>
            			<li><a href="inloggen.php">inloggen</a></li>
            
                        <?php
                    }
                    ?>
            </ul>
        </div>     
            
       </div> 
       
       
       <div class="center_content">
       	<div class="left_content">
<?php
	include_once "includes/connectie.php";

//ipadres in een variabele plaatsen
$ipadres = $_SERVER['HTTP_HOST'];

if ($ipadres == 'localhost' || $ipadres == '127.0.0.1') {
    $adres = $_SERVER['HTTP_HOST']."/Eindwerk%20webshop";
} else {
    $adres = $_SERVER['HTTP_HOST']."/~sac.D27B-01/Eindwerk%20webshop";
}

if ($_SERVER['HTTP_REFERER'] != "http://".$adres."/paginas/bevestiging.php" && $_SERVER['HTTP_REFERER'] != "http://".$adres."/paginas/bevestiging.php?akkoord=neen") {
    header('location:winkelwagentje.php');
}

$bestelid = $_SESSION['bestelid'];
$gebruikersid = $_SESSION['gebruikersid'];

$querygebruiker = "SELECT tbllanden.LandNaam, tblklanten.KlantID, tblklanten.Voornaam, tblklanten.Familienaam, tblklanten.Straat, tblklanten.Nummer,
                   tblklanten.Postcode, tblklanten.Gemeente,
                   tblbestellingen.LeveringsStraat, tblbestellingen.LeveringsNr,tblbestellingen.LeveringsPostcode, tblbestellingen.LeveringsGemeente,
                   tblbestellingen.BestellingTimestamp, tblbestellingen.BestellingID
                   FROM tbllanden
                   INNER JOIN tblklanten ON tbllanden.LandID = tblklanten.LandID
                   INNER JOIN tblbestellingen ON tblklanten.KlantID = tblbestellingen.KlantID
                   WHERE tblbestellingen.BestellingID = '".$bestelid."'";

$resultsgebruiker = mysql_query($querygebruiker)
    or die(mysql_error());

while($rowgebruiker = mysql_fetch_array($resultsgebruiker)) {

    $landnaam = $rowgebruiker['LandNaam'];

    $gebruikersid = $rowgebruiker['KlantID'];
    $voornaam = $rowgebruiker['Voornaam'];
    $familienaam = $rowgebruiker['Familienaam'];

    $straat = $rowgebruiker['Straat'];
    $huisnr = $rowgebruiker['Nummer'];
    $postcode = $rowgebruiker['Postcode'];
    $gemeente = $rowgebruiker['Gemeente'];

    $leveringsstraat = $rowgebruiker['LeveringsStraat'];
    $leveringshuisnr = $rowgebruiker['LeveringsNr'];
    $leveringspostcode = $rowgebruiker['LeveringsPostcode'];
    $leveringsgemeente = $rowgebruiker['LeveringsGemeente'];

    $datumuurbestelling = $rowgebruiker['BestellingTimestamp'];

    //de volgorde van de datum wijzigen en in een variabele plaatsen
    $datumuurbestelling = date('d-m-Y H:i:s', strtotime($datumuurbestelling));

    $bestelid = $rowgebruiker['BestellingID'];

    //het bestelnummer bestaat uit de bestelid, gebruikersid, en de datum zonder streepjes
    $bestelnummer = $bestelid.$gebruikersid;
}

?>

<h1>Bedankt voor uw bestelling, er werd een e-mail verzonden met onderstaande gegevens</h1>

<table class="tablemarge">
    <tr>
        <td class="geenpaddinglinks">
            <h2 class="titelbovenaan">Gegevens aankoper</h2>
            <?php
            echo $voornaam." ".$familienaam."<br />";
            echo $straat." ".$huisnr."<br />";
            echo $postcode." ".$gemeente."<br />";
            echo $landnaam;
            ?>
            <br /><br />
            <br /><br />
        </td>
        <td></td>
        <td>
            <h2 class="titelbovenaan">Gegevens verkoper</h2>
            Nv Scrivere <br />
            Leuterweg 31 <br />
            3630 Maasmechelen<br />
            Belgi&#235; <br /><br />
            Tel: 089 75 41 92<br />
            Emailadres: thomas.debois@gmail.com
        </td>
    </tr>
</table>

<h2>Afleveradres</h2>
<?php
echo $leveringsstraat." ".$leveringshuisnr."<br />";
echo $leveringspostcode." ".$leveringsgemeente."<br />";
?>

<h2>Bestelinformatie</h2>
<table>
    <tr>
        <td>Datum bestelling:</td>
        <td><?php echo $datumuurbestelling ?></td>
    </tr>
    <tr>
        <td>Bestelnummer:</td>
        <td><?php echo $bestelnummer ?></td>
    </tr>
</table>

<h2>Overzicht bestelde boeken</h2>

<table>
    <tr>
        <td>Titel</td>
        <td>Aantal</td>
        <td>Prijs/stuk</td>
        <td>Totaalprijs</td>
    </tr>

<?php

//$totaal op nul zetten of een undefined variable te vermijden
$totaalprijs = 0;

$querybestelling = "SELECT tblbestellingendetail.ProductPrijs, tblbestellingendetail.ProductAantal, tblproducten.ProductNaam
                    FROM tblklanten
                    INNER JOIN tblbestellingen ON tblklanten.KlantID = tblbestellingen.KlantID
                    INNER JOIN tblbestellingendetail ON tblbestellingen.BestellingID = tblbestellingendetail.BestellingID
                    INNER JOIN tblproducten ON tblbestellingendetail.ProductID = tblproducten.ProductID
                    WHERE tblbestellingen.BestellingID = '".$bestelid."'";

$resultsbestelling = mysql_query($querybestelling)
    or die(mysql_error());

while($rowbestelling = mysql_fetch_array($resultsbestelling)) {

    $boekprijs = $rowbestelling['ProductPrijs'];
    $boekaantal = $rowbestelling['ProductAantal'];
    $boektitel = $rowbestelling['ProductNaam'];

    $boektotaalprijs = $boekaantal * $boekprijs;
    $totaalprijs += $boektotaalprijs;

    ?>
    <tr>
        <td class="geenpaddinglinks"><?php echo $boektitel; ?></td>
        <td><?php echo $boekaantal; ?></td>
        <td><?php echo "&#8364; ".number_format($boekprijs, 2); ?></td>
        <td><?php echo "&#8364; ".number_format($boektotaalprijs, 2); ?></td>
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

<h2>Totaal boeken</h2>
    <table>
        <tr>
            <td>Totaal excl BTW:</td>
            <td><?php echo "&#8364; ".number_format($totaalexclbtw, 2); ?></td>
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

<h2>Totaal</h2>

<?php
$queryleveringsmethode = "SELECT tblleveringsmethodes.LeveringsmethodeNaam, tblleveringsmethodes.LeveringsKosten
                         FROM tblleveringsmethodes
                         INNER JOIN tblbestellingen ON tblleveringsmethodes.LeveringsmethodeID = tblbestellingen.LeveringsmethodeID
                         WHERE tblbestellingen.BestellingID = '".$bestelid."'";

$resultsleveringsmethode = mysql_query($queryleveringsmethode)
    or die(mysql_error());

while($rowleveringsmethode = mysql_fetch_array($resultsleveringsmethode)) {

    $leveringsmethodenaam = $rowleveringsmethode['LeveringsmethodeNaam'];
    $leveringskosten = $rowleveringsmethode['LeveringsKosten'];

}

$querybetalingsmethode = "SELECT tblbetalingsmethodes.BetalingsmethodeNaam, tblbetalingsmethodes.Kosten
                         FROM tblbetalingsmethodes
                         INNER JOIN tblbestellingen ON tblbetalingsmethodes.BetalingsmethodeID = tblbestellingen.BetalingsmethodeID
                         WHERE tblbestellingen.BestellingID = '".$bestelid."'";

$resultsbetalingsmethode = mysql_query($querybetalingsmethode)
    or die(mysql_error());

while($rowbetalingsmethode = mysql_fetch_array($resultsbetalingsmethode)) {

    $betalingsmethodenaam = $rowbetalingsmethode['BetalingsmethodeNaam'];
    $betaalkosten = $rowbetalingsmethode['Kosten'];

}

$totaal = $leveringskosten + $betaalkosten + $totaalprijs;

if ($betaalkosten == 0) {
    $betaalkosten = 'Gratis';
} else {
    $betaalkosten = "&#8364; ".$betaalkosten;
}

?>

<table>
    <tr>
        <td class="geenpaddinglinks">Levering door <?php echo $leveringsmethodenaam; ?>:</td>
        <td><?php echo "&#8364; ".$leveringskosten; ?></td>
    </tr>

    <tr>
        <td class="geenpaddinglinks">Betaalt met <?php echo $betalingsmethodenaam; ?>:</td>
        <td><?php echo $betaalkosten; ?></td>
    </tr>

    <tr>
        <td class="geenpaddinglinks"><b>Totaal:</b></td>
        <td><b><?php echo "&#8364; ".number_format($totaal, 2); ?></b></td>
    </tr>
</table>
<br />
        
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
                                <a href="index.php?page=boekencategorieen&categorieid=<?php echo $categorieid; ?>">
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
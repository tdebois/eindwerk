<?php 
	include_once "../include/connectie.php";
	
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
                            <li><a href="uitloggen.php">uitloggen</a></li>

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
//categorieid uit de URL in een variabele plaatsen
$categorieid = $_GET['categorieid'];

//vraag aan de database stellen, selecteer de categorienaam waar het categorieid gelijk is aan de categorieid uit de URL
$querycategorie = "SELECT CategorieNaam FROM tblcategorie WHERE CategorieID = '".$categorieid."'";

//uitvoeren van de query
$resultscategorie = mysql_query($querycategorie)
    or die(mysql_error());

//lus starten, rijen herhalen zolang er boeken in de database zitten
while($rowcategorie = mysql_fetch_array($resultscategorie)) {
    $categorienaam = $rowcategorie['CategorieNaam'];
}

?>
    <h1 class="titelbovenaan"><?php echo $categorienaam; ?></h1>
<?php

//vraag aan de database stellen, selecteer het boekid (geen dubbele) uit de tabel boeken
//waar de categorieid uit de tabel cateogireën gelijk is aan de categorieid uit de URL,
//de status gelijk is aan 1 en de voorraad groter is dan 0
$queryaantalboeken = "SELECT DISTINCT tblproducten.ProductID
                      FROM tblproducten
                      INNER JOIN tblprodpercategorie ON tblproducten.ProductID = tblprodpercategorie.ProductID
                      INNER JOIN tblcategorie ON tblprodpercategorie.CategorieID = tblcategorie.CategorieID
                      WHERE tblcategorie.CategorieID = '".$categorieid."' AND tblproducten.Status = 1 AND tblproducten.ProductVoorraad > 0";

//uitvoeren van de query
$resultsaantalboeken = mysql_query($queryaantalboeken)
    or die(mysql_error());

//het aantal boeken in een variabele plaatsen
$aantalboeken = mysql_num_rows($resultsaantalboeken);

if ($aantalboeken == 0) {
    echo "Deze categorie heeft geen boeken";
} else {
    //maximum aantal boeken op 1 pagina
    $maxboeken = 1;

    //het aantal paginas is het aantal boeken gedeelt door het maximum aantal boeken afgerond naar boven
    $aantalpaginas = ceil($aantalboeken / $maxboeken);

    //als het paginaid hoger is dan het aantal paginas, terugsturen naar de eerste pagina
    if (isset($_GET['paginaid']) && $_GET['paginaid'] > $aantalpaginas) {
        header('location:boekencategorieen?categorieid='.$categorieid.'&paginaid=1');

    //anders als het paginaid ingesteld is en niet leeg is de het paginaid in een variabele plaatsen
    } else if(isset($_GET['paginaid']) && !empty($_GET['paginaid'])) {
        $paginaid = $_GET['paginaid'];

    //indien het paginaid niet ingesteld is het paginaid op een zetten
    //welke situatie? wanneer je een categorienaam selecteert is het paginaid niet ingesteld
    } else {
        $paginaid = 1;
    }

    //de start van de limitering berekenen a.d.h.v. het paginaid en het maximum aantal boeken
    $beginlimitering = ($paginaid - 1) * $maxboeken;

    //vraag aan de database stellen, selecteer de gegevens van het boek met de gegevens van zijn auteurs uit de tabellen tblproducten en tblauteurs
    //waar de categorieid van de tabel tblcategorieen gelijk is aan de categorieid uit de URL,
    //de status gelijk is aan 1 en de voorraad groter is dan 0
    //sorteer oplopend op de boekids en limiteer van het begin van de query tot het maximum aantal boeken per pagina
    $queryboeken = "SELECT DISTINCT tblauteurs.AuteursID, tblauteurs.AuteursNaam, tblproducten.ProductID, tblproducten.ProductNaam, tblproducten.ProductOmschrijving,
                    tblproducten.ProductPrijs, tblproducten.ProductPromoPrijs, tblproducten.ProductVoorraad, tblcategorie.CategorieNaam
                    FROM tblauteurs
                    INNER JOIN tblproducten ON tblauteurs.AuteursID = tblproducten.AuteursID
                    INNER JOIN tblprodpercategorie ON tblproducten.ProductID = tblprodpercategorie.ProductID
                    INNER JOIN tblcategorie ON tblprodpercategorie.CategorieID = tblcategorie.CategorieID
                    WHERE tblcategorie.CategorieID = '".$categorieid."' AND tblproducten.Status = 1 AND tblproducten.ProductVoorraad > 0
                    ORDER BY tblproducten.ProductID ASC
                    LIMIT ".$beginlimitering.','. $maxboeken;

    //uitvoeren van de query
    $resultsboeken = mysql_query($queryboeken)
        or die(mysql_error());

    //lus starten, rijen herhalen zolang er boeken in de database zitten
    while($row = mysql_fetch_array($resultsboeken)) {
        $auteurid = $row['AuteursID'];
        $auteurnaam = $row['AuteursNaam'];

        $boekid = $row['ProductID'];
        $boektitel = $row['ProductNaam'];

        $boekomschrijving = $row['ProductOmschrijving'];

        //enkele de eerste 310 tekens van de omschrijving in de variabele omschrijving plaatsen
        $omschrijving = substr($boekomschrijving, 0, 310)."...";

        ///als er geen omschrijving is, 'geen omschrijving' in een variabele omschrijving plaatsen
        if ($boekomschrijving == "") {
            $omschrijving = "Geen omschrijving";
        }

        $boekprijs = $row['ProductPrijs'];
        $boekpromoprijs = $row['ProductPromoPrijs'];

        //het puntje voor het kommateken veranderen naar een komma
        $boekprijs = str_replace(".", ",", $boekprijs);
        $boekpromoprijs = str_replace(".", ",", $boekpromoprijs);

        $boekvoorraad = $row['ProductVoorraad'];

        //als de voorraad van het boek gelijk is aan 0, in de variabele boekvoorraad plaatsen dat er het boek niet op voorraad is
        if ($boekvoorraad == 0) {
            $boekvoorraad = "Niet op voorraad";

            //indien niet, in de variabele boekvoorraad plaatsen dat het boek op voorraad is
        } else {
            $boekvoorraad = "Op voorraad";
        }

        $categorienaam = $row['CategorieNaam'];
        ?>

        <div>

            <div>
                <?php

                //selecteer id en de URL van de eerste afbeelding waar het boekid gelijk is aan het boekid van de vorige query
                $queryafbeeldingen = "SELECT AfbeeldingID, AfbeeldingURL
                                              FROM tblafbeeldingen
                                              WHERE ProductID = '".$boekid."'
                                              LIMIT 1";

                //uitvoeren van de query
                $resultsafbeeldingen = mysql_query($queryafbeeldingen)
                    or die(mysql_error()); // zet je niets tussen de haakjes krijg je foutmelding uit de database

                //het aantal afbeeldingen in een variabele plaatsen
                $aantalafbeeldingen = mysql_num_rows($resultsafbeeldingen);

                //als het aantal afbeelding gelijk is aan 0 een afbeelding weergeven met de melding 'Geen afbeelding beschikbaar'
                if ($aantalafbeeldingen == 0) {
                    ?>
                    <img src="../images/geenboek.png">
                    <?php

                    //indien het boek wel een afbeelding geeft de afbeelding weergeven
                } else {

                    //lus starten, rijen herhalen zolang er afbeeldingen in de database zitten
                    while($row = mysql_fetch_array($resultsafbeeldingen)) {

                        $boekafbeeldingsurl = $row['AfbeeldingURL'];

                        //de URL van de afbeelding uitbreiden zodat de URL werkt op deze pagina
                        $boekafbeeldingsurl = str_replace("../../", "../", $boekafbeeldingsurl);

                        //code om de URL van het kleinere formaat van de afbeelding te verkrijgen

                        //de extensie van de afbeelding in een variabele plaatsen (vb .jpg
                        $extensie = substr($boekafbeeldingsurl, -4);

                        //'SS' voor de extensie plaatsen
                        $extensiemetss = 'SS'.$extensie;

                        //de extensie vervangen door de extensie met SS ervoor
                        $afbeeldingsurlklein = str_replace($extensie, $extensiemetss, $boekafbeeldingsurl);
                        ?>

                        <img src="<?php echo $afbeeldingsurlklein; ?>">

                    <?php
                    }
                }
                ?>

            </div>

            <div>
                <strong>
                    <a href="boekdetail.php?boekid=<?php echo $boekid; ?>">
                        <?php echo $boektitel; ?>
                    </a>
                </strong>
                <br />

                <p>Door
                        <?php echo $auteurnaam; ?><br />
                </p>
                <p>
                    <?php echo $omschrijving; ?>
                </p>

            </div>

            <?php

            //als er een promoprijs is, de promoprijs weergeven en de oudeprijs doorstrepen
            if ($boekpromoprijs != 0) {
                ?>
                <div>
                    <p>
                        <s><?php echo "&#8364; ".$boekprijs; ?></s><br />
                        <?php echo "&#8364; ".$boekpromoprijs; ?>
                    </p>
                </div>
            <?php

            } else {
                ?>
                <div>
                    <p>
                        <?php echo "&#8364; ".$boekprijs; ?>
                    </p>
                </div>
            <?php
            }
            ?>

            <div>

                <form id="form1" name="form1" method="post" action="../gebruiker/verwerkingwinkelwagentje.php?action=toevoegen&productid=<?php echo $boekid ?>">
                    <p><input type="submit" name="bestellen" id="bestellen" class="knop" value="Bestellen" /></p>
                </form>

                <form id="form1" name="form2" method="post" action="boekdetail.php?boekid=<?php echo $boekid ?>">
                    <p><input type="submit" name="meerinfo" id="meerinfo" class="knop" value="Meer info" /></p>
                </form>

            </div>
        </div>

        <div id="clear"></div>

    <?php
    }

    //navigatie

    //als alle boeken op 1 pagina de navigatie plaatsen
    if ($aantalpaginas != 1) {
        ?>
        <div>

            <?php
            //als de paginaid niet 1 is, eerste en vorige plaatsen
            if ($paginaid != 1) {
                ?>
                <span>
                    <a href="boekencategorieen.php?categorieid=<?php echo $categorieid; ?>&paginaid=1">
                        eerste
                    </a>
                </span>

                <span>
                    <a href="boekencategorieen.php?categorieid=<?php echo $categorieid; ?>&paginaid=<?php echo $paginaid - 1; ?>">
                        vorige
                    </a>
                </span>
                <?php

                //als het paginaid wel 1 is, eerste en vorige plaatsen zonder link (onklikbaar)
            } else {
                ?>
                <span>
                    eerste
                </span>

                <span>
                    vorige
                </span>
            <?php
            }

            //de variabele $i op een plaatsen (while lus)
            $i = 1;

            //lus starten, zolang de variabele $i kleiner of gelijk is aan het aantal pagina's knoppen weergeven
            while ($i <= $aantalpaginas) {

                //als de variabele $i gelijk is aan het paginaid, de variabele $i weergeven (onklikbaar)
                if( $i == $paginaid ){
                    ?>
                    <span>
                        <?php echo $i; ?>
                    </span>
                    <?php

                    //indien niet een link plaatsen met de variabele $i
                } else {
                    ?>
                    <span>
                        <a href="boekencategorieen.php?categorieid=<?php echo $categorieid; ?>&paginaid=<?php echo $i; ?>">
                            <?php echo $i; ?>
                        </a>
                    </span>
                <?php
                }

                //na het einde van de lus de variabel $i verhogen
                $i++;
            }

            //als het paginaid verschilt van het aantal paginas, volgende en laatste plaatsen
            if ($paginaid != $aantalpaginas) {
                ?>
                <span>
                    <a href="boekencategorieen.php?categorieid=<?php echo $categorieid; ?>&paginaid=<?php echo ($paginaid + 1); ?>">
                        volgende
                    </a>
                </span>

                <span>
                    <a href="boekencategorieen.php?categorieid=<?php echo $categorieid; ?>&paginaid=<?php echo ($aantalpaginas); ?>">
                        Laatste
                    </a>
                </span>
                <?php

                //als het paginaid gelijk is aan 1 eerste en vorige plaatsen zonder link (onklikbaar
            } else {
                ?>
                <span>
                    volgende
                </span>

                <span>
                    laatste
                </span>
            <?php
            }
            ?>

        </div>
    <?php
    }
}

?>

        
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



        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
        <script>window.jQuery || document.write('<script src="../js/vendor/jquery-1.9.1.min.js"><\/script>')</script>
        <script src="../js/plugins.js"></script>
        <script src="../js/main.js"></script>

        <!-- Google Analytics: change UA-XXXXX-X to be your site's ID. -->
        <script>
            var _gaq=[['_setAccount','UA-XXXXX-X'],['_trackPageview']];
            (function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];
            g.src='//www.google-analytics.com/ga.js';
            s.parentNode.insertBefore(g,s)}(document,'script'));
        </script>
    </body>
</html>
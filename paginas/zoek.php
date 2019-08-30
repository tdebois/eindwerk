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
        <link rel="stylesheet" href="../css/normalize.css">
        <link rel="stylesheet" href="../css/main.css">
        <link rel="stylesheet" href="../css/app.css">
		
        <script src="../js/vendor/modernizr-2.6.2.min.js"></script>
   <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>

<div class="navbar navbar-inverse navbar-fixed-top">
    <div class="container">

        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand glyphicon glyphicon-home" href="http://www.thomasdebois.be"></a>
        </div>
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="pull-right">
				<ul class="nav navbar-nav">
                <li><a href="http://www.thomasdebois.be/grafieken.pdf" target="_blank">Grafieken</a></li>
                <li class="divider-vertical"></li>
                <li><a href="http://www.thomasdebois.be/thomas-debois-portfolio.html">Portfolio</a></li>
                <li class="divider-vertical"></li>
                <li><a href="http://www.thomasdebois.be/druppel/">Drupal</a></li>
				<li class="divider-vertical"></li>
                <li><a href="http://www.thomasdebois.be/wordpress/">Wordpress</a></li>
                <li class="divider-vertical"></li>
                <li><a href="http://www.thomasdebois.be/#about">About</a></li>
                <li class="divider-vertical"></li>
                <li><a href="http://www.thomasdebois.be/thomas-debois-portfolio.html#contact">Contact</a></li>
            </ul>
        </div>
    </div>
</div>

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

//als het zoekwoord uit de URL is ingesteld het zoekwoord plaatsen in een variabele
if (isset($_GET['zoekwoord'])) {
    $zoekwoord = $_GET['zoekwoord'];

//indien niet terugsturen naar de startpagina
} else {
    header('location:../index.php');
    die();
}

?>
<h1>Zoeken</h1>
<?php

//als er geen zoekwoord is ingevuld een melding geven en de zoekopdracht niet uitvoeren
if ($zoekwoord == "") {
    echo "Gelieve een zoekopdracht in te vullen";

//als het zoekwoord minder dan drie tekens een melding geven en de zoekopdracht niet uitvoeren
} else if (strlen($zoekwoord) <= 2 ) {
    echo "Gelieve een zoekopdracht in te vullen dat minstens 3 tekens bevat";

//indien wel, de verschillende query's uitvoeren die het zoekwoord zoeken en de resultaten (boekids) opslaan in een array
} else {

    /////////////////////////////////////////////////////
    //zoeken in boektitel, boekomschrijving en boektaal//
    /////////////////////////////////////////////////////

    //vraag aan de database stellen, selecteer het boekid waar de boektitel, boekomschrijving of boektaal gelijk zijn aan het het zoekwoord en de status gelijk is aan 1
    $queryboeken = "SELECT ProductID FROM tblproducten WHERE ProductNaam LIKE '%".$zoekwoord."%' AND Status = 1 AND tblproducten.ProductVoorraad > 0
                    OR ProductOmschrijving LIKE '%".$zoekwoord."%' AND Status = 1 AND tblproducten.ProductVoorraad > 0
                    OR ProductTaal LIKE '%".$zoekwoord."%' AND Status = 1 AND tblproducten.ProductVoorraad > 0";

    //query uitvoeren
    $resultsboeken = mysql_query($queryboeken)
        or die(mysql_error()); //zet je niets tussen de haakjes krijg je foutmelding uit de database

    //lus starten, rijen herhalen zolang er boeken in de database zitten
    while($rowboeken = mysql_fetch_array($resultsboeken)) {
        $boekid = $rowboeken['ProductID'];

        //boekid telkens opslaan in een array
        $boekids[] = $boekid;
    }

    ///////////////////////////
    //zoeken in categorienaam//
    ///////////////////////////

    //vraag aan de database stellen, selecteer het boekid waar de categorienaam gelijk is aan het zoekwoord en de status gelijk is aan 1
    $queryboeken = "SELECT DISTINCT tblproducten.ProductID FROM tblproducten
                    INNER JOIN tblprodpercategorie ON tblproducten.ProductID = tblprodpercategorie.ProductID
                    INNER JOIN tblcategorie ON tblprodpercategorie.CategorieID = tblcategorie.CategorieID
                    WHERE tblcategorie.CategorieNaam LIKE '%".$zoekwoord."%' AND tblproducten.Status = 1 AND tblproducten.ProductVoorraad > 0";

    //query uitvoeren
    $resultsboeken = mysql_query($queryboeken)
        or die(mysql_error()); //zet je niets tussen de haakjes krijg je foutmelding uit de database

    //lus starten, rijen herhalen zolang er boeken in de database zitten
    while($rowboeken = mysql_fetch_array($resultsboeken)) {
        $boekid = $rowboeken['boekid'];

        //boekid telkens opslaan in een array
        $boekids[] = $boekid;
    }

    ///////////////////////////////////////////////
    //zoeken in auteurvoornaam en auteufamilienaam//
    ///////////////////////////////////////////////

    //vraag aan de database stellen, selecteer het boekid waar de auteurvoornaam of auteurfamilienaam gelijk is aan het zoekwoord en de status gelijk is aan 1
    $queryauteurs = "SELECT tblproducten.ProductID FROM tblproducten INNER JOIN tblauteurs
                    ON tblproducten.AuteursID = tblauteurs.AuteursID
                    WHERE tblauteurs.AuteursNaam LIKE '%".$zoekwoord."%' AND tblproducten.Status = 1 AND tblproducten.ProductVoorraad > 0
                    AND tblproducten.Status = 1 AND tblproducten.ProductVoorraad > 0";

    //query uitvoeren
    $resultsauteurs = mysql_query($queryauteurs)
        or die(mysql_error()); //zet je niets tussen de haakjes krijg je foutmelding uit de database

    //lus starten, rijen herhalen zolang er boeken in de database zitten
    while($rowauteurs = mysql_fetch_array($resultsauteurs)) {
        $boekid = $rowauteurs['ProductID'];

        //boekid telkens opslaan in een array
        $boekids[] = $boekid;
    }

    ////////////////////////////
    //zoeken in uitgeverijnaam//
    ////////////////////////////

    //vraag aan de database stellen, selecteer het boekid waar de uitgeverijnaam gelijk is aan het zoekwoord en de status gelijk is aan 1
    $queryuitgeverijen = "SELECT tblproducten.ProductID FROM tblproducten INNER JOIN tbluitgeverij
                          ON tblproducten.UitgeverijID = tbluitgeverij.UitgeverijID
                          WHERE tbluitgeverij.UitgeverijNaam LIKE '%".$zoekwoord."%' AND tblproducten.Status = 1 AND tblproducten.ProductVoorraad > 0";

    //query uitvoeren
    $resultsuitgeverijen = mysql_query($queryuitgeverijen)
        or die(mysql_error()); //zet je niets tussen de haakjes krijg je foutmelding uit de database

    //lus starten, rijen herhalen zolang er boeken in de database zitten
    while($rowuitgeverijen = mysql_fetch_array($resultsuitgeverijen)) {
        $boekid = $rowuitgeverijen['boekid'];
        $boekids[] = $boekid;
    }

    ////////////////////////////////////////
    //als de array is beokids is ingesteld//
    ////////////////////////////////////////

    //indien de array niet ingesteld is, een melding geven dat er geen boeken gevonden zijn
    if (!isset($boekids))  {
        echo 'Er zijn geen boeken gevonden voor het zoekwoord '.$zoekwoord;

    //als de array boekids wel ingesteld is
    } else {
        //dubbele boekids verwijderen
        $boekids = array_unique($boekids);

        ///////////////////////////////
        //aantal resultaten weergeven//
        ///////////////////////////////

        //aantal resultaten van de array in een variabele plaatsen
        $aantalresultaten = count($boekids);

        //het aantal resultaten gelijk is aan 1, weergeven in een titel dat er 1 resultaat gevonden is voor het zoekwoord
        if ($aantalresultaten == 1) {
            echo '<h2>'.$aantalresultaten.' gevonden resultaat voor '.$zoekwoord.'</h2>';

        //indien niet, weergeven in een titel dat er meerdere resultaten gevonden zijn voor het zoekwoord
        } else {
           echo '<h2>'.$aantalresultaten.' gevonden resultaten voor '.$zoekwoord.'</h2>';
        }

        ///////////////////////////////////////////////////////////
        //berekenen van het aantal pagina's en gelimiteerde array//
        ///////////////////////////////////////////////////////////

        //maximum aantal boeken op 1 pagina
        $maxboeken = 1;

        //het aantal paginas is het aantal boeken gedeelt door het maximum aantal boeken afgerond naar boven
        $aantalpaginas = ceil($aantalresultaten / $maxboeken);

        //als het paginaid hoger is dan het aantal paginas, terugsturen naar de eerste pagina
        if (isset($_GET['paginaid']) && $_GET['paginaid'] > $aantalpaginas) {
            header('location:zoek.php?zoekwoord='.$zoekwoord.'&paginaid=1');

            //anders als het paginaid ingesteld is en niet leeg is de het paginaid in een variabele plaatsen
        } else if(isset($_GET['paginaid']) && !empty($_GET['paginaid'])) {
            $paginaid = $_GET['paginaid'];

            //indien het paginaid niet ingesteld is het paginaid op een zetten
            //welke situatie? wanneer je een categorienaam selecteert is het paginaid niet ingesteld
        } else {
            $paginaid = 1;
        }

        //de start van de array berekenen a.d.h.v. het paginaid en het maximum aantal boeken
        $beginarray = ($paginaid - 1) * $maxboeken;

        //de array wordt gelimiteerd vanaf de variabele $beginarray tot het maximum aantal boeken
        $stukarray = array_slice($boekids, $beginarray, $maxboeken);

        ///////////////////////////////////////////
        //boeken weergeven van gelimiteerde array//
        ///////////////////////////////////////////

        //voor elke waarde uit de array boekids, een query opbouwen a.d.h.v. dat boekid en het boek weergeven
        foreach($stukarray as $key=>$value) {

            //selecteer de gegevens van het boek met de gegevens van zijn auteurs
            //waar het boekid gelijk is aan het boekid (value) van de array
            $queryboeken = "SELECT tblauteurs.AuteursID, tblauteurs.AuteursNaam, 
                            tblproducten.ProductID, tblproducten.ProductNaam, tblproducten.ProductOmschrijving,
                            tblproducten.ProductPrijs, tblproducten.ProductPromoPrijs, tblproducten.ProductVoorraad
                            FROM tblauteurs
                            INNER JOIN tblproducten ON tblauteurs.AuteursID = tblproducten.AuteursID
                            WHERE tblproducten.ProductID = '".$value."' AND tblproducten.Status = 1 AND tblproducten.ProductVoorraad > 0";

            //uitvoeren van de query
            $resultsboeken = mysql_query($queryboeken)
                or die(mysql_error());

            //lus starten, rijen herhalen zolang er boeken in de database zitten
            while($rowboeken = mysql_fetch_array($resultsboeken)) {
                $auteurid = $rowboeken['AuteursID'];
                $auteurnaam = $rowboeken['AuteursNaam'];

                $boekid = $rowboeken['ProductID'];
                $boektitel = $rowboeken['ProductNaam'];

                $boekomschrijving = $rowboeken['ProductOmschrijving'];

                //enkele de eerste 310 tekens van de omschrijving in de variabele omschrijving plaatsen
                $omschrijving = substr($boekomschrijving, 0, 310)."...";

                ///als er geen omschrijving is, 'geen omschrijving' in een variabele omschrijving plaatsen
                if ($boekomschrijving == "") {
                    $omschrijving = "Geen omschrijving";
                }

                $boekprijs = $rowboeken['ProductPrijs'];
                $boekpromoprijs = $rowboeken['ProductPromoPrijs'];

                //het puntje voor het kommateken veranderen naar een komma
                $boekprijs = str_replace(".", ",", $boekprijs);
                $boekpromoprijs = str_replace(".", ",", $boekpromoprijs);

                $boekvoorraad = $rowboeken['ProductVoorraad'];

                //als de voorraad van het boek gelijk is aan 0, in de variabele boekvoorraad plaatsen dat er het boek niet op voorraad is
                if ($boekvoorraad == 0) {
                    $boekvoorraad = "Niet op voorraad";

                    //indien niet, in de variabele boekvoorraad plaatsen dat het boek op voorraad is
                } else {
                    $boekvoorraad = "Op voorraad";
                }

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
                            <img src="images/geenboek.png">
                            <?php

                            //indien het boek wel een afbeelding geeft de afbeelding weergeven
                        } else {

                            //lus starten, rijen herhalen zolang er afbeeldingen in de database zitten
                            while($rowafbeeldingen = mysql_fetch_array($resultsafbeeldingen)) {

                                $boekafbeeldingsurl = $rowafbeeldingen['AfbeeldingURL'];

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

                        Door
                        <em>
                            <p><?php echo $auteurnaam; ?></p>
                        </em>
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
                                <s><span><?php echo "&#8364; ".$boekprijs; ?></span></s><br />
                                <span><?php echo "&#8364; ".$boekpromoprijs; ?></span>
                            </p>
                        </div>
                    <?php

                    } else {
                        ?>
                        <div>
                            <p>
                                <span><?php echo "&#8364; ".$boekprijs; ?></span>
                            </p>
                        </div>
                    <?php
                    }
                    ?>

                    <div>

                        <form id="form1" name="form1" method="post" action="../gebruiker/verwerkingwinkelwagentje.php?action=toevoegen&boekid=<?php echo $boekid ?>&zoekwoord=<?php echo $zoekwoord; ?>&paginaid=<?php echo $paginaid; ?>">
                            <input type="submit" name="bestellen" id="bestellen" class="knop" value="Bestellen" /><br />
                        </form>

                        <form id="form1" name="form2" method="post" action="boekdetail.php?boekid=<?php echo $boekid ?>">
                            <input type="submit" name="meerinfo" id="meerinfo" class="knop" value="Meer info" /><br />
                        </form>

                    </div>
                </div>

                <div id="clear"></div>

            <?php
            }
        }

        /////////////
        //navigatie//
        /////////////

        //als alle boeken op 1 pagina de navigatie plaatsen
        if ($aantalpaginas != 1) {
            ?>
            <div id="navigatie">

                <?php
                //als de paginaid niet 1 is, eerste en vorige plaatsen
                if ($paginaid != 1) {
                    ?>
                    <span class="navigatieknop">
                        <a href="zoek.php?zoekwoord=<?php echo $zoekwoord; ?>&paginaid=1">
                            eerste
                        </a>
                    </span>

                    <span>
                        <a href="zoek.php?zoekwoord=<?php echo $zoekwoord; ?>&paginaid=<?php echo $paginaid - 1; ?>">
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
                            <a href="zoek.php?zoekwoord=<?php echo $zoekwoord; ?>&paginaid=<?php echo $i; ?>">
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
                        <a href="zoek.php?zoekwoord=<?php echo $zoekwoord; ?>&paginaid=<?php echo ($paginaid + 1); ?>">
                            volgende
                        </a>
                    </span>

                    <span>
                        <a href="zoek.php?zoekwoord=<?php echo $zoekwoord; ?>&paginaid=<?php echo ($aantalpaginas); ?>">
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

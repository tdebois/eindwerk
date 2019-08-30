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
    if(isset($_GET['boekid'])){
		$boekid = $_GET['boekid'];
	}
	else{
		header('location:../index.php');
		die();
	}
    $queryboek = "SELECT tblauteurs.AuteursNaam,
                    tbluitgeverij.UitgeverijNaam,
                    tblproducten.ProductNaam, tblproducten.ProductOmschrijving,tblproducten.ProductPrijs, tblproducten.ProductPromoPrijs,
                    tblproducten.ProductVoorraad, tblproducten.ProductISBN, tblproducten.ProductPublicatie,
                    tblproducten.ProductTaal, tblproducten.ProductAantalpaginas
                    FROM tblproducten
                    INNER JOIN tblauteurs ON tblproducten.AuteursID = tblauteurs.AuteursID
                    INNER JOIN tbluitgeverij ON tblproducten.UitgeverijID = tbluitgeverij.UitgeverijID
                    WHERE tblproducten.ProductID = '".$boekid."'";

    $resultsboek = mysql_query($queryboek)
        or die(mysql_error());

    while($row = mysql_fetch_array($resultsboek)) {
        $auteurnaam = $row['AuteursNaam'];
        
		$uitgeverijnaam = $row['UitgeverijNaam'];

        $boektitel = $row['ProductNaam'];
        $boekomschrijving = $row['ProductOmschrijving'];

        if ($boekomschrijving == "") {
            $boekomschrijving = "/";
        }

        $boekprijs = $row['ProductPrijs'];
        $boekpromoprijs = $row['ProductPromoPrijs'];

        //euroteken na de prijs en promoprijs plaatsen
        $boekprijs = "&#8364; ".str_replace(".", ",", $boekprijs);
        $boekpromoprijs = "&#8364; ".str_replace(".", ",", $boekpromoprijs);

        $boekvoorraad = $row['ProductVoorraad'];

        //als de voorraad gelijk is aan nul krijgt de variabele voorraad de waarde 'niet op voorraad'
        if ($boekvoorraad == 0) {
            $boekvoorraad = "Niet op voorraad";
        } else {
            $boekvoorraad = "Op voorraad";
        }

        $boekisbn = $row['ProductISBN'];

        //streepjes tussen de verschillende onderdelen van het isbn nummer toevoegen
        $eancode = substr($boekisbn, 0, 3);
        $taalgebied = substr($boekisbn ,3 , 2);
        $uitgeverijisbn = substr($boekisbn, 5, 3);
        $uitgave = substr($boekisbn, 8, 4);
        $controlecijfer = substr($boekisbn, 12, 1);
        $isbn = $eancode."-".$taalgebied."-".$uitgeverijisbn."-".$uitgave."-".$controlecijfer;

        //als het boek geen ISBN-code heeft een schuine streep plaatsen
        if ($boekisbn == "") {
            $boekisbn = "/";
        }

        $boekpublicatiedatum = $row['ProductPublicatie'];

        //volgorde van de publicatiedatum wijzigen
        $boekpublicatiedatum = date('d-m-Y', strtotime($boekpublicatiedatum));

        //als het boek geen publicatiedatum heeft een schuine streep plaatsen
        if ($boekpublicatiedatum == '01-01-1970') {
            $boekpublicatiedatum = "/";
        }

        //als het boek geen taal heeft een schuine streep plaatsen
        $boektaal = $row['ProductTaal'];
        if ($boektaal == "") {
            $boektaal = "/";
        }

        //als het aantal pagina's van het boek niet wordt opgenomen een schuine streep plaatsen
        $boekaantalpaginas = $row['ProductAantalpaginas'];
        if ($boekaantalpaginas == 0) {
            $boekaantalpaginas = "/";
        }
    }
    ?>

    <h1 class="titelbovenaan"><?php echo $boektitel; ?></h1>

    <table width="470" height="297" class="boekdetailtable">
        <tr>
            <td width="156" rowspan="9">
                <?php
                $queryafbeeldingen = "SELECT AfbeeldingID, AfbeeldingURL FROM tblafbeeldingen WHERE ProductID = '".$boekid."' LIMIT 1";

                $resultsafbeeldingen = mysql_query($queryafbeeldingen)
                or die(mysql_error()); 
				
                $aantalafbeeldingen = mysql_num_rows($resultsafbeeldingen);

                if ($aantalafbeeldingen == 0) {
                    ?>
                    <img src="../images/geenboek.png">
                    <?php

                } else {
                    ?>

                        <div>
                            <?php

                            //lus starten, rijen herhalen zolang er afbeeldingen in de database zitten
					while($row = mysql_fetch_array($resultsafbeeldingen)) {

                    $afbeeldingsurl = $row['AfbeeldingURL'];

                    //de URL van de afbeelding uitbreiden zodat de URL werkt op deze pagina
                    $afbeeldingsurl = str_replace("../../", "../", $afbeeldingsurl);

                    //code om de URL van het kleinere formaat van de afbeelding te verkrijgen

                    //de extensie van de afbeelding in een variabele plaatsen (vb .jpg
                    $extensie = substr($afbeeldingsurl, -4);

                    //'SS' voor de extensie plaatsen
                    $extensiemetss = 'SS'.$extensie;

                    //de extensie vervangen door de extensie met SS ervoor
                    $afbeeldingsurlklein = str_replace($extensie, $extensiemetss, $afbeeldingsurl);


                    ?>
                <img src="<?php echo $afbeeldingsurlklein; ?>">

                            <?php
                            }

                            ?>

                        </div>

                <?php
                }
                ?>


            </td>

            <td width="144">Naam:</td>
            <td width="143"><?php echo $boektitel; ?></td>
        </tr>

        <tr>
            <td>Auteur:</td>
            <td><?php echo $auteurnaam; ?></td>
        </tr>

        <tr>
            <td>Uitgeverij:</td>
            <td><?php echo $uitgeverijnaam; ?></td>
        </tr>

        <tr>
            <td>ISBN:</td>
            <td><?php echo $boekisbn; ?></td>
        </tr>

        <tr>
            <td>Publicatiedatum:</td>
            <td><?php echo $boekpublicatiedatum; ?></td>
        </tr>

        <tr>
            <td>Taal:</td>
            <td><?php echo $boektaal; ?></td>
        </tr>

        <tr>
            <td>Aantal pagina's:</td>
            <td><?php echo $boekaantalpaginas; ?></td>
        </tr>

        <tr>
            <td>Prijs:</td>
            <td>
                <?php
                //als het boek in promo de prijs weergeven met daarnaast tussen haakjes de promoprijs gedoorstreept
                if ($boekpromoprijs != 0) {
                    ?>
                        <s><?php echo $boekpromoprijs." "; ?></s> <?php echo "(".$boekprijs.")"; ?>
                    <?php
                } else {
                    echo $boekprijs;
                }
                ?>
            </td>
        </tr>
    </table>
    <br />
    <?php
    $querycategorieen = "SELECT DISTINCT tblcategorie.CategorieNaam FROM tblcategorie
                         INNER JOIN tblprodpercategorie ON tblcategorie.CategorieID = tblprodpercategorie.CategorieID
                         INNER JOIN tblproducten ON tblprodpercategorie.ProductID = tblproducten.ProductID
                         WHERE tblproducten.ProductID = '".$boekid."'";

    $resultscategorieen = mysql_query($querycategorieen)
        or die(mysql_error());

    $aantalcategorieen = mysql_num_rows($resultscategorieen);

    if ($aantalcategorieen == 1) {
        ?>
        <b>Categorie van het boek: </b>
        <?php

        while($rowcategorieen = mysql_fetch_array($resultscategorieen)) {
            $categorienaam = $rowcategorieen['CategorieNaam'];
            ?>
          <p><?php echo $categorienaam; ?></p>
            <?php
        }

    } else {
        ?>
            <b>Categorie&#235;n van het boek:</b>
        <ul>
        <?php
        while($rowcategorieen = mysql_fetch_array($resultscategorieen)) {
            $categorienaam = $rowcategorieen['CategorieNaam'];
            ?>
            <li>
                <?php echo $categorienaam; ?>
            </li>

        <?php
        }
        ?></ul><?php
    }
    ?>

    <b>Omschrijving:</b>

    <p>
        <?php echo $boekomschrijving ?>
    </p

   ><p>
        <form id="form1" name="form1" method="post" action="../gebruiker/verwerkingwinkelwagentje.php?action=toevoegen&productid=<?php echo $boekid ?>">
            <input type="submit" name="bestellen" id="bestellen" class="knop" value="Boek bestellen" />
        </form>
   </p>
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

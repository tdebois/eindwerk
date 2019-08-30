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
            			<li  class="selected"><a href="inloggen.php">inloggen</a></li>
            
                        <?php
                    }
                    ?>
            </ul>
        </div>     
            
       </div> 
       
       
       <div class="center_content">
       	<div class="left_content">
		<?php

//na het inloggen kan er niet meer op deze pagina gesurft worden
if (isset($_SESSION['wachtwoord']) && isset($_SESSION['emailadres'])) {
    header("location:index.php");
}

//als de session emailadres nog niet is ingesteld, hem instellen
//om foutmelding te vermijden bij het tekstveld emailadres te vermijden bij de eerste keer laden van het formulier
if (!isset($_SESSION['emailadres'])) {
    $_SESSION['emailadres'] = "";
}

//als er gesurft wordt naar deze pagina na het registreren, de sessie eerstepagina altijd instellen op index.php (na registratie --> inlogpagina, na inloggen --> index.php
//zodat er na het registreren en inloggen naar index.php wordt gesurft
if (isset($_GET['registration']) AND $_GET['registration'] == 'succes') {
    $_SESSION['eerstepagina'] = '../index.php';
} else {

    //conclusie van onderstaande code: als een wachtwoord verkeerd is ingevoerd (error nietingevoerdlogin of passwoordverkeerd)
    //de pagina voor deze pagina niet in de sessie eerst pagina plaatsen
    //--> vermijden dat er na het 1 of meerdere keren verkeerd invoeren van de login of wachtwoord en daarna juist invoeren
    //terug wordt gezonden naar de inlogpagina

    //als er een error is en de error komt van de pagina paginatoegang (niet logincheck) in de sessie eerste pagina de pagina voor deze pagina onthouden
    if (isset($_GET['error'])) {
        if ($_GET['error'] == 'nietingevoerd' || $_GET['error'] == 'passverkeerd') {
            //als er direct naar deze pagina wordt gesurft is de eerste pagina index.php (browser opgestart direct naar deze pagina)
            if (!isset($_SERVER['HTTP_REFERER'])) {
                $_SESSION['eerstepagina'] = '../index.php';

            } else {
                $_SESSION['eerstepagina'] = $_SERVER['HTTP_REFERER'];
            }
        }

    //als er geen error is in de sessie eerste pagina de pagina voor deze pagina onthouden
    } else {
        //als er direct naar deze pagina wordt gesurft is de eerste pagina index.php (browser opgestart direct naar deze pagina)
        if (!isset($_SERVER['HTTP_REFERER'])) {
            $_SESSION['eerstepagina'] = '../index.php';

        } else {
            $_SESSION['eerstepagina'] = $_SERVER['HTTP_REFERER'];
        }
    }
}

?>

<h1 class="titelbovenaan">Inloggen</h1>

    <form id="form" name="form" method="post" action="../gebruiker/logincheck.php">

            <p><label for="emailadres">Emailadres</label>
            <input type="text" name="emailadres" id="emailadres" value="<?php echo $_SESSION['emailadres'];?>">
            <br>
            <br />

            <label for="Wachtwoord">Wachtwoord</label>
            <input type="password" name="wachtwoord" id="wachtwoord">
</p>
            <p>
                <input type="submit" name="inloggen" id="inloggen" value="Inloggen">
            </p>
    </form>


    <p><a href="registreren.php">Registreer nu!</a></p>
    <p><a class="inloggenlink" href="wachtwoordvergeten.php">Wachtwoord vergeten?</a></p>

<?php
//als de waarde uit de URL ingesteld en gelijk is aan 'nietingevoerd' een foutmelding geven
if (isset($_GET['error']) && $_GET['error'] == 'nietingevoerd') {
    echo 'Gelieve eerst in te loggen'.'<br/><br/>';
}

//als de waarde uit de URL ingesteld en gelijk is aan 'passverkeerd' een foutmelding geven
if (isset($_GET['error']) && $_GET['error'] == 'passverkeerd') {
    echo 'Gelieve eerst in te loggen met een correct emailadres en wachtwoord'.'<br/><br/>';
}

if (isset($_GET['error']) && $_GET['error'] == 'nietingevoerdlogin') {
    echo 'Gelieve uw emailadres en wachtwoord in te vullen'.'<br/><br/>';
}

if (isset($_GET['error']) && $_GET['error'] == 'passverkeerdlogin') {
    echo 'Gelieve uw correcte emailadres en wachtwoord in te vullen'.'<br/><br/>';
}

//als er op uitloggen geklikt wordt is de waarde 'vorige' uit de URL ingesteld en wordt er een melding weergegeven
if (isset($_GET['vorige'])) {
    echo 'Succesvol uitgelogd'.'<br/><br/>';
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

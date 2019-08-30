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
                        <li  class="selected"><a href="registreren.php">registreren</a></li>
            			<li><a href="inloggen.php">inloggen</a></li>
            
                        <?php
                    }
                    ?>
            </ul>
        </div>     
            
       </div> 
       
       
       <div class="center_content">
       	<div class="left_content">
		<h1>Schrijf je in.</h1>

<?php
//na het inloggen kan er niet meer op deze pagina gesurft worden
if (isset($_SESSION['wachtwoord']) && isset($_SESSION['emailadres'])) {
    header("location:index.php");
}

if (!isset($_SESSION['voornaam'])) {
$_SESSION['voornaam'] = "";
}

if (!isset($_SESSION['familienaam'])) {
$_SESSION['familienaam'] = "";
}

if (!isset($_SESSION['straat'])) {
$_SESSION['straat'] = "";
}

if (!isset($_SESSION['huisnr'])) {
$_SESSION['huisnr'] = "";
}

if (!isset($_SESSION['huisnr'])) {
$_SESSION['huisnr'] = "";
}

if (!isset($_SESSION['postcode'])) {
$_SESSION['postcode'] = "";
}

if (!isset($_SESSION['gemeente'])) {
$_SESSION['gemeente'] = "";
}

if (!isset($_SESSION['telefoon'])) {
$_SESSION['telefoon'] = "";
}

if (!isset($_SESSION['emailadres'])) {
$_SESSION['emailadres'] = "";
}

if (!isset($_SESSION['land'])) {
$_SESSION['land'] = "";
}

if (!isset($_SESSION['bedrijfsnaam'])) {
$_SESSION['bedrijfsnaam'] = "";
}

if (!isset($_SESSION['soortorganisatie'])) {
$_SESSION['soortorganisatie'] = "";
}

if (!isset($_SESSION['btwnummer'])) {
$_SESSION['btwnummer'] = "";
}

if (!isset($_SESSION['website'])) {
$_SESSION['website'] = "";
}

?>

<form id="form" name="form" class="registratie" method="post" action="../gebruiker/gebruikertoevoegen.php">
    <p><label for="naam">Naam*</label>
    <input type="text" name="voornaam" id="voornaam" maxlength="30" value="<?php echo $_SESSION['voornaam'];?>"/>
    <input type="text" name="familienaam" id="familienaam" maxlength="30" value="<?php echo $_SESSION['familienaam'];?>"/>
    <br>
    <br />

    <label for="adres">Adres*</label>
    <input type="text" name="straat" id="straat" placeholder="Straat" maxlength="40" value="<?php echo $_SESSION['straat'];?>" />
    <input type="text" name="huisnr" id="huisnr" placeholder="Huisnummer" maxlength="4" value="<?php echo $_SESSION['huisnr'];?>" />
    <br />

    <label for="postcodegemeente"></label>
     	<input type="text" name="postcode" id="postcode" placeholder="Postcode" maxlength="6" value="<?php echo $_SESSION['postcode'];?>" /> 
        <input type="text" name="gemeente" id="gemeente" placeholder="Gemeente" maxlength="40" value="<?php echo $_SESSION['gemeente'];?>" />
        <br>
        <br />

    <label for="telefoon">Telefoon*</label>
    <input type="text" name="telefoon" id="telefoon" maxlength="14" value="<?php echo $_SESSION['telefoon'];?>"/>
    <br>
    <br />

    <script>
        $('#telefoon').keypress( function(e) {
            //als de letter geen cijfer is niet typen
            if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
                return false;
            }
        });
    </script>

    <label for="emailadres">Emailadres*</label>
    <input type="text" name="emailadres" id="emailadres" maxlength="50" value="<?php echo $_SESSION['emailadres'];?>" />
    <br>
    <br />

    <label class="formklein" for="land">Land</label>
    <select name="land" id="land">
        <?php

        $selectedland = $_SESSION['land'];

        $queryland = "SELECT * FROM tbllanden WHERE Status = 1 ORDER BY LandNaam";
        $resultsland = mysql_query($queryland) or die(mysql_error());
        while($rowland = mysql_fetch_array($resultsland))
        {
            $landid = $rowland['LandID'];
            $landnaam = $rowland['LandNaam'];

            if ($selectedland == $landid) {
                $selected = "selected";
            }
            else {
                $selected = "";
            }
            ?>
            <option value="<?php echo $landid; ?>" <?php echo $selected;?> ><?php echo $landnaam; ?></option>

            <?php
            //while lus sluiten
        }
        ?>
    </select>
    <br>
<br />

    <?php
        $selectedorganisatie = $_SESSION['soortorganisatie'];
    ?>
    <label for="soortorganisatie">Soort organisatie*</label>
    <select name="soortorganisatie" id="soortorganisatie">
        <option value="Particulier" <?php if($selectedorganisatie == "Particulier") echo 'selected'; ?>>Particulier</option>
        <option value="Venootschap" <?php if($selectedorganisatie == "Venootschap") echo 'selected'; ?>>Venootschap</option>
        <option value="VZW" <?php if($selectedorganisatie == "VZW") echo 'selected'; ?>>VZW</option>
        <option value="internationale VZW" <?php if($selectedorganisatie == "internationale VZW") echo 'selected'; ?>>Internationale VZW</option>
        <option value="Stichting" <?php if($selectedorganisatie == "Stichting") echo 'selected'; ?>>Stichting</option>
        <option value="Vereniging" <?php if($selectedorganisatie == "Vereniging") echo 'selected'; ?>>Vereninging</option>
        <option value="Anders" <?php if($selectedorganisatie == "Anders") echo 'selected'; ?>>Anders</option>
    </select>
    <br>
    <br />

    <label for="bedrijfsnaam">Bedrijfsnaam</label>
    <input type="text" name="bedrijfsnaam" id="bedrijfsnaam" maxlength="50" class="textfieldgroot" value="<?php echo $_SESSION['bedrijfsnaam'];?>" />
    <br>
    <br />

    <label for="btwnummer">BTW-nummer</label>
    <input type="text" name="btwnummer" id="btwnummer" maxlength="12" class="textfieldgroot" value="<?php echo $_SESSION['btwnummer'];?>" />
    <br>
<br />

    <label for="website">Website</label>
    <input type="text" name="website" id="website" maxlength="50" value="<?php echo $_SESSION['website'];?>" />
    <br>
    <br />

    <label for="wachtwoord">Wachtwoord*</label>
    <input type="password" name="wachtwoord" id="wachtwoord" maxlength="20" class="textfieldgroot" />
    <br>
    <br />

    <label for="wachtwoord2">Wachtwoord herhalen*</label>
    <input type="password" name="wachtwoord2" id="wachtwoord2" maxlength="20" class="textfieldgroot" /></p>

    <p>
        <input type="submit" name="bevestig" id="bevestig" value="Schrijf je in" />
    </p>

    <?php
        if (isset($_SESSION['error']['voornaam']) ) {
            echo $_SESSION['error']['voornaam']."<br>";
        }

        if (isset($_SESSION['error']['familienaam']) ) {
            echo $_SESSION['error']['familienaam']."<br>";
        }

        if (isset($_SESSION['error']['straat']) ) {
            echo $_SESSION['error']['straat']."<br>";
        }

        if (isset($_SESSION['error']['huisnr']) ) {
            echo $_SESSION['error']['huisnr']."<br>";
        }

        if (isset($_SESSION['error']['postcode']) ) {
            echo $_SESSION['error']['postcode']."<br>";
        }

        if (isset($_SESSION['error']['gemeente']) ) {
            echo $_SESSION['error']['gemeente']."<br>";
        }

        if (isset($_SESSION['error']['telefoon']) ) {
            echo $_SESSION['error']['telefoon']."<br>";
        }

        if (isset($_SESSION['error']['emailadres']) ) {
            echo $_SESSION['error']['emailadres']."<br>";
        }

        if (isset($_SESSION['error']['land']) ) {
            echo $_SESSION['error']['land']."<br>";
        }

        if (isset($_SESSION['error']['website']) ) {
            echo $_SESSION['error']['website']."<br>";
        }

        if (isset($_SESSION['error']['wachtwoorden']) ) {
            echo $_SESSION['error']['wachtwoorden']."<br>";
        }
    ?>

    <br /><br />

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
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
<h1>Winkelwagentje</h1>
<?php

//sessionid in een variabele plaatsen
$sessionid = session_id();

//de totaalprijs op 0 zetten om een undefined variabele te voorkomen
//later in de code $totaalprijs += $boektotaalprijs --> mogelijkheid dat de totaalprijs nog niet gedefineerd is
$totaalprijs = 0;

//vraag aan de database stellen, selecteer het detail van de bestelling (met gegevens boek)
//waar de sessionid van tbltempbesteldetail gelijk is aan de opgehaalde sessions id
$querytempbesteldetail = "SELECT tblproducten.ProductID, tblproducten.ProductNaam, tblproducten.ProductVoorraad, tbltempbestellingendetail.ProductAantal, tbltempbestellingendetail.ProductPrijs FROM tblproducten
                          INNER JOIN tbltempbestellingendetail ON tblproducten.ProductID = tbltempbestellingendetail.ProductID
                          WHERE tbltempbestellingendetail.SessionID = '".$sessionid."'";

//query uitvoeren
$resultstempbesteldetail = mysql_query($querytempbesteldetail)
    or die(mysql_error()); //zet je niets tussen de haakjes krijg je foutmelding uit de database

//het aantal rijen van de query in een variabele plaatsen
$numrows = mysql_num_rows($resultstempbesteldetail);

//als er geen rijen zijn, een melding geven dat het winkelwagentje leeg is en geen code meer uitvoeren
if ($numrows == 0) {
    echo 'Uw winkelwagentje is leeg';
} else {
    ?>
    <table width="476" height="179" border="1">
        <tr align="left">
            <th></th>
            <th></th>
            <th>Artikelomschrijving</th>
            <th colspan="2">Aantal</th>
            <th>Prijs/stuk</th>
            <th>Totaalprijs</th>
        </tr>
        <?php

        //lus starten, rijen herhalen zolang er details van de bestelling in de database zitten
        while($row = mysql_fetch_array($resultstempbesteldetail)) {

            $productid = $row['ProductID'];
            $productnaam = $row['ProductNaam'];
            $productvoorraad = $row['ProductVoorraad'];
            $productaantal = $row['ProductAantal'];
            $productprijs = $row['ProductPrijs'];

            //de totaalprijs van het soort boek is de prijs van het boek * het aantal
            $producttotaalprijs = $productprijs * $productaantal;

            //de totaalprijs per soort boek wordt telkens opgeteld bij de totaalprijs
            $totaalprijs += $producttotaalprijs;

                //als er geen voorraad is, in een variabele plaatsen dat er geen voorraad is
                if ($productvoorraad == 0) {
                    $voorraad = 'Niet op voorraad';

                //indien wel, in een variabele plaatsen dat er wel een voorraad is
                } else {
                    $voorraad = 'Voorraad';
                }
                ?>

                <tr>
                    <td>
                        <a href="../gebruiker/verwerkingwinkelwagentje.php?action=delete&productid=<?php echo $productid; ?>"  onClick="return confirm('Ben je zeker dat je dit boek wilt verwijderen?')" >
                            <img src="../images/delete.png" width="12" height="12" title="Item verwijderen">
                        </a>
                    </td>

                    <td class="detailicoon">
                        <a href="boekdetail.php?boekid=<?php echo $productid ?>">
                            <img src="../images/info.png" width="12" height="12" title="Item verwijderen">
                        </a>
                    </td>

                    <td><?php echo $productnaam; ?>
                    </td>

                    <td><?php echo $productaantal; ?></td>
                    <td>
                        <a href="../gebruiker/verwerkingwinkelwagentje.php?action=verhoog&productid=<?php echo $productid; ?>">
                            <img src="../images/toevoegen.png" width="12" height="12" title="Verhogen">
                        </a>

                        <br />

                        <a href="../gebruiker/verwerkingwinkelwagentje.php?action=verlaag&productid=<?php echo $productid; ?>">
                            <img src="../images/delete.png" width="12" height="12" title="Verlagen">
                        </a>
                    </td>
                    <td><?php echo "&#8364; ".number_format($productprijs, 2); ?></td>
                    <td><?php echo "&#8364; ".number_format($producttotaalprijs, 2); ?></td>
                </tr>

        <?php
        }

        //de prijs exclusief BTW berekenen
        $totaalexcbtw = ($totaalprijs / 108) * 100;

        //de BTW berekenen
        $btw = $totaalprijs - $totaalexcbtw;
        ?>
        <tr>
            <td colspan="7"></td>
        </tr>
        <tr>
            <td colspan="2"></td>
            <td colspan="4">Totaal exc BTW:</td>
            <td>
                <?php echo "&#8364; ".number_format($totaalexcbtw, 2); ?>
            </td>
        </tr>

        <tr>
            <td colspan="2"></td>
            <td colspan="4" class="winkelwagentjerechts">BTW: </td>
            <td>
                <?php echo "&#8364; ".number_format($btw, 2); ?>
            </td>
        </tr>

        <tr>
            <td colspan="2"></td>
            <td colspan="4">Totaal incl BTW: </td>
            <td>
                <?php echo "&#8364; ".number_format($totaalprijs, 2); ?>
            </td>
        </tr>
    </table>
    <br />

    <h1>Kies uw betaling en leveringsmethode</h1>

    <form id="form1" name="form1" method="post" action="bevestiging.php">

        <p><label class="betalingenlevering" for="leveringsmethode">Leveringsmethode</label>
        <select name="leveringsmethode" id="leveringsmethode"></p>
            <?php

            //vraag aan de database stellen, selecteer alle gegevens van tblleveringsmethodes, order op de naam van de leveringsmethode
            $queryleveringsmethodes = "SELECT * FROM tblleveringsmethodes ORDER BY LeveringsmethodeNaam";

            //query uitvoeren
            $resultsleveringsmethodes = mysql_query($queryleveringsmethodes)
                or die(mysql_error()); //zet je niets tussen de haakjes krijg je foutmelding uit de database

            //lus starten, rijen herhalen er leveringsmethodes in de database zitten
            while($row = mysql_fetch_array($resultsleveringsmethodes))
            {
                $leveringsmethodeid = $row['LeveringsmethodeID'];
                $leveringsmethodenaam = $row['LeveringsmethodeNaam'];
                $leveringskosten = $row['Kosten'];

                //naast de naam van de leveringsmethode de leveringskosten plaatsen met een euroteken
                $leveringsmethode = $leveringsmethodenaam." - &#8364; ".$leveringskosten;

                ?>
                <option value="<?php echo $leveringsmethodeid; ?>"><?php echo $leveringsmethode; ?></option>

                <?php
                //while lus sluiten
            }
            ?>
        </select>
        <br />

        <p><label class="betalingenlevering" for="betalingsmethode">Betalingsmethode</label>
        <select name="betalingsmethode" id="betalingsmethode"></p>
            <?php

            //vraag aan de database stellen, selecteer alle gegevens van tblbetalingsmethodes, order op de naam van de betalingsmethode
            $querybetalingsmethodes = "SELECT * FROM tblbetalingsmethodes ORDER BY BetalingsmethodeNaam";

            //query uitvoeren
            $resultsbetalingsmethodes = mysql_query($querybetalingsmethodes) or die(mysql_error());

            //lus starten, rijen herhalen er betalingsmethodes in de database zitten
            while($rowbetalingsmethodes = mysql_fetch_array($resultsbetalingsmethodes))
            {
                $betalingsmethodeid = $rowbetalingsmethodes['BetalingsmethodeID'];
                $betalingsmethodenaam = $rowbetalingsmethodes['BetalingsmethodeNaam'];
                $betaalkosten = $rowbetalingsmethodes['Kosten'];

                //als de betaling gratis is enkel de naam van de betalingmethode weergeven
                if ($betaalkosten == 0) {
                    $betalingsmethode = $betalingsmethodenaam;

                //indien niet naast de naam van de betalingsmethode, de betaalkosten plaatsen met een euroteken
                } else {
                    $betalingsmethode = $betalingsmethodenaam." - &#8364; ".$betaalkosten;
                }

                ?>
                <option value="<?php echo $betalingsmethodeid; ?>"><?php echo $betalingsmethode; ?></option>

                <?php
                //while lus sluiten
            }
            ?>
        </select>
        <br />

        <p>
            <input type="submit" name="afrekenen" id="afrekenen" class="knop" value="Afrekenen" />
        </p>


    </form>
    <?php
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
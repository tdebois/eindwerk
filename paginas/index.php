<?php
if (!isset($connect)) {
    // do nothing
	header('location:../index.php');
	die();
}

///////////////
//in promotie//
///////////////

$qryproducten = "SELECT DISTINCT tblauteurs.AuteursID, tblauteurs.AuteursNaam, 
    tblproducten.ProductID, tblproducten.ProductNaam, tblproducten.ProductOmschrijving,
    tblproducten.ProductPrijs, tblproducten.ProductPromoPrijs, tblproducten.ProductVoorraad
    FROM tblauteurs
    INNER JOIN tblproducten ON tblauteurs.AuteursID = tblproducten.AuteursID
    INNER JOIN tblprodpercategorie ON tblproducten.ProductID = tblprodpercategorie.ProductID
    INNER JOIN tblcategorie ON tblprodpercategorie.CategorieID = tblcategorie.CategorieID
    WHERE tblproducten.ProductPromoPrijs != 0 AND tblproducten.Status = 1 AND tblproducten.ProductVoorraad > 0
    ORDER BY RAND()
    LIMIT 2";

//uitvoeren van de query
$resultsboeken = mysql_query($qryproducten)
    or die(mysql_error());

//het aantal rijen van de query
$numrows = mysql_num_rows($resultsboeken);

//lus starten
while($row = mysql_fetch_array($resultsboeken)) {
    $auteurid = $row['AuteursID'];
    $auteurnaam = $row['AuteursNaam'];

    $productid = $row['ProductID'];
    $productnaam = $row['ProductNaam'];

    $productomschrijving = $row['ProductOmschrijving'];

    if ($productomschrijving == "") {
        $productomschrijving = "Geen omschrijving";
    } else {
        //de eerste 260 tekens in var plaatsen
        $productomschrijving = substr($productomschrijving, 0, 260)."...";
    }

    $productprijs = $row['ProductPrijs'];
    $productpromoprijs = $row['ProductPromoPrijs'];

    $productprijs = str_replace(".", ",", $productprijs);
    $productpromoprijs = str_replace(".", ",", $productpromoprijs);

    $productvoorraad = $row['ProductVoorraad'];

    if ($productvoorraad == 0) {
        $productvoorraad = "Niet op voorraad";
    } else {
        $productvoorraad = "Op voorraad";
    }

    ?>
    </h1>
    <div class="feat_prod_box">
    <div class="prod_img">
        <?php

            //selecteer id en de URL van de eerste afbeelding waar het boekid gelijk is aan het boekid van de vorige query
            $queryafbeeldingen = "SELECT AfbeeldingID, AfbeeldingURL
                                      FROM tblafbeeldingen
                                      WHERE ProductID = '".$productid."'
                                      LIMIT 1";

            //uitvoeren van de query
            $resultsafbeeldingen = mysql_query($queryafbeeldingen)
                or die(mysql_error()); 

                 ?>
               
      <?php

                //lus starten, rijen herhalen zolang er afbeeldingen in de database zitten
                while($row = mysql_fetch_array($resultsafbeeldingen)) {

                    $afbeeldingsurl = $row['AfbeeldingURL'];

                    //de URL van de afbeelding uitbreiden zodat de URL werkt op deze pagina
                    $afbeeldingsurl = str_replace("../../", "", $afbeeldingsurl);

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

<div class="prod_det_box">
                    <div class="box_top"></div>
                    <div class="box_center">
                    <div class="prod_title">
                    <a href="paginas/boekdetail.php?boekid=<?php echo $productid; ?>">
                        <?php echo $productnaam; ?>
                    </a>
                    </div>
       <p class="details">
                <?php echo $productomschrijving; ?><br /></p>
                <a href="paginas/boekdetail.php?boekid=<?php echo $productid ?>" class="more">- lees meer -</a>
       <div class="clear"></div>
                    </div>
                    
                    <div class="box_bottom"></div>
                    <h5><s><?php echo "&#8364; ".$productprijs; ?></s>&nbsp;&nbsp;&nbsp;&nbsp;
 					       <?php echo "&#8364; ".$productpromoprijs; ?></h5>
                <form id="form" name="form" method="post" action="gebruiker/verwerkingwinkelwagentje.php?action=toevoegen&productid=<?php echo $productid ?>">
                    <input type="submit" name="bestellen" id="bestellen" class="knopindex" value="Bestellen" /><br />
              </form>
                </div>    
<div class="clear"></div>
            </div>
               

            
<?php
}
    ?>
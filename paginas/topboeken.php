<?php
if (!isset($connect)) {
    // do nothing
	header('location:../index.php');
	die();
}

$qryproducten = "SELECT DISTINCT tblauteurs.AuteursID, tblauteurs.AuteursNaam, 
    tblproducten.ProductID, tblproducten.ProductNaam, tblproducten.ProductOmschrijving,
    tblproducten.ProductPrijs, tblproducten.ProductPromoPrijs, tblproducten.ProductVoorraad
    FROM tblauteurs
    INNER JOIN tblproducten ON tblauteurs.AuteursID = tblproducten.AuteursID
    INNER JOIN tblprodpercategorie ON tblproducten.ProductID = tblprodpercategorie.ProductID
    INNER JOIN tblcategorie ON tblprodpercategorie.CategorieID = tblcategorie.CategorieID
    WHERE tblproducten.Status = 1 AND tblproducten.Status = 1 AND tblproducten.ProductVoorraad > 0
    ORDER BY tblproducten.ProductAantalVerkocht DESC
    LIMIT 3";

//uitvoeren van de query
$resultsboeken = mysql_query($qryproducten)
    or die(mysql_error());

//het aantal rijen van de query opslaan in een variabele
$numrows = mysql_num_rows($resultsboeken);

//lus starten, rijen herhalen zolang er boeken in de database zitten
while($row = mysql_fetch_array($resultsboeken)) {
    $auteurid = $row['AuteursID'];
    $auteurnaam = $row['AuteursNaam'];

    $productid = $row['ProductID'];
    $productnaam = $row['ProductNaam'];

    $productomschrijving = $row['ProductOmschrijving'];

    ///als er geen omschrijving is, 'geen omschrijving' in een variabele omschrijving plaatsen
    if ($productomschrijving == "") {
        $productomschrijving = "Geen omschrijving";
    } else {
        //enkele de eerste 310 tekens van de omschrijving in de variabele omschrijving plaatsen
        $productomschrijving = substr($productomschrijving, 0, 260)."...";
    }

    $productprijs = $row['ProductPrijs'];
    $productpromoprijs = $row['ProductPromoPrijs'];

    //het puntje voor het kommateken veranderen naar een komma
    $productprijs = str_replace(".", ",", $productprijs);
    $productpromoprijs = str_replace(".", ",", $productpromoprijs);

    $productvoorraad = $row['ProductVoorraad'];

    //als de voorraad van het boek gelijk is aan 0, in de variabele boekvoorraad plaatsen dat er het boek niet op voorraad is
    if ($productvoorraad == 0) {
        $productvoorraad = "Niet op voorraad";

        //indien niet, in de variabele boekvoorraad plaatsen dat het boek op voorraad is
    } else {
        $productvoorraad = "Op voorraad";
    }

    ?>

    
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
                
            <?php

                
            

            ?>
               
<div class="new_prod_box">
                        <a href="paginas/boekdetail.php?boekid=<?php echo $productid; ?>">
                        <?php echo $productnaam; ?>
                    </a>
                        <div>
                        <a href="paginas/boekdetail.php?boekid=<?php echo $productid; ?>">
                        <img src="<?php echo $afbeeldingsurlklein; ?>">
                    </a>
                        </div>           
                    </div>
                    
            
<?php
}}
    ?>
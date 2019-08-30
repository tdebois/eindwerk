<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Thomas
 * Date: 22-4-13
 * Time: 14:36
 * To change this template use File | Settings | File Templates.
 */

include_once("pageaccess.php");
?>
<?php

//include met connectie toevoegen
include_once "../include/connectie.php";

//query opbouwen
$queryupdate= "SELECT * FROM tbladmin WHERE AdminID = 1";

$resultsupdate = mysql_query($queryupdate) or die (mysql_error());

//gegevens ophalen
while($row = mysql_fetch_array($resultsupdate))
{
    $adminlogin = $row['AdminLogin'];
    $adminpas = $row['AdminPas'];

}


//als de verzend knop is aangeduid
if(isset($_POST['verzend']))
{
    //geg ophalen
    $adminlogin=$_POST['AdminLogin'];
    $adminpas=$_POST['AdminPas'];

    //query geg invoegen
    $queryadd = " INSERT INTO tblAdmin (
					AdminLogin,AdminPas)
			VALUES ('" . $adminlogin . "',
			        '" . $adminpas . "')";

    // uitvoeren van de query
    mysql_query($queryadd) or die (mysql_error());

    echo $adminlogin . " " . $adminpas;
    echo " is met succes toegevoegd aan de database";
    echo "</br>";
    echo "</br>";
    //knop weergeven om trg te gaan naar de vorige pagina
    echo '<a href="productenlijst.php"><input name="knop" value="Terug!" type="button"></a>';

}
else
{
    ?>
<form action="paswijzigen.php" method="post">
    <p>Gebruikersnaam:
        <input type="text" name="AdminLogin" size="60" value="<?php echo $adminlogin; ?>"/>
    <p>Paswoord:
        <input type="password" name="richting" size="60" value="<?php echo $adminpas; ?>"/>
    </p><input type='submit' name="verzend" value="Gebruikersnaam en paswoord updaten !" /><p>
    <?php
    echo '<a href="productenlijst.php"><input name="knop" value="Terug!" type="button"></a>';
}
?>
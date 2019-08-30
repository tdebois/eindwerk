<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Thomas
 * Date: 22-4-13
 * Time: 13:58
 * To change this template use File | Settings | File Templates.
 */

session_start();

//session_unset(Login);

///////////////////////////
///// controleer login ////
///////////////////////////

// pipelines || Or moet in hoofdletters
//controleren of de tekstvakken ingevuld zijn
if (empty($_POST['login']) || empty($_POST['pass']))
{
    header('location:inloggen.php?error=invullen');
    exit();
}

//gegevens ophalen en koppelen aan variabelen
	$login = mysql_escape_string($_POST['login']);
	$pass = mysql_escape_string($_POST['pass']);

//connectie toevoegen
include_once "../include/connectie.php";

//controleren of deze gegevens wel in de database zitten
//vraag aan database stellen
	$querylogin= "SELECT AdminID, AdminLogin, AdminPas FROM tbladmin WHERE AdminLogin = '" . $login . "' AND AdminPas = '" . $pass . "'";

	// query uitvoeren
	$resultslogin = mysql_query($querylogin) or die(mysql_error());

	//tellen
	$aantallogin = mysql_num_rows($resultslogin);
	

//indien er 0 of meer dan 1 rijen voldoen aan de vraag, terugsturen
	if ($aantallogin != 1)
    {
        //terugsturen
        header('location:inloggen.php?error=gegevens');
        exit();
    }
    else
    {
        while($rowlogin = mysql_fetch_array($resultslogin))
        {
            //sesions toevoegen
            $_SESSION['login']= $login;
            $_SESSION['pass']= $pass;
            $_SESSION['adminID']= $rowlogin['AdminID'];
        }

        // gebruiker doorsturen
        header('location:index.php');
        exit();
    }
	
	
	

?>
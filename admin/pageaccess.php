<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Thomas
 * Date: 22-4-13
 * Time: 13:40
 * To change this template use File | Settings | File Templates.
 */

session_start();

////////////////////////////////////
///// controleer toegang pagina ////
////////////////////////////////////

//controleren of sessie's bestaan/aangemaakt zijn
if (!isset($_SESSION['login']) || !isset($_SESSION['pass']) || !isset($_SESSION['adminID']))
{
    header('location:inloggen.php?error=toegang');
    exit();
}

//connectie toevoegen
include_once "../include/connectie.php";

//controleren of deze gegevens wel in de database zitten
//vraag aan database stellen
	$querylogin= "SELECT AdminID, AdminLogin, AdminPas FROM tbladmin WHERE AdminLogin = '" . $_SESSION['login'] . "' AND AdminPas = '" . $_SESSION['pass'] . "' AND AdminID = " . $_SESSION['adminID'];

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

	//gebruiker heeft toegang tot de rest van de pagina

?>
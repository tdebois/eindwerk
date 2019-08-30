<?php
session_start();
//sessie's mogelijk maken

//als de ingevoerde emailadres niet leeg is, de login in de sessie plaatsen
if (!empty($_POST['emailadres'])) {

    //emailadres in de sessie plaatsen
    $_SESSION['emailadres'] = $_POST['emailadres'];
}

//controleren of de ingevoerde gegevens niet leeg zijn
if (empty($_POST['emailadres']) || empty($_POST['wachtwoord'])) {
    header('location:../index.php?error=nietingevoerdlogin');
    die();
}

//gegevens ophalen en koppelen aan variabelen
$emailadres = mysql_escape_string($_POST['emailadres']); // geen toegang geven tot sql insert
$wachtwoord = mysql_escape_string($_POST['wachtwoord']);

//connectie invoegen
include_once "../include/connectie.php";

//controleren of deze gegevens wel in de database zitten
//vraag aan database stellen
$querylogin = "SELECT KlantID, Email, Paswoord, Voornaam FROM tblklanten WHERE Email = '".$emailadres."' AND Paswoord = '".$wachtwoord."'";

//query uitvoeren
$resultslogin = mysql_query($querylogin) or die (mysql_error());

//tellen
$aantallogin = mysql_num_rows($resultslogin);

//Indien er 0 of meer dan 1 rijen voldoen aan de vraag, terugsturen
if ($aantallogin != 1) {

    //terugsturen naar inloggen
    header('location:../paginas/inloggen.php?error=passverkeerdlogin');
	
	echo $emailadres;
	echo $wachtwoord;
    die();

} else {

    while($row = mysql_fetch_array($resultslogin)) {
        //sessions opbouwen

        //door de mysql_real_escape_string komen er / voor speciale tekens, met de functie stripslashes worden deze / gewist
        $_SESSION['emailadres'] = $emailadres;
        $_SESSION['wachtwoord'] = $wachtwoord;
        $_SESSION['gebruikersid'] = $row['KlantID'];

        //geen sessie voornaam omdat er bij de registratie van een gebruiker ook de sessie voornaam wordt gebruikt
        //wordt gebruikt in het menu, welkom 'voornaamgeb'
        $_SESSION['voornaamgeb'] = $row['Voornaam'];
    }

    //als er direct na het opstarten van de browser naar deze pagina gesurft wordt is de sessie 'eerstepagina' nog niet ingesteld
    //en wordt er teruggezonden naar de index
    if (!isset($_SESSION['eerstepagina'])) {
        header('location:../index.php');

    } else {
        //doorsturen naar de pagina waar je bent geweest voor je op de pagina inloggen was
        $eerstepagina = $_SESSION['eerstepagina'];
        header('location:'.$eerstepagina);
        die();
    }

//else sluiten
}
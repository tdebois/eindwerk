<?php
session_start();
//sessie's mogelijk maken

//als de sessie's emailadres, wachtwoord en de voornaam van de gebruiker ingesteld zijn, ze uitschakelen
if (isset ($_SESSION['emailadres']) && isset($_SESSION['wachtwoord']) && isset($_SESSION['voornaamgeb'])) {
    unset($_SESSION['emailadres']);
    unset($_SESSION['wachtwoord']);
    unset($_SESSION['voornaamgeb']);

    //terugsturen naar de login pagina en een waarde meegeven in de URL dat er succesvol is uitgelogd
    //zodat er op de pagina inloggen een melding kan gegeven worden
    header('location:../index.php?page=inloggen&vorige=uitloggen');
    die();

//indien de sessie's niet ingesteld zijn terugsturen naar de startpagina
} else {
    header('location:../index.php');
    die();
}

?>
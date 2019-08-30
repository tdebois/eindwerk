<?php

if (isset ($_SESSION['emailadres']) && isset($_SESSION['wachtwoord']) && isset($_SESSION['voornaamgeb'])) {
    unset($_SESSION['emailadres']);
    unset($_SESSION['wachtwoord']);
    unset($_SESSION['voornaamgeb']);

    //aeen waarde meegeven in de URL dat er succesvol is uitgelogd zodat er op de pagina inloggen een melding kan gegeven worden
    header('location:inloggen.php');
} else {
    header('location:../index.php');
}

?>
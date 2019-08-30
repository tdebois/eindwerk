<?php

//als de waarde in het zoekveld is ingesteld, de waarde ophalen uit het formulier
if (isset($_POST['zoek']) ) {
    $zoekwoord = $_POST['zoek'];

//indien niet, terugsturen naar de startpagina
} else {
    header('location:../index.php');
    die();
}

//doorsturen naar de zoek pagina
header('location:../paginas/zoek.php?zoekwoord='.$zoekwoord);
die();

?>
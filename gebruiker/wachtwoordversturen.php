<?php
session_start();
//sessie's mogelijk maken

/*///////////////////////////////
//controle emailadres structuur//
///////////////////////////////*/

//gegevens uit het form inlezen
$email = mysql_real_escape_string($_POST['email']);

//formvalidatie
include_once "includes/formvalidatie.php";

ismail($email, 'emailvergeten');

//array message koppelen aan sessie
//sessie error beschikbaar stellen op andere pagina's
$_SESSION['error'] = $message;

//als er een foutmelding is
if ($_SESSION['error']) {

    $_SESSION['emailvergeten'] = stripslashes($email);
    header('location:../paginas/wachtwoordvergeten.php');
    die();
}

//connectie invoegen
include_once "includes/connectie.php";

/*//////////////////////////////
//controle emailadres database//
//////////////////////////////*/

$queryemailadresbestaat = "SELECT Voornaam, Familienaam, Paswoord FROM tblklanten WHERE Email ='".$email."'";
$resultsemailadresbestaat = mysql_query($queryemailadresbestaat)
    or die(mysql_error()); // zet je niets tussen de haakjes krijg je foutmelding uit de database

//tellen hoeveel rijen er voldoen aan de vraag
$aantalrijen = mysql_num_rows($resultsemailadresbestaat);

if ($aantalrijen == 0) {
    $_SESSION['email'] = stripslashes($email);
    header('location:../paginas/wachtwoordvergeten.php?email=verkeerd');
    die();
}

/*////////////////////////////
//mail sturen met emailadres//
////////////////////////////*/

//lus starten, rijen herhalen zolang er gebruikers in de database zitten (1 gebruiker)
while($rowemailadresbestaat = mysql_fetch_array($resultsemailadresbestaat)) {

    $voornaam = $rowemailadresbestaat['Voornaam'];
    $familienaam = $rowemailadresbestaat['Familienaam'];
    $wachtwoord = $rowemailadresbestaat['Paswoord'];
}

//het IP-adres in een variabele plaatsen
$ipadres = $_SERVER['HTTP_HOST'];

//als je niet op de localhost surft (online) een e-mail versturen
if ($ipadres != 'localhost' && $ipadres != '127.0.0.1') {

    //e-mail opstellen//
    $headers = "From: Nv.Scrivere \r\n";
    $headers .= "X-Sender: <thomas.debois@gmail.com>\r\n";
    $headers .= "X-Mailer: PHP\r\n";
    $headers .= "X-Priority: 3\r\n"; //1 = Spoed bericht, 3 = Normaal bericht
    $headers .= "Return-Path: <".stripslashes($email).">\r\n";
    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

    $onderwerp = "Wachtwoord vergeten";

    $bericht = "

    <html>
        <body>
            <p>Beste ".stripslashes($voornaam)." ".stripslashes($familienaam)."
            <p>U hebt via onze site gemeld dat u uw wachtwoord bent vergeten. Gelieve met onderstaan gegevens in te loggen om een bestelling te plaatsen.</p>
            <p>
                Login: ".$email."<br />
                Paswoord: ".$wachtwoord."
            </p>
                Bewaar deze mail goed, zo kan u snel uw login en paswoord terugvinden. Alvast bedankt en een fijn bezoek aan onze website.
            <p>
            <p>
                Met vriendelijke groeten<br />
                Thomas Debois
            </p>
        </body>
    </html>";

    //e-mail versturen//
    mail ($email,$onderwerp,$bericht,$headers);
}

//wanneer de gebruiker succesvol geregistreerd is, de sessie leegmaken
unset($_SESSION['email']);

//terugsturen naar de pagina wachtwoordvergeten met de melding in de URL dat het wachtwoord succesvol verstuurt is
header('location:../paginas/wachtwoordvergeten.php?email=succes');
die();

?>
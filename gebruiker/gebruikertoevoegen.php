<?php
session_start();

if (get_magic_quotes_gpc()) {
    $process = array(&$_GET, &$_POST, &$_COOKIE, &$_REQUEST);
    while (list($key, $val) = each($process)) {
        foreach ($val as $k => $v) {
            unset($process[$key][$k]);
            if (is_array($v)) {
                $process[$key][stripslashes($k)] = $v;
                $process[] = &$process[$key][stripslashes($k)];
            } else {
                $process[$key][stripslashes($k)] = stripslashes($v);
            }
        }
    }
    unset($process);
}

//gegevens uit het form inlezen
//mysql_real_escape_string gaat SQL injection tegen
$voornaam = mysql_escape_string($_POST['voornaam']);
$familienaam = mysql_escape_string($_POST['familienaam']);
$straat = mysql_escape_string($_POST['straat']);
$huisnr = mysql_escape_string($_POST['huisnr']);
$postcode = mysql_escape_string($_POST['postcode']);
$gemeente = mysql_escape_string($_POST['gemeente']);
$telefoon = mysql_escape_string($_POST['telefoon']);
$emailadres = mysql_escape_string($_POST['emailadres']);
$land = $_POST['land'];
$soortorganisatie = $_POST['soortorganisatie'];
$bedrijfsnaam = mysql_escape_string($_POST['bedrijfsnaam']);
$btwnummer = mysql_escape_string($_POST['btwnummer']);
$website = mysql_escape_string($_POST['website']);
$wachtwoord = mysql_escape_string($_POST['wachtwoord']);
$wachtwoord2 = mysql_escape_string($_POST['wachtwoord2']);

//formvalidatie
include_once "includes/formvalidatie.php";

//formvalidatie via de functies uit formvalidatie.php
veldleeg($voornaam, 'voornaam');
veldleeg($familienaam, 'familienaam');
veldleeg($straat, 'straat');
veldleeg($huisnr, 'huisnr');
veldleeg($postcode, 'postcode');
veldleeg($gemeente, 'gemeente');
numeriekleeg($telefoon, 'telefoon');
ismail($emailadres, 'emailadres');
controleerwachtwoorden($wachtwoord, $wachtwoord2, 'wachtwoorden');

//foutmeldingen

//array message koppelen aan sessie
//sessie error beschikbaar stellen op andere pagina's
$_SESSION['error'] = $message;

//als er een foutmelding is
if ($_SESSION['error']) {

    //de gegevens zonder schuine strepen in de sessie's plaatsen
    //door mysql_real_escape_string komen er slashes bij speciale tekens
    $_SESSION['voornaam'] = stripslashes($voornaam);
    $_SESSION['familienaam'] = stripslashes($familienaam);
    $_SESSION['straat'] = stripslashes($straat);
    $_SESSION['huisnr'] = stripslashes($huisnr);
    $_SESSION['postcode'] = stripslashes($postcode);
    $_SESSION['gemeente'] = stripslashes($gemeente);
    $_SESSION['telefoon'] = stripslashes($telefoon);
    $_SESSION['emailadres'] = stripslashes($emailadres);
    $_SESSION['land'] = $land;
    $_SESSION['soortorganisatie'] = $soortorganisatie;
    $_SESSION['bedrijfsnaam'] = stripslashes($bedrijfsnaam);
    $_SESSION['btwnummer'] = stripslashes($btwnummer);
    $_SESSION['website'] = stripslashes($website);

    //terugsturen naar de pagina om te registreren
    header('location:../index.php?page=registreren');
    die();
}

//IP-adres in een variabele plaatsen
$ipadres = $_SERVER['HTTP_HOST'];

//als je niet op de localhost surft (online) een e-mail versturen
if ($ipadres != 'localhost' && $ipadres != '127.0.0.1') {

    $headers = "From: Nv Scrivere \r\n";
    $headers .= "X-Sender: <thomas.debois@gmail.com>\r\n";
    $headers .= "X-Mailer: PHP\r\n";
    $headers .= "X-Priority: 3\r\n";
    $headers .= "Return-Path: <".stripslashes($emailadres).">\r\n";
    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

    $onderwerp = "Welkom op onze webshop van Scrivere";

    $bericht = "
    <html>
        <body>
            <p>Beste ".stripslashes($voornaam)." ".stripslashes($familienaam)."
            <p>Bedankt voor uw registratie op onze webshop Scrivere. Gelieve met onderstaan gegevens in te loggen om een bestelling te plaatsen.</p>
            <p>
                Login: ".$emailadres."<br />
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
    mail ($emailadres,$onderwerp,$bericht,$headers);
}

//connectie invoegen
include_once "includes/connectie.php";

//query uitbouwen, voeg alle gegevens van de gebruik toe in de database
$querygebruikertoevoegen = "INSERT INTO tblklanten
(Voornaam, Familienaam, Straat, Nummer, Postcode, Gemeente, Telefoon, Email, LandID, Bedrijf, Organisatie, BTWNummer, Website, Paswoord)
VALUES (
'".$voornaam. "', '".$familienaam. "', '".$straat. "', '".$huisnr. "', '".$postcode. "', '".$gemeente. "', '".$telefoon. "',
'".$emailadres."', '".$land. "', '".$bedrijfsnaam. "', '".$soortorganisatie."', '".$btwnummer. "', '".$website. "', '".$wachtwoord."')";

//query uitvoeren
mysql_query($querygebruikertoevoegen) or die (mysql_error());

//wanneer de gebruiker succesvol geregistreerd is, de sessie's leegmaken
unset($_SESSION['voornaam']);
unset($_SESSION['familienaam']);
unset($_SESSION['straat']);
unset($_SESSION['huisnr']);
unset($_SESSION['postcode']);
unset($_SESSION['gemeente']);
unset($_SESSION['telefoon']);
unset($_SESSION['emailadres']);
unset($_SESSION['land']);
unset($_SESSION['bedrijfsnaam']);
unset($_SESSION['soortorganisatie']);
unset($_SESSION['btwnummer']);
unset($_SESSION['website']);

//doorsturen naar beheerrichtingen.php als er correct is ingelogd
//doorgeven via de url(registration=succes) dat er na het registreren gesurfd wordt naar de pagina inloggen
//zodat er na het inloggen niet terug naar de registratiepagina wordt gegaan
header('location:../paginas/inloggen.php?registration=succes');
die();
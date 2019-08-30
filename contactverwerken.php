<?php  

	$emailadres = $_POST['email'];

    $headers = "From: ThomasDebois \r\n";
    $headers .= "X-Sender: <thomas.debois@gmail.com>\r\n";
    $headers .= "X-Mailer: PHP\r\n";
    $headers .= "X-Priority: 3\r\n";
    $headers .= "Return-Path: <". $emailadres .">\r\n";
    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

    $onderwerp = "Een boodschap van " . $_POST['naam'];

    $bericht = "
    <html>
        <body>
            <p>Email: " . $_POST['email'] . "
            <p>Telefoon: " . $_POST['telefoon'] . "</p>
            <p>Bedrijf: " . $_POST['bedrijf'] . "</p>
            <p>Bedrijf: " . $_POST['boodschap'] . "</p>
        </body>
    </html>";

    //e-mail versturen//
    mail ($emailadres,$onderwerp,$bericht,$headers);

	header('location:contact.php');
	die();
?>
<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Thomas
 * Date: 22-4-13
 * Time: 13:56
 * To change this template use File | Settings | File Templates.
 */

session_start();

//alle mogelijke sessions verwijderen
session_destroy();

?>
<form action="logincheck.php" method="post">
    <p>
        <label for="textfield">Login</label>
        <input type="text" name="login" id="textfield" placeholder="Naam" />
    </p>
    <p>
        <label for="textfield2">Paswoord</label>
        <input type="text" name="pass" id="textfield2" placeholder="Paswoord" />
    </p>
    <p>
        <input type="submit" name="button" id="button" value="Inloggen" />
    </p>
</form>
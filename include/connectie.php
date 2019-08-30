<?php

        //connectie met de server maken
        $connect = mysql_connect("localhost","root","")
            or die("Je hebt geen toegang tot de database");

        //connectie met de juiste database
        mysql_select_db("eindwerk");


?>
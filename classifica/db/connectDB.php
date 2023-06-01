<?php
$servername = "db";  
$username = "root";  
$password = "pw";     
$dbname = "serie_a";  

$connessione = new mysqli($servername, $username, $password, $dbname);

if ($connessione->connect_error) {
    die("Connessione fallita: " . $connessione->connect_error);
}

?>
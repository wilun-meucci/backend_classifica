<?php
    $connessione = $_SESSION["db"];

    function registration($userId,$nome, $cognome, $mail, $psw, $gender,$conpleanno,$telefono)
    {
        global $connessione;
        #$sql = "SELECT * FROM utenti where email = '$email' and  passwd='$psw'";
        $insertInto = "INSERT INTO utenti (idUtente,nome,cognome,email,passwd,sesso,dataNascita,numeroTelefono) VALUES ('$userId','$nome','$cognome','$mail','$psw','$gender','$conpleanno','$telefono');";
        $result = $connessione->query($insertInto) or die("fail");
       
        if ($result=== TRUE) 
        {
            return true;
        } else 
        {
            echo "(/db/databaseInsert.php/registration/else)Error: " . $insertInto . "<br>" . $connessione->error;
            return false;
        }
    }
?>
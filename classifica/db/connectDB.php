<?php
    # funzione per collegarsi con il database
    function connectDB() {
        $servername = "db-container";
        $username = "root";
        $password = " ciccio";
        $dbname = "serie_a";
        $connessione = new mysqli($servername, $username, $password, $dbname);
        if ($connessione->connect_error) 
        {
            #aggiungere un visuallizazione migliore
            die("Connection failed: " . $connessione->connect_error);
        } 
        else return $connessione;
        
    }
    

    
?>
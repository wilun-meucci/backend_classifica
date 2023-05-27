<?php
    require_once "connectDB.php";
    require_once "databaseQuery.php";
    // require_once "../php/function.php";
    // require("databaseQuery.php");

    function addCalendario($combinations) {
        global $connessione;
        $matches = generateMatchesByDay($combinations);
        $day = 1;
        foreach ($matches as $matchesOfDay) {
            foreach ($matchesOfDay as $match) {
                $squadraCasa = getSquadra($match[0])["id"]; 
                $squadraOspite = getSquadra($match[1])["id"]; 
                $sql = "INSERT INTO partita (squadra_casa, squadra_ospite,giornata) VALUES ($squadraCasa, $squadraOspite,$day);";
                if ($connessione->query($sql) !== TRUE)
                {
                    echo "Errore nell'inserimento della partita: " . $connessione->error;
                    return false;
                }
                //per debagare
                // else {
                //     echo "---Query: " . $sql . "<br>"; 
                // }
            }
            $day++;
        }
    }
?>
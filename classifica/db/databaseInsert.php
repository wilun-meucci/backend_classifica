<?php
    require_once "connectDB.php";
    require_once "databaseQuery.php";
    // require("databaseQuery.php");
    function addCalendario($combinations)
    {
        global $connessione;

        foreach ($combinations as $key => $value) {
            $casa = getSquadra($value["0"])["id"];
            $ospite = getSquadra($value["1"])["id"];
            $sql = "INSERT INTO partita (squadra_casa, squadra_ospite) VALUES ($casa, $ospite);";
            if ($connessione->query($sql) !== TRUE) {
                echo "Errore nell'inserimento della partita: " . $connessione->error;
                $query = "DELETE FROM partita";
                $connessione->query($query) or die($connessione->error);
                return false;
            }
        }
    }

    function updateMatchesWithDay($matches) {
        global $connessione;
        $day = 1;
        // echo "day :$day<br>";
        foreach ($matches as $index => $matchesOfDay) {
            // echo "index: $index<br>"; 
            foreach ($matchesOfDay as $index2 => $match) {
                // echo "---index2: $index2<br>";
                $squadraCasa = $match[0];
                // echo "---squadraCasa: $squadraCasa<br>"; 
                $squadraOspite = $match[1];
                // echo "---squadraOspite: $squadraOspite<br>"; 
    
                $squadraCasaId = getSquadra($squadraCasa)["id"];
                $squadraOspiteId = getSquadra($squadraOspite)["id"];
    
                $query = "UPDATE partita
                          SET giornata = $day
                          WHERE squadra_casa = $squadraCasaId AND squadra_ospite = $squadraOspiteId";
                echo "---Query: " . $query . "<br>"; // Debug: Visualizza la query generata
                if ($connessione->query($query) !== TRUE) {
                    echo "Errore nell'inserimento della partita: " . $connessione->error;
                    // $query = "DELETE FROM partita";
                    // $connessione->query($query) or die($connessione->error);
                    return false;
                }
                #sleep(2);
            }
    
            $day++;
        }
    }
?>
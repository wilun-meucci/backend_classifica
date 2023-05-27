<?php
    require_once "connectDB.php";
    require_once "databaseQuery.php";
    // require_once "../php/function.php";
    // require("databaseQuery.php");

    function addPartita($giornata, $casa, $ospite,$retiC, $retiO)
    {
        global $connessione;
        $idCasa = getSquadra($casa)["id"];
        $idOspite = getSquadra($ospite)["id"];
        $query = "UPDATE partita
        SET reti_casa = $retiC, reti_ospite = $retiO
        WHERE squadra_casa = $idCasa AND squadra_ospite = $idOspite AND giornata=$giornata";
        if ($connessione->query($query) !== TRUE)
        {
            echo "Errore nell'inserimento dei risultati della partita: " . $connessione->error;
            return false;
        }
        return true;
        
    }
?>


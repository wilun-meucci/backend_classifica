<?php
    require_once "connectDB.php";
    require_once "databaseQuery.php";
    // require_once "../php/function.php";
    // require("databaseQuery.php");

    function old_addPartita($giornata, $casa, $ospite,$retiC, $retiO)
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

    function addPartita($giornata, $casa,$ospite, $retiCasa, $retiOspite) {
        global $connessione;
        
        if(checkDay($giornata))
        {
            $idCasa = getSquadra($casa)["id"];
             // echo "<br>casa: ".$idCasa;
            $idOspite =  getSquadra($ospite)["id"];
            // echo "<br>ospite: ".$idOspite;
            // Verifica se il risultato è già presente
            if (dontExitResultToGame($idCasa,$idOspite,$giornata)) {
                // Aggiorna i valori delle reti
                $query = "UPDATE partita SET reti_casa = $retiCasa, reti_ospite = $retiOspite WHERE squadra_casa = $idCasa AND squadra_ospite = $idOspite and giornata=$giornata ";
                if($connessione->query($query))
                {
                    return true;
                }
                else 
                {
                    // echo "why?";
                    echo $connessione->error;
                }
                
            } else {
                // echo "perche?";
                return false;
            }
        }
        
        
    }

function addGiornata($giornata)
{
    if(checkDay($giornata))
    {
        $partiteGiornata = getGiornata($giornata);
        // print_r($partiteGiornata);
        // echo "<br>----------------------------<br>";
        foreach ($partiteGiornata as $partita) 
        {
            $result = generateRandomResult($_GET["min"] ?? 0,$_GET["max"] ?? 10);
            // echo"<br>giornata: ". $giornata, "casa: ". $partita["casa"], "ospite: ". $partita["ospite"],"reti :". $result["casa"], $result["ospite"],"<br>";
            if(addPartita($giornata, $partita["casa"], $partita["ospite"], $result["casa"], $result["ospite"]) )
            {
            }
            else 
                return false;
        }
        return true;
    }else 
    {

        return false;
    }
}
?>


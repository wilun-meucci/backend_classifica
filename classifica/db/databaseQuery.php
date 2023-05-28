<?php
    require_once "connectDB.php";

    function queryBool($sql)
    {
        global $connessione;
        $result = $connessione->query($sql) or die("fail");
        if($result->num_rows > 0 )
        {
            return true;
        }
        else return false;
    }

    function query($query)
    {
        global $connessione; // Utilizza l'oggetto di connessione globale
        // Esecuzione della query
        $result = $connessione->query($query);
        // Verifica degli eventuali errori nella query
        if ($result !== false) {
            return $result;
        } else {
            die("Errore nella query: " . $connessione->error);
        }
    }

    function getSquadra($id)
    {
        $query = "select * from squadra where id ='" . $id ."' or nome ='". $id."'";
        return query($query)->fetch_assoc();
    }
    function listSquadre()
    {
        $query = "select * from squadra";
        $result = query($query);
        $tmp_data = array();
        $data = [];
        while ($row =$result->fetch_assoc())
        {
            // echo "id: ". $row["id"] ." nome: ". $row["nome"] . "\n";
            $tmp_data = array("id" => $row["id"], "nome" => $row["nome"]);
            array_push($data,$tmp_data);
            // echo "idA: ". $tmp_data["id"]." nomeA: ".$tmp_data["nome"]. "\n";
            // ;
        }
        // print_r($data);
        return $data;
    }

    function checkCalendarioEsistente() {
        $query = "SELECT COUNT(*) AS conteggio FROM partita";
        $conteggio = query($query)->fetch_assoc()['conteggio'];
        $numeroSquadre = count(listSquadre());
        $combinazioniPossibili = ($numeroSquadre * ($numeroSquadre - 1));
        if ($conteggio == $combinazioniPossibili) {
        
            return true; // Il calendario esiste già
        } else {
            return false; // Il calendario non esiste ancora
        }
    }

    function getCalendarioBase() {
        $query = "SELECT DISTINCT sc.nome AS squadra_casa, so.nome AS squadra_ospite
        FROM partita p
        JOIN squadra sc ON p.squadra_casa = sc.id
        JOIN squadra so ON p.squadra_ospite = so.id;";
        $result = query($query);
        $calendario = array();
        while ($row = $result->fetch_assoc()) {
            $partita = array($row['squadra_casa'], $row['squadra_ospite']);
            $calendario[] = $partita;
        }
        return $calendario;
    }
    function old_exitResultToGame($casa, $ospite)
{
    $retiCQuery = "SELECT reti_casa
                   FROM partita
                   WHERE squadra_casa = $casa AND squadra_ospite = $ospite";
    $retiOQuery = "SELECT reti_ospite
                   FROM partita
                   WHERE squadra_casa = $casa AND squadra_ospite = $ospite";
    
    $retiCResult = query($retiCQuery);
    $retiOResult = query($retiOQuery);
    
    $retiCasa = $retiCResult->fetch_assoc()["reti_casa"];
    $retiOspite = $retiOResult->fetch_assoc()["reti_ospite"];
    
    if (empty($retiCasa) || is_null($retiCasa)) {
        return true;
    }
    
    if (empty($retiOspite) || is_null($retiOspite)) {
        return true;
    }
    
    return false;
}





function dontExitResultToGame($casa, $ospite,$giornata) {
    global $connessione;
    $query = "SELECT reti_casa, reti_ospite FROM partita WHERE squadra_casa = $casa AND squadra_ospite = $ospite and giornata = $giornata";
    $result = $connessione->query($query);

    if ($result->num_rows > 0) {
        $retiCasa = $result->fetch_assoc()['reti_casa'];
        $retiOspite = $result->fetch_assoc()['reti_ospite'];

        if ($retiCasa === null && $retiOspite === null) {
            return true; // Risultato non presente
        } else {
            return false; // Risultato già presente
        }
    } else {
        return false; // Partita non trovata
    }
}
function getPartita($casa,$ospite)
{
    $query = "select * from partita where squadra_casa ='" . getSquadra($casa)["id"] ."' and  squadra_ospite ='". getSquadra($ospite)["id"]."'";
    return query($query)->fetch_assoc();
}

function listPartite()
    {
        $query = "select * from partita order by giornata asc;";
        $result = query($query);
        $tmp_data = array();
        $data = [];
        while ($row =$result->fetch_assoc())
        {
            // echo "id: ". $row["id"] ." nome: ". $row["nome"] . "\n";
            $tmp_data = array("id" => $row["id"], "giornata" => $row["giornata"],"casa" => $row["squadra_casa"],"ospite" => $row["squadra_ospite"], "retiC" => $row["reti_casa"],"retiO" => $row["reti_ospite"]);
            array_push($data,$tmp_data);
            // echo "idA: ". $tmp_data["id"]." nomeA: ".$tmp_data["nome"]. "\n";
            // ;
        }
        // print_r($data);
        return $data;
    }

function getGiornata($day)
{
    $query = "select * from partita where giornata = $day";
    $result = query($query);
        $tmp_data = array();
        $data = [];
        while ($row =$result->fetch_assoc())
        {
            // echo "id: ". $row["id"] ." nome: ". $row["nome"] . "\n";
            $tmp_data = array("id" => $row["id"], "giornata" => $row["giornata"],"casa" => $row["squadra_casa"],"ospite" => $row["squadra_ospite"], "retiC" => $row["reti_casa"],"retiO" => $row["reti_ospite"]);
            array_push($data,$tmp_data);
            // echo "idA: ". $tmp_data["id"]." nomeA: ".$tmp_data["nome"]. "\n";
            // ;
        }
        // print_r($data);
        return $data;
}






?>
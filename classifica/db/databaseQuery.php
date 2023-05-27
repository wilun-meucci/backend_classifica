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
        $query = "SELECT sc.nome AS squadra_casa, so.nome AS squadra_ospite
                  FROM partita p
                  JOIN squadra sc ON p.squadra_casa = sc.id
                  JOIN squadra so ON p.squadra_ospite = so.id";
        $result = query($query);
        $calendario = array();
        while ($row = $result->fetch_assoc()) {
            $partita = array($row['squadra_casa'], $row['squadra_ospite']);
            $calendario[] = $partita;
        }
        return $calendario;
    }


?>
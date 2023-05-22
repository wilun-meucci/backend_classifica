<?php
    require ( "connectDB.php");
    $_SESSION["db"] = $connessione = connectDB();

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

    function getClassifica($squadra)
    {
        global $connessione;
        
    }
    function query($query)
    {
        global $connessione; // Utilizza l'oggetto di connessione globale
        // Esecuzione della query
        $result = $connessione->query($query);
        // Verifica degli eventuali errori nella query
        if ($result or $result->num_rows>0) {
            return $result;
        }
        else 
        {
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
        global $connessione;
        $query = "select * from squadra";
        $result = $connessione->query($query);
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


?>
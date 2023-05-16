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
    function getSquadra($id)
    {
        global $connessione;
        $query = "select * from squadra where squadra = '". $id ."'";
        $result = $connessione->query($query) or die("fail");
        return $result->featch_assoc()["squadra"];
    }


?>
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
        $sql = "select squadre from classifica where squadra = '$squadra'";
        $result = $connessione->query($sql) or die("fail");
        return $result->featch_assoc()["squadra"];
    }
?>
<?php 
header('Access-Control-Allow-Origin: *');
#header('Content-Type: application/json');


require("./db/databaseQuery.php");
//getClassifica($)

/*
echo "[";
    while ($row =$result->fetch_assoc())
    {
        echo '{"name": "' . $row["squadra"] . '"}, ';
    }
    echo "]";
*/

echo "dio";
echo getSquadra("Juventus");
    //echo "{name: " . $_GET["squadra"] ."}";
?>  



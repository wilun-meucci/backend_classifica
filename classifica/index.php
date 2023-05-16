<?php 
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json; charset=utf-8'); 


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

$data = ["ciao","come ba?"]; 

echo json_encode($data);

    //echo "{name: " . $_GET["squadra"] ."}";
?>  



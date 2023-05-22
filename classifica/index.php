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


if(isset($_GET["squadra"]))
{
    $data = getSquadra($_GET["squadra"]);
    echo json_encode($data);
}

if(isset($_GET["squadre"]))
{
    $data = listSquadre();
    // print_r($data);
    echo json_encode($data);
}

#echo json_encode($data);

    //echo "{name: " . $_GET["squadra"] ."}";
?>  

<?php
function generateCombinations($array) {
    $combinations = array();

    for ($x = 0; $x < count($array); $x++) {
        for ($y = $x + 1; $y < count($array); $y++) {
            $combination = [$array[$x], $array[$y]];
            $combinations[] = $combination;
        }
    }

    return $combinations;
}

function copyAndReverseArray($array) {
    $copiedArray = array();
    foreach ($array as $element) {
        $reversedElement = strrev($element);
        $copiedArray[] = $reversedElement;
    }
    return $copiedArray;
}


function printCombinations($combinations) {
    foreach ($combinations as $combination) {
        echo $combination[0] . " " . $combination[1] . "\n";
    }
}

$teams = ["a", "b", "c", "d", "e"];

$originalCombinations = generateCombinations($teams);
$copiedArray = copyAndReverseArray($teams);
$additionalCombinations = generateCombinations($copiedArray);

$allCombinations = array_merge($originalCombinations, $additionalCombinations);

printCombinations($allCombinations);
?>



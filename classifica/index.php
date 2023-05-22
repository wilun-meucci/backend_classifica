<?php 


header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json; charset=utf-8'); 


require("./db/databaseQuery.php");
require("./php/function.php");


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

if(isset($_GET["calendario"]))
{
    $request = $_GET["calendario"];
    $combinations = generateCombinations(listSquadre());
    if($request=="squadre")
    {
        $teamsCobinations = organizeByTeams($combinations);
        if($_GET["nome"])
        {
            $name = $_GET["nome"];
            $nameTeams = getTeams($name, $teamsCobinations);
            #print_r($nameTeams);
            if($_GET["ruolo"])
            {
                $ruolo = $_GET["ruolo"];
                $roleTeams = getTeamsByRole($ruolo, $nameTeams);
                echo json_encode($roleTeams);
            }
            else
                echo json_encode($nameTeams);
                #echo "oh no";
            
        }else 
        {
            #print_r($teamsCobinations);
            echo json_encode($teamsCobinations);
            #echo "oh nono";
        }      
    }
    else if($request=="giorni")
    {
        $dayCombinations = generateMatchesByDay($combinations);
        echo json_encode($dayCombinations);
    }
    else if($request=="ciao")
    {
        $dayCombinations = generateMatchesByDay($combinations);
    }
    else
        echo json_encode($combinations);
    

    #print_r($combinations);
}
$squadre = listSquadre();
$combinations = generateCombinations($squadre);
?>  





        
            

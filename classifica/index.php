<?php 


// header('Access-Control-Allow-Origin: *');
// header('Content-Type: application/json; charset=utf-8'); 


require_once "./db/databaseQuery.php";
require_once "./db/databaseInsert.php";
require_once "./db/databaseUpdate.php";
require_once "./php/function.php";





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

if(isset($_GET["creaCalendario"]))
{
    if(checkCalendarioEsistente())
    {
        $combinations = getCalendarioBase();
    }
    else
    {
        $combinations = generateCombinations(listSquadre());
        addCalendario($combinations);
    }
    $request = $_GET["creaCalendario"];
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
        }      
    }
    else if($request=="giorni")
    {   
        echo "giorni";
        $dayCombinations = generateMatchesByDay($combinations);
        echo json_encode($dayCombinations);
    }
    else
        echo json_encode($combinations);
    #print_r($combinations);
}
// $squadre = listSquadre();
// $combinations = generateCombinations($squadre);

if(isset($_GET["giocaPartita"]))
{
    if($_GET["giocaPartita"] == "random")
    {
        $giornata = $_GET["giornata"];
        $casa = $_GET["casa"];
        $ospite =$_GET["ospite"];
        
        if(!exitResultToGame($casa,$ospite))
        {
            $result = generateRandomResult($_GET["min"] ?? 0,$_GET["max"] ?? 5);
            if(addPartita($giornata, $casa, $ospite, $result["casa"], $result["ospite"]))
            {
                echo "gg";
            }
        }
        else 
        {
            echo exitResultToGame($casa,$ospite);
            echo "esiste gia un risultato";
        }
        
    }
}






?>  





        
            

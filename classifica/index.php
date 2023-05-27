<?php 


header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json; charset=utf-8'); 


require_once "./db/databaseQuery.php";
require_once "./db/databaseInsert.php";
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
            #echo "oh nono";
        }      
    }
    else if($request=="giorni")
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
        $dayCombinations = generateMatchesByDay($combinations);

        updateMatchesWithDay($dayCombinations);



        #echo json_encode($dayCombinations);
    }
    else if($request=="ciao")
    {
        $dayCombinations = generateMatchesByDay($combinations);
    }
    else
        echo json_encode($combinations);
    

    #print_r($combinations);
}
// $squadre = listSquadre();
// $combinations = generateCombinations($squadre);







?>  





        
            

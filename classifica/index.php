<?php 


header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json; charset=utf-8'); 


require_once "./db/databaseQuery.php";
require_once "./db/databaseInsert.php";
require_once "./db/databaseUpdate.php";
require_once "./php/function.php";


if(isset($_GET))
{
    if(checkCalendarioEsistente())
    {
        unset($combinations);
        $combinations = getCalendarioBase();
    }
    else
    {
        $combinations = generateCombinations(listSquadre());
        addCalendario(listSquadre());
    }
}


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

if(isset($_GET["nonServe"]))
{
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
        $dayCombinations = generateMatchesByDay(listSquadre());
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
        if(dontExitResultToGame($casa,$ospite, $giornata))
        {
            $result = generateRandomResult($_GET["min"] ?? 0,$_GET["max"] ?? 10);
            if(addPartita($giornata ,$casa, $ospite, $result["casa"], $result["ospite"]))
            {
                $partita = getPartita($casa,$ospite);
                echo json_encode($partita);
            }
        }
        
    }
}
if(isset($_GET["giocaGiornata"]))
{
    if($_GET["giocaGiornata"] == "random")
    {
        $giornata = $_GET["giornata"];
        if(addGiornata($giornata))
        {
            $partitaGiornata = getGiornata($giornata);
            echo json_encode($partitaGiornata);
        }
    }
}

if(isset($_GET["giocaCampionato"]))
{
    if($_GET["giocaCampionato"] == "random")
    {
        for ($giornata=0; $giornata <= 38; $giornata++) { 
            addGiornata($giornata);
        }
        $calendario = getCalendario($_GET["orderBy"]);
        echo json_encode($calendario);
        
    }
}

if(isset($_GET["classifica"]))
{
    $classifica = getClassifica();
    echo json_encode($classifica);
}

if(isset($_GET["calendario"]))
{
    $request = $_GET["calendario"];
    if($request=="giorni")
    {
        $calendarioDays = getCalendarioByDay();
        // print_r($calendarioDays);
        echo json_encode($calendarioDays);
    }
    else if($request=="squadre")
    {
        $calendarioTeams = getCalendarioByTeams();
        echo json_encode($calendarioTeams);
    }
    else{
        $calendario = getCalendario($_GET["orderBy"]);
        echo json_encode($calendario);
    }
    
}





?>  





        
            

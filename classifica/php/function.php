<?php
function generateCombinations($array) {
    $combinations = array();
    $count = count($array);
    for ($x = 0; $x < $count; $x++) {
        $nomeX = $array[$x]['nome'];

        for ($y = $x + 1; $y < $count; $y++) {
            $nomeY = $array[$y]['nome'];

            $combinations[] = array($nomeX, $nomeY);
            $combinations[] = array($nomeY, $nomeX);
        }
    }
    return $combinations;
}

function organizeByTeams($combinations) {
    $teams = array();

    foreach ($combinations as $combination) {
        $team1 = $combination[0];
        $team2 = $combination[1];

        if (!isset($teams[$team1])) {
            $teams[$team1] = array(
                'casa' => array(),
                'ospite' => array()
            );
        }

        if (!isset($teams[$team2])) {
            $teams[$team2] = array(
                'casa' => array(),
                'ospite' => array()
            );
        }

        $teams[$team1]['casa'][] = $team2;
        $teams[$team2]['ospite'][] = $team1;
    }

    // Inverti l'ordine delle squadre nella sezione ospite
    foreach ($teams as &$team) {
        $team['ospite'] = array_reverse($team['ospite']);
    }

    return $teams;
}

function printCombinations($combinations) {
    foreach ($combinations as $combination) {
        echo implode(', ', $combination) . "\n";
    }
}

function generateMatchesByDay(array $teams): array {
    $numplayers = count($teams);

    if ($numplayers % 2 != 0)
        $numplayers++;

    $days = [];

    for ($round = 0; $round < $numplayers - 1; $round++) {
        $day = [];
        $match = [ $teams[0]['nome'] ];

        for ($i = 0; $i < $numplayers - 1; $i++) {
            if ($i % 2 == 0)
                $player = ($numplayers - 2) - $i / 2 - $round;
            else
                $player = ($i - 1) / 2 - $round;

            if ($player < 0)
                $player += $numplayers - 1;

            array_push($match, $teams[$player + 1]['nome']);

            if ($i % 2 == 0)
            {
                array_push($day, $match);
                $match = [];
            }
        }

        array_push($days, $day);
    }

    foreach ($days as $day) {
        $mirror = [];

        foreach ($day as [ $a, $b ])
            array_push($mirror, [ $b, $a ]);

        array_push($days, $mirror);
    }

    return $days;
}
function getTeams($name, $teamsCombinations) {
    $teams = array();

    foreach ($teamsCombinations as $team => $matches) {
        if (in_array($name, $matches['casa'])) {
            $teams['casa'] = $matches['casa'];
            $teams['ospite'] = $matches['ospite'];
            break;
        }

        if (in_array($name, $matches['ospite'])) {
            $teams['casa'] = $matches['ospite'];
            $teams['ospite'] = $matches['casa'];
            break;
        }
    }

    return $teams;
}
function getTeamsByRole($ruolo, $nameTeams) {
    if ($ruolo === "casa") {
        return $nameTeams['casa'];
    } elseif ($ruolo === "ospite") {
        return $nameTeams['ospite'];
    } else {
        return array(); // Ruolo non valido, restituisce un array vuoto
    }
}



function generateRandomResult($min, $max)
{
    $retiC = rand($min, $max);
    $retiO = rand($min, $max);
    return array("casa" => $retiC, "ospite" => $retiO);
}



function checkDay($giornata)
{
    if($giornata == 1)
    {
        return true;
    }
    $partite = listPartite();
    foreach ($partite as $partita) 
    {
        if($giornata > $partita["giornata"])
        {
            if(dontExitResultToGame($partita["casa"],$partita["ospite"], $partita["giornata"]))
            {
                echo "Gioca prima le altre giornate";
                return false;
            }
        }
    }
    return true;
    
}









?>
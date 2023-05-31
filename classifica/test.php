<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json; charset=utf-8'); 
   

    function generateCombinations($array) {
    $combinations = array();

    foreach ($array as ['nome'  => $casa]) {
        foreach ($array as ['nome' => $trasferta]) {
            if ($casa != $trasferta)
                array_push($combinations, [$casa, $trasferta]);
        }
    }
    // for ($x = 0; $x < count($array); $x++) {
    //     $nomeX = $array[$x]['nome'];

    //     for ($y = $x + 1; $y < $count; $y++) {
    //         $nomeY = $array[$y]['nome'];

    //         $combinations[] = array($nomeX, $nomeY);
    //         $combinations[] = array($nomeY, $nomeX);
    //     }
    // }
    return $combinations;
    }
    function listSquadre()
    {
        $data = array(
            array('id' => '1','nome' => 'atalanta'),
            array('id' => '2','nome' => 'bologna'),
            array('id' => '3','nome' => 'cremonese'),
            array('id' => '4','nome' => 'Empoli'),
            array('id' => '5','nome' => 'fiorentina'),
            array('id' => '6','nome' => 'hellas Verona'),
            array('id' => '7','nome' => 'inter'),
            array('id' => '8','nome' => 'Juventus'),
            array('id' => '9','nome' => 'Lazio'),
            array('id' => '10','nome' => 'lecce'),
            array('id' => '11','nome' => 'milan'),
            array('id' => '12','nome' => 'Monza'),
            array('id' => '13','nome' => 'napoli'),
            array('id' => '14','nome' => 'roma'),
            array('id' => '15','nome' => 'salernitana'),
            array('id' => '16','nome' => 'Sampdoria'),
            array('id' => '17','nome' => 'Sassuolo'),
            array('id' => '18','nome' => 'spezia'),
            array('id' => '19','nome' => 'torino'),
            array('id' => '20','nome' => 'udinese')
          );
        // print_r($data);
        return $data;
    }
    
    function countTeamOccurrences($array) {
        $teamCasa = array();
        $teamOspite = array();
    
        foreach ($array as $subArray) {
            foreach ($subArray as $teams) {
                $teamCasa[] = $teams[0];
                $teamOspite[] = $teams[1];
            }
        }
    
        $teamCasaOccurrences = array_count_values($teamCasa);
        $teamOspiteOccurrences = array_count_values($teamOspite);
    
        foreach ($teamCasaOccurrences as $team => $count) {
            echo "La squadra $team compare in casa $count volte.\n";
        }
        echo "\n";
        foreach ($teamOspiteOccurrences as $team => $count) {
            echo "La squadra $team compare come ospite $count volte.\n";
        }
    }
    function old_generateMatchesByDay($combinations) {
        $days = [];
        do {
            $new_combinations = [];
            $day = [];
            foreach ($combinations as $combination) {
                if (count($day) >= 10)
                    break;
                $skip_combination = false;
                foreach ($day as $match) {
                    $skip_combination |=
                        $combination[0] == $match[0] ||
                        $combination[0] == $match[1] ||
                        $combination[1] == $match[0] ||
                        $combination[1] == $match[1];
                }

                if ($skip_combination)
                    array_push($new_combinations, $combination);
                else
                    array_push($day, $combination);
                
                // Richiama la funzione di debug
                
            }
            array_push($days, $day);
            $combinations = $new_combinations;
        } while (count($combinations) > 0);
        
        return $days;
    }
    
    function teamInDay(array $day, string $team): bool {
        foreach ($day as $match) {
            if ($match[0] == $team || $match[1] == $team)
                return true;
        }

        return false;
    }

    function matchInDay(array $day, array $new_match): bool {
        foreach ($day as $match) {
            if ($new_match[0] == $match[0] && $new_match[1] == $match[1])
                return true;
        }

        return false;
    }

    function matchInDays(array $days, array $new_match): bool {
        foreach ($days as $day) {
            if (matchInDay($day, $new_match))
                return true;
        }

        return false;
    }

    function old_isCombinationOk(string $casa, string $trasferta, array $days, array $new_day): bool {
        if ($casa == $trasferta)
            return false;

        if (teamInDay($new_day, $casa) || teamInDay($new_day, $trasferta))
            return false;

        if (matchInDays($days, [$casa, $trasferta]))
            return false;

        return true;
    }

    function isCombinationOk(string $casa, string $trasferta, array $day): bool {
        return count($day) < 10 && !teamInDay($day, $casa) && !teamInDay($day, $trasferta);
    }
    
    function new_old_generateMatchesByDay(array $teams): array {
        $daysCount = 38;
        $days = [];

        for ($i = 0; $i < $daysCount; $i++) {
            $matchesCount = 10;
            $matches = [];

            for ($j = 0; $j < $matchesCount; $j++)
                foreach ($teams as ['nome' => $casa])
                    foreach ($teams as ['nome' => $trasferta])
                        if (old_isCombinationOk($casa, $trasferta, $days, $matches))
                            array_push($matches, [$casa, $trasferta]);
            
            array_push($days, $matches);
        }

        return $days;
    }


function pieno38_generateMatchesByDay(array $matches): array {
    $days = [];

    for ($i=0; $i < 38; $i++) { 
        array_push($days, []);
    }

    $ptr = 0;

    foreach ($matches as [$casa, $trasferta]) {
        while($ptr < count($days) - 1 && !isCombinationOk($casa, $trasferta, $days[$ptr])) {
            $ptr++;
        }
        array_push($days[$ptr], [$casa, $trasferta]);
        $ptr = 0;
    }

    return $days;
}

function old__old_generateMatchesByDay(array $matches): array
{
    $days = [];

    for ($i=0; $i < 38; $i++)
        array_push($days, []);

    $ptr = 0;

    while (count($matches) > 0)
    {
        for ($i=0; $i < count($matches) && $ptr < count($days); $i++)
        { 
            // la squadra non gioca già in questa giornata
            if (isCombinationOk($matches[$i][0], $matches[$i][1], $days[$ptr]))
            {
                array_push($days[$ptr], $matches[$i]);
                unset($matches[$i--]);
                $matches = array_values($matches);
            }
            else
            {
                $i--;
                $ptr++;
            }
        }
    }

    return $days;
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

$combinations = generateCombinations(listSquadre());
$dayCombinations = generateMatchesByDay(listSquadre());

// countTeamOccurrences($dayCombinations);
//  echo "giornate: ".count($dayCombinations)."\n<br>";
// // echo phpinfo();
echo json_encode($dayCombinations);
#print_r($dayCombinations);
?>

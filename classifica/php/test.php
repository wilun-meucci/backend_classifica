<?php
require_once "../db/connectDB.php";
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json; charset=utf-8'); 
    function old_generateMatchesByDay($combinations) {
    $matchesPerDay = 10;
    $matchesPerSeason = 380;
    $days = 38;

    $matches = array();
    $teamsPlayed = array();

    for ($day = 1; $day <= $days; $day++) {
        $matchesOfDay = array();

        for ($matchIndex = 0; $matchIndex < $matchesPerDay; $matchIndex++) {
            $validMatchFound = false;

            while (!$validMatchFound) {
                $combinationIndex = array_rand($combinations);
                $match = $combinations[$combinationIndex];

                if (!in_array($match[0], $teamsPlayed) && !in_array($match[1], $teamsPlayed)) {
                    $validMatchFound = true;
                    $teamsPlayed[] = $match[0];
                    $teamsPlayed[] = $match[1];
                }
            }

            $matchesOfDay[] = $match;
        }

        $matches[] = $matchesOfDay;
        $teamsPlayed = array();
    }

    return $matches;
    }

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
    function listSquadre()
    {
        global $connessione;
        $query = "select * from squadra";
        $result = $connessione->query($query);
        $tmp_data = array();
        $data = [];
        while ($row =$result->fetch_assoc())
        {
            // echo "id: ". $row["id"] ." nome: ". $row["nome"] . "\n";
            $tmp_data = array("id" => $row["id"], "nome" => $row["nome"]);
            array_push($data,$tmp_data);
            // echo "idA: ". $tmp_data["id"]." nomeA: ".$tmp_data["nome"]. "\n";
            // ;
        }
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
    

    function generateMatchesByDay($combinations) {
        $days = [];

        do {
            $new_combinations = [];
            $day = [];

            foreach ($combinations as $combination) {
                if (count($day) > 10)
                    break;

                $skip_combination = false;

                foreach ($day as $match) {
                    $skip_combination |= in_array($combination[0], $match) || in_array($combination[1], $match);
                }

                if ($skip_combination)
                    array_push($new_combinations, $combination);
                else
                    array_push($day, $combination);
            }

            array_push($days, $day);
            $combinations = $new_combinations;
        } while (count($combinations) > 0);

        return $days;
    }

$combinations = generateCombinations(listSquadre());
#$dayCombinations = old_generateMatchesByDay($combinations);
countTeamOccurrences(generateMatchesByDay($combinations));



print_r(generateMatchesByDay($combinations));
?>

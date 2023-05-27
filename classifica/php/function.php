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

function generateMatchesByDay($combinations) {
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

function checkCalendarioEsistente() {
    $query = "SELECT COUNT(*) AS conteggio FROM partita";
    $result = query($query)->fetch_assoc();
    $conteggio = $result['conteggio'];
    $numeroSquadre = count(listSquadre());
    $combinazioniPossibili = ($numeroSquadre * ($numeroSquadre - 1));

    if ($conteggio == $combinazioniPossibili) {
        return true; // Il calendario esiste già
    } else {
        return false; // Il calendario non esiste ancora
    }
}

function getCalendarioBase() {
    $query = "SELECT sc.nome AS squadra_casa, so.nome AS squadra_ospite
              FROM partita p
              JOIN squadra sc ON p.squadra_casa = sc.id
              JOIN squadra so ON p.squadra_ospite = so.id";
    $result = query($query);
    $calendario = array();

    while ($row = $result->fetch_assoc()) {
        $partita = array($row['squadra_casa'], $row['squadra_ospite']);
        $calendario[] = $partita;
    }

    return $calendario;
}









?>
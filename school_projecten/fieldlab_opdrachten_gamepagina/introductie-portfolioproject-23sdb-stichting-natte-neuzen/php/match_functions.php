<?php
require_once 'config.php';
$conn = dbConnect();

// Haal alle matches op met unieke match_id
function getMatches() {
    global $conn;
    $sql = "SELECT match_id, competition_id, team1_id, team2_id, scheduled_at, status, score_team1, score_team2
            FROM matches
            ORDER BY scheduled_at ASC";
    $stmt = $conn->query($sql);
    $matches = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Voeg team- en competitie-namen toe per match
    foreach ($matches as &$m) {
        $m['team1_name'] = getTeamName($m['team1_id']);
        $m['team2_name'] = getTeamName($m['team2_id']);
        $m['competition_name'] = getCompetitionName($m['competition_id']);
    }

    return $matches;
}

function getTeamName($teamId) {
    global $conn;
    if (!$teamId) return '';
    $stmt = $conn->prepare("SELECT name FROM teams WHERE team_id = :id");
    $stmt->execute(['id' => $teamId]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    return $row ? $row['name'] : '';
}

function getCompetitionName($compId) {
    global $conn;
    if (!$compId) return '';
    $stmt = $conn->prepare("SELECT name FROM competitions WHERE competition_id = :id");
    $stmt->execute(['id' => $compId]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    return $row ? $row['name'] : '';
}

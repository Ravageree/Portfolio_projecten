<?php
session_start();
require_once 'config.php';
$conn = dbConnect();

if (empty($_SESSION['user_id'])) {
    header("Location: ../pages/login.php");
    exit;
}

$userId = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $matchId = $_POST['match_id'] ?? null;
    $competitionId = $_POST['competition_id'] ?? null;
    $team1Id = $_POST['team1_id'] ?? null;
    $team2Id = $_POST['team2_id'] ?? null;
    $scheduledAt = $_POST['scheduled_at'] ?? null;
    $status = $_POST['status'] ?? 'scheduled';
    $score_team1 = $_POST['score_team1'] ?? 0;
    $score_team2 = $_POST['score_team2'] ?? 0;

    // Bereken winnaar
    $winner_team_id = null;
    if ($score_team1 > $score_team2) $winner_team_id = $team1Id;
    elseif ($score_team2 > $score_team1) $winner_team_id = $team2Id;

    if ($matchId) {
        // Update bestaande match
        $sql = "
        UPDATE matches SET
            competition_id = :competition_id,
            team1_id = :team1_id,
            team2_id = :team2_id,
            scheduled_at = :scheduled_at,
            status = :status,
            score_team1 = :score_team1,
            score_team2 = :score_team2,
            winner_team_id = :winner_team_id
        WHERE match_id = :match_id
        ";
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            'competition_id' => $competitionId,
            'team1_id' => $team1Id,
            'team2_id' => $team2Id,
            'scheduled_at' => $scheduledAt,
            'status' => $status,
            'score_team1' => $score_team1,
            'score_team2' => $score_team2,
            'winner_team_id' => $winner_team_id,
            'match_id' => $matchId
        ]);
    } else {
        // Voeg nieuwe match toe
        $sql = "
        INSERT INTO matches 
            (competition_id, team1_id, team2_id, scheduled_at, status, score_team1, score_team2, winner_team_id)
        VALUES
            (:competition_id, :team1_id, :team2_id, :scheduled_at, :status, :score_team1, :score_team2, :winner_team_id)
        ";
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            'competition_id' => $competitionId,
            'team1_id' => $team1Id,
            'team2_id' => $team2Id,
            'scheduled_at' => $scheduledAt,
            'status' => $status,
            'score_team1' => $score_team1,
            'score_team2' => $score_team2,
            'winner_team_id' => $winner_team_id
        ]);
    }

    header("Location: ../pages/wedstrijdschema.php");
    exit;
}

// Verwijder match
if (isset($_GET['delete'])) {
    $matchId = $_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM matches WHERE match_id = :id");
    $stmt->execute(['id' => $matchId]);
    header("Location: ../pages/wedstrijdschema.php");
    exit;
}

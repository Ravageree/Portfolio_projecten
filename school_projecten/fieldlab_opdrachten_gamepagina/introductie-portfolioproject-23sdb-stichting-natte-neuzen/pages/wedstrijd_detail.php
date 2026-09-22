<?php
session_start();
require_once '../php/config.php';
$conn = dbConnect();

if (empty($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$matchId = $_GET['id'] ?? null;
if (!$matchId) {
    header("Location: wedstrijdschema.php");
    exit;
}

// Haal match op met alle details
$sql = "
SELECT m.*, 
       t1.name AS team1_name, t2.name AS team2_name,
       c.name AS competition_name, c.game
FROM matches m
LEFT JOIN teams t1 ON m.team1_id = t1.team_id
LEFT JOIN teams t2 ON m.team2_id = t2.team_id
LEFT JOIN competitions c ON m.competition_id = c.competition_id
WHERE m.match_id = :id
";
$stmt = $conn->prepare($sql);
$stmt->execute(['id' => $matchId]);
$match = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$match) {
    echo "Wedstrijd niet gevonden.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wedstrijd Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>
    <?php include '../php/navbar.php'; ?>

    <div class="container py-5">
        <h2>Wedstrijd Details</h2>
        <table class="table table-bordered">
            <tr>
                <th>Competitie</th>
                <td><?= htmlspecialchars($match['competition_name']) ?></td>
            </tr>
            <tr>
                <th>Game</th>
                <td><?= htmlspecialchars($match['game'] ?? 'Niet gespecificeerd') ?></td>
            </tr>
            <tr>
                <th>Team 1</th>
                <td><?= htmlspecialchars($match['team1_name']) ?></td>
            </tr>
            <tr>
                <th>Team 2</th>
                <td><?= htmlspecialchars($match['team2_name']) ?></td>
            </tr>
            <tr>
                <th>Datum & Tijd</th>
                <td><?= date('d-m-Y H:i', strtotime($match['scheduled_at'])) ?></td>
            </tr>
            <tr>
                <th>Status</th>
                <td><?= ucfirst($match['status']) ?></td>
            </tr>
            <tr>
                <th>Score</th>
                <td><?= $match['score_team1'] ?> - <?= $match['score_team2'] ?></td>
            </tr>
        </table>
        <a href="wedstrijdschema.php" class="btn btn-secondary">Terug naar schema</a>
    </div>

    <?php include '../php/footer.php'; ?>
</body>

</html>
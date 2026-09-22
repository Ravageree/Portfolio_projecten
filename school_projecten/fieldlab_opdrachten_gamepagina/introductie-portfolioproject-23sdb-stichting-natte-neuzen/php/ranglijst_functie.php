<?php
require_once 'config.php';
$pdo = $conn = dbConnect();

$teams = $pdo->query("SELECT team_id, name FROM teams ORDER BY team_id")->fetchAll(PDO::FETCH_ASSOC);

$leaderboards = [];

foreach ($teams as $team) {
    $team_id = $team['team_id'];

    $stmt = $pdo->prepare(
        "SELECT * FROM matches WHERE status = 'played' AND (team1_id = :id OR team2_id = :id)"
    );

    $stmt->execute(['id' => $team_id]);
    $matches = $stmt->fetchALL(PDO::FETCH_ASSOC);

    $wins = $losses = $draws = $points = $goals_for = $goals_against = 0;

    foreach ($matches as $m) {
        if ($m['team1_id'] == $team_id) {
            $goals_for += $m['score_team1'];
            $goals_against += $m['score_team2'];
        } else {
            $goals_for += $m['score_team2'];
            $goals_against += $m['score_team1'];
        }

        if ($m['score_team1'] == $m['score_team2']) {
            $draws++;
            $points += 1;
        } elseif ($m['winner_team_id'] == $team_id) {
            $wins++;
            $points += 3;
        } else {
            $losses++;
        }
    }

    $leaderboards[] = [
        'team_name' => $team['name'],
        'wins' => $wins,
        'draws' => $draws,
        'losses' => $losses,
        'points' => $points,
        'goals_for' => $goals_for,
        'goals_against' => $goals_against,
    ];
}

usort($leaderboards, function ($a, $b) {
    if ($a['points'] == $b['points']) {
        return ($b['goals_for'] - $b['goals_against']) <=> ($a['goals_for'] - $a['goals_against']);
    }
    return $b['points'] <=> $a['points'];
});
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <table>
        <tr>
            <th>Positie</th>
            <th>Team</th>
            <th>Punten</th>
        </tr>
        <?php
        $rank = 1;
        foreach ($leaderboards as $row):
            if ($rank > 10) break;
        ?>
            <tr>
                <td><?= $rank++ ?></td>
                <td><?= htmlspecialchars($row['team_name']) ?></td>
                <td><?= htmlspecialchars($row['points']) ?></td>
            </tr>
        <?php endforeach; ?>

    </table>
    <div class="modal fade table table-dark table-striped table-bordered align-middle table-css" id="exampleModalToggle" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalToggleLabel">Team Rank</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body table-responsive">
                    <table class="table table-dark table-striped table-bordered align-middle mb-0 box table-css">
                        <thead>
                            <tr>
                                <th scope="col">Positie</th>
                                <th scope="col">Team</th>
                                <th scope="col">Gewonnen</th>
                                <th scope="col">Gelijk</th>
                                <th scope="col">Verloren</th>
                                <th scope="col">Punten</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $rank = 1;
                            foreach ($leaderboards as $row): ?>
                                <tr>
                                    <td><?= $rank++ ?></td>
                                    <td><?= htmlspecialchars($row['team_name']) ?></td>
                                    <td><?= $row['wins'] ?></td>
                                    <td><?= $row['draws'] ?></td>
                                    <td><?= $row['losses'] ?></td>
                                    <td><b><?= $row['points'] ?></b></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <button class="button" data-bs-target="#exampleModalToggle" data-bs-toggle="modal">Volledig lijst</button>


</body>

</html>
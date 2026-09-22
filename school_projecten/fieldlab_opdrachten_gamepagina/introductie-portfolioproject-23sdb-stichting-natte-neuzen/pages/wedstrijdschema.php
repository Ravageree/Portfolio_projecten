<?php
session_start();
require_once '../php/config.php';
$conn = dbConnect();

if (empty($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Check user role
$stmt = $conn->prepare("SELECT role FROM users WHERE user_id = :id");
$stmt->execute(['id' => $_SESSION['user_id']]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);
$isAdmin = $user && $user['role'] === 'admin';

// Haal alle matches met competitie, teams en game
$sql = "
    SELECT m.*, 
           t1.name AS team1_name,
           t2.name AS team2_name,
           c.name AS competition_name,
           c.game AS competition_game
    FROM matches m
    LEFT JOIN teams t1 ON m.team1_id = t1.team_id
    LEFT JOIN teams t2 ON m.team2_id = t2.team_id
    LEFT JOIN competitions c ON m.competition_id = c.competition_id
    ORDER BY m.scheduled_at ASC
";
$matches = $conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wedstrijdschema</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

</head>

<body>
    <?php include '../php/navbar.php'; ?>

    <div class="container-fluid py-5 text-center">
        <h1 class="mb-4">Wedstrijdschema</h1>

        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="box table-responsive">

                    <?php if ($isAdmin): ?>
                        <a href="match_form.php" class="btn btn-success mb-4">Nieuwe Wedstrijd</a>
                    <?php endif; ?>

                    <?php if (!empty($matches)) { ?>
                        <table class="table table-dark table-striped table-bordered align-middle mb-0 box table-css">
                            <thead class="table-secondary table-dark text-dark">
                                <tr>
                                    <th>Competitie</th>
                                    <th>Game</th>
                                    <th>Team 1</th>
                                    <th>Team 2</th>
                                    <th>Datum & Tijd</th>
                                    <th>Status</th>
                                    <th>Score</th>
                                    <?php if ($isAdmin): ?><th>Acties</th><?php endif; ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($matches as $m): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($m['competition_name']) ?></td>
                                        <td><?= htmlspecialchars($m['competition_game'] ?? '-') ?></td>
                                        <td>
                                            <a href="wedstrijd_detail.php?id=<?= $m['match_id'] ?>" class="text-info text-decoration-none">
                                                <?= htmlspecialchars($m['team1_name']) ?>
                                            </a>
                                        </td>
                                        <td>
                                            <a href="wedstrijd_detail.php?id=<?= $m['match_id'] ?>" class="text-info text-decoration-none">
                                                <?= htmlspecialchars($m['team2_name']) ?>
                                            </a>
                                        </td>
                                        <td><?= date('d-m-Y H:i', strtotime($m['scheduled_at'])) ?></td>
                                        <td><?= ucfirst($m['status']) ?></td>
                                        <td><strong><?= $m['score_team1'] ?> - <?= $m['score_team2'] ?></strong></td>
                                        <?php if ($isAdmin): ?>
                                            <td>
                                                <a href="match_form.php?id=<?= $m['match_id'] ?>" class="btn btn-sm btn-primary">Bewerken</a>
                                                <a href="../php/match_handler.php?delete=<?= $m['match_id'] ?>"
                                                    class="btn btn-sm btn-danger"
                                                    onclick="return confirm('Weet je zeker dat je deze wedstrijd wilt verwijderen?');">
                                                    Verwijderen
                                                </a>
                                            </td>
                                        <?php endif; ?>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php } else { ?>
                        <p class="text-light mb-0">
                            Er zijn momenteel geen wedstrijden gepland.
                            <?php if ($isAdmin): ?>
                                <a href="match_form.php" class="text-info text-decoration-none">Klik hier</a> om een nieuwe wedstrijd toe te voegen.
                            <?php endif; ?>
                        </p>
                    <?php } ?>

                </div>
            </div>
        </div>
    </div>

    <?php include '../php/footer.php'; ?>
</body>


</html>
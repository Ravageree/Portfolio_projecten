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

if (!$isAdmin) {
    echo "Geen toegang!";
    exit;
}

// Check if editing existing match
$matchId = $_GET['id'] ?? null;
$match = null;
if ($matchId) {
    $stmt = $conn->prepare("SELECT * FROM matches WHERE match_id = :id");
    $stmt->execute(['id' => $matchId]);
    $match = $stmt->fetch(PDO::FETCH_ASSOC);
}

// Haal alle teams op
$teams = $conn->query("SELECT * FROM teams ORDER BY name ASC")->fetchAll(PDO::FETCH_ASSOC);

// Haal alle competities op
$competitions = $conn->query("SELECT * FROM competitions ORDER BY name ASC")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $match ? "Bewerk" : "Nieuwe" ?> Wedstrijd</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</head>

<body>
    <?php include '../php/navbar.php'; ?>

    <div class="container py-5" style="background-color: #242024; color: #F3F4F5; border-radius: 12px; box-shadow: 0 0 15px rgba(0,0,0,0.7); max-width: 700px; margin: 50px auto;">
        <h2 style="color: #ffcc00; text-align: center; margin-bottom: 30px;"><?= $match ? "Bewerk" : "Nieuwe" ?> Wedstrijd</h2>
        <form action="../php/match_handler.php" method="POST">
            <?php if ($match): ?>
                <input type="hidden" name="match_id" value="<?= $match['match_id'] ?>">
            <?php endif; ?>

            <div class="mb-3">
                <label for="competition_id" class="form-label">Competitie</label>
                <select name="competition_id" id="competition_id" class="form-select" required
                    style="">
                    <option value="">Selecteer een competitie</option>
                    <?php foreach ($competitions as $c): ?>
                        <option value="<?= $c['competition_id'] ?>"
                            <?= $match && $match['competition_id'] == $c['competition_id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($c['name']) ?> (<?= htmlspecialchars($c['game'] ?? 'Niet gespecificeerd') ?>)
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-3">
                <label for="team1_id" class="form-label">Team 1</label>
                <select name="team1_id" id="team1_id" class="form-select" required
                    style="">
                    <option value="">Selecteer team 1</option>
                    <?php foreach ($teams as $t): ?>
                        <option value="<?= $t['team_id'] ?>"
                            <?= $match && $match['team1_id'] == $t['team_id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($t['name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-3">
                <label for="team2_id" class="form-label">Team 2</label>
                <select name="team2_id" id="team2_id" class="form-select" required
                    style="">
                    <option value="">Selecteer team 2</option>
                    <?php foreach ($teams as $t): ?>
                        <option value="<?= $t['team_id'] ?>"
                            <?= $match && $match['team2_id'] == $t['team_id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($t['name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-3">
                <label for="scheduled_at" class="form-label">Datum & Tijd</label>
                <input type="datetime-local" name="scheduled_at" id="scheduled_at" class="form-control"
                    value="<?= $match ? date('Y-m-d\TH:i', strtotime($match['scheduled_at'])) : '' ?>"
                    required
                    style="">
            </div>

            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select name="status" id="status" class="form-select"
                    style="">
                    <option value="scheduled" <?= $match && $match['status'] == 'scheduled' ? 'selected' : '' ?>>Scheduled</option>
                    <option value="completed" <?= $match && $match['status'] == 'completed' ? 'selected' : '' ?>>Completed</option>
                    <option value="confirmed" <?= $match && $match['status'] == 'confirmed' ? 'selected' : '' ?>>Confirmed</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="score_team1" class="form-label">Score Team 1</label>
                <input type="number" name="score_team1" id="score_team1" class="form-control"
                    value="<?= $match['score_team1'] ?? 0 ?>"
                    style="">
            </div>

            <div class="mb-3">
                <label for="score_team2" class="form-label">Score Team 2</label>
                <input type="number" name="score_team2" id="score_team2" class="form-control"
                    value="<?= $match['score_team2'] ?? 0 ?>"
                    style="">
            </div>

            <button type="submit" class="btn btn-primary"><?= $match ? "Bewerken" : "Toevoegen" ?> Wedstrijd</button>
            <a href="wedstrijdschema.php" class="btn btn-secondary">Annuleren</a>
        </form>
    </div>


    <?php include '../php/footer.php'; ?>
</body>

</html>
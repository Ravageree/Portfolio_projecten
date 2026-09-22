<?php
session_start();
if (empty($_SESSION['user_id'])) {
    header("Location: landing_page.php");
    exit;
}

require_once '../php/config.php';
$conn = dbConnect();

$userId = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT * FROM teams WHERE created_by = :user_id");
$stmt->bindParam(':user_id', $userId);
$stmt->execute();
$userHasTeam = $stmt->rowCount() > 0;
?>
<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Team aanmaken</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</head>

<body>
    <?php include '../php/navbar.php'; ?>

    <div class="container mt-5" style="max-width: 500px;">
        <h2>Team aanmaken</h2>

        <?php if (!empty($_GET['error'])): ?>
            <div class="alert alert-danger"><?php echo htmlspecialchars($_GET['error']); ?></div>
        <?php endif; ?>

        <?php if ($userHasTeam): ?>
            <div class="alert alert-info">
                Je hebt al een team aangemaakt. Je kunt maar één team beheren.
            </div>
        <?php else: ?>
            <form method="POST" action="../php/register_team.php">
                <div class="mb-3">
                    <label>Teamnaam <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="team_name" maxlength="16" required>
                </div>
                <div class="mb-3">
                    <label>Beschrijving <span class="text-danger">*</span></label>
                    <textarea class="form-control" name="team_description" maxlength="128" required></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Team registreren</button>
            </form>
        <?php endif; ?>
    </div>

    <?php include '../php/footer.php'; ?>
</body>

</html>
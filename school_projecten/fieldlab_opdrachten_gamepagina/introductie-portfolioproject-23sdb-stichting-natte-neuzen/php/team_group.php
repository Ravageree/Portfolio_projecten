<?php
require_once 'config.php';
$pdo = dbConnect();

$user_id = $_SESSION['user_id'] ?? null;

if (!$user_id) {
    echo "Je moet ingelogd zijn.";
    exit;
}

$stmt = $pdo->prepare("SELECT team_id FROM team_members WHERE user_id = :user_id LIMIT 1");
$stmt->execute(['user_id' => $user_id]);
$team_id = $stmt->fetchColumn();

if (!$team_id) {
    echo "Je zit niet in een team.";
    exit;
}

$sql = "
    SELECT 
        u.username,
        tm.role,
        t.name AS team_name
    FROM team_members tm
    INNER JOIN users u ON tm.user_id = u.user_id
    INNER JOIN teams t ON tm.team_id = t.team_id
    WHERE tm.team_id = :team_id
    ORDER BY u.username
";
$stmt = $pdo->prepare($sql);
$stmt->execute(['team_id' => $team_id]);
$members = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>


<?php if ($members): ?>
    <div class="container-fluid py-5 text-center">
        <h1>Team: <?php echo htmlspecialchars($members[0]['team_name']); ?></h1>
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="box">
                    <table class="table table-dark table-striped table-bordered align-middle mb-0 box table-css">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Gebruikersnaam</th>
                                <th scope="col">Rol</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($members as $index => $row): ?>
                                <tr>
                                    <th scope="row"><?php echo $index + 1; ?></th>
                                    <td><?php echo htmlspecialchars($row['username']); ?></td>
                                    <td><?php echo htmlspecialchars($row['role']); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
<?php else: ?>
    <div class="container text-center py-5">
        <p class="text-light mb-0">
            Je hebt nog geen team. Ga naar
            <a class="text-info" href="../pages/create_team.php">Team aanmaken</a>
            om er één te maken.
        </p>
    </div>
<?php endif; ?>
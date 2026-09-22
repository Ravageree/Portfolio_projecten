<?php
require_once 'config.php';
$conn = dbConnect();


$stmt = $conn->prepare("SELECT t.* FROM teams t INNER JOIN team_members tm ON tm.team_id = t.team_id WHERE tm.user_id = ?");
$stmt->execute([$_SESSION['user_id']]);
$teams = $stmt->fetchAll(pdo::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <div class="container-fluid py-5 text-center">
        <h1 class="mb-4">Team stat</h1>

        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="box table-responsive">
                    <?php if (!empty($teams)) { ?>
                        <table class="table table-dark table-striped table-bordered align-middle mb-0 box table-css">
                            <thead>
                                <tr>
                                    <th>Team_naam</th>
                                    <th>Wins</th>
                                    <th>Verlies</th>
                                    <th>Gelijkspel</th>
                                    <th>Win_ratio</th>
                                    <th>Wedstrijden gespeeld</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($teams as $team) { ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($team['name']); ?></td>
                                        <td><?php echo htmlspecialchars($team['kills'] ?? 'N/A'); ?></td>
                                        <td><?php echo htmlspecialchars($team['deaths'] ?? 'N/A'); ?></td>
                                        <td><?php echo htmlspecialchars($team['assists'] ?? 'N/A'); ?></td>
                                        <td><?php echo htmlspecialchars($team['ratio'] ?? 'N/A'); ?></td>
                                        <td><?php echo htmlspecialchars($team['matches_played'] ?? 'N/A'); ?></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    <?php } else { ?>
                        <p class="text-light mb-0">je hebt geen team ge naar <li><a class="dropdown-item" href="../pages/create_team.php">Team aanmaken</a></li>
                            om een te maken .</p>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</body>


</html>
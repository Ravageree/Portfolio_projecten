<?php
require_once 'config.php';
$conn = dbConnect();


$stmt = $conn->prepare("SELECT * FROM users WHERE user_id = ?");
$stmt->execute([$_SESSION['user_id']]);
$users = $stmt->fetchAll(pdo::FETCH_ASSOC);

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
        <h1 class="mb-4">speler stat</h1>

        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="box table-responsive">
                    <?php if (!empty($users)) { ?>
                        <table class="table table-dark table-striped table-bordered align-middle mb-0 box table-css">
                            <thead>
                                <tr>
                                    <th>Naam</th>
                                    <th>Rol</th>
                                    <th>Kills</th>
                                    <th>Doods</th>
                                    <th>Assists</th>
                                    <th>KDA ratio</th>
                                    <th>westrijd gespeeld</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($users as $user) { ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($user['username']); ?></td>
                                        <td><?php echo htmlspecialchars($user['role']); ?></td>
                                        <td><?php echo htmlspecialchars($user['kills'] ?? 'N/A'); ?></td>
                                        <td><?php echo htmlspecialchars($user['deaths'] ?? 'N/A'); ?></td>
                                        <td><?php echo htmlspecialchars($user['assists'] ?? 'N/A'); ?></td>
                                        <td><?php echo htmlspecialchars($user['ratio'] ?? 'N/A'); ?></td>
                                        <td><?php echo htmlspecialchars($user['matches_played'] ?? 'N/A'); ?></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    <?php } else { ?>
                        <p class="text-light mb-0">Geen gebruikers gevonden.</p>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</body>


</html>
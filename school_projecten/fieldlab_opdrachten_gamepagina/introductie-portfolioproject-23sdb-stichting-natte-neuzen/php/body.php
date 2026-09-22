<?php

require_once 'config.php';

$pdo = dbConnect();

$sql = "SELECT `role` FROM users WHERE user_id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<div class="container-fluid py-3">
    <div class="row">

        <!-- Left Column -->
        <div class="col-md-4 col-sm-6">
            <div class="box team-ranks">
                <h3>Teampositie</h3>
                <br>
                <p><?php include '../php/ranglijst_functie.php'; ?></p>
            </div>

        </div>

        <!-- Middle Column -->
        <div class="col-md-4 col-sm-6">
            <div class="box extra-info" role="button" tabindex="0"
                onclick="location.href='wedstrijdschema.php';"
                onkeypress="if(event.key === 'Enter' || event.key === ' ') location.href='wedstrijdschema.php';">
                <h3> Wedstrijdschema</h3>
                <h6>Klik hier</h6>
            </div>
        </div>

        <!-- Right Column (Chat) -->


        <div class="col-md-4 col-sm-12">
            <div class="box chat-box">
                <h3>Vriendenlijst</h3>
                <?php if (empty($friends)): ?>
                    <p>Je hebt nog geen vrienden.</p>
                <?php else: ?>
                    <ul>
                        <?php foreach ($friends as $friend): ?>
                            <li>
                                <a href="chat.php?friend_id=<?= $friend['user_id']; ?>">
                                    <?= htmlspecialchars($friend['username']); ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php
session_start();

// // Gebruikersnaam ophalen
require '../php/name_display.php';

// // Database connectie
require_once '../php/config.php';

// // Forum functies
require_once '../php/forum_functions.php';


$conn = dbConnect();
$name = display_name($conn);
$teamname = display_teamname($conn);


?>

<!DOCTYPE html>
<html lang="nl">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
<link rel="stylesheet" href="../css/style.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>

<head>
    <meta charset="UTF-8">
    <title>Simpel Forum</title>
    <link rel="stylesheet" href="../css/style.css">
    <style>

    </style>
    <script>
        function toggleForm() {
            const form = document.getElementById("postForm");
            form.style.display = (form.style.display === "block") ? "none" : "block";
        }

        function toggleReact() {
            const form = document.getElementById("postReact");
            form.style.display = (form.style.display === "block") ? "none" : "block";
        }

        function openModal(created_id) {
            document.getElementById(created_id).style.display = "block";
        }

        function closeModal(created_id) {
            document.getElementById(created_id).style.display = "none";
        }
    </script>
</head>

<body>
    <?php include '../php/navbar.php'; ?>
    <div class="container-fluid py-3">
        <div class="row">
            <div class="col-md-2 col-sm-6">
                <div class="box">Team ranks</div>
            </div>
            <div class="col-md-4 col-sm-6">
                <div class="box extra-info">
                    <h2><?php echo $teamname; ?> Forum</h2>

                    <?php
                    $user_id = $_SESSION['user_id'];

                    // Controleer of de gebruiker leader is van een team
                    $stmt = $conn->prepare("SELECT role FROM team_members WHERE user_id = :user_id");
                    $stmt->execute(['user_id' => $user_id]);
                    $user_roles = $stmt->fetchAll(PDO::FETCH_COLUMN);

                    // Controleer of minstens één rol 'leader' is
                    $is_leader = in_array('leader', $user_roles);
                    ?>
                    <?php if ($is_leader): ?>
                    <button onclick="toggleForm()">Nieuw bericht</button>

                    <form id="postForm" method="POST" action="forum.php">
                        <input type="hidden" name="action" value="new_thread">
                        <label for="username"> Naam: <?php echo $name ?> </label>
                        <input type="hidden" name="sender_id" value="<?php echo $name ?>" required>
                        <br>
                        <textarea name="title" required placeholder="Schrijf je bericht..."></textarea><br>
                        <button type="submit">Plaats bericht</button>
                    </form>
                    <?php endif; ?>

                    <h3>Berichten</h3>
                    <?php foreach ($threads as $thread): ?>
                        <div class="post">
                            <?php $datum = new DateTime($thread['created_at']); ?>
                            <p>
                                <strong><?= htmlspecialchars($thread['username']); ?></strong> <br>
                                <?= htmlspecialchars($thread['title']); ?><br>
                                <small>Geplaatst op: <?= $datum->format('d-m-Y'); ?></small>
                            </p>
                            <button onclick="openModal('modal-<?= $thread['thread_id']; ?>')">Bekijk & Reageer</button>
                            <hr>
                        </div>

                        <!-- Modal voor deze thread -->
                        <div id="modal-<?= $thread['thread_id']; ?>" class="modal">
                            <div class="modal-content">
                                <span class="close" onclick="closeModal('modal-<?= $thread['thread_id']; ?>')">&times;</span>

                                <h3><?= htmlspecialchars($thread['title']); ?></h3>
                                <p><strong>Gestart door <?= htmlspecialchars($thread['username']); ?></strong></p>

                                <h4>Berichten</h4>
                                <?php
                                $stmtPosts = $conn->prepare("SELECT forum_posts.*, users.username 
                        FROM forum_posts
                        JOIN users ON forum_posts.user_id = users.user_id
                        WHERE forum_posts.thread_id = :thread_id
                        ORDER BY forum_posts.created_at ASC");
                                $stmtPosts->execute(['thread_id' => $thread['thread_id']]);
                                $posts = $stmtPosts->fetchAll(PDO::FETCH_ASSOC);
                                ?>

                                <?php if ($posts): ?>
                                    <?php foreach ($posts as $p): ?>
                                        <div style="border-bottom:1px solid #eee; padding:5px 0;">
                                            <strong><?= htmlspecialchars($p['username']); ?>:</strong>
                                            <p><?= nl2br(htmlspecialchars($p['content'])); ?></p>
                                            <small><?= (new DateTime($p['created_at']))->format('d-m-Y H:i'); ?></small>
                                        </div>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <p><em>Nog geen berichten in deze thread...</em></p>
                                <?php endif; ?>

                                <button onclick="toggleReact()">Reageer</button>

                                <form id="postReact" method="POST" action="forum.php">
                                    <input type="hidden" name="action" value="new_reply">
                                    <label for="username"> Naam: <?php echo $name ?> </label>
                                    <input type="hidden" name="sender_id" value="<?php echo $name ?>" required>
                                    <input type="hidden" name="thread_id" value="<?= $thread['thread_id']; ?>">
                                    <br>
                                    <textarea name="content" required placeholder="Schrijf je reactie..."></textarea><br>
                                    <button type="submit">Plaats bericht</button>
                                </form>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="col-md-6 col-sm-12">
                <div class="box chat-box">Team chat
                    <div></div>
                </div>
            </div>
        </div>
    </div>
    <?php include '../php/footer.php'; ?>
</body>
<?php
// Notificaties tonen na acties
if (isset($_GET['accepted'])) {
    echo "<script>showFriendNotification('Vriendschap geaccepteerd 🎉','Je bent nu vrienden!','success');</script>";
} elseif (isset($_GET['removed'])) {
    echo "<script>showFriendNotification('Verzoek geweigerd ❌','Het verzoek is verwijderd.','error');</script>";
}
?>

</html>
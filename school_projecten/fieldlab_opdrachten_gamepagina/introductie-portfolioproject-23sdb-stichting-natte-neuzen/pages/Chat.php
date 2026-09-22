<?php
session_start();
require_once '../php/config.php';
require_once '../php/chat_functions.php';
require_once '../php/friend_functions.php';

// Controleer of gebruiker is ingelogd
if (!isset($_SESSION['user_id'])) {
    header('Location: login_page.php');
    exit();
}

$user1_id = $_SESSION['user_id'];
$current_friend = isset($_GET['friend_id']) ? intval($_GET['friend_id']) : null;

// Bericht versturen
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['message']) && !empty(trim($_POST['message'])) && isset($_POST['friend_id'])) {
    send_message($user1_id, intval($_POST['friend_id']), trim($_POST['message']));

    header("Location: chat.php?friend_id={$friend_id}&sent=1");
    exit();
}

// Vriendenlijst ophalen
$friends = get_friends($conn, $user1_id);

// Berichten ophalen
$messages = $current_friend ? get_messages($user1_id, $current_friend) : [];
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Playerchat</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

    <style>
        .chat-messages {
            max-height: 500px;
            overflow-y: auto;
            background: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
        }
        .message {
            margin-bottom: 10px;
            padding: 8px 12px;
            border-radius: 10px;
            max-width: 80%;
        }
        .message.sent {
            background: #a41b0b;
            color: white;
            margin-left: auto;
            text-align: right;
        }
        .message.received {
            background: #2d1106;
            text-align: left;
        }
        textarea {
            width: 100%;
            border-radius: 5px;
            border: 1px solid #ccc;
            resize: none;
            padding: 8px;
        }
        .chat-container {
            display: flex;
            gap: 2rem;
        }
        .chat-list {
            flex: 1;
            min-width: 200px;
        }
        .chat-box {
            flex: 2.5;
        }
    </style>
</head>

<body>
<?php include '../php/navbar.php'; ?>

<div class="container-fluid py-3">
    <div class="chat-container">

        <!-- Friendlist -->
        <div class="box chat-list">
            <h4>Chatlijst</h4>
            <?php if (empty($friends)): ?>
                <p>Je hebt nog geen vrienden.</p>
            <?php else: ?>
                <ul class="list-unstyled">
                    <?php foreach ($friends as $friend): ?>
                        <li>
                            <a href="chat.php?friend_id=<?= $friend['user_id']; ?>" 
                               class="<?= $current_friend == $friend['user_id'] ? 'fw-bold text-primary' : '' ?>">
                               <?= htmlspecialchars($friend['username']); ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </div>

        <!-- Chatbox -->
        <div class="box chat-box">
            <h2>Chat</h2>

            <?php if (!$current_friend): ?>
                <p>Kies iemand uit je vriendenlijst om te chatten.</p>
            <?php else: ?>
                <div class="chat-messages" id="chatMessages">
                    <?php if (empty($messages)): ?>
                        <p>Nog geen berichten met deze vriend.</p>
                    <?php else: ?>
                        <?php foreach ($messages as $msg): ?>
                            <div class="message <?= $msg['sender_id'] == $user1_id ? 'sent' : 'received'; ?>">
                                <strong><?= htmlspecialchars($msg['username']); ?>:</strong><br>
                                <?= nl2br(htmlspecialchars($msg['content'])); ?><br>
                                <small><em><?= htmlspecialchars($msg['sent_at']); ?></em></small>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>

                <form method="POST" class="mt-3">
                    <input type="hidden" name="friend_id" value="<?= $current_friend; ?>">
                    <textarea name="message" placeholder="Typ een bericht..." rows="3" required></textarea>
                    <button type="submit" class="btn btn-primary w-100 mt-2">Verstuur</button>
                </form>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include '../php/footer.php'; ?>

<script>
    // Scroll automatisch naar beneden als er berichten zijn
    document.addEventListener("DOMContentLoaded", () => {
        const chatBox = document.getElementById('chatMessages');
        if (chatBox) {
            chatBox.scrollTop = chatBox.scrollHeight;
        }
    });
</script>

<?php
if (isset($_GET['accepted'])) {
    echo "<script>showFriendNotification('Vriendschap geaccepteerd 🎉','Je bent nu vrienden!','success');</script>";
} elseif (isset($_GET['removed'])) {
    echo "<script>showFriendNotification('Verzoek geweigerd ❌','Het verzoek is verwijderd.','error');</script>";
}
?>
</body>
</html>

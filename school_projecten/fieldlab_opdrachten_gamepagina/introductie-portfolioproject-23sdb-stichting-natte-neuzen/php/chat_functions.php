<?php
require_once 'config.php';
$conn = dbConnect();

function get_messages($user1_id, $user2_id) {
    global $conn;
    $stmt = $conn->prepare("
        SELECT m.*, u.username 
        FROM messages m
        JOIN users u ON u.user_id = m.sender_id
        WHERE (m.sender_id = :user1 AND m.receiver_id = :user2)
           OR (m.sender_id = :user2 AND m.receiver_id = :user1)
        ORDER BY m.sent_at ASC
    ");
    $stmt->execute([
        ':user1' => $user1_id,
        ':user2' => $user2_id
    ]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function send_message($sender_id, $receiver_id, $content) {
    global $conn;

    $check = $conn->prepare("
        SELECT 1 FROM friends 
        WHERE user_id = :sender AND friend_id = :receiver AND status = 'accepted'
    ");
    $check->execute([':sender' => $sender_id, ':receiver' => $receiver_id]);

    if ($check->rowCount() === 0) {
        return false;
    }

    $stmt = $conn->prepare("
        INSERT INTO messages (sender_id, receiver_id, content)
        VALUES (:sender, :receiver, :content)
    ");
    return $stmt->execute([
        ':sender' => $sender_id,
        ':receiver' => $receiver_id,
        ':content' => $content
    ]);
}
?>

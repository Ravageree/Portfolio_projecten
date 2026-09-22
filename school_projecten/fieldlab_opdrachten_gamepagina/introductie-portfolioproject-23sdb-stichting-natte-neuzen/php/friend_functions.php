<?php
require_once __DIR__ . '/config.php';

$conn = dbConnect();

function get_friends($conn, $user_id): array {
    $stmt = $conn->prepare("
        SELECT u.user_id, u.username, u.name 
        FROM friends f
        JOIN users u ON u.user_id = f.friend_id
        WHERE f.user_id = ? AND f.status = 'accepted'
    ");
    $stmt->execute([$user_id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function handle_friend_actions($conn, $user_id): void {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['add_friend'])) {
            $friend_id = (int)$_POST['friend_id'];
            send_friend_request($conn, $user_id, $friend_id);
        }

        if (isset($_POST['accept_request'])) {
            $friend_id = (int)$_POST['friend_id'];
            accept_friend_request($conn, $user_id, $friend_id);
            header("Location: .../pages/friends.php");
            exit;
        }

        if (isset($_POST['remove_friend'])) {
            $friend_id = (int)$_POST['friend_id'];
            remove_friend($conn, $user_id, $friend_id);
            header("Location: friends.php?removed=1");
            exit;
        }
    }
}

function send_friend_request($conn, $user_id, $friend_id): void {
    $stmt = $conn->prepare("
        INSERT IGNORE INTO friends (user_id, friend_id, status) 
        VALUES (?, ?, 'pending')
    ");
    $stmt->execute([$user_id, $friend_id]);
}

function accept_friend_request($conn, $user_id, $friend_id): void {
    $stmt = $conn->prepare("
        UPDATE friends 
        SET status = 'accepted' 
        WHERE user_id = ? AND friend_id = ?
    ");
    $stmt->execute([$friend_id, $user_id]);

    $stmt2 = $conn->prepare("
        INSERT INTO friends (user_id, friend_id, status) 
        VALUES (?, ?, 'accepted')
    ");
    $stmt2->execute([$user_id, $friend_id]);
}

function remove_friend($conn, $user_id, $friend_id): void {
    $stmt = $conn->prepare("
        DELETE FROM friends 
        WHERE (user_id = ? AND friend_id = ?) 
           OR (user_id = ? AND friend_id = ?)
    ");
    $stmt->execute([$user_id, $friend_id, $friend_id, $user_id]);
}

function get_friends_list($conn, $user_id): array {
    $stmt = $conn->prepare("
        SELECT u.user_id, u.username 
        FROM friends f 
        JOIN users u ON f.friend_id = u.user_id 
        WHERE f.user_id = ? AND f.status = 'accepted'
    ");
    $stmt->execute([$user_id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function get_pending_requests($conn, $user_id): array {
    $stmt = $conn->prepare("
        SELECT u.user_id, u.username 
        FROM friends f 
        JOIN users u ON f.user_id = u.user_id 
        WHERE f.friend_id = ? AND f.status = 'pending'
    ");
    $stmt->execute([$user_id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function search_users($conn, $user_id, $term): array {
    $term = "%$term%";

    $stmt = $conn->prepare("
        SELECT friend_id FROM friends WHERE user_id = ?
        UNION
        SELECT user_id FROM friends WHERE friend_id = ?
    ");
    $stmt->execute([$user_id, $user_id]);
    $excluded = $stmt->fetchAll(PDO::FETCH_COLUMN);

    $excluded[] = $user_id;

    $placeholders = str_repeat('?,', count($excluded) - 1) . '?';

    $sql = "
        SELECT user_id, username, name
        FROM users
        WHERE (username LIKE ? OR name LIKE ?)
        AND user_id NOT IN ($placeholders)
        LIMIT 20
    ";

    $stmt2 = $conn->prepare($sql);
    $params = array_merge([$term, $term], $excluded);
    $stmt2->execute($params);

    return $stmt2->fetchAll(PDO::FETCH_ASSOC);
}
?>

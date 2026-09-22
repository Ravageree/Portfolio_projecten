<?php
require_once __DIR__ . '/config.php';
$conn = dbConnect();

function send_team_invite($conn, $team_id, $sender_id, $receiver_id) {
    $stmt = $conn->prepare("
        INSERT INTO team_invites (team_id, sender_id, receiver_id, status)
        VALUES (?, ?, ?, 'pending')
    ");
    $stmt->execute([$team_id, $sender_id, $receiver_id]);
}

function accept_team_invite($conn, $invite_id, $receiver_id) {
    $stmt = $conn->prepare("
        UPDATE team_invites
        SET status = 'accepted'
        WHERE invite_id = ? AND receiver_id = ?
    ");
    $stmt->execute([$invite_id, $receiver_id]);

    $stmt2 = $conn->prepare("
        INSERT IGNORE INTO team_members (team_id, user_id, role)
        SELECT team_id, receiver_id, 'member'
        FROM team_invites
        WHERE invite_id = ?
    ");
    $stmt2->execute([$invite_id]);
}


function reject_team_invite($conn, $invite_id, $receiver_id) {
    $stmt = $conn->prepare("
        UPDATE team_invites
        SET status = 'rejected'
        WHERE invite_id = ? AND receiver_id = ?
    ");
    $stmt->execute([$invite_id, $receiver_id]);
}

function get_pending_team_invites($conn, $user_id): array {
    $stmt = $conn->prepare("
        SELECT ti.invite_id, t.name AS team_name, u.username AS sender_name
        FROM team_invites ti
        JOIN teams t ON ti.team_id = t.team_id
        JOIN users u ON ti.sender_id = u.user_id
        WHERE ti.receiver_id = ? AND ti.status = 'pending'
    ");
    $stmt->execute([$user_id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>

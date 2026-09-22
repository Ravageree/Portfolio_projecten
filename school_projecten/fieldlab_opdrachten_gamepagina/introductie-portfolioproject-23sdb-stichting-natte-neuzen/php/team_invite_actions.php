<?php
session_start();
require_once 'config.php';
require_once 'team_invite_functions.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'error' => 'Niet ingelogd']);
    exit;
}

$user_id = $_SESSION['user_id'];
$action = $_POST['action'] ?? '';
$invite_id = (int)($_POST['invite_id'] ?? 0);
$receiver_id = (int)($_POST['receiver_id'] ?? 0);
$team_id = (int)($_POST['team_id'] ?? 0);

switch ($action) {
    case 'send':
        send_team_invite($conn, $team_id, $user_id, $receiver_id);
        echo json_encode(['success' => true, 'message' => 'Uitnodiging verzonden!']);
        break;

    case 'accept':
        accept_team_invite($conn, $invite_id, $user_id);
        echo json_encode(['success' => true, 'message' => 'Uitnodiging geaccepteerd!']);
        break;

    case 'reject':
        reject_team_invite($conn, $invite_id, $user_id);
        echo json_encode(['success' => true, 'message' => 'Uitnodiging geweigerd.']);
        break;

    default:
        echo json_encode(['success' => false, 'error' => 'Onbekende actie']);
}
?>

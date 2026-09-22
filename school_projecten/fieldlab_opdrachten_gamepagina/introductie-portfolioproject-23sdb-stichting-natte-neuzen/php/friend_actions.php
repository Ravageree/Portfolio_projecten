<?php
session_start();
require_once 'config.php';
require_once 'friend_functions.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'error' => 'Niet ingelogd']);
    exit;
}

$conn = dbConnect();
$user_id = $_SESSION['user_id'];

$action = $_POST['action'] ?? '';
$friend_id = (int)($_POST['friend_id'] ?? 0);

if (!$action || !$friend_id) {
    echo json_encode(['success' => false, 'error' => 'Ongeldige parameters']);
    exit;
}

switch ($action) {
    case 'add':
        send_friend_request($conn, $user_id, $friend_id);
        echo json_encode(['success' => true, 'message' => 'Vriendschapsverzoek verzonden!']);
        exit;

    case 'accept':
        accept_friend_request($conn, $user_id, $friend_id);
        echo json_encode(['success' => true, 'message' => 'Vriendschap geaccepteerd!']);
        exit;

    case 'remove':
        remove_friend($conn, $user_id, $friend_id);
        echo json_encode(['success' => true, 'message' => 'Vriendschapsverzoek geweigerd.']);
        exit;

    default:
        echo json_encode(['success' => false, 'error' => 'Onbekende actie']);
        exit;
}
?>
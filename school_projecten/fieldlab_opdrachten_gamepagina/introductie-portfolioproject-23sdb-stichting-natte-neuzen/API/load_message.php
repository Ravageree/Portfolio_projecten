<?php
session_start();
require 'chat_functions.php';

$friend_id = intval($_GET['friend_id']);
$messages = get_messages($_SESSION['user_id'], $friend_id);
echo json_encode($messages);
?>

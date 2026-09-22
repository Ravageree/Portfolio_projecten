<?php
session_start();
require 'chat_functions.php';

$data = json_decode(file_get_contents("php://input"), true);
send_message($_SESSION['user_id'], $data['receiver_id'], $data['content']);
?>

<?php
require_once 'config.php';
$conn = dbConnect();


function display_name($conn)
{
    // Voor testdoeleinden, normaal zou dit uit de login komen
    // $id = $_SESSION['user_id'] = 1;
    $id = $_SESSION['user_id'];
    $stmt = $conn->prepare("SELECT username FROM users WHERE user_id = :id");
    $stmt->execute(['id' => $id]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        return $user['username'];
    } else {
        return "Onbekende gebruiker";
    }
}

function display_teamname($conn)
{
    $id = $_SESSION['user_id'];
    $stmt = $conn->prepare("SELECT name FROM teams WHERE created_by = (SELECT user_id FROM users WHERE user_id = :id)");
    $stmt->execute(['id' => $id]);
    $team = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($team) {
        return $team['name'];
    } else {
        return "Geen team";
    }
}

<?php
session_start();
require_once 'config.php';
$conn = dbConnect();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    if (empty($username) || empty($password)) {
        header("Location: ../pages/login_page.php?error=" . urlencode("Vul zowel gebruikersnaam als wachtwoord in."));
        exit;
    }

    $stmt = $conn->prepare("SELECT * FROM users WHERE username = :username");
    $stmt->bindParam(':username', $username);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['username'] = $user['username'];
        header("Location: ../pages/homepage.php");
        exit;
    } else {
        header("Location: ../pages/login_page.php?error=" . urlencode("Ongeldige gebruikersnaam of wachtwoord."));
        exit;
    }
} else {
    header("Location: ../pages/login_page.php");
    exit;
}
?>

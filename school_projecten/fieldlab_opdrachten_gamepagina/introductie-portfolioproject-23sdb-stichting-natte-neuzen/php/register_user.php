<?php
session_start();
require_once 'config.php';
$conn = dbConnect();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST['username']);
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];
    $name = trim($_POST['name']);
    $birth_date = $_POST['birth_date'];

    // Validaties
    if (empty($username) || empty($email) || empty($password) || empty($birth_date)) {
        header("Location: ../pages/register.php?error=" . urlencode("Vul alle verplichte velden in"));
        exit;
    }

    // Extra validatie: gebruikersnaam mag niet alleen uit onzichtbare tekens bestaan
    $cleanUsername = preg_replace('/[\s\x{00A0}\x{200B}-\x{200F}\x{2028}-\x{202F}\x{205F}-\x{206F}\x{FEFF}]/u', '', $username);
    if (empty($cleanUsername)) {
        header("Location: ../pages/register.php?error=" . urlencode("Gebruikersnaam mag niet alleen uit onzichtbare tekens bestaan"));
        exit;
    }

    if (strlen($username) > 16) {
        header("Location: ../pages/register.php?error=" . urlencode("Gebruikersnaam mag maximaal 16 tekens bevatten"));
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location: ../pages/register.php?error=" . urlencode("Ongeldig e-mailadres."));
        exit;
    }

    // Leeftijd berekenen uit geboortedatum
    $birthDateTime = new DateTime($birth_date);
    $now = new DateTime();
    $age = $now->diff($birthDateTime)->y;

    if ($age < 18 || $age > 99) {
        header("Location: ../pages/register.php?error=" . urlencode("Je moet tussen de 18 en 99 jaar oud zijn."));
        exit;
    }

    // Gamevoorkeuren (uit checkboxes)
    $allowedPreferences = [
        "CS:GO",
        "Call of Duty",
        "Battlefield",
        "Overwatch",
        "Rainbow Six Siege",
        "World of Warcraft",
        "League of Legends",
        "Dota 2",
        "Fortnite",
        "Apex Legends",
        "Minecraft",
        "StarCraft II",
        "Age of Empires",
        "Clash of Clans",
        "Civilization VI",
        "Rocket League",
        "Valorant",
        "Among Us",
        "FIFA",
        "PUBG"
    ];

    if (isset($_POST['game_preferences']) && is_array($_POST['game_preferences'])) {
        $filteredPreferences = array_intersect($_POST['game_preferences'], $allowedPreferences);
        $game_preferences = implode(',', $filteredPreferences);
    } else {
        $game_preferences = '';
    }

    // Uniekheid controleren
    $check = $conn->prepare("SELECT * FROM users WHERE username = :username OR email = :email");
    $check->bindParam(':username', $username);
    $check->bindParam(':email', $email);
    $check->execute();

    if ($check->rowCount() > 0) {
        header("Location: ../pages/register.php?error=" . urlencode("Gebruikersnaam of e-mail bestaat al"));
        exit;
    }

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO users (username, email, password, name, birth_date, game_preferences)
                            VALUES (:username, :email, :password, :name, :birth_date, :game_preferences)");

    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':password', $hashedPassword);
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':birth_date', $birth_date);
    $stmt->bindParam(':game_preferences', $game_preferences);

    try {
        $stmt->execute();
        $_SESSION['user_id'] = $conn->lastInsertId();
        $_SESSION['username'] = $username;

        header("Location: ../pages/homepage.php");
        exit;
    } catch (PDOException $e) {
        header("Location: ../pages/register.php?error=" . urlencode("Fout bij registratie: " . $e->getMessage()));
        exit;
    }
}

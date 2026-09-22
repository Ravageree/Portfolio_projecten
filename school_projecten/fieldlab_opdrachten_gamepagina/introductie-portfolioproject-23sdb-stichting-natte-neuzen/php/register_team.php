<?php
session_start();
require_once 'config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../pages/landing_page.php");
    exit;
}

$conn = dbConnect();
$user_id = $_SESSION['user_id'];

// Kijkt of gebruiker al een team heeft
$check = $conn->prepare("SELECT team_id FROM teams WHERE created_by = :user_id");
$check->bindParam(':user_id', $user_id);
$check->execute();

if ($check->rowCount() > 0) {
    header("Location: ../pages/create_team.php?error=" . urlencode("Je hebt al een team aangemaakt."));
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $team_name = trim($_POST['team_name']);
    $team_description = trim($_POST['team_description']);

    if (empty($team_name) || empty($team_description)) {
        header("Location: ../pages/create_team.php?error=" . urlencode("Vul alle verplichte velden in."));
        exit;
    }

    if (strlen($team_name) > 16 || strlen($team_description) > 128) {
        header("Location: ../pages/create_team.php?error=" . urlencode("Teamnaam of beschrijving is te lang."));
        exit;
    }

    // Team aanmaken
    $stmt = $conn->prepare("INSERT INTO teams (name, description, created_by) VALUES (:name, :description, :created_by)");
    $stmt->bindParam(':name', $team_name);
    $stmt->bindParam(':description', $team_description);
    $stmt->bindParam(':created_by', $user_id);
    $stmt->execute();

    $team_id = $conn->lastInsertId();

    // Voeg gebruiker toe als leider
    $stmt = $conn->prepare("INSERT INTO team_members (team_id, user_id, role) VALUES (:team_id, :user_id, 'leader')");
    $stmt->bindParam(':team_id', $team_id);
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute();

    header("Location: ../pages/homepage.php"); // Pas dit pad aan als nodig
    exit;
} else {
    header("Location: ../pages/create_team.php");
    exit;
}
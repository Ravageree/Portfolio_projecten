<?php

if ($_SERVER["REQUEST_METHOD"] === "POST" && $_POST['action'] === "new_thread") {
    if (isset($_SESSION['id'])) {
        $user_id = $_SESSION['id'];
        $bericht = htmlspecialchars($_POST["title"]);
        

        if (!empty($bericht)) {
            $stmt = $conn->prepare("
                INSERT INTO forum_threads (created_by, title) 
                VALUES (:created_by, :title)
            ");
            $stmt->execute([
                'created_by' => $user_id,
                'title' => $bericht
            ]);

            header("Location: forum.php");
            exit;
        }
    } else {
        echo "Je moet ingelogd zijn om een bericht te plaatsen.";
    }
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && $_POST['action'] === "new_reply") {
    $user_id = $_SESSION['id'];
    $thread_id = $_POST['thread_id'];
    $reply = htmlspecialchars($_POST['content']);

    if (!empty($reply)) {
        $stmt = $conn->prepare("
            INSERT INTO forum_posts (thread_id, user_id, content) 
            VALUES (:thread_id, :user_id, :content)
        ");
        $stmt->execute([
            'thread_id' => $thread_id,
            'user_id' => $user_id,
            'content' => $reply
        ]);
    }
}

$user_id = $_SESSION['user_id'];

$stmt = $conn->prepare("SELECT DISTINCT forum_threads.*, users.username, teams.name AS team_name
    FROM forum_threads
    JOIN users ON forum_threads.created_by = users.user_id
    JOIN team_members AS tm_creator ON tm_creator.user_id = users.user_id
    JOIN team_members AS tm_viewer ON tm_viewer.team_id = tm_creator.team_id
    JOIN teams ON teams.team_id = tm_creator.team_id
    WHERE tm_viewer.user_id = :user_id
    ORDER BY forum_threads.created_at DESC
");
$stmt->execute(['user_id' => $user_id]);
$threads = $stmt->fetchAll(PDO::FETCH_ASSOC);


?>
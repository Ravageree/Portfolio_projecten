<?php
require_once 'config.php';
$conn = dbConnect();

function showTable($conn, $tableName, $query = null) {
    echo "<h2>$tableName</h2>";

    if ($query === null) {
        $query = "SELECT * FROM $tableName";
    }

    $stmt = $conn->prepare($query);
    $stmt->execute();
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (count($rows) === 0) {
        echo "<p>strong>$tableName</strong></p>";
        return;
    }

    echo "<table border='1' cellpadding='5' cellspacing='0'>";
    echo "<tr>";
    foreach (array_keys($rows[0]) as $column) {
        echo "<th>$column</th>";
    }
    echo "</tr>";

    foreach ($rows as $row) {
        echo "<tr>";
        foreach ($row as $value) {
            echo "<td>" . htmlspecialchars($value) . "</td>";
        }
        echo "</tr>";
    }

    echo "</table><br>";
}


// Users
showTable($conn, 'users');

// Teams
showTable($conn, 'teams');

// Team Members
showTable($conn, 'team_members');

// Competitions
showTable($conn, 'competitions');

// Matches
showTable($conn, 'matches');

// Messages (met usernames)
showTable($conn, 'messages', "
    SELECT 
        m.message_id,
        m.content,
        m.sent_at,
        sender.username AS sender_name,
        receiver.username AS receiver_name
    FROM messages m
    JOIN users sender ON m.sender_id = sender.user_id
    JOIN users receiver ON m.receiver_id = receiver.user_id
    ORDER BY m.sent_at ASC
");

// Forum Threads (met creator username)
showTable($conn, 'forum_threads', "
    SELECT 
        ft.thread_id,
        ft.title,
        ft.created_at,
        u.username AS creator_name
    FROM forum_threads ft
    JOIN users u ON ft.created_by = u.user_id
    ORDER BY ft.created_at ASC
");

// Forum Posts (met author username)
showTable($conn, 'forum_posts', "
    SELECT 
        fp.post_id,
        fp.thread_id,
        fp.content,
        fp.created_at,
        u.username AS author_name
    FROM forum_posts fp
    JOIN users u ON fp.user_id = u.user_id
    ORDER BY fp.created_at ASC
");

?>

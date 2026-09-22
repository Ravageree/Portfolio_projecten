<?php

function loadReplies($threadID) {
    $conn = dbConnect();
    
    try { 
        // Query to select reactions from specifc threads.
        $sql = "SELECT * FROM posts WHERE thread_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$threadID]);

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if ($result) {
            // Loop through the results and load them in
            foreach ($result as $row) {
                echo "<div>";
                echo "<p><strong>" . htmlspecialchars($row['username']) . ":</strong> " . htmlspecialchars($row['content']) . "</p>";
                echo "</div>";
            }
        } else {
            echo "<p>No replies yet.</p>";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>

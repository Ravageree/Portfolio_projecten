<?php
require_once('config.php');

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Establish database connection
        $conn = dbConnect();

        // Validate required inputs
        if (isset($_POST['thread_id'], $_POST['title'], $_POST['content'])) {
            // Sanitize inputs
            $id = intval($_POST['thread_id']); // Convert to integer for safety
            $newTitle = htmlspecialchars($_POST['title']);
            $newContent = htmlspecialchars($_POST['content']);

            // Update the thread record
            $updateThread = $conn->prepare("UPDATE threads 
                SET title = ?, content = ?
                WHERE thread_id = ?");
            $updateThread->execute([$newTitle, $newContent, $id]);

            // Check if any rows were affected
            if ($updateThread->rowCount() > 0) {
                // Respond with success
                echo json_encode(['success' => true]);
            } else {
                // Respond with error if no rows were updated
                echo json_encode(['error' => 'Thread not found or no changes made']);
            }
        } else {
            // Handle invalid or missing inputs
            echo json_encode(['error' => 'Invalid request: thread_id, title, and content are required']);
        }
    } catch (PDOException $e) {
        // Handle database errors
        echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
    }
} else {
    // Handle non-POST requests
    echo json_encode(['error' => 'Invalid request: POST method required']);
}
?>

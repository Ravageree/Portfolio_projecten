<?php
require_once 'website_php/config.php';

if (isset($_POST['delete'])) {
    // Retrieve thread id from the form.
    $thread_id = $_POST['thread_id'];

    // connect to database.
    $conn = dbConnect();

    try {
        // Start an transaction.
        $conn->beginTransaction();

        // Delete all posts that can refer to this thread.
        $stmt_posts = $conn->prepare("DELETE FROM posts WHERE thread_id = ?");
        $stmt_posts->execute([$thread_id]);

        // Delete the thread itself.
        $stmt_thread = $conn->prepare("DELETE FROM threads WHERE thread_id = ?");
        $stmt_thread->execute([$thread_id]);

        // Commit if the action was succesful.
        $conn->commit();

        echo "Thread and its posts have been successfully deleted.";
        
        // Redirect after the deletion was succesful.
        header("Location: index.php");
        exit;
    } catch (PDOException $e) {
        // Rollback the action if something went wrong.
        $conn->rollBack();

        echo "Error deleting thread: " . $e->getMessage();
    }
}
?>

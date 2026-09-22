<?php
function loadThreads($enumValue)
{
    $conn = dbConnect();

    try {
        // query to select the data from sub table
        $sql = "SELECT * FROM threads WHERE sub = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$enumValue]);

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if ($result) {
            // Loop through the results and load them in
            foreach ($result as $row) {
                echo '<br>';
                echo '<div class="card shadow-lg p-3 mb-5 bg-body-tertiary rounded " style="width: 50rem;">';
                echo '<div class="card-body">';
                echo '<p id="box" class="w-60 p-6 flex-item" id="' . htmlspecialchars($row['title']) . '">';
                echo '<h4 class="card-title">' . htmlspecialchars($row['title']) . '</h4>';
                echo '<br>';
                echo '<h5 class="card-subtitle mb-2 text-body-secondary">' . htmlspecialchars($row['content']) . '</h5>';
                echo '<button class="Add_button btn btn-outline-primary mt-3 mb-4 new-reply" data-thread-id="' . $row['thread_id'] . '">+ Add a Comment</button>';
                echo '<button class="Update_button btn btn-outline-success mt-3 mb-4 ms-4 update-btn" data-thread-id="' . $row['thread_id'] . '">Update</button>';
                echo '<form action="delete_thread.php" method="post">';
                echo '<input type="hidden" name="thread_id" value="' . urlencode($row['thread_id']) . '">';
                echo '<button type="submit" name="delete" class="btn btn-outline-danger mt-3 mb-4 ms-4 Delete_button">Delete</button>';
                echo '</form>';
                include_once 'load_reply.php';
                include 'new_reply.php';
                include 'update_form.php';
                loadReplies($row['thread_id']);
                echo '</p>';
                echo '</div>';
                echo '</div>';
            }
        } else {
            echo "There are no threads available";
        }
        // error handling
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

?>
<script>
document.addEventListener("DOMContentLoaded", function() {
    const updateBtns = document.querySelectorAll('.update-btn');
    const newReplyBtns = document.querySelectorAll('.new-reply');

    updateBtns.forEach(function(updateBtn) {
        updateBtn.addEventListener('click', function(e) {
            e.preventDefault();
            const threadId = this.getAttribute('data-thread-id');
            const updateModal = new bootstrap.Modal(document.getElementById('updateModal' + threadId));
            updateModal.show();
        });
    });

    newReplyBtns.forEach(function(newReplyBtn) {
        newReplyBtn.addEventListener('click', function(e) {
            e.preventDefault();
            const threadId = this.getAttribute('data-thread-id');
            const replyModal = new bootstrap.Modal(document.getElementById('replyModal' + threadId));
            replyModal.show();
        });
    });

    function toggleForm(button, type) {
        // Your existing JavaScript code for toggling forms
    }
});
</script>






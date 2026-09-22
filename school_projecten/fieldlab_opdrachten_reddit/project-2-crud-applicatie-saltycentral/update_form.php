<!-- Modify the form to be displayed within a modal -->
<div class="modal fade" id="updateModal<?= $row['thread_id'] ?>" tabindex="-1" aria-labelledby="updateModalLabel<?= $row['thread_id'] ?>" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form class="thread-form" method="POST" action="update_thread.php">
        <div class="modal-header">
          <h5 class="modal-title" id="updateModalLabel<?= $row['thread_id'] ?>">Update Thread</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <label for="title">Thread Title:</label>
          <input type="text" name="title" id="title" value="<?= htmlspecialchars($row['title']); ?>" required>
          <label for="content">Thread Content:</label>
          <textarea name="content" id="content" rows="4" required><?= htmlspecialchars($row['content']); ?></textarea>
          <input type="hidden" name="thread_id" value="<?= urlencode($row['thread_id']); ?>"> 
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <input type="submit" value="Update Thread" class="btn btn-primary">
        </div>
      </form>
    </div>
  </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const updateForm = document.querySelector('.thread-form');

    updateForm.addEventListener('submit', function(e) {
        e.preventDefault(); // Prevent the default form submission behavior

        const formData = new FormData(this);

        // Send an AJAX request to update_thread.php
        fetch('update_thread.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Redirect to index.php after successful update
                window.location.href = 'index.php';
            } else {
                // Handle errors
                console.error('Error updating thread:', data.error);
                // Optionally, display an error message to the user
                // You can update the UI to show the error message
                // For example, you can display an alert or update a div element with the error message
            }
        })
        .catch(error => {
            console.error('Error:', error);
            // Handle any network errors or exceptions
            // You can display an error message to the user or retry the request
        });
    });
});

</script>

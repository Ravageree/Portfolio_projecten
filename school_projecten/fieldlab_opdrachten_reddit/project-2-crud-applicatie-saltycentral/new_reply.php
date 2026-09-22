<!-- Modify the form to be displayed within a modal -->
<div class="modal fade" id="replyModal<?= $row['thread_id'] ?>" tabindex="-1" aria-labelledby="replyModalLabel<?= $row['thread_id'] ?>" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form class="thread-form" method="POST" action="process_reply.php">
        <div class="modal-header">
          <h5 class="modal-title" id="replyModalLabel<?= $row['thread_id'] ?>">Add a Comment</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <label for="reply_content">Make reply:</label> <!-- Changed ID to match script -->
          <textarea name="reply_content" id="reply_content" rows="4" required></textarea> <!-- Changed name attribute -->
          <input type="hidden" name="thread_id" value="<?= $row['thread_id']; ?>"> <!-- Removed urlencode -->
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <input type="submit" value="Submit Reply" class="btn btn-primary">
        </div>
      </form>
    </div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.thread-form').forEach(function(form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            fetch(this.action, {
                method: this.method,
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                // Check if there is an error in the response
                if (data.error) {
                    // Display the error to the user
                    alert(data.error);
                } else if (data.success) {
                    // Handle success, e.g., redirect or display a success message
                    alert('Reply submitted successfully!');
                    // You may want to redirect the user or update the UI here
                }
            })
            .catch(error => {
                console.error('Error:', error);
                // Handle fetch errors here
                alert('An error occurred while processing your request. Please try again later.');
            });
        });
    });
});
</script>


<?php

function generate_thread_form($SubID)
{
    echo '<div class="sub" id="' . $SubID . '">';
    echo '<form class="thread-form" method="POST" action="process_thread.php">';
    echo '<label for="title">Thread Title:</label>';
    echo '<input type="text" name="title" id="title" required>';
    echo '<label for="content">Thread Content:</label>';
    echo '<textarea name="content" id="content" rows="4" required></textarea>';
    echo '<input type="hidden" name="sub" value="' . $SubID . '">';
    echo '<input type="submit" value="Create Thread" class="btn btn-outline-primary mt-3 mb-4">';
    echo '</form>';
    echo '</div>';
};
?>      
<script>
document.addEventListener("DOMContentLoaded", function() {
    document.querySelector('.thread-form').addEventListener('submit', function(e) {
        e.preventDefault(); // Prevent form submission
        
        var form = this;
        var formData = new FormData(form);

        fetch('process_thread.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                window.location.href = 'index.php'; // Redirect to index page if successful
            } else {
                alert(data.error); // Display error message
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
    });
});

</script>
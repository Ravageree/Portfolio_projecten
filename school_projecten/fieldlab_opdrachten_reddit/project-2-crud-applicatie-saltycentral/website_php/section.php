<link rel="stylesheet" type="text/css" href="styles.css">
<style>
    /* here is where you cannot interackt with the add update and the delete buttons */
    .Delete_button {
        display: none;
    }
    .Add_button {
        display: none;
    }
    .Update_button {
        display: none;
    }
</style>
<?php
require_once('config.php');
// this is going only loading in the admin threads
include 'load_thread.php';
loadThreads("Admin");

?>
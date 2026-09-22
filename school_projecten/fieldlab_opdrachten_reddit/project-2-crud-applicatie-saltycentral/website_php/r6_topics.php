
<link rel="stylesheet" type="text/css" href="styles.css">
 
<?php
// this going to load only the R6 content for the threads and the posts
require_once ('config.php');
include 'new_thread.php';
generate_thread_form("R6");

include 'load_thread.php';
loadThreads("R6")

?>

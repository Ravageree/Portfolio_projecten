
<link rel="stylesheet" type="text/css" href="styles.css">
 
<?php
// this going to load only the COD content for the threads and the posts
require_once ('config.php');
include 'new_thread.php';
generate_thread_form("COD");

include 'load_thread.php';
loadThreads("COD")

?>

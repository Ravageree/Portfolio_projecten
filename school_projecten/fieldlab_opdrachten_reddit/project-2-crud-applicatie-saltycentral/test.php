<?php
require_once 'website_php/config.php';
require_once 'website_php/cookieauth.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="styling/style.css">

</head>
<body>
<?php
$conn = dbConnect();
if ($conn) {
    echo "Database connection successful!<br>";
} else {
    echo "Database connection failed!<br>";
}


$userName = cookieAuth();
if ($userName) {
    echo "User authentication successful!<br>";
    echo "Logged in as: $userName<br>";
} else {
    echo "User authentication failed!<br>";
} 

include 'new_thread.php';
generate_thread_form("R6");   


$sql = "SELECT * FROM threads";
$conn = dbConnect(); 
$result = $conn->query($sql);


if ($result && $result->rowCount() > 0) {
    // Loop door de resultaten en toon de threads
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        echo "<div>";
        echo "<h2>" . htmlspecialchars($row['title']) . "</h2>";
        echo "<p>" . htmlspecialchars($row['content']) . "</p>";
        echo "</div>";
    }
} else {
    echo "Er zijn geen threads beschikbaar.";
}
?>
</body>
</html>
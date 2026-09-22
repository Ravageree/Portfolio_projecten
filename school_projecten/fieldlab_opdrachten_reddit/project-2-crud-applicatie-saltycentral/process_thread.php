<?php
require_once 'website_php/config.php';
require_once 'website_php/cookieauth.php';

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    // Handle the case when the request method is not POST
    http_response_code(405); // Method Not Allowed
    exit('Method Not Allowed');
}

// Get the username out of the cookie-data
$userName = cookieAuth();

$title = $_POST['title'];
$content = $_POST['content'];
$SubID = $_POST['sub'];

// Initialize response array
$response = array();

// Check if the form was filled in correctly
if (empty($title) || empty($content)) {
    $response['error'] = "Please fill in all fields";
} else {
    try {
        // Check for duplicate thread
        $conn = dbConnect();
        $sql = "SELECT COUNT(*) AS count FROM threads WHERE sub = ? AND title = ? AND content = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$SubID, $title, $content]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result['count'] > 0) {
            $response['error'] = "A thread with the same title and content already exists in this sub";
        } else {
            // Insert the thread into the database
            $sql = "INSERT INTO threads (username, sub, title, content, created_at) VALUES (?, ?, ?, ?, NOW())";
            $stmt = $conn->prepare($sql);
            $result = $stmt->execute([$userName, $SubID, $title, $content]);

            // Check if the query was successful
            if ($result) {
                $response['success'] = true;
            } else {
                $response['error'] = "Thread creation failed";
            }
        }
    } catch (PDOException $e) {
        // Handle database errors
        $response['error'] = "Database error: " . $e->getMessage();
    }
}

// Output response as JSON
header('Content-Type: application/json');
echo json_encode($response);
?>

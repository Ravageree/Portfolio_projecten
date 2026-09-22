<?php
require_once 'website_php/config.php';
require_once 'website_php/cookieauth.php';

// Get the username out of the cookie-data
$userName = cookieAuth();

$threadID = $_POST['thread_id'];
$replyContent = $_POST['reply_content'];

// Check if the form was filled in correctly
if (empty($replyContent)) {
    echo json_encode(array("success" => false, "error" => "Please fill in your reply"));
    exit();
}

// Check for duplicate content in the database
$conn = dbConnect();
$sql = "SELECT COUNT(*) AS count FROM posts WHERE thread_id = ? AND content = ?";
$stmt = $conn->prepare($sql);
$stmt->execute([$threadID, $replyContent]);
$result = $stmt->fetch(PDO::FETCH_ASSOC);

if ($result['count'] > 0) {
    echo json_encode(array("success" => false, "error" => "Duplicate reply found"));
    exit();
}

// Insert the reply into the database
$sql = "INSERT INTO posts (thread_id, username, content) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);
$result = $stmt->execute([$threadID, $userName, $replyContent]);

// Prepare JSON response
$response = array();
$response["success"] = $result; // Set success to the result of the database operation
if ($result) {
    header("Refresh:0");
} else {
    $response["error"] = "Reply creation failed";
}

echo json_encode($response);
?>
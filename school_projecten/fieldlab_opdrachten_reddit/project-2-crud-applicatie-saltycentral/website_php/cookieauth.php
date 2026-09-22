<?php

require_once "config.php";

function cookieAuth() {
    if (isset($_COOKIE["userData"])) {
        try {
            $conn = dbConnect();
            $stmt = $conn->prepare('SELECT * FROM users WHERE token = :token');
            $stmt->bindParam(':token', $_COOKIE['userData']);
            $stmt->execute();
            
            // Check if any rows are returned
            if ($stmt->rowCount() > 0) {
                try {
                    $data = $stmt->fetch(PDO::FETCH_ASSOC);
                    return $data['username'];
                } catch (Exception $e) {
                    echo "ERROR: " . $e->getMessage();
                }
            } else {
                // Handle case where no rows are returned
                return null;
            }
            
        } catch (Exception $e) {
            echo 'ERROR: ' .$e->getMessage();
        }
    }
    
    // Return null if cookie is not set
    return null;
}

?>

<?php
require "config.php";

if (isset($_POST['Login'])) {

    $username = $_POST['username'];
    $password = $_POST['password'];
    $conn = dbConnect(); // Establish the database connection

    try {
        $stmt = $conn->prepare('SELECT * FROM users WHERE username = :username AND password=:password');
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $password);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        var_dump($user);
        if ($user) {
            echo "succes";
            $tokenValue = generateCookie();
            // Update the user's cookie value in the database
            $updateStmt = $conn->prepare('UPDATE users SET token = :token WHERE username = :username');
            $updateSuccess = $updateStmt->execute(array(':token' => $tokenValue, ':username' => $username));
            if (!$updateSuccess) {
                throw new Exception("Database update failed.");
            }
            header("Location: ../index.php");
        } else {
            // Invalid username or password
            echo "Invalid username or password";
        }
    } catch (Exception $e) {
        echo 'Error: ' . $e->getMessage();
    }
}

if (isset($_POST['Register'])) {
    logOut();
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Assume dbConnect() function establishes database connection
    $conn = dbConnect();

    try {
        if (strlen($password) < 8)
        {
            echo "Password must be 8 or more characters.";
            exit();
        }
        // Prepare SQL statement for inserting user data
        $stmt = $conn->prepare('INSERT INTO users (username, password) VALUES (:username, :password)');
        
        // Bind parameters
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $password);

        // Execute the statement
        $stmt->execute();

        // Check if insertion was successful
        if ($stmt->rowCount() > 0) {
            echo "Registration successful";
            header("Location: ../index.php");
            // Redirect to login page or any other page as needed
            
        } else {
            echo "Registration failed";
        }
    } catch (Exception $e) {
        echo 'Error: ' . $e->getMessage();
    }
}
?>



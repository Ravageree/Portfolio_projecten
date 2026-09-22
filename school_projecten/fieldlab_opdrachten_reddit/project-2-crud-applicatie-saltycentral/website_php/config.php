<?php
// W: Please dont touch this

// I: logs into the database and returns a connection.
function dbConnect()
{
    $db_username = "bit_academy";
    $db_password = "bit_academy";
    $conn = new PDO('mysql:host=localhost;dbname=saltycentral', $db_username, $db_password);
    return $conn;
}

function generateCookie()
{
    // Password is correct, proceed with login
    // Generate a random cookie value
    $tokenValue = bin2hex(random_bytes(16));

    // Set the cookie
    setcookie('userData', $tokenValue, time() + (86400 * 30), "/");
    return $tokenValue;
}

// I: Checks if the user is still logged in, and if he is he gets logged out
function logOut()
{
    if (isset($_COOKIE['userData'])) {
        try {
            unset($_COOKIE['userData']);
            setcookie('userData', '', time() - 3600, '/'); // I: delete cookie client-side
            header("Refresh:0"); // I: Instantely refreshes after a logout to clear the headers
            return true;
        } catch (Exception $e) {
            echo "ERROR: " . $e->getMessage(); // W: This should never happen
        }
    } else {
        return false;
    }
}

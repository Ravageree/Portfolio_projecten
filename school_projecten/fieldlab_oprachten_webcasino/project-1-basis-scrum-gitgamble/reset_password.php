<?php

session_start();
include 'db.php';
$pdo = dbconnect();

$stmt = $pdo->prepare('SELECT * FROM user WHERE name = :uname');
$stmt->bindParam(':uname', $_SESSION['passwordreset']);
$stmt->execute();
$user = $stmt->fetch();

if (isset($_POST['change'])) {
    $updatestmt = "UPDATE user
    SET password = :password
    WHERE name = :name";

    $stmt = $pdo->prepare($updatestmt);
    $stmt->bindParam(':name', $_SESSION['passwordreset']);
    $stmt->bindParam(':password', $_POST['new_password']);
    
    $stmt->execute();

    header('location: loggin.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/reset_password.css">
    <title>Reset Password</title>
</head>
<body>
    <main>
        <section>
            <div class="reset-password">
                <div class="content">
                    <h1>Reset Password</h1>
                    <form method="post">
                        <div class="form">
                            <div class="inputbox">
                                <input type="password" name="new_password" required>
                                <i>New Password:</i>
                            </div>
                            <div class="inputbox">
                                <input type="submit" name="change" value="Change Password">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </main>
</body>
</html>

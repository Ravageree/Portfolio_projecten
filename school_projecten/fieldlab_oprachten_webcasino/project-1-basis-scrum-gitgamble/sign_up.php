<?php

include 'db.php';
$pdo = dbconnect();

$stmt = $pdo->prepare('SELECT * FROM user');
$stmt->execute();
$user = $stmt->fetchAll();


if (isset($_POST['submits'])) {
    // Validate age requirement
    $birthdate = new DateTime($_POST['age']);
    $today = new DateTime();
    $age = $today->diff($birthdate)->y;

    if ($age < 16) {
        // Display an error message or take appropriate action
        echo "Sorry, you must be 16 or older to sign up.";
    } else {
        // Continue with the database insertion
        $queryadd = 'INSERT INTO user
        (`name`, `username`, `password`, `birthdate`)
        VALUES (:name, :username, :password, :birthdate)';

        $stmt = $pdo->prepare($queryadd);

        $stmt->bindParam(':name', $_POST['name']);
        $stmt->bindParam(':username', $_POST['username']);
        $stmt->bindParam(':password', $_POST['password']);
        $stmt->bindParam(':birthdate', $_POST['age']);

        $stmt->execute();

        header('location: loggin.php');
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/loggin.css">
    <title>Gitgamble</title>
</head>

<body>
    <main>
        <section>
            <?php
            // achtergrond voor de sign up scherm 
            for ($i = 0; $i < 260; $i++) {
                echo "<span></span>";
            }
            ?>

            <div class="signin">
                <div class="content">
                    <h1>Sign in</h1>
                    <form method="post">
                        <div class="form">
                        <div class="inputbox">
                                <input type="text" name="name" required>
                                <i>Name</i>
                            </div>
                            <div class="inputbox">
                                <input type="text" name="username" required>
                                <i>Username</i>
                            </div>
                            <div class="inputbox">
                                <input type="password" name="password" required>
                                <i>Password</i>
                            </div>
                            <div class="inputbox">
                                <input type="date" name="age" required>
                                <i>Age</i>
                            </div>
                            <div class="inputbox">
                                <input type="submit" name="submits" value="Singup">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </main>

</body>

</html>
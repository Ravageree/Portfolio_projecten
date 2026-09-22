<?php

include 'db.php';
$pdo = dbconnect();

session_start();

if (isset($_POST['passwordres'])) {
    $stmt = $pdo->prepare('SELECT id FROM user WHERE name = :name AND birthdate = :birthdate');

    $stmt->bindParam(':name', $_POST['name']);
    $stmt->bindParam(':birthdate', $_POST['birthdate']);

    $stmt->execute();

    $count = $stmt->rowCount();

    if ($count > 0) {
        $stmt->fetch(PDO::FETCH_ASSOC);
        $_SESSION['passwordreset'] = $_POST['name'];
        header('location: reset_password.php');
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

            for ($i = 0; $i < 260; $i++) {
                echo "<span></span>";
            }

            ?>
            <div class="signin">
                <div class="content">
                    <h1>Forgot Password</h1>
                    <form action="forgot_password.php" method="post">
                        <div class="form">
                            <div class="inputbox">
                                <form method="post">
                                    <input type="text" name="name" required>
                                    <i>Username:</i>
                            </div>
                            <div class="inputbox">
                                <input type="date" name="birthdate" required>
                                <i>Birthdate:</i>
                            </div>
                            <div class="inputbox">
                                <input type="submit" name="passwordres" value="Forgot Password">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </main>
</body>

</html>

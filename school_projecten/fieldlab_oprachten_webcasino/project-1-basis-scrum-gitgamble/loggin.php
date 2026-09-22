<?php

session_start();
$username = "bit_academy";
$password = "bit_academy";
try {
    $connect = new PDO("mysql:host=localhost; dbname=webcasino", $username, $password);
    $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    if (isset($_POST["Login"])) {
        if (empty($_POST["name"]) || empty($_POST["password"])) {
            $message = '<label for="username" style="color: red;">All fields are required</label>'; // Issue = doet niks
        } else {
            $query = "SELECT id FROM user WHERE name = :name AND password = :password";
            $statement = $connect->prepare($query);
            $statement->execute(
                array(
                    'name'     =>     $_POST["name"],
                    'password'     =>     $_POST["password"]
                )
            );
            
            $count = $statement->rowCount();
            if ($count > 0) {
                $statement->fetch(PDO::FETCH_ASSOC);
                $_SESSION['loggedinuser'] = $_POST["name"];
                header("location:home.php");
            } else {
                $message = '<label for="username" style="color: red;">Wrong Data</label>'; // Issue = doet niks
            }
        }
    }
} catch (PDOException $error) {
    $message = $error->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/loggin.css">
    <title>gitgamble</title>
</head>
<body>
    <main>
        <section>
            
            <?php

            //hier word een rij gemaakt voor de blockjes op het achtergrond scherm 
            for ($i=0; $i < 260; $i++) { 
                echo "<span></span>";
            }

            ?>

            <div class="signin">
                <div class="content">
                    <h1>Sign in</h1>
                    <form method="post">
                        <div class="form">
                            <div class="inputbox">
                            <input type="text" id="username" name="name" required>
                                <i>Username</i>
                            </div>
                            <div class="inputbox">
                                <input type="password" name="password" required>
                                <i>Password</i>
                            </div>
                            <div class="links">
                                <a href="forgot_password.php">Forgot Password</a>
                                <a href="sign_up.php">Signup</a>
                            </div>
                            <div class="inputbox">
                                <input type="submit" name="Login" value="Login">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </main>
</body>
</html>
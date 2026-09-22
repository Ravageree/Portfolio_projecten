<?php
session_start();
include 'db.php';

$pdo = dbconnect();

$stmt = $pdo->prepare('SELECT * FROM user WHERE id = :uid');

$stmt->bindParam(':uid', $_SESSION['userid']);
$stmt->execute();
$user = $stmt->fetch();

$total1 = $user['score'];
// Controleer of de cookieKlik-knop is ingedrukt
if (isset($_POST['cookieKlik'])) {
    // Controleer of de cookie 'cookie' bestaat
    if (isset($_COOKIE['cookie'])) {
        $aantal_keer_bezogt = $_COOKIE['cookie'] + 1;
    } else {
        $aantal_keer_bezogt = 1;
    }

    // Controleer of 100 keer geklikt is
    if ($aantal_keer_bezogt % 100 === 0) {
        // Verhoog de score met 100
        $total1 += 100;

        // Update de score in de database
        $stmt = $pdo->prepare('UPDATE user SET score = :score WHERE id = :uid');
        $stmt->bindParam(':score', $total1);
        $stmt->bindParam(':uid', $_SESSION['userid']);
        $stmt->execute();
    }

    // Verhoog het aantal keer bezocht en vernieuw de cookie
    setcookie('cookie', $aantal_keer_bezogt, time() + 3600); // De cookie is nu geldig voor 1 uur
}

// het voor bereiden voor nieuwe gegevens, of zet het weer op 0 als de cookie nog niet bestaat
$aantal_keer_bezogt = isset($_COOKIE['cookie']) ? $_COOKIE['cookie'] : 0;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/coockieKlikker.css">
    <title>Cookie Clicker</title>
</head>

<body>
    <main>
        <section id="section">
            <?php
            for ($i = 0; $i < 260; $i++) {
                echo "<span></span>";
            }
            ?>
            <div class="content">
                <p>Welcome to Cookie Clicker!</p>
                <p>Cookies: <?php echo $aantal_keer_bezogt; ?></p>
                <p>Score: <?php echo $total1; ?></p>

                <form action="cookieKlikker.php" method="post">
                    <a href="javascript:void(0);" onclick="document.getElementById('cookieKlik').click();">
                        <img src="img-cookieKlikker/een-cookie-als-thema-real-life-zonder-achtergron-upscaled-fotor-bg-remover-20240202174135.png" alt="cookie">
                    </a>
                    <input type="submit" name="cookieKlik" id="cookieKlik" style="display: none;">
                </form>

                <form action="home.php" method="post">
                    <input type="submit" value="Back to games" id="backknop">
                </form>
            </div>
        </section>
    </main>
</body>

</html>

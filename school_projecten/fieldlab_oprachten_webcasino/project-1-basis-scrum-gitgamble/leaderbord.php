<?php

session_start();

include 'db.php';
$pdo = dbconnect();

if (!isset($_SESSION['loggedinuser'])) {
    header("location:loggin.php");
} else

    $stmt = $pdo->prepare('SELECT * FROM user WHERE name = :uname');
$stmt->bindParam(':uname', $_SESSION['loggedinuser']);
$stmt->execute();
$user = $stmt->fetch();

$stmt = $pdo->prepare('SELECT * FROM user ORDER BY score DESC LIMIT 3');
$stmt->execute();
$leaderboard = $stmt->fetchAll();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/home.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <title>Gitgamble</title>
</head>

<body>
    <header>
    <Div class="profiel_picture">
            <img src="img-page/gitgamble_logo.png" alt="profile_picture" id="logo_foto">
        </Div>
        <Div class="profile">
            <p>Username: <?= $user['username'] ?></p>
            <p>score: <?= $user['score'] ?></p>
        </Div>
        <Div class="logout">
            <a href="loggin.php" class="logout" style="text-decoration: none;">Logout</a>
        </Div>
    </header>
    <nav class="navbar">
        <li class="nav">
            <form action="home.php" method="post">
                <input type="hidden" name="sendingh" value="<?= $user['id'] ?>">
                <input type="submit" name="post" value="Home">
            </form>
        </li>
        <li class="nav">
            <form action="leaderbord.php" method="post">
                <input type="hidden" name="sendingl" value="<?= $user['id'] ?>">
                <input type="submit" name="post" value="Leaderboard">
            </form>
        </li>
        <li class="nav">
            <form action="about_us.php" method="post">
                <input type="hidden" name="sendingabout" value="<?= $user['id'] ?>">
                <input type="submit" name="post" value="About">
            </form>
        </li>
    </nav>
    <main>
        <section id="section">
            <?php

            for ($i = 0; $i < 260; $i++) {
                echo "<span></span>";
            }
            ?>
            <div class="content">
                <div class="games">
                    <div class="players">
                        <div class="player">
                            <p class="Username"><i class="place">1. </i><?= $leaderboard[0]['username'] ?></p>
                            <div class="inner_bar" style="width: <?= $leaderboard[0]['score'] / $leaderboard[0]['score'] * 100 ?>%;"></div>
                            <div class="points">
                                <?= $leaderboard[0]['score'] ?>
                            </div>
                        </div>
                        <div class="player">
                            <p class="Username"><i class="place">2. </i><?= $leaderboard[1]['username'] ?></p>
                            <div class="inner_bar" style="width: <?= $leaderboard[1]['score'] / $leaderboard[0]['score'] * 100 ?>%;"></div>
                            <div class="points">
                                <?= $leaderboard[1]['score'] ?>
                            </div>
                        </div>
                        <div class="player">
                            <p class="Username"><i class="place">3. </i><?= $leaderboard[2]['username'] ?></p>
                            <div class="inner_bar" style="width: <?= $leaderboard[2]['score'] / $leaderboard[0]['score'] * 100 ?>%;"></div>
                            <div class="points">
                                <?= $leaderboard[2]['score'] ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
    <footer>
        <div class="media_links">
            <ul class="footer">
                <li class="item">
                    <a href="https://github.com/horizoncollege/project-1-basis-scrum-gitgamble">
                        <i class="fa-brands fa-github icon"></i>
                    </a>
                </li>
                <li class="item">
                    <a href="https://www.facebook.com/profile.php?id=61555949182134">
                        <i class="fa-brands fa-facebook icon"></i>
                    </a>
                </li>
                <li class="item">
                    <a href="https://www.youtube.com/channel/UCgW7mtUuH5IU3TVeOISUTrw">
                        <i class="fa-brands fa-youtube icon"></i>
                    </a>
                </li>
            </ul>
        </div>
        <div class="namen_van_makers">
            <a href="https://www.linkedin.com/in/thomas-doggen-0a122122b/" class="thomas">Thomas</a>
            <a href="https://www.linkedin.com/in/kevin-lont-29368a296/" class="kevin">Kevin</a>
            <a href="https://www.linkedin.com/in/rafael-fonseca-b686a12b3/" class="rafael">Rafael</a>
            <a href="https://www.linkedin.com/in/isa-hanif/" class="isa">Isa</a>
            <a href="https://www.linkedin.com/in/silvano-douwes-82210a299/" class="silvano">Silvano</a>
            <a href="https://www.linkedin.com/in/sven-borremans-8405a1296/" class="sven">Sven</a>
        </div>
        <div id=main-container>
            <div class="rating-box">
                <input type="radio" id="rating-1" name="rating" hidden>
                <label for="rating-1" class="fas fa-star"></label>

                <input type="radio" id="rating-2" name="rating" hidden>
                <label for="rating-2" class="fas fa-star"></label>

                <input type="radio" id="rating-3" name="rating" hidden>
                <label for="rating-3" class="fas fa-star"></label>

                <input type="radio" id="rating-4" name="rating" hidden>
                <label for="rating-4" class="fas fa-star"></label>

                <input type="radio" id="rating-5" name="rating" hidden>
                <label for="rating-5" class="fas fa-star"></label>
            </div>
            <div class="mening">
                <i>Rate our site:</i>
                <input type="text" name="mening" class="mening_invoer">
                <input type="submit" value="Send" class="mening_invoer">
            </div>
        </div>
        <div class="copyright">
            <p>&copy; 2024 Gitgamble. Alle rechten voorbehouden.</p>
        </div>
    </footer>
</body>

</html>
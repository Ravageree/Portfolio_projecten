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

$_SESSION['userid'] = $user['id'];
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
            <p>Username: <?= $user['username'] ?> </p>
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
                <input type="submit" name="post" id="post" value="Home">
            </form>
        </li>
        <li class="nav">
            <form action="leaderbord.php" method="post">
                <input type="hidden" name="sendingl" value="<?= $user['id'] ?>">
                <input type="submit" name="post" id="post" value="Leaderbord"></form>
        </li>
        <li class="nav">
            <form action="about_us.php" method="post">
                <input type="hidden" name="sendingab" value="<?= $user['id'] ?>">
                <input type="submit" name="post" id="post" value="About">
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
                    <h1 class="titlegames">Games</h1>
                    <div class="container">
                        <div class="parent" id="card1">
                            <div class="card">
                                <div class="content-box">
                                    <h1 class="card-title">Slotmachine</h1>
                                    <p class="card-content">Dream big and aim for the jackpot! Our slot machine boasts enticing jackpot opportunities that can turn every spin into a life-changing moment.</p>
                                    <form action="slotmachine.php" method="post">
                                        <input type="hidden" name="pslot" value="<?= $user['id'] ?>">
                                        <input type="submit" name="post" value="Start game">
                                    </form>
                                </div>
                                <div class="date-box">
                                    <i class="date">&#x1F3B0;</i>
                                </div>
                            </div>
                        </div>
                        <div class="parent" id="card2">
                            <div class="card">
                                <div class="content-box">
                                    <h1 class="card-title">Coin flip</h1>
                                    <p class="card-content"> where a simple flip can turn your luck around! Are you ready to take the chance and see where fortune lands?</p>
                                    <form action="coinflip.php" method="post" class="see-more">
                                        <input type="hidden" name="pslot" value="<?= $user['id'] ?>">
                                        <input type="submit" name="post" value="Start game">
                                    </form>
                                </div>
                                <div class="date-box">
                                    <i class="date">&#x1FA99;</i>
                                </div>
                            </div>
                        </div>
                        <div class="parent" id="card3">
                            <div class="card">
                                <div class="content-box">
                                    <h1 class="card-title">Cookie Clicker</h1>
                                    <p class="card-content">Unlock the sweet secrets of Cookie Clicker with our exclusive quiz! Discover the irresistible allure of clicking your way to fortune in this addictive casino game. Are you ready to indulge in the ultimate cookie-clicking challenge?</p>
                                    <form action="cookieKlikker.php" method="post" class="see-more">
                                        <input type="hidden" name="pcookie" value="<?= $user['id'] ?>">
                                        <input type="submit" name="post" value="Start game">
                                    </form>
                                </div>
                                <div class="date-box">
                                    <i class="date">&#x1f36a;</i>
                                </div>
                            </div>
                        </div>
                        <div class="parent" id="card4">
                            <div class="card">
                                <div class="content-box">
                                    <h1 class="card-title">Rock Paper Scissors</h1>
                                    <p class="card-content">Join the millions of players worldwide who have succumbed to the addictive charm of Rock, Paper, Scissors. Whether you're vying for bragging rights or simply seeking a thrilling diversion, this game promises endless fun and excitement for all.</p>
                                    <form action="rockpaperscissors.php" method="post" class="see-more">
                                        <input type="hidden" name="pspin" value="<?= $user['id'] ?>">
                                        <input type="submit" name="post" value="Start game">
                                    </form>
                                </div>
                                <div class="date-box">
                                    <i class="date">&#x2702;&#xFE0F;</i>
                                </div>
                            </div>
                        </div>
                        <div class="parent" id="card5">
                            <div class="card">
                                <div class="content-box">
                                    <h1 class="card-title">Hangman</h1>
                                    <p class="card-content">Climb the leaderboard and showcase your mastery of words. With each victorious round, earn money and bragging rights as you become the Galgje champion among your peers.</p>
                                    <form action="galgje.php" method="post" class="see-more">
                                        <input type="hidden" name="pgalg" value="<?= $user['id'] ?>">
                                        <input type="submit" name="post" value="Start game">
                                    </form>
                                </div>
                                <div class="date-box">
                                    <i class="date">&#x1F9CD;&#x200D;&#x2642;&#xFE0F;</i>
                                </div>
                            </div>
                        </div>
                        <div class="parent" id="card6">
                            <div class="card">
                                <div class="content-box">
                                    <h1 class="card-title">Noughts And Crosses</h1>
                                    <p class="card-content">Experience the timeless thrill of Noughts and Crosses at our casino. Will you outsmart your opponent or succumb to their strategy?</p>
                                    <form action="boter-kaas-eieren.php" method="post" class="see-more">
                                        <input type="hidden" name="pauto" value="<?= $user['id'] ?>">
                                        <input type="submit" name="post" value="Start game">
                                    </form>
                                </div>
                                <div class="date-box">
                                    <i class="date">&#x274c;</i>
                                </div>
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

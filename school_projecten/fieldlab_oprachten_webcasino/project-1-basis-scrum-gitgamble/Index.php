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
        <Div class="login">
            <a href="loggin.php" class="login" style="text-decoration: none;">Login</a>
        </Div>
    </header>
    <nav>
        <li class="nav"><a href="index.php">Home</a></li>
        <li class="nav"><a href="about.php">About</a></li>
        <li class="nav"><a href="contact.php">Contact</a></li>
    </nav>
    <main>
        <section id="section">
            <?php
            for ($i = 0; $i < 260; $i++) {
                echo "<span></span>";
            }
            ?>
            <div class="content">
                <section class="info">
                    <h1>The Games</h1>
                    <h3 class="about">Slotmachine</h3>
                    <p class="about">Welcome to an electrifying world of excitement and chance! Our state-of-the-art slot machine is designed to whisk you away on a thrilling adventure, where luck and entertainment collide. Here's what makes our slot machine an irresistible choice</p>
                    <h3 class="about">Coin flip</h3>
                    <p class="about">Embark on a thrilling journey with our exhilarating coin flip game! Picture the suspense as a shiny coin hovers in the air, teetering on the edge of destiny. Will it be heads or tails? Every flip is a moment of anticipation, a chance for fortune to smile upon you. Immerse yourself in the excitement, where a simple coin becomes a harbinger of excitement and potential wins. Are you ready to let fate decide your fortune? Join the excitement and flip your way to unexpected victories!</p>
                    <h3 class="about">Cookie Clicker</h3>
                    <p class="about">But it's not just about cookies - delve into the whimsical world of Cookie Clicker and uncover hidden secrets and surprises along the way. With charming visuals, addictive gameplay, and endless possibilities, Cookie Clicker is sure to satisfy your craving for fun!</p>
                    <h3 class="about">Spinning wheel</h3>
                    <p class="about">Are you ready for a whirlwind of fun and surprises? Step right up and take a spin on our mesmerizing Spinning Wheel! Brace yourself for an exhilarating gaming experience that will keep you on the edge of your seat.</p>
                    <h3 class="about">Hangman</h3>
                    <p class="about">Embark on a linguistic journey like never before with Galgje, the classic word-guessing game that promises excitement and mental stimulation. Galgje, also known as Hangman, is a timeless challenge that transcends language barriers and keeps players on the edge of their seats.</p>
                    <h3 class="about">Noughts And Crosses</h3>
                    <p class="about">Perfect for a quick match during a break or a leisurely game night with friends and family, Noughts and Crosses promises hours of entertainment and endless fun. Discover new strategies, challenge your friends, and see who will emerge victorious in this ultimate battle of wits.</p>
                </section>
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
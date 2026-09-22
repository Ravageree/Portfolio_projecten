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
    <nav class="navbar">
        <li class="nav"><a href="index.php">Home</a></li>
        <li class="nav"><a href="about.php">About</a></li>
        <li class="nav"><a href="contact.php">contact</a></li>
    </nav>
    <main class="body_contact">
        <section id="section">
            <?php
            for ($i = 0; $i < 260; $i++) {
                echo "<span></span>";
            }
            ?>
            <div class="content">
                <section class="reclame_contact">
                    <h1></h1>
                    <p></p>
                    <p></p>
                    <p></p>
                </section>
                <section class="invoer_contact">
                    <form action="mailto:gitgamble@gmail.com" method="post">
                        <i class="contact_color">firstname: </i><br>
                        <input type="text" size="20" maxsize="40" naam="firstname">
                        <br>
                        <i class="contact_color">lastname: </i><br>
                        <input type="text" size="20" maxsize="40" naam="lastname">
                        <br>
                        <i class="contact_color">E-mail: </i><br>
                        <input type="email" size="20" maxsize="40" naam="email">
                        <br>
                        <br>
                        <textarea name="probleem" cols="25" rows="7"></textarea>
                        <br>
                        <input type="submit" value="Send">
                    </form>
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
            <a href="#" class="rafael">Rafael</a>
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
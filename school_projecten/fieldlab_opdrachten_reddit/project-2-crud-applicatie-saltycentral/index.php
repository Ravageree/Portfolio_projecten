<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="shortcut icon" type="image/png" href="images/SaltyLogo.png">
    <link rel="stylesheet" href="styling/style.css">
    <title>SaltyCentral</title>
</head>

<body>
    <nav> <?php include('website_php/nav.php') ?></nav>
    <main class="container-fluid d-flex">
        <section id="content" class="content col-lg-8 col-md-8 col-sm-12 border border-2 rounded border-dark m-3 h-60 justify-content-center scrollable-section shadow-lg p-3 mb-5 bg-body-tertiary rounded">
            <?php
            // here is where the content in the change 
            if (isset($_COOKIE['userData']) && isset($_POST['home'])) {
                // here is for the all the threads
                include('website_php/section.php');
            } elseif (isset($_POST["login"])) {
                // login screen
                include("website_php/login.php");
            } elseif (isset($_POST['lobby'])) {
                // the lobby's for the phone
                include("website_php/aside.php");
            } elseif (isset($_POST["loginhandler"])) {
                // handels the login
                include("website_php/loginhandler.php");
            } elseif (isset($_POST["contact"])) {
                // where you can fill in the Bug Report
                include("website_php/contact.php");
            } elseif (isset($_POST['btf'])) {
                // Battle Field content
                include('website_php/BT_topics.php');
                echo "<style> main {
                    background-image: url('images/battlefield.jpg');
                    background-size: cover;
                    background-repeat: no-repeat;
                } 
                </style>";
            } elseif (isset($_POST['cod'])) {
                //Call Of Duty content
                include('website_php/cod_topics.php');
                echo "<style> main {
                   background-image: url('images/cod.jpg');
                   background-size: cover;
                   background-repeat: no-repeat;
                }
                </style>";
            } elseif (isset($_POST['cs2'])) {
                //Counter Strike 2 content
                include('website_php/cs2_topics.php');
                echo "<style>
                main {
                    background-image: url('images/CS2.png');
                    background-size: cover;
                    background-repeat: no-repeat;
                }
                </style>";
            } elseif (isset($_POST['r6'])) {
                // Rainbow Six Siege content
                include('website_php/r6_topics.php');
                echo "<style>
                main {
                    background-image: url('images/rainbow-six-siege.jpg');
                    background-size: cover;
                    background-repeat: no-repeat;
                }
                </style>";
            } else {
                // the History if your not logged in yet 
                if (!isset($_COOKIE['userData'])) {
                    include('website_php/about.php');
                } else {
                    include('website_php/section.php');
                }
            }
            ?>
        </section>
        <aside class="col-lg-2 col-md-2 col-sm-12 border border-2 rounded border-dark m-5 p-2 h-30 aside shadow-lg p-2 mb-5 bg-body-tertiary rounded">
            <?php
            if (isset($_COOKIE['userData'])) {
                // the lobby's for pc not phone foction 
                include('website_php/aside.php');
            } else {
                // the Builders that made the website (if your not logged in yet)
                include('website_php/dev.php');
            }
            ?>
        </aside>
    </main>
    <footer class="footer mt-auto py-1 text-center sticky-bottom" style="background-color: #212529;">
        <?php include('website_php/footer.php') ?>
    </footer>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>


</body>

</html>
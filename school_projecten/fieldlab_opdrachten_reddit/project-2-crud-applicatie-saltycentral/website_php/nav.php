<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SaltyCentral</title>
    <style>
        .logo {
            width: auto;
            height: 80px;
            padding-bottom: 0px;
        }

        .navbar {
            max-height: 80px;

        }

        #h1 {
            color: #E0C1B3;
        }

        .lobby {
            display: none;
        }

        @media (max-width: 800px) {
            .lobby {
                display: block;
            }
        }
    </style>
</head>

<!-- the navbar -->
<nav class="navbar navbar-dark bg-dark block-top" style="padding-top: 0 !important;">
    <div class="container-fluid">
        <img src="images/SaltyLogo.png" alt="SaltyCentral" class="d-inline-block align-top img-fluid logo">
        <h1 class="navbar-brand" id="h1">SaltyCentral</h1>
        <div class="nav-login d-flex justify-content-end align-items-center ">
            <form action="" method="post">
                <?php
                require_once "cookieauth.php";
                require_once 'config.php'; 
                ?>
                <!-- login button -->
                <input class="btn btn-dark" type="submit" name="login" value="<?php $user = cookieAuth();if ($user) {echo cookieAuth();} else {echo "login";}?>"> 
            </form>
            <!-- button vertical extension of the navbar -->
            <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasDarkNavbar" aria-controls="offcanvasDarkNavbar" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>
        <div class="offcanvas offcanvas-end text-bg-dark" tabindex="-1" id="offcanvasDarkNavbar" aria-labelledby="offcanvasDarkNavbarLabel">
            <div class="offcanvas-header">
                <h5 class="offcanvas-title" id="offcanvasDarkNavbarLabel">Menu</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                    <li class="nav-item">
                        <!-- home button -->
                        <form action="" method="post">
                            <input type="submit" name="home" class="nav-link active" value="&#x2302 Home">
                        </form>
                    </li>
                    <li class="nav-item">
                        <!-- contact button -->
                        <form action="" method="post">
                            <input type="submit" name="contact" class="nav-link active" value="&#128389; Bug Report">
                        </form>
                    </li>
                    <li class="nav-item lobby">
                        <!-- lobby button -->
                        <form action="" method="post">
                            <input type="submit" name="lobby" class="nav-link active" value="&#128423; Lobby's">
                        </form>
                    </li>
                    <?php
                    
                    if (isset($_COOKIE['userData'])) {
                        //logout button
                        echo '<li class="nav-item">
                        <form action="" method="post">
                        <input type="submit" name="logout" class="nav-link active" value="Logout">
                        </form>
                        </li>';
                        if (isset($_POST['logout'])) {
                            logOut();
                        }
                    } else {
                        //login button 
                        echo '<li class="nav-item">
                        <form action="" method="post">
                        <input type="submit" name="login" class="nav-link active" value="Login">
                        </from>
                        </li><br><br>';
                    }

                    if (isset($_COOKIE['userData'])) {
                        echo '<li class="nav-item">
                        <form action="AIVD.php" method="post">
                        <input type="submit" name="AIVD" class="nav-link active" value="AIVD"> 
                        </form>
                        </li>';
                    } else {
                        echo '<h3>Welcome to SaltyCentral</h3>';
                    }

                    ?>
                </ul>
                <!-- the search bar -->
                <form class="d-flex mt-3" role="search" style="display: none;">
                    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" style="display: none;">
                    <button class="btn btn-success" type="submit" style="display: none;">Search</button>
                </form>
            </div>
        </div>
    </div>
</nav>

</html>
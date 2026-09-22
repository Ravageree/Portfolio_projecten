<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
} ?>

<nav class="navbar navbar-expand-lg bg-body-tertiary nav">
    <div class="container-fluid">
        <a class="navbar-brand">Clanbase</a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link" href="homepage.php">Home</a>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Teams
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="../pages/forum.php">Team Forum</a></li>
                        <li><a class="dropdown-item" href="../pages/mijn_team.php">Mijn team</a></li>
                        <li><a class="dropdown-item" href="../pages/create_team.php">Team aanmaken</a></li>
                        <li><a class="dropdown-item" href="../pages/teams_stat.php">Teams stat</a></li>
                    </ul>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Account
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="../pages/chat.php">Chat</a></li>
                        <li><a class="dropdown-item" href="../pages/friend.php">vriendenlist</a></li>
                        <li><a class="dropdown-item" href="../pages/player_statustieken.php">statustieken</a></li>
                    </ul>
                </li>
            </ul>

            <?php
            if (isset($_SESSION['user_id']) && isset($_SESSION['username'])) {
                echo '<div class="account-box">' . htmlspecialchars($_SESSION['username']) . '</div>
              <a href="../php/logout.php" class="btn btn-secondary ">Uitloggen</a>';
            } else {
                echo '<a href="../pages/login_page.php" class="btn ms-3">Login</a>';
            }
            ?>
        </div>
    </div>
</nav>
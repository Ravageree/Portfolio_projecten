<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rock Paper Scissors Game</title>
    <link rel="stylesheet" href="css/rockpaperscissors.css">
</head>

<body>
    <!-- below here no touchie -->
    <main>
        <section id="section">
            <?php
            for ($i = 0; $i < 260; $i++) {
                echo "<span></span>";
            }
            ?>
            <div class="content">
                <!-- above here no touchie -->
                <div class="container">
                    <h1>Rock Paper Scissors Game <br> 100 points</h1>
                    <form action="" method="post">
                        <div class="options">
                            <label><input type="radio" name="user_choice" value="rock"> Rock</label>
                            <label><input type="radio" name="user_choice" value="paper"> Paper</label>
                            <label><input type="radio" name="user_choice" value="scissors"> Scissors</label>
                        </div>
                        <button type="submit" name="submit">Play for 50 points</button>
                    </form>
                    <div class="result">
                        <!-- knop voor terugkeren naar de homepage -->
                        <button type="submit" name="startgame"><a href="home.php">Homepage</a></button>
                        <?php
                        // Dit bepaalt de keuzes
                        $choices = array('rock', 'paper', 'scissors');

                        // Controleert of het formulier is verzonden
                        if (isset($_POST['submit'])) {
                            // Krijg de keuze van de gebruiker
                            $user_choice = isset($_POST['user_choice']) ? $_POST['user_choice'] : '';

                            // Valideer de keuze van de gebruiker
                            if (!in_array($user_choice, $choices)) {
                                echo "<p class = text>Please select a valid choice.</p>";
                                exit;
                            }

                            // Computer selecteert een willekeurige keuze
                            $computer_choice = $choices[array_rand($choices)];

                            // Bepaalt de winnaar
                            if ($user_choice == $computer_choice) {
                                echo "<p class = text>It's a tie!</p>";
                            } elseif (($user_choice == 'rock' && $computer_choice == 'scissors') ||
                                ($user_choice == 'paper' && $computer_choice == 'rock') ||
                                ($user_choice == 'scissors' && $computer_choice == 'paper')
                            ) {
                                echo "<p class = text>You win 100 points! Computer chose $computer_choice.</p>";
                            } else {
                                echo "<p class = text>Computer wins! It chose $computer_choice.</p>";
                            }
                        }

                        ?>
                    </div>
                </div>
</body>

</html>
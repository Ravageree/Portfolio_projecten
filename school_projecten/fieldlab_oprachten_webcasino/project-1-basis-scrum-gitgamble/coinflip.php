<?php
session_start();
include 'db.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kop of Munt</title>
    <link rel="stylesheet" href="css/coin.css">
</head>

<body>

    <main>
        <section>
            <!-- Background Blocks -->
            <?php
            // Generates a grid of blocks for the background
            for ($i = 0; $i < 260; $i++) {
                echo "<span></span>";
            }
            ?>

            <!-- Sign-in Form and Coin Flip Game -->
            <div class="signin">
                <div class="content">
                    <h1>Kop of Munt</h1>

                    <?php
                    $pdo = dbconnect();

                    $stmt = $pdo->prepare('SELECT * FROM user WHERE id = :uid');

                    $stmt->bindParam(':uid', $_SESSION['userid']);
                    $stmt->execute();
                    $user = $stmt->fetch();

                    $total1 = $user['score'];

                    // Game Logic: Handles user bets, points, and winning outcomes
                    $symbols = ["head", "tail"];
                    $symbol = null;
                    $userBet = isset($_POST['bet']) ? $_POST['bet'] : null;
                    $userPoints = isset($_POST['points']) ? intval($_POST['points']) : 0;
                    $winningScore = 0;

                    $user_id = $_SESSION['userid']; // Retrieve the user ID from session

                    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                        // Simulate a coin flip
                        $symbol = $symbols[array_rand($symbols)];
                    
                        // Calculate winnings based on user's bet
                        if ($symbol == $userBet) {
                            // Check if the user has enough points to place the bet
                            if ($total1 >= $userPoints) {
                                $winningScore = $userPoints;
                                $userPoints += $winningScore;
                    
                                // Update user points in the database
                                try {
                                    $stmt = $pdo->prepare("UPDATE user SET score = score + :winningScore WHERE id = :id");
                                    $stmt->bindParam(':winningScore', $winningScore);
                                    $stmt->bindParam(':id', $user_id); // Bind the user ID
                                    $stmt->execute();
                                } catch (PDOException $e) {
                                    echo "Error: " . $e->getMessage();
                                }
                            } else {
                                // Display an error message if the user doesn't have enough points
                                echo "You don't have enough points to place this bet.";
                            }
                        } else {
                            $winningScore = 0;
                        }
                    }

                    ?>

                    <!-- Displays result of the coin flip -->
                    <?php
                    if ($symbol !== null) {
                        echo "<p>You won: $winningScore points</p>";
                    }
                    ?>

                    <!-- Coin Flip Form -->
                    <form method="post" onsubmit="flipCoin()">
                        <label>
                            <input type="radio" name="bet" value="head" <?php if ($userBet === 'head') echo 'checked'; ?>> Head
                        </label>
                        <label>
                            <input type="radio" name="bet" value="tail" <?php if ($userBet === 'tail') echo 'checked'; ?>> Tail
                        </label>
                        <br>
                        <label for="points">Points:</label>
                        <input type="number" name="points" id="points" min="1" value="<?php echo $userPoints; ?>">

                        <br>
                        <div class="golden-reset">
                            <input type="submit" value="Throw the coin">
                        </div>

                    </form>

                    <form action="home.php" method="post">
                        <input type="submit" value="Back to games" class="backknop">
                    </form>

                    <?php

                    echo "<div class=total_points><br><br>Total points: " . $total1 . "</div>";
                    ?>

                    <!-- Displays the coin image based on the result -->
                    <?php
                    if ($symbol == "head") {
                        echo "<img id='coinImage' class='coin' src='img-coinflip/kop.png' style='transform: rotateY(0deg);'>";
                        echo "It is head";
                    } else {
                        echo "<img id='coinImage' class='coin' src='img-coinflip/munt.png' style='transform: rotateY(0deg);'>";
                        echo "It is tail";
                    }
                    ?>
                </div>
            </div>
        </section>
    </main>

</body>

</html>
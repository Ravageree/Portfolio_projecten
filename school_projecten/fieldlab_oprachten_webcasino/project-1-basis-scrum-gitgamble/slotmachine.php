<?php

session_start();

include 'db.php';
$pdo = dbconnect();

$stmt = $pdo->prepare('SELECT * FROM user WHERE id = :uid');

$stmt->bindParam(':uid', $_SESSION['userid']);
$stmt->execute();
$user = $stmt->fetch();

$total1 = $user['score'];

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/slotmachine.css">
    <title>slotmachine</title>

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
                <?php
                $faces = array(
                    'img-slotmachine/bar.png',
                    'img-slotmachine/blueberry.png',
                    'img-slotmachine/cherry.png',
                    'img-slotmachine/chips.png',
                    'img-slotmachine/clover.png',
                    'img-slotmachine/diamond.png',
                    'img-slotmachine/seven.png',
                    'img-slotmachine/triplebar.png',
                    'img-slotmachine/watermelon.png'
                );

                $payouts = array(
                    'img-slotmachine/blueberry.png|img-slotmachine/blueberry.png|img-slotmachine/blueberry.png' => '10',
                    'img-slotmachine/cherry.png|img-slotmachine/cherry.png|img-slotmachine/cherry.png' => '20',
                    'img-slotmachine/watermelon.png|img-slotmachine/watermelon.png|img-slotmachine/watermelon.png' => '30',
                    'img-slotmachine/bar.png|img-slotmachine/bar.png|img-slotmachine/bar.png' => '50',
                    'img-slotmachine/seven.png|img-slotmachine/seven.png|img-slotmachine/seven.png' => '80',
                    'img-slotmachine/triplebar.png|img-slotmachine/triplebar.png|img-slotmachine/triplebar.png' => '150',
                    'img-slotmachine/clover.png|img-slotmachine/clover.png|img-slotmachine/clover.png' => '200',
                    'img-slotmachine/diamond.png|img-slotmachine/diamond.png|img-slotmachine/diamond.png' => '250',
                    'img-slotmachine/chips.png|img-slotmachine/chips.png|img-slotmachine/chips.png' => '500',
                );

                $wheel1 = $faces;
                $wheel2 = array_reverse($wheel1);
                $wheel3 = $wheel1;

                $stop1 = 0;
                $stop2 = 0;
                $stop3 = 0;

                $stop1 = rand(count($wheel1), 2 + 10 * count($wheel1)) % count($wheel1);
                $stop2 = rand(count($wheel1), 2 + 10 * count($wheel1)) % count($wheel1);
                $stop3 = rand(count($wheel1), 2 + 10 * count($wheel1)) % count($wheel1);

                $result1 = $wheel1[$stop1];
                $result2 = $wheel2[$stop2];
                $result3 = $wheel3[$stop3];

                $slot_result = $result1 . '|' . $result2 . '|' . $result3;

                ?>
                <div class="slot-container">
                    <img src='<?php echo $result1; ?>' alt='Wheel 1' class='slot-image'>
                    <img src='<?php echo $result2; ?>' alt='Wheel 2' class='slot-image'>
                    <img src='<?php echo $result3; ?>' alt='Wheel 3' class='slot-image'>
                </div>
                <?php

                $total = $total1;

                if (isset($payouts[$slot_result])) {
                    $total1 = $total + $payouts[$slot_result];
                    echo "<div class=win><br><br>You won: $" . $payouts[$slot_result] . "</div>";
                } else {
                    echo "<div class=lost><br><br>No points</div>";
                }
                if (isset($_POST['submit'])) {
                    $stmt = $pdo->prepare('UPDATE user
                    SET score = :score
                    WHERE id = :uid');

                    $stmt->bindParam(':uid', $_SESSION['userid']);
                    $stmt->bindParam(':score', $total1);
                    $stmt->execute();
                }


                echo "<div class=total_points><br><br>Total points: " . $total1 . "</div>";
                ?>


                <form method='post'>
                    <input type='submit' name='submit' class="spinknop" value='Spin' onclick='spinSlots()' />
                    <input type='hidden' name='total' value='<?php echo $total1; ?>' />
                    <input type='hidden' name='bust' value='<?php echo $bust; ?>' />
                </form>

                <form action="home.php" method="post">
                    <input type="submit" value="Back to games" class="backknop">
                </form>

                <script>
                    function spinSlots() {
                        var slotContainer = document.querySelector('.slot-container');
                        slotContainer.classList.add('spin-animation');

                        slotContainer.addEventListener('animationend', function() {
                            slotContainer.classList.remove('spin-animation');

                            var slotImages = document.querySelectorAll('.slot-image');
                            slotImages.forEach(function(image) {
                                image.classList.add('slide-up-animation');
                                setTimeout(function() {
                                    image.classList.remove('slide-up-animation');
                                }, 500);
                            });
                        }, {
                            once: true
                        });
                    }
                </script>
            </div>
        </section>
    </main>


</body>

</html>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/card.css">
    <title>Document</title>
</head>

<body>
    <div> 
        <?php
        include("include/nav.php");
        ?>
    </div>
    <section class=klok>
    <div class="homepagina">
        <?php
        date_default_timezone_set('America/New_York');
        $currentTime = new DateTime('now');
        $targetTimeZone = new DateTimeZone('Europe/Amsterdam');
        $currentTime->setTimezone($targetTimeZone);
        $tijd = $currentTime->format('H:i');

        if ($tijd >= '05:00' && $tijd < '12:00') {
            echo "<h2>Goedemorgen!</h2>";
        } elseif ($tijd >= '12:00' && $tijd < '18:00') {
            echo "<h2>Goedemiddag!</h2>";
        } else {
            echo "<h2>Goedeavond!</h2>";
        }
        ?>
        <p>de tijd van vandaag is: <?php echo "$tijd"; ?></p>
    </section>
        <section class=kaarten>
    </div>
    <div class="card">
        <div class="wrapper">
            <img src="https://ggayane.github.io/css-experiments/cards/dark_rider-cover.jpg" class="cover-image" />
        </div>
        <img src="https://ggayane.github.io/css-experiments/cards/dark_rider-title.png" class="title" />
        <img src="https://ggayane.github.io/css-experiments/cards/dark_rider-character.webp" class="character" />
    </div>

    <div class="card">
        <div class="wrapper">
            <img src="https://ggayane.github.io/css-experiments/cards/force_mage-cover.jpg" class="cover-image" />
        </div>
        <img src="https://ggayane.github.io/css-experiments/cards/force_mage-title.png" class="title" />
        <img src="https://ggayane.github.io/css-experiments/cards/force_mage-character.webp" class="character" />
    </div>
    </section>

</body>

</html>
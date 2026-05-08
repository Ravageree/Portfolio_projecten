<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/minesweeper.css">
    <script src="script.js"></script>
    <title>Mine sweeper</title>
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
                <h1 class="mines">Mines: <i id="mines-count">0</i> <br> Flags Placed: <i id="flags-count">0</i></h1>
                <div id="board"></div>
                <br>
                <button id="flag-button">&#128681</button>
            </div>
        </section>
    </main>
    <audio id="winSound" src="project_webcasino/project-1-basis-scrum-gitgamble/geluid-minesweeper/sounds_yay.mp3"></audio>
    <audio id="loseSound" src="project_webcasino/project-1-basis-scrum-gitgamble/geluid-minesweeper/fail.mp3"></audio>
</body>

</html>
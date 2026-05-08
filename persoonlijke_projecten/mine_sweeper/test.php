<?php

$board = [];
$row = 18;
$columns = 18;

$minesCount = 50;
$minelocation = [];
$tile = [];

$tilesClicked = 0;
$flagEnabled = false;
$flags = 0;
$correctFlags = 0;
$flag = "🚩";

$gameOver = false;

function setMines() {
    global $minesCount, $minelocation, $row, $columns;

    $minesLeft = $minesCount;

    while ($minesLeft > 0) {
        $r = rand(0, $row - 1);
        $c = rand(0, $columns - 1);
        $id = $r . "-" . $c;

        if (!in_array($id, $minelocation)) {
            array_push($minelocation, $id);
            $minesLeft -= 1;
        }
    }
}

function startGame() {
    global $minesCount, $flags, $flagEnabled, $row, $columns, $board;

    echo '<script>';
    echo 'document.getElementById("mines-count").innerText = ' . $minesCount . ';';
    echo 'document.getElementById("flags-count").innerText = ' . $flags . ';';
    echo 'document.getElementById("flag-button").addEventListener("click", setFlag);';
    echo '</script>';

    setMines();

    for ($r = 0; $r < $row; $r++) {
        $rowArray = [];
        for ($c = 0; $c < $columns; $c++) {
            $tile = '<div id="' . $r . '-' . $c . '></div>';
            array_push($rowArray, $tile);
        }
        array_push($board, $rowArray);
    }

    echo '<script>';
    echo 'console.log(' . json_encode($board) . ');';
    echo '</script>';
}

function setFlag() {
    global $flagEnabled;

    if ($flagEnabled) {
        $flagEnabled = false;
        echo '<script>document.getElementById("flag-button").style.backgroundColor = "lightblue";</script>';
    } else {
        $flagEnabled = true;
        echo '<script>document.getElementById("flag-button").style.backgroundColor = "cornflowerblue";</script>';
    }
}

function clickTile($tile) {
    global $gameOver, $flagEnabled, $flag, $minesCount, $minelocation, $flags, $row, $columns, $board, $correctFlags;

    if ($gameOver || in_array("tile-clicked", $tile)) {
        return;
    }

    if ($flagEnabled) {
        if ($tile->innerText == "") {
            $tile->innerText = $flag;
            $flags = $flags + 1;
            $correctFlags += 1;
        } elseif ($tile->innerText == $flag) {
            $tile->innerText = "";
            $flags = $flags - 1;
        }

        if ($correctFlags === $minesCount) {
            checkWin();
        }
        $flags + 1;
        echo '<script>document.getElementById("flags-count").innerText = ' . $flags . '</script>';
        return;
    }

    if (in_array($tile->id, $minelocation)) {
        echo 'alert("GAME OVER YOU LOST: 150 ");';
        revealMines();
        $gameOver = true;
        return;
    }

    $coords = explode("-", $tile->id);
    $r = (int) $coords[0];
    $c = (int) $coords[1];
    checkmine($r, $c);
}

function checkWin() {
    global $gameOver;
    echo 'alert("YOU WIN: 200");';
    revealMines();
    $gameOver = true;
}

function revealMines() {
    global $minelocation, $board, $row, $columns;

    for ($r = 0; $r < $row; $r++) {
        for ($c = 0; $c < $columns; $c++) {
            $tile = $board[$r][$c];
            if (in_array($tile->id, $minelocation)) {
                $tile->innerText = "💣";
                $tile->style->backgroundColor = "red";
            }
        }
    }
}

function checkmine($r, $c) {
    global $row, $columns, $board, $minelocation;

    if ($r < 0 || $r >= $row || $c < 0 || $c >= $columns) {
        return;
    }

    if (in_array("tile-clicked", $board[$r][$c]->classList)) {
        return;
    }

    $board[$r][$c]->classList->add("tile-clicked");

    $minesFound = 0;

    $minesFound += checkTile($r - 1, $c - 1);
    $minesFound += checkTile($r - 1, $c);
    $minesFound += checkTile($r - 1, $c + 1);

    $minesFound += checkTile($r, $c - 1);
    $minesFound += checkTile($r, $c + 1);

    $minesFound += checkTile($r + 1, $c - 1);
    $minesFound += checkTile($r + 1, $c);
    $minesFound += checkTile($r + 1, $c + 1);

    if ($minesFound > 0) {
        $board[$r][$c]->innerText = $minesFound;
        $board[$r][$c]->classList->add("x" . $minesFound);
    } else {
        $board[$r][$c]->innerText = "";
        checkmine($r - 1, $c - 1);
        checkmine($r - 1, $c);
        checkmine($r - 1, $c + 1);

        checkmine($r, $c - 1);
        checkmine($r, $c + 1);

        checkmine($r + 1, $c - 1);
        checkmine($r + 1, $c);
        checkmine($r + 1, $c + 1);
    }
}

function checkTile($r, $c) {
    global $row, $columns, $minelocation;

    if ($r < 0 || $r >= $row || $c < 0 || $c >= $columns) {
        return 0;
    }

    if (in_array($r . "-" . $c, $minelocation)) {
        return 1;
    }

    return 0;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/minesweeper.css">
    <script src="minesweeper.js"></script>
    <title>Document</title>
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
                <h1 class="mines">Mines: <?php echo $minesCount; ?> <br> Flags Placed: <?php echo $flags; ?></h1>
                <div id="board">
                    <?php
                    foreach ($board as $rowArray) {
                        foreach ($rowArray as $tile) {
                            echo $tile;
                        }
                    }
                    ?>
                </div>
                <br>
                <button id="flag-button">&#128681</button>
            </div>
        </section>
    </main>
</body>

</html>

<?php
session_start();

// Initialiseren van scores en rondes
if (!isset($_SESSION['scores'])) {
    $_SESSION['scores'] = ['X' => 0, 'O' => 0];
}
if (!isset($_SESSION['round'])) {
    $_SESSION['round'] = 1;
}

// Functie om het spel te resetten
function resetGame()
{
    $_SESSION['board'] = [
        ['', '', ''],
        ['', '', ''],
        ['', '', '']
    ];
    $_SESSION['turn'] = 'X';
}

// Functie om te controleren op gelijkspel
function checkDraw($board)
{
    foreach ($board as $row) {
        foreach ($row as $cell) {
            if ($cell === '') {
                return false; // Als er een lege cel is, is het geen gelijkspel
            }
        }
    }
    return true; // Als er geen lege cellen zijn, is het gelijkspel
}

// Controleren of er een zet is gedaan
if (isset($_GET['row']) && isset($_GET['col']) && isset($_SESSION['turn'])) {
    $row = $_GET['row'];
    $col = $_GET['col'];
    $turn = $_SESSION['turn'];
    $board = $_SESSION['board'];
    // Hier wordt gecontroleerd of er een zet is gedaan via de 'row' en 'col'. Ook wordt gecontroleerd of het de beurt is van een speler ($_SESSION['turn']).

    // Controleren of de geselecteerde cel leeg is
    if ($board[$row][$col] == '') {
        $board[$row][$col] = $turn;

        // Controleren op een winnaar
        if (checkWinner($board, $turn)) {
            $_SESSION['scores'][$turn]++;
            if ($_SESSION['scores'][$turn] == 3) {
                // Bericht weergeven en doorsturen naar home.php bij het winnen van het spel
                echo "<script>
                        alert('Speler $turn wint het spel!');
                        window.location.href = 'home.php';
                      </script>";
                // Scores en spel resetten
                $_SESSION['scores'] = ['X' => 0, 'O' => 0];
                $_SESSION['round'] = 1;
                resetGame();
            } else {
                $remainingWins = 3 - $_SESSION['scores'][$turn];
                $message = ($remainingWins == 1) ? "Speler $turn moet nog 1 keer winnen" : "Speler $turn moet nog $remainingWins keer winnen";
                // doorsturen naar de volgende ronde
                echo "<script>
                        alert('$message');
                        window.location.href = '?next_round=1';
                      </script>";
                $_SESSION['round']++;
                resetGame();
            }
        } elseif (checkDraw($board)) {
            // Bericht weergeven en doorsturen naar volgende ronde bij gelijkspel
            echo "<script>
                    alert('Het is gelijkspel!');
                    window.location.href = '?next_round=1';
                  </script>";
            $_SESSION['round']++;
            resetGame();
        } else {
            // Wisselen van beurt
            $_SESSION['turn'] = ($turn == 'X') ? 'O' : 'X';
        }
    }

    $_SESSION['board'] = $board;
} else {
    // Controleren of volgende ronde is aangevraagd
    if (isset($_GET['next_round'])) {
        $_SESSION['round']++;
        resetGame();
        header("Location: {$_SERVER['PHP_SELF']}");
        exit();
    } else {
        // Starten van een nieuw spel
        resetGame();
    }
}

// Functie om te controleren of er een winnaar is
function checkWinner($board, $player)
{
    // Controleren op rijen
    for ($i = 0; $i < 3; $i++) {
        if ($board[$i][0] == $player && $board[$i][1] == $player && $board[$i][2] == $player) {
            return true;
        }
        // De functie doorloopt elke rij op het bord en controleert of alle drie de cellen in die rij zijn gevuld met de symbool van de speler 
    }
    // Controleren op kolommen
    for ($j = 0; $j < 3; $j++) {
        if ($board[0][$j] == $player && $board[1][$j] == $player && $board[2][$j] == $player) {
            return true;
        }
    }
    // De functie doorloopt elke kolom op het bord en controleert of alle drie de cellen in die kolom zijn gevuld met het symbool van de speler 

    // Controleren op diagonalen
    if ($board[0][0] == $player && $board[1][1] == $player && $board[2][2] == $player) {
        return true;
    }
    // checkt of het diagonaal is van linksboven naar rechts onder
    if ($board[0][2] == $player && $board[1][1] == $player && $board[2][0] == $player) {
        return true;
    }
    return false;
    // checkt of de diagonalen van linksonder naat rechtsboven gaan
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/boter-kaas-eieren.css">
    <style>
        table {
            border-collapse: collapse;
        }

        td {
            width: 50px;
            height: 50px;
            border: 1px solid black;
            text-align: center;
            font-size: 24px;
            color: white; /* Alle cellen hebben standaard witte tekst */
        }

        .winner {
            background-color: lightgreen;
            color: purple; /* Als een speler wint, worden de tekens paars */
        }
    </style>
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
                <h3 class="title">Boter kaas en eieren</h3>
                <?php
                // Toon het bord
                echo "<table>";
                // Toon de rijen van het bord
                for ($i = 0; $i < 3; $i++) {
                    echo "<tr>";
                    // Maak cellen voor elke kolom
                    for ($j = 0; $j < 3; $j++) {
                        $cellValue = $_SESSION['board'][$i][$j];
                        $cellClass = '';
                        if (checkWinner($_SESSION['board'], 'X') && $cellValue === 'X' || checkWinner($_SESSION['board'], 'O') && $cellValue === 'O') {
                            $cellClass = 'winner';
                        }
                        echo "<td class='$cellClass' onclick='makeMove($i, $j)'>$cellValue</td>";
                    }
                    echo "</tr>";
                }
                echo "</table>";
                ?>
                <script>
                    // Verwerk de zetten
                    function makeMove(row, col) {
                        // Stuur door naar dezelfde pagina voor de volgende ronde
                        window.location.href = `?row=${row}&col=${col}`;
                    }
                </script>
            </div>
        </section>
    </main>
</body>

</html>

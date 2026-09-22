<?php
// Start de PHP-sessie om de spelgegevens bij te houden
session_start();

// Lijst met woorden voor het spel
$words = ["fortnite", "wiskunde", "database", "piloot", "leraar", "voetbal", "banaan", "nederland", "olifant", "jens", "kevin", "afwasser", "kaas", "boter", "vijftien", "kerstboomversiering", "brandweer", "politie", "ziekenhuis", "woonwijk", "heiloo", "raamkozijn", "aphotheker", "huisartsenpost", "cars", "McQueen", "youtube", "netflix", "parasol", "aandachttekort", "kip", "telefoonverbod", "school", "anticonceptiepil", "paracetamol", "pythagoras", "sinus", "cosinus", "tangens", "jas", "gamen", "boef", "kut", "mario", "luigi", "bowser", "mariokart", "skylanders"];

// Functie om een nieuw spel te starten
function startNewGame()
{
    global $words;
    // Kies willekeurig een woord uit de lijst en sla het op in de sessievariabele
    // met de strtolower zorg je ervoor dat de hoofletters in kleine letters worden veranderd  
    $_SESSION['word'] = strtolower($words[array_rand($words)]);
    // Initialisatie van arrays voor geraden letters en onjuiste pogingen
    $_SESSION['guessedLetters'] = [];
    $_SESSION['incorrectGuesses'] = 0;
    // Verwijder de volgende lijn, omdat de score al wordt geïnitialiseerd in de onderstaande code
    // $_COOKIE['score'] = 0;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Start een nieuw spel als de newGame-knop is ingedrukt
    if (isset($_POST['newGame'])) {
        startNewGame();
    }
    // Verwerk de gok als de processGuess-knop is ingedrukt en het spel nog bezig is
    elseif (isset($_POST['guess']) && inGameInProgress()) {
        processGuess($_POST['guess']);
    }
}

// Initialize score if not already set
if (!isset($_SESSION['score'])) {
    $_SESSION['score'] = 0;
}
// Functie om het te raden woord weer te geven 
function displayWord()
{
    $display = '';
    foreach (str_split($_SESSION['word']) as $letter) {
        // als het letter nog niet geraden is dan staat er een underscore 
        $display .= (in_array($letter, $_SESSION['guessedLetters']) ? $letter : '_') . ' ';
    }
    return trim($display);
}

// Functie om een gok te verwerken
function processGuess($letter)
{
    $letter = strtolower($letter);
    // Controleer of de letter niet eerder is geraden
    if (!in_array($letter, $_SESSION['guessedLetters'])) {
        // Voeg de letter toe aan de lijst met geraden letters
        $_SESSION['guessedLetters'][] = $letter;
        // Verhoog het aantal onjuiste pogingen als de letter niet in het woord voorkomt
        if (!str_contains($_SESSION['word'], $letter)) {
            $_SESSION['incorrectGuesses']++;
        }
    }
}

// Functies om te controleren of het spel is gewonnen, verloren of nog bezig is
function isGameWon()
{
    $isWon = count(array_intersect(str_split($_SESSION['word']), $_SESSION['guessedLetters'])) == strlen($_SESSION['word']);
    // Update score if the game is won
    if ($isWon && !isset($_SESSION['wordGuessed'])) {
        $_SESSION['score']++;
        $_SESSION['wordGuessed'] = true; // met deze code komt er maar steeds 1 punt bij
    }
    return $isWon;
}


function isGameLost()
{
    return $_SESSION['incorrectGuesses'] >= 7;
}

function inGameInProgress()
{
    return !isGameWon() && !isGameLost();
}

// Verwerking van het formulier bij indienen
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Start een nieuw spel als de 'newGame'-knop is ingedrukt
    if (isset($_POST['newGame'])) {
        startNewGame();
    }
    // Verwerk de gok als de 'guess'-knop is ingedrukt en het spel nog bezig is
    elseif (isset($_POST['guess']) && inGameInProgress()) {
        processGuess($_POST['guess']);
    }
} else {
    // Start automatisch een nieuw spel als de pagina voor het eerst wordt geladen
    startNewGame();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hangman Game</title>
    <link rel="stylesheet" href="css/galgje.css">
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
                <h1 class="woorden">Hangman Game</h1>

                <!-- galgje-afbeeldingen bij fouten -->
                <?php
                $hangmanpicture = [
                    'img-galgje/start.png',
                    'img-galgje/strike1.png',
                    'img-galgje/strike2.png',
                    'img-galgje/strike3.png',
                    'img-galgje/strike4.png',
                    'img-galgje/strike5.png',
                    'img-galgje/strike6.png',
                    'img-galgje/strike7.png',
                ];
                $currentPictureIndex = min($_SESSION['incorrectGuesses'], count($hangmanpicture) - 1);
                ?>

                <!-- Weergave van de spelstatus: gewonnen, verloren of nog bezig -->
                <?php
                // als de persoon het spel heeft gewonnen // 
                if (isGameWon()) {
                    echo '<h4 class="woorden">Congratulations! You guessed the word: ' . $_SESSION['word'] . '</h4>';
                } // als de persoon het spel heeft verloren //  
                elseif (isGameLost()) {
                    echo '<h4 class="woorden">Sorry, you ran out of attempts. The correct word was: ' . $_SESSION['word'] . '</h4>';
                } // na het spel wordt het hele woord zichtbaar // 
                else {
                    echo '<div class="woorden" id="word">' . displayWord() . '</div>';
                };
                ?>

                <!-- Afbeelding van de galg -->
                <img id="hangman-image" src="<?php echo $hangmanpicture[$currentPictureIndex]; ?>" alt="Hangman picture">

                <!-- je kan een letter invullen om te raden of hij er in zit  -->
                <form method="post">
                    <label class="woorden" for="guess">Guess a letter: </label>
                    <input type="text" id="guess" name="guess" maxlength="1" pattern="[a-zA-Z]" required>
                    <button type="submit">Submit</button>
                </form>

                <!-- knoppen voor het starten van een nieuw spel of terugkeren naar de homepage -->
                <form class="buttons" method="post">
                    <button type="submit" name="newGame">Start a new game</button>
                    <button type="submit" name="startgame"><a href="home.php">Homepage</a></button>
                    <!-- laat de score zien -->
                    <p class="score">Score: <?php echo $_SESSION['score']; ?></p>

                </form>

            </div>
        </section>
    </main>
</body>

</html>
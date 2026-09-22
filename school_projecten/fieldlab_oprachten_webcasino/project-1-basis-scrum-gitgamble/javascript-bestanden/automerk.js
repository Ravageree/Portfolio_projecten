var automerkImg = [
    { src: 'img-autoquiz/audi.jpg', value: 'Audi' },
    { src: 'img-autoquiz/bentley.jpg', value: 'Bentley' },
    { src: 'img-autoquiz/chev.jpg', value: 'Chevrolet' },
    { src: 'img-autoquiz/ford.jpg', value: 'Ford' },
    { src: 'img-autoquiz/honda.png', value: 'Honda' },
    { src: 'img-autoquiz/mercedes.jpg', value: 'Mercedes' },
    { src: 'img-autoquiz/nissan.jpg', value: 'Nissan' },
    { src: 'img-autoquiz/subaro.jpg', value: 'Subaru' },
    { src: 'img-autoquiz/toyta.png', value: 'Toyota' },
    { src: 'img-autoquiz/volkswagen.jpg', value: 'Volkswagen' },
];

let scores = 0;
let questionCounter = 0;
let usedIndexes = [];

function getRandomCarImage() {
    if (questionCounter >= 10) {
        // Redirect to home.php after 10 questions
        window.location.href = 'home.php';
        return;
    }

    var randomIndex;
    do {
        randomIndex = Math.floor(Math.random() * automerkImg.length);
    } while (usedIndexes.includes(randomIndex));

    usedIndexes.push(randomIndex);

    var randomCarImage = document.getElementById('randomCarImage');
    var buttonsContainer = document.getElementById('buttonsContainer');

    if (!randomCarImage || !buttonsContainer) {
        console.error("HTML elements not found. Check your HTML structure.");
        return;
    }

    randomCarImage.src = automerkImg[randomIndex].src;
    randomCarImage.alt = automerkImg[randomIndex].value;

    buttonsContainer.innerHTML = '';

    for (var i = 0; i < automerkImg.length; i++) {
        var button = document.createElement('button');
        button.textContent = automerkImg[i].value;
        button.onclick = function () {
            checkGuess(this.textContent);
        };
        buttonsContainer.appendChild(button);
    }

    questionCounter++;
}

function checkGuess(guess) {
    var randomCarImage = document.getElementById('randomCarImage');

    if (!randomCarImage) {
        console.error("HTML element not found. Check your HTML structure.");
        return;
    }

    if (guess === randomCarImage.alt) {
        alert('Correct! Next logo!');
        scores++;
        updateScoreboard();
        getRandomCarImage();
    } else {
        alert('Try again');
        // Allow the user to continue to the next question even if the answer is incorrect
        getRandomCarImage();
    }
}

function updateScoreboard() {
    var scoreboard = document.getElementById('scoreboard');

    if (scoreboard) {
        scoreboard.textContent = 'Score: ' + scores;
    } else {
        console.error("HTML element not found. Check your HTML structure.");
    }
}

function resetScore() {
    scores = 0;
    questionCounter = 0;
    usedIndexes = [];
    updateScoreboard();
    getRandomCarImage();
}

window.onload = function () {
    getRandomCarImage();
    resetScore();
};
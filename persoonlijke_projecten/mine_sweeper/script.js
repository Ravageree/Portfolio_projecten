let board = [];
let row = 18;
let colums = 18;

let minesCount = 50;
let minelocation = [];

let tilesClicked = 0; //de doel om niet de minenen aan te clikken 
let flagEnabled = false;
let flags = 0;
let correctFlags = 0;
let flag = "🚩";


let gameOver = false;

window.onload = function () {
    startGame();
}
//locaties van de mines random 
function setMines() {
    let minesLeft = minesCount;
    while (minesLeft > 0) {
        let r = Math.floor(Math.random() * row);
        let c = Math.floor(Math.random() * colums);
        let id = r.toString() + "-" + c.toString();

        if (!minelocation.includes(id)) {
            minelocation.push(id);
            minesLeft -= 1;
        }
    }

}

function startGame() {
    document.getElementById("mines-count").innerText = minesCount;
    document.getElementById("flags-count").innerText = flags;
    document.getElementById("flag-button").addEventListener("click", setFlag);
    setMines();

    //binnen in de board de cellen maken
    for (let r = 0; r < row; r++) {
        let row = [];
        for (let c = 0; c < colums; c++) {
            // een div gemaakt als een cel voor de opvulling van het board
            let tile = document.createElement("div");
            //hier heb ik een id aan de divs gegeven zoals 0-0 of 0-1
            tile.id = r.toString() + "-" + c.toString();
            tile.addEventListener("click", clickTile);
            document.getElementById("board").append(tile);
            row.push(tile);
        }
        board.push(row);
    }

    console.log(board);
}

//hier veranderen we de kleur van de flag knop
function setFlag() {
    if (flagEnabled) {
        flagEnabled = false;
        document.getElementById("flag-button").style.backgroundColor = "lightblue";
    }
    else {
        flagEnabled = true;
        document.getElementById("flag-button").style.backgroundColor = "cornflowerblue";
    }
}

//hier maak ik de div dat je er op kan clicken 
function clickTile() {
    if (gameOver || this.classList.contains("tile-clicked")) {
        return;
    }

    // dit is voor het vlaggen knop om de vlaggen ook in de div te kunnen zetten
    let tile = this;
    if (flagEnabled) {
        if (tile.innerText == "") {
            tile.innerText = flag;
            flags = flags + 1;
        }
        else if (tile.innerText == flag) {
            tile.innerText = "";
            flags = flags - 1;
        }

        if (flags === minesCount) {
            checkWin();
        }

        document.getElementById("flags-count").innerText = flags;
        return;
    }

    // dit is als je op een mine drukt ga je naar een andere webpagina ze kunnen alleen terug als ze weer op start nieuw game drukken 
    if (minelocation.includes(tile.id)) {
        alert("GAME OVER YOU LOST: 150 ");
        revealMines();
        window.location.replace("home.php");
        gameOver = true;
        return;
    }

    let coords = tile.id.split("-");
    let r = parseInt(coords[0]);
    let c = parseInt(coords[1]);
    checkmine(r, c);
}
// als je hebt gewonnen ga je naar de home pagina en je kan alleen terug als je op start nieuw game drukt 
function checkWin() {
    alert("YOU WIN: 200");
    revealMines();
    window.location.replace("home.php");
    gameOver = true;
    return;
}
//de locatie laten zien waar ze zitten als je er op heb gedrukt 
function revealMines() {
    for (let r = 0; r < row; r++) {
        for (let c = 0; c < colums; c++) {
            let tile = board[r][c];
            if (minelocation.includes(tile.id)) {
                tile.innerText = "💣"
                tile.style.backgroundColor = "red"
            }
        }
    }
}

function checkmine(r, c) {
    if (r < 0 || r >= row || c < 0 || c >= colums) {
        return;
    }
    if (board[r][c].classList.contains("tile-clicked")) {
        return;
    }

    board[r][c].classList.add("tile-clicked");

    let minesFound = 0;
    //bij de div's er rond om kijken of het een mine aanraakt 
    minesFound += checkTile(r - 1, c - 1); //boven kant links
    minesFound += checkTile(r - 1, c); //boven kant
    minesFound += checkTile(r - 1, c + 1) //boven kant rechts

    //links en rechts
    minesFound += checkTile(r, c - 1); //links
    minesFound += checkTile(r, c + 1); //rechts

    //onderste 3 
    minesFound += checkTile(r + 1, c - 1); //onder kant links
    minesFound += checkTile(r + 1, c); //onder kant
    minesFound += checkTile(r + 1, c + 1) //onder kant rechts
    //hier doet hij de nummer laten zien met hoeveel mines hij vindt
    if (minesFound > 0) {
        board[r][c].innerText = minesFound;
        board[r][c].classList.add("x" + minesFound.toString());
    }
    else {
        //als niks in de div zit dan doet hij hem weg 
        board[r][c].innerText = "";
        //bovenste 3
        checkmine(r - 1, c - 1); //boven links
        checkmine(r - 1, c);   //boven
        checkmine(r - 1, c + 1); //boven rechts

        checkmine(r, c - 1); //links
        checkmine(r, c + 1); //rechts

        checkmine(r + 1, c - 1); //onder links
        checkmine(r + 1, c);  //onder
        checkmine(r + 1, c + 1);// onder rechts   
    }

}

function checkTile(r, c) {
    if (r < 0 || r >= row || c < 0 || c >= colums) {
        return 0;
    }
    if (minelocation.includes(r.toString() + "-" + c.toString())) {
        return 1;
    }
    return 0;
}
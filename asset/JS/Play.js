const gameBoard = document.querySelector("#gameboard");
const infoDisplay = document.querySelector("#info");
const startCells = ["", "", "", "", "", "", "", "", ""];
let go = "circle";

// Récupérer les scores depuis localStorage, ou les initialiser à 0
let scoreCircle = localStorage.getItem("scoreCircle")
  ? parseInt(localStorage.getItem("scoreCircle"))
  : 0;
let scoreCross = localStorage.getItem("scoreCross")
  ? parseInt(localStorage.getItem("scoreCross"))
  : 0;
let scoreDraw = localStorage.getItem("scoreDraw")
  ? parseInt(localStorage.getItem("scoreDraw"))
  : 0;

// Afficher les scores au chargement de la page
document.querySelector("#score_o").textContent = `${scoreCircle}`;
document.querySelector("#score_x").textContent = `${scoreCross}`;
document.querySelector("#nul").textContent = `${scoreDraw}`;

infoDisplay.textContent = "Circle goes first";

function createBoard() {
  startCells.forEach((_cell, index) => {
    const cellElement = document.createElement("div");
    cellElement.classList.add("square");
    cellElement.id = index;
    cellElement.addEventListener("click", addGo);
    gameBoard.append(cellElement);
  });
}
createBoard();

function addGo(e) {
  const goDisplay = document.createElement("div");
  goDisplay.classList.add(go);
  e.target.append(goDisplay);
  go = go === "circle" ? "cross" : "circle";
  infoDisplay.textContent = "It is now " + go + "'s go";
  e.target.removeEventListener("click", addGo);
  checkScore();
  checkDraw(); // Vérification du match nul après chaque mouvement
}

function checkScore() {
  const allSquares = document.querySelectorAll(".square");
  const winningCombos = [
    [0, 1, 2],
    [3, 4, 5],
    [6, 7, 8],
    [0, 3, 6],
    [1, 4, 7],
    [2, 5, 8],
    [0, 4, 8],
    [2, 4, 6],
  ];
  winningCombos.forEach((array) => {
    const crossWins = array.every((cell) =>
      allSquares[cell].firstChild?.classList.contains("cross")
    );
    if (crossWins) {
      infoDisplay.textContent = "Cross Wins!";
      incrementScore("cross");
      // Attendre un clic de l'utilisateur avant de terminer le jeu
      document.body.addEventListener("click", endGame, { once: true });
      return;
    }
  });
  winningCombos.forEach((array) => {
    const circleWins = array.every((cell) =>
      allSquares[cell].firstChild?.classList.contains("circle")
    );
    if (circleWins) {
      infoDisplay.textContent = "Circle Wins!";
      incrementScore("circle");
      // Attendre un clic de l'utilisateur avant de terminer le jeu
      document.body.addEventListener("click", endGame, { once: true });
      return;
    }
  });
}

function checkDraw() {
  const allSquares = document.querySelectorAll(".square");
  const isDraw = [...allSquares].every((square) => square.firstChild);
  if (isDraw) {
    infoDisplay.textContent = "It's a Draw!";
    incrementScore("draw");
    // Attendre un clic de l'utilisateur avant d'appeler endGame
    document.body.addEventListener("click", endGame, { once: true });
  }
}

function endGame() {
  const allSquares = document.querySelectorAll(".square");
  // Supprimer les événements de clic pour arrêter le jeu
  allSquares.forEach((square) => square.replaceWith(square.cloneNode(true)));
  // Attendre un clic pour redémarrer la partie
  document.body.addEventListener("click", () => location.reload(), {
    once: true,
  });
}

function incrementScore(winner) {
  if (winner === "circle") {
    scoreCircle++;
    localStorage.setItem("scoreCircle", scoreCircle); // Sauvegarder dans localStorage
    document.querySelector("#score_o").textContent = `${scoreCircle}`;
  } else if (winner === "cross") {
    scoreCross++;
    localStorage.setItem("scoreCross", scoreCross); // Sauvegarder dans localStorage
    document.querySelector("#score_x").textContent = `${scoreCross}`;
  } else if (winner === "draw") {
    scoreDraw++;
    localStorage.setItem("scoreDraw", scoreDraw); // Sauvegarder dans localStorage
    document.querySelector("#nul").textContent = `${scoreDraw}`;
  }
}

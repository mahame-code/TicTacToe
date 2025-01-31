const gameBoard = document.querySelector("#gameboard");
const infoDisplay = document.querySelector("#info");
const startCells = ["", "", "", "", "", "", "", "", ""];
let go = "circle"; // Player is "circle", bot is "cross"

// Récupérer les scores depuis localStorage, ou les initialiser à 0
let scorePlayer = localStorage.getItem("scorePlayer")
  ? parseInt(localStorage.getItem("scorePlayer"))
  : 0;
let scoreComputer = localStorage.getItem("scoreComputer")
  ? parseInt(localStorage.getItem("scoreComputer"))
  : 0;
let scoreNul = localStorage.getItem("scoreNul")
  ? parseInt(localStorage.getItem("scoreNul"))
  : 0;

// Afficher les scores au chargement de la page
document.querySelector("#score_o").textContent = `${scorePlayer}`;
document.querySelector("#score_x").textContent = `${scoreComputer}`;
document.querySelector("#nul").textContent = `${scoreNul}`;

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

function addGo(e) {
  if (go === "circle") {
    const goDisplay = document.createElement("div");
    goDisplay.classList.add(go);
    e.target.append(goDisplay);
    e.target.removeEventListener("click", addGo);

    // Vérifiez si le joueur gagne ou si le jeu est nul avant que le bot ne bouge
    if (checkGameEnd()) return;

    go = "cross"; // Passer le tour au bot
    infoDisplay.textContent = "It is now the bot's turn";

    // Laissez le bot jouer après un court délai
    setTimeout(botMove, 500);
  }
}

function findOpportunity(playerSymbol) {
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

  // Vérifiez chaque combinaison gagnante possible
  for (let combo of winningCombos) {
    const [a, b, c] = combo;
    const cells = [allSquares[a], allSquares[b], allSquares[c]];

    const botCells = cells.filter((cell) =>
      cell.firstChild?.classList.contains(playerSymbol)
    );
    const emptyCells = cells.filter((cell) => !cell.firstChild);

    // Si deux cellules sont occupées par le bot et qu'une est vide, c'est une opportunité gagnante
    if (botCells.length === 2 && emptyCells.length === 1) {
      return emptyCells[0]; // Return the empty cell to win
    }
  }

  return null; //Aucune opportunité gagnante détectée
}

function botMove() {
  if (checkGameEnd()) return; // Ne bougez pas si le jeu est déjà terminé

  const winOpportunity = findOpportunity("cross"); // Vérifiez si le bot peut gagner
  const threat = findOpportunity("circle"); // Vérifiez si le joueur est sur le point de gagner
  let targetCell;

  if (winOpportunity) {
    // Prioriser la victoire
    targetCell = winOpportunity;
  } else if (threat) {
    // Sinon, bloquez le joueur
    targetCell = threat;
  } else {
    // S'il n'y a pas de menace ou d'opportunité de victoire, choisissez une cellule vide au hasard

    const allSquares = document.querySelectorAll(".square");
    const emptySquares = [...allSquares].filter((square) => !square.firstChild);

    if (emptySquares.length === 0) return; // Pas de cellules vides

    targetCell = emptySquares[Math.floor(Math.random() * emptySquares.length)];
  }

  // Jouer dans la cellule choisie
  const goDisplay = document.createElement("div");
  goDisplay.classList.add("cross");
  targetCell.append(goDisplay);
  targetCell.removeEventListener("click", addGo);

  go = "circle"; // Passe, retourne au joueur
  infoDisplay.textContent = "It is now your turn";

  // Vérifiez si le bot gagne ou si le jeu est nul
  checkGameEnd();
}

function checkGameEnd() {
  return checkScore() || checkDraw();
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

  for (let array of winningCombos) {
    const crossWins = array.every((cell) =>
      allSquares[cell].firstChild?.classList.contains("cross")
    );
    if (crossWins) {
      infoDisplay.textContent = "Cross Wins!";
      incrementScore("computer");
      endGame(); // Appeler endGame pour bloquer le jeu et attendre le clic
      return true; // Game over
    }

    const circleWins = array.every((cell) =>
      allSquares[cell].firstChild?.classList.contains("circle")
    );
    if (circleWins) {
      infoDisplay.textContent = "You Win!";
      incrementScore("player");
      endGame(); // Appeler endGame pour bloquer le jeu et attendre le clic
      return true; // Game over
    }
  }

  return false; // No winner yet
}

function checkDraw() {
  const allSquares = document.querySelectorAll(".square");
  const isDraw = [...allSquares].every((square) => square.firstChild);
  if (isDraw) {
    infoDisplay.textContent = "It's a Draw!";
    incrementScore("draw");
    endGame(); // Appeler endGame pour bloquer le jeu et attendre le clic
    return true; // Game over
  }
  return false; // No draw yet
}

function endGame() {
  const allSquares = document.querySelectorAll(".square");
  // Désactiver les clics sur le plateau
  allSquares.forEach((square) => {
    square.removeEventListener("click", addGo); // Enlever l'écouteur d'événements
    square.classList.add("disabled"); // Ajouter une classe pour indiquer que les cases sont désactivées
  });

  // Activer un écouteur d'événements sur le corps de la page pour redémarrer le jeu
  document.body.addEventListener("click", resetGame, { once: true });
}
function resetGame() {
  // Réinitialiser le tableau de jeu
  gameBoard.innerHTML = ""; // Vider le tableau de jeu
  createBoard(); // Recréer le tableau de jeu

  // Réinitialiser les variables de jeu
  go = "circle";
  infoDisplay.textContent = "Circle goes first";

  // Réactiver les écouteurs d'événements pour les cellules du tableau
  const allSquares = document.querySelectorAll(".square");
  allSquares.forEach((square) => {
    square.addEventListener("click", addGo);
    square.classList.remove("disabled"); // Enlever la classe de désactivation
  });

  // Retirer l'écouteur d'événements du corps de la page pour éviter plusieurs activations
  document.body.removeEventListener("click", resetGame);
}

function incrementScore(winner) {
  if (winner === "player") {
    scorePlayer++;
    localStorage.setItem("scorePlayer", scorePlayer); // Sauvegarder dans localStorage
    document.querySelector("#score_o").textContent = `${scorePlayer}`;
  } else if (winner === "computer") {
    scoreComputer++;
    localStorage.setItem("scoreComputer", scoreComputer); // Sauvegarder dans localStorage
    document.querySelector("#score_x").textContent = `${scoreComputer}`;
  } else if (winner === "draw") {
    scoreNul++;
    localStorage.setItem("scoreNul", scoreNul); // Sauvegarder dans localStorage
    document.querySelector("#nul").textContent = `${scoreNul}`;
  }
}

// Créer le tableau de jeu initial
createBoard();

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" href="asset/IMG/rond.png" type="image/x-icon">
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"
    />
    <title>Document</title>
    <style>
      body {
        margin: 0;
        padding: 0;
        color: #f2f4f6;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        flex-direction: column;
        background-color: #686d76;
      }
      .board {
        display: flex;
        flex-direction: column;
        align-items: center;
      }

      #gameboard {
        width: 600px;
        height: 600px;
        display: flex;
        flex-wrap: wrap;
        background-color: #686d76;
      }

      .square {
        width: 200px;
        height: 200px;
        border: solid 2px #f2f4f6;
        box-sizing: border-box;
        display: flex;
        justify-content: center;
        align-items: center;
      }
      .square:nth-child(3n) {
        border-right: none;
      }
      .square:nth-child(6) ~ .square {
        border-bottom: none;
      }
      .square:nth-child(-n + 3) {
        border-top: none;
      }
      .square:nth-child(3n + 1) {
        border-left: none;
      }
      .circle {
        height: 160px;
        width: 160px;
        border-radius: 50%;
        border: 20px solid #55d2ed;
        box-sizing: border-box;
        animation: appear 0.2s ease-out;
      }
      .cross {
        height: 180px;
        width: 180px;
        position: relative;
        transform: rotate(45deg);
      }
      .cross::before,
      .cross:after {
        content: "";
        position: absolute;
        background-color: #e73c3c;
        animation: appear 0.2s ease-out;
      }
      .cross::before {
        left: 50%;
        width: 20px;
        height: 100%;
        margin-left: -6%;
        border-radius: 5px;
      }
      .cross::after {
        top: 50%;
        width: 100%;
        height: 20px;
        margin-top: -6%;
        border-radius: 5px;
      }
      @keyframes appear {
        from {
          transform: scale(0);
        }
        to {
          transform: scale(1);
        }
      }

      .menu {
        display: flex;
        justify-content: space-between;
        align-items: center;
        width: 80%;
      }
      .icon {
        width: 8%;
        height: 60%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: x-large;
      }
      .icon a i {
        color: #55d2ed;
      }
      .icon a img {
        height: 30px;
      }
      .score {
        text-align: center;
        display: flex;
        justify-content: space-around;
        font-size: larger;

        width: 50%;
      }

      .darken {
        opacity: 0.5; /* Réduction de l'opacité pour assombrir le symbole */
        transition: opacity 0.5s ease-in-out; /* Transition fluide */
      }
      @media screen and (max-width: 500px) and (min-width: 300px) {
        body {
          flex-direction: column-reverse;
          justify-content: flex-end;
          gap: 100px;
        }
        #gameboard {
          width: 300px;
          height: 300px;
        }
        .square {
          width: 33.33%;
          height: 33.33%;
          border: solid 2px #f2f4f6;
          box-sizing: border-box;
          display: flex;
          justify-content: center;
          align-items: center;
        }
        #info {
          font-size: large;
        }
        .board {
          gap: 50px;
        }
        .circle {
          height: 80px;
          width: 80px;
          border-radius: 50%;
          border: 12px solid #55d2ed;
          box-sizing: border-box;
        }
        .cross {
          height: 90px;
          width: 90px;
          position: relative;
          transform: rotate(45deg);
        }
        .cross::before {
          left: 50%;
          width: 15px;
          height: 100%;
          margin-left: -8%;
          border-radius: 5px;
        }
        .cross::after {
          top: 50%;
          width: 100%;
          height: 15px;
          margin-top: -8%;
          border-radius: 5px;
        }
        .score {
          font-size: small;
        }
      }
    </style>
  </head>
  <body>
    <section class="board">
      <div id="gameboard"></div>
      <p id="info"></p>
    </section>

    <section class="menu">
      <div class="icon">
        <a href="accueil_2.php"><i class="fa fa-bars"></i></a>
      </div>
      <!-- <div class="icon">
        <a href="accueil_2"><img src="asset/IMG/utilisateur.png" alt="" /></a>
      </div> -->
    </section>

    <script>
      const gameBoard = document.querySelector("#gameboard");
      const infoDisplay = document.querySelector("#info");
      const startCells = ["", "", "", "", "", "", "", "", ""];
      let go = "circle";
      let playerMoves = { circle: [], cross: [] }; // Historique des coups de chaque joueur

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
        // Ajouter le symbole pour le coup actuel
        const goDisplay = document.createElement("div");
        goDisplay.classList.add(go);
        e.target.append(goDisplay);

        // Ajouter le coup joué à la liste des coups de ce joueur
        playerMoves[go].push(e.target);

        // Si le joueur a plus de 3 coups, supprimer le premier coup
        if (playerMoves[go].length > 3) {
          const firstMove = playerMoves[go].shift(); // Supprimer le plus ancien coup du joueur
          firstMove.innerHTML = ""; // Effacer le symbole
          firstMove.addEventListener("click", addGo); // Rendre la case cliquable à nouveau
        }

        // Changer le tour du joueur
        go = go === "circle" ? "cross" : "circle";
        infoDisplay.textContent = "It is now " + go + "'s go";

        e.target.removeEventListener("click", addGo); // Désactiver la case cliquée
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
          document.body.addEventListener("click", endGame, { once: true });
        }
      }

      function endGame() {
        const allSquares = document.querySelectorAll(".square");
        allSquares.forEach((square) =>
          square.replaceWith(square.cloneNode(true))
        );
        document.body.addEventListener("click", () => location.reload(), {
          once: true,
        });
      }
    </script>
  </body>
</html>

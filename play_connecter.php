<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="Jouez au morpion en ligne, affrontez
    des adversaires en temps réel et découvrez des fonctionnalités comme la
     suppression d'anciens symboles pour une partie plus dynamique.">
     <link rel="icon" href="asset/IMG/rond.png" type="image/x-icon">
    <link rel="stylesheet" href="asset/CSS/Play.css" />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"
    />
    <title>Jouez au Morpion en Ligne - Partie Rapide et Amusante</title>
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

      <div class="score">
        <p>Player 1<br /><span id="score_o">0</span></p>
        <p>
          Egalité<br />
          <span id="nul">0</span>
        </p>
        <p>Player 2<br /><span id="score_x">0</span></p>
      </div>
      <div class="icon">
        <a href="play_2_connecter.php"
          ><img src="asset/IMG/utilisateur.png" alt=""
        /></a>
      </div>
    </section>

    <script src="asset/JS/Play.js"></script>
  </body>
</html>

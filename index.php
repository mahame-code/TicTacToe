<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta
      name="description"
      content="Bienvenue sur notre jeu de morpion en 
    ligne ! Jouez gratuitement, défiez vos amis, et profitez de nos 
    fonctionnalités innovantes pour une expérience unique."
    />
    <link rel="icon" href="asset/IMG/rond.png" type="image/x-icon">
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/
      font-awesome.min.css"
    />
    <link rel="stylesheet" href="asset/CSS/Accueil.css" />
    <title>
      Jeu de Morpion en Ligne - Amusez-vous avec Tic Tac Toe Gratuitement
    </title>
    <link rel="icon" href="asset/IMG/rond.png" type="image/x-icon">
  </head>
  <body>
    <header>
      <div>
        <a href="inscription.php"><i class="fa fa-user"></i></a>
        <!-- <p>name user</p> -->
      </div>
      <img
        id="logo_header"
        src="asset/IMG/logo_tictactoe.png"
        alt="logo jeu du morpion grille 3x3 effet 3D "
      />
      <div id="btn_header">
        <a href="inscription.php"><button class="btn_log">sign up</button></a>
        <a href="connexion.php"><button class="btn_log">log in</button></a>
      </div>
    </header>
    <main>
      <div id="popup" class="popup">
        <div class="popup-content">
          <span class="close">&times;</span>
          <h2>Rejoignez nous</h2>
          <a href="inscription.php" class="connexion">S'inscrire</a>
          <a class="connexion" href="connexion.php"> Se connecter</a>
        </div>
      </div>
      <div id="logo_icon">
        <div class="icon"></div>
      </div>

      <img src="asset/IMG/logo_accueil.png" alt="grille de jeu" />
      <div class="bouton_play">
        <a href="Play_V1.php"><button class="button 1">PLAY</button></a>
      </div>
    </main>
    <script>
      document.getElementById("logo_icon").onclick = function () {
        document.getElementById("popup").style.display = "flex";
      };
      document.querySelector(".close").onclick = function () {
        document.getElementById("popup").style.display = "none";
      };
    </script>
  </body>
</html>

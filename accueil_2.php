<?php
session_start();

// Initialisation de la variable pour stocker le pseudo
$pseudo = "";

// Vérifie si le joueur est connecté
if (isset($_SESSION["pseudo"])) {
    // Stocke le pseudo du joueur
    $pseudo = htmlspecialchars($_SESSION["pseudo"]);
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="Bienvenue sur notre jeu de morpion en ligne ! Jouez gratuitement, défiez vos amis, et profitez de nos fonctionnalités innovantes pour une expérience unique.">
    <link rel="stylesheet" href="asset/CSS/Accueil_2.css" />
    <link rel="icon" href="asset/IMG/rond.png" type="image/x-icon">
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"
    />
    <title>Jeu de Morpion en Ligne - Amusez-vous avec Tic Tac Toe Gratuitement</title>
  </head>
  <body>
    <header>
      <div></div>
      <img
        id="logo_header"
        src="asset/IMG/logo_tictactoe.png"
        alt="logo jeu du morpion"
      />
      <div id="logo_log">
        <div class="icon"></div>
        <a>
           <!-- Affiche uniquement le pseudo du joueur -->
           <?php if (!empty($pseudo)) : ?>
               <p style="text-align: center;"><?php echo $pseudo; ?></p>
           <?php endif; ?>
      </div>
    
    <div id="popup" class="popup">
        <div class="popup-content">
            <span class="close">&times;</span>
            <h2>Mon compte</h2>
            <a id="deconnexion" href="deconnexion.php"> Se Déconnecter</a>
            <a href="RGPD.php" id="redirect">Règlement Général sur la Protection des Données</a>
        </div>
    </div>
    </header>
    <main>
      <div id="logo_log_2">
        <div class="icon"></div>
        <p>
        <?php if (!empty($pseudo)) : ?>
               <p style="text-align: center;"><?php echo $pseudo; ?></p>
           <?php endif; ?>
        </p>
      </div>
      <img src="asset/IMG/logo_accueil.png" alt="grille de jeu 3x3 effet 3D" />
      <div class="bouton_play">
        <a href="play_connecter.php"><button class="button 1">PLAY</button></a>

        <a href="new.php"><button class="button 1">NEW</button></a>
      </div>
    </main>
    <script>
  document.getElementById('logo_log').onclick = function() {
    document.getElementById('popup').style.display = 'flex';
}
document.getElementById('logo_log_2').onclick = function() {
    document.getElementById('popup').style.display = 'flex';
}

document.querySelector('.close').onclick = function() {
    document.getElementById('popup').style.display = 'none';
}

document.getElementById('deconnexion').onclick = function() {
    alert('Déconnexion réussie.');
    document.getElementById('popup').style.display = 'none';
}
</script>
  </body>
</html>

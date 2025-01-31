<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    
    <link rel="stylesheet" href="asset/CSS/Connexion.css" />
    <link rel="icon" href="asset/IMG/rond.png" type="image/x-icon">
    <title>Connexion au Jeu de Morpion - Accédez à Votre Compte</title>
  </head>
  <body>
    <main>
      <a class="logo_connexion" href="index.php">
        <img
          id="img_logo"
          src="asset/IMG/logo_connexion.png"
          alt="Logo tic tac toe"
      /></a>

      <form action="traitement_connexion.php" method="post">
        <h1 class="connexion_form">Connexion</h1>
        <label for="email"></label>
        <input
          class="formulaire"
          type="text"
          name="email"
          placeholder="E-mail"
        />

        <label for="password"></label>
        <input
          class="formulaire"
          type="password"
          name="password"
          placeholder="Mot de passe"
        />
        

        <input class="btn_connexion" type="submit" value="Se connecter" />
      </form>
      <form class="modal_form" action="forgot.php?mode=enter_email">
          <a class="valider" href="forgot.php?mode=enter_email">Mot de passe oublié ?</a>
         </form>
      <a class="lien_inscription" href="inscription.php"
        >Nouveau ?<br />Inscriver-vous et commencez à jouer !</a
      >
    </main>
  </body>
</html>

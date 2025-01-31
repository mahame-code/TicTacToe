<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="Inscrivez-vous gratuitement pour profiter de notre jeu de morpion, sauvegardez vos scores, personnalisez votre profil et défiez d'autres joueurs en ligne.">

    <link rel="stylesheet" href="asset/CSS/Inscription.css" />
    <link rel="icon" href="asset/IMG/rond.png" type="image/x-icon">
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"
    />
    <title>Inscrivez-vous pour Jouer au Morpion - Créez Votre Compte Gratuitement
    </title>
  </head>
  <body>
    <main>
      <!-- <div class="div_main">
        <a href="accueil.html"><i class="fa fa-arrow-left"></i></a>
        
      </div> -->
      <h1>Entrez vos information</h1>
      <p class="p_main">
        Cela vous permet de vous connecter sur n'importe quel appareil
      </p>
      <form action="traitement_inscription.php" method="post">
        <label for="pseudo"></label>
        <input
          type="text"
          class="formulaire"
          name="pseudo"
          placeholder="Nom d'utilisateur"
          pattern="[/^ [A-Za-z0-9\x{00c0}-\x{00ff}]{3,250}$/u]"
        />
        <label for="email"></label>
        <input
          type="text"
          class="formulaire"
          name="email"
          placeholder="E-mail"
        />
        <label for="password"></label>
        <input
          type="password"
          class="formulaire"
          name="password"
          placeholder="Mot de passe"
          pattern="[A-Za-z0-9_$]{4,}"
        />
        <input class="btn_inscription" type="submit" value="S'inscrire" />
      </form>
      <a class="deja_inscrit" href="connexion.php"><p>J'ai déjà un compte !</p></a>
    </main>
  </body>
</html>

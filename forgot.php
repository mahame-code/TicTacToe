<?php
session_start();
$errors = array();
// Inclusion du fichier mail.php qui contient probablement des fonctions liées à l'envoi de courriels
require "mail.php";
// Inclusion du fichier constants.inc.php, probablement contenant des constantes utiles
include_once ("commun/inc_perso.php");
try {
    // Tentative de connexion à la base de données MySQL avec des paramètres définis dans les constantes
    $pdo = new PDO("mysql:host=$db_host;dbname=$db_name;charset=utf8", $db_user, $db_password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // Affiche un message d'erreur en cas d'échec de la connexion
} catch (PDOException $e) {
    die("la connexion n'est pas etablie: " . $e->getMessage());
}

$mode = "enter_email";
if (isset($_GET['mode'])) {
    $mode = $_GET['mode'];
}

if (count($_POST) > 0) {
    switch ($mode) {
        case 'enter_email':
            // code...
            $email = $_POST['mail'];
            // Vérification de la validité de l'adresse e-mail
             //et ajout d'une erreur si elle est invalide
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = " veillez inserer un email valide";
                // Vérification si l'adresse e-mail existe dans
                // la base de données et ajout d'une erreur si non
            } elseif (!valid_email($pdo, $email)) {
                $errors[] = "veillez inserer un email valide";

                 // Envoi d'un courriel de réinitialisation
            } else {
                $_SESSION['forgot']['mail'] = $email;
                send_email($pdo, $email);
                // Redirection vers la page de saisie du code
                header("Location: forgot.php?mode=enter_code") ;
                die;
            }
            break;

        case 'enter_code':
           
            $code = $_POST['code'];
            $result = is_code_correct($pdo, $code);

            if ($result === "le code est correcte") {
                $_SESSION['forgot']['code'] = $code;
                 // Redirection vers la page de saisie 
                 //du nouveau mot de passe
                header("Location: forgot.php?mode=enter_password");
                die;
            } else {
                // Ajout d'une erreur si le code saisi n'est pas correct
                $errors[] = $result;
            }
            break;

        case 'enter_password':
  
            $password = $_POST['password'];
            $password2 = $_POST['password2'];
            // Vérification si les mots de passe saisis sont identiques
            if ($password !== $password2) {
                $errors[] = "les mots de passes ne sont pas identiques";
            } elseif (!isset($_SESSION['forgot']['mail']) || !isset($_SESSION['forgot']['code'])) {
                header("Location: forgot.php");
                die;
            } else {
                // Sauvegarde du nouveau mot de passe dans la base de données
                save_password($pdo, $password);
                // Suppression des informations de récupération de mot de passe de la session
                if (isset($_SESSION['forgot'])) {

                    unset($_SESSION['forgot']);
                }
                echo '<script type="text/javascript">
                    alert("Mot de passe changé avec succès");
                    window.location.href="index.php";
                    </script>';
                die;
            }
            break;

        default:
            // code...
            break;
    }
}

// Fonction d'envoi de courriel pour la réinitialisation de mot de passe

function send_email($pdo, $email) {
    // Durée de validité du code (2 minutes)
    $expire = time() + (60 * 2);
     // Génération d'un code aléatoire
    $code = rand(10000, 99999);
    $email = addslashes($email);

    $query = "INSERT INTO codes (email, code, expire) VALUES (:mail, :code, :expire)";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':mail', $email);
    $stmt->bindParam(':code', $code);
    $stmt->bindParam(':expire', $expire);
    $stmt->execute();
// Envoi du courriel contenant le code
    send_mail($email, 'Reinitialisation de mot de passe', 'Votre code est : '. $code);
}


// Fonction de sauvegarde du nouveau mot de passe dans la base de données

function save_password($pdo, $password) {
    $email = addslashes($_SESSION['forgot']['mail']);
     // Utilisation de la fonction password_hash pour sécuriser le mot de passe 
    $password = password_hash($password, PASSWORD_DEFAULT);
    $query = "UPDATE utilisateur SET password = :password WHERE email = :mail";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':password', $password);
    $stmt->bindParam(':mail', $email);
    $stmt->execute();
}


// Fonction de vérification de l'existence de l'adresse e-mail dans la base de données
function valid_email($pdo, $email) {
    $query = "SELECT * FROM utilisateur WHERE email = :mail LIMIT 1";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':mail', $email);
    $stmt->execute();
    
    if ($stmt->rowCount() > 0) {
        return true;
    }

    return false;
}

// Fonction de vérification de la validité du code saisi
function is_code_correct($pdo, $code) {
    $expire = time();
    $email = addslashes($_SESSION['forgot']['mail']);

    $query = "SELECT * FROM codes WHERE code = :code AND email = :mail ORDER BY id DESC LIMIT 1";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':code', $code);
    $stmt->bindParam(':mail', $email);
    $stmt->execute();
  
    if ($stmt->rowCount() > 0) {
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        var_dump($row);

        if ($row['expire'] > $expire) {
            return "le code est correcte";

        } else {
            return "Le code a expiré. Veuillez recommencer. <br> <a href='Se_connecter.php' class='label'>Retour</a>";
        }
    } else {
        return "Le code est incorrect.";
        var_dump($row);

    }
    var_dump($row);
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="asset/CSS/forgot.css">
    <title>Se connecter</title>
</head>
<body>
    
<section class="Form-box">
    <?php
    
    switch ($mode) {
        case 'enter_email':
            // code...
            ?>
            <section id="form_forgot">
                <form class="formulaire" method="post" action="forgot.php?mode=enter_email" >
                    <h2 class="soustitre">Mot de passe oublié</h2>

                    <span style="color:red;">
                    <?php 
                    foreach ($errors as $err) {
                        echo $err . "<br>";
                    }
                    ?>
                    </span>
                    <div >   
                    <label class="label" for="pseudo"></label>
                    <input type="email" name="mail" placeholder="Entrez votre email" class="input">
                    </div>
                    <button type="submit" class="valider">Connexion</button>
                      <a class="link" href="index.php">retour à l'accueil</a>
                </form>

              
            </section>
            <?php
            break;

        case 'enter_code':
            // code...
            ?>
            <section id="form_forgot">
                <form class="form_log" method="post" action="forgot.php?mode=enter_code">
                    <h2 class="soustitre">Mot de passe oublié</h2>
                   

                    <span style=" color:red;">
                    <?php 
                    foreach ($errors as $err) {
                        echo $err . "<br>";
                    }
                    ?>
                    </span>
                    <label class="label" for="pseudo">Entrez le code reçu par mail</label>
                    <input id="co" class="input" type="text" name="code" placeholder="12345">
                    <input type="submit" value="Continuer" class="valider">
                </form>
            </section>
            <?php
            break;

        case 'enter_password':
            // code...
            ?>
            <section id="form_forgot">
                <form class="form_log" method="post" action="forgot.php?mode=enter_password">
                    <h2 class="soustitre">Mot de passe oublié</h2>
                    <span style="color:red;">
                    <?php 
                    foreach ($errors as $err) {
                        echo $err . "<br>";
                    }
                    ?>
                    </span>
                    <label class="label" for="pseudo">   Entrez votre nouveau mot de passe</label>
                    <input id="co" class="input" type="password" name="password" placeholder="Nouveau mot de passe">
                    <input id="co" class="input" type="password" name="password2" placeholder="Entrez à nouveau le mot de passe">
                    <input type="submit" value="Continuer" class="valider">
                </form>
            </section>
            <?php
            break;

        default:
            // code...
            break;
    }
    ?>
    </section>
</body>
</html>

<?php
include('commun/footer.php');
?>

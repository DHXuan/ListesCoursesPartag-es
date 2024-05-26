<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width">
  <title> Liste de course partagée </title>
  <link href="style.css" rel="stylesheet" type="text/css" />
</head>

<body>
  <script src="index.js"></script>
  <div class="rectangle">
    <p class="titre"> LISTE DE COURSE PARTAGEE </p>
  </div>

  <form action="" method="post" class="center">

    <fieldset>
      <legend> Se connecter </legend>
      <div class="center">
        <label for="email">Adresse e-mail :</label>

        <input type="email" id="email1" name="email1" required />
      </div>
      <div class="center">

        <label for="password3">Mot de passe : </label>
        <input type="password" id="password1" name="password1"></br>
        </br>
      </div>
      <div class="center">
        <input type="submit" value="Se connecter" onclick="connect()">
      </div>
      </br>

      <div class="center">
        <input type="button" class="MdpF " id="MdpF" name="MdpF" value="Mot de passe oublié ?" onclick="oublie()" />

        <input type="button" id="Creat" name="Creat" value="Vous n'avez pas de compte ?" onclick="creat()" />
        </br>
      </div>

    </fieldset>

    </form>


<?php
//on verifie qu'on obtient bien une addresse mail et unmot de passe
if(isset($_POST["email1"])&&isset($_POST["password1"])) {
  $email = $_POST["email1"]; //stockage de l'email entrée par l'utilisateurs
  $password = $_POST["password1"]; //stockage du mot de passe entrée par l'utilisateurs
  $authenticated = false; // variable permettant de savoir si la personne est connecté, au début elle indique NON

//lancement de la session
  session_start();

  /*fonction permettant de recuperer les donnes du fichier texte.txt 
  dans lequel est stockés les informations suivantes id,email,mot de passe
  cette fonction permet de créer un tableau contenant l'ensmble des utilisateurs 
*/
  function Recupdonne($filename) {
      $fichier = file("texte.txt");
      $utilisateurs = [];

      foreach ($fichier as $line) {
          $utilisateurs[] = str_getcsv($line, ",", "\"");
      }

      return $utilisateurs;
  }

  /* Cette fonction permet de vérifier si l'utilisatuer c'est connceté, 
  elle va comparer le mot de passe et le mail rentrée par l'utilisateurs
  et les mots de passes et les mails qui sont présents dans texte.txt */ 
  function authentification($email, $password, $users) {
      foreach ($users as $user) { //BOucle permettant de parcourir l'ensemble du fichier texte.txt
          if ($user[1] === $email) { // vérification si l'email rentrée est le même qu'un des emails de fichier.txt 

              /* Utiliser password_verify

              password_verify vérifie qu'un mot de passe correspond à un hachage

              J'ai trouvé cela sur internet, sur le site de php.net/manual

              On  nous le presente en même temps que password_hash

              Cette fonction nous permet bien de comparer 2 mots de passes hachés

              Si nous mettions comme tout à l'heure $user[2] === $password

              Nous pourrions point comparer les deux mots de passes car l'un est haché ( celui contenu dans texte.txt et fait 60 caractère) et l'autre mot de passe ne serait pas haché

              De ce fait nous pourrions pas faire la comparaison
               */ 
              if (password_verify($password,$user[2])) { // 
                $_SESSION['id'] = $user[0]; // On écrit que l'ID de la session est celui enregistré dans le fichier texte.txt
				$_SESSION['email'] = $user[1];
				$_SESSION['nom'] = $user[3];
				$_SESSION['prenom'] = $user[4];
				
                return true; // on bascule authentification en vrai
              }
          }
      }
      return false; // si une des conditions n'est pas remplis alors authentification est retourner comme faux
  }

  // Vérifier si les données de connexion ont été soumises via le formulaire
  if (isset($_POST["email1"]) && isset($_POST["password1"])) {
      $email = $_POST["email1"]; //on enregistre la reponses de l'utilisateurs
      $utilisateur = Recupdonne("texte.txt"); //utilisation de la fonction qui va permet de récuperer les données stockés dans texte.txt

      if (authentification($email, $password, $utilisateur)) { 
        //utilisation de la fonction authentification dans laquelle on envoie l'email et le mot de passe que l'utilisateur viens de rentrer et le tableau contenant l'ensmeble des utilisatuers elle va lancer les requetes après seulement si authentification est vrai 

        $user_id = $_SESSION['id']; // mettre une varaible égale à l'ID de la session

        echo "Connexion réussie. Vous allez être redirigé..."; //message qui va s'afficher
        header("refresh:3;url=http://localhost:/liste.php?id=$user_id"); 
        //on va rediriger vers une page liste.php qui dans l'url va dépendre de l'ID de l'utilisateurs et sera donc différente selon l'utilisateurs 
        //Le refresh:3; permet de mettre une attente de 3 seconde avant d'être rediriger  
        exit();
      } else {
          echo "Email ou mot de passe incorrect."; //message d'erreur si le mdp ou le mail ne marche pas 
      }
  } else {
      echo "Veuillez entrer votre email et votre mot de passe.";
  }

}
?>
<?php 
session_start();
$user_id = $_SESSION['id'];
?>

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
    <p class="titre"> MODE ADMIN </p>
  </div>

  <form action="" method="post" class="center">

    <fieldset>
      <legend> Se connecter </legend>
      <div class="center">
        <label for="email4">Adresse e-mail :</label>

        <input type="email" id="email4" name="email4" required />
      </div>
      <div class="center">

        <label for="password4">Mot de passe : </label>
        <input type="password" id="password4" name="password4"></br>
        </br>
      </div>
      <div class="center">
        <input type="submit" value="Se connecter">
      </div>  
    </fieldset>

    </form>


<?php
if(isset($_POST["email4"])&&isset($_POST["password4"])) {
  $email4 = $_POST["email4"]; 
  $password4 = $_POST["password4"]; 
  $authentication = false; 

  function Recupdonne($filename) {
      $fichier = file("perso_admin.txt");
      $utilisateurs = [];

      foreach ($fichier as $line) {
          $utilisateurs[] = str_getcsv($line, ",", "\"");
      }

      return $utilisateurs;
  }

  function authentification($email4, $password4, $users) {
      foreach ($users as $user) { 
          if ($user[0] === $email4) { 
              if ($password4===$user[1]) {
                return true; 
              }
          }
      }
      return false; 
  }

  if (isset($_POST["email4"]) && isset($_POST["password4"])) {

      $email4 = $_POST["email4"];
      $password4 = $_POST["password4"];  
      $utilisateur = Recupdonne("perso_admin.txt"); 

      if (authentification($email4, $password4, $utilisateur)) { 
        $user_id = $_SESSION['id']; 
        echo "Connexion réussie. Vous allez être redirigé..."; 
        header("refresh:3;url=http://localhost:/admin.php?id=$user_id"); 
        exit();
      } else {
          echo "Email ou mot de passe incorrect."; 
      }
  } else {
      echo "Veuillez entrer votre email et votre mot de passe.";
  }

}
?>
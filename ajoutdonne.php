<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width">
  <title>Liste de course partagée</title>
  <link href="style.css" rel="stylesheet" type="text/css" />
</head>

<body>
  <div class="rectangle">
    <p class="titre">LISTE DE COURSE PARTAGÉE</p>
  </div>

  <div class="separation-horiz"></div>

  <br>

  <form action="" method="post" class="center">
    <fieldset>
      <legend>Créer un compte</legend>

      <label for="prenom">Prénom :</label>
      <input type="text" id="prenom" name="prenom" maxlength="50" required><br>

      <label for="nom">Nom de famille :</label>
      <input type="text" id="nom" name="nom" maxlength="50" required><br>

      <label for="email">Adresse e-mail :</label>
      <input type="email" id="email" name="email" required><br>

      <label for="password">Mot de passe :</label>
      <input type="password" id="password" name="password" required><br>

      <div class="center">
        <button type="reset" id="reset_button">RÉINITIALISER LES CHAMPS</button>
        <input type="submit" name="submit" value="SAUVEGARDER MES DONNÉES">
      </div>
    </fieldset>
  </form>

<?php
//lancement de la session
session_start();

/*fonction permettant de recuperer les donnes du fichier texte.txt 
  dans lequel est stockés les informations suivantes id,email,mot de passe
  cette fonction permet de créer un tableau contenant l'ensmble des utilisateurs 
*/
function Recupdonne($filename) {
    $fichier = file($filename);
    $utilisateurs = [];

    foreach ($fichier as $line) {
        $utilisateurs[] = str_getcsv($line, ",", "\"");
    }

    return $utilisateurs;
}

// Vérifier si le formulaire a été soumis
if (isset($_POST["prenom"]) && isset($_POST["nom"]) && isset($_POST["email"]) && isset($_POST["password"])) {
    $id = uniqid(); //créer un id unique à chaque personne inscrite
    $prenom = trim($_POST["prenom"]); // on recupere ici les infomations transmisses par l'utilisateur
    $nom = trim($_POST["nom"]);
    $email = strtolower(trim($_POST["email"])); // transformation de la chaine de carctère en minuscules et enleve les espaces
    $password = password_hash(trim($_POST["password"]), PASSWORD_BCRYPT); 
    /*permet ici le hachage de mot de passe

    password_hash est une des fonction permettant de crée une clée de hachage pour un mdp

    La fonction password_hash() crée un nouveau hachage en utilisant un algorithme de hachage fort et irréversible.
    
    J'ai trouvé cela sur internet, sur le site de php.net/manual(site que l'on nous donnait dans les CM pour pouvoir les différentes fonctions présentes en PHP)

    PASSWORD_BCRYPT

    La constante PASSWORD_BCRYPT est utilisée pour créer une nouvelle table de hachage de mot de passe en utilisant l'algorithme CRYPT_BLOWFISH.

    Elle a toujours retourné le résultat de hachage en utilisant le format crypt "$2y$", qui sera toujours une chaîne de caractères de 60 caractères de long

    */

    $fichier_utilisateurs = 'texte.txt'; //je charge un fichier contenant les info suivantes id,email,mot de passe
    $utilisateur = [];
    if (file_exists($fichier_utilisateurs)) {
        $utilisateur = Recupdonne($fichier_utilisateurs); // j'envoie dans la fonction créer plus haut
    }

    // Vérifier si l'e-mail existe déjà
    foreach ($utilisateur as $user) { 
        if ($user[1] === $email) { //je regarde la 2e colonnes de mon tableau et la compare au mail utilisé 
            echo "Vous êtes déjà inscrit vous allez etre redirigé"; // dans le cas où le mail est indentique j'affiche le message 
            header("refresh:3;index.php");
            exit; // Arrête l'exécution du reste de la page
        }
    }

    // Ouvrir le fichier en mode ajout
    $fichiertexte = fopen($fichier_utilisateurs, "a");

    // Vérifier si l'ouverture du fichier a réussi
    if ($fichiertexte === false) {
        echo "Impossible d'ouvrir le fichier pour écrire."; 
        //j'affiche un message dans le cas de la non réussite de l'ouverture du fichier
         exit;
    }

    /* Écrire les données dans le fichier texte avec une nouvelle ligne 
    j'ai écrit les données suivantes id, email,mdp
    PHP_EOL est égale à PHP end of the line ce qui indique que ma ligne est terminée
    */
    fwrite($fichiertexte, $id . "," . $email . "," . $password ."," . $nom . "," . $prenom . PHP_EOL);

    // Fermer le fichier
    fclose($fichiertexte);

    /* Créer un nouveau fichier nommé en fonction de l'adresse e-mail
       ce fichier va permettre de stocker les différentes listes de l'utilisateurs 
    */
    $fichier_perso = $email. '.txt';
    $fichier_perso_def = fopen($fichier_perso, "a");

    // Vérifier si l'ouverture du fichier a réussi
    if ($fichier_perso_def === false) {
        echo "Impossible d'ouvrir le fichier personnel pour écrire."; // ecriture d'un message d'erreur
        exit;
    }

    // Écrire les données dans le fichier personnel

    //fwrite($fichier_perso_def, $prenom . "," . $nom . PHP_EOL);

    // Fermer le fichier personnel
    fclose($fichier_perso_def);

    header("Location: index.php");
    //renvoie vers la page d'acceuil
    exit();
}
?>
</body>
</html>

<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width">
  <title>Liste de course partagée</title>
  <link href="style.css" rel="stylesheet" type="text/css" />
</head>

<body>

  <form action="" method="post" class="center">
    <fieldset>

    <div class="center">
        <label for="email">Adresse e-mail de votre compte:</label>
        <input type="email" id="email2" name="email2" required />
        </div>
        
        <div class="center">
        <br>
        <br>
        <label for="email">Inscrire le nouveau code que vous voulez, il sera transmis à l'admin :</label>
        <input type="text" id="message" name="message" required />
      
      <input type="submit" value="Soumettre">
    </div>

    </fieldset>
  </form>

</body>

</html>

<?php 

function Recupdonne($filename) {
    $fichier = file("texte.txt");
    $utilisateurs = [];

    foreach ($fichier as $line) {
        $utilisateurs[] = str_getcsv($line, ",", "\"");
    }

    return $utilisateurs;
}

function authentification($x,$y,$utilisateur) {
    foreach ($utilisateur as $user) { 
        if ($user[1] === $x) {
            $fichier_admin=fopen("admin.txt",'a');
            fwrite($fichier_admin,  $x . "," . $y . PHP_EOL);
            fclose ($fichier_admin);
            
            return true;
        }
    }
    return false;
}

if (isset($_POST["email2"])) {
    $authentication = false;
    $utilisateur = Recupdonne("texte.txt");
    $x=$_POST['email2'];
    $y = password_hash(trim($_POST["message"]), PASSWORD_BCRYPT); 
    
    if(authentification($x,$y,$utilisateur)){
        echo "Nous avons envoyer votre demande à un admin";
        header("Location: index.php");
        exit();
    }
    else{
        echo"Nous n'avons pas trouver votre email,veuillez réitérer votre demande ";
    }
}
?>

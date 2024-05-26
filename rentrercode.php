<?php 
session_start();
$user_id = $_SESSION['id'];
?>

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
      <label for="code">CODE :</label>
      <input type="number" id="code" name="code"><br>
      <input type="submit" value="Soumettre">
    </fieldset>
  </form>

  <a href="liste.php?id=<?php echo $user_id ?>">
      <button id='retour'>Revenir au liste</button>
  </a>

</body>
<script src="liste.js"></script>
</html>

<?php 

function Recupdonnenum($filename) {
    $fichier = file($filename, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    $codes = [];
    foreach ($fichier as $line) {
        $codes[] = intval($line); // Convertir chaque ligne en nombre entier
    }
    return $codes;
}

if (isset($_POST["code"])) {
    $code = $_POST["code"];
    $user_mail = $_SESSION['email'];
    $nomtxtperso = $user_mail . '.txt';

    $fichier_global = fopen("fichier_global.txt", "r");
    $fichier_perso = fopen($nomtxtperso, "a+");


    $codesglobaux = Recupdonnenum("fichier_global.txt"); 
    $codesperso = Recupdonnenum($nomtxtperso);


    if (in_array($code, $codesglobaux)) {
        if(in_array ($code, $codesperso)){
          echo"Vous avez déja accès à la liste";
          exit;
        }
        fwrite($fichier_perso, $code . ',' . PHP_EOL);
        echo "Le code a bien fonctionné";
        header("Location: liste.php?id=" . $_SESSION['id']);
    }
    else {
        echo "Erreur : Le code n'existe pas";
    }


    fclose($fichier_global);
    fclose($fichier_perso);
}
?>

<?php
    session_start();
    $user_id = $_SESSION['id'];
    function Recupdonne($filename) {
        $fichier = file($filename);
        $listes = [];
      
        foreach ($fichier as $line) {
            $listes[] = str_getcsv($line, ",", "\"");
        }
      
        return $listes;
      }
    $nomfichier = $_SESSION["email"].'.txt'; 
    $listes = Recupdonne($nomfichier);
    $select = '<select id="aSupp" name="aSupp">';
    foreach ($listes as $liste){
        $select .= '<option value=' . $liste[0].'>'. $liste[0] .'</option>';
    }
    $select .= '</select>';

?>


<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width">
  <title> Liste de course partagée </title>
  <link href="style.css"a rel="stylesheet" type="text/css" />
</head>

<br>
    <h1> Supprimer une Liste</h1>
    <form method = "POST" action = "suppression.php">
        <label> Veuillez choisir L'ID de la liste à supprimer </label>
        <?php echo $select ?>
        <button type = 'submit'> Valider </button>
    </form>
</br>
    <a href="liste.php?id=<?php echo $user_id ?>">
      <button id='retour'>Revenir au liste</button>
  </a>
  <script src="liste.js"></script>
</body>
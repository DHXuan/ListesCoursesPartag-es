<?php 

session_start();
$user_id = $_SESSION['id'];
$user_mail = $_SESSION['email'];

function Recupdonne($filename) {
  $fichier = file($filename);
  $codes = [];

  foreach ($fichier as $line) {
      $codes[] = str_getcsv($line, ",", "\"");
  }

  return $codes;
}
// Vérifier si le formulaire a été soumis
if (isset($_POST["cat"]) &&isset($_POST["nomAliment"])&&isset($_POST["quantite"])&&isset($_POST["numListe"])){
  $nomtxtliste = $_POST["numListe"].'.txt';
  $nomtxtperso = $user_mail . '.txt';
  $fichier_globalv2 = fopen("fichier_global.txt", "a"); //fichier contenant l'ensemble des codes de toutes les listes existantes
  $fichier_globalv1 = fopen("fichier_global.txt","r");
  $fichier_liste = fopen($nomtxtliste, "a");//si retrouvé (déjà existant) alors le fichier correspondant à la liste est ouvert, sinon il est créé
  $fichier_persov2 = fopen($nomtxtperso, "a");//on lance la version add en premier dans le cas où le fichier n'existe pas : pour le créer et eviter un bug à la ligne suivante
  $fichier_persov1 = fopen($nomtxtperso,"r");
  
 $codesperso = Recupdonne($nomtxtperso); //Recup des codes des listes auxquel l'utilisatuer en question est déjà concerné
 $codesglobaux = Recupdonne("fichier_global.txt");

  if (isset($_POST["notes"])==false){
  $notes = " "; //on met un espace pour combler le vide s'il n'y a pas de commentaire afin d'éviter des bugs
} else {
  $notes = $_POST["notes"];
}
//echo 'abc' $_POST['numListe'];

  /*if ($fichier_liste === false) {
      echo "Impossible d'ouvrir le fichier pour écrire."; 
      //j'affiche un message dans le cas de la non réussite de l'ouverture du fichier
       exit;
  }*/
  $cat = $_POST["cat"];
  $quantite = $_POST["quantite"];
  $nomAliment = $_POST["nomAliment"];

  
  fwrite($fichier_liste, $cat . "," . $quantite . "," . $nomAliment ."," . $notes . PHP_EOL);
  
  
  fclose($fichier_liste);

  
   // Vérifier si l'e-mail existe déjà
   foreach ($codesperso as $codes) { 
    if ($codes[0] === $_POST['numListe']) { 
        fclose($fichier_persov1);
        fclose($fichier_persov2);
        fclose($fichier_globalv1);
        fclose($fichier_globalv2);
        header("Location: http://localhost:/liste.php?id=$user_id");
        exit; // Arrête l'exécution du reste de la page
    }
}

  fwrite($fichier_persov2, $_POST['numListe'] . ',' . PHP_EOL);
  fclose($fichier_persov1);
  fclose($fichier_persov2);

  foreach ($codesglobaux as $global) { 
    if ($global[0] === $_POST['numListe']) { 
        fclose($fichier_globalv1);
        fclose($fichier_globalv2);
        header("Location: http://localhost:/liste.php?id=$user_id");
        exit; // Arrête l'exécution du reste de la page
    }
} 

  fwrite($fichier_globalv2, $_POST['numListe'] . ',' . PHP_EOL);
  fclose($fichier_globalv1);
  fclose($fichier_globalv2);
}
else {
  echo "Champs manquants";
}

header("Location: http://localhost:/liste.php?id=$user_id");
?>
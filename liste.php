<?php

function Recupdonne($filename) {
  $fichier = file($filename);
  $codes = [];

  foreach ($fichier as $line) {
      $codes[] = str_getcsv($line, ",", "\"");
  }

  return $codes;
}



$catego = ['Fruits', 'Legumes', 'Viandes', 'Boissons', 'Surgelés','Autres'];

session_start();
// Vérifier si l'ID de l'utilisateur est présent dans la session
if(isset($_SESSION['id'])) {
  $user_id = $_SESSION['id'];
  // Utiliser $user_id pour personnaliser le contenu de la page ou pour toute autre fonctionnalité
} else {
  // Rediriger l'utilisateur vers la page de connexion s'il n'est pas connecté
  header("Location: http://localhost/index.php");
  exit;
}

function RestransListe($num){
  $initliste ='<div class="liste" id="'.$num.'."><h2 contenteditable="true">Saisissez le titre...</h2><div><h3>Code de la liste à partager : '.$num.'</h3></div>';
  $divfruits = '<div id="categorie"><h4>Fruits</h4>';
  $divlegumes ='<div id="categorie"><h4>Legumes</h4>';
  $divviandes ='<div id="categorie"><h4>Viandes</h4>';
  $divboissons ='<div id="categorie"><h4>Boissons</h4>';
  $divsurgeles ='<div id="categorie"><h4>Surgelés</h4>';
  $divproduitslaitiers ='<div id="categorie"><h4>Produits laitiers</h4>';
  $divautres = '<div id="categorie"><h4>Autres</h4>';
  $divplus ='<button>+</button>';
  $numlistefichier = $num.'.txt';
  $produits = Recupdonne($numlistefichier);
    foreach ($produits as $produit){
      //placer les produits dans la var declarée au début dans leur bonne catécorie
      //if ($liste[0] === 'Fruits'){
      $liste[$produit[0]][] = $produit;
      
        switch($produit[0]){
        case 'Fruits':
          $divfruits .= '<div class = "list-item"> '.$produit[1].'-'.$produit[2].'-'.$produit[3].'</div>';
          break;
        case 'Legumes':
          $divlegumes = $divlegumes .'<div class = "list-item"> '.$produit[1].'-'.$produit[2].'-'.$produit[3].'</div>';
          break;
        case 'Viandes':
          $divviandes .= '<div class = "list-item"> '.$produit[1].'-'.$produit[2].'-'.$produit[3].'</div>';
          break;
        case 'Boissons':
          $divboissons .=  '<div class = "list-item"> '.$produit[1].'-'.$produit[2].'-'.$produit[3].'</div>';
          break;
        case 'Surgelés' :
          $divsurgeles .= '<div class = "list-item"> '.$produit[1].'-'.$produit[2].'-'.$produit[3].'</div>';
          break;
        case 'Laits':
          $divproduitslaitiers .= '<div class = "list-item"> '.$produit[1].'-'.$produit[2].'-'.$produit[3].'</div>';
          break;
        case 'Autres':
          $divautres .='<div class = "list-item"> '.$produit[1].'-'.$produit[2].'-'.$produit[3].'</div>';
      }
      
    
    }
    $divfruits .= '</div>';
    $divlegumes .= '</div>';
    $divboissons .= '</div>';
    $divviandes .= '</div>';
    $divsurgeles .= '</div>';
    $divproduitslaitiers .= '</div>';
    $divautres .= '</div>';
  
    $divresult = $initliste.$divplus.'Ajouter un produit</br>'.$divfruits.$divlegumes.$divviandes.$divboissons.$divproduitslaitiers.$divsurgeles.$divautres.'</div>';
    
    return $divresult;
  }

$user_mail = $_SESSION['email'];
$fichier_perso = $user_mail . '.txt'; //titre du fichier perso
$codes = Recupdonne($fichier_perso); //tab de 1 colonnes et de n lignes pour les n codes compris dans le fichier perso
$ensembleListe = ''; 
$liste = [];
foreach ($codes as $code){
  $ensembleListe .= RestransListe($code[0]);
}
  


$script = '<script src="espoir.js"></script> ';

/*function creat_liste(){
 

  $user_mail = $_SESSION['email'];
  $fichier_perso = $user_mail . '.txt'; //titre du fichier perso
  $codes = Recupdonne($fichier_perso); //tab de 1 colonnes et de n lignes pour les n codes compris dans le fichier perso
  foreach ($codes as $code){
    $numlistefichier = $codes[0] . 'txt';
    $liste = Recupdonne($numlistefichier); //tab de 4 colonnes avec dans l'ordre le la catégorie, la quantité, le nom de l'aliment, les commentaires
    foreach $code in $liste{
      //placer les produits dans la var declarée au début dans leur bonne catécorie
      //if ($liste[0] === 'Fruits'){
      $catego[liste[0]] = $code;
      
    }
  }
  return 

}
*/
?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width">
  <title> Liste de course partagée </title>
  <link href="style.css"a rel="stylesheet" type="text/css" />
</head>

<body>

   <div class="menu"> 
    <div class = "container">
    <div class="abs">
      <h1><b>Votre Profil</b></h1>  
      
        <li> <?php echo $_SESSION['nom'] ?></li>
        <li> <?php echo $_SESSION['prenom'] ?></li>
        <li>  Email : <?php echo $_SESSION['email']?></li>
        <br/>
        <li><button id="ajoutListe">📝</button> 
          <b>Ajouter une liste</b></li>
      </br>
      <li>
        <a href="rentrercode.php?id=<?php echo $_SESSION['id'] ?>">
          <button id = 'code'> Rentrer un code </button>
        </li>
        </br>
        <button id="retour">↩️</button> 
        <a href="deco.php?id=<?php echo $_SESSION['id'] ?>">
          <!--<input type="button"  class="Deconnexion "id="Deconnexion" name="Deconnexion" value="Deconnexion"/> -->
          <button id = 'deco'> Deconnexion </button>
          </a>

      </ul>

    </div>
    </div>


  <div class = "emplacement_liste" id = 'liste'>
    <div class = "epingles" id = 'epingles'>
       <h2>Listes Epinglées</h2>
     </div>
    <div class = "nonep" id = 'nonep'>
       <?php echo $ensembleListe ?>
      
    </div>
  </div>
  <script src="espoir.js"></script> 
  <?php echo $script ?>
</body>

</html>

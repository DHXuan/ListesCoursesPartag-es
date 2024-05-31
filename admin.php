<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width">
  <title>Mode Admin - Liste de course partagée</title>
  <link href="style.css" rel="stylesheet" type="text/css" />
</head>

<body>
  <header>
    <i>Mode Admin - Liste de course partagée</i>
  </header>

  <main>
    <section>
      <h2>Bienvenue dans le Mode Admin</h2>
      <p>En tant qu'administrateur, vous avez accès à plusieurs outils et fonctionnalités pour gérer la liste de courses partagée. Voici un aperçu de ce que vous pouvez faire :</p>
      
      <ul>
        <li>
          <h3>Demande de nouveaux mot de passe</h3>
          <p>Vous pouvez voir les demandes pour modifier le mot de passe d'un utilisateurs.<br>
            Dans la première colonne vous verrez le mail de l'utilisateurs en questions et dans la deuxième colonne vous verrez par quoi l'utilisateurs veut le remplacer.<br>
            Il faudra faire le travail manuellement dans le fichier texte.txt</p>
        </li>
        <li>
          <h3>Recuperer une liste</h3>
          <p>Vous pouvez recuperer une liste appartenant à n'importe quel utilisateur</p>
        </li>
      </ul>
      <br>
      <br>
      <h2>Liste des Demandes</h2>
      <?php
      session_start();
      $user_id = $_SESSION['id'];
      function Recupdonne($filename) {
        $fichier = file($filename);
        $utilisateurs = [];

        foreach ($fichier as $line) {
            $utilisateurs[] = str_getcsv($line, ",", "\"");
        }

        return $utilisateurs;
      }

      function afficherTableau($data) {
          if (empty($data) || !is_array($data)) {
              echo "<p>Aucune donnée disponible pour afficher le tableau.</p>";
              return;
          }

          echo '<table border="1" cellpadding="10" cellspacing="0">';
          
          // En-tête du tableau
          echo '<thead><tr>';
          foreach ($data[0] as $header) {
              echo '<th>' . htmlspecialchars($header) . '</th>';
          }
          echo '</tr></thead>';
          
          // Corps du tableau
          echo '<tbody>';
          for ($i = 1; $i < count($data); $i++) {
              echo '<tr>';
              foreach ($data[$i] as $cell) {
                  echo '<td>' . htmlspecialchars($cell) . '</td>';
              }
              echo '</tr>';
          }
          echo '</tbody>';
          
          echo '</table>';
      }

      $utilisateurs = Recupdonne("admin.txt");
      afficherTableau($utilisateurs);
      ?>
    </section>
    <br>
    <a href="liste.php?id=<?php echo $user_id ?>">
      <button id='retour'>Revenir au liste</button>
  </main>

</body>

</html>

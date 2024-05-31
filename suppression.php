<?php
    session_start();
    function Recupdonne($filename,$aSupp) {
        $fichier = file($filename);
        $listes = [];
        $aSuppvir = " ".$aSupp.',';
        echo $aSuppvir;
       //$code='';
        foreach ($fichier as $line) {
            /*for ($i = 0; $i < strlen($line); $i++){
                $code .= $line[$i];
                echo $code;
            }*/
            
            //echo $code . ';';
            echo $line;
            if (trim($line) == trim($aSuppvir)){
                
                echo "liste à supp trouvée".PHP_EOL;
                continue;
            }
            else{
                $listes[] = str_getcsv($line, ",", "\"");
            }
        }
      
        return $listes;
    }
      if (isset($_POST['aSupp'])==0) {
        echo 'pb reception aSupp';
        exit;
      }
      $aSupp = $_POST['aSupp'];
      echo $aSupp;
      $fichierSupp = fopen('Supprimes.txt','a');
      fwrite ($fichierSupp, $_SESSION['email'] .',' . $aSupp . PHP_EOL); //sauvegarde des listes supprimes + utilisateur pour lequel elle a été supprimé.
      $fichierliste = $_SESSION['email'].'.txt';
      echo $fichierliste;
      $listes = Recupdonne($fichierliste,$aSupp);
      $fichierperso = fopen($fichierliste,'w');
      foreach ($listes as $liste){
        fwrite($fichierperso, $liste[0].','. PHP_EOL);
        echo $liste[0].PHP_EOL;
      }
fclose($fichierSupp);
fclose($fichierperso);

header("Location: http://localhost:/liste.php?id=$user_id");

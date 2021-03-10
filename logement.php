<?php
require_once "constantes.php";
require_once "fonctions.php";
require_once "actions.php";
$titre = "Logement";
// seeArray($_POST);
// seeArray($_FILES);
// seeArray($_GET);
?>

<!DOCTYPE html>
<html lang="fr">

<head>
  <?php include "elements/head.php" ?>
</head>

<body>

  <?php include "elements/bandeau.php"; ?>


  <div class="container">
    <div class="row my-4">
      <div class="col-md-5">
        <h1><?= TITRE ?> - <small><?php echo $titre ?></small> </h1>
      </div>
    </div>

    <div class="row">
      <div class="col">
        <h2>Bienvenue dans l'affichage par logement</h2>
      </div>
    </div>

    <!-- Affichage de message de confirmation ou d'erreur de création de logements -->
    <div class="row">
      <div class="col-md-6 offset-md-3 text-center">
        <?php
        include "elements/messages.php";
        ?>
      </div>
    </div>
    <!-- Fin d'affichage des erreurs -->


    <!--Début du code propre à la page-->

    <div class="row">
      <div class="col">
        <!-- Affichage des différents comptes -->
        <?php
        $logements = listerFichesLogements();
        $id = (isset($_GET["id"])) ? $_GET["id"] : "";
        // seeArray($logements);
        foreach ($logements as $idlogement => $logement) {
          if ($logement['id_logement'] == $id) {
            $html = "<h3 class='mt-3'>Logement : numero {$id} concernant {$logement['titre']}<h3>
            <br>
            <p>adresse :{$logement['adresse']} code postal : {$logement['cp']}ville : {$logement['ville']} </p>
            <br>
            <p>surface : {$logement['surface']} prix : {$logement['prix']} type: {$logement['type']} </p>
            <br>
            <p>description : {$logement['description']}</p>
            <br>
            <div>image : <img class='img-fluid' src='img/{$logement["image"]}' alt='{$logement["titre"]}'></div>";
          } else {
            $html = "";
          }
          echo $html;
        }
        ?>
        <!-- Fin d'affichage des différents comptes -->
      </div>
    </div>
    <!--Fin du code propre à la page-->
  </div>


  <?php include "elements/scripts.php"; ?>

</body>

</html>
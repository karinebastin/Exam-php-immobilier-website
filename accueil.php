<?php
require_once "constantes.php";
require_once "fonctions.php";
require_once "actions.php";
$titre = "Accueil des logements";
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
      <div class="col-md-6">
        <h1><?= TITRE ?> - <small><?php echo $titre ?></small> </h1>
      </div>
    </div>

    <div class="row">
      <div class="col">
        <h2>Bienvenue dans l'affichage des logements</h2>
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


    <!-- Affichage le tableau des logements-->
    <?php
    include "logements.php";
    ?>

    <!-- Fin d'affichage des différents logements -->

    <!-- Formulaire de création de logements -->
    <div class="row">
      <div class="col">
        <h3>Ajouter un logement</h3>
        <div id="msgErreurs"></div>
        <form method="post" class="form-inline mt-3 mb-5" enctype="multipart/form-data" onsubmit="return verifJS(this);">
          <input type="hidden" name="action" value="addLogement">

          <input type="text" name="titre" placeholder="titre" class="form-control mr-2">
          <input type="text" name="adresse" placeholder="adresse" class="form-control mr-2">
          <input type="text" name="ville" placeholder="ville" class="form-control mr-2">
          <input type="text" name="cp" placeholder="Code Postal" class="form-control mr-2">
          <input type="text" name="surface" placeholder="surface" class="form-control mr-2">
          <input type="text" name="prix" placeholder="prix" class="form-control mr-2">
          <select name='type' id='type' class='form-control mr-2'>
            <option value="location">Location</option>
            <option value="vente">Vente</option>
          </select>
          <input type="text" name="description" placeholder="description" class="form-control mr-2">
          <input type="file" name="image" onchange="previsualiser(this)" value="<?php echo $image; ?>" class="mx-4 mb-2" />
          <input type="submit" value="Ajouter le logement" class="btn btn-primary">
        </form>
      </div>
    </div>
    <!-- Fin d'affichage du formulaire-->
  </div>


  <?php include "elements/scripts.php"; ?>

</body>

</html>
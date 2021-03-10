<?php
//================
// Action
//================

// on récupère les actions de modif url $_POST
$action = (isset($_POST["action"])) ? $_POST["action"] : "";

//================
// Action de téléchargement de l'image
//================

if (isset($_FILES["image"])) {

  $erreurs = [];

  // test du champs image en lien
  $image = (isset($_FILES["image"]["name"])) ? $_FILES["image"]["name"] : "";
  if ($image != "") {
    $chemin = generateLien($image);
    $image = $chemin;


    // test du type de fichier envoyé
    if ($_FILES["image"]["type"] != "image/jpeg" && $_FILES["image"]["type"] != "image/png") {
      array_push($erreurs, "Merci d'envoyer une image JPG ou PNG");
    }

    // test du poid du fichier
    if ($_FILES["image"]["size"] > 1000000) {
      array_push($erreurs, "Merci d'envoyer un fichier inférieur à 1000ko");
    }

    if ($erreurs) {
      foreach ($erreurs as $erreur) {
        // on affiche les erreurs
        echo "<p>$erreur<p>";
      }
    } else {
      // prêt à enregistrer
      // on verif si création
      if (!file_exists("./img")) {
        mkdir("./img", 0755);
      }
      // on enregistre proprement le fichier
      $oldPath = $_FILES["image"]["tmp_name"];

      $newPath = "./img/" . $chemin;
      if (move_uploaded_file($oldPath, $newPath)) {
        // déplacement ok
        echo "<img src='{$newPath}' width='250' >";
        //enregistrer le chemin en base
      } else {
        // c'est mal passé
        array_push($erreurs, "merci de recommencer le téléchargement");
        // echo "merci de recommencer";
        echo $erreur;
      }
    }
  } else {
    $image = "";
  }
}

//================
// Enregistrement du logement à partir du formulaire
//================
if ($action == "addLogement") {
  // or récupère à la récupération des autres données
  $titre = (isset($_POST["titre"])) ? $_POST["titre"] : "";
  $adresse = (isset($_POST["adresse"])) ? $_POST["adresse"] : "";
  $ville = (isset($_POST["ville"])) ? $_POST["ville"] : "";
  $cp = (isset($_POST["cp"])) ? $_POST["cp"] : "";
  $surface = (isset($_POST["surface"])) ? $_POST["surface"] : "";
  $prix = (isset($_POST["prix"])) ? $_POST["prix"] : "";
  $type = (isset($_POST["type"])) ? $_POST["type"] : "";
  $description = (isset($_POST["description"])) ? $_POST["description"] : "";
  $image = (isset($_FILES["image"]["name"])) ? $chemin : "";

  // Test d'erreurs
  $erreur = [];

  // test1 titre
  if ($titre == "") {
    $erreur[] = "Merci de renseigner le titre <br>";
  }

  // test2 adresse
  if ($adresse == "") {
    $erreur[] = "Merci de renseigner l'adresse <br>";
  }

  // test3 ville
  if ($ville == "") {
    $erreur[] = "Merci de renseigner la ville <br>";
  }

  // test4 code postale
  if ($cp == "") {
    $erreur[] = "Merci de renseigner le code postale <br>";
  } else if (!preg_match("/^(F-)?((2[A|B])|[0-9]{2})[0-9]{3}$/", $cp)) {
    $erreur[] = "Merci de renseigner un code postale français <br>";
  }

  // test5 surface
  if ($surface == "") {
    $erreur[] = "Merci de renseigner la surface du logement <br>";
  } else if (!preg_match("/[0-9]/", $surface)) {
    $erreur[] = "Merci de renseigner une surface en nombre entier <br>";
  }

  // test6 prix
  if ($prix == "") {
    $erreur[] = "Merci de renseigner le prix du logement <br>";
  } else if (!preg_match("/[0-9]/", $prix)) {
    $erreur[] = "Merci de renseigner un prix en nombre entier <br>";
  }

  // test7 type (peut être pas necessaire avec liste de choix)
  if ($type == "") {
    $erreur[] = "Merci de renseigner le type du logement <br>";
  }

  // test8
  if ($image == "") {
    $erreur[] = "Merci de renseigner l'image <br>";
  }



  if (!$erreur) {
    // Ajout en BDD
    $r = ajouterLogements($titre, $adresse, $ville, $cp, $surface, $prix, $type, $image, $description);
    if ($r) {
      // on prépare le message de confirmation que l'on souhaite afficher plus bas
      $msg = "Logement ajouté.";
    } else {
      $erreur[] = "Erreur lors de l'ajout.";
    }
  }
}

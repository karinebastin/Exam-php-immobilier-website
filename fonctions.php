<?php
/*FONCTIONS*/

//=====================================================
// Permet d'afficher un tableau
//=====================================================
function seeArray($tab)
{
  echo "<pre>";
  print_r($tab);
  echo "</pre>";
}

// =====================================================
// retourne lien d'image generé
// =====================================================
function generateLien($image)
{
  $image = "logement_" . time() . ".jpg";
  return $image;
}

//=====================================================
// longueur de text si trop grand afiche le début et ...
//=====================================================
// longueur de description
function longueur($text)
{
  if (isset($text)) {
    if (strlen($text) > 50) {
      $maxtext = substr($text, 0, 50) . "[...]";
    } else {
      $maxtext = $text;
    }
    return $maxtext;
  }
}


//=====================================================
// Connexion en PDO
//=====================================================
function connexionPDO()
{
  try {
    $options = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION];
    $db = new PDO("mysql:host=" . HOST . ";dbname=" . DB, LOGIN, PWD, $options);
    return $db;
  } catch (PDOException $e) {
    echo $e->getMessage();
    die();
  }
}

//=====================================================
// Ajout d'un logement dans la bdd
// =====================================================

function ajouterLogements($titre, $adresse, $ville, $cp, $surface, $prix, $type, $image, $description)
{
  $db = ConnexionPDO();
  $sql = "INSERT INTO logement VALUES (NULL,:titre,:adresse,:ville,:cp,:surface,:prix,:type,:image,:description)";
  try {
    $query = $db->prepare($sql);
    $query->execute(["titre" => $titre, "adresse" => $adresse, "ville" => $ville, "cp" => $cp, "surface" => $surface, "prix" => $prix, "type" => $type, "image" => $image, "description" => $description]);
    return true;
  } catch (PDOException $e) {
    // echo $e->getMessage();
    return false;
  }
}

//=====================================================
// Affiche les produits de la bdd
//=====================================================

function listerFichesLogements()
{
  $db = connexionPDO();
  //sql
  $sql = "SELECT * FROM logement";
  // execution de l'ordre
  try {
    $query = $db->query($sql);

    // s'il y a au moins un compte
    if ($query->rowCount() > 0) {
      $logements = $query->fetchAll(PDO::FETCH_ASSOC);
      return $logements;
    }
  } catch (PDOException $e) {
    echo $e->getMessage();
  }
}

//=====================================================
//  affiche le produit en fonction d'un tableau contenant les données
//=====================================================
function fichesLogements($logements)
{
  $html = "<div class='row'>
      <div class='col'>
      <h3>Liste des logements</h3>
        <table class='table table-bordered table-sm table-hover my-5'>
          <thead class='thead-dark my-3'>
              <tr>
                  <th>Titre</th>
                  <th>Adresse</th>
                  <th>Ville</th>
                  <th>Code Postal</th>
                  <th>Surface</th>
                  <th>Prix</th>
                  <th>Type</th>
                  <th>Image</th>
                  <th>Description</th>
                  <th></th>
              </tr>
          </thead>
          <tbody>";

  foreach ($logements as $i => $logement) {
    $descriptionMax = longueur($logement["description"]);
    $html .= "<tr style='border:1px solid lightgray;'>
    <td>{$logement["titre"]}</td>
    <td>{$logement["adresse"]}</td>
    <td>{$logement["ville"]}</td>
    <td>{$logement["cp"]}</td>
    <td>{$logement["surface"]}</td>
    <td>{$logement["prix"]}</td>
    <td>{$logement["type"]}</td>
    <td>
      <img class='img-fluid' src='img/{$logement["image"]}' alt='{$logement["titre"]}'>
    </td>
    <td>{$descriptionMax}</td>
    <td class='d-flex justify-content-center align-items-end border-0'>
      <a href='logement.php?id={$logement["id_logement"]}' class='btn btn-warning btn-sm w30px mx-2'><i class='fas fa-pen'></i></a></td>
    </tr>
    ";
  }
  $html .= "</tbody>
  </table>
  </div>
    </div>";
  return $html;
};

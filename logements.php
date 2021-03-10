<!-- Affichage des différents logements -->

<?php
$r = listerFichesLogements();
$affichage = fichesLogements($r);
echo $affichage;
?>
<!-- Fin d'affichage des différents logements -->
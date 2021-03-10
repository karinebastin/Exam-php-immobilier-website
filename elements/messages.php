<?php
// si $msg existe
if (isset($msg)) {
    echo "<div class='alert alert-success'>$msg</div>";
}
// si $erreur existe
if (isset($erreur)) {
    foreach ($erreur as $e) {
        echo "<div class='alert alert-danger'>$e</div>";
    }
}

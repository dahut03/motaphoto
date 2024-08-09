<?php
// Chemin vers le dossier des images
$directory = 'images/';

// Récupérer les fichiers dans le dossier
$images = glob($directory . '*.{jpg,jpeg,png,gif}', GLOB_BRACE);

// Convertir le tableau en JSON
echo json_encode($images);
?>
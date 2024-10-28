<?php
header('Content-Type: application/json');

// Spécifiez le dossier d'images
$imageFolder = get_stylesheet_directory() . '/images/photos/';
$baseURL = get_stylesheet_directory_uri() . '/images/photos/';

// Liste tous les fichiers dans le dossier
$images = [];
if (is_dir($imageFolder)) {
    $files = scandir($imageFolder);
    foreach ($files as $file) {
        $filePath = $imageFolder . $file;
        if (is_file($filePath) && preg_match('/\.(jpg|jpeg|png|webp)$/i', $file)) {
            $images[] = $baseURL . $file;
        }
    }
}

// Retourne la liste en JSON
echo json_encode($images);
exit;

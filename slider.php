<?php
function generate_super_slider() {
    // Chemin des images dans le répertoire OceanWP Child
    $image_path = get_stylesheet_directory_uri() . '/images/photos/';

    // Récupérer les posts du slider
    $args = array(
        'post_type' => 'photo',
        'posts_per_page' => 16, 
        'orderby' => 'rand'
    );
    $posts = get_posts($args);
    

}   

?>
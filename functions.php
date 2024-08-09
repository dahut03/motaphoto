<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

// BEGIN ENQUEUE PARENT ACTION
// AUTO GENERATED - Do not modify or remove comment markers above or below:

if ( !function_exists( 'chld_thm_cfg_locale_css' ) ):
    function chld_thm_cfg_locale_css( $uri ){
        if ( empty( $uri ) && is_rtl() && file_exists( get_template_directory() . '/rtl.css' ) )
            $uri = get_template_directory_uri() . '/rtl.css';
        return $uri;
    }
endif;
add_filter( 'locale_stylesheet_uri', 'chld_thm_cfg_locale_css' );
         
if ( !function_exists( 'child_theme_configurator_css' ) ):
    function child_theme_configurator_css() {
        wp_enqueue_style( 'chld_thm_cfg_child', trailingslashit( get_stylesheet_directory_uri() ) . 'style.css', array( 'font-awesome','simple-line-icons','oceanwp-style' ) );
    }
endif;
add_action( 'wp_enqueue_scripts', 'child_theme_configurator_css', 10 );

// END ENQUEUE PARENT ACTION
function register_footer_menu() {
    register_nav_menu('footer-menu', __('Footer Menu'));
}
add_action('init', 'register_footer_menu');


function enqueue_custom_scripts() {
    // Enqueue your custom script
    wp_enqueue_script(
        'custom-scripts', // Handle for your script
        get_stylesheet_directory_uri() . '/js/scripts.js', // Path to your script file
        array(), // Dependencies (if any)
        null, // Version number (null for no version)
        true // Load script in footer
    );
}
add_action('wp_enqueue_scripts', 'enqueue_custom_scripts');


function my_custom_menu_shortcode() {
    // Placez ici le code PHP que vous souhaitez exécuter
    $output = "<button id='contactButton' class='ma-classe-personnalisee'>CONTACT</button>";
    return $output;
}
add_shortcode( 'custom_menu_php', 'my_custom_menu_shortcode' );

function my_theme_enqueue_scripts() {
    wp_enqueue_script( 'custom-scripts', get_template_directory_uri() . '/js/scripts.js', array('jquery'), null, true );
}
add_action( 'wp_enqueue_scripts', 'my_theme_enqueue_scripts' );


function get_random_background_image() {
    // Array des URLs des images
    $background_images = array(
        get_template_directory_uri() . '/../oceanwp-child/images/photos/nathalie-1.jpeg',
        get_template_directory_uri() . '/../oceanwp-child/images/photos/nathalie-2.jpeg',
        get_template_directory_uri() . '/../oceanwp-child/images/photos/nathalie-3.jpeg',
        get_template_directory_uri() . '/../oceanwp-child/images/photos/nathalie-4.jpeg',
        get_template_directory_uri() . '/../oceanwp-child/images/photos/nathalie-5.jpeg',
        get_template_directory_uri() . '/../oceanwp-child/images/photos/nathalie-6.jpeg',
        get_template_directory_uri() . '/../oceanwp-child/images/photos/nathalie-7.jpeg',
        get_template_directory_uri() . '/../oceanwp-child/images/photos/nathalie-8.jpeg',
        get_template_directory_uri() . '/../oceanwp-child/images/photos/nathalie-9.jpeg',
        get_template_directory_uri() . '/../oceanwp-child/images/photos/nathalie-10.jpeg',
        get_template_directory_uri() . '/../oceanwp-child/images/photos/nathalie-11.jpeg',
        get_template_directory_uri() . '/../oceanwp-child/images/photos/nathalie-12.jpeg',
        get_template_directory_uri() . '/../oceanwp-child/images/photos/nathalie-13.jpeg',
        get_template_directory_uri() . '/../oceanwp-child/images/photos/nathalie-14.jpeg',
        get_template_directory_uri() . '/../oceanwp-child/images/photos/nathalie-15.jpeg',
        // Ajoutez ici plus d'images si nécessaire
    );

    // Sélectionner une image aléatoirement
    $random_image = $background_images[array_rand($background_images)];

    return $random_image;
}

function add_custom_background_style() {
    // Appeler la fonction pour obtenir l'image aléatoire
    $background_image = get_random_background_image();

    // Injecter le CSS pour le fond personnalisé
    echo "
    <style>
        body {
            background-image: url('$background_image');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }
    </style>
    ";
}
add_action('wp_head', 'add_custom_background_style');

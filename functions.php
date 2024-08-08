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

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
    // Enqueue your custom script only once
    wp_enqueue_script(
        'custom-scripts', // Handle for your script
        get_stylesheet_directory_uri() . '/js/scripts.js', // Path to your script file
        array('jquery'), // Dependencies (include jQuery if needed)
        null, // Version number (null for no version)
        true // Load script in footer
    );

    // Pass the admin-ajax.php URL to the script
    wp_localize_script('custom-scripts', 'ajax_object', array(
        'ajax_url' => admin_url('admin-ajax.php')
    ));
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




// Shortcode pour afficher le champ 'type'
function shortcode_type() {
    $type = get_field('type');
    if ($type) {
        return esc_html($type);
    }
    return '';
}
add_shortcode('type', 'shortcode_type');

// Shortcode pour afficher le champ 'référence'
function shortcode_reference() {
    $reference = get_field('reference');
    if ($reference) {
        return esc_html($reference);
    }
    return '';
}
add_shortcode('reference', 'shortcode_reference');

// Shortcode pour afficher les catégories d'un post spécifique (sans puces ni retour à la ligne)
function display_post_categories_inline_shortcode($atts) {
    global $post;

    // Extraire les attributs passés au shortcode, s'il y en a
    $atts = shortcode_atts(array(
        'id' => $post->ID, // Par défaut, l'ID du post actuel
    ), $atts);

    // Récupérer les catégories pour le post spécifié
    $terms = get_the_terms($atts['id'], 'categorie');

    if (!empty($terms) && !is_wp_error($terms)) {
        $output = '';
        $separator = ', '; // Séparateur entre les catégories
        foreach ($terms as $term) {
            $output .= esc_html($term->name) . $separator;
        }
        // Supprimer le dernier séparateur
        $output = rtrim($output, $separator);
        return $output;
    }

    return 'No categories found';
}
add_shortcode('categories', 'display_post_categories_inline_shortcode');


// Shortcode pour afficher les formats d'un post spécifique (sans puces ni retour à la ligne)
function display_post_formats_inline_shortcode($atts) {
    global $post;

    // Extraire les attributs passés au shortcode, s'il y en a
    $atts = shortcode_atts(array(
        'id' => $post->ID, // Par défaut, l'ID du post actuel
    ), $atts);

    // Récupérer les formats pour le post spécifié
    $terms = get_the_terms($atts['id'], 'format');

    if (!empty($terms) && !is_wp_error($terms)) {
        $output = '';
        $separator = ', '; // Séparateur entre les formats
        foreach ($terms as $term) {
            $output .= esc_html($term->name) . $separator;
        }
        // Supprimer le dernier séparateur
        $output = rtrim($output, $separator);
        return $output;
    }

    return 'No formats found';
}
add_shortcode('formats', 'display_post_formats_inline_shortcode');


// Shortcode pour afficher le titre du post ou de la page (sans puces ni retour à la ligne)
function display_post_title_shortcode_inline($atts) {
    global $post;

    // Extraire les attributs passés au shortcode, s'il y en a
    $atts = shortcode_atts(array(
        'id' => $post->ID, // Par défaut, l'ID du post actuel
    ), $atts);

    // Récupérer le titre du post spécifié
    $title = get_the_title($atts['id']);

    // Retourner le titre ou un message si le post est introuvable
    return $title ? esc_html($title) : 'Post not found';
}
add_shortcode('titre', 'display_post_title_shortcode_inline');


// Shortcode pour afficher l'année en cours
function display_current_year_shortcode() {
    return date('Y');
}
add_shortcode('annee', 'display_current_year_shortcode');

function custom_contact_button_shortcode($atts) {
    // Extraire les attributs du shortcode (optionnel)
    $atts = shortcode_atts(
        array(
            'text' => 'Contactez-nous', // Texte par défaut du bouton
            'id' => 'contactButton1',    // ID par défaut du bouton
        ), $atts, 'contact_button'
    );

    // Retourner le HTML du bouton
    return '<button id="' . esc_attr($atts['id']) . '" class="contact-button">' . esc_html($atts['text']) . '</button>';
}
add_shortcode('contact_button', 'custom_contact_button_shortcode');







function custom_lightbox_script() {
    // Récupérer les posts du slider
    $args = array(
        'post_type' => 'photo',
        'posts_per_page' => -1, 
        'orderby' => 'rand'
    );
    $posts = get_posts($args);

    $images = array();

    foreach ($posts as $post) {
        // Récupérer l'URL de l'image principale
        $image_url = get_the_post_thumbnail_url($post->ID, 'large');

        // Récupérer les références depuis le groupe de champs 'Détails Photo'
        $details_photo = get_field('details_photo', $post->ID);
        $reference = null;
        if (!empty($details_photo)){
            $reference = $details_photo['reference'];
        }


        // Récupérer les catégories liées
        $categories = wp_get_post_terms($post->ID, 'categorie', array('fields' => 'names'));
        $categories_list = implode(', ', $categories);

        // Ajouter les informations de l'image dans le tableau
        $images[] = array(
            'url' => $image_url,
            'reference' => $reference,
            'categories' => $categories_list
        );
    }

    ?>
    
    <?php
}
add_action('wp_footer', 'custom_lightbox_script');







function custom_reference_shortcode($atts) {
    global $post;

    // Récupérer les détails de la photo depuis le groupe de champs 'Détails Photo'
    $details_photo = get_field('details_photo', $post->ID);

    // Récupérer la référence spécifique à partir de ce groupe
    $reference = $details_photo['reference'];

    // Si la référence est vide, retourner un texte par défaut
    if (!$reference) {
        return 'Aucune référence disponible';
    }

    return $reference;
}
add_shortcode('custom_reference', 'custom_reference_shortcode');
















function custom_hover_icon_script() {
    ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var linkedImageWrappers = document.querySelectorAll('.linked-image-wrapper');
            linkedImageWrappers.forEach(function(wrapper) {
                wrapper.addEventListener('mouseover', function() {
                    this.querySelector('.eye-icon').style.opacity = '1';
                });
                wrapper.addEventListener('mouseout', function() {
                    this.querySelector('.eye-icon').style.opacity = '0';
                });
            });
        });
    </script>
    <?php
}
add_action('wp_footer', 'custom_hover_icon_script');




// Dans functions.php de votre thème enfant
function add_random_image_script() {
    if (is_front_page()) { // Vérifie si c'est la page d'accueil
        // Récupère toutes les images dans le répertoire 'images/photos/'
        $directory = get_stylesheet_directory() . '/images/photos/';
        $image_files = glob($directory . '*.{jpg,jpeg,png,webp}', GLOB_BRACE);

        // Génère la liste d'URL d'images à partir des noms de fichiers trouvés
        $image_urls = array_map(function($file) {
            return get_stylesheet_directory_uri() . '/images/photos/' . basename($file);
        }, $image_files);

        ?>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var images = <?php echo json_encode($image_urls); ?>;

                var randomImage = images[Math.floor(Math.random() * images.length)];
                var container = document.createElement('div');
                container.className = 'image-random-container';

                var img = document.createElement('img');
                img.src = randomImage;
                container.appendChild(img);

                var text = document.createElement('div');
                text.className = 'overlay-text';
                text.innerText = 'Photographe Event';
                container.appendChild(text);

                // Cibler le header pour insérer le conteneur juste après
                var header = document.querySelector('header'); // Utiliser 'header' pour cibler l'élément header
                if (header) {
                    header.insertAdjacentElement('afterend', container); // Insère le conteneur juste après le header
                } else {
                    document.body.insertBefore(container, document.body.firstChild); // Fallback au cas où le header n'est pas trouvé
                }
            });
        </script>
        <?php
    }
}
add_action('wp_footer', 'add_random_image_script');



function custom_mobile_script() {
    ?>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        function moveImageOnMobile() {
            // Sélectionnez les éléments nécessaires
            var imageBlock = document.querySelector('.image-block');
            var textBlock = document.querySelector('.text-block');
            var container = document.querySelector('.container');

            // Vérifiez que les éléments existent et qu'ils sont des enfants directs du même conteneur
            if (imageBlock && textBlock && container && container.contains(imageBlock) && container.contains(textBlock)) {
                if (window.innerWidth <= 768) {
                    // Déplacer l'image avant le texte
                    container.insertBefore(imageBlock, textBlock);
                } else {
                    // Remettre l'ordre original si nécessaire
                    if (textBlock.nextElementSibling !== imageBlock) {
                        container.insertBefore(textBlock, imageBlock);
                    }
                }
            }
        }

        // Appeler la fonction au chargement de la page
        moveImageOnMobile();

        // Appeler la fonction à chaque redimensionnement de la fenêtre
        window.addEventListener('resize', moveImageOnMobile);
    });
    </script>
    <?php
}
add_action('wp_footer', 'custom_mobile_script');



function display_images_by_custom_category($atts) {
    ob_start();
    
    // Extraire les attributs du shortcode
    $atts = shortcode_atts(array(
        'count' => 2, // Nombre d'images à afficher
    ), $atts, 'images_by_custom_category');
    
    if (is_singular('photo')) { 
        $terms = get_the_terms(get_the_ID(), 'categorie');
        if ($terms && !is_wp_error($terms)) {
            $term_ids = wp_list_pluck($terms, 'term_id');
            $already_displayed_ids = array(get_the_ID()); 
            $selected_images = array();

            while (count($selected_images) < $atts['count']) {
                $args = array(
                    'post_type' => 'photo', 
                    'tax_query' => array(
                        array(
                            'taxonomy' => 'categorie',
                            'field'    => 'term_id',
                            'terms'    => $term_ids,
                            'operator' => 'IN',
                        ),
                    ),
                    'post__not_in' => $already_displayed_ids,
                    'posts_per_page' => 1,
                    'orderby' => 'rand'
                );

                $related_posts = new WP_Query($args);

                if ($related_posts->have_posts()) {
                    $related_posts->the_post();
                    $post_id = get_the_ID();
                    
                    // Ajouter l'image si elle n'a pas déjà été sélectionnée
                    if (!in_array($post_id, $already_displayed_ids)) {
                        $already_displayed_ids[] = $post_id;
                        $selected_images[] = array(
                            'image_url' => get_the_post_thumbnail_url($post_id, 'large'),
                            'post_link' => get_permalink($post_id)
                        );
                    }
                } else {
                    // Si aucune autre image n'est trouvée, on arrête la boucle
                    break;
                }

                wp_reset_postdata();
            }

            if (!empty($selected_images)) {
                echo '<div class="related-images">';
                foreach ($selected_images as $image_data) {
                    echo '<div class="related-image2" style="background-image: url(' . esc_url($image_data['image_url']) . ');">';
                    echo '<div class="overlay-icons2">';
                    echo '<div class="fullscreen-icon2" onclick="viewFullscreen(\'' . esc_url($image_data['image_url']) . '\')">⛶</div>';
                    echo '<a href="' . esc_url($image_data['post_link']) . '" class="eye-icon2">';
                    echo '<img src="' . get_stylesheet_directory_uri() . '/images/Eye.png" alt="Eye Icon" class="eye-image2">';
                    echo '</a>';
                    echo '</div>';
                    echo '</div>';
                }
                echo '</div>';
            } else {
                echo 'Aucune image trouvée dans cette catégorie.';
            }
        } else {
            echo 'Aucune catégorie trouvée.';
        }
    } else {
        echo 'Ce shortcode ne fonctionne pas sur cette page.';
    }
    
    return ob_get_clean();
}
add_shortcode('images_by_custom_category', 'display_images_by_custom_category');





add_action('wp_ajax_load_more_images', 'load_more_images_ajax');
add_action('wp_ajax_nopriv_load_more_images', 'load_more_images_ajax');









function mytheme_setup() {
    // Support de l'éditeur de blocs (Gutenberg)
    add_theme_support('editor-styles');
    add_editor_style('style-editor.css'); // Ajouter un fichier CSS spécifique à l'éditeur si nécessaire
}
add_action('after_setup_theme', 'mytheme_setup');





// Définir automatiquement "Template de Nathalie" comme modèle par défaut pour les types de publication "photo"
function set_default_template_for_photo( $post_id ) {
    // Vérifie le type de publication
    if ( get_post_type( $post_id ) !== 'photo' ) {
        return;
    }
    
    // Vérifie si un modèle a déjà été attribué
    $template = get_post_meta( $post_id, '_wp_page_template', true );
    
    if ( empty( $template ) || $template === 'default' ) {
        // Définit le modèle par défaut sur "Template de Nathalie"
        update_post_meta( $post_id, '_wp_page_template', 'single-custom.php' );
    }
}
add_action( 'save_post', 'set_default_template_for_photo' );

// Restreindre les modèles de page disponibles pour le type de publication "photo"
function restrict_templates_for_photo( $post_templates, $wp_theme, $post ) {
    if ( $post->post_type === 'photo' ) {
        // Garde uniquement "Template de Nathalie"
        $post_templates = [
            'single-custom.php' => 'Template de Nathalie',
        ];
    }
    return $post_templates;
}
add_filter( 'theme_page_templates', 'restrict_templates_for_photo', 10, 3 );

function load_more_images_ajax() {
    if (isset($_POST['currentPage'])) {
        $current_page = intval($_POST['currentPage']);
        $images_per_page = 8; // Nombre d'images à charger par clic

        // Récupérer les IDs des images déjà chargées
        $loaded_images = isset($_POST['loadedImages']) ? array_map('intval', $_POST['loadedImages']) : array();

        $args = array(
            'post_type' => 'photo',
            'posts_per_page' => $images_per_page,
            'paged' => $current_page + 1, // Charger la page suivante
            'post_status' => 'publish',
            'post__not_in' => $loaded_images, // Exclure les images déjà chargées
        );

        $query = new WP_Query($args);

        $images = array();

        if ($query->have_posts()) {
            while ($query->have_posts()) {
                $query->the_post();
                $image_url = get_the_post_thumbnail_url(get_the_ID(), 'full'); // Récupérer l'URL de l'image

                // Récupérer d'autres métadonnées comme la référence et la catégorie
                $reference = get_field('reference'); // ACF
                $categorie = get_the_terms(get_the_ID(), 'categorie');

                $images[] = array(
                    'id' => get_the_ID(), // Ajouter l'ID de l'image
                    'title' => get_the_title(), // Utiliser le titre du post
                    'url' => $image_url,
                    'reference' => $reference,
                    'categorie' => $categorie ? $categorie[0]->name : 'Aucune catégorie', // Récupérer le nom de la première catégorie
                    'pageUrl' => get_permalink(get_the_ID()), // URL de l'article
                );
            }

            wp_send_json_success(array('images' => $images));
        } else {
            wp_send_json_error('Pas d\'images à charger.');
        }

        wp_reset_postdata();
    } else {
        wp_send_json_error('Page actuelle non définie.');
    }

    wp_die(); // Terminer l'exécution de la requête AJAX
}





add_action('wp_ajax_load_more_images', 'load_more_images');
add_action('wp_ajax_nopriv_load_more_images', 'load_more_images');

function load_more_images() {
    if (!session_id()) {
        session_start();
    }

    // Réinitialisation des images chargées si demandé
    if (isset($_POST['reset']) && $_POST['reset'] === 'true') {
        unset($_SESSION['loaded_images']);
        $_SESSION['loaded_images'] = [];
    }

    // Récupérer la page et les images chargées
    $current_page = intval($_POST['currentPage']);
    $loaded_images = isset($_POST['loadedImages']) ? json_decode(stripslashes($_POST['loadedImages']), true) : [];

    // Logique pour récupérer les images
    $args = array(
        'post_type' => 'photo', // Assurez-vous que ce type de publication est correct
        'posts_per_page' => 8,
        'paged' => $current_page,
        'post__not_in' => $loaded_images, // Exclure les images déjà chargées
    );

    $query = new WP_Query($args);

    if ($query->have_posts()) {
        $images = [];
        while ($query->have_posts()) {
            $query->the_post();
            $images[] = array(
                'id' => get_the_ID(),
                'title' => get_the_title(),
                'thumbnail' => get_the_post_thumbnail_url(get_the_ID(), 'medium'),
                // Ajoutez d'autres champs d'image si nécessaire
            );
        }
        wp_reset_postdata();

        // Sauvegarder l'état des images chargées
        $_SESSION['loaded_images'] = array_merge($_SESSION['loaded_images'], array_column($images, 'id'));
        wp_send_json_success(['images' => $images]);
    } else {
        wp_send_json_error('Pas d\'images à charger.'); // Aucune image trouvée
    }
}






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
        ?>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var images = [
                    'nathalie-0.jpeg',
                    'nathalie-1.jpeg',
                    'nathalie-2.jpeg',
                    'nathalie-3.jpeg',
                    'nathalie-4.jpeg',
                    'nathalie-5.jpeg',
                    'nathalie-6.jpeg',
                    'nathalie-7.jpeg',
                    'nathalie-8.jpeg',
                    'nathalie-9.jpeg',
                    'nathalie-10.jpeg',
                    'nathalie-11.jpeg',
                    'nathalie-12.jpeg',
                    'nathalie-13.jpeg',
                    'nathalie-14.jpeg',
                    'nathalie-15.jpeg'
                ];

                var randomImage = images[Math.floor(Math.random() * images.length)];
                var container = document.createElement('div');
                container.className = 'image-random-container';
                
                var img = document.createElement('img');
                img.src = '<?php echo get_stylesheet_directory_uri(); ?>/images/photos/' + randomImage;
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

// Ajoutez cette fonction dans functions.php
function get_featured_images() {
    // Vérifiez le nonce pour la sécurité (ajoutez un nonce côté JS également)
    check_ajax_referer('load_featured_images_nonce', 'nonce');

    // Requête pour récupérer les articles CPT (remplacez 'photo' par le slug de votre CPT)
    $args = [
        'post_type'      => 'photo',  // Nom de votre CPT
        'posts_per_page' => -1        // Nombre d'articles à récupérer
    ];

    $query = new WP_Query($args);
    $images = [];

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            if (has_post_thumbnail()) {
                // Récupérez l'URL de l'image mise en avant
                $images[] = get_the_post_thumbnail_url(get_the_ID(), 'full');
            }
        }
        wp_reset_postdata();
    }

    // Renvoyez la liste des URLs d'images en JSON
    wp_send_json($images);
}
add_action('wp_ajax_get_featured_images', 'get_featured_images');
add_action('wp_ajax_nopriv_get_featured_images', 'get_featured_images');


// Dans ton fichier functions.php
function mon_script_ajax() {
    // Enqueue ton script principal
    wp_enqueue_script('mon_script', get_template_directory_uri() . '/../oceanwp-child/js/mon_script.js', array('jquery'), '1.0', true);

    // Crée le nonce et l'URL AJAX, puis les passe à ton script JavaScript
    wp_localize_script('mon_script', 'ajax_object', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('mon_nonce_action')
    ));
}
add_action('wp_enqueue_scripts', 'mon_script_ajax');


function mon_action_ajax() {
    // Vérifie le nonce pour sécuriser la requête
    check_ajax_referer('mon_nonce_action', 'security');

    // Code à exécuter si le nonce est valide
    $resultat = array('message' => 'Requête sécurisée réussie !');
    wp_send_json_success($resultat);
}
add_action('wp_ajax_mon_action', 'mon_action_ajax');
add_action('wp_ajax_nopriv_mon_action', 'mon_action_ajax');  // Si tu veux que la requête soit accessible aux non-connectés

add_action('wp_ajax_load_more_images', 'load_more_images');
add_action('wp_ajax_nopriv_load_more_images', 'load_more_images');

function load_more_images() {
    check_ajax_referer('YOUR_NONCE_VALUE', 'nonce');

    $offset = isset($_POST['offset']) ? intval($_POST['offset']) : 0;
    $images = [];

    $query_args = [
        'post_type' => 'photo',
        'posts_per_page' => 8,
        'offset' => $offset
    ];
    $query = new WP_Query($query_args);

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            $image_url = get_the_post_thumbnail_url(get_the_ID(), 'medium');
            if ($image_url) {
                $images[] = $image_url;
            }
        }
        wp_reset_postdata();
    }

    if (!empty($images)) {
        wp_send_json_success(['images' => $images]);
    } else {
        wp_send_json_error(['message' => 'Aucune image disponible']);
    }

    wp_die();
}




// Enregistrer et localiser le script JavaScript avec le nonce
function enqueue_custom_ajax_script() {
    wp_enqueue_script('custom-ajax-script', get_template_directory_uri() . '/../oceanwp-child/js/my-ajax-script.js', array('jquery'), null, true);
    
    // Localisation du nonce et de l'URL AJAX
    wp_localize_script('custom-ajax-script', 'ajax_params', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('filter_nonce')  // Créez un nonce
    ));
}
add_action('wp_enqueue_scripts', 'enqueue_custom_ajax_script');


// Action AJAX pour le filtrage des images
function load_filtered_images() {
    if (!isset($_POST['security']) || !wp_verify_nonce($_POST['security'], 'filter_nonce')) {
        wp_send_json_error('Nonce invalid');
        return;
    }
    

    // Récupérer les filtres
    $category = isset($_POST['category']) ? sanitize_text_field($_POST['category']) : 'all';
    $format = isset($_POST['format']) ? sanitize_text_field($_POST['format']) : 'all';
    $date = isset($_POST['date']) ? sanitize_text_field($_POST['date']) : 'newest';
    $page = isset($_POST['page']) ? intval($_POST['page']) : 1;

    // Déboguer et vérifier les paramètres
    error_log('Category: ' . $category);
    error_log('Format: ' . $format);
    error_log('Date: ' . $date);
    error_log('Page: ' . $page);

    // Charger les images selon les filtres
// Charger les images selon les filtres
$args = array(
    'post_type' => 'photo',
    'posts_per_page' => 8,  // Modifier pour un nombre différent d'images par page
    'paged' => $page,
    'no_found_rows' => false // Permet de récupérer le nombre total de pages
);

$query = new WP_Query($args);

if ($query->have_posts()) {
    $images = [];
    while ($query->have_posts()) {
        $query->the_post();
        $images[] = array(
            'id' => get_the_ID(),
            'url' => get_the_post_thumbnail_url(),
            'title' => get_the_title(),
        );
    }

    // Envoi du nombre total de pages pour la pagination
    wp_send_json_success(array(
        'images' => $images,
        'max_pages' => $query->max_num_pages,
        'current_page' => $page
    ));
} else {
    wp_send_json_error('No images found');
}

wp_die();


    // Ajouter des filtres si spécifiés
    if ($category !== 'all') {
        $args['tax_query'][] = array(
            'taxonomy' => 'categorie',
            'field' => 'slug',
            'terms' => $category,
            'operator' => 'IN',
        );
    }

    if ($format !== 'all') {
        $args['tax_query'][] = array(
            'taxonomy' => 'format',
            'field' => 'slug',
            'terms' => $format,
            'operator' => 'IN',
        );
    }

    if ($date === 'newest') {
        $args['orderby'] = 'date';
        $args['order'] = 'DESC';
    } elseif ($date === 'oldest') {
        $args['orderby'] = 'date';
        $args['order'] = 'ASC';
    }

    // Requête pour récupérer les images
    $query = new WP_Query($args);

    if ($query->have_posts()) {
        $images = [];
        while ($query->have_posts()) {
            $query->the_post();
            $images[] = array(
                'id' => get_the_ID(),
                'url' => get_the_post_thumbnail_url(),
                'title' => get_the_title(),
            );
        }
        wp_send_json_success($images);  // Retourner les images sous forme de JSON
    } else {
        wp_send_json_error('No images found');
    }

    wp_die();  // Fin de la requête Ajax
}
add_action('wp_ajax_load_filtered_images', 'load_filtered_images');
add_action('wp_ajax_nopriv_load_filtered_images', 'load_filtered_images');



function enqueue_my_custom_scripts() {
    // Enqueue the script first
    wp_enqueue_script('my-ajax-script', get_stylesheet_directory_uri() . '/js/my-ajax-script.js', array('jquery'), null, true);

    // Then localize the script with AJAX parameters
    wp_localize_script('my-ajax-script', 'gallery_ajax_params', array(
        'ajax_url' => admin_url('admin-ajax.php'), // URL d'Ajax
        'nonce'    => wp_create_nonce('gallery_nonce') // Création du nonce pour la sécurité
    ));
}

add_action('wp_enqueue_scripts', 'enqueue_my_custom_scripts');












function my_enqueue_scripts() {
    wp_enqueue_script('my-scripts', get_stylesheet_directory_uri() . '/js/scripts.js', array('jquery'), null, true);
    
    // Transmet les données AJAX au script JavaScript
    wp_localize_script('my-scripts', 'myAjax', array(
        'url' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('charger_plus_images_nonce')
    ));
}
add_action('wp_enqueue_scripts', 'my_enqueue_scripts');


function charger_plus_images() {
    // Vérifie le nonce pour la sécurité
    check_ajax_referer('charger_plus_images_nonce', 'nonce');

    // Logique pour récupérer les images (exemple)
    $images = array(
        array('url' => 'url_de_image_1.jpg'),
        array('url' => 'url_de_image_2.jpg')
        // Ajoutez d'autres images ici
    );

    // Réponse JSON
    wp_send_json_success(array('images' => $images));
}

add_action('wp_ajax_charger_plus_images', 'charger_plus_images');
add_action('wp_ajax_nopriv_charger_plus_images', 'charger_plus_images');








add_filter('wp_nav_menu_items', function($items, $args) {
    // Vérifiez si c'est le bon emplacement de menu
    if ($args->theme_location === 'primary') { // Remplacez 'primary' par l'emplacement de votre menu
        // Ajoutez le formulaire après les autres éléments du menu
        $items .= '<li class="menu-item menu-item-form">' . do_shortcode('[contact-form-7 id="a724969" title="Formulaire de contact 1_copy"]') . '</li>';
    }
    return $items;
}, 10, 2);
add_action('wp_enqueue_scripts', function() {
    // Charger les scripts de Contact Form 7 si ce n'est pas fait
    if (function_exists('wpcf7_enqueue_scripts')) {
        wpcf7_enqueue_scripts();
    }
    if (function_exists('wpcf7_enqueue_styles')) {
        wpcf7_enqueue_styles();
    }
});


function ajouter_select2_local() {
    // CSS local
    wp_enqueue_style('select2-css', get_template_directory_uri() . '/../oceanwp-child/assets/css/select2.min.css');
    
    // JS local
    wp_enqueue_script('select2-js', get_template_directory_uri() . '/../oceanwp-child//assets/js/select2.min.js', array('jquery'), null, true);
}
add_action('wp_enqueue_scripts', 'ajouter_select2_local');




add_action('wp_ajax_load_more_images', 'load_more_images_callback');
add_action('wp_ajax_nopriv_load_more_images', 'load_more_images_callback');

function load_more_images_callback() {
    $page = isset($_POST['page']) ? (int) $_POST['page'] : 1;
    $category = isset($_POST['category']) ? sanitize_text_field($_POST['category']) : 'all';
    $format = isset($_POST['format']) ? sanitize_text_field($_POST['format']) : 'all';
    $date = isset($_POST['date']) ? sanitize_text_field($_POST['date']) : 'newest';

    $args = array(
        'post_type' => 'photo',
        'posts_per_page' => 10,
        'paged' => $page,
        'orderby' => 'date',
        'order' => $date == 'oldest' ? 'ASC' : 'DESC',
    );

    if ($category && $category != 'all') {
        $args['tax_query'] = array(
            array(
                'taxonomy' => 'categorie',
                'field' => 'slug',
                'terms' => $category,
            ),
        );
    }

    if ($format && $format != 'all') {
        $args['tax_query'][] = array(
            'taxonomy' => 'format',
            'field' => 'slug',
            'terms' => $format,
        );
    }

    $query = new WP_Query($args);
    
    $images = array();
    while ($query->have_posts()) {
        $query->the_post();
        $images[] = array(
            'src' => get_the_post_thumbnail_url(),
            'title' => get_the_title(),
        );
    }
    
    wp_reset_postdata();

    wp_send_json_success(array('images' => $images));
}

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



function custom_image_gallery_shortcode() {
    // Récupérer les termes des taxonomies 'categorie' et 'format'
    $categories = get_terms(array(
        'taxonomy' => 'categorie',
        'hide_empty' => false,
    ));

    $formats = get_terms(array(
        'taxonomy' => 'format',
        'hide_empty' => false,
    ));

    // Obtenir les publications du type 'photo'
    $args = array(
        'post_type' => 'photo',
        'posts_per_page' => -1, // Récupérer toutes les publications
        'orderby' => 'date',
        'order' => 'DESC',
    );
    $query = new WP_Query($args);

    $images = array();
    while ($query->have_posts()) {
        $query->the_post();
        $image_id = get_the_ID();
        $image_src = get_the_post_thumbnail_url($image_id, 'full');
        $title = get_the_title($image_id);
        $categories_list = wp_get_post_terms($image_id, 'categorie', array('fields' => 'slugs'));
        $formats_list = wp_get_post_terms($image_id, 'format', array('fields' => 'slugs'));
        $date = get_the_date('Y-m-d', $image_id);
        $page_url = get_permalink($image_id); // URL de la page du post

        $images[] = array(
            'src' => $image_src,
            'title' => $title,
            'category' => !empty($categories_list) ? $categories_list[0] : 'default-category',
            'format' => !empty($formats_list) ? $formats_list[0] : 'default-format',
            'date' => $date,
            'pageUrl' => $page_url // Ajouter l'URL de la page
        );
    }
    wp_reset_postdata();

    ob_start();
    ?>
<div id="image-gallery-container" class="image-gallery">
    <!-- Champs de tri -->
    <div class="filters">
        <!-- Catégorie -->
        <div class="filter-group-categorie">
            <label for="category-filter">Catégorie:</label>
            <select id="category-filter" onchange="filterImages()">
                <option value="all"></option>
                <?php foreach ($categories as $category) : ?>
                    <option value="<?php echo esc_attr($category->slug); ?>">
                        <?php echo esc_html($category->name); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <!-- Format -->
        <div class="filter-group-format">
            <label for="format-filter">Format:</label>
            <select id="format-filter" onchange="filterImages()">
                <option value="all"></option>
                <?php foreach ($formats as $format) : ?>
                    <option value="<?php echo esc_attr($format->slug); ?>">
                        <?php echo esc_html($format->name); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <!-- Date -->
        <div class="filter-group date-filter">
            <label for="date-filter">Date:</label>
            <select id="date-filter" onchange="filterImages()">
                <option value="all"></option>
                <option value="newest">Les plus récentes</option>
                <option value="oldest">Les plus anciennes</option>
            </select>
        </div>
    </div>

    <!-- Galerie d'images -->
    <div id="image-gallery" class="image-grid">
        <!-- Les images seront chargées ici -->
    </div>
</div>

        
        <!-- Pagination -->
        <div class="pagination">
            <button id="next-button" onclick="nextPage()">Charger plus</button>
        </div>
    </div>

    <script>
        let images = <?php echo json_encode($images); ?>;

        let currentPage = 1;
        const itemsPerPage = 8;

        function loadImages() {
            let gallery = document.getElementById('image-gallery');

            let filteredImages = filterImagesList(images);

            let totalItems = filteredImages.length;
            let totalPages = Math.ceil(totalItems / itemsPerPage);

            let startIndex = (currentPage - 1) * itemsPerPage;
            let endIndex = startIndex + itemsPerPage;
            let imagesToDisplay = filteredImages.slice(startIndex, endIndex);

            imagesToDisplay.forEach(image => {
                let div = document.createElement('div');
                div.className = 'image-item';
                div.style.backgroundImage = 'url("' + image.src + '")';
                div.innerHTML = `
                    <div class="image-title">${image.title}</div>
                    <div class="image-category">${image.category}</div>
                    <div class="fullscreen-icon" onclick="viewFullscreen('${image.src}')">⛶</div>
                    <a href="${image.pageUrl}" class="eye-icon" target="_blank">
                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/Eye.png" alt="Eye Icon" class="eye-image">
                        </a>

                `;
                gallery.appendChild(div);
            });

            document.getElementById('next-button').disabled = currentPage >= totalPages;

            let observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('visible');
                        observer.unobserve(entry.target);
                    }
                });
            }, { threshold: 0.1 });

            document.querySelectorAll('.image-item').forEach(item => {
                observer.observe(item);
            });
        }

        function filterImages() {
            // Réinitialiser la page actuelle à 1 lorsque le filtre est modifié
            currentPage = 1;

            // Réinitialiser la galerie
            document.getElementById('image-gallery').innerHTML = '';

            // Recharger les images
            loadImages();
        }

        function filterImagesList(images) {
            let category = document.getElementById('category-filter').value;
            let format = document.getElementById('format-filter').value;
            let date = document.getElementById('date-filter').value;

            let filteredImages = images.filter(image => {
                return (category === 'all' || image.category === category) &&
                       (format === 'all' || image.format === format);
            });

            if (date === 'newest') {
                filteredImages.sort((a, b) => new Date(b.date) - new Date(a.date));
            } else {
                filteredImages.sort((a, b) => new Date(a.date) - new Date(b.date));
            }

            return filteredImages;
        }

        function viewFullscreen(imageSrc) {
    // Créer l'élément overlay
    let overlay = document.createElement('div');
    overlay.style.position = 'fixed';
    overlay.style.top = '0';
    overlay.style.left = '0';
    overlay.style.width = '100%';
    overlay.style.height = '100%';
    overlay.style.backgroundColor = 'rgba(0, 0, 0, 0.7)'; // Couleur noire avec une opacité de 70%
    overlay.style.zIndex = '999'; // Assurez-vous que l'overlay est derrière l'image
    overlay.onclick = closeFullscreen;

    // Créer l'élément image
    let fullImage = document.createElement('img');
    fullImage.src = imageSrc;
    fullImage.style.position = 'fixed';
    fullImage.style.top = '50%';
    fullImage.style.left = '50%';
    fullImage.style.transform = 'translate(-50%, -50%)';
    fullImage.style.zIndex = '1000'; // Assurez-vous que l'image est devant l'overlay
    fullImage.style.maxWidth = '100%';
    fullImage.style.maxHeight = '100%';
    fullImage.onclick = closeFullscreen;

    // Créer la croix de fermeture
    let closeButton = document.createElement('div');
    closeButton.innerHTML = '&times;'; // Symbole de la croix
    closeButton.style.position = 'fixed';
    closeButton.style.top = '20px';
    closeButton.style.right = '35px';
    closeButton.style.fontSize = '50px';
    closeButton.style.fontWeight = 'bold';
    closeButton.style.transition = '0.3s';
    closeButton.style.color = 'white';
    closeButton.style.cursor = 'pointer';
    closeButton.style.zIndex = '1001'; // Assurez-vous que la croix est devant tout le reste
    closeButton.onclick = closeFullscreen;

    // Fonction pour fermer le plein écran
    function closeFullscreen() {
        document.body.removeChild(overlay);
        document.body.removeChild(fullImage);
        document.body.removeChild(closeButton);
    }

    // Ajouter l'overlay, l'image, et la croix au document
    document.body.appendChild(overlay);
    document.body.appendChild(fullImage);
    document.body.appendChild(closeButton);
}


        function nextPage() {
            currentPage++;
            loadImages();
        }

        document.addEventListener('DOMContentLoaded', function() {
            loadImages();
        });
    </script>
    <?php
    return ob_get_clean();
}
add_shortcode('custom_image_gallery', 'custom_image_gallery_shortcode');



function custom_lightbox_script() {
    ?>
    <script>
// Fonction pour afficher l'image en plein écran dans la lightbox
function viewFullscreenCarousel(index) {
    // Les images du carrousel
    const images = [
        "<?php echo get_stylesheet_directory_uri(); ?>/images/photos/nathalie-0.jpeg",
        "<?php echo get_stylesheet_directory_uri(); ?>/images/photos/nathalie-1.jpeg",
        "<?php echo get_stylesheet_directory_uri(); ?>/images/photos/nathalie-2.jpeg",
        "<?php echo get_stylesheet_directory_uri(); ?>/images/photos/nathalie-3.jpeg",
        "<?php echo get_stylesheet_directory_uri(); ?>/images/photos/nathalie-4.jpeg",
        "<?php echo get_stylesheet_directory_uri(); ?>/images/photos/nathalie-5.jpeg",
        "<?php echo get_stylesheet_directory_uri(); ?>/images/photos/nathalie-6.jpeg",
        "<?php echo get_stylesheet_directory_uri(); ?>/images/photos/nathalie-7.jpeg",
        "<?php echo get_stylesheet_directory_uri(); ?>/images/photos/nathalie-8.jpeg",
        "<?php echo get_stylesheet_directory_uri(); ?>/images/photos/nathalie-9.jpeg",
        "<?php echo get_stylesheet_directory_uri(); ?>/images/photos/nathalie-10.jpeg",
        "<?php echo get_stylesheet_directory_uri(); ?>/images/photos/nathalie-11.jpeg",
        "<?php echo get_stylesheet_directory_uri(); ?>/images/photos/nathalie-12.jpeg",
        "<?php echo get_stylesheet_directory_uri(); ?>/images/photos/nathalie-13.jpeg",
        "<?php echo get_stylesheet_directory_uri(); ?>/images/photos/nathalie-14.jpeg",
        "<?php echo get_stylesheet_directory_uri(); ?>/images/photos/nathalie-15.jpeg",
    ];

    let currentIndex = index;

    // Créer la lightbox
    let lightbox = document.createElement('div');
    lightbox.className = 'lightbox';
    lightbox.style.position = 'fixed';
    lightbox.style.top = '0';
    lightbox.style.left = '0';
    lightbox.style.width = '100%';
    lightbox.style.height = '100%';
    lightbox.style.backgroundColor = 'rgba(0, 0, 0, 0.8)';
    lightbox.style.display = 'flex';
    lightbox.style.alignItems = 'center';
    lightbox.style.justifyContent = 'center';
    lightbox.style.zIndex = '1000';

    // Créer l'image dans la lightbox
    let fullImage = document.createElement('img');
    fullImage.src = images[currentIndex];
    fullImage.style.maxWidth = '90%';
    fullImage.style.maxHeight = '90%';
    lightbox.appendChild(fullImage);

    // Créer le bouton de fermeture
    let closeButton = document.createElement('div');
    closeButton.className = 'close';
    closeButton.innerHTML = '&times;'; // Symbole de fermeture
    closeButton.style.position = 'absolute';
    closeButton.style.top = '10px';
    closeButton.style.right = '20px';
    closeButton.style.color = 'white';
    closeButton.style.fontSize = '30px';
    closeButton.style.cursor = 'pointer';
    closeButton.onclick = () => document.body.removeChild(lightbox);
    lightbox.appendChild(closeButton);

    // Créer le bouton "Précédente"
    let prevButton = document.createElement('div');
    prevButton.innerHTML = '&#9664; Précédente'; // Flèche gauche avec texte
    prevButton.style.position = 'absolute';
    prevButton.style.left = '20px';
    prevButton.style.top = '50%';
    prevButton.style.transform = 'translateY(-50%)';
    prevButton.style.color = 'white';
    prevButton.style.fontSize = '30px';
    prevButton.style.cursor = 'pointer';
    prevButton.onclick = function () {
        currentIndex = (currentIndex > 0) ? currentIndex - 1 : images.length - 1;
        fullImage.src = images[currentIndex];
    };
    lightbox.appendChild(prevButton);

    // Créer le bouton "Suivante"
    let nextButton = document.createElement('div');
    nextButton.innerHTML = 'Suivante &#9654;'; // Flèche droite avec texte
    nextButton.style.position = 'absolute';
    nextButton.style.right = '20px';
    nextButton.style.top = '50%';
    nextButton.style.transform = 'translateY(-50%)';
    nextButton.style.color = 'white';
    nextButton.style.fontSize = '30px';
    nextButton.style.cursor = 'pointer';
    nextButton.onclick = function () {
        currentIndex = (currentIndex < images.length - 1) ? currentIndex + 1 : 0;
        fullImage.src = images[currentIndex];
    };
    lightbox.appendChild(nextButton);

    // Ajouter la lightbox au body
    document.body.appendChild(lightbox);
}

// Attacher l'événement de clic sur chaque image du carrousel
document.querySelectorAll('#carousel-example .carousel-item img').forEach((img, index) => {
    img.addEventListener('click', () => {
        viewFullscreenCarousel(index);
    });
});

    </script>
    <?php
}
add_action('wp_footer', 'custom_lightbox_script');













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



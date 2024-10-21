<?php
/* 
 Template Name: Template de Nathalie
 Template Post Type: photo
*/

get_header(); // Inclut l'en-tête du site
?>
<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/style.css" type="text/css" media="all" />


<div class="container-centered">
    <!-- wp:columns -->
    <div class="wp-block-columns">
        <!-- wp:column {"width":"1440px"} -->
        <div class="wp-block-column" style="flex-basis:1140px">
            <!-- wp:spacer {"height":"30px"} -->
            <div style="height:30px" aria-hidden="true" class="wp-block-spacer"></div>
            <!-- /wp:spacer -->
        </div>
        <!-- /wp:column -->
    </div>
    <!-- /wp:columns -->

    <!-- wp:columns -->
<div class="wp-block-columns custom-mobile-reverse">
    <!-- wp:column {"verticalAlignment":"bottom","width":"483px","className":"bloc_venant_de_gauche"} -->
    <div class="wp-block-column is-vertically-aligned-bottom bloc_venant_de_gauche" style="flex-basis:483px">
        <div class="info-column">
            <!-- wp:shortcode -->
            <div class="titre_photos">
                <?php echo do_shortcode('[titre]'); ?>
            </div>
            <!-- /wp:shortcode -->

            <!-- wp:shortcode -->
            <div class="categorie">
                CATÉGORIE: <?php echo do_shortcode('[categories]'); ?>
            </div>
            <!-- /wp:shortcode -->

            <!-- wp:shortcode -->
            <div class="type">
                TYPE: <?php echo do_shortcode('[type]'); ?>
            </div>
            <!-- /wp:shortcode -->

            <!-- wp:shortcode -->
            <div class="format">
                FORMAT: <?php echo do_shortcode('[formats]'); ?>
            </div>
            <!-- /wp:shortcode -->

            <!-- wp:shortcode -->
            <div class="reference">
                RÉFÉRENCE: <?php echo do_shortcode('[reference]'); ?>
            </div>
            <!-- /wp:shortcode -->

            <!-- wp:shortcode -->
            <div class="annee">
                ANNÉE: <?php echo do_shortcode('[annee]'); ?>
            </div>
            <!-- /wp:shortcode -->
        </div>

        <!-- wp:separator {"align":"center","className":"is-style-default ligne_longueur"} -->
        <hr class="wp-block-separator aligncenter has-alpha-channel-opacity is-style-default ligne_longueur"/>
        <!-- /wp:separator -->
    </div>
    <!-- /wp:column -->

    <!-- wp:column {"width":"574px"} -->
    <div class="wp-block-column" style="flex-basis:574px">
        <!-- wp:image {"id":457,"width":"680px","sizeSlug":"large","linkDestination":"none","className":"image_principale"} -->
        <figure class="wp-block-image size-large is-resized image_principale"><?php the_post_thumbnail('large'); ?></figure>
        <!-- /wp:image -->
    </div>
    <!-- /wp:column -->
</div>
<!-- /wp:columns -->


    <!-- wp:columns -->
    <div class="wp-block-columns">
        <!-- wp:column -->
        <div class="wp-block-column"></div>
        <!-- /wp:column -->
    </div>
    <!-- /wp:columns -->

    <!-- wp:columns -->
    <div class="wp-block-columns">
        <!-- wp:column {"verticalAlignment":"center"} -->
        <div class="wp-block-column is-vertically-aligned-center">
            <!-- wp:paragraph {"className":"interet"} -->
            <p class="interet">Cette photo vous intéresse ?</p>
            <!-- /wp:paragraph -->
        </div>
        <!-- /wp:column -->

        <!-- wp:column {"className":"bouton_contact"} -->
        <div class="wp-block-column bouton_contact">
            <!-- wp:html -->
            <button id="open-modal-5" class="open-modal">Contact</button>
            <!-- /wp:html -->
        </div>
        <!-- /wp:column -->

        <!-- wp:column {"verticalAlignment":"bottom","width":""} -->
        <div class="wp-block-column is-vertically-aligned-bottom">
    <!-- wp:html -->
    <div class="slider-container" style="width: 81px; height: 71px; float: right;">
    <?php
// Récupérer les images triées par date
$args = array(
    'post_type' => 'photo',
    'posts_per_page' => -1,
    'orderby' => 'date',
    'order' => 'ASC',
);

$photos = new WP_Query($args);

$image_urls = array();
foreach ($photos->posts as $photo) {
    $image_urls[] = wp_get_attachment_url(get_post_thumbnail_id($photo->ID)); // URL de l'image mise en avant
}

// Récupérer l'index de la photo actuelle
$current_photo_id = get_the_ID(); // ID de la photo actuelle
$current_index = array_search(wp_get_attachment_url(get_post_thumbnail_id($current_photo_id)), $image_urls);

// Obtenir les indices des photos précédente et suivante
$previous_index = $current_index > 0 ? $current_index - 1 : count($image_urls) - 1;
$next_index = $current_index < count($image_urls) - 1 ? $current_index + 1 : 0;

$previous_photo_url = $image_urls[$previous_index];
$next_photo_url = $image_urls[$next_index];

$previous_photo_permalink = get_permalink($photos->posts[$previous_index]->ID);
$next_photo_permalink = get_permalink($photos->posts[$next_index]->ID);
?>

<!-- Box pour la miniature -->
<div class="thumbnail-box">
    <img id="thumbnail" src="" alt="Miniature" style="width: 81px; height: 71px; display: none;" />
</div>

<!-- Navigation avec liens -->
<div class="navigation">
    <a href="<?php echo $previous_photo_permalink; ?>" class="nav-link" data-id="<?php echo $previous_index; ?>" data-img="<?php echo $previous_photo_url; ?>">←</a>
    <a href="<?php echo $next_photo_permalink; ?>" class="nav-link" data-id="<?php echo $next_index; ?>" data-img="<?php echo $next_photo_url; ?>">→</a>
</div>




<script>
    const imageUrls = <?php echo json_encode($image_urls); ?>; // Encodage JSON
</script>




    </div>
    <!-- /wp:html -->
</div>
        <!-- /wp:column -->
    </div>
    <!-- /wp:columns -->

    
        <!-- wp:column {"width":"100%"} -->

            <hr class="wp-block-separator has-alpha-channel-opacity"/>


    <!-- /wp:columns -->

    <!-- wp:columns -->
    <div class="wp-block-columns">
        <!-- wp:column {"width":"564px","className":"image_vous_aimerez"} -->
        <div class="wp-block-column image_vous_aimerez" style="flex-basis:564px">
            <!-- wp:paragraph {"className":"vous_aimerez"} -->
            <p class="vous_aimerez">Vous aimerez aussi</p>
            <!-- /wp:paragraph -->

            <!-- wp:shortcode -->
            <?php echo do_shortcode('[images_by_custom_category count="1"]'); ?>
            <!-- /wp:shortcode -->
        </div>
        <!-- /wp:column -->

        <!-- wp:column {"width":"564px","className":"image_vous_aimerez"} -->
        <div class="wp-block-column image_vous_aimerez2" style="flex-basis:564px">
            <!-- wp:spacer {"height":"43px"} -->
            <div style="height:43px" aria-hidden="true" class="wp-block-spacer"></div>
            <!-- /wp:spacer -->
            <!-- wp:shortcode -->
            <?php echo do_shortcode('[images_by_custom_category count="1"]'); ?>
            <!-- /wp:shortcode -->
        </div>
        <!-- /wp:column -->
    </div>
    <!-- /wp:columns -->
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const menuToggle = document.querySelector('.oceanwp-mobile-menu-icon.clr.mobile-right');

    menuToggle.addEventListener('click', function() {
        menuToggle.classList.toggle('is-active'); // Alterne la classe is-active
    });
});
</script>

<?php
get_footer(); // Inclut le pied de page du site
?>

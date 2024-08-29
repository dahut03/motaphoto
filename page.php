<?php
// page.php
get_header(); // Inclure le header

if ( have_posts() ) :
    while ( have_posts() ) : the_post(); ?>
        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
            <div class="content">
                <?php the_content(); ?>
            </div>
        </article>
    <?php endwhile;
else :
    echo '<p>Aucune page trouvée.</p>';
endif;

get_footer(); // Inclure le footer
?>


<?php
/**
 * The Header for our theme.
 *
 * @package OceanWP WordPress theme
 */

?>
<!DOCTYPE html>
<html class="<?php echo esc_attr( oceanwp_html_classes() ); ?>" <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?> <?php oceanwp_schema_markup( 'html' ); ?>>

	<?php wp_body_open(); ?>

	<?php do_action( 'ocean_before_outer_wrap' ); ?>

	<div id="outer-wrap" class="site clr">

		<a class="skip-link screen-reader-text" href="#main"><?php echo esc_html( oceanwp_theme_strings( 'owp-string-header-skip-link', false ) ); ?></a>

		<?php do_action( 'ocean_before_wrap' ); ?>

		<div id="wrap" class="clr">

			<?php do_action( 'ocean_top_bar' ); ?>

			<?php do_action( 'ocean_header' ); ?>
			<?php include('templates_part/contact_modal.php'); ?>
			<div id="contact-popup-overlay" style="display: none;">
    <button id="close-popup-overlay" aria-label="Fermer la modale">&times;</button>
    <div id="contact-popup">
        <div class="contact-header-image-container">
            <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/Contact_header.png" alt="Image en-tête du formulaire de contact">
        </div>
        <?php echo do_shortcode('[contact-form-7 id="a724969" title="Formulaire de contact 1_copy"]'); ?>
    </div>
</div>



			<?php do_action( 'ocean_before_main' ); ?>

			<main id="main" class="site-main clr"<?php oceanwp_schema_markup( 'main' ); ?> role="main">

				<?php do_action( 'ocean_page_header' ); ?>


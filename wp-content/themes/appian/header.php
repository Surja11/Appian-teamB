<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Outside_Traineeship_Biolerplate
 */

?>
<!doctype html$color-primary-red>
<html <?php language_attributes(); ?>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<style>
		main {
			padding-top: 72px !important;
		}
		@media (min-width: 1291px) {
			main {
				padding-top: 74px !important;
			}
		}
	</style>
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Skip to content', 'outside-traineeship-biolerplate' ); ?></a>

	<!-- Bootstrap CSS — your friend will enqueue this via functions.php -->

<header>
	<?php get_template_part('template-parts/header/header'); ?>
	</header>
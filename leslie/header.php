<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="//gmpg.org/xfn/11">
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php //wp_body_open hook if WordPress 5.2
    if ( function_exists( 'wp_body_open' ) ) {
        wp_body_open();
    } ?>
<a class="skip-link screen-reader-text" href="#content">
<?php esc_attr_e( 'Skip to content', 'leslie' ); ?></a>
    <header class="row" id="masthead">

        <figure class="c4" id="logo" role="banner">
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'title' ) ); ?>  &mdash; <?php echo esc_attr( get_bloginfo( 'description' ) ); ?>" rel="home"><img src="<?php header_image(); ?>" height="<?php echo get_custom_header()->height; ?>" width="<?php echo esc_attr( get_custom_header()->width ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'title' ) ); ?>" /></a>
        </figure> 

            <div class="c8" id="hgroup">
                <h1 class="site-title"><a href="<?php echo esc_url( home_url() ); ?>/"><?php bloginfo('name'); ?></a></h1> 
                <h2 class="site-description"><?php bloginfo('description'); ?></h2>
            </div>

    </header><!-- ends header -->

        <div id="main">

            <div class="row" id="full-page">
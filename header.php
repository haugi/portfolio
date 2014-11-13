<?php
/*
Template: Portfolio
Author: Markus Haug

Version: 1.0

*/
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
	<head>
		<meta charset="<?php bloginfo( 'charset' ); ?>" />
		<title><?php wp_title(); ?></title>
		<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/style.css" type="text/css" media="screen" />
		<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/lightbox.css" type="text/css" media="screen" />
		<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
		<link href='http://fonts.googleapis.com/css?family=Open+Sans+Condensed:300,700,300italic' rel='stylesheet' type='text/css'>
		<script src="<?php echo get_template_directory_uri(); ?>/js/jquery-1.11.1.min.js" type="text/javascript"></script>
		<script src="<?php echo get_template_directory_uri(); ?>/js/lightbox.min.js" type="text/javascript"></script>
		<script src="<?php echo get_template_directory_uri(); ?>/js/main.js" type="text/javascript"></script>
		<?php wp_head(); ?>
	</head>

	<body>
		<div id="board">
			<div id="header">
				<div class="headerTitle">
					<h1><a href="<?php echo get_option('home'); ?>"><?php bloginfo('name'); ?></a></h1>
					<h2><?php bloginfo('description'); ?></h2>
				</div>
				<div id="navigation">
					<?php get_Menu('header-menu', 'Header Menu'); ?>
				</div>
				<div class="seperator"></div>
			</div>
<!DOCTYPE html>
<html>
	<head>
		<title><?php echo is_front_page() ? bloginfo('name') : wp_title() ?></title>
		<meta charset="utf-8" />
		<meta name="viewport" content="initial-scale=1, maximum-scale=1, user-scalable=no" />
		<?php wp_head(); ?>
	</head>
<body <?php body_class(); ?>>
	<div id="container">
		<header>
			<div id="logo"><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><img src="<?php header_image(); ?>" alt="Fatharp.com"></a></div>
			<nav id="base-nav">
				<div id="menu-label"><img src="<? echo get_template_directory_uri();?>/img/menu-label.png">Menu</div>
					<?php wp_nav_menu ( array(
						'theme_location' => 'main_menu',
						'container'		=>	false
						));
					?>			
			<?php get_search_form(); ?>	
			</nav>
		</header>

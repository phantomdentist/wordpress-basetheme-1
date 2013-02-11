<!DOCTYPE html>
<!-- Add browser classes to html tag --> 
<!--[if lt IE 7]>  <html <?php language_attributes(); ?> class="ie ie6 lte9 lte8 lte7"> <![endif]-->
<!--[if IE 7]>     <html <?php language_attributes(); ?> class="ie ie7 lte9 lte8 lte7"> <![endif]-->
<!--[if IE 8]>     <html <?php language_attributes(); ?> class="ie ie8 lte9 lte8"> <![endif]-->
<!--[if IE 9]>     <html <?php language_attributes(); ?> class="ie ie9 lte9"> <![endif]-->
<!--[if gt IE 9]>  <html <?php language_attributes(); ?>> <![endif]-->
<!--[if !IE]> <html <?php language_attributes(); ?>> <![endif]-->

<!--[if lt IE 9]>
   <script>
      document.createElement('header');
      document.createElement('nav');
      document.createElement('section');
      document.createElement('article');
      document.createElement('aside');
      document.createElement('footer');
   </script>
<![endif]-->

<head>
<!--
******************************************
Meta stuff
******************************************
-->
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="SKYPE_TOOLBAR" content ="SKYPE_TOOLBAR_PARSER_COMPATIBLE"/>
<title><?php wp_title('');?></title>

<!--
******************************************
Link stuff
******************************************
-->
<link rel="icon" type="image/png" href="<?php echo get_template_directory_uri(); ?>/images/favicon.png"/>
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'stylesheet_url' ); ?>"/>
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />

<!-- Add Wordpress head hook stuff --> 
<?php wp_head();?>

</head>

<!--
******************************************
Start of body
******************************************
-->
<body <?php body_class(); ?>>

	<div class="wrapper-main">
    
    	<header class="header">
			<a class="logo" href="<?php echo home_url(); ?>"><?php bloginfo('name'); ?></a>
			<nav class="nav-main"><?php wp_nav_menu( array( 'theme_location' => 'menu-main', 'container' => '') ); ?></nav>
        </header><!-- end header -->
    
    	<?php get_search_form(); ?>

		

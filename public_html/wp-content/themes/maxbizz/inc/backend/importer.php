<?php
/**
 * Hooks for importer
 *
 * @package Maxbizz
 */


/**
 * Importer the demo content
 *
 * @since  1.0
 *
 */
function maxbizz_importer() {
	return array(
		array(
			'name'       => 'Home Main',
			'preview'    => get_template_directory_uri().'/inc/backend/data/main/home1.jpg',
			'content'    => get_template_directory_uri().'/inc/backend/data/main/demo-content.xml',
			'customizer' => get_template_directory_uri().'/inc/backend/data/main/customizer.dat',
			'widgets'    => get_template_directory_uri().'/inc/backend/data/main/widgets.wie',
			'sliders'    => get_template_directory_uri().'/inc/backend/data/main/sliders.zip',
			'pages'      => array(
				'front_page' => 'Home',
				'blog'       => 'Blog',
				'shop'       => 'Shop',
				'cart'       => 'Cart',
				'checkout'   => 'Checkout',
				'my_account' => 'My Account',
			),
			'menus'      => array(
				'primary'   => 'main-menu',
			)
		),
		array(
			'name'       => 'Home Consulting',
			'preview'    => get_template_directory_uri().'/inc/backend/data/consulting/home2.jpg',
			'content'    => get_template_directory_uri().'/inc/backend/data/consulting/demo-content.xml',
			'customizer' => get_template_directory_uri().'/inc/backend/data/consulting/customizer.dat',
			'widgets'    => get_template_directory_uri().'/inc/backend/data/consulting/widgets.wie',
			'sliders'    => get_template_directory_uri().'/inc/backend/data/consulting/sliders.zip',
			'pages'      => array(
				'front_page' => 'Home',
				'blog'       => 'Blog',
				'shop'       => 'Shop',
				'cart'       => 'Cart',
				'checkout'   => 'Checkout',
				'my_account' => 'My Account',
			),
			'menus'      => array(
				'primary'   => 'main-menu',
			)
		),
		array(
			'name'       => 'Home Business',
			'preview'    => get_template_directory_uri().'/inc/backend/data/business/home3.jpg',
			'content'    => get_template_directory_uri().'/inc/backend/data/business/demo-content.xml',
			'customizer' => get_template_directory_uri().'/inc/backend/data/business/customizer.dat',
			'widgets'    => get_template_directory_uri().'/inc/backend/data/business/widgets.wie',
			'sliders'    => get_template_directory_uri().'/inc/backend/data/business/sliders.zip',
			'pages'      => array(
				'front_page' => 'Home',
				'blog'       => 'Blog',
				'shop'       => 'Shop',
				'cart'       => 'Cart',
				'checkout'   => 'Checkout',
				'my_account' => 'My Account',
			),
			'menus'      => array(
				'primary'   => 'main-menu',
			)
		),
		array(
			'name'       => 'Home Corporate',
			'preview'    => get_template_directory_uri().'/inc/backend/data/corporate/home4.jpg',
			'content'    => get_template_directory_uri().'/inc/backend/data/corporate/demo-content.xml',
			'customizer' => get_template_directory_uri().'/inc/backend/data/corporate/customizer.dat',
			'widgets'    => get_template_directory_uri().'/inc/backend/data/corporate/widgets.wie',
			'pages'      => array(
				'front_page' => 'Home',
				'blog'       => 'Blog',
				'shop'       => 'Shop',
				'cart'       => 'Cart',
				'checkout'   => 'Checkout',
				'my_account' => 'My Account',
			),
			'menus'      => array(
				'primary'   => 'main-menu',
			)
		),
		array(
			'name'       => 'Home Finance',
			'preview'    => get_template_directory_uri().'/inc/backend/data/finance/home5.jpg',
			'content'    => get_template_directory_uri().'/inc/backend/data/finance/demo-content.xml',
			'customizer' => get_template_directory_uri().'/inc/backend/data/finance/customizer.dat',
			'widgets'    => get_template_directory_uri().'/inc/backend/data/finance/widgets.wie',
			'pages'      => array(
				'front_page' => 'Home',
				'blog'       => 'Blog',
				'shop'       => 'Shop',
				'cart'       => 'Cart',
				'checkout'   => 'Checkout',
				'my_account' => 'My Account',
			),
			'menus'      => array(
				'primary'   => 'main-menu',
			)
		),
	);
}

add_filter( 'soo_demo_packages', 'maxbizz_importer', 30 );
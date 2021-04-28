<?php


namespace TFR\PostTypes;


use TFR\Plugin;

class LandingPageTemplate {
	const SLUG = 'landing-page-temp'; // Had to shorten slug due to 20 character max set by WordPress
	const SINGULAR = 'Landing Page Template';
	const PLURAL = 'Landing Page Templates';

	//https://developer.wordpress.org/resource/dashicons/#admin-appearance
	const ICON = 'dashicons-welcome-widgets-menus';

	public static function init() {
		add_action('init', [self::class, 'register_post_type'], 2);
	}

	public static function register_post_type() {
		$labels = [
			'name'               => self::PLURAL,
			'singular_name'      => self::SINGULAR,
			'add_new_item'       => 'Add New ' . self::SINGULAR,
			'edit_item'          => 'Edit ' . self::SINGULAR,
			'new_item'           => 'New ' . self::SINGULAR,
			'all_items'          => self::PLURAL,
			'view_item'          => 'View ' . self::SINGULAR,
			'search_items'       => 'Search ' . self::PLURAL,
			'not_found'          => 'No ' . strtolower(self::PLURAL) . ' found',
			'not_found_in_trash' => 'No ' . strtolower(self::PLURAL) . ' found in the Trash',
			'parent_item_colon'  => '',
			'menu_name'          => __(self::PLURAL, Plugin::TEXT_DOMAIN),
			'name_admin_bar'     => __(self::PLURAL, Plugin::TEXT_DOMAIN),
		];
		$args   = [
			'menu_icon'          => self::ICON,
			'labels'             => $labels,
			'public'             => false,
			'publicly_queryable' => false,
			'has_archive'        => false,
			'show_ui'            => true,
			'show_in_nav_menus'  => false,
			'show_in_menu'       => 'site_settings',
			'hierarchical'       => false,
			'menu_position'      => 15,
			'rewrite'            => false,
			'map_meta_cap'       => true,
			'supports'           => [
				'title',
			],
			'show_in_rest'       => false,
			'capability_type'    => 'page',
		];

		register_post_type(self::SLUG, $args);
	}
}

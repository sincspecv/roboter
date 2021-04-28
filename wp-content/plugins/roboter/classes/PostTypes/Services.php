<?php

namespace TFR\PostTypes;

class Services {
	const SLUG = 'service';
	const SINGULAR = 'Service';
	const PLURAL = 'Services';

	//https://developer.wordpress.org/resource/dashicons/#admin-appearance
	const ICON = 'dashicons-screenoptions';

	public static function init() {
		add_action('init', [self::class, 'register_post_type'], 10);
	}

	public static function register_post_type() {
		$labels = [
			'name'               => self::PLURAL,
			'single_name'        => self::SINGULAR,
			'add_new_item'       => 'Add New ' . self::SINGULAR,
			'edit_item'          => 'Edit ' . self::SINGULAR,
			'new_item'           => 'New ' . self::SINGULAR,
			'all_items'          => 'All ' . self::PLURAL,
			'view_item'          => 'View ' . self::SINGULAR,
			'search_items'       => 'Search ' . self::PLURAL,
			'not_found'          => 'No ' . strtolower(self::PLURAL) . ' found',
			'not_found_in_trash' => 'No ' . strtolower(self::PLURAL) . ' found in the Trash',
			'parent_item_colon'  => '',
			'menu_name'          => self::PLURAL,
		];
		$args   = [
			'menu_icon'          => self::ICON,
			'labels'             => $labels,
			'public'             => true,
			'publicly_queryable' => true,
			'has_archive'        => false,
			'show_ui'            => true,
			'show_in_nav_menus'  => true,
			'hierarchical'       => true,
			'menu_position'      => 15,
			'rewrite'            => [
				'slug'       => sanitize_title(self::PLURAL),
				'with_front' => false,
			],
			'map_meta_cap'       => true,
			'supports'           => [
				'title',
				'revisions',
				'thumbnail',
			],
			'show_in_rest'       => true,
		];

		register_post_type(self::SLUG, $args);
	}
}

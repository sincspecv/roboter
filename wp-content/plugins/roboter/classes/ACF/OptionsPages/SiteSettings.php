<?php

namespace TFR\ACF\OptionsPages;

use TFR\Plugin;

class SiteSettings {
	const SLUG = 'site_settings';
	const SITE_IDENTITY_GROUP = 'site_identity';
	const SOCIAL_GROUP = 'social_media';

	public static function init() 	{
		add_action('acf/init', [self::class, 'additions']);
	}

	public static function additions() 	{
		if (!function_exists('acf_add_options_page')) {
			return;
		}

		acf_add_options_page([
			'page_title' => __('Site Settings', Plugin::TEXT_DOMAIN),
			'menu_title' => __('Site Settings', Plugin::TEXT_DOMAIN),
			'menu_slug'  => 'settings_menu',
			'post_id'    => 'settings_menu',
			'capability' => 'manage_options',
			'icon_url'   => Plugin::$url . '/assets/tfr_logo.svg'
		]);

		acf_add_options_sub_page([
			'page_title'   => __('Global Settings', Plugin::TEXT_DOMAIN),
			'menu_title'  => __('Global Settings', Plugin::TEXT_DOMAIN),
			'menu_slug'   => self::SLUG,
			'post_id'     => self::SLUG,
			'capability'  => 'manage_options',
			'parent_slug' => 'settings_menu',
		]);

		acf_add_local_field_group([
			'key'        => self::SITE_IDENTITY_GROUP,
			'title'      => __('Site Logo', Plugin::TEXT_DOMAIN),
			'menu_order' => 1,
			'fields'     => [
			    [
			        'key'   => self::SITE_IDENTITY_GROUP . '_logo_type',
                    'label' => __('Type of logo image', Plugin::TEXT_DOMAIN),
                    'name'  => 'logo_type',
                    'type'  => 'select',
                    'choices' => [
                        'file' => __('png/jpeg', Plugin::TEXT_DOMAIN),
                        'svg'  => __('svg', Plugin::TEXT_DOMAIN),
                    ]
                ],
				[
					'key'          => self::SITE_IDENTITY_GROUP . '_logo_file',
					'label'        => __('Logo', Plugin::TEXT_DOMAIN),
					'type'         => 'image',
					'name'         => 'site_logo_file',
                    'conditional_logic' => [
                        [
                            [
                                'field'    => self::SITE_IDENTITY_GROUP . '_logo_type',
                                'operator' => '==',
                                'value'    => 'file'
                            ]
                        ]
                    ],
				],
				[
					'key'          => self::SITE_IDENTITY_GROUP . '_logo_svg',
					'label'        => __('Logo', Plugin::TEXT_DOMAIN),
					'type'         => 'textarea',
					'name'         => 'site_logo_svg',
                    'conditional_logic' => [
                        [
                            [
                                'field'    => self::SITE_IDENTITY_GROUP . '_logo_type',
                                'operator' => '==',
                                'value'    => 'svg'
                            ]
                        ]
                    ],
				],
			],
			'location' => [
				[
					[
						'param'    => 'options_page',
						'operator' => '==',
						'value'    => self::SLUG,
					],
				],
			],
		]);

		acf_add_local_field_group([
			'key'        => 'social_media',
			'title'      => __('Social Media', Plugin::TEXT_DOMAIN),
			'menu_order' => 2,
			'fields'     => [
				[
					'key'          => self::SOCIAL_GROUP . '_accounts',
					'label'        => __('Accounts', Plugin::TEXT_DOMAIN),
					'type'         => 'repeater',
					'name'         => 'social_accounts',
					'button_label' => __('Add Account', Plugin::TEXT_DOMAIN),
					'layout'       => 'block',
					'sub_fields'   => [

						[
							'key'     => self::SOCIAL_GROUP . '_link',
							'label'   => __('Link', Plugin::TEXT_DOMAIN),
							'type'    => 'url',
							'name'    => 'link',
							'wrapper' => [
								'width' => 50,
							],
						],
						[
							'key'     => self::SOCIAL_GROUP . '_network',
							'label'   => __('Network', Plugin::TEXT_DOMAIN),
							'type'    => 'select',
							'name'    => 'network',
							'choices' => [
								'facebook'  => 'Facebook',
								'twitter'   => 'Twitter',
								'youtube'   => 'YouTube',
								'instagram' => 'Instagram',
								'linkedin'  => 'LinkedIn',
								'flickr'    => 'Flickr',
								'github'    => 'GitHub',
							],
							'wrapper' => [
								'width' => 50,
							],
						],
					],
				],
			],
			'location' => [
				[
					[
						'param'    => 'options_page',
						'operator' => '==',
						'value'    => self::SLUG,
					],
				],
			],
		]);

        acf_add_local_field_group([
            'key'        => 'scripts',
            'title'      => __('Scripts to inject in head, body, and footer', Plugin::TEXT_DOMAIN),
            'menu_order' => 3,
            'fields'     => [
                [
                    'key'          => 'scripts_head',
                    'label'        => __('Head Scripts', Plugin::TEXT_DOMAIN),
                    'instructions' => __('This will be injected into the head of the website on all pages', Plugin::TEXT_DOMAIN),
                    'type'         => 'textarea',
                    'name'         => 'head_scripts',
                ],
                [
                    'key'          => 'scripts_body',
                    'label'        => __('Body Scripts', Plugin::TEXT_DOMAIN),
                    'instructions' => __('This will be injected into the body of the website on all pages', Plugin::TEXT_DOMAIN),
                    'type'         => 'textarea',
                    'name'         => 'body_scripts',
                ],
                [
                    'key'          => 'scripts_footer',
                    'label'        => __('Footer Scripts', Plugin::TEXT_DOMAIN),
                    'instructions' => __('This will be injected into the footer of the website on all pages', Plugin::TEXT_DOMAIN),
                    'type'         => 'textarea',
                    'name'         => 'footer_scripts',
                ],
            ],
            'location' => [
                [
                    [
                        'param'    => 'options_page',
                        'operator' => '==',
                        'value'    => self::SLUG,
                    ],
                ],
            ],
        ]);
	}
}

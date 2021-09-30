<?php

namespace TFR\ACF\OptionsPages;

use TFR\Plugin;
use TFR\Util;

class SiteSettings {
	const SLUG = 'site_settings';
	const SITE_IDENTITY_GROUP = 'site_identity';
	const SOCIAL_GROUP = 'social_media';
	const BANNER_GROUP = 'banner_settings';
	const CTA_GROUP = 'global_cta_settings';
	const FOOTER_GROUP = 'footer_settings';

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
			'page_title'  => __('Global Settings', Plugin::TEXT_DOMAIN),
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
			'key'        => 'banner_settings',
			'title'      => __('Banner Settings', Plugin::TEXT_DOMAIN),
			'menu_order' => 2,
			'fields'     => [
				[
					'key'          => self::BANNER_GROUP . '_button',
					'label'        => __('Button', Plugin::TEXT_DOMAIN),
					'type'         => 'link',
					'name'         => 'banner_button',
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
			'menu_order' => 3,
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
            'menu_order' => 4,
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

		acf_add_local_field_group([
			'key'        => 'global_cta',
			'title'      => __('Global CTA Settings', Plugin::TEXT_DOMAIN),
			'menu_order' => 5,
			'fields'     => [
				[
					'key'          => self::CTA_GROUP . 'global_cta_heading',
					'label'        => __('Heading', Plugin::TEXT_DOMAIN),
					'type'         => 'text',
					'name'         => 'global_cta_heading',
				],
				[
					'key'          => self::CTA_GROUP . 'global_cta_subheading',
					'label'        => __('Sub Heading', Plugin::TEXT_DOMAIN),
					'type'         => 'text',
					'name'         => 'global_cta_subheading',
				],
				[
					'key'          => self::CTA_GROUP . 'global_cta_text',
					'label'        => __('Text Content', Plugin::TEXT_DOMAIN),
					'type'         => 'wysiwyg',
					'name'         => 'global_cta_text',
				],
				[
					'key'          => self::CTA_GROUP . 'global_cta_button',
					'label'        => __('Button', Plugin::TEXT_DOMAIN),
					'type'         => 'link',
					'name'         => 'global_cta_button',
					'wrapper'  => [
						'width' => '50%'
					]
				],
				[
					'key'          => self::CTA_GROUP . 'global_cta_image',
					'label'        => __('Image', Plugin::TEXT_DOMAIN),
					'type'         => 'image',
					'name'         => 'global_cta_image',
					'wrapper'  => [
						'width' => '50%'
					]
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
			'key'        => 'footer_settings',
			'title'      => __('Footer Settings', Plugin::TEXT_DOMAIN),
			'menu_order' => 6,
			'fields'     => [
				[
					'key'      => self::FOOTER_GROUP . '_form_title',
					'type'     => 'text',
					'name'     => 'footer_form_title',
					'label'    => __('Form Title', Plugin::TEXT_DOMAIN),
					'required' => 1,
					'wrapper'  => [
						'width' => '50%'
					]
				],
				[
					'key'     => self::FOOTER_GROUP . '_form',
					'type'    => 'select',
					'name'    => 'footer_form',
					'label'   => __('Form', Plugin::TEXT_DOMAIN),
					'choices' => Util::getGFForms(true),
					'wrapper' => [
						'width' => '30%'
					]
				],
				[
					'key'   => self::FOOTER_GROUP . '_image_type',
					'label' => __('Type of image', Plugin::TEXT_DOMAIN),
					'name'  => 'footer_img_type',
					'type'  => 'select',
					'choices' => [
						'file' => __('png/jpeg', Plugin::TEXT_DOMAIN),
						'svg'  => __('svg', Plugin::TEXT_DOMAIN),
					],
					'wrapper' => [
						'width' => '20%'
					]
				],
				[
					'key'          => self::FOOTER_GROUP . '_image_file',
					'label'        => __('Image', Plugin::TEXT_DOMAIN),
					'type'         => 'image',
					'name'         => 'footer_img_file',
					'conditional_logic' => [
						[
							[
								'field'    => self::FOOTER_GROUP . '_image_type',
								'operator' => '==',
								'value'    => 'file'
							]
						]
					],
				],
				[
					'key'          => self::FOOTER_GROUP . '_image_svg',
					'label'        => __('Image', Plugin::TEXT_DOMAIN),
					'type'         => 'textarea',
					'name'         => 'footer_img_svg',
					'conditional_logic' => [
						[
							[
								'field'    => self::FOOTER_GROUP . '_image_type',
								'operator' => '==',
								'value'    => 'svg'
							]
						]
					],
				],
				[
					'key'          => self::FOOTER_GROUP . '_background_image',
					'label'        => __('Background Image', Plugin::TEXT_DOMAIN),
					'type'         => 'image',
					'name'         => 'footer_background_img',
				],
				[
					'key'          => self::FOOTER_GROUP . '_content',
					'label'        => __('Footer Content', Plugin::TEXT_DOMAIN),
					'type'         => 'wysiwyg',
					'name'         => 'footer_content',
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

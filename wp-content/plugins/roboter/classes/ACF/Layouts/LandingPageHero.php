<?php


namespace TFR\ACF\Layouts;

use TFR\Plugin;
use TFR\Util;
use TFR\ACFToPost\Util\FieldGenerator;
use TFR\ACFToPost\Base\Layout;

class LandingPageHero extends Layout {

	public function __construct() {
		parent::__construct();

		$this->setName( 'landing-page-hero' );
        $this->setLabel( __( 'Hero', Plugin::TEXT_DOMAIN ) );
		$this->setRepeaters( ['landing_page_modules'] );
	}

	public function setFields() {
		$fields = new FieldGenerator( $this->getKey() );

		$this->fields = [
			$fields->add('select', [
				'name' => 'background',
				'label' => __('Background', Plugin::TEXT_DOMAIN),
				'choices' => [
					'image' => 'Image',
					'dark'  => 'Dark',
					'light' => 'Light',
				],
				'wrapper' => [
					'width' => '30%',
				],
			]),

			$fields->add('image', [
				'name' => 'image',
				'label' => __('Image', Plugin::TEXT_DOMAIN),
				'wrapper' => [
					'width' => '70%',
				],
				'conditional_logic' => [
					[
						[
							'field'    => $this->getKey() . '_background',
							'operator' => '==',
							'value'    => 'image'
						]
					]
				],
			]),

			$fields->add( 'text', [
				'name'  => 'heading',
                'label' => __( 'Heading', Plugin::TEXT_DOMAIN ),
			]),

			$fields->add( 'text', [
				'name'  => 'sub_heading',
                'label' => __( 'Subheading', Plugin::TEXT_DOMAIN ),
			]),

			$fields->add( 'wysiwyg', [
				'name'  => 'text',
                'label' => __( 'Text', Plugin::TEXT_DOMAIN ),
			]),

			$fields->add('select', [
				'name' => 'form',
				'label' => __('Form', Plugin::TEXT_DOMAIN),
				'choices' => Util::getGFForms(true),
			]),

			$fields->add('text', [
				'name' => 'form_title',
				'label' => __('Form Title', Plugin::TEXT_DOMAIN),
				'conditional_logic' => [
					[
						[
							'field'    => $this->getKey() . '_form',
							'operator' => '!=',
							'value'    => '0'
						]
					]
				],
			]),

			$fields->add('group', [
				'name' => 'cta_group',
				'label' => __('CTA', Plugin::TEXT_DOMAIN),
				'conditional_logic' => [
					[
						[
							'field'    => $this->getKey() . '_form',
							'operator' => '!=',
							'value'    => '0'
						]
					]
				],
				'sub_fields' => [
					$fields->add('text', [
						'name' => 'cta_text',
						'label' => __('CTA Text', Plugin::TEXT_DOMAIN),
					]),

					$fields->add('text', [
						'name' => 'cta_phone',
						'label' => __('Phone Number', Plugin::TEXT_DOMAIN),
					])
				]
			]),

			$fields->add('link', [
				'name' => 'button',
				'label' => __('Button', Plugin::TEXT_DOMAIN),
				'conditional_logic' => [
					[
						[
							'field'    => $this->getKey() . '_form',
							'operator' => '==',
							'value'    => '0'
						]
					]
				],
			])
		];
	}
}

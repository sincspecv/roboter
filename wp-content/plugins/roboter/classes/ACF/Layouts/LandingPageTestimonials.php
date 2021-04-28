<?php


namespace TFR\ACF\Layouts;

use TFR\Plugin;
use TFR\Util;
use TFR\ACFToPost\Util\FieldGenerator;
use TFR\ACFToPost\Base\Layout;

class LandingPageTestimonials extends Layout {

	public function __construct() {
		parent::__construct();

		$this->setName( 'landing-page-testimonials' );
        $this->setLabel( __( 'Testimonials', Plugin::TEXT_DOMAIN ) );
		$this->setRepeaters( ['landing_page_modules'] );
	}

	public function setFields() {
		$fields = new FieldGenerator( $this->getKey() );

		$this->fields = [
			$fields->add('select', [
				'name' => 'background',
				'label' => __('Background', Plugin::TEXT_DOMAIN),
				'choices' => [
					'default' => 'Default',
					'light' => 'Light',
					'medium' => 'Medium',
					'dark' => 'Dark',
				],
				'wrapper' => [
					'width' => '30%',
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

			$fields->add('relationship', [
				'name' => 'testimonials',
				'label' => __('Testimonials', Plugin::TEXT_DOMAIN),
				'post_type' => [
					0 => 'testimonial',
				],
				'filters' => [
					0 => 'search',
				],
				'max' => 3,
				'return_format' => 'object',
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
			]),
		];
	}
}

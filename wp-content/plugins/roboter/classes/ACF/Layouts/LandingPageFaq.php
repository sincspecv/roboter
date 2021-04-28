<?php


namespace TFR\ACF\Layouts;

use TFR\Plugin;
use TFR\Util;
use TFR\ACFToPost\Util\FieldGenerator;
use TFR\ACFToPost\Base\Layout;

class LandingPageFaq extends Layout {

	public function __construct() {
		parent::__construct();

		$this->setName( 'landing-page-faq' );
        $this->setLabel( __( 'FAQ', Plugin::TEXT_DOMAIN ) );
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

			$fields->add('repeater', [
				'name' => 'faqs',
				'label' => __('FAQs', Plugin::TEXT_DOMAIN),
				'min'   =>  1,
				'layout' => 'block',
				'collapsed' => $this->getKey() . '_faq_heading',
				'button_label' => __('Add FAQ', Plugin::TEXT_DOMAIN),
				'sub_fields' => [
					$fields->add('text', [
						'name' => 'faq_heading',
						'label' => __('FAQ Heading', Plugin::TEXT_DOMAIN),
						'required' => 1,
					]),

					$fields->add('wysiwyg', [
						'name' => 'faq_text',
						'label' => __('FAQ Text', Plugin::TEXT_DOMAIN),
						'required' => 1,
					]),
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

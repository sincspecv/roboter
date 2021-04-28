<?php


namespace TFR\ACF\Groups;

use TFR\Plugin;
use TFR\ACFToPost\Base\Group;
use TFR\ACFToPost\Util\FieldGenerator;

class LandingPage extends Group {
	public function __construct() {
		parent::__construct();

		// Set the group parameters
		$this->setTitle( __( 'Landing Page Content', Plugin::TEXT_DOMAIN ) );
		$this->setTemplates( ['views/template-landing-page.blade.php'] );
		$this->setHiddenElements( ['the_content'] );
	}

	public function setFields() {
		$fields = new FieldGenerator($this->getKey());

		$this->fields = [
			$fields->add('select', [
				'name' => 'background_color',
				'label' => __('Background Color', Plugin::TEXT_DOMAIN),
				'choices' => [
					'light' => 'Light',
					'dark' => 'Dark',
				],
				'default_value' => [
					0 => 'light',
				],
				'ui' => 1,
			]),

			$fields->add('text', [
				'name' => 'phone_number',
				'label' => __('Phone Number', Plugin::TEXT_DOMAIN),
				'wrapper' => [
					'width' => '33%'
				]
			]),

			$fields->add('text', [
				'name' => 'phone_number_cta',
				'label' => __('Phone Number CTA Text', Plugin::TEXT_DOMAIN),
				'wrapper' => [
					'width' => '33%'
				]
			]),

			$fields->add('link', [
				'name' => 'button',
				'label' => __('Button', Plugin::TEXT_DOMAIN),
				'wrapper' => [
					'width' => '33%'
				]
			])
		];

	}
}

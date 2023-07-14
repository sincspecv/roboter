<?php


namespace TFR\ACF\Blocks;

use TFR\ACFToPost\Base\Group;
use TFR\ACFToPost\Util\FieldGenerator;
use TFR\Plugin;

class TestView extends Group {
	public function __construct() {
		parent::__construct();

		// Set the group parameters
		$this->setTitle( __( 'Test View', Plugin::TEXT_DOMAIN ) );
		$this->setLocation( [
            'param' => 'block',
            'operator' => '==',
            'value' => 'acf/test-view'
        ] );
	}

	public function setFields() {
		$fields = new FieldGenerator($this->getKey());

		$this->fields = [
			$fields->add('text', [
				'name' => 'name',
				'label' => __('Name', Plugin::TEXT_DOMAIN),
			]),

			$fields->add('text', [
				'name' => 'company',
				'label' => __('Company/Organization', Plugin::TEXT_DOMAIN),
			]),

			$fields->add('textarea', [
				'name' => 'testimonial',
				'label' => __('Testimonial', Plugin::TEXT_DOMAIN),
			])
		];
	}
}

<?php


namespace TFR\ACF\Groups;

use TFR\Plugin;
use TFR\ACFToPost\Base\Group;
use TFR\ACFToPost\Util\FieldGenerator;

class Testimonial extends Group {
	public function __construct() {
		parent::__construct();

		// Set the group parameters
		$this->setTitle( __( 'Testimonial', Plugin::TEXT_DOMAIN ) );
		$this->setPostTypes( ['testimonial'] );
		$this->setHiddenElements( ['the_content', 'author'] );
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

<?php


namespace TFR\ACF\Groups;

use TFR\Plugin;
use TFR\Util;
use TFR\ACFToPost\Base\Group;
use TFR\ACFToPost\Util\FieldGenerator;

class LandingPageFooter extends Group {
	public function __construct() {
		parent::__construct();

		// Set the group parameters
		$this->setTitle( __( 'Footer Options', Plugin::TEXT_DOMAIN ) );
		$this->setTemplates( ['views/template-landing-page.blade.php'] );
		$this->setHiddenElements( ['the_content'] );
		$this->setOrder(1);
	}

	public function setFields() {
		$fields = new FieldGenerator($this->getKey());

		$this->fields = [
			$fields->add('text', [
				'name' => 'footer_phone',
				'label' => __('Phone Number', Plugin::TEXT_DOMAIN),
				'wrapper' => [
					'width' => '50%'
				]
			]),

			$fields->add('text', [
				'name' => 'footer_location_name',
				'label' => __('Location Name', Plugin::TEXT_DOMAIN),
				'wrapper' => [
					'width' => '50%'
				]
			]),

			$fields->add('wysiwyg', [
				'name' => 'footer_address',
				'label' => __('Address', Plugin::TEXT_DOMAIN),
			]),

			$fields->add('wysiwyg', [
				'name' => 'footer_hours',
				'label' => __('Hours', Plugin::TEXT_DOMAIN),
			]),

			$fields->add('select', [
				'name' => 'right_column',
				'label' => __('What to display in the right column', Plugin::TEXT_DOMAIN),
				'choices' => [
					'form' => 'Form',
					'image' => 'Image',
					'none' => 'Nothing'
				]
			]),

			$fields->add('text', [
				'name' => 'footer_form_title',
				'label' => __('Form Title', Plugin::TEXT_DOMAIN),
				'conditional_logic' => [
					[
						[
							'field'    => $this->getKey() . '_right_column',
							'operator' => '==',
							'value'    => 'form'
						]
					]
				],
				'required' => 1,
				'wrapper' => [
					'width' => '50%'
				]
			]),

			$fields->add('select', [
				'name' => 'footer_form',
				'label' => __('Form', Plugin::TEXT_DOMAIN),
				'choices' => Util::getGFForms(),
				'conditional_logic' => [
					[
						[
							'field'    => $this->getKey() . '_right_column',
							'operator' => '==',
							'value'    => 'form'
						]
					]
				],
				'wrapper' => [
					'width' => '50%'
				]
			]),

			$fields->add('image', [
				'name' => 'footer_image',
				'label' => __('Image', Plugin::TEXT_DOMAIN),
				'conditional_logic' => [
					[
						[
							'field'    => $this->getKey() . '_right_column',
							'operator' => '==',
							'value'    => 'image'
						]
					]
				],
				'required' => 1,
			]),
		];

	}
}

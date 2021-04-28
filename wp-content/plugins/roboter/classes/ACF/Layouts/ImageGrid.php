<?php


namespace TFR\ACF\Layouts;

use TFR\Plugin;
use TFR\Util;
use TFR\ACFToPost\Util\FieldGenerator;
use TFR\ACFToPost\Base\Layout;

class ImageGrid extends Layout {

	public function __construct() {
		parent::__construct();

		$this->setName( 'image-grid' );
        $this->setLabel( __( 'Image Grid', Plugin::TEXT_DOMAIN ) );
		$this->setRepeaters( ['modules', 'post_modules', 'landing_page_modules'] );
	}

	public function setFields() {
		$fields = new FieldGenerator( $this->getKey() );

		$this->fields = [
			$fields->add('repeater', [
				'name' => 'images',
				'label' => __('Images', Plugin::TEXT_DOMAIN),
				'button_label' => __('Add Image', Plugin::TEXT_DOMAIN),
				'layout' => 'block',
				'sub_fields' => [
					$fields->add('image', [
						'name' => 'image',
						'label' => __('Image', Plugin::TEXT_DOMAIN),
						'wrapper' => [
							'width' => '50%',
						],
					]),

					$fields->add('text', [
						'name' => 'subtitle',
						'label' => __('Subtitle', Plugin::TEXT_DOMAIN),
						'wrapper' => [
							'width' => '50%',
						],
					]),

					$fields->add('wysiwyg', [
						'name' => 'text',
						'label' => __('Caption', Plugin::TEXT_DOMAIN),
					]),
				],
				'min' => 1,
				'max' => 10,
			]),
		];
	}
}

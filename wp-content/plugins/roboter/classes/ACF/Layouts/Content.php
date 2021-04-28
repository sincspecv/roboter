<?php


namespace TFR\ACF\Layouts;

use TFR\Plugin;
use TFR\ACFToPost\Util\FieldGenerator;
use TFR\ACFToPost\Base\Layout;

class Content extends Layout {

	public function __construct() {
		parent::__construct();

		$this->setName( 'content' );
		$this->setLabel( __( 'Content', Plugin::TEXT_DOMAIN ) );
		$this->setRepeaters( ['modules', 'post_modules'] );
	}

	public function setFields() {
		$fields = new FieldGenerator( $this->getKey() );

		$this->fields = [
			$fields->add( 'wysiwyg', [
				'name'  => 'text',
				'label' => __( 'Text', Plugin::TEXT_DOMAIN ),
			]),

			$fields->add( 'select', [
				'name'  => 'background',
				'label' => __( 'Background Color', Plugin::TEXT_DOMAIN ),
				'choices' => [
					'#f5f7f9' => 'Grey',
					'#fefefe' => 'White'
				]
			])
		];
	}
}

<?php


namespace TFR\ACF\Layouts;

use TFR\Plugin;
use TFR\ACFToPost\Util\FieldGenerator;
use TFR\ACFToPost\Base\Layout;

class Hero extends Layout {

	public function __construct() {
		parent::__construct();

		$this->setName( 'hero' );
        $this->setLabel( __( 'Hero', Plugin::TEXT_DOMAIN ) );
		$this->setRepeaters( ['modules', 'post_modules'] );
	}

	public function setFields() {
		$fields = new FieldGenerator( $this->getKey() );

		$this->fields = [
			$fields->add( 'text', [
				'name'  => 'heading',
            'label' => __( 'Heading', Plugin::TEXT_DOMAIN ),
			]),

			$fields->add( 'wysiwyg', [
				'name'  => 'text',
            'label' => __( 'Text', Plugin::TEXT_DOMAIN ),
			]),
		];
	}
}

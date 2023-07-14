<?php

namespace TFR\ACF\Blocks;

use TFR\ACFToPost\Base\Group;
use TFR\ACFToPost\Util\FieldGenerator;
use TFR\Plugin;
use TFR\Util;

class Hero extends Group {
	public function __construct() {
		parent::__construct();

		// Set the group parameters
		$this->setTitle( __( 'Hero', Plugin::TEXT_DOMAIN ) );
		$this->setLocation( [
            'param' => 'block',
            'operator' => '==',
            'value' => 'acf/hero'
        ] );
	}

	public function setFields() {
		$fields = new FieldGenerator($this->getKey());

        $this->fields = [
            $fields->add('image',  [
                'name' => 'image',
                'label' => __( 'Background Image', Plugin::TEXT_DOMAIN ),
                'instructions' => __( 'Leave blank to use the featured image. Select the color background style if you do not want to use an image at all.', Plugin::TEXT_DOMAIN )
            ]),

            $fields->add( 'text', [
                'name'  => 'heading',
                'label' => __( 'Heading', Plugin::TEXT_DOMAIN ),
                'instructions' => __( 'Leave blank to use the page title.', Plugin::TEXT_DOMAIN )
            ]),

            $fields->add( 'wysiwyg', [
                'name'  => 'text',
                'label' => __( 'Text', Plugin::TEXT_DOMAIN ),
            ]),

            $fields->add( 'link', [
                'name'  => 'button',
                'label' => __( 'Button', Plugin::TEXT_DOMAIN ),
            ]),
        ];
	}
}

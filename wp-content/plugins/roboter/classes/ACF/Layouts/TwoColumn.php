<?php


namespace TFR\ACF\Layouts;

use TFR\Plugin;
use TFR\ACFToPost\Util\FieldGenerator;
use TFR\ACFToPost\Base\Layout;

class TwoColumn extends Layout {

	public function __construct() {
		parent::__construct();

		$this->setName( 'two-column' );
		$this->setLabel( __( 'Two Column Layout', Plugin::TEXT_DOMAIN ) );
		$this->setRepeaters( ['modules', 'post_modules', 'landing_page_modules'] );
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
                    'dark'  => 'Dark',
                ],
            ]),

            $fields->add('group', [
                'name' => 'left_column',
                'label' => __('Left Column', Plugin::TEXT_DOMAIN),
                'sub_fields' => [

                    $fields->add( 'text', [
                        'name'  => 'heading',
                        'label' => __( 'Heading', Plugin::TEXT_DOMAIN ),
                    ]),

                    $fields->add( 'wysiwyg', [
                        'name'  => 'text',
                        'label' => __( 'Text', Plugin::TEXT_DOMAIN ),
                    ]),

                    $fields->add( 'link', [
                        'name'  => 'button',
                        'label' => __( 'Button', Plugin::TEXT_DOMAIN ),
                    ]),
                ],
                'wrapper' => [
                    'width' => '50%',
                ],
            ]),

            $fields->add('group', [
                'name' => 'right_column',
                'label' => __('Right Column', Plugin::TEXT_DOMAIN),
                'sub_fields' => [

                    $fields->add( 'text', [
                        'name'  => 'heading',
                        'label' => __( 'Heading', Plugin::TEXT_DOMAIN ),
                    ]),

                    $fields->add( 'wysiwyg', [
                        'name'  => 'text',
                        'label' => __( 'Text', Plugin::TEXT_DOMAIN ),
                    ]),

                    $fields->add( 'link', [
                        'name'  => 'button',
                        'label' => __( 'Button', Plugin::TEXT_DOMAIN ),
                    ]),
                ],
                'wrapper' => [
                    'width' => '50%',
                ],
            ]),
		];
	}
}

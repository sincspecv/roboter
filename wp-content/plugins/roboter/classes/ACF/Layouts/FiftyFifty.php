<?php


namespace TFR\ACF\Layouts;

use TFR\Plugin;
use TFR\ACFToPost\Util\FieldGenerator;
use TFR\ACFToPost\Base\Layout;

class FiftyFifty extends Layout {

	public function __construct() {
		parent::__construct();

		$this->setName( '50_50' );
		$this->setLabel( __( '50/50', Plugin::TEXT_DOMAIN ) );
		$this->setRepeaters( ['modules', 'post_modules', 'landing_page_modules'] );
	}

	public function setFields() {
		$fields = new FieldGenerator( $this->getKey() );

		$this->fields = [
			$fields->add( 'repeater', [
				'name'       => 'rows',
				'label'      => __( 'Rows', Plugin::TEXT_DOMAIN ),
				'layout'     => 'block',
				'sub_fields' => [

					$fields->add('group', [
						'name' => 'left_block',
						'label' => __('Left Block', Plugin::TEXT_DOMAIN),
						'sub_fields' => [
							$fields->add('select', [
								'name' => 'left_background',
								'label' => __('Background', Plugin::TEXT_DOMAIN),
								'choices' => [
									'default' => 'Default',
									'light' => 'Light',
									'medium' => 'Medium',
									'dark'  => 'Dark',
									'image' => 'Image'
								],
							]),

							$fields->add( 'image', [
								'name'  => 'left_image',
								'label' => __( 'Image', Plugin::TEXT_DOMAIN ),
								'conditional_logic' => [
									[
										[
											'field'    => $this->getKey() . '_left_background',
											'operator' => '==',
											'value'    => 'image'
										]
									]
								],
							]),

							$fields->add( 'text', [
								'name'  => 'left_heading',
								'label' => __( 'Heading', Plugin::TEXT_DOMAIN ),
								'conditional_logic' => [
									[
										[
											'field'    => $this->getKey() . '_left_background',
											'operator' => '!=',
											'value'    => 'image'
										]
									]
								],
							]),

							$fields->add( 'wysiwyg', [
								'name'  => 'left_text',
								'label' => __( 'Text', Plugin::TEXT_DOMAIN ),
								'conditional_logic' => [
									[
										[
											'field'    => $this->getKey() . '_left_background',
											'operator' => '!=',
											'value'    => 'image'
										]
									]
								],
							]),

							$fields->add( 'link', [
								'name'  => 'left_button',
								'label' => __( 'Button', Plugin::TEXT_DOMAIN ),
								'conditional_logic' => [
									[
										[
											'field'    => $this->getKey() . '_left_background',
											'operator' => '!=',
											'value'    => 'image'
										]
									]
								],
							]),
						],
						'wrapper' => [
							'width' => '50%',
						],
					]),

					$fields->add('group', [
						'name' => 'right_block',
						'label' => __('Right Block', Plugin::TEXT_DOMAIN),
						'sub_fields' => [
							$fields->add('select', [
								'name' => 'right_background',
								'label' => __('Background', Plugin::TEXT_DOMAIN),
								'choices' => [
									'default' => 'Default',
									'light' => 'Light',
									'medium' => 'Medium',
									'dark'  => 'Dark',
									'image' => 'Image'
								],
							]),

							$fields->add( 'image', [
								'name'  => 'right_image',
								'label' => __( 'Image', Plugin::TEXT_DOMAIN ),
								'conditional_logic' => [
									[
										[
											'field'    => $this->getKey() . '_right_background',
											'operator' => '==',
											'value'    => 'image'
										]
									]
								],
							]),

							$fields->add( 'text', [
								'name'  => 'right_heading',
								'label' => __( 'Heading', Plugin::TEXT_DOMAIN ),
								'conditional_logic' => [
									[
										[
											'field'    => $this->getKey() . '_right_background',
											'operator' => '!=',
											'value'    => 'image'
										]
									]
								],
							]),

							$fields->add( 'wysiwyg', [
								'name'  => 'right_text',
								'label' => __( 'Text', Plugin::TEXT_DOMAIN ),
								'conditional_logic' => [
									[
										[
											'field'    => $this->getKey() . '_right_background',
											'operator' => '!=',
											'value'    => 'image'
										]
									]
								],
							]),

							$fields->add( 'link', [
								'name'  => 'right_button',
								'label' => __( 'Button', Plugin::TEXT_DOMAIN ),
								'conditional_logic' => [
									[
										[
											'field'    => $this->getKey() . '_right_background',
											'operator' => '!=',
											'value'    => 'image'
										]
									]
								],
							]),
						],
						'wrapper' => [
							'width' => '50%',
						],
					]),
				]
			]),
		];
	}
}

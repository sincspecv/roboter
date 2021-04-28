<?php


namespace TFR\TemplateEngine;

use TFR\Plugin;
use TFR\PostTypes\Template;

class MetaBox {
	const POST_TYPES = ['page', 'post'];

	/**
	 * Adds actions to their respective WordPress hooks.
	 */
	public static function init() {
		add_action( 'add_meta_boxes', [self::class, 'addMetaBoxes'] );
		add_action( 'save_post', [self::class, 'savePost'] );
		add_action( 'admin_footer', [self::class, 'adminFooter'] );
	}

	/**
	 * Hooks into WordPress' add_meta_boxes function.
	 * Goes through screens (post types) and adds the meta box.
	 */
	public static function addMetaBoxes() {
		$screens = self::getScreens();

		foreach ( $screens as $screen ) {
			add_meta_box(
				'choose-template',
				__( 'Choose Flexible Layout Template', Plugin::TEXT_DOMAIN ),
				[self::class, 'addMetaBoxCallback' ],
				$screen,
				'side',
				'core'
			);
		}
	}

	/**
	 * Generates the HTML for the meta box
	 *
	 * @param object $post WordPress post object
	 */
	public static function addMetaBoxCallback( $post ) {
		wp_nonce_field( 'choose_template_data', 'choose_template_nonce' );
		self::generateFields( $post );
	}

	/**
	 * Generates the field's HTML for the meta box.
	 */
	public static function generateFields( $post ) {
		$fields = self::getFields();
		$output = '';
		foreach ( $fields as $field ) {
			$label = '<label for="' . $field['id'] . '">' . $field['label'] . '</label>';
			$db_value = self::getMeta( $post->ID, $field['id'] );
			switch ( $field['type'] ) {
				case 'select':
					$input = sprintf(
						'<select disabled id="%s" name="%s" style="%s">',
						$field['id'],
						$field['id'],
						$field['style']
					);
					foreach ( $field['options'] as $key => $value ) {
						$input .= sprintf(
							'<option %s value="%s">%s</option>',
							$db_value == $key ? 'selected' : '',
							$key,
							$value
						);
					}
					$input .= '</select>';
					$output .= '<p style="width:100%">' . $label . '<br>' . $input . '</p>';
					break;
				case 'hidden' :
					$input = sprintf(
						'<input id="%s" name="%s" type="%s" value="%s">',
						$field['id'],
						$field['id'],
						$field['type'],
						$field['value']
					);
					$output .= $input;
					break;
				default:
					$input = sprintf(
						'<input id="%s" name="%s" type="%s" value="%s">',
						$field['id'],
						$field['id'],
						$field['type'],
						$db_value
					);
					$output .= '<p>' . $label . '<br>' . $input . '</p>';
			}
		}
		$output .= '<p><a href="" id="enable_select" style="color:#a00;display:none;">Choose a new template</a></p>';
		echo $output;
	}

	/**
	 * Hooks into WordPress' save_post function
	 */
	public static function savePost( $post_id ) {
		if ( ! isset( $_POST['choose_template_nonce'] ) )
			return $post_id;

		$nonce = $_POST['choose_template_nonce'];
		if ( ! wp_verify_nonce( $nonce, 'choose_template_data' ) )
			return $post_id;

		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
			return $post_id;

		$fields = self::getFields();
		foreach ( $fields as $field ) {
			if ( isset( $_POST[ $field['id'] ] ) ) {
				switch ( $field['id'] ) {
					case 'template' :
						if( ! $_POST['has_modules'] ) {
							$modules = get_post_meta( (int)$_POST['template'], FlexibleContent::KEY, true );
							if( $modules !== FALSE ) {
								update_post_meta( $post_id, FlexibleContent::KEY, $modules );
							}
							update_post_meta( $post_id, '_choose_template_' . $field['id'], (int)$_POST['template'] );
						}
						break;
					case 'chosen_template' :
						if( $_POST['template'] ) {
							update_post_meta( $post_id, '_choose_template_' . $field['id'], (int)$_POST['template'] );
						}
						break;
					default :
						return false;
				}
			}
		}
	}

	public static function getScreens() {
		$screens = self::POST_TYPES;

		// We don't want this shown on the template post type
		$key = array_search( Template::SLUG, $screens );
		if( $key !== FALSE ) {
			unset( $screens[$key] );
		}

		// Check if the current page is using the page template for flexible content
		$current_screen_template = get_page_template_slug();
		if( in_array( $current_screen_template, FlexibleContent::PAGE_TEMPLATES ) ) {
			$screen = get_current_screen();
			$screens[] = $screen->post_type;
		}

		return $screens;
	}

	public static function getFields() {
		global $post;
		$templates = get_posts( ['post_type' => Template::SLUG] );
		$selects = [ __( 'None', Plugin::TEXT_DOMAIN ) ];

		foreach( $templates as $template ) {
			$selects[$template->ID] = $template->post_title;
		}

		$fields = [
			[
				'id'      => 'template',
				'label'   => __( 'Layout Template', Plugin::TEXT_DOMAIN ),
				'type'    => 'select',
				'options' => $selects,
				'style'   => 'width:100%;',
			],
			[
				'id'    => 'chosen_template',
				'type'  => 'hidden',
				'value' => '',
			],
			[
				'id'    => 'has_modules',
				'type'  => 'hidden',
				'value' => (int)self::hasModules( $post->ID ),
			],
		];

		return $fields;
	}

	public static function getMeta( $post_id, $field_id ) {
		return get_post_meta( $post_id, '_choose_template_' . $field_id, true );
	}

	public static function hasModules( $post_id ) {
		$modules = get_post_meta( $post_id, FlexibleContent::KEY, true );
		if( empty( $modules ) ) {
			return false;
		}

		return true;
	}

	public static function adminFooter() {
		?>
		<div id="template-warning">
			<div id="template-warning__wrap">
                <span>
                    <strong>WARNING:</strong> Choosing a new template may cause loss of any content already entered. Please be sure to back up all of your content before changing the template.
                </span>
				<a id="template-warning-cancel" class="button warning">Cancel</a>
				<a id="template-warning-continue" class="button button-primary">Continue</a>
			</div>
		</div>

		<style>
			#template-warning {
				background: rgba(0,0,0,.65);
				width: 100%;
				height: 100%;
				position: fixed;
				top: 0;
				left: 0;
				z-index: 1000000;
				display: none;
			}
			#template-warning__wrap {
				position: relative;
				top: 50%;
				left: 50%;
				transform: translate(-50%, -50%);
				background: #fff;
				border-radius: 8px;
				padding: 64px;
				width: 90%;
				max-width: 600px;
				height: auto;
				text-align: center;
			}
			#template-warning__wrap span {
				display: block;
				font-size: 18px;
				margin-bottom: 18px;
			}
		</style>

		<script>
            jQuery(document).ready(function($) {
                if(($('#template').val() == $('#chosen_template').val()) || $('#has_modules').val() == true ) {
                    $('#template').prop('disabled', true);
                    $('#enable_select').show();
                } else {
                    $('#template').prop('disabled', false);
                }

                $('#enable_select').on('click', function(e) {
                    e.preventDefault();
                    $('#template-warning').show();
                    $('#template-warning-cancel').on('click', function(e) {
                        e.preventDefault();
                        $('#template-warning').hide();
                    });
                    $('#template-warning-continue').on('click', function(e) {
                        e.preventDefault();
                        $('#template').prop('disabled', false);
                        $('#enable_select').hide();
                        $('#has_modules').val(0);
                        $('#template-warning').hide();
                    })
                })
            })
		</script>
		<?php
	}
}

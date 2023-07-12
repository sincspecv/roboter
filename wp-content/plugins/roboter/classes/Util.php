<?php


namespace TFR;


class Util {
	/**
	 * Get all active Gravityforms for use in an ACF choice field.
	 * Pass TRUE to add a none option at the beginning of array.
	 *
	 * @param bool $add_none
	 *
	 * @return array
	 */
	public static function getGFForms($add_none = false) {
		$form_choices = [];
		if(class_exists('RGFormsModel')) {
			$forms = \RGFormsModel::get_forms(1);
			if($add_none) {
				$form_choices[false] = 'None';
			}
			foreach($forms as $form) {
				$form_choices[intval($form->id)] = ucfirst($form->title);
			}
		}

		return $form_choices;
	}

    public static function render_block_view($attributes, $content = '', $wp_block = null) {
        $name = str_replace('acf/', '', $attributes['name']);
        $view = "{$attributes['path']}/{$name}.blade.php";
        $fields = json_decode(json_encode(get_fields($attributes['id'])));

        if (file_exists($view)) {
//            echo view("TFR::blocks/{$name}", ['block' => $attributes, 'fields' => $fields]);
            echo view($view, ['block' => $attributes, 'fields' => $fields]);
        }
    }
}

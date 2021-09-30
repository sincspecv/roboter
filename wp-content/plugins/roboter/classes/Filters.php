<?php


namespace TFR;


class Filters {
	public static function init() {
		add_filter( 'wp_kses_allowed_html', [self::class, 'allowed_tags'], 99, 2);
	}

	/**
	 * Allowed tags and attributes for wp_kses() with context 'acf' or 'tfr'
	 * Note: Tags with empty array will be allowed without attributes
	 */
	 public static function allowed_tags( $tags, $context ) {
		if ($context === 'acf' || $context === 'tfr') {
			$global_atts = [
				'data-*' => true,
				'aria-*' => true,
				'role' => true,
				'style' => true,
				'class' =>  true,
			];

			$tags['iframe'] = [
				'src'             => true,
				'height'          => true,
				'width'           => true,
				'frameborder'     => true,
				'allowfullscreen' => true,
				'image' => true,
			];
			$tags['svg'] = [
				'style'           => true,
				'class'           => true,
				'id'              => true,
				'aria-hidden'     => true,
				'aria-labelledby' => true,
				'xmlns'           => true,
				'width'           => true,
				'height'          => true,
				'viewbox'         => true,
			];
			$tags['polygon'] = [
				'points'            => true,
				'fill'              => true,
				'transform'         => true,
				'stroke-miterlimit' => true,
				'stroke-width'      => true,
				'stroke'            => true,
			];
			$tags['polyline'] = [
				'points'            => true,
				'fill'              => true,
				'transform'         => true,
				'stroke-miterlimit' => true,
				'stroke-width'      => true,
				'stroke'            => true,
			];
			$tags['defs'] = [];
			$tags['style'] = [];
			$tags['g'] =[
				'fill'    => true,
				'class'   => true,
				'opacity' => true,
			];
			$tags['clippath'] = [
				'class' => true,
				'id'    => true,
			];
			$tags['title'] = [];
			$tags['path']  = [
				'd'         => true,
				'fill'      => true,
				'fill-rule' => true,
				'class'     => true,
				'transform' => true,
				'stroke-miterlimit' => true,
				'stroke-width' => true,
				'stroke'    => true,
			];
			$tags['mask'] = [
				'id' => true,
				'x' => true,
				'y' => true,
				'width' => true,
				'height' => true,
				'maskunits' => true,
			];
			$tags['lineargradient'] = [
				'class'         => true,
				'gradientunits' => true,
				'stroke-miterlimit' => true,
				'id'            => true,
				'x1'            => true,
				'x2'            => true,
				'xlink:href'    => true,
				'y1'            => true,
				'y2'            => true,
			];
			$tags['stop'] = [
				'class'        => true,
				'offset'       => true,
				'style'        => true,
				'stop-color'   => true,
				'stop-opacity' => true,
			];
			$tags['rect'] = [
				'class'        => true,
				'fill-opacity' => true,
				'fill'         => true,
				'height'       => true,
				'rx'           => true,
				'stroke-width' => true,
				'stroke-miterlimit' => true,
				'stroke'       => true,
				'transform'    => true,
				'width'        => true,
				'x'            => true,
				'y'            => true,
			];
			$tags['line'] = [
				'class'        => true,
				'fill-opacity' => true,
				'fill'         => true,
				'height'       => true,
				'rx'           => true,
				'stroke-width' => true,
				'stroke-miterlimit' => true,
				'stroke'       => true,
				'transform'    => true,
				'width'        => true,
				'x'            => true,
				'y'            => true,
				'x1'            => true,
				'y1'            => true,
				'x2'            => true,
				'y2'            => true,
			];
			$tags['circle'] = [
				'class' => true,
				'cx'    => true,
				'cy'    => true,
				'fill'  => true,
				'r'     => true,
			];
			$tags['image'] = [
				'width' => true,
				'height' => true,
				'transform' => true,
				'src' => true,
				'alt' => true,
				'style' => true,
				'class' => true,
				'id' => true,
				'title' => true,
				'name' => true,
				'xlink:href' => true,
			];
			$tags['img'] = $tags['image'];
			$tags['filter'] = [
				'id' => true,
				'filterunits' => true,
				'color-interpolation-filters' => true,
			];
			$tags['span'] = [
				'class' => true,
				'id'    => true,
				'style' => true,
			];

			foreach ($tags as $tag => &$value) {
				$value = array_merge($value, $global_atts);
			}
		}

		return $tags;
	}
}
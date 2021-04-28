<?php

namespace TFR\ACF\Repeaters;

use TFR\Plugin;
use TFR\ACFToPost\Base\FlexibleContent;

class Modules extends FlexibleContent {
	public function __construct() {
		parent::__construct();

		$this->setLabel( __( 'Page Modules', Plugin::TEXT_DOMAIN ) );
		$this->setName( 'page_modules' );
		$this->setButtonLabel( __( 'Add Module', Plugin::TEXT_DOMAIN ) );
		$this->setGroups( ['page'] );
	}
}

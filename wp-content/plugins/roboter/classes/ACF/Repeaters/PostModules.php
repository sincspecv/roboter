<?php

namespace TFR\ACF\Repeaters;

use TFR\Plugin;
use TFR\ACFToPost\Base\FlexibleContent;

class PostModules extends FlexibleContent {
	public function __construct() {
		parent::__construct();

		$this->setLabel( __( 'Post Modules', Plugin::TEXT_DOMAIN ) );
		$this->setName( 'post_modules' );
		$this->setButtonLabel( __( 'Add Module', Plugin::TEXT_DOMAIN ) );
		$this->setGroups( ['post'] );
	}
}

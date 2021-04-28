<?php

namespace TFR\ACF\Repeaters;

use TFR\Plugin;
use TFR\ACFToPost\Base\FlexibleContent;

class LandingPageModules extends FlexibleContent {
	public function __construct() {
		parent::__construct();

		$this->setLabel( __( 'Landing Page Modules', Plugin::TEXT_DOMAIN ) );
		$this->setName( 'landing_page_modules' );
		$this->setButtonLabel( __( 'Add Module', Plugin::TEXT_DOMAIN ) );
		$this->setGroups( ['landing_page'] );
	}
}

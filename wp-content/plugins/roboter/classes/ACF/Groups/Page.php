<?php


namespace TFR\ACF\Groups;

use TFR\Plugin;
use TFR\ACFToPost\Base\Group;
use TFR\ACFToPost\Util\FieldGenerator;

class Page extends Group {
	public function __construct() {
		parent::__construct();

		// Set the group parameters
		$this->setTitle( __( 'Page Content', Plugin::TEXT_DOMAIN ) );
		$this->setPostTypes( ['page'] );
		$this->ignoreTemplates( ['views/template-landing-page.blade.php'] );
		$this->setHiddenElements( ['the_content'] );
	}
}

<?php


namespace TFR\ACF\Groups;

use TFR\Plugin;
use TFR\ACFToPost\Base\Group;
use TFR\ACFToPost\Util\FieldGenerator;

class Post extends Group {
	public function __construct() {
		parent::__construct();

		// Set the group parameters
		$this->setTitle( __( 'Post Content', Plugin::TEXT_DOMAIN ) );
		$this->setPostTypes( ['post'] );
		$this->setHiddenElements( ['the_content'] );
	}
}

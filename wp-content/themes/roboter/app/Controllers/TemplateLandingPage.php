<?php


namespace App\Controllers;

use Sober\Controller\Controller;
use Sober\Controller\Module\Tree;
use App\Theme\Util;

class TemplateLandingPage extends Controller implements Tree {
    protected $acf = true;

    public function display_phone_number() {
        $phone = get_field('phone_number');
        return Util::formatPhone($phone, 'display') ? Util::formatPhone($phone, 'display') : '';
    }

    public function link_phone_number() {
        $phone = get_field('phone_number');
        return Util::formatPhone($phone, 'link') ? Util::formatPhone($phone, 'link') : '';
    }
}

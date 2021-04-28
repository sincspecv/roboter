<?php


namespace TFR;


class Plugin {
    /**
     * Plugin version
     */
    const VERSION = '1.0.0';

    const TEXT_DOMAIN = 'digital-strike';

    /**
     * Plugin Path
     *
     * @var \Directory|false|null
     */
    public static $dir;

	/**
	 * Plugin URL
	 *
	 * @var string
	 */
	public static $url;

	public static function load() {
        self::setVariables();
        Bootstrap::init();
    }

    private static function setVariables() {
        self::$dir = dirname(__FILE__, 2);
	    self::$url = plugins_url('', self::$dir . '/plugin.php');
    }
}

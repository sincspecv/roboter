<?php
$env      = (object)parse_ini_file('env.ini');
$rootDir  = dirname(__FILE__);
$basename = basename($rootDir);
$url      = "http://{$basename}.loc";

/**
 * Database
 */
$table_prefix = $env->db_prefix; // called in wp-settings.php
define('DB_HOST', "{$env->db_host}:{$env->db_port}");
define('DB_NAME', $env->db_name);
define('DB_USER', $env->db_user);
define('DB_PASSWORD', $env->db_password);
define('DB_CHARSET', 'utf8');
define('DB_COLLATE', '');

define('AUTH_KEY', '5wzN_1-fW+=6+nkS;P5x|P@bVyodK5TK8<U#S+F/7<+dnBx7CxNt|qEAnsT-|:_l');
define('SECURE_AUTH_KEY', 'ExKm`Q]asm6i,j;LB6:B1b__P<D4XM5NQrbZz `mZ`G_0pI}.-b5Dc<v0_i.OUBI');
define('LOGGED_IN_KEY', 'TuJXxo1>|2TEEQ}&dgF+l3fxQiBQxt4q5e(Imp<+LE`2R]Bpo-nY/R05AqRXd-w(');
define('NONCE_KEY', '.ng{]lA~#`|Fn.&3b]JK#*rt[2-?Xm7zbdps8=3G!#Ij@T5:CXHW$-Hq[De@lk_f');
define('AUTH_SALT', '/Q.VdgAazA#am/h^Amn}6y3{K6okjaB%HNT_IRy+n{gtkVFNa4cLZ^:ZZ8COnH4t');
define('SECURE_AUTH_SALT', '|q8$`|O~!_Oa0~EFe;I?#cXk)&{jgf1nT(^P=}C5fJ7*5RtP`C0b1MjLsy.{(2kz');
define('LOGGED_IN_SALT', 'WR/>oEgDr5R_5p!=~@bOAb>NMmXTT-TdG)cW(9XRp6 +89x>Jht%I0g>;i{Cm(s=');
define('NONCE_SALT', '7Y0uz+YJN{myf>Xxbnk8=ec+^U|a<.-t_#Y5)l+r+UZqUo6*u;>@Gk]#eMwIwfAd');

define('WP_SITEURL', "{$url}/wp");
define('WP_HOME', "{$url}");

define('WP_CONTENT_DIR', "{$rootDir}/wp-content");
define('WP_CONTENT_URL', "{$url}/wp-content");

define('WP_DEBUG', true);
define('WP_DEBUG_LOG', true);
define('WP_DEBUG_DISPLAY', true);

if (!defined('ABSPATH')) {
    define('ABSPATH', "$rootDir/");
}

require_once ABSPATH . 'wp-settings.php';

<?php
error_reporting ( E_ALL );
ini_set ( 'display_errors', 'On' );
mb_language ( 'uni' );
mb_internal_encoding ( 'UTF-8' );
define ( "DB_DSN", "mysql:host=localhost;dbname=cs_news" );
define ( "DB_USERNAME", "root" );
define ( "DB_PASSWORD", "" );

define ( "HOMEPAGE_NUM_ARTICLES", 10 );
$app_URI = rtrim ( $_SERVER ['REQUEST_URI'], '/' );

$expl = explode ( "\\", dirname ( __FILE__ ) );
define ( 'ROOT', "/" . end ( $expl ) );
define ( "CSS_PATH", ROOT . "/css" );
define ( "IMAGE_PATH", ROOT . "/images" );
define ( "JS_PATH", ROOT . "/js" );


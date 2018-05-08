<?php
/*
if (!defined('DS')) {
         define('DS', DIRECTORY_SEPARATOR);
}
if (!defined('ROOT')) {
         define('ROOT', dirname(dirname(dirname(__FILE__))));
}
if (!defined('APP_DIR')) {
         define('APP_DIR', basename(dirname(dirname(__FILE__))));
}
 
if (!defined('CAKE_CORE_INCLUDE_PATH')) {
         define('CAKE_CORE_INCLUDE_PATH', ROOT);
}
if (!defined('WEBROOT_DIR')) {
         define('WEBROOT_DIR', basename(dirname(__FILE__)));
}
if (!defined('WWW_ROOT')) {
         define('WWW_ROOT', dirname(__FILE__) . DS);
}
if (!defined('CORE_PATH')) {
//         if (function_exists('ini_set')) {
//         		  echo("one");
//                  ini_set('include_path', ini_get('include_path') . 
//PATH_SEPARATOR .
//CAKE_CORE_INCLUDE_PATH . PATH_SEPARATOR . ROOT . DS . APP_DIR . DS);
 //                 define('APP_PATH', null);
//                  define('CORE_PATH', null);
//         } else {
         		  //echo("two");
                  define('APP_PATH', ROOT . DS . APP_DIR . DS);
                  define('CORE_PATH', CAKE_CORE_INCLUDE_PATH . DS);
//         }
}
  
include CAKE_CORE_INCLUDE_PATH .DS . 'cake' . DS . 'basics.php';
include CAKE_CORE_INCLUDE_PATH .DS . 'cake' . DS . 'config' . DS. 'paths.php';
include CAKE_CORE_INCLUDE_PATH .DS . 'cake' . DS . 'libs' . DS . 'object.php';
include CAKE_CORE_INCLUDE_PATH .DS . 'cake' . DS . 'libs' . DS . 'security.php';
include CAKE_CORE_INCLUDE_PATH .DS . 'cake' . DS . 'libs' . DS . 'cake_session.php';
include CAKE_CORE_INCLUDE_PATH .DS . 'cake' . DS . 'libs' . DS . 'inflector.php';
include CAKE_CORE_INCLUDE_PATH .DS . 'cake' . DS . 'libs' . DS . 'cache.php';
include CAKE_CORE_INCLUDE_PATH .DS . 'cake' . DS . 'libs' . DS . 'configure.php'; 
//include APP_PATH . 'config' .DS  .'core.php';
 
function cake_login($session) {
	$s = new CakeSession(null);
	$s = new CakeSession(null);
	$s->renew();
	
	// Basic authentication information
	$s->write('User.id', $session['UserID']);

    // Write whatever session information you want to share with Cake
    foreach ($_SESSION as $key => $value){
    	$s->write($key, $_SESSION[$key]);
    }
}

function cake_logout() {
	$s = new CakeSession(null);
	$s = new CakeSession(null);
	$s->destroy();
}
*/

?>
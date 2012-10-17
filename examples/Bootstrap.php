<?php

define('DS', DIRECTORY_SEPARATOR);
define('PS', PATH_SEPARATOR);
define('BASE_PATH', dirname(dirname(realpath(__FILE__))));

define('LIBRARY_PATH', BASE_PATH . DS . 'library');

$includePaths = array(
    get_include_path(),
    LIBRARY_PATH,
);
set_include_path(implode(PS, $includePaths));

//die(print_r(get_include_path(), 1));

require_once('Zend/Loader/Autoloader.php');
$autoloader = Zend_Loader_Autoloader::getInstance();
$autoloader->setFallbackAutoloader(true);
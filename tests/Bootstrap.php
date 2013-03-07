<?php
/**
 * PHP Datafeed Library
 *
 * LICENSE
 *
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.opensource.org/licenses/bsd-license.php
 *
 * @category    Dfp
 * @package     UnitTest
 * @subpackage  Bootstrap
 * @copyright   Copyright (c) 2012 PHP Datafeed Library
 * @version     $Id: Bootstrap.php 15 2012-04-04 14:08:43Z mail@henryhayes.co.uk $
 * @since       2012-04-04
 */
/**
 * Bootstrap file for the PHP Datafeed Library.
 *
 * @category    Dfp
 * @package     UnitTest
 * @subpackage  Bootstrap
 * @copyright   Copyright (c) 2012 PHP Datafeed Library
 * @author      Henry Hayes <mail@henryhayes.co.uk>
 * @since       2012-04-04
 */

define('BASE_PATH', dirname(dirname(realpath(__FILE__))));
define('LIBRARY_PATH', BASE_PATH . DIRECTORY_SEPARATOR . 'library');
set_include_path(implode(PATH_SEPARATOR, array(LIBRARY_PATH, get_include_path())));

require_once('Zend/Loader/Autoloader.php');
$autoloader = Zend_Loader_Autoloader::getInstance();
$autoloader->setFallbackAutoloader(true);
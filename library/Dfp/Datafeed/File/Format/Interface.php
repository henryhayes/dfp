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
 * @package     Datafeed
 * @subpackage  File_Format_Interface
 * @copyright   Copyright (c) 2012 PHP Datafeed Library
 * @version     $Id: Interface.php 47 2012-04-18 08:39:38Z t.carnage@gmail.com $
 * @since       2011-12-07
 */
/**
 * Dfp_Datafeed_File_Format_Interface interface.
 *
 * @category    Dfp
 * @package     Datafeed
 * @subpackage  File_Format_Interface
 * @copyright   Copyright (c) 2012 PHP Datafeed Library
 * @author      Chris Riley <chris.riley@imhotek.net>
 * @since       2011-12-07
 */
interface Dfp_Datafeed_File_Format_Interface extends Dfp_Error_Interface, Dfp_Option_Interface
{
    /**
     * Method to perform initialisation of the object, will be called at the end of the constructor
     */
    public function init();

    /**
     * Getter for feed file location
     *
     * @return string
     */
    public function getLocation();

    /**
     * Setter for feed file location
     *
     * @param string $location
     */
    public function setLocation($location);

    /**
     * Getter for Dialect
     *
     * @return string
     */
    public function getDialect();

    /**
     * Setter for Dialect
     *
     * @param string $dialect
     */
    public function setDialectString($dialect);

    /**
     * Setter for Dialect
     *
     * @param Dfp_Datafeed_File_Format_Dialect_Interface $dialect
     */
    public function setDialect(Dfp_Datafeed_File_Format_Dialect_Interface $dialect);

    /**
     * Returns the current dialect namespace.
     *
     * @return string
     */
    public function getDialectNamespace();

    /**
     * Sets the dialect namespace.
     *
     * @param string $dialectNamespace
     */
    public function setDialectNamespace($dialectNamespace);
}
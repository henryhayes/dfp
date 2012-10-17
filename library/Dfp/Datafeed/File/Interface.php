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
 * @subpackage  File_Interface
 * @copyright   Copyright (c) 2012 PHP Datafeed Library
 * @version     $Id: Interface.php 45 2012-04-17 11:21:21Z t.carnage@gmail.com $
 * @since       2011-12-07
 */
/**
 * Dfp_Datafeed_File_Interface interface.
 *
 * @category    Dfp
 * @package     Datafeed
 * @subpackage  File_Interface
 * @copyright   Copyright (c) 2012 PHP Datafeed Library
 * @author      Chris Riley <chris.riley@imhotek.net>
 * @since       2012-04-17
 */
interface Dfp_Datafeed_File_Interface extends Dfp_Error_Interface, Dfp_Option_Interface
{
    /**
     * Setter for format, allows providing the format as a string
     *
     * @param String $format
     */
    public function setFormatString($format);

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
     * @return Dfp_Datafeed_File_Format_Dialect_Interface
     */
    public function getDialect();

    /**
     * Setter for Dialect
     *
     * @param Dfp_Datafeed_File_Format_Dialect_Interface $dialect
     */
    public function setDialect(Dfp_Datafeed_File_Format_Dialect_Interface $dialect);

    /**
     * Setter for Dialect
     *
     * @param String $dialect
     */
    public function setDialectString($dialect);

    /**
     * Returns the format namespace.
     *
     * @return string
     */
    public function getFormatNamespace();

    /**
     * Sets the format namespace.
     *
     * @param string $formatNamespace
     */
    public function setFormatNamespace($formatNamespace);
}
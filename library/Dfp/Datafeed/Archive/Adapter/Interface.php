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
 * @subpackage  Archive_Adapter_Interface
 * @copyright   Copyright (c) 2012 PHP Datafeed Library
 * @version     $Id: Interface.php 82 2012-05-02 07:38:37Z t.carnage@gmail.com $
 * @since       2011-12-09
 */
/**
 * Dfp_Datafeed_Archive_Adapter_Interface class.
 *
 * @category    Dfp
 * @package     Datafeed
 * @subpackage  Archive_Adapter_Interface
 * @copyright   Copyright (c) 2012 PHP Datafeed Library
 * @author      Chris Riley <chris.riley@imhotek.net>
 * @since       2011-12-09
 */

interface Dfp_Datafeed_Archive_Adapter_Interface extends Dfp_Error_Interface, Dfp_Option_Interface
{
    /**
     * Adds a single file to the archive
     *
     * @param string $filename path to the file
     * @param string $localname path to use in the archive if null, will use the filename of the file added
     * @return Dfp_Datafeed_Archive_Adapter_Interface
     */
    public function addFile($filename, $localname=null);

    /**
     * Closes and writes out the archive after adding files to it.
     *
     * @return Dfp_Datafeed_Archive_Adapter_Interface
     */
    public function close();

    /**
     * Extracts the archive to the set extract path.
     *
     * @return Dfp_Datafeed_Archive_Adapter_Interface
     */
    public function extractFiles();

    /**
     * Returns the path of the archive
     *
     * @return Dfp_Datafeed_Archive_Adapter_Interface
     */
    public function getLocation();

    /**
     * Sets the location of the archive file
     *
     * @param string $location
     * @return Dfp_Datafeed_Archive_Adapter_Interface
     */
    public function setLocation($location);

    /**
     * Sets the path to extract files to
     *
     * @param string $path
     * @return Dfp_Datafeed_Archive_Adapter_Interface
     */
    public function setExtractPath($path);

    /**
     * Sets the path to extract files to.
     *
     * @return string
     */
    public function getExtractPath();
}
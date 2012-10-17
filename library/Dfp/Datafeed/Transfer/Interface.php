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
 * @subpackage  Transfer_Interface
 * @copyright   Copyright (c) 2012 PHP Datafeed Library
 * @version     $Id: Interface.php 72 2012-05-01 14:03:54Z t.carnage@gmail.com $
 * @since       2011-12-09
 */
/**
 * Dfp_Datafeed_Transfer_Interface interface.
 *
 * @category    Dfp
 * @package     Datafeed
 * @subpackage  Transfer_Interface
 * @copyright   Copyright (c) 2012 PHP Datafeed Library
 * @author      Chris Riley <chris.riley@imhotek.net>
 * @since       2011-12-09
 */

interface Dfp_Datafeed_Transfer_Interface extends Dfp_Error_Interface, Dfp_Option_Interface
{
    /**
     * Transfers the local file $source to the remote file $destination
     *  
     * @param string $source
     * @param string $destination
     * @return Dfp_Datafeed_Transfer_Interface
     */
    public function sendFile($source, $destination=null);
    
    /**
     * Transfers an array of local files to the array of remote destinations 
     * 
     * @param array $sources
     * @param array $destinations
     * @return Dfp_Datafeed_Transfer_Interface
     */
    public function sendFiles(array $sources, array $destinations=array());
    
    /**
     * Transfers the remote file $source to the local file $destination
     * 
     * @param string $source
     * @param string $destination
     * @return Dfp_Datafeed_Transfer_Interface
     */
    public function retrieveFile($source, $destination=null);
    
    /**
    * Transfers an array of remote files to the array of local destinations
    *
    * @param array $sources
    * @param array $destinations
    * @return Dfp_Datafeed_Transfer_Interface
    */    
    public function retrieveFiles(array $sources, array $destinations=array());
    
    /**
     * Sets the string name of the adapter to use
     * 
     * @param string $adapter
     * @return Dfp_Datafeed_Transfer_Interface
     */
    public function setAdapterString($adapter);
    
    /**
     * Sets the string namespace to use for the adapter
     * 
     * @param string $namespace
     * @return Dfp_Datafeed_Transfer_Interface
     */
    public function setAdapterNamespace($namespace);
    
    /**
     * Gets the namespace of the adapter.
     * 
     * @return string
     */
    public function getAdapterNamespace();
    
    /**
     * Sets the adapter directly.
     * 
     * @param Dfp_Datafeed_Transfer_Adapter_Interface $adapter
     * @return Dfp_Datafeed_Transfer_Interface
     */
    public function setAdapter(Dfp_Datafeed_Transfer_Adapter_Interface $adapter);
    
    /**
     * Gets the adapter.
     * 
     * @return Dfp_Datafeed_Transfer_Adapter_Interface
     */
    public function getAdapter();
}
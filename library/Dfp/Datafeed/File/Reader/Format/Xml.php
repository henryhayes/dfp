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
 * @subpackage  File_Reader_Format_Xml
 * @copyright   Copyright (c) 2012 PHP Datafeed Library
 * @version     $Id: Xml.php 72 2012-05-01 14:03:54Z t.carnage@gmail.com $
 * @since       2011-12-08
 */
/**
 * Dfp_Datafeed_File_Reader_Format_Xml class.
 *
 * @category    Dfp
 * @package     Datafeed
 * @subpackage  File_Reader_Format_Xml
 * @copyright   Copyright (c) 2012 PHP Datafeed Library
 * @author      Chris Riley <chris.riley@imhotek.net>
 * @since       2011-12-08
 */
// @codeCoverageIgnoreStart
//stub for testing.
class Dfp_Datafeed_File_Reader_Format_Xml extends Dfp_Datafeed_File_Reader_Format_Abstract
{
	/**
     * @see Dfp_Datafeed_File_Reader_Format_Interface::init()
     */
    public function init()
    {
        trigger_error('This format hasn\'t been implemented', E_USER_ERROR);
    }
    
    /**
     * Stub method to allow unit testing
     * @return NULL
     */
    public function getXslt()
    {
        return null;
    }
    
    /**
    * Stub method to allow unit testing
    * @return NULL
    */    
    public function setXslt($xslt)
    {
        return $this;
    }
    
    public function getDialect()
    {
        
    }
    
    public function setDialect(Dfp_Datafeed_File_Format_Dialect_Interface $dialect)
    {
        
    }
    
    public function getDialectNamespace()
    {
        
    }
    
    public function setDialectNamespace($dialectNamespace)
    {
        
    }
    
    protected function _loadNextRecord()
    {
        
    }
    
    protected function _resetFeed()
    {
        
    }
}
// @codeCoverageIgnoreEnd
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
 * @subpackage  File_Writer_Format_Xml
 * @copyright   Copyright (c) 2012 PHP Datafeed Library
 * @version     $Id: Xml.php 72 2012-05-01 14:03:54Z t.carnage@gmail.com $
 * @since       2012-01-26
 */
/**
 * Dfp_Datafeed_File_Writer_Format_Xml class.
 *
 * @category    Dfp
 * @package     Datafeed
 * @subpackage  File_Writer_Format_Xml
 * @copyright   Copyright (c) 2012 PHP Datafeed Library
 * @author      Henry Hayes
 * @since       2012-01-26
 */
// @codeCoverageIgnoreStart
//stub to allow unit testing
class Dfp_Datafeed_File_Writer_Format_Xml extends Dfp_Datafeed_File_Writer_Format_Abstract
{
    public function init() 
    {
        
    }
    
    /**
    * @see Dfp_Datafeed_File_Writer_Format_Interface::writeRecord()
    */
    public function writeRecord(array $data)
    {
        //@todo
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
        
}

// @codeCoverageIgnoreEnd
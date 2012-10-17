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
 * @subpackage  File_Writer_Interface
 * @copyright   Copyright (c) 2012 PHP Datafeed Library
 * @version     $Id: Interface.php 72 2012-05-01 14:03:54Z t.carnage@gmail.com $
 * @since       2012-01-26
 */
/**
 * Dfp_Datafeed_File_Writer_Interface class.
 *
 * @category    Dfp
 * @package     Datafeed
 * @subpackage  File_Writer_Interface
 * @copyright   Copyright (c) 2012 PHP Datafeed Library
 * @author      Chris Riley <chris.riley@imhotek.net>
 * @since       2012-04-17
 */
interface Dfp_Datafeed_File_Writer_Interface extends Dfp_Datafeed_File_Interface
{
    /**
     * Getter for format
     *
     * @return Dfp_Datafeed_File_Writer_Format_Interface
     */
    public function getFormat();

    /**
     * Setter for format
     *
     * @param Dfp_Datafeed_File_Writer_Format_Interface $format
     */
    public function setFormat(Dfp_Datafeed_File_Writer_Format_Interface $format);

    /**
     * Getter for Xslt location
     *
     * @throws Dfp_Datafeed_File_Writer_Exception if format type isn't XML.
     * @return string
     */
    public function getXslt();

    /**
     * Setter for Xslt location
     *
     * @throws Dfp_Datafeed_File_Writer_Exception if format type isn't XML.
     * @param string $xslt
     */
    public function setXslt($xslt);
    
    /**
     * Writes a record to the file. Array keys are used for the header, if the dialect specifies a header. 
     * If the dialect specifies header as null, a header row will only be written if the array keys are strings.
     * 
     * @param array $data Array of data to write
     */
    public function writeRecord(array $data);
    
    /**
     * Writes records to the file 
     * @see Dfp_Datafeed_File_Writer_Interface::writeRow
     * 
     * @param array $data Array of arrays of data to write
     */
    public function writeRecords(array $data);
}
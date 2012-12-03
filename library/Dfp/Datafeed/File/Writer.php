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
 * @subpackage  File_Writer
 * @copyright   Copyright (c) 2012 PHP Datafeed Library
 * @version     $Id: Writer.php 72 2012-05-01 14:03:54Z t.carnage@gmail.com $
 * @since       2012-01-26
 */
/**
 * Dfp_Datafeed_File_Writer class.
 *
 * @category    Dfp
 * @package     Datafeed
 * @subpackage  File_Writer
 * @copyright   Copyright (c) 2012 PHP Datafeed Library
 * @author      Chris Riley <chris.riley@imhotek.net>
 * @since       2012-04-17
 */
class Dfp_Datafeed_File_Writer extends Dfp_Datafeed_File_Abstract implements Dfp_Datafeed_File_Writer_Interface
{
    /**
    * Holds an instance of the feed format adapter.
    *
    * @var Dfp_Datafeed_File_Writer_Format_Interface
    */
    protected $_format;
    
    /**
     * Holds the name of the format namespace. Defaults to this namespace.
     *
     * @var string
     */
    protected $_formatNamespace = 'Dfp_Datafeed_File_Writer_Format';    

    /**
    * @see Dfp_Option_Interface::setOptions()
    * @return Dfp_Datafeed_File_Reader
    * @throws Dfp_Datafeed_File_Reader_Exception
    */
    public function setOptions(array $options)
    {
        if (isset($options['format'])) {
            if ($options['format'] instanceof Dfp_Datafeed_File_Writer_Format_Interface) {
                $this->setFormat($options['format']);
            } elseif (is_string($options['format'])) {
                $this->setFormatString($options['format']);
            } else {
                throw new Dfp_Datafeed_File_Writer_Exception('Invalid format specified');
            }
            unset($options['format']);
        }
    
        $this->getFormat()->setOptions($options);
        return $this;
    }    
    
    /**
    * @see Dfp_Datafeed_File_Writer_Interface::getFormat()
    */
    public function getFormat()
    {
        if (!($this->_format instanceof Dfp_Datafeed_File_Writer_Format_Interface)) {
            $this->_loadFormat();
        }
        
        return $this->_format;        
    }
    
    /**
     * @see Dfp_Datafeed_File_Writer_Interface::setFormat()
     */
    public function setFormat(Dfp_Datafeed_File_Writer_Format_Interface $format)
    {
        $this->_format = $format;
        return $this;        
    }
    
    
    /**
     * @see Dfp_Datafeed_File_Writer_Interface::getXslt
     */
    public function getXslt()
    {
        $format = $this->getFormat();
        if (!($format instanceof Dfp_Datafeed_File_Writer_Format_Xml)) {
            throw new Dfp_Datafeed_File_Writer_Exception('getXslt can only be called when the format is XML');
        }
        
        return $format->getXslt();        
    }
    
    /**
     * @see Dfp_Datafeed_File_Writer_Interface::setXslt()
     */
    public function setXslt($xslt)
    {
        $format = $this->getFormat();
        if (!($format instanceof Dfp_Datafeed_File_Writer_Format_Xml)) {
            throw new Dfp_Datafeed_File_Writer_Exception('setXslt can only be called when the format is XML');
        }
        
        $format->setXslt($xslt);
        return $this;        
    }
    
    /**
     * @see Dfp_Datafeed_File_Writer_Interface::writeRecord()
     */
    public function writeRecord(array $data)
    {
    	$data = $this->getRecordFilterer()->filterRecord($data);
    	if (!$this->getRecordValidator()->validateRecord($data)) {
    		$errors = $this->getRecordValidator()->getErrors();
    		foreach ($errors AS $error) {
    			$this->addError(sprintf('Validation error: %s', $error));
    		}
    		return;
    	}
        $this->getFormat()->writeRecord($data);
        return $this;
    }
    
    /**
     * @see Dfp_Datafeed_File_Writer_Interface::writeRecords()
     */
    public function writeRecords(array $data)
    {
        foreach ($data as $datum) {
            $this->writeRecord($datum);
        }
        return $this;
    }
}
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
 * @subpackage  File_Abstract
 * @copyright   Copyright (c) 2012 PHP Datafeed Library
 * @version     $Id: Abstract.php 47 2012-04-18 08:39:38Z t.carnage@gmail.com $
 * @since       2011-12-07
 */
/**
 * Dfp_Datafeed_File_Abstract class.
 *
 * @category    Dfp
 * @package     Datafeed
 * @subpackage  File_Abstract
 * @copyright   Copyright (c) 2012 PHP Datafeed Library
 * @author      Chris Riley <chris.riley@imhotek.net>
 * @since       2012-04-17
 */
class Dfp_Datafeed_File_Abstract
{
    /**
    * @see Dfp_Option_Interface::__construct()
    */
    public function __construct($options = null)
    {
        if ($options instanceof Zend_Config) {
            $this->setConfig($options);
        } elseif (is_array($options)) {
            $this->setOptions($options);
        } elseif (!is_null($options)) {
            throw new Dfp_Datafeed_File_Reader_Exception('Invalid parameter to constructor');
        }
    }
    
    /**
     * @see Dfp_Datafeed_File_Interface::getDialect()
     */
    public function getDialect()
    {
        return $this->getFormat()->getDialect();
    }
    
    /**
     * @see Dfp_Datafeed_File_Interface::setDialect()
     * @return Dfp_Datafeed_File_Reader
     */
    public function setDialect(Dfp_Datafeed_File_Format_Dialect_Interface $dialect)
    {
        $this->getFormat()->setDialect($dialect);
        return $this;
    }
    
    /**
     * @see Dfp_Datafeed_File_Interface::setDialectString()
     * @return Dfp_Datafeed_File_Reader
     */
    public function setDialectString($dialect)
    {
        $this->getFormat()->setDialectString($dialect);
        return $this;
    }
    
    /**
     * Returns the format namespace.
     *
     * @return string
     */
    public function getFormatNamespace()
    {
        return $this->_formatNamespace;
    }
    
    /**
     * Sets the format namespace.
     *
     * @param string $formatNamespace
     */
    public function setFormatNamespace($formatNamespace)
    {
        $this->_formatNamespace = $formatNamespace;
        return $this;
    }
    

    
    /**
     * @see Dfp_Datafeed_File_Interface::setFormatString()
     * @return Dfp_Datafeed_File_Abstract
     */
    public function setFormatString($format)
    {
        $this->_format = $format;
        return $this;
    }
    
    /**
     * @see Dfp_Datafeed_File_Interface::getLocation()
     */
    public function getLocation()
    {
        return $this->getFormat()->getLocation();
    }
    
    /**
     * @see Dfp_Datafeed_File_Interface::setLocation()
     * @return Dfp_Datafeed_File_Abstract
     */
    public function setLocation($location)
    {
        $this->getFormat()->setLocation($location);
        return $this;
    }
    

	/**
     * @see Dfp_Option_Interface::setConfig()
     * @return Dfp_Datafeed_File_Reader
     */
    public function setConfig(Zend_Config $config)
    {
        $this->setOptions($config->toArray());
        return $this;
    }
    
    /**
    * @see Dfp_Error_Interface::addError()
    * @return Dfp_Datafeed_File_Abstract
    */
    public function addError($message)
    {
        $this->getFormat()->addError($message);
        return $this;
    }
    
    /**
     * @see Dfp_Error_Interface::addErrors()
     * @return Dfp_Datafeed_File_Abstract
     */
    public function addErrors(array $messages)
    {
        $this->getFormat()->addErrors($messages);
        return $this;
    }
    
    /**
     * @see Dfp_Error_Interface::getErrors()
     * @return array
     */
    public function getErrors()
    {
        return $this->getFormat()->getErrors();
    }
    
    /**
     * @see Dfp_Error_Interface::hasErrors()
     * @return bool
     */
    public function hasErrors()
    {
        return $this->getFormat()->hasErrors();
    }
    
    /**
     * @see Dfp_Error_Interface::setErrors()
     * @return Dfp_Datafeed_File_Abstract
     */
    public function setErrors(array $messages)
    {
        $this->getFormat()->setErrors($messages);
        return $this;
    }    
    
    protected function _loadFormat()
    {
        if (is_null($this->_format)) {
            $this->_format = 'csv';
        }
        
        $class = $this->getFormatNamespace() . '_';
        $class .= str_replace(' ', '_', ucwords(str_replace('_', ' ', strtolower($this->_format))));
        
        $this->_format = new $class();        
    }
}

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
 * @subpackage  Transfer
 * @copyright   Copyright (c) 2012 PHP Datafeed Library
 * @version     $Id: Transfer.php 71 2012-04-30 14:32:58Z t.carnage@gmail.com $
 * @since       2011-12-09
 */
/**
 * Dfp_Datafeed_Transfer class.
 *
 * @category    Dfp
 * @package     Datafeed
 * @subpackage  Transfer
 * @copyright   Copyright (c) 2012 PHP Datafeed Library
 * @author      Chris Riley <chris.riley@imhotek.net>
 * @since       2011-12-09
 */

class Dfp_Datafeed_Transfer implements Dfp_Datafeed_Transfer_Interface
{
    /**
     * Holds an instance of the adapter 
     * @var Dfp_Datafeed_Transfer_Adapter_Interface
     */
    protected $_adapter;
    
    /**
     * Namespace for adapter
     * @var string
     */
    protected $_adapterNamespace = 'Dfp_Datafeed_Transfer_Adapter';
    
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
            throw new Dfp_Datafeed_Transfer_Exception('Invalid parameter to constructor');
        }
    }
        
    /**
     * @see Dfp_Datafeed_Transfer_Interface::sendFile()
     * @return Dfp_Datafeed_Transfer
     */
    public function sendFile($source, $destination=null)
    {
        $this->getAdapter()->sendFile($source, $destination);
        return $this;
    }
    
    /**
     * @see Dfp_Datafeed_Transfer_Interface::sendFiles()
     * @return Dfp_Datafeed_Transfer
     */
    public function sendFiles(array $sources, array $destinations=array())
    {
        foreach ($sources AS $index => $source) {
            $this->sendFile($source, $destinations[$index]);
        }
        return $this;
    }
    
    /**
     * @see Dfp_Datafeed_Transfer_Interface::retrieveFile()
     * @return Dfp_Datafeed_Transfer
     */
    public function retrieveFile($source, $destination=null)
    {
        $this->getAdapter()->retrieveFile($source, $destination);
        return $this;
    }
    
    /**
     * @see Dfp_Datafeed_Transfer_Interface::retrieveFiles()
     * @return Dfp_Datafeed_Transfer
     */
    public function retrieveFiles(array $sources, array $destinations=array())
    {
        foreach ($sources AS $index => $source) {
            $this->retrieveFile($source, $destinations[$index]);
        }   
        return $this;     
    }
    
    /**
     * @see Dfp_Datafeed_Transfer_Interface::setAdapter()
     * @return Dfp_Datafeed_Transfer
     */
    public function setAdapter(Dfp_Datafeed_Transfer_Adapter_Interface $adapter)
    {
        $this->_adapter = $adapter;
        return $this;
    }

    /**
     * @see Dfp_Datafeed_Transfer_Interface::setAdapterString()
     * @return Dfp_Datafeed_Transfer
     */
    public function setAdapterString($adapter)
    {
        $this->_adapter = $adapter;
        return $this;
    }
    
    /**
     * @see Dfp_Datafeed_Transfer_Interface::setAdapterNamespace()
     * @return Dfp_Datafeed_Transfer
     */
    public function setAdapterNamespace($namespace)
    {
        $this->_adapterNamespace = $namespace;
        return $this;
    }
    
    /**
     * @see Dfp_Datafeed_Transfer_Interface::getAdapterNamespace()
     */
    public function getAdapterNamespace()
    {
        return $this->_adapterNamespace;
    }    
    
   /**
    * @see Dfp_Datafeed_Transfer_Interface::getAdapter()
    */
    public function getAdapter()
    {
        if (!($this->_adapter instanceof Dfp_Datafeed_Transfer_Adapter_Interface)) {
            if (is_null($this->_adapter)) {
                throw new Dfp_Datafeed_Transfer_Exception('Invalid Adapter Specified');
            }
            $class = $this->getAdapterNamespace() . '_' . $this->_adapter;
            
            $this->_adapter = new $class();
        }
        
        return $this->_adapter;
    }
    
    
    /**
     * @see Dfp_Option_Interface::setOptions()
     * @return Dfp_Datafeed_Transfer
     */
    public function setOptions(array $options) 
    {
        if (isset($options['adapter'])) {
            if ($options['adapter'] instanceof Dfp_Datafeed_Transfer_Adapter_Interface) {
                $this->setAdapter($options['adapter']);
            } elseif (is_string($options['adapter'])) {
                $this->setAdapterString($options['adapter']);
            } else {
                throw new Dfp_Datafeed_Transfer_Exception('Invalid adapter specified');
            }
            unset($options['adapter']);
        }
        if (isset($options['adapterNamespace'])) {
            if (is_string($options['adapterNamespace'])) {
                $this->setAdapterNamespace($options['adapterNamespace']);
            } else {
                throw new Dfp_Datafeed_Transfer_Exception('Invalid adapter namespace specified');
            }
            unset($options['adapterNamespace']);
        }        
        
        $this->getAdapter()->setOptions($options);
        
        return $this;
    }
    
    /**
    * @see Dfp_Option_Interface::setConfig()
    * @return Dfp_Datafeed_Transfer
    */
    public function setConfig(Zend_Config $config)
    {
        $this->setOptions($config->toArray());
        return $this;
    }
    
    /**
     * @see Dfp_Error_Interface::addError()
     * @return Dfp_Datafeed_Transfer
     */
    public function addError($message)
    {
        $this->getAdapter()->addError($message);
        return $this;
    }
    
    /**
     * @see Dfp_Error_Interface::addErrors()
     * @return Dfp_Datafeed_Transfer
     */
    public function addErrors(array $messages)
    {
        $this->getAdapter()->addErrors($messages);
        return $this;
    }
    
    /**
     * @see Dfp_Error_Interface::getErrors()
     * @return array
     */
    public function getErrors()
    {
        return $this->getAdapter()->getErrors();
    }
    
    /**
     * @see Dfp_Error_Interface::hasErrors()
     * @return bool
     */
    public function hasErrors()
    {
        return $this->getAdapter()->hasErrors();
    }
    
    /**
     * @see Dfp_Error_Interface::setErrors()
     * @return Dfp_Datafeed_Transfer
     */
    public function setErrors(array $messages)
    {
        $this->getAdapter()->setErrors($messages);
        return $this;
    }
}
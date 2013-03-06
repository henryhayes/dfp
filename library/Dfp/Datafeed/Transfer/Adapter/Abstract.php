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
 * @subpackage  Transfer_Adapter_Abstract
 * @copyright   Copyright (c) 2012 PHP Datafeed Library
 * @version     $Id: Abstract.php 72 2012-05-01 14:03:54Z t.carnage@gmail.com $
 * @since       2012-04-24
 */
/**
 * Dfp_Datafeed_Transfer_Adapter_Abstract class.
 *
 * @category    Dfp
 * @package     Datafeed
 * @subpackage  Transfer_Adapter_Abstract
 * @copyright   Copyright (c) 2012 PHP Datafeed Library
 * @author      Chris Riley <chris.riley@imhotek.net>
 * @since       2012-04-24
 */

abstract class Dfp_Datafeed_Transfer_Adapter_Abstract implements Dfp_Datafeed_Transfer_Adapter_Interface
{
    /**
    * Holds an array of errors for this object.
    *
    * @var array
    */
    protected $_errors = array();
    
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
            throw new Dfp_Datafeed_Transfer_Adapter_Exception('Invalid parameter to constructor');
        }
    }
    
    
    /**
    * @see Dfp_Option_Interface::setConfig()
    * @return Dfp_Datafeed_Transfer_Adapter_Abstract
    */
    public function setConfig(Zend_Config $config)
    {
        return $this->setOptions($config->toArray());
    }
    
    /**
    * @see Dfp_Error_Interface::addError()
    * @return Dfp_Datafeed_Transfer_Adapter_Abstract
    */
    public function addError($message)
    {
        $this->_errors[] = $message;
        return $this;
    }
    
    /**
     * @see Dfp_Error_Interface::addErrors()
     * @return Dfp_Datafeed_Transfer_Adapter_Abstract
     */
    public function addErrors(array $messages)
    {
        foreach ($messages AS $message) {
            $this->addError($message);
        }
        return $this;
    }
    
    /**
     * @see Dfp_Error_Interface::getErrors()
     */
    public function getErrors()
    {
        return $this->_errors;
    }
    
    /**
     * @see Dfp_Error_Interface::hasErrors()
     */
    public function hasErrors()
    {
        return (bool) count($this->_errors);
    }
    
    /**
     * @see Dfp_Error_Interface::setErrors()
     * @return Dfp_Datafeed_Transfer_Adapter_Abstract
     */
    public function setErrors(array $messages)
    {
        $this->_errors = $messages;
        return $this;
    }
    
    /**
     * Factory method for creating an adapter. Valid array keys are as follows:
     * 
     *  fullClassname    The full class name to create
     *  prefix           The first part of the adapter namespace (defaults to Dfp)
     *  namespace        The remainder of the adapter namespace (defaults to Datafeed_Transfer_Adapter)
     *  classname        The classname to create 
     *  phpNamespace     If set to true, the classname generated will use \ as a separator between parts instead of _
     *  options          An array of options to pass into the new class
     *  
     * Fullclassname or classname are required parameters, the class must implement 
     * Dfp_Datafeed_Transfer_Adapter_Interface or an exception will be thrown 
     *  
     * @param array $options
     * @throws Dfp_Datafeed_Transfer_Adapter_Exception
     * @return Dfp_Datafeed_Transfer_Adapter_Interface
     */
    public static function factory(array $options)
    {
    	if (array_key_exists('fullClassname', $options)) {
    		$classname = $options['fullClassname'];
    	} elseif (array_key_exists('classname', $options)) {
	    	$classBits['prefix'] = 'Dfp';
	    	if (array_key_exists('prefix', $options)) {
	    		$classBits['prefix'] = $options['prefix'];
	    	}
	    	
	    	$classBits['namespace'] = 'Datafeed_Transfer_Adapter';
	    	if (array_key_exists('namespace', $options)) {
	    		$classBits['namespace'] = $options['namespace'];
	    	}
	    	
	    	$classBits['classname'] = $options['classname'];
	    	
	    	$separator = '_';
	    	if (array_key_exists('phpNamespace', $options) && $options['phpNamespace']) {
	    		$separator = '\\';
	    	}

	    	$classname = implode($separator, $classBits);
    	} else {
    		throw new Dfp_Datafeed_Transfer_Adapter_Exception(
    				'You must provide either the classname or the full classname'
    		);    		
    	}
    	
    	if (!@class_exists($classname)) {
    		throw new Dfp_Datafeed_Transfer_Adapter_Exception(
    				sprintf('%s was not found.', $classname)
    		);
    	}
    	
    	$class = new $classname();
    	
    	if (!($class instanceof Dfp_Datafeed_Transfer_Adapter_Interface)) {
    		throw new Dfp_Datafeed_Transfer_Adapter_Exception(
    				sprintf('%s does not implement Dfp_Datafeed_Transfer_Adapter_Interface', $classname)
    		);
    	}
    	
    	if (array_key_exists('options', $options)) {
    		$class->setOptions($options['options']);
    	}
    	
    	return $class;    	
    }
}
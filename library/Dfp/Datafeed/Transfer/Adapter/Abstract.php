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
}
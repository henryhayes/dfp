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
 * @subpackage  File_Format_Abstract
 * @copyright   Copyright (c) 2012 PHP Datafeed Library
 * @version     $Id: Abstract.php 121 2012-07-03 21:13:38Z mail@henryhayes.co.uk $
 * @since       2012-04-17
 */
/**
 * Dfp_Datafeed_File_Reader_Format_Abstract class.
 *
 * @category    Dfp
 * @package     Datafeed
 * @subpackage  File_Format_Abstract
 * @copyright   Copyright (c) 2012 PHP Datafeed Library
 * @author      Chris Riley <chris.riley@imhotek.net>
 * @since       2012-04-17
 */

abstract class Dfp_Datafeed_File_Format_Abstract //implements Dfp_Datafeed_File_Reader_Format_Interface
{
    /**
     * Holds a string containing the dialect namespace.
     *
     * @var string
     */
    protected $_dialectNamespace = 'Dfp_Datafeed_File_Format_Csv_Dialect';

    /**
     * File path to the feed.
     *
     * @var string
     */
    protected $_location;

    /**
     * Holds an instance of a dialect.
     *
     * @var mixed
     */
    protected $_dialect;

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
            throw new Dfp_Datafeed_File_Exception('Invalid parameter to constructor');
        }
        $this->init();
    }

	/**
     * @see Dfp_Datafeed_File_Reader_Format_Interface::getLocation()
     */
    public function getLocation()
    {
        return $this->_location;
    }

    /**
     * @see Dfp_Datafeed_File_Reader_Format_Interface::setDialectString()
     */
    public function setDialectString($dialect)
    {
        $this->_dialect = $dialect;
        return $this;
    }

    /**
    * Returns the current dialect namespace.
    *
    * @return string
    */
    public function getDialectNamespace()
    {
        return $this->_dialectNamespace;
    }

    /**
     * Sets the dialect namespace.
     *
     * @param string $dialectNamespace
     */
    public function setDialectNamespace($dialectNamespace)
    {
        $this->_dialectNamespace = $dialectNamespace;
        return $this;
    }

    /**
     * @see Dfp_Datafeed_File_Reader_Format_Interface::setLocation()
     * @return Dfp_Datafeed_File_Reader_Format_Abstract
     */
    public function setLocation($location)
    {
        $this->_location = $location;
        return $this;
    }

	/**
     * @see Dfp_Option_Interface::setConfig()
     * @return Dfp_Datafeed_File_Reader_Format_Abstract
     */
    public function setConfig(Zend_Config $config)
    {
        return $this->setOptions($config->toArray());
    }

    /**
     * Sets options from array.
     *
     * @param array $options
     * @throws Dfp_Datafeed_File_Exception
     * @return Dfp_Datafeed_File_Format_Abstract
     */
    public function setOptions(array $options)
    {
        if (isset($options['dialect'])) {
            if ($options['dialect'] instanceof Dfp_Datafeed_File_Format_Dialect_Interface) {
                $this->setDialect($options['dialect']);
            } elseif (is_string($options['dialect'])) {
                $this->setDialectString($options['dialect']);
            } else {
                throw new Dfp_Datafeed_File_Exception('Invalid dialect specified');
            }
            unset($options['dialect']);
        }

        if (isset($options['location'])) {
            if (is_string($options['location'])) {
                $this->setLocation($options['location']);
            } else {
                throw new Dfp_Datafeed_File_Exception('Invalid location specified');
            }
            unset($options['location']);
        }

        return $this;
    }

	/**
     * @see Dfp_Error_Interface::addError()
     * @return Dfp_Datafeed_File_Reader_Format_Abstract
     */
    public function addError($message)
    {
        $this->_errors[] = $message;
        return $this;
    }

	/**
     * @see Dfp_Error_Interface::addErrors()
     * @return Dfp_Datafeed_File_Reader_Format_Abstract
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
     * @return Dfp_Datafeed_File_Reader_Format_Abstract
     */
    public function setErrors(array $messages)
    {
        $this->_errors = $messages;
        return $this;
    }
}
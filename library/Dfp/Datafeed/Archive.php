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
 * @subpackage  Archive
 * @copyright   Copyright (c) 2012 PHP Datafeed Library
 * @version     $Id: Archive.php 82 2012-05-02 07:38:37Z t.carnage@gmail.com $
 * @since       2011-12-09
 */
/**
 * Dfp_Datafeed_Archive class.
 *
 * @category    Dfp
 * @package     Datafeed
 * @subpackage  Archive
 * @copyright   Copyright (c) 2012 PHP Datafeed Library
 * @author      Chris Riley <chris.riley@imhotek.net>
 * @since       2011-12-09
 */

class Dfp_Datafeed_Archive implements Dfp_Datafeed_Archive_Interface
{
    /**
    * Holds an instance of the adapter
    * @var Dfp_Datafeed_Archive_Adapter_Interface
    */
    protected $_adapter;

    /**
     * Namespace for adapter
     * @var string
     */
    protected $_adapterNamespace = 'Dfp_Datafeed_Archive_Adapter';

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
            throw new Dfp_Datafeed_Archive_Exception('Invalid parameter to constructor');
        }
    }

    public function close()
    {
        $this->getAdapter()->close();
        return $this;
    }

    /**
     * @see Dfp_Datafeed_Archive_Interface::addFile()
     */
    public function addFile($filename, $localname=null)
    {
        $this->getAdapter()->addFile($filename, $localname);
        return $this;
    }

    /**
     * @see Dfp_Datafeed_Archive_Interface::addFiles()
     */
    public function addFiles(array $filenames, array $localnames = array())
    {
        foreach ($filenames AS $index => $filename) {
            if (array_key_exists($index, $localnames)) {
                $this->addFile($filename, $localnames[$index]);
            } else {
                $this->addFile($filename);
            }
        }
    }

    /**
     * @see Dfp_Datafeed_Archive_Interface::extractFiles()
     */
    public function extractFiles()
    {
        $this->getAdapter()->extractFiles();
        return $this;
    }

    /**
     * @see Dfp_Datafeed_Archive_Interface::getLocation()
     */
    public function getLocation()
    {
        return $this->getAdapter()->getLocation();
    }

    /**
     * @see Dfp_Datafeed_Archive_Interface::setLocation()
     */
    public function setLocation($location)
    {
        $this->getAdapter()->setLocation($location);
        return $this;
    }

    /**
     * @see Dfp_Datafeed_Archive_Interface::setExtractPath()
     */
    public function setExtractPath($path)
    {
        $this->getAdapter()->setExtractPath($path);
        return $this;
    }

    /**
     * @see Dfp_Datafeed_Archive_Interface::getExtractPath()
     */
    public function getExtractPath()
    {
        return $this->getAdapter()->getExtractPath();
    }

    /**
    * @see Dfp_Datafeed_Archive_Interface::setAdapter()
    * @return Dfp_Datafeed_Archive
    */
    public function setAdapter(Dfp_Datafeed_Archive_Adapter_Interface $adapter)
    {
        $this->_adapter = $adapter;
        return $this;
    }

    /**
     * @see Dfp_Datafeed_Archive_Interface::setAdapterString()
     * @return Dfp_Datafeed_Archive
     */
    public function setAdapterString($adapter)
    {
        $this->_adapter = $adapter;
        return $this;
    }

    /**
     * @see Dfp_Datafeed_Archive_Interface::setAdapterNamespace()
     * @return Dfp_Datafeed_Archive
     */
    public function setAdapterNamespace($namespace)
    {
        $this->_adapterNamespace = $namespace;
        return $this;
    }

    /**
     * @see Dfp_Datafeed_Archive_Interface::getAdapterNamespace()
     */
    public function getAdapterNamespace()
    {
        return $this->_adapterNamespace;
    }

    /**
     * @see Dfp_Datafeed_Archive_Interface::getAdapter()
     */
    public function getAdapter()
    {
        if (!($this->_adapter instanceof Dfp_Datafeed_Archive_Adapter_Interface)) {
            if (is_null($this->_adapter)) {
                throw new Dfp_Datafeed_Archive_Exception('Invalid Adapter Specified');
            }
            $class = $this->getAdapterNamespace() . '_' . $this->_adapter;

            $this->_adapter = new $class();
        }

        return $this->_adapter;
    }


    /**
     * @see Dfp_Option_Interface::setOptions()
     * @return Dfp_Datafeed_Archive
     */
    public function setOptions(array $options)
    {
        if (isset($options['adapter'])) {
            if ($options['adapter'] instanceof Dfp_Datafeed_Archive_Adapter_Interface) {
                $this->setAdapter($options['adapter']);
            } elseif (is_string($options['adapter'])) {
                $this->setAdapterString($options['adapter']);
            } else {
                throw new Dfp_Datafeed_Archive_Exception('Invalid adapter specified');
            }
            unset($options['adapter']);
        }
        if (isset($options['adapterNamespace'])) {
            if (is_string($options['adapterNamespace'])) {
                $this->setAdapterNamespace($options['adapterNamespace']);
            } else {
                throw new Dfp_Datafeed_Archive_Exception('Invalid adapter namespace specified');
            }
            unset($options['adapterNamespace']);
        }

        $this->getAdapter()->setOptions($options);

        return $this;
    }

    /**
     * @see Dfp_Option_Interface::setConfig()
     * @return Dfp_Datafeed_Archive
     */
    public function setConfig(Zend_Config $config)
    {
        $this->setOptions($config->toArray());
        return $this;
    }

    /**
     * @see Dfp_Error_Interface::addError()
     * @return Dfp_Datafeed_Archive
     */
    public function addError($message)
    {
        $this->getAdapter()->addError($message);
        return $this;
    }

    /**
     * @see Dfp_Error_Interface::addErrors()
     * @return Dfp_Datafeed_Archive
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
     * @return Dfp_Datafeed_Archive
     */
    public function setErrors(array $messages)
    {
        $this->getAdapter()->setErrors($messages);
        return $this;
    }
}
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
 * @subpackage  Transfer_Adapter_Stream
 * @copyright   Copyright (c) 2012 PHP Datafeed Library
 * @version     $Id$
 * @since       2011-12-09
 */
/**
 * Dfp_Datafeed_Transfer_Adapter_Stream class.
 *
 * @category    Dfp
 * @package     Datafeed
 * @subpackage  Transfer_Adapter_Stream
 * @copyright   Copyright (c) 2012 PHP Datafeed Library
 * @author      Chris Riley <chris.riley@imhotek.net>
 * @since       2011-12-09
 */

class Dfp_Datafeed_Transfer_Adapter_Stream extends Dfp_Datafeed_Transfer_Adapter_Abstract
{
    /**
     * Holds the schema type to connect with (should be ftp or ftps)
     *
     * @var string
     */
    protected $_schema = 'http';

    /**
     * Holds the hostname of the server to connect to
     *
     * @var string
     */
    protected $_host;

    /**
     * Holds the port to connect to the server on
     *
     * @var string
     */
    protected $_port;

    /**
     * Holds the username to connect to the server with
     *
     * @var string
     */
    protected $_username;

    /**
     * Holds the password to use when connecting to the server
     *
     * @var string
     */
    protected $_password;

    /**
     * Holds the base path to use for locating files locally. Files will be sent from and saved to this location.
     *
     * @var string
     */
    protected $_basePath;

    /**
     * Getter for schema
     *
     * @return string
     */
    public function getSchema()
    {
        return $this->_schema;
    }

    /**
     * Getter for host
     *
     * @return string
     */
    public function getHost()
    {
        return $this->_host;
    }

    /**
     * Getter for port
     *
     * @return string
     */
    public function getPort()
    {
        return $this->_port;
    }

    /**
     * Getter for username
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->_username;
    }

    /**
     * Getter for password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->_password;
    }

    /**
     * Getter for base path
     *
     * @return string
     */
    public function getBasePath()
    {
        return $this->_basePath;
    }

    /**
     * Setter for schema
     *
     * @param string $schema
     * @return Dfp_Datafeed_Transfer_Adapter_Stream
     */
    public function setSchema($schema)
    {
        $this->_schema = $schema;
        return $this;
    }

    /**
     * Setter for host
     *
     * @param string $host
     * @return Dfp_Datafeed_Transfer_Adapter_Stream
     */
    public function setHost($host)
    {
        $this->_host = $host;
        return $this;
    }

    /**
     * Setter for port
     *
     * @param string $port
     * @return Dfp_Datafeed_Transfer_Adapter_Stream
     */
    public function setPort($port)
    {
        $this->_port = $port;
        return $this;
    }

    /**
     * Setter for username
     *
     * @param string $username
     * @return Dfp_Datafeed_Transfer_Adapter_Stream
     */
    public function setUsername($username)
    {
        $this->_username = $username;
        return $this;
    }

    /**
     * Setter for password
     *
     * @param string $password
     * @return Dfp_Datafeed_Transfer_Adapter_Stream
     */
    public function setPassword($password)
    {
        $this->_password = $password;
        return $this;
    }

    /**
     * Setter for base path
     *
     * @param string $basePath
     * @return Dfp_Datafeed_Transfer_Adapter_Stream
     */
    public function setBasePath($basePath)
    {
        $basePath  = rtrim($basePath, '/');
        $basePath  = rtrim($basePath, '\\');
        //$basePath .= DIRECTORY_SEPARATOR;

        $this->_basePath = $basePath;
        return $this;
    }

    /**
     * Setter for options, used to configure the object by providing a set of options as an array
     * Valid values for the array depend on the object.
     *
     * @param array $options
     */
    public function setOptions(array $options)
    {
        $options = array_change_key_case($options);

        if (isset($options['schema'])) {
            if (is_string($options['schema'])) {
                $this->setSchema($options['schema']);
            } else {
                throw new Dfp_Datafeed_Transfer_Exception('Invalid Schema');
            }
        }
        if (isset($options['host'])) {
            if (is_string($options['host'])) {
                $this->setHost($options['host']);
            } else {
                throw new Dfp_Datafeed_Transfer_Exception('Invalid Host');
            }
        }
        if (isset($options['port'])) {
            if (is_numeric($options['port'])) {
                $this->setPort($options['port']);
            } else {
                throw new Dfp_Datafeed_Transfer_Exception('Invalid Port');
            }
        }
        if (isset($options['username'])) {
            if (is_string($options['username'])) {
                $this->setUsername($options['username']);
            } else {
                throw new Dfp_Datafeed_Transfer_Exception('Invalid Username');
            }
        }
        if (isset($options['password'])) {
            if (is_string($options['password'])) {
                $this->setPassword($options['password']);
            } else {
                throw new Dfp_Datafeed_Transfer_Exception('Invalid Password');
            }
        }
        if (isset($options['basepath'])) {
            if (is_string($options['basepath'])) {
                $this->setBasePath($options['basepath']);
            } else {
                throw new Dfp_Datafeed_Transfer_Exception('Invalid Basepath');
            }
        }
    }

    /**
     * Copys a file from source to destination
     *
     * @param string $sourceUri
     * @param string $destUri
     */
    protected function _copyFile($sourceUri, $destUri)
    {
        $sourceH = fopen($sourceUri, 'rb');
        $destH = fopen($destUri, 'wb');

        stream_copy_to_stream($sourceH, $destH);
    }

    /**
     * @see Dfp_Datafeed_Transfer_Adapter_Interface::sendFile()
     */
    public function sendFile($source, $destination=null)
    {
        $sourceUri = $this->getBasePath() . DIRECTORY_SEPARATOR . $source;

        if (is_null($destination)) {
            $destination = $source;
        }
        $destUri = $this->getUri() . '/' . $destination;

        $this->_copyFile($sourceUri, $destUri);

    }

    /**
     * @see Dfp_Datafeed_Transfer_Adapter_Interface::retrieveFile()
     */
    public function retrieveFile($source, $destination=null)
    {
        $sourceUri = $this->getUri() . '/' . $source;

        if (is_null($destination)) {
            $destination = $source;
        }
        $destUri = $this->getBasePath() . DIRECTORY_SEPARATOR . $destination;

        $this->_copyFile($sourceUri, $destUri);
    }

    /**
     * Constructs a remote uri based on the adapter settings.
     *
     * @throws Dfp_Datafeed_Transfer_Exception
     * @return string
     */
    public function getUri()
    {
        $uri = $this->getSchema() . '://';

        if (!is_null($this->getUsername())) {
            $uri .= $this->getUsername();
            if (!is_null($this->getPassword())) {
                $uri .= ':' . $this->getPassword();
            }
            $uri .= '@';
        }

        if (is_null($this->getHost())) {
            throw new Dfp_Datafeed_Transfer_Exception('Host must be set');
        }

        $uri .= $this->getHost();

        if (!is_null($this->getPort())) {
            $uri .= ':' . $this->getPort();
        }

        //$uri .= '/';

        return $uri;
    }
}
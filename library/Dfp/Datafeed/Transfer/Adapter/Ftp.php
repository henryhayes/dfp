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
 * @subpackage  Transfer_Adapter_Ftp
 * @copyright   Copyright (c) 2012 PHP Datafeed Library
 * @version     $Id: Ftp.php 149 2012-07-25 11:59:54Z craig@autoweb.co.uk $
 * @since       2012-05-22
 */
/**
 * Dfp_Datafeed_Transfer_Adapter_Ftp class.
 *
 * @category    Dfp
 * @package     Datafeed
 * @subpackage  Transfer_Adapter_Ftp
 * @copyright   Copyright (c) 2012 PHP Datafeed Library
 * @author      Chris Riley <chris.riley@imhotek.net>
 * @since       2012-05-22
 */

class Dfp_Datafeed_Transfer_Adapter_Ftp extends Dfp_Datafeed_Transfer_Adapter_Abstract
{
    /**
     * Contains the ftp connection resource.
     *
     * @var string
     */
    protected $_ftp;

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
    protected $_port = '21';

    /**
     * Contains the timeout time in seconds.
     *
     * @var string
     */
    protected $_timeout = 90;

    /**
     * Holds the username to connect to the server with. The username 'anonymous' is default.
     *
     * @var string
     */
    protected $_username = 'anonymous';

    /**
     * Holds the password to use when connecting to the server. By convention an
     * email address for the user should be used as the password.
     *
     * @var string
     */
    protected $_password = '';

    /**
     * Holds the base path to use for locating files locally. Files will be sent from and saved to this location.
     *
     * @var string
     */
    protected $_basePath;

    /**
     * Contains the message from the last error caught
     *
     * @var string
     */
    protected $_error;

    /**
     * @see Dfp_Option_Interface::__construct()
     */
    public function __construct($options = null)
    {
        parent::__construct($options);
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
     * Getter for timeout
     *
     * @return string
     */
    public function getTimeout()
    {
        return $this->_timeout;
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
     * Setter for host
     *
     * @param string $host
     * @return Dfp_Datafeed_Transfer_Adapter_Ftp
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
     * @return Dfp_Datafeed_Transfer_Adapter_Ftp
     */
    public function setPort($port)
    {
        $this->_port = $port;
        return $this;
    }

    /**
     * Setter for timeout
     *
     * @param int $timeout
     * @param boolean True if system is under test
     * @return Dfp_Datafeed_Transfer_Adapter_Ftp
     */
    public function setTimeout($timeout, $test = false)
    {
        $this->_timeout = $timeout;
        if ($test == false && is_resource($this->_ftp)) {
            ftp_set_option($this->_ftp, FTP_TIMEOUT_SEC, $this->getTimeout());
        }
        return $this;
    }

    /**
     * Setter for username
     *
     * @param string $username
     * @return Dfp_Datafeed_Transfer_Adapter_Ftp
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
     * @return Dfp_Datafeed_Transfer_Adapter_Ftp
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
     * @return Dfp_Datafeed_Transfer_Adapter_Ftp
     */
    public function setBasePath($basePath)
    {
        $basePath  = rtrim($basePath, '/');
        $basePath  = rtrim($basePath, '\\');

        $this->_basePath = $basePath;
        return $this;
    }

    /**
     * Sets if passive (true) or active (false) should be used.
     *
     * @param boolean $passive
     * @param boolean True if system is under test
     * @return Dfp_Datafeed_Transfer_Adapter_Ftp
     */
    public function setPassive($passive, $test = false)
    {
        if (false === $test) {
            @ftp_pasv($this->_getFtp(), (bool) $passive);
        }
        return $this;
    }

    /**
     * Setter for options, used to configure the object by providing a set of options as an array
     * Valid values for the array depend on the object.
     *
     * @param array $options Options
     * @throws Dfp_Datafeed_Transfer_Exception
     */
    public function setOptions(array $options)
    {
        $options = array_change_key_case($options);

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
        if (isset($options['passive'])) {
            if (is_bool($options['passive'])) {
                $this->setPassive($options['basepath']);
            } else {
                throw new Dfp_Datafeed_Transfer_Exception('Invalid set passive flag, must be boolean.');
            }
        }
        if (isset($options['timeout'])) {
            if (is_numeric($options['timeout'])) {
                $this->setTimeout($options['timeout']);
            } else {
                throw new Dfp_Datafeed_Transfer_Exception('Invalid timeout flag, must be a number.');
            }
        }
    }

    /**
     * @see Dfp_Datafeed_Transfer_Adapter_Interface::sendFile()
     */
    public function sendFile($source, $destination=null)
    {
        // Source from local file system
        $sourceUri = $this->getBasePath() . DIRECTORY_SEPARATOR . $source;

        if (is_null($destination)) {
            $destination = $source;
        }

        /**
         * Here we change the error handler to catch the error message thrown by ftp_put
         */
        set_error_handler(array($this, 'errorHandler'), E_WARNING);
        $put = ftp_put($this->_getFtp(), $destination, $sourceUri, FTP_BINARY);
        restore_error_handler();

        if (!$put) {
            //$error = array_pop($this->getErrors());
            $message = sprintf('File PUT failed for file from %s to %s', $sourceUri, $destination);
            $this->addError($message);
            throw new Dfp_Datafeed_Transfer_Adapter_Exception($message);
        }

        return $this;
    }

    /**
     * @see Dfp_Datafeed_Transfer_Adapter_Interface::retrieveFile()
     */
    public function retrieveFile($source, $destination=null)
    {
        if (is_null($destination)) {
            $destination = $source;
        }
        // Destination to local file system
        $destUri = $this->getBasePath() . DIRECTORY_SEPARATOR . $destination;

        /**
         * Here we change the error handler to catch the error message thrown by ftp_put
         */
        set_error_handler(array($this, 'errorHandler'), E_WARNING);
        $get = ftp_get($this->_getFtp(), $destUri, $source, FTP_BINARY);
        restore_error_handler();

        if (!$get) {
            //$error = array_pop($this->getErrors());
            $message = sprintf('File GET failed for file from %s to %s', $source, $destUri);
            $this->addError($message);
            throw new Dfp_Datafeed_Transfer_Adapter_Exception($message);
        }
    }

    /**
     * Get's an FTP connection.
     *
     * @throws Dfp_Datafeed_Transfer_Adapter_Exception
     */
    protected function _getFtp()
    {
        if (!is_resource($this->_ftp)) {

            //set_error_handler(array($this, 'errorHandler'), E_WARNING);
            $this->_ftp = ftp_connect($this->getHost(), $this->getPort(), $this->getTimeout());
            //restore_error_handler();

            if (!$this->_ftp) {
                $message = sprintf('Conection failed to %s', $this->getHost());
                $this->addError($message);
                throw new Dfp_Datafeed_Transfer_Adapter_Exception($message);
            }

            set_error_handler(array($this, 'errorHandler'), E_WARNING);
            $login = ftp_login($this->_ftp, $this->getUsername(), $this->getPassword());
            restore_error_handler();

            if (!$login) {
                $message = sprintf(
                    'Login failed to %s @ %s Port: %s, Using password: %s',
                    $this->getUsername(), $this->getHost(), $this->getPort(),
                    (('' != $this->getPassword()) ? 'Yes' : 'No')
                );
                $this->addError($message);
                throw new Dfp_Datafeed_Transfer_Adapter_Exception($message);
            }
        }

        return $this->_ftp;
    }

    /**
     * Catches and records the error.
     *
     * @param string $errno
     * @param string $errstr
     * @param string $errfile
     * @param string $errline
     */
    public function errorHandler($errno, $errstr)
    {
        $errstr = trim($errstr);
        if (strstr($errstr, ':')) {
            $errstr = explode(':', $errstr);
            array_shift($errstr);
            $errstr = trim(implode('', $errstr));
        }
        $this->addError($errstr);
        return true;
    }
}
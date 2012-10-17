<?php
/**
 * Dfp_Option_Interface file.
 *
 * @category    Dfp
 * @package     Option
 * @copyright   Copyright (c) 2012 PHP Datafeed Library
 * @version     $Id: Interface.php 3 2012-01-26 12:23:31Z mail@henryhayes.co.uk $
 * @since       2011-12-08
 */
/**
 * Dfp_Option_Interface interface.
 *
 * @category    Dfp
 * @package     Option
 * @copyright   Copyright (c) 2012 PHP Datafeed Library
 * @author      Chris Riley <chris.riley@imhotek.net>
 * @since       2011-12-08
 */
interface Dfp_Option_Interface
{
    /**
     * Constructs the object, takes either an array of options, an instance of zend config or null
     *
     * @param array|Zend_Config $options
     */
    public function __construct($options = null);

    /**
     * Setter for options, used to configure the object by providing a set of options as an array
     * Valid values for the array depend on the object.
     *
     * @param array $options
     */
    public function setOptions(array $options);

    /**
     * Setter for options using a Zend_Config instance.
     *
     * @see Dfp_Option_Interface::setOptions
     * @param Zend_Config $config
     */
    public function setConfig(Zend_Config $config);
}

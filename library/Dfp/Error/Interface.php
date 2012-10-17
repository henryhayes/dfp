<?php
/**
 * Dfp_Error_Interface file.
 *
 * @category    Dfp
 * @package     Error
 * @copyright   Copyright (c) 2012 PHP Datafeed Library
 * @version     $Id: Interface.php 3 2012-01-26 12:23:31Z mail@henryhayes.co.uk $
 * @since       2011-12-07
 */
/**
 * Dfp_Error_Interface interface.
 *
 * @category    Dfp
 * @package     Error
 * @copyright   Copyright (c) 2012 PHP Datafeed Library
 * @author      Chris Riley <chris.riley@imhotek.net>
 * @since       2011-12-07
 */
interface Dfp_Error_Interface
{
    /**
     * Returns true if errors are present false otherwise.
     *
     * @return bool
     */
    public function hasErrors();

    /**
     * Returns an array of all the errors
     *
     * @return array
     */
    public function getErrors();

    /**
     * Adds an error to the object
     *
     * @param string $message
     */
    public function addError($message);

    /**
     * Adds multiple errors to the object
     *
     * @param array $messages
     */
    public function addErrors(array $messages);

    /**
     * Sets an array of errors on the object, overwriting any existing errors
     *
     * @param array $messages
     */
    public function setErrors(array $messages);
}

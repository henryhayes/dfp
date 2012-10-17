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
 * @subpackage  File_Format_Csv_Dialect_Dynamic
 * @copyright   Copyright (c) 2011 autoweb.co.uk
 * @version     $Id: Dynamic.php 117 2012-06-18 16:08:36Z t.carnage@gmail.com $
 * @since       2011-12-13
 */
/**
 * Dfp_Datafeed_File_Format_Csv_Dialect_Dynamic class.
 *
 * @category    Dfp
 * @package     Datafeed
 * @subpackage  File_Format_Csv_Dialect_Dynamic
 * @copyright   Copyright (c) 2011 Autoweb.co.uk
 * @author      Chris Riley <chris.riley@autoweb.co.uk>
 * @since       2011-12-13
 */

class Dfp_Datafeed_File_Format_Csv_Dialect_Dynamic
    extends Dfp_Datafeed_File_Format_Csv_Dialect_Abstract implements Dfp_Option_Interface
{
	/**
     * @see Dfp_Datafeed_File_Reader_Format_Csv_Dialect_Abstract::__construct()
     * @param array $options
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
     * @see Dfp_Option_Interface::setConfig()
     * @return Dfp_Datafeed_File_Reader_Format_Csv_Dialect_Dynamic
     */
    public function setConfig(Zend_Config $config)
    {
        return $this->setOptions($config->toArray());
    }

	/**
     * @see Dfp_Option_Interface::setOptions()
     * @return Dfp_Datafeed_File_Reader_Format_Csv_Dialect_Dynamic
     */
    public function setOptions(array $options = null)
    {
        if (!is_null($options)) {
            foreach ($options as $key => $value) {
                $normalized = ucfirst($key);
                $method = 'set' . $normalized;
                if (method_exists($this, $method)) {

                    $this->$method($value);
                }
            }
        }

        return $this;
    }

	/**
     * Sets the delimiter character.
     *
     * @param string $delimiter
     * @return Dfp_Datafeed_File_Reader_Format_Csv_Dialect_Dynamic
     */
    public function setDelimiter($delimiter)
    {
        $this->_delimiter = $delimiter;
        return $this;
    }

	/**
     * Sets the quote character.
     *
     * @param string $quote
     * @return Dfp_Datafeed_File_Reader_Format_Csv_Dialect_Dynamic
     */
    public function setQuote($quote)
    {
        $this->_quote = $quote;
    }

	/**
     * Sets the quote character.
     *
     * @param string $escape
     * @return Dfp_Datafeed_File_Reader_Format_Csv_Dialect_Dynamic
     */
    public function setEscape($escape)
    {
        $this->_escape = $escape;
        return $this;
    }

	/**
     * Sets the quote character.
     *
     * @param bool $hasHeader
     * @return Dfp_Datafeed_File_Reader_Format_Csv_Dialect_Dynamic
     */
    public function setHasHeader($hasHeader)
    {
        $this->_hasHeader = (bool)$hasHeader;
        return $this;
    }

    /**
     * Sets the line return characters
     * @param string $return
     * @return Dfp_Datafeed_File_Format_Csv_Dialect_Dynamic
     */
    public function setLineReturn($return)
    {
        $this->_lineReturn = $return;
        return $this;
    }
}
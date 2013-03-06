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
 * @subpackage  File_Format_Csv_Dialect_Abstract
 * @copyright   Copyright (c) 2012 PHP Datafeed Library
 * @version     $Id: Abstract.php 117 2012-06-18 16:08:36Z t.carnage@gmail.com $
 * @since       2011-12-13
 */
/**
 * Dfp_Datafeed_File_Format_Csv_Dialect_Abstract class.
 *
 * @category    Dfp
 * @package     Datafeed
 * @subpackage  File_Format_Csv_Dialect_Abstract
 * @copyright   Copyright (c) 2012 PHP Datafeed Library
 * @author      Chris Riley <chris.riley@imhotek.net>
 * @since       2011-12-13
 */

abstract class Dfp_Datafeed_File_Format_Csv_Dialect_Abstract
	extends Dfp_Datafeed_File_Format_Dialect_Abstract
    implements Dfp_Datafeed_File_Format_Csv_Dialect_Interface
{
    /**
     * The delimiter character
     *
     * @var string
     */
    protected $_delimiter = ',';

    /**
     * The quote character
     *
     * @var string
     */
    protected $_quote = '"';

    /**
     * The escape character
     *
     * @var string
     */
    protected $_escape = '\\';

    /**
     * True if this dialect has a header, false if not. Important: NULL if not known.
     *
     * @var bool
     */
    protected $_hasHeader = null;

	/**
     * @see Dfp_Datafeed_File_Reader_Format_Csv_Dialect_Interface::getDelimiter()
     */
    public function getDelimiter()
    {
        return $this->_delimiter;
    }

	/**
     * @see Dfp_Datafeed_File_Reader_Format_Csv_Dialect_Interface::getQuote()
     */
    public function getQuote()
    {
         return $this->_quote;
    }

	/**
     * @see Dfp_Datafeed_File_Reader_Format_Csv_Dialect_Interface::getEscape()
     */
    public function getEscape()
    {
        return $this->_escape;
    }

	/**
     * @see Dfp_Datafeed_File_Reader_Format_Csv_Dialect_Interface::hasHeader()
     */
    public function hasHeader()
    {
        return $this->_hasHeader;
    }
}
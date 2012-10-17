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
 * @subpackage  File_Format_Csv_Dialect_Interface
 * @copyright   Copyright (c) 2012 PHP Datafeed Library
 * @version     $Id: Interface.php 117 2012-06-18 16:08:36Z t.carnage@gmail.com $
 * @since       2011-12-12
 */
/**
 * Dfp_Datafeed_File_Format_Csv_Dialect_Interface interface.
 *
 * @category    Dfp
 * @package     Datafeed
 * @subpackage  File_Format_Csv_Dialect_Interface
 * @copyright   Copyright (c) 2012 PHP Datafeed Library
 * @author      Chris Riley <chris.riley@imhotek.net>
 * @since       2011-12-12
 */
interface Dfp_Datafeed_File_Format_Csv_Dialect_Interface
    extends Dfp_Datafeed_File_Format_Dialect_Interface
{
    /**
     * returns true if this dialect contains a header row.
     *
     * @return bool
     */
    public function hasHeader();

    /**
     * Returns the delimiter character for this dialect.
     *
     * @return string
     */
    public function getDelimiter();

    /**
     * Returns the quote character for this dialect.
     *
     * @return string
     */
    public function getQuote();

    /**
     * Returns the escape character for this dialect.
     *
     * @return string
     */
    public function getEscape();

    /**
     * Returns the line return character
     *
     * @return string
     */
    public function getLineReturn();
}
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
 * @subpackage  File_Format_Csv_Dialect_Tabs
 * @copyright   Copyright (c) 2012 PHP Datafeed Library
 * @version     $Id: Tabs.php 72 2012-05-01 14:03:54Z t.carnage@gmail.com $
 * @since       2011-12-13
 */
/**
 * Dfp_Datafeed_File_Format_Csv_Dialect_Tabs class.
 *
 * @category    Dfp
 * @package     Datafeed
 * @subpackage  File_Format_Csv_Dialect_Tabs
 * @copyright   Copyright (c) 2012 PHP Datafeed Library
 * @author      Chris Riley <chris.riley@imhotek.net>
 * @since       2011-12-13
 */

class Dfp_Datafeed_File_Format_Csv_Dialect_Tabs
    extends Dfp_Datafeed_File_Format_Csv_Dialect_Abstract
{
    /**
     * The delimiter character
     *
     * @var string
     */
    protected $_delimiter = "\t";

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
     * True if this dialect has a header.
     *
     * @var bool
     */
    protected $_hasHeader = null;
}
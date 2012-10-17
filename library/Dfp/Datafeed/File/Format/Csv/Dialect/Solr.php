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
 * @subpackage  File_Format_Csv_Dialect_Solr
 * @copyright   Copyright (c) 2012 PHP Datafeed Library
 * @version     $Id: Solr.php 139 2012-07-09 21:55:47Z mail@henryhayes.co.uk $
 * @since       2012-07-09
 */
/**
 * Dfp_Datafeed_File_Format_Csv_Dialect_Solr class.
 *
 * This csv dialect is specifically written for Apache Solr. With this, you can write an Apache Solr
 * compatible CSV file that should natively import with no problems.
 *
 * @link http://wiki.apache.org/solr/UpdateCSV
 * @link http://wiki.apache.org/solr/CSVResponseWriter
 *
 * @category    Dfp
 * @package     Datafeed
 * @subpackage  File_Format_Csv_Dialect_Solr
 * @copyright   Copyright (c) 2012 PHP Datafeed Library
 * @author      Henry Hayes <mail@henryhayes.co.uk>
 * @since       2012-07-09
 */

class Dfp_Datafeed_File_Format_Csv_Dialect_Solr
    extends Dfp_Datafeed_File_Format_Csv_Dialect_Abstract
{
    /**
     * The delimiter character, Solr: csv.separator
     *
     * @var string
     */
    protected $_delimiter = ",";

    /**
     * The quote character, Solr: csv.encapsulator
     *
     * @var string
     */
    protected $_quote = '"';

    /**
     * The escape character, Solr: csv.escape
     *
     * @var string
     */
    protected $_escape = '';

    /**
     * The line return character, Solr: csv.newline
     *
     * @var string
     */
    protected $_lineReturn = "\n";

    /**
     * True if this dialect has a header, Solr: csv.header
     *
     * @var bool
     */
    protected $_hasHeader = true;
}
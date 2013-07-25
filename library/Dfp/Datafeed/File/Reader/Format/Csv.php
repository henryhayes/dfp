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
 * @subpackage  File_Reader_Format_Csv
 * @copyright   Copyright (c) 2012 PHP Datafeed Library
 * @version     $Id: Csv.php 123 2012-07-04 10:13:23Z mail@henryhayes.co.uk $
 * @since       2011-12-08
 */
/**
 * Dfp_Datafeed_File_Reader_Format_Csv class.
 *
 * @category    Dfp
 * @package     Datafeed
 * @subpackage  File_Reader_Format_Csv
 * @copyright   Copyright (c) 2012 PHP Datafeed Library
 * @author      Chris Riley <chris.riley@imhotek.net>
 * @since       2011-12-08
 */
class Dfp_Datafeed_File_Reader_Format_Csv extends Dfp_Datafeed_File_Reader_Format_Abstract
{
    /**
     * Holds an instance of the classes dialect
     *
     * @var Dfp_Datafeed_File_Format_Csv_Dialect_Interface
     */
    protected $_dialect;

    /**
     * Holds a count of the number of records read.
     *
     * @var integer
     */
    protected $_records;

    /**
     * Holds an instance of a csv file reader class
     *
     * @var Dfp_Datafeed_File_Reader_Format_Csv_File
     */
    protected $_file;

    /**
     * Holds an array containing the csv file header
     *
     * @var array
     */
    protected $_header;

    /**
     * @see Dfp_Datafeed_File_Reader_Format_Interface::init()
     */
    public function init()
    {
        null;
    }

    /**
     * Getter for file
     *
     * @return Dfp_Datafeed_File_Reader_Format_Csv_File
     */
    public function getFile()
    {
        if (!($this->_file instanceof Dfp_Datafeed_File_Reader_Format_Csv_File)) {
            $this->_file = new Dfp_Datafeed_File_Reader_Format_Csv_File();

        }

        return $this->_file;
    }

    /**
     * Setter for file
     *
     * @param Dfp_Datafeed_File_Reader_Format_Csv_File $file
     * @return Dfp_Datafeed_File_Reader_Format_Csv
     */
    public function setFile(Dfp_Datafeed_File_Reader_Format_Csv_File $file)
    {
        $this->_file = $file;
        return $this;
    }

    /**
     * @see Dfp_Datafeed_File_Reader_Format_Interface::getDialect()
     * @return Dfp_Datafeed_File_Format_Csv_Dialect_Interface
     */
    public function getDialect()
    {
        if (!($this->_dialect instanceof Dfp_Datafeed_File_Format_Csv_Dialect_Interface)) {
            if (is_null($this->_dialect)) {
                $this->_dialect = 'dynamic';
            }

            $class = $this->getDialectNamespace() . '_';
            $class .= str_replace(' ', '_', ucwords(str_replace('_', ' ', strtolower($this->_dialect))));

            $this->_dialect = new $class();

            if ($this->_dialect instanceof Dfp_Datafeed_File_Format_Csv_Dialect_Dynamic) {
                $this->_resetFeed();
                $params = $this->getFile()->detectDialect();
                $this->_dialect->setOptions($params);
            }

            $this->getFile()->setDialect($this->_dialect);
        }
        return $this->_dialect;
    }

    /**
     * @see Dfp_Datafeed_File_Reader_Format_Interface::setDialect()
     * @param Dfp_Datafeed_File_Format_Csv_Dialect_Interface $dialect
     * @return Dfp_Datafeed_File_Reader_Format_Csv
     */
    public function setDialect(Dfp_Datafeed_File_Format_Dialect_Interface $dialect)
    {
        $this->_dialect = $dialect;
        return $this;
    }

    /**
     * @see Dfp_Datafeed_File_Reader_Format_Abstract::_loadNextRecord()
     */
    protected function _loadNextRecord()
    {
        //ensure that the file object has a valid dialect to read the file with.
        if (!($this->getFile()->getDialect() instanceof Dfp_Datafeed_File_Format_Dialect_Interface)) {
            $this->getFile()->setDialect($this->getDialect());
        }

        if (!is_array($this->_header)) {
            $this->_setupHeader();
        }

        $record = $this->getFile()->getRecord();

        if ($record === false && $this->getFile()->isEof()) {
            $this->_currentRecord = null;
            return;
        }

        $this->_records++;

        if ($record === false) {
            $this->addError('Error on line: ' . $this->_records);
            $this->_loadNextRecord();
            return;
        } elseif (count($record) == 1 && is_null($record[0])) {
            $this->addError('Empty row on line: ' . $this->_records);
            $this->_loadNextRecord();
            return;
        } elseif (count($this->_header) != count($record)) {
            $this->addError('Header row and record mismatch on line: ' . $this->_records);
            $this->_loadNextRecord();
            return;
        }

        $this->_currentRecord = array_combine($this->_header, $record);
    }

    protected function _setupHeader()
    {
        if (is_null($this->getDialect()->hasHeader())) {
            $this->_header = $this->getFile()->detectHeader();
        } elseif (true == $this->getDialect()->hasHeader()) {
            $this->_header = $this->getFile()->getRecord();
        } else {
            $this->_header = $this->getFile()->generateHeader();
        }
    }

    /**
     * @see Dfp_Datafeed_File_Reader_Format_Abstract::_resetFeed()
     */
    protected function _resetFeed()
    {
        $this->getFile()->open($this->getLocation());
    }

}
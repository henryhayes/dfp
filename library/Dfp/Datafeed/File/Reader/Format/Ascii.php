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
 * @subpackage  File_Reader_Format_Ascii
 * @copyright   Copyright (c) 2012 PHP Datafeed Library
 * @version     $Id: Ascii.php 146 2012-07-20 10:41:15Z t.carnage@gmail.com $
 * @since       2012-07-03
 */
/**
 * Dfp_Datafeed_File_Reader_Format_Ascii class.
 *
 * @category    Dfp
 * @package     Datafeed
 * @subpackage  File_Reader_Format_Ascii
 * @copyright   Copyright (c) 2012 PHP Datafeed Library
 * @author      Henry Hayes <mail@henryhayes.co.uk>
 * @since       2012-07-03
 */
class Dfp_Datafeed_File_Reader_Format_Ascii extends Dfp_Datafeed_File_Reader_Format_Abstract
{
    /**
     * Contains a count of current record.
     *
     * @var resource
     */
    protected $_record = 0;

    /**
     * Contains a resource
     *
     * @var resource
     */
    protected $_fp;

    /**
     * Holds a string containing the dialect namespace.
     *
     * @var string
     */
    protected $_dialectNamespace = 'Dfp_Datafeed_File_Format_Ascii_Dialect';

    /**
     * Holds the unpack format
     *
     * @var string
     */
    protected $_unpackformat;

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
     * @return resource
     */
    public function getFp()
    {
        $filename = $this->getLocation();

        if (!is_resource($this->_fp)) {
            $this->_fp = @fopen($filename, 'r');
        }

        if (!is_resource($this->_fp)) {
            throw new Dfp_Datafeed_File_Reader_Exception("The file '{$filename}' could not be opened");
        }

        return $this->_fp;
    }

    /**
     * Getter for file
     *
     * @return string | bool false on eof.
     */
    public function getFgets()
    {
        $record = fgets($this->getFp(), 8192);
        $this->_record++;

        return $record;
    }

    /**
     * Returns an object of type Dfp_Datafeed_File_Format_Ascii_Dialect_Interface
     * by default returns Dfp_Datafeed_File_Format_Ascii_Dialect_Positional
     *
     * @see Dfp_Datafeed_File_Reader_Format_Interface::getDialect()
     * @return Dfp_Datafeed_File_Format_Ascii_Dialect_Positional
     */
    public function getDialect()
    {
        if (!($this->_dialect instanceof Dfp_Datafeed_File_Format_Ascii_Dialect_Interface)) {
            if (is_null($this->_dialect)) {
                $this->_dialect = 'Positional';
            }

            $class = $this->getDialectNamespace() . '_';
            $class .= str_replace(' ', '_', ucwords(str_replace('_', ' ', strtolower($this->_dialect))));

            $this->_dialect = new $class();

            $this->setDialect($this->_dialect);
        }
        return $this->_dialect;
    }

    /**
     *
     * @param Dfp_Datafeed_File_Format_Ascii_Dialect_Interface $dialect
     * @return Dfp_Datafeed_File_Reader_Format_Ascii Fluent Interface
     */
    public function setDialect(Dfp_Datafeed_File_Format_Dialect_Interface $dialect)
    {
        $this->_dialect = $dialect;
        return $this;
    }

    /**
     * Returns the format for use with fscanf.
     *
     * @return string
     */
    protected function _getUnpackFormat()
    {
        if (is_null($this->_unpackformat)) {
            $config = $this->getDialect()->getPositionalInfo();
            $offsets = array();
            $i = 0;
            foreach ($config as $field => $seek) {
                $offsets[$i]['offset'] = $seek['offset'];
                $offsets[$i]['length'] = $seek['length'];
                $offsets[$i]['name'] = $field;
                $i++;
            }

            $format = '';
            for ($i=0; $i<count($offsets); $i++) {
                $nextoffset = isset($offsets[$i+1]) ? $offsets[$i+1]['offset'] : null;
                $name = $offsets[$i]['name'];
                $chars = $offsets[$i]['length'];
                if (is_null($chars)) {
                    $format .= 'a*' . $name . '/';
                } else {
                    $format .= 'a' . $chars . $name . '/';
                    if (!is_null($nextoffset)) {
                        if ($offsets[$i]['offset'] + $offsets[$i]['length'] < $nextoffset) {
                            $dropChars = $nextoffset - ($offsets[$i]['offset'] + $offsets[$i]['length']);
                            $format .= 'a' . $dropChars . '/';
                        }
                    } else {
                        $format .= 'a*/';
                    }
                }
            }

            $this->_unpackformat = rtrim($format, '/');
        }

        //error_log($format);

        return $this->_unpackformat;
    }

    /**
     * Returns an array of the field names.
     *
     * @return array
     */
    protected function _getFieldNames()
    {
        $config = $this->getDialect()->getPositionalInfo();

        return array_keys($config);
    }

    /**
     * Loads the next record from the current file.
     */
    protected function _loadNextRecord()
    {
        $row = $this->getFgets();

        // Skip rows?
        $skipRows = $this->getDialect()->getSkipLines();
        if ($this->key() == 0 && $skipRows > 0) {
            for ($r = 0; $r<count($skipRows); $r++) {
                $row = $this->getFgets();
            }
        }

        //$row = trim($row);
        if (!$row) {
            $this->_currentRecord = false;
            return;
        }

        $array = @unpack($this->_getUnpackFormat(), $row);
        // Was the row invalid?
        if (false === $array) {
            $this->addError(sprintf('Line %1$s is incorrect', $this->_record));
            return $this->_loadNextRecord();
        }

        unset($array[1]); //remove the dropped characters from the record
        $this->_currentRecord = array_map('trim', $array);
    }

    /**
     * Resets the feed to the first record.
     */
    protected function _resetFeed()
    {
        fseek($this->getFp(), 0);
        $this->_record = 0;
    }
}
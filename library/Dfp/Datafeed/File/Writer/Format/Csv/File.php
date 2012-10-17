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
 * @subpackage  File_Reader_Format_Csv_File
 * @copyright   Copyright (c) 2012 PHP Datafeed Library
 * @version     $Id$
 * @since       2011-12-08
 */
/**
 * Dfp_Datafeed_File_Reader_Format_Csv_File class.
 *
 * @category    Dfp
 * @package     Datafeed
 * @subpackage  File_Reader_Format_Csv_File
 * @copyright   Copyright (c) 2012 PHP Datafeed Library
 * @author      Chris Riley <chris.riley@imhotek.net>
 * @since       2011-12-08
 */

//use case:
/*
File->open(location);
if(need to get format)
file->detectDialect(); (uses file->getRaw())
file->setDialect();
file->getRecord();
*/

class Dfp_Datafeed_File_Writer_Format_Csv_File
{
    /**
     * Holds a file pointer to the file we are processing
     *
     * @var resource
     */
    protected $_filePointer;

    /**
     * Holds an instance of the classes dialect
     *
     * @var Dfp_Datafeed_File_Reader_Format_Csv_Dialect_Interface
     */
    protected $_dialect;

    /**
     * @return Dfp_Datafeed_File_Reader_Format_Csv_Dialect_Interface
     */
    public function getDialect()
    {
        return $this->_dialect;
    }

	/**
     * @param Dfp_Datafeed_File_Reader_Format_Csv_Dialect_Interface $dialect
     * @return Dfp_Datafeed_File_Reader_Format_Csv_File
     */
    public function setDialect(Dfp_Datafeed_File_Format_Dialect_Interface $dialect)
    {
        $this->_dialect = $dialect;
        return $this;
    }

    /**
     * Opens the file for reading
     *
     * @param string $location
     * @throws Dfp_Datafeed_File_Reader_Exception
     */
    public function open($location)
    {
        if (is_resource($this->_filePointer)) {
            fclose($this->_filePointer);
        }

        $this->_filePointer = @fopen($location, 'w+b');

        if (!is_resource($this->_filePointer)) {
            throw new Dfp_Datafeed_File_Writer_Exception('Unable to open feed');
        }
    }


    /**
     * Returns true if the files has been opened already.
     * @return boolean
     */
    public function isOpen()
    {
        return is_resource($this->_filePointer);
    }

    public function writeRecord(array $data)
    {
        if (!$this->isOpen()) {
            throw new Dfp_Datafeed_File_Writer_Exception('The file is not open');
        }

        if (is_null($this->getDialect())) {
            throw new Dfp_Datafeed_File_Writer_Exception('The dialect is invalid');
        }

        $escapedData = array_map(array($this, '_quoteField'), $data);
        $line = implode($this->getDialect()->getDelimiter(), $escapedData);
        fwrite($this->_filePointer, $line);
        fwrite($this->_filePointer, $this->getDialect()->getLineReturn());
    }


    /**
     * Takes a single field escapes characters if needed and encloses it in quotes
     * @param string $datum
     * @return string
     */
    protected function _quoteField($datum)
    {
        $escape = $this->getDialect()->getEscape();
        $quote = $this->getDialect()->getQuote();

        if ($escape != '') {
            if ($escape == $quote) {
                $datum = str_replace($quote, $escape . $quote, $datum);
            } else {
                $datum = str_replace($escape, $escape . $escape, $datum);
                $datum = str_replace($quote, $escape . $quote, $datum);
            }
        }
        return $quote . $datum . $quote;
    }

}
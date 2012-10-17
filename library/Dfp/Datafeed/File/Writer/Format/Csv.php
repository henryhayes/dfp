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
 * @subpackage  File_Writer_Format_Csv
 * @copyright   Copyright (c) 2012 PHP Datafeed Library
 * @version     $Id: Csv.php 100 2012-05-17 12:21:30Z t.carnage@gmail.com $
 * @since       2012-01-26
 */
/**
 * Dfp_Datafeed_File_Writer_Format_Csv class.
 *
 * @category    Dfp
 * @package     Datafeed
 * @subpackage  File_Writer_Format_Csv
 * @copyright   Copyright (c) 2012 PHP Datafeed Library
 * @author      Chris Riley <chris.riley@imhotek.net>
 * @since       2012-04-18
 */
class Dfp_Datafeed_File_Writer_Format_Csv extends Dfp_Datafeed_File_Writer_Format_Abstract
{
    protected $_dataWritten = false;

    protected $_file;

    public function init()
    {

    }

    /**
    * Getter for file
    *
    * @return Dfp_Datafeed_File_Writer_Format_Csv_File
    */
    public function getFile()
    {
        if (!($this->_file instanceof Dfp_Datafeed_File_Writer_Format_Csv_File)) {
            $this->_file = new Dfp_Datafeed_File_Writer_Format_Csv_File();

        }

        return $this->_file;
    }

    /**
     * Setter for file
     *
     * @param Dfp_Datafeed_File_Writer_Format_Csv_File $file
     * @return Dfp_Datafeed_File_Writer_Format_Csv
     */
    public function setFile(Dfp_Datafeed_File_Writer_Format_Csv_File $file)
    {
        $this->_file = $file;
        return $this;
    }

    /**
    * @see Dfp_Datafeed_File_Format_Interface::getDialect()
    * @return Dfp_Datafeed_File_Format_Csv_Dialect_Interface
    */
    public function getDialect()
    {
        if (!($this->_dialect instanceof Dfp_Datafeed_File_Format_Csv_Dialect_Interface)) {
            if (is_null($this->_dialect)) {
                throw new Dfp_Datafeed_File_Writer_Exception('Invalid Dialect');
            }

            $class = $this->getDialectNamespace() . '_';
            $class .= str_replace(' ', '_', ucwords(str_replace('_', ' ', strtolower($this->_dialect))));

            $this->_dialect = new $class();

            $this->getFile()->setDialect($this->_dialect);
        }
        return $this->_dialect;
    }

    /**
     * @see Dfp_Datafeed_File_Format_Interface::setDialect()
     * @param Dfp_Datafeed_File_Format_Csv_Dialect_Interface $dialect
     */
    public function setDialect(Dfp_Datafeed_File_Format_Dialect_Interface $dialect)
    {
        $this->_dialect = $dialect;
        return $this;
    }

    /**
     * @see Dfp_Datafeed_File_Writer_Format_Interface::writeRecord()
     */
    public function writeRecord(array $data)
    {
        if (!($this->getFile()->getDialect() instanceof Dfp_Datafeed_File_Format_Dialect_Interface)) {
            $this->getFile()->setDialect($this->getDialect());
        }

        if (!$this->_dataWritten) {
            $this->getFile()->open($this->getLocation());
            $header = array_keys($data);
            if (is_null($this->getDialect()->hasHeader())) {
                $write = false;
                foreach ($header AS $item) {
                    if (!is_numeric($item)) {
                        $write = true;
                    }
                }

                if ($write) {
                    $this->getFile()->writeRecord($header);
                }
            } elseif (true == $this->getDialect()->hasHeader()) {
                $this->getFile()->writeRecord($header);
            }
        }

        $this->getFile()->writeRecord(array_values($data));
        $this->_dataWritten = true;
    }
}
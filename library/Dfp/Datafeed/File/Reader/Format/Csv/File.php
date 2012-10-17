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
 * @version     $Id: File.php 72 2012-05-01 14:03:54Z t.carnage@gmail.com $
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

class Dfp_Datafeed_File_Reader_Format_Csv_File
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
     * Get's next csv record.
     *
     * @TODO throw a suitable exception if dialect isn't valid.
     * @return array
     */
    public function getRecord()
    {
        if (!$this->isOpen()) {
            throw new Dfp_Datafeed_File_Reader_Exception('The file is not open');
        }

        if (is_null($this->getDialect())) {
            throw new Dfp_Datafeed_File_Reader_Exception('The dialect is invalid');
        }

        $csv = fgetcsv(
            $this->_filePointer,
            0,
            $this->getDialect()->getDelimiter(),
            $this->getDialect()->getQuote(),
            $this->getDialect()->getEscape()
        );

        return $csv;
    }

    /**
     * Get's data from open file.
     *
     * @return string
     */
    public function getRaw()
    {
        if (!$this->isOpen()) {
            throw new Dfp_Datafeed_File_Reader_Exception('The file is not open');
        }

        $data = fread($this->_filePointer, 8192);

        // @codeCoverageIgnoreStart
        // This is only likely to occur if the file is deleted between it being opened and it being read.
        if (FALSE === $data) {
            throw new Dfp_Datafeed_File_Reader_Exception('An error occurred reading the file');
        }
        // @codeCoverageIgnoreEnd

        return $data;
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

        $this->_filePointer = @fopen($location, 'r');

        if (!is_resource($this->_filePointer)) {
            throw new Dfp_Datafeed_File_Reader_Exception('Unable to open feed');
        }
    }

    /**
     * Returns true if the files has been opened already.
     * @return boolean
     */
    public function isEof()
    {
        return feof($this->_filePointer);
    }

    /**
     * Returns true if the files has been opened already.
     * @return boolean
     */
    public function isOpen()
    {
        return is_resource($this->_filePointer);
    }

    /**
     * Detects if the file has a header, if it contains one returns it
     * otherwise it generates a dynamic header based on the length of the first row
     * in the file.
     *
     * @param integer $testRows
     * @return array
     */
    public function detectHeader($testRows = 5)
    {
        //first row could be a header. Find out.

        $header = $this->getRecord();
        $headerOffset = ftell($this->_filePointer);
        $isAHeader = false;

        //really really cool algorithm to decide if this is a header row.

        $headerNumbers = array_map('is_numeric', $header);
        $headerLength = array_sum(array_map('strlen', $header));
        $votes = 0;

        for ($i=0; $i<$testRows; $i++) {
            $rows[$i] = $this->getRecord();
            if (!is_array($rows[$i])) {
                throw new Dfp_Datafeed_File_Reader_Exception('Insufficient rows to detect header');
            }

            $numberTest[$i] = array_map('is_numeric', $rows[$i]);
            //test if there are numerics in the row and not in the header.
            if (in_array(true, $numberTest[$i]) && $numberTest[$i] === $headerNumbers) {
                $votes--;
            } elseif ($numberTest[$i] !== $headerNumbers) {
                $votes++;
            }

            $lengthTest[$i] = array_sum(array_map('strlen', $rows[$i]));
        }

        //calculate average row length and std deviation.
        $lengthAvg = array_sum($lengthTest) / $testRows;
        $deviationSum = 0;

        for ($i=0; $i<$testRows; $i++) {
            $deviationSum += pow($lengthTest[$i]-$lengthAvg, 2);
        }

        $std = pow($deviationSum / $lengthAvg, 0.5);

        if (abs($headerLength - $lengthAvg) > 2 * $std) {
            $votes += ($testRows * 0.8); //bias the string length test as its not as accurate.
        } elseif (abs($headerLength - $lengthAvg) < $std) {
            $votes -= ($testRows * 0.8);
        }

        if ($votes > 0) {
            $isAHeader = true;
            if (method_exists($this->getDialect(), 'setHasHeader')) {
                $this->getDialect()->setHasHeader(true);
            }
        }

        //reset file after we've messed around with it and setup header.
        if ($isAHeader) {
            fseek($this->_filePointer, $headerOffset, SEEK_SET);
        } else {
            fseek($this->_filePointer, 0, SEEK_SET);
            $header = $this->generateHeader();
        }

        return $header;
    }

    /**
     * Detects the dialect used in the file.
     * Returns an array with the delimiter quote and escape chars in, or an empty array in the event of
     * being unable to detect the dialect.
     *
     * @return array
     */
    public function detectDialect()
    {
        $data = $this->getRaw();

        $newlineRegex = '\n|\r|\r\n|\n\r';
        $regexArray = array(
            //searches for <delimiter><optional space><quotechar><text><quotechar><delimiter> eg ,".*?",
        	'#(?P<delim>[^\w\n\r"\'])(?P<space> ?)(?P<quote>["\']).*?(?P=quote)(?P=delim)#',
            //searches for <quote><text><quote><delimiter> at the start of a line eg ".*?",
            '#(?:^|'.$newlineRegex.')(?P<quote>["\']).*?(?P=quote)(?P<delim>[^\w\n"\'])(?P<space> ?)#',
            //searches for <delimiter><quote><text><quote> at the end of a line eg ,".*?"
            '#(?P<delim>[^\w\n"\'])(?P<space> ?)(?P<quote>["\']).*?(?P=quote)(?:$|'.$newlineRegex.')#',
            //searches for <quote><text><quote> as the only thing on a line eg ".*?"
            '#(?:^|'.$newlineRegex.')(?P<quote>["\']).*?(?P=quote)(?:$|'.$newlineRegex.')#'
        );

        $matches = array();
        foreach ($regexArray AS $pattern) {
            if (preg_match($pattern, $data)) {
                preg_match_all($pattern, $data, $matches);
                break;
            }
        }

        if (isset($matches['quote'])) {
            //find most common quote char
            $quote = $this->_mostCommon($matches['quote']);

            if (isset($matches['delim'])) {
                $delimiter = $this->_mostCommon($matches['delim']);
            } else {
                $delimiter = ''; //no delimiter (single column)
            }
            fseek($this->_filePointer, 0);
            return array('quote'=>$quote,'delimiter'=>$delimiter);
        }

        //If there were no quotes in the file we need an alternative method of finding the delimiter
        $newlineRegex = '\n';
        $data = str_replace("\r", '', $data);
        $lines = preg_split('#'.$newlineRegex.'#', $data);
        while (count($lines) < 10 && !$this->isEof()) {
            $data .= $this->getRaw();
            $data = str_replace("\r", '', $data);
            $lines = preg_split('#'.$newlineRegex.'#', $data);
        }

        if (count($lines) > 1) {
            array_pop($lines); //remove the last line as its probably incomplete.
        }

        $linesTest = array_shift(array_chunk($lines, 10));
        $mostCommon = array();
        foreach ($linesTest AS $line) {
            preg_match_all('#(?P<delim>[,;:~\t])#', $line, $matches);
            $mostCommon[] = $this->_mostCommon($matches['delim']);
        }

        $delimiter = $this->_mostCommon($mostCommon);
        foreach ($linesTest AS $line) {
            $counts[] = substr_count($line, $delimiter);
        }

        $freqs = array_count_values($counts);
        arsort($freqs, SORT_NUMERIC);
        if (0.7*count($linesTest) <= array_shift($freqs)) {
            fseek($this->_filePointer, 0);
            return array('quote'=>'"','delimiter'=>$delimiter);
        }


        throw new Dfp_Datafeed_File_Reader_Exception('Could not determine file format');
    }

    /**
     * returns the most common value from an array
     *
     * @param array $array
     * @return mixed
     */
    protected function _mostCommon(array $array)
    {
        //echo 'Before: '; var_dump($array);

        $freq = @array_count_values($array);
        arsort($freq, SORT_NUMERIC);
        $freq = array_flip($freq);
        $ret = array_shift($freq);

        //echo 'After: ';var_dump($ret);

        return $ret;
    }

    /**
     * Reads a row from the file and determines its length, then uses this to generate a dynamic header row.
     *
     * @return array
     */
    public function generateHeader()
    {
        $offset = ftell($this->_filePointer);
        $header = range(0, count($this->getRecord()));
        fseek($this->_filePointer, $offset, SEEK_SET);

        // We pop the last element as it's probably the
        array_pop($header);

        foreach ($header as $k => $v) {
            $header[$k] = (string)$v;
        }
        return $header;
    }
}
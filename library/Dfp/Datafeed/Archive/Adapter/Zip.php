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
 * @subpackage  Archive_Adapter_Zip
 * @copyright   Copyright (c) 2012 PHP Datafeed Library
 * @version     $Id: Zip.php 132 2012-07-05 16:10:14Z mail@henryhayes.co.uk $
 * @since       2011-12-09
 */
/**
 * Dfp_Datafeed_Archive_Adapter_Zip class.
 *
 * @category    Dfp
 * @package     Datafeed
 * @subpackage  Archive_Adapter_Zip
 * @copyright   Copyright (c) 2012 PHP Datafeed Library
 * @author      Chris Riley <chris.riley@imhotek.net>
 * @since       2011-12-09
 */

class Dfp_Datafeed_Archive_Adapter_Zip extends Dfp_Datafeed_Archive_Adapter_Abstract
{
    /**
     * Zip Archive we are working with
     * @var ZipArchive
     */
    protected $_zip;

    /**
     * Contains an array of all files added to the zip archive.
     *
     * @var array
     */
    protected $_files = array();

    /**
     * Gets a zip archive object
     *
     * @throws Dfp_Datafeed_Archive_Adapter_Exception
     * @return ZipArchive
     */
    public function getZip()
    {
        if (!($this->_zip instanceof ZipArchive)) {
            $this->_zip = new ZipArchive();
        }

        return $this->_zip;
    }

    /**
     * Setter for zip archive class.
     *
     * @param ZipArchive $zip
     * @return Dfp_Datafeed_Archive_Adapter_Zip
     */
    public function setZip(ZipArchive $zip)
    {
        $this->_zip = $zip;
        return $this;
    }

    /**
     * @see Dfp_Option_Interface::setOptions()
     */
    public function setOptions(array $options)
    {
        if (isset($options['zip'])) {
            if ($options['zip'] instanceof ZipArchive) {
                $this->setZip($options['zip']);
            } else {
                throw new Dfp_Datafeed_Archive_Exception('Invalid zip archive specified');
            }
            unset($options['zip']);
        }

        parent::setOptions($options);

        return $this;
    }

    /**
     * @see Dfp_Datafeed_Archive_Adapter_Interface::addFile()
     */
    public function addFile($filename, $localname=null)
    {
        if (is_null($localname)) {
            $tmp = str_replace(array('/','\\'), DIRECTORY_SEPARATOR, $filename);
            $tmp = explode(DIRECTORY_SEPARATOR, $tmp);
            $localname = array_pop($tmp);
        }

        $this->_files[] = array('filename'=>$filename, 'localname'=>$localname);
        return $this;
    }

    /**
     * @see Dfp_Datafeed_Archive_Adapter_Interface::close()
     */
    public function close()
    {
        if (is_null($this->getLocation())) {
            throw new Dfp_Datafeed_Archive_Adapter_Exception('No location set');
        }

        $result = $this->getZip()->open($this->getLocation(), ZIPARCHIVE::CREATE|ZIPARCHIVE::OVERWRITE);

        if ($result !== True) {
            throw new Dfp_Datafeed_Archive_Adapter_Exception('Unable to open file');
        }

        foreach (array_chunk($this->_files, 1000) AS $chunk) {
            $this->_addFiles($chunk);
        }

        $this->getZip()->close();

        return $this;
    }

    /**
     * Adds files in chunks to the zip file. As a single failure in a file can cause the entire archive to be empty,
     * this method checks for an error and readds any files that failed in smaller and smaller chunks until the file
     * which caused the error is identified, this file is then logged and ignored allowing the rest of the filse to be
     * added correctly
     *
     * @param array $files
     */
    protected function _addFiles(array $files)
    {
        $addedFiles = array();
        foreach ($files AS $data) {
            if (is_readable($data['filename'])) {
                $this->getZip()->addFile($data['filename'], $data['localname']);
                $addedFiles[] = $data;
            } else {
                $this->addError('Unable to read file: '. $data['filename']);
            }
        }

        if (count($addedFiles) < 1) {
            return;
        }

        $files = $addedFiles;
        unset($addedFiles);

        $result = $this->getZip()->close();
        $this->getZip()->open($this->getLocation(), ZIPARCHIVE::CREATE);

        if ($result === false) {
            if (count($files) > 1) {
                $limit = pow(10, floor(log10(count($files))) - 1); //force $limit to be a power of 10
                $limit = max($limit, 1);
                foreach (array_chunk($files, $limit) AS $data) {
                    $this->_addFiles($data);
                }
            } else {
                $this->addError('Unable to add file: '. $files[0]['filename']); //files should only have one element
            }
        }
    }

    /**
     * @see Dfp_Datafeed_Archive_Adapter_Interface::extractFiles()
     */
    public function extractFiles()
    {
        if (is_null($this->getLocation())) {
            throw new Dfp_Datafeed_Archive_Adapter_Exception('No location set');
        }

        if (is_null($this->getExtractPath())) {
            throw new Dfp_Datafeed_Archive_Adapter_Exception('No extract path set');
        }

        $result = $this->getZip()->open($this->getLocation());

        if ($result !== True) {
            throw new Dfp_Datafeed_Archive_Adapter_Exception('Unable to open file');
        }

        $this->getZip()->extractTo($this->getExtractPath());

    }
}
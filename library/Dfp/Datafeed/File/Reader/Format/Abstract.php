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
 * @subpackage  File_Reader_Format_Abstract
 * @copyright   Copyright (c) 2012 PHP Datafeed Library
 * @version     $Id: Abstract.php 73 2012-05-01 14:05:35Z t.carnage@gmail.com $
 * @since       2011-12-08
 */
/**
 * Dfp_Datafeed_File_Reader_Format_Abstract class.
 *
 * @category    Dfp
 * @package     Datafeed
 * @subpackage  File_Reader_Format_Abstract
 * @copyright   Copyright (c) 2012 PHP Datafeed Library
 * @author      Chris Riley <chris.riley@imhotek.net>
 * @since       2011-12-08
 */

abstract class Dfp_Datafeed_File_Reader_Format_Abstract extends Dfp_Datafeed_File_Format_Abstract
    implements Dfp_Datafeed_File_Reader_Format_Interface
{
    /**
     * Holds an instance of a dialect.
     *
     * @var mixed
     */
    protected $_dialect;

    /**
     * Holds the current position into the feed.
     *
     * @var int
     */
    protected $_position = 0;

    /**
     * Holds the current record from the feed.
     *
     * @var array
     */
    protected $_currentRecord;

	/**
     * @see Iterator::rewind()
     */
    public function rewind()
    {
        $this->_resetFeed();
        $this->_position = 0;
        $this->next(); //load first record
    }

	/**
     * @see Iterator::next()
     */
    public function next()
    {
        $this->_loadNextRecord();
        $this->_position++;
    }

	/**
     * @see Iterator::valid()
     */
    public function valid()
    {
        return (bool) $this->_currentRecord;
    }

	/**
     * @see Iterator::current()
     */
    public function current()
    {
        return $this->_currentRecord;
    }

	/**
     * @see Iterator::key()
     */
    public function key()
    {
        return $this->_position;
    }

    /**
     * Loads the next record from the current file.
     */
    abstract protected function _loadNextRecord();

    /**
     * Resets the feed to the first record.
     */
    abstract protected function _resetFeed();
}
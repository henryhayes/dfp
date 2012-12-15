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
 * @subpackage  File_Format_Ascii_Dialect_Abstract
 * @copyright   Copyright (c) 2012 PHP Datafeed Library
 * @version     $Id: Abstract.php 129 2012-07-04 15:44:34Z mail@henryhayes.co.uk $
 * @since       2012-07-03
 */
/**
 * Dfp_Datafeed_File_Format_Ascii_Dialect_Abstract class.
 *
 * @category    Dfp
 * @package     Datafeed
 * @subpackage  File_Format_Ascii_Dialect_Abstract
 * @copyright   Copyright (c) 2012 PHP Datafeed Library
 * @author      Henry Hayes <mail@henryhayes.co.uk>
 * @since       2012-07-03
 */

abstract class Dfp_Datafeed_File_Format_Ascii_Dialect_Abstract
	extends Dfp_Datafeed_File_Format_Dialect_Abstract
    implements Dfp_Datafeed_File_Format_Ascii_Dialect_Interface
{
    /**
     * Contains the amount of lines to skip.
     *
     * @var int
     */
    protected $_skipLines = 0;

    /**
     * Sets the amount of lines to skip.
     *
     * @param int $skipLines
     */
    public function setSkipLines($skipLines)
    {
        return $this->_skipLines = $skipLines;
    }

    /**
     * Sets the amount of lines to skip.
     *
     * @return int
     */
    public function getSkipLines()
    {
        return $this->_skipLines;
    }
}
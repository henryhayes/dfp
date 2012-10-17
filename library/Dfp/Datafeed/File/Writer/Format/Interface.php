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
 * @subpackage  File_Writer_Format_Interface
 * @copyright   Copyright (c) 2012 PHP Datafeed Library
 * @version     $Id: Interface.php 72 2012-05-01 14:03:54Z t.carnage@gmail.com $
 * @since       2012-01-26
 */
/**
 * Dfp_Datafeed_File_Writer_Format_Interface.
 *
 * @category    Dfp
 * @package     Datafeed
 * @subpackage  File_Writer_Format_Interface
 * @copyright   Copyright (c) 2012 PHP Datafeed Library
 * @author      Henry Hayes
 * @since       2012-01-26
 */
interface Dfp_Datafeed_File_Writer_Format_Interface extends Dfp_Error_Interface, Dfp_Option_Interface
{
    /**
     * Writes a record to the file.
     * 
     * @param array $data
     */
    public function writeRecord(array $data);
}
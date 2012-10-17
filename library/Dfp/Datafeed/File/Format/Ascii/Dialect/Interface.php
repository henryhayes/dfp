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
 * @subpackage  File_Format_Ascii_Dialect_Interface
 * @copyright   Copyright (c) 2012 PHP Datafeed Library
 * @version     $Id: Interface.php 122 2012-07-03 21:15:30Z mail@henryhayes.co.uk $
 * @since       2012-07-03
 */
/**
 * Dfp_Datafeed_File_Format_Ascii_Dialect_Interface interface.
 *
 * @category    Dfp
 * @package     Datafeed
 * @subpackage  File_Format_Ascii_Dialect_Interface
 * @copyright   Copyright (c) 2012 PHP Datafeed Library
 * @author      Henry Hayes <mail@henryhayes.co.uk>
 * @since       2012-07-03
 */
interface Dfp_Datafeed_File_Format_Ascii_Dialect_Interface
    extends Dfp_Datafeed_File_Format_Dialect_Interface
{
    /**
     * Returns the line return character
     *
     * @return string
     */
    public function getLineReturn();
}
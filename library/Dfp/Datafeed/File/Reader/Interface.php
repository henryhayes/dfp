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
 * @subpackage  File_Reader_Interface
 * @copyright   Copyright (c) 2012 PHP Datafeed Library
 * @version     $Id: Interface.php 72 2012-05-01 14:03:54Z t.carnage@gmail.com $
 * @since       2011-12-07
 */
/**
 * Dfp_Datafeed_File_Reader_Interface interface.
 *
 * @category    Dfp
 * @package     Datafeed
 * @subpackage  File_Reader_Interface
 * @copyright   Copyright (c) 2012 PHP Datafeed Library
 * @author      Chris Riley <chris.riley@imhotek.net>
 * @since       2011-12-07
 */
interface Dfp_Datafeed_File_Reader_Interface extends Dfp_Datafeed_File_Interface, Iterator
{
    /**
     * Getter for format
     *
     * @return Dfp_Datafeed_File_Reader_Format_Interface
     */
    public function getFormat();

    /**
     * Setter for format
     *
     * @param Dfp_Datafeed_File_Reader_Format_Interface $format
     */
    public function setFormat(Dfp_Datafeed_File_Reader_Format_Interface $format);
}
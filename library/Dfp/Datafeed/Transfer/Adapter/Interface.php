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
 * @subpackage  Transfer_Adapter_Interface
 * @copyright   Copyright (c) 2012 PHP Datafeed Library
 * @version     $Id: Interface.php 72 2012-05-01 14:03:54Z t.carnage@gmail.com $
 * @since       2011-12-09
 */
/**
 * Dfp_Datafeed_Transfer_Adapter_Interface interface.
 *
 * @category    Dfp
 * @package     Datafeed
 * @subpackage  Transfer_Adapter_Interface
 * @copyright   Copyright (c) 2012 PHP Datafeed Library
 * @author      Chris Riley <chris.riley@imhotek.net>
 * @since       2011-12-09
 */

interface Dfp_Datafeed_Transfer_Adapter_Interface extends Dfp_Error_Interface, Dfp_Option_Interface
{
    public function sendFile($source, $destination=null);
    public function retrieveFile($source, $destination=null);
}
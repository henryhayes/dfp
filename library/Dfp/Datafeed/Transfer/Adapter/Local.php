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
 * @subpackage  Transfer_Adapter_Local
 * @copyright   Copyright (c) 2012 PHP Datafeed Library
 * @version     $Id: Local.php 112 2012-06-02 19:22:22Z henryhayesuk@gmail.com $
 * @since       2011-12-09
 */
/**
 * Dfp_Datafeed_Transfer_Adapter_Local class.
 *
 * @category    Dfp
 * @package     Datafeed
 * @subpackage  Transfer_Adapter_Local
 * @copyright   Copyright (c) 2012 PHP Datafeed Library
 * @author      Chris Riley <chris.riley@imhotek.net>
 * @since       2011-12-09
 */

class Dfp_Datafeed_Transfer_Adapter_Local extends Dfp_Datafeed_Transfer_Adapter_Abstract
{
    public function sendFile($source, $destination=null)
    {
        trigger_error("This method " . __METHOD__ . " has yet to be implemented", E_USER_ERROR);
    }

    public function retrieveFile($source, $destination=null)
    {
        trigger_error("This method " . __METHOD__ . " has yet to be implemented", E_USER_ERROR);
    }
}
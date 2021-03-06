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
* @subpackage  File_Format_Dialect_Abstract
* @copyright   Copyright (c) 2012 PHP Datafeed Library
* @since       2012-12-15
*/
/**
 * Dfp_Datafeed_File_Format_Dialect_Abstract class.
*
* @category    Dfp
* @package     Datafeed
* @subpackage  File_Format_Dialect_Abstract
* @copyright   Copyright (c) 2012 PHP Datafeed Library
* @author      Chris Riley <chris.riley@imhotek.net>
* @since       2012-12-15
*/

abstract class Dfp_Datafeed_File_Format_Dialect_Abstract 
	implements Dfp_Datafeed_File_Format_Dialect_Interface
{
	/**
	 * The line return character
	 *
	 * @var string
	 */
	protected $_lineReturn = "\n";	
	
	/**
	 * @see Dfp_Datafeed_File_Format_Dialect_Interface::getLineReturn()
	 */
	public function getLineReturn()
	{
		return $this->_lineReturn;
	}	
}
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
 * @subpackage  File_Record_Validator
 * @copyright   Copyright (c) 2012 PHP Datafeed Library
 * @since       2012-11-18
 */
/**
 * Dfp_Datafeed_File_Record_Validator class.
 *
 * @category    Dfp
 * @package     Datafeed
 * @subpackage  File_Record_Validator
 * @copyright   Copyright (c) 2012 PHP Datafeed Library
 * @author      Chris Riley <chris.riley@imhotek.net>
 * @since       2012-11-18
 */
class Dfp_Datafeed_File_Record_Validator 
{
	/**
	 * An array of validators to apply to each record before its returned.
	 *
	 * @var array
	 */
	protected $_validators = array();
		
	/**
	 * Add a validator
	 *
	 * @param Zend_Validate_Interface $validator
	 * @param string $field
	 * @return Dfp_Datafeed_File_Record_Validator
	 */
	public function addValidator(Zend_Validate_Interface $validator, $field=null, $breakChain=true)
	{
		if (is_null($field)) {
			//global filter: apply to all fields
			$this->_validators['global'][] = array('validator'=>$validator, 'breakChain'=>$breakChain);
		} else {
			$this->_validators['fields'][$field][] = array('validator'=>$validator, 'breakChain'=>$breakChain);
		}
		return $this;	
	}
	
	/**
	 * Getter for the validators array
	 *
	 * @return array
	 */
	public function getValidators()
	{
		return $this->_validators;
	}
	
	public function isValid($record)
	{
		
	}
	
	public function getMessages()
	{
		
	}
}
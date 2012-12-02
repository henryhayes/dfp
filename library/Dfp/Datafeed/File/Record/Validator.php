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
class Dfp_Datafeed_File_Record_Validator implements Dfp_Error_Interface
{
	/**
	 * An array of validators to apply to each record before its returned.
	 *
	 * @var array
	 */
	protected $_validators = array();
	
	/**
	 * Holds an array of errors for this object.
	 *
	 * @var array
	 */
	protected $_errors = array();
	
	/**
	 * Holds a list of fields required to be set for the record to be valid
	 * 
	 * @var array
	 */
	protected $_required = array();
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
	
	/**
	 * Adds a required field
	 * 
	 * @param string $field
	 * @return Dfp_Datafeed_File_Record_Validator
	 */
	public function addRequiredField($field)
	{
		$this->_required[] = $field;
		return $this;
	}
	
	/**
	 * Sets required fields
	 * 
	 * @param array $fields
	 * @return Dfp_Datafeed_File_Record_Validator
	 */
	public function setRequiredFields(array $fields)
	{
		$this->_required = $fields;
		return $this;
	}
	
	/**
	 * Add multiple required fields at once
	 * 
	 * @param array $fields
	 * @return Dfp_Datafeed_File_Record_Validator
	 */
	public function addRequiredFields(array $fields)
	{
		foreach ($fields AS $field) {
			$this->addRequiredField($field);
		}
		return $this;
	}
	
	/**
	 * Getter for required fields
	 * 
	 * @return array
	 */
	public function getRequiredFields()
	{
		return $this->_required;
	}

	/**
	 * Checks if a given record is valid.
	 * 
	 * @param array $record
	 * @return boolean
	 */
	public function validateRecord(array $record)
	{
		$this->setErrors(array());
		
		if (count($this->_required)) {
			foreach ($this->_required AS $field) {
				if (!array_key_exists($field, $record) || empty($record[$field]) ) {
					$this->addError(sprintf('Reqiured field %s is missing', $field));
				}
			}
		}
		
		foreach ($record AS $field => $value) {
			$break = false;
			if (array_key_exists('global', $this->_validators)) {
				foreach ($this->_validators['global'] AS $validatorInfo) {
					list($validator, $breakChain) = array_values($validatorInfo);
					if (!$validator->isValid($value)) {
						$this->addErrors($validator->getMessages());
						if ($breakChain) {
							$break = true;
							break;
						}
					}
				}
			}
			if (
				!$break && 
				array_key_exists('fields', $this->_validators) && 
				array_key_exists($field, $this->_validators['fields'])
			) {
				foreach ($this->_validators['fields'][$field] AS $validatorInfo) {
					list($validator, $breakChain) = array_values($validatorInfo);
					if (!$validator->isValid($value)) {
						$this->addErrors($validator->getMessages());
						if ($breakChain) {
							break;
						}
					}
				}
			}
		}
		return !$this->hasErrors();
	}

	/**
	 * @see Dfp_Error_Interface::addError()
	 * @return Dfp_Datafeed_File_Reader_Format_Abstract
	 */
	public function addError($message)
	{
		$this->_errors[] = $message;
		return $this;
	}
	
	/**
	 * @see Dfp_Error_Interface::addErrors()
	 * @return Dfp_Datafeed_File_Reader_Format_Abstract
	 */
	public function addErrors(array $messages)
	{
		foreach ($messages AS $message) {
			$this->addError($message);
		}
		return $this;
	}
	
	/**
	 * @see Dfp_Error_Interface::getErrors()
	 */
	public function getErrors()
	{
		return $this->_errors;
	}
	
	/**
	 * @see Dfp_Error_Interface::hasErrors()
	 */
	public function hasErrors()
	{
		return (bool) count($this->_errors);
	}
	
	/**
	 * @see Dfp_Error_Interface::setErrors()
	 * @return Dfp_Datafeed_File_Reader_Format_Abstract
	 */
	public function setErrors(array $messages)
	{
		$this->_errors = $messages;
		return $this;
	}	
}
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
 * @subpackage  File_Record_Filterer
 * @copyright   Copyright (c) 2012 PHP Datafeed Library
 * @since       2011-12-07
 */
/**
 * Dfp_Datafeed_File_Record_Filterer class.
 *
 * @category    Dfp
 * @package     Datafeed
 * @subpackage  File_Record_Filterer
 * @copyright   Copyright (c) 2012 PHP Datafeed Library
 * @author      Chris Riley <chris.riley@imhotek.net>
 * @since       2011-12-07
 */
class Dfp_Datafeed_File_Record_Filterer 
{
	/**
	 * An array of filters to apply to each record before its returned.
	 *
	 * @var array
	 */
	protected $_filters = array();
		
	/**
	 * Adds a filter to the reader.
	 * Second parameter specifies which field to apply to, null adds a global filter
	 *
	 * @param Zend_Filter_Interface $filter
	 * @param string $field
	 * @return Dfp_Datafeed_File_Reader
	 */
	public function addFieldFilter(Zend_Filter_Interface $filter, $field=null)
	{
		if (is_null($field)) {
			//global filter: apply to all fields
			$this->_filters['global'][] = $filter;
		} else {
			$this->_filters['fields'][$field][] = $filter;
		}
		return $this;
	}
	
	/**
	 * Adds a filter for the field headers
	 *
	 * @param Zend_Filter_Interface $filter
	 * @return Dfp_Datafeed_File_Reader
	 */
	public function addHeaderFilter(Zend_Filter_Interface $filter)
	{
		$this->_filters['header'][] = $filter;
		return $this;
	}
	
	/**
	 * Single method for adding a filter,
	 * proxies through to the specific type filter add methods
	 *
	 * @param Zend_Filter_Interface $filter
	 * @param string $field
	 * @param string $type
	 */
	public function addFilter(Zend_Filter_Interface $filter, $field=null, $type='field')
	{
		if ($type == 'field') {
			$this->addFieldFilter($filter, $field);
		} elseif ($type == 'header') {
			$this->addHeaderFilter($filter);
		}
	}
	
	/**
	 * Getter for the filters array
	 *
	 * @return array
	 */
	public function getFilters()
	{
		return $this->_filters;
	}
	
	/**
	 * Filters the data in the record
	 *
	 * @param array $record
	 */
	public function filterRecord(array $record)
	{
		if (array_key_exists('header', $this->_filters) && is_array($this->_filters['header'])) {
			//first filter each header
			$filtered = array();
	
			foreach ($record AS $key => $value) {
				$newHeader = $key;
				foreach ($this->_filters['header'] AS $filter) {
					$newHeader = $filter->filter($newHeader);
				}
				$filtered[$newHeader] = $value;
			}
			$record = $filtered;
		}
	
		$filterFields = array();
	
		if (array_key_exists('global', $this->_filters)) {
			$filterFields = array_keys($record);
		} elseif (array_key_exists('fields', $this->_filters)) {
			$possibleFields = array_keys($record);
			$filterFields = array_intersect(
					$possibleFields,
					array_keys($this->_filters['fields'])
			);
		}
	
		foreach ($filterFields as $key) {
			//loop through each global filter and apply.
			if (array_key_exists('global', $this->_filters)) {
				foreach ($this->_filters['global'] AS $filter) {
					$record[$key] = $filter->filter($record[$key]);
				}
			}
				
			//loop through each field filter and apply.
			if (array_key_exists('fields', $this->_filters) && array_key_exists($key, $this->_filters['fields'])) {
				foreach ($this->_filters['fields'][$key] AS $filter) {
					$record[$key] = $filter->filter($record[$key]);
				}
			}
				
		}
		return $record;
	}	
}
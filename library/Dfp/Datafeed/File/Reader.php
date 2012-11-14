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
 * @subpackage  File_Reader
 * @copyright   Copyright (c) 2012 PHP Datafeed Library
 * @version     $Id: Reader.php 72 2012-05-01 14:03:54Z t.carnage@gmail.com $
 * @since       2011-12-07
 */
/**
 * Dfp_Datafeed_File_Reader class.
 *
 * @category    Dfp
 * @package     Datafeed
 * @subpackage  File_Reader
 * @copyright   Copyright (c) 2012 PHP Datafeed Library
 * @author      Chris Riley <chris.riley@imhotek.net>
 * @since       2011-12-07
 */
class Dfp_Datafeed_File_Reader extends Dfp_Datafeed_File_Abstract implements Dfp_Datafeed_File_Reader_Interface
{
    /**
     * Holds an instance of the feed format adapter.
     *
     * @var Dfp_Datafeed_File_Reader_Format_Interface
     */
    protected $_format;

    /**
     * Holds the name of the format namespace. Defaults to this namespace.
     *
     * @var string
     */
    protected $_formatNamespace = 'Dfp_Datafeed_File_Reader_Format';

    /**
     * Holds the current position into the feed.
     *
     * @var int
     */
    protected $_position = 0;
    
    /**
     * Holds the current record from the feed.
     *
     * @var array
     */
    protected $_currentRecord;
    
    /**
     * An array of filters to apply to each record before its returned.
     * 
     * @var array
     */
    protected $_filters = array();
    
    /**
    * @see Dfp_Option_Interface::setOptions()
    * @return Dfp_Datafeed_File_Reader
    * @throws Dfp_Datafeed_File_Reader_Exception
    */
    public function setOptions(array $options)
    {
        if (isset($options['format'])) {
            if ($options['format'] instanceof Dfp_Datafeed_File_Reader_Format_Interface) {
                $this->setFormat($options['format']);
            } elseif (is_string($options['format'])) {
                $this->setFormatString($options['format']);
            } else {
                throw new Dfp_Datafeed_File_Reader_Exception('Invalid format specified');
            }
            unset($options['format']);
        }
    
        $this->getFormat()->setOptions($options);
        return $this;
    }    
    
    /**
    * @see Dfp_Datafeed_File_Reader_Interface::getFormat()
    * @return Dfp_Datafeed_File_Reader_Format_Interface
    */
    public function getFormat()
    {
        if (!($this->_format instanceof Dfp_Datafeed_File_Reader_Format_Interface)) {
            $this->_loadFormat();
        }
    
        return $this->_format;
    }
    
    /**
     * @see Dfp_Datafeed_File_Reader_Interface::setFormat()
     * @return Dfp_Datafeed_File_Reader
     */
    public function setFormat(Dfp_Datafeed_File_Reader_Format_Interface $format)
    {
        $this->_format = $format;
        return $this;
    }    

    /**
     * @see Dfp_Datafeed_File_Reader_Interface::getXslt()
     * @return string
     */
    public function getXslt()
    {
        $format = $this->getFormat();
        if (!($format instanceof Dfp_Datafeed_File_Reader_Format_Xml)) {
            throw new Dfp_Datafeed_File_Reader_Exception('getXslt can only be called when the format is XML');
        }
    
        return $format->getXslt();
    }
    
    /**
     * @see Dfp_Datafeed_File_Reader_Interface::setXslt()
     * @return Dfp_Datafeed_File_Reader
     */
    public function setXslt($xslt)
    {
        $format = $this->getFormat();
        if (!($format instanceof Dfp_Datafeed_File_Reader_Format_Xml)) {
            throw new Dfp_Datafeed_File_Reader_Exception('setXslt can only be called when the format is XML');
        }
    
        $format->setXslt($xslt);
        return $this;
    }
    
    /**
     * @see Iterator::rewind()
     */
    public function rewind()
    {
    	$this->getFormat()->resetFeed();
    	$this->_position = 0;
    	$this->next(); //load first record
    }
    
    /**
     * @see Iterator::next()
     */
    public function next()
    {
    	$this->_currentRecord = $this->getFormat()->loadNextRecord();
    	if (is_array($this->_currentRecord)) {
    		$this->_currentRecord = $this->filterRecord($this->_currentRecord);
    	}
    	$this->_position++;
    }
    
    /**
     * @see Iterator::valid()
     */
    public function valid()
    {
    	return (bool) $this->_currentRecord;
    }
    
    /**
     * @see Iterator::current()
     */
    public function current()
    {
    	return $this->_currentRecord;
    }
    
    /**
     * @see Iterator::key()
     */
    public function key()
    {
    	return $this->_position;
    } 

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
			$originalHeaders = array();
			$filtered = array();

			foreach ($record AS $key => $value) {
				$newHeader = $key;
				foreach ($this->_filters['header'] AS $filter) {
					$newHeader = $filter->filter($newHeader);
				} 
				$filtered[$newHeader] = $value;
				$originalHeaders[$newHeader] = $key; //preserve the old value for filtering fields
			}
			$record = $filtered;
		}
		
		$filterFields = array();
		
		if (array_key_exists('global', $this->_filters)) {
			$filterFields = array_keys($record);
		} elseif (array_key_exists('fields', $this->_filters)) {
			
			$filterFields = array_intersect(
								array_merge(array_keys($record), array_values($originalHeaders)), 
								array_keys($this->_filters['fields'])
							);
		}
		
		//todo: use original headers array to apply filters from before filtering headers.
		foreach ($filterFields as $key) {
			//loop through each global filter and apply.
			if (array_key_exists('global', $this->_filters)) {
				foreach ($this->_filters['global'] AS $filter) {
					$record[$key] = $filter->filter($record[$key]);
				}
			}
			
			//loop through each field filter and apply.
			if (array_key_exists('fields', $this->_filters)) {
				$filters = array();
			
				if (array_key_exists($key, $this->_filters['fields'])) {
					$filters = array_merge($filters, $this->_filters['fields'][$key]);
				} 
				if (array_key_exists($originalHeaders[$key], $this->_filters['fields'])) {
					$filters = array_merge($filters, $this->_filters['fields'][$originalHeaders[$key]]);
				}
				foreach ($this->_filters['fields'][$key] AS $filter) {
					$record[$key] = $filter->filter($record[$key]);
				}
			}
			
		}
		return $record;
	}
}
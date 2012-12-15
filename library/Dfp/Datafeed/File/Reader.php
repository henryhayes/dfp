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
    	do {
    		$this->_currentRecord = $this->getFormat()->loadNextRecord();
    		if (!is_array($this->_currentRecord)) {
    			return;
    		}
    		$this->_position++;
    		$this->_currentRecord = $this->getRecordFilterer()->filterRecord($this->_currentRecord);
    		$valid = $this->getRecordValidator()->validateRecord($this->_currentRecord);
    		
    		if (!$valid) {
    			$errors = $this->getRecordValidator()->getErrors();
    			if (is_array($errors)) {
    				foreach ($errors AS $error) {
    					$this->addError(sprintf('Validation error on line %d: %s', $this->_position, $error));
    				}
    			} else {
    				$this->addError(sprintf('Validation error on line %d', $this->_position));
    			}
    		}
    		
    	} while (!$valid);
    	
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
     * @param string $method
     * @param array $args
     * @throws Dfp_Datafeed_File_Reader_Exception
     * @return mixed
     */
    public function __call($method, $args)
    {
    	if (method_exists($this->getFormat(), $method)) {
    		return call_user_func_array(array($this->getFormat(), $method), $args);
    	}
    	
    	throw new Dfp_Datafeed_File_Reader_Exception(sprintf('Method %s dosn\'t exist in format class', $method));
    }
}
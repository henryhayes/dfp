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
 * @subpackage  File_Format_FixedWidth_Dialect_Positional
 * @copyright   Copyright (c) 2012 PHP Datafeed Library
 * @since       2012-07-03
 */
/**
 * Dfp_Datafeed_File_Format_FixedWidth_Dialect_Positional class.
 *
 * @category    Dfp
 * @package     Datafeed
 * @subpackage  File_Format_FixedWidth_Dialect_Positional
 * @copyright   Copyright (c) 2012 PHP Datafeed Library
 * @author      Henry Hayes <mail@henryhayes.co.uk>
 * @since       2012-07-03
 */
class Dfp_Datafeed_File_Format_FixedWidth_Dialect_Positional
    extends Dfp_Datafeed_File_Format_FixedWidth_Dialect_Abstract
{
    /**
     * Contains an array of data for the positional data.
     *
     * $_info = array(
     *     'header_field_name1' => array('offset' => 1, 'length' => 3),
     *     'header_field_name2' => array('offset' => 4, 'length' => 5),
     *     'header_field_name3' => array('offset' => 7, 'length' => 10),
     * )
     *
     * @var array
     */
    protected $_info = array();

    /**
     * Sets the positional information.
     *
     * @param array $info
     * @return Dfp_Datafeed_File_Format_FixedWidth_Dialect_Positional
     */
    public function setPositionalInfo(array $info)
    {
        if (!count($info)) {
            throw new Dfp_Datafeed_File_Exception('Array was empty');
        }

        foreach ($info as $key => $offsetArray) {
            if (!is_array($offsetArray)) {
                throw new Dfp_Datafeed_File_Exception('Array was not of correct format');
            }
        }

        $this->_info = $info;
        return $this;
    }

    /**
     * Sets the positional information.
     *
     * @return array
     */
    public function getPositionalInfo()
    {
        return $this->_info;
    }
}
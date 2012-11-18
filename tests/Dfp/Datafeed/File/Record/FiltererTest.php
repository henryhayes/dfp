<?php
/**
 * Test class for Dfp_Datafeed_File_Reader.
 * Generated by PHPUnit on 2011-12-09 at 10:59:43.
 *
 */
class Dfp_Datafeed_File_Record_FiltererTest extends PHPUnit_Framework_TestCase
{
	public function testGetFilters()
	{
		$sut = new Dfp_Datafeed_File_Record_Filterer();
		$this->assertEmpty($sut->getFilters());
	}
	
	public function testAddFieldFilter()
	{
		$mockFilter = $this->getMock('Zend_Filter_Interface');
		$sut = new Dfp_Datafeed_File_Record_Filterer();
		$sut->addFieldFilter($mockFilter);
		 
		$this->assertEquals(array('global'=>array($mockFilter)), $sut->getFilters());
		 
		$sut = new Dfp_Datafeed_File_Record_Filterer();
		$sut->addFieldFilter($mockFilter, 'test');
	
		$this->assertEquals(array('fields'=>array('test'=>array($mockFilter))), $sut->getFilters());
	}
	
	public function testAddHeaderFilter()
	{
		$mockFilter = $this->getMock('Zend_Filter_Interface');
		$sut = new Dfp_Datafeed_File_Record_Filterer();
		$sut->addHeaderFilter($mockFilter);
	
		$this->assertEquals(array('header'=>array($mockFilter)), $sut->getFilters());
	}
	
	public function testAddFilter()
	{
		$mockFilter = $this->getMock('Zend_Filter_Interface');
		$sut = new Dfp_Datafeed_File_Record_Filterer();
		$sut->addFilter($mockFilter);
	
		$this->assertEquals(array('global'=>array($mockFilter)), $sut->getFilters());
		 
		$mockFilter = $this->getMock('Zend_Filter_Interface');
		$sut = new Dfp_Datafeed_File_Record_Filterer();
		$sut->addFilter($mockFilter, 'test');
	
		$this->assertEquals(array('fields'=>array('test'=>array($mockFilter))), $sut->getFilters());
	
		$mockFilter = $this->getMock('Zend_Filter_Interface');
		$sut = new Dfp_Datafeed_File_Record_Filterer();
		$sut->addFilter($mockFilter, null, 'header');
	
		$this->assertEquals(array('header'=>array($mockFilter)), $sut->getFilters());
	}
	
	/**
	 * @dataProvider filterRecordProvider
	 */
	public function testFilterRecord($record, $filters, $expected)
	{
		$sut = new Dfp_Datafeed_File_Record_Filterer();
	
		foreach ($filters AS $filter) {
			call_user_func_array(array($sut, 'addFilter'), $filter);
		}
	
		$this->assertEquals($expected,$sut->filterRecord($record));
	}
	
	public function filterRecordProvider()
	{
		$mockFilter = $this->getMock('Zend_Filter_Interface');
		$mockFilter->expects($this->any())
		           ->method('filter')
		           ->will($this->returnCallback('strtoupper'));
		return array(
			//Tests no action with no filters
			array(
				array('noaction'=>'noaction'),
				array(),
				array('noaction'=>'noaction')
			),
			//tests action of field specific filter
			array(
				array('filterme'=>'alllower', 'butnotme'=>'alllower'),
				array(array($mockFilter, 'filterme')),
				array('filterme'=>'ALLLOWER', 'butnotme'=>'alllower'),
			),
			//Tests action of global filter
			array(
				array('filterme'=>'alllower', 'andme'=>'alllower'),
				array(array($mockFilter)),
				array('filterme'=>'ALLLOWER', 'andme'=>'ALLLOWER'),
			),
			//tests action of header filter
			array(
				array('filterme'=>'alllower', 'andme'=>'alllower'),
				array(array($mockFilter,null,'header')),
				array('FILTERME'=>'alllower', 'ANDME'=>'alllower')
			),
			//tests action of filter on a filtered header
			array(
				array('filterme'=>'alllower', 'butnotme'=>'alllower'),
				array(array($mockFilter,null,'header'), array($mockFilter, 'FILTERME')),
				array('FILTERME'=>'ALLLOWER', 'BUTNOTME'=>'alllower'),
			),
		);
	}
}
<?php
/**
 * Test class for Dfp_Datafeed_File_Format_Csv_Dialect_Solr.
 */
class Dfp_Datafeed_File_Format_Csv_Dialect_SolrTest extends PHPUnit_Framework_TestCase
{
    public function testGetDelimiter()
    {
        $sut = new Dfp_Datafeed_File_Format_Csv_Dialect_Solr();
        $this->assertEquals(",", $sut->getDelimiter());
    }

    public function testGetEscape()
    {
        $sut = new Dfp_Datafeed_File_Format_Csv_Dialect_Solr();
        $this->assertEquals('', $sut->getEscape());
    }

    public function testGetQuote()
    {
        $sut = new Dfp_Datafeed_File_Format_Csv_Dialect_Solr();
        $this->assertEquals('"', $sut->getQuote());
    }

    public function testhasHeader()
    {
        $sut = new Dfp_Datafeed_File_Format_Csv_Dialect_Solr();
        $this->assertTrue($sut->hasHeader());
    }

    public function testGetLineReturn()
    {
        $sut = new Dfp_Datafeed_File_Format_Csv_Dialect_Solr();
        $this->assertEquals("\n", $sut->getLineReturn());
    }
}

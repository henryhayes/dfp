<?php
/**
 * Test class for Dfp_Datafeed_File_Format_Csv_Dialect_Standard.
 * Generated by PHPUnit on 2011-12-13 at 11:51:23.
 *
 */
class Dfp_Datafeed_File_Format_Csv_Dialect_StandardTest extends PHPUnit_Framework_TestCase
{
    public function testGetDelimiter()
    {
        $sut = new Dfp_Datafeed_File_Format_Csv_Dialect_Standard();
        $this->assertEquals(',', $sut->getDelimiter());
    }

    public function testGetEscape()
    {
        $sut = new Dfp_Datafeed_File_Format_Csv_Dialect_Standard();
        $this->assertEquals('\\', $sut->getEscape());
    }

    public function testGetQuote()
    {
        $sut = new Dfp_Datafeed_File_Format_Csv_Dialect_Standard();
        $this->assertEquals('"', $sut->getQuote());
    }

    public function testhasHeader()
    {
        $sut = new Dfp_Datafeed_File_Format_Csv_Dialect_Standard();
        $this->assertNull($sut->hasHeader());
    }

    public function testGetLineReturn()
    {
        $sut = new Dfp_Datafeed_File_Format_Csv_Dialect_Standard();
        $this->assertEquals("\n", $sut->getLineReturn());
    }
}

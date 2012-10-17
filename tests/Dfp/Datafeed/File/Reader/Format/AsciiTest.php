<?php

include_once 'vfsStream/vfsStream.php';

/**
 * Test class for Dfp_Datafeed_File_Reader_Format_Ascii.
 */
class Dfp_Datafeed_File_Reader_Format_AsciiTest extends PHPUnit_Framework_TestCase
{
    /**
     * Tests getDialect()
     */
    public function testGetDialect()
    {
        $mockFile = $this->getMock('Dfp_Datafeed_File_Format_Ascii_Dialect_Positional');
        $sut = new Dfp_Datafeed_File_Reader_Format_Ascii();

        $dialect = $sut->getDialect();
        $this->assertInstanceOf('Dfp_Datafeed_File_Format_Ascii_Dialect_Positional', $dialect);

        $this->assertEquals(array(), $dialect->getPositionalInfo());
    }

    /**
     * Tests setDialect()
     */
    public function testSetDialect()
    {
        $mockDialect = $this->getMock('Dfp_Datafeed_File_Format_Ascii_Dialect_Interface');
        $sut = new Dfp_Datafeed_File_Reader_Format_Ascii();
        $sut->setDialect($mockDialect);
        $this->assertSame($mockDialect, $sut->getDialect());
    }

    /**
    * Tests setDialectString()
    */
    public function testSetDialectString()
    {
        $sut = $sut = new Dfp_Datafeed_File_Reader_Format_Ascii();
        $sut->setDialectString('positional');
        $this->assertInstanceOf('Dfp_Datafeed_File_Format_Ascii_Dialect_Positional', $sut->getDialect());
    }

    /**
     * Tests the itterator, file contents and parsing.
     *
     * @dataProvider dataProvider
     *
     * @param array $positionalInfo
     * @param string $fileContents
     * @param array $dataExpected
     */
    public function testProcessor(array $positionalInfo, $fileContents, array $dataExpected, array $errors)
    {
        $dir = vfsStream::setup('base');
        file_put_contents(vfsStream::url('base/test.csv'), $fileContents);
        //error_log(print_r(file_get_contents(vfsStream::url('base/test.csv')), 1));

        $params = array(
            'location' => vfsStream::url('base/test.csv')
        );

        $dialect = new Dfp_Datafeed_File_Format_Ascii_Dialect_Positional();
        $dialect->setPositionalInfo($positionalInfo);

        $sut = new Dfp_Datafeed_File_Reader_Format_Ascii($params);
        $sut->setDialect($dialect);

        $data = array();
        foreach ($sut as $record) {
            $data[] = $record;
        }

        $this->assertSame($dataExpected, $data);

        $this->assertSame($sut->getErrors(), $errors);
    }

    public function dataProvider()
    {
        return array(
            array(
                array(
                    'header_1' => array('offset' => 1, 'length' => 3),
                    'header_2' => array('offset' => 4, 'length' => 4),
                    'header_3' => array('offset' => 8, 'length' => null),
                ),
                "AB2AS 1 7891\r\nAB2AS11 7891\nAB2BS   7891\r",
                array(
                    0 => array('header_1' => 'AB2', 'header_2' => 'AS 1', 'header_3' => '7891'),
                    1 => array('header_1' => 'AB2', 'header_2' => 'AS11', 'header_3' => '7891'),
                    2 => array('header_1' => 'AB2', 'header_2' => 'BS', 'header_3' => '7891'),
                ),
                array()
            ),
            // Cap ascii example
            array(
                array(
                    'cap_code'             => array('offset' => 1,  'length' => 20),
                    'cap_id'               => array('offset' => 21, 'length' => 5),
                    'make'                 => array('offset' => 26, 'length' => 25),
                    'model'                => array('offset' => 51, 'length' => 25),
                    'model_extended'       => array('offset' => 76, 'length' => 50),
                    'year_from'            => array('offset' => 126, 'length' => 4),
                    'year_to'              => array('offset' => 130, 'length' => 4),
                    'derivative'           => array('offset' => 134, 'length' => 25),
                    'derivative_extended'  => array('offset' => 159, 'length' => 50),
                    'derivative_year_from' => array('offset' => 209, 'length' => 4),
                    'derivative_year_to'   => array('offset' => 213, 'length' => 4),
                    'currently_available'  => array('offset' => 217, 'length' => 1),
                ),
                "CDEVAL.J25 25/06/2012\r\nABA514   3HPTM      44042ABARTH                   500                      " .
                "500 HATCHBACK                                     2009                             1.4 16V T-Jet 3dr" .
                "                                 20092010Y\nCDEVAL.J25 25/06/2012",
                array(
                    0 => array(
                        'cap_code' => 'ABA514   3HPTM',
                        'cap_id' => '44042',
                        'make' => 'ABARTH',
                        'model' => '500',
                        'model_extended' => '500 HATCHBACK',
                        'year_from' => '2009',
                        'year_to' => '',
                        'derivative' => '',
                        'derivative_extended' => '1.4 16V T-Jet 3dr',
                        'derivative_year_from' => '2009',
                        'derivative_year_to' => '2010',
                        'currently_available' => 'Y'
                    ),
                ),
                array(
                    0 => 'Line 1 is incorrect',
                    1 => 'Line 3 is incorrect',
                )
            ),
            //unpack filtering length
            array(
                array(
                    'header_1' => array('offset' => 1, 'length' => 3),
                    'header_2' => array('offset' => 4, 'length' => 2),
                    'header_3' => array('offset' => 8, 'length' => null),
                ),
                "AB2AS 1 7891\r\nAB2AS11 7891\nAB2BS   7891\r",
                array(
                    0 => array('header_1' => 'AB2', 'header_2' => 'AS', 'header_3' => '7891'),
                    1 => array('header_1' => 'AB2', 'header_2' => 'AS', 'header_3' => '7891'),
                    2 => array('header_1' => 'AB2', 'header_2' => 'BS', 'header_3' => '7891'),
                ),
                array()
            ),
            //unpack filtering length, not using whole record
            array(
                array(
                    'header_1' => array('offset' => 1, 'length' => 3),
                    'header_2' => array('offset' => 4, 'length' => 7),
                    'header_3' => array('offset' => 11, 'length' => 10),
                    'header_4' => array('offset' => 21, 'length' => 10),
                ),
                "AB2AS 1 7891hdjf ajsdhk ajfhksdj sjfhks\r\n",
                array(
                    0 => array(
                    	'header_1' => 'AB2',
                    	'header_2' => 'AS 1 78',
                    	'header_3' => '91hdjf ajs',
                    	'header_4'=>'dhk ajfhks'
                	),
                ),
                array()
            ),
            //not enough characters to unpack
            array(
                array(
                    'header_1' => array('offset' => 1, 'length' => 3),
                    'header_2' => array('offset' => 4, 'length' => 2),
                    'header_3' => array('offset' => 8, 'length' => 100),
                ),
                "AB2AS 1 7891\r\n",
                array(
                ),
                array(0 => 'Line 1 is incorrect')
            ),
        );
    }

    public function test__construct()
    {
        $params = array(
            'location'=>'test.csv'
        );

        $c = new Zend_Config($params);

        $sut = new Dfp_Datafeed_File_Reader_Format_Ascii($params);
        $this->assertEquals('test.csv', $sut->getLocation());
        $sut = new Dfp_Datafeed_File_Reader_Format_Ascii($c);
        $this->assertEquals('test.csv', $sut->getLocation());

        try {
            $sut = new Dfp_Datafeed_File_Reader_Format_Ascii('string');
        } catch (Dfp_Datafeed_File_Exception $e) {
            if ($e->getMessage() == 'Invalid parameter to constructor') {
                return;
            }
        }

        $this->fail('Exception not thrown');
    }

    public function testSetDialectNamespace()
    {
        $sut = new Dfp_Datafeed_File_Reader_Format_Ascii();
        $sut->setDialectNamespace('test');
        $this->assertEquals('test', $sut->getDialectNamespace());
    }
}

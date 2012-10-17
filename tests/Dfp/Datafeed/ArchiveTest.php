<?php
include_once 'vfsStream/vfsStream.php';
/**
 * Test class for Dfp_Datafeed_Archive
 * Generated by PHPUnit on 2011-12-09 at 10:59:43.
 *
 */
class Dfp_Datafeed_ArchiveTest extends PHPUnit_Framework_TestCase
{
    /**
     * @todo Implement testGetAdapter().
     */
    public function testGetAdapter()
    {
        $sut = new Dfp_Datafeed_Archive();
        try {
            $sut->getAdapter();
        } catch (Dfp_Datafeed_Archive_Exception $e) {
            if ($e->getMessage() == 'Invalid Adapter Specified') {
                return;
            }
        }

        $this->fail('Exception not thrown');
    }

    /**
     * @todo Implement testGetAdapter().
     */
    public function testSetAdapterString()
    {
        $name = 'test' . uniqid();
        $className = 'Dfp_Datafeed_Archive_Adapter_' . ucfirst($name);

        $sut = new Dfp_Datafeed_Archive();
        $mockAdapter = $this->getMock(
        	'Dfp_Datafeed_Archive_Adapter_Interface',
        	array(),
        	array(),
        	$className
        );

        $sut->setAdapterString($name);

        $this->assertInstanceOf($className, $sut->getAdapter());
    }

    public function testGetAdapterNamespace()
    {
        $sut = new Dfp_Datafeed_Archive();

        $this->assertEquals('Dfp_Datafeed_Archive_Adapter', $sut->getAdapterNamespace());
    }

    public function testSetAdapterNamespace()
    {
        $sut = new Dfp_Datafeed_Archive();

        $sut->setAdapterNamespace('test');

        $this->assertEquals('test', $sut->getAdapterNamespace());
    }

    /**
     * @todo Implement testSetAdapter().
     */
    public function testSetAdapter()
    {
        $sut = new Dfp_Datafeed_Archive();
        $mockAdapter = $this->getMock('Dfp_Datafeed_Archive_Adapter_Interface');

        $sut->setAdapter($mockAdapter);

        $this->assertSame($mockAdapter, $sut->getAdapter());
    }

    /**
     * @todo Implement testSetConfig().
     */
    public function testSetConfig()
    {
        $options = array('adapterNamespace'=>'Test_Namespace');

        $config = new Zend_Config($options);

        $sut = $this->getMock('Dfp_Datafeed_Archive', array('setOptions'));
        $sut->expects($this->once())->method('setOptions')->with($this->equalTo($options));

        $sut->setConfig($config);
    }

    /**
     * @todo Implement testSetOptions().
     */
    public function testSetOptions()
    {
        $options = array('adapter'=>'ftp','adapterOption'=>'value','adapterNamespace'=>'Test_Namespace');

        $sut = $this->getMock('Dfp_Datafeed_Archive', array('getAdapter','setAdapterString', 'setAdapterNamespace'));

        $mockAdapter = $this->getMock('Dfp_Datafeed_Archive_Adapter_Interface');
        $mockAdapter->expects($this->once())->method('setOptions')
                    ->with($this->equalTo(array('adapterOption'=>'value')));
        $sut->expects($this->any())->method('getAdapter')->will($this->returnValue($mockAdapter));

        $sut->expects($this->once())->method('setAdapterString')->with($this->equalTo('ftp'));
        $sut->expects($this->once())->method('setAdapterNamespace')->with($this->equalTo('Test_Namespace'));

        $sut->setOptions($options);

        //test with a adapter instance

        $mockAdapter = $this->getMock('Dfp_Datafeed_Archive_Adapter_Interface');
        $options = array('adapter'=>$mockAdapter);

        $sut = new Dfp_Datafeed_Archive();
        $sut->setOptions($options);

        $this->assertEquals($mockAdapter, $sut->getAdapter());

        //test with invalid adapter

        $passed = false;
        $sut = new Dfp_Datafeed_Archive();
        $options = array('adapter'=>array());
        try {
            $sut->setOptions($options);
        } catch (Dfp_Datafeed_Archive_Exception $e) {
            if ($e->getMessage() == 'Invalid adapter specified') {
                $passed = true;
            }
        }
        $this->assertTrue($passed, 'Adapter exception not thrown');

        $sut = new Dfp_Datafeed_Archive();
        $options = array('adapterNamespace'=>array());
        try {
            $sut->setOptions($options);
        } catch (Dfp_Datafeed_Archive_Exception $e) {
            if ($e->getMessage() == 'Invalid adapter namespace specified') {
                return;
            }
        }

        $this->fail('Adapter namespace exception not thrown');
    }

    public function test__construct()
    {
        $mockAdapter = $this->getMock('Dfp_Datafeed_Archive_Adapter_Interface');
        $options = array('adapter'=>$mockAdapter);

        $sut = new Dfp_Datafeed_Archive($options);

        $this->assertEquals($mockAdapter, $sut->getAdapter());
        $c = new Zend_Config($options);

        $sut = new Dfp_Datafeed_Archive($c);

        $this->assertEquals($mockAdapter, $sut->getAdapter());

        try {
            $sut = new Dfp_Datafeed_Archive('invalid');
        } catch (Dfp_Datafeed_Archive_Exception $e) {
            if ($e->getMessage() == 'Invalid parameter to constructor') {
                return;
            }
        }

        $this->fail('Exception not thrown');
    }

    public function testAddError()
    {
        $sut = new Dfp_Datafeed_Archive();
        $mockAdapter = $this->getMock('Dfp_Datafeed_Archive_Adapter_Interface');
        $mockAdapter->expects($this->once())->method('addError')->with($this->equalTo('error'));

        $sut->setAdapter($mockAdapter);

        $sut->addError('error');
    }

    public function testAddErrors()
    {
        $sut = new Dfp_Datafeed_Archive();
        $mockAdapter = $this->getMock('Dfp_Datafeed_Archive_Adapter_Interface');
        $mockAdapter->expects($this->once())->method('addErrors')->with($this->equalTo(array('error','error2')));

        $sut->setAdapter($mockAdapter);

        $sut->addErrors(array('error','error2'));
    }

    public function testGetErrors()
    {
        $sut = new Dfp_Datafeed_Archive();
        $mockAdapter = $this->getMock('Dfp_Datafeed_Archive_Adapter_Interface');
        $mockAdapter->expects($this->once())->method('getErrors')->will($this->returnValue(array('error')));

        $sut->setAdapter($mockAdapter);

        $this->assertEquals(array('error'), $sut->getErrors());
    }

    public function testHasErrors()
    {
        $sut = new Dfp_Datafeed_Archive();
        $mockAdapter = $this->getMock('Dfp_Datafeed_Archive_Adapter_Interface');
        $mockAdapter->expects($this->once())->method('hasErrors')->will($this->returnValue(true));

        $sut->setAdapter($mockAdapter);

        $this->assertEquals(true, $sut->hasErrors());
    }

    public function testSetErrors()
    {
        $sut = new Dfp_Datafeed_Archive();
        $mockAdapter = $this->getMock('Dfp_Datafeed_Archive_Adapter_Interface');
        $mockAdapter->expects($this->once())->method('setErrors')->with($this->equalTo(array('error','error2')));

        $sut->setAdapter($mockAdapter);

        $sut->setErrors(array('error','error2'));
    }

    public function testSetExtractPath()
    {
        $sut = new Dfp_Datafeed_Archive();
        $mockAdapter = $this->getMock('Dfp_Datafeed_Archive_Adapter_Interface');
        $mockAdapter->expects($this->once())->method('setExtractPath')->with($this->equalTo('c:\\files\\'));

        $sut->setAdapter($mockAdapter);

        $sut->setExtractPath('c:\\files\\');
    }

    public function testGetExtractPath()
    {
        $sut = new Dfp_Datafeed_Archive();
        $mockAdapter = $this->getMock('Dfp_Datafeed_Archive_Adapter_Interface');
        $mockAdapter->expects($this->once())->method('getExtractPath')->will($this->returnValue('c:\\files\\'));

        $sut->setAdapter($mockAdapter);

        $this->assertEquals('c:\\files\\', $sut->getExtractPath());
    }
    public function testSetLocation()
    {
        $sut = new Dfp_Datafeed_Archive();
        $mockAdapter = $this->getMock('Dfp_Datafeed_Archive_Adapter_Interface');
        $mockAdapter->expects($this->once())->method('setLocation')->with($this->equalTo('c:\\files\\test.zip'));

        $sut->setAdapter($mockAdapter);

        $sut->setLocation('c:\\files\\test.zip');
    }

    public function testGetLocation()
    {
        $sut = new Dfp_Datafeed_Archive();
        $mockAdapter = $this->getMock('Dfp_Datafeed_Archive_Adapter_Interface');
        $mockAdapter->expects($this->once())->method('getLocation')->will($this->returnValue('c:\\files\\test.zip'));

        $sut->setAdapter($mockAdapter);

        $this->assertEquals('c:\\files\\test.zip', $sut->getLocation());
    }

    public function testExtractFiles()
    {
        $sut = new Dfp_Datafeed_Archive();
        $mockAdapter = $this->getMock('Dfp_Datafeed_Archive_Adapter_Interface');
        $mockAdapter->expects($this->once())->method('extractFiles');

        $sut->setAdapter($mockAdapter);

        $sut->extractFiles();
    }

    public function testAddFile()
    {
        $sut = new Dfp_Datafeed_Archive();
        $mockAdapter = $this->getMock('Dfp_Datafeed_Archive_Adapter_Interface');
        $mockAdapter->expects($this->once())->method('addFile')
                    ->with($this->equalTo('c:\\files\\test.jpg'), $this->equalTo('test.jpg'));

        $sut->setAdapter($mockAdapter);

        $sut->addfile('c:\\files\\test.jpg', 'test.jpg');
    }

    public function testAddFiles()
    {
        $sut = $this->getMock('Dfp_Datafeed_Archive', array('addFile'));
        $sut->expects($this->at(0))->method('addFile')->with($this->equalTo('test.txt'), $this->equalTo('test.txt'));
        $sut->expects($this->at(1))->method('addFile')
            ->with($this->equalTo('file.gif'), $this->equalTo('images/file.gif'));
        $sut->expects($this->at(2))->method('addFile')
            ->with($this->equalTo('thirdfile.txt'));

        $sut->addFiles(array('test.txt','file.gif', 'thirdfile.txt'), array('test.txt', 'images/file.gif'));
    }

    public function testClose()
    {
        $sut = new Dfp_Datafeed_Archive();
        $mockAdapter = $this->getMock('Dfp_Datafeed_Archive_Adapter_Interface');
        $mockAdapter->expects($this->once())->method('close');

        $sut->setAdapter($mockAdapter);

        $sut->close();
    }
}

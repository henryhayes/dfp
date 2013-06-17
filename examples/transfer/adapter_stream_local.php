<?php
/**
 * Require the examples boostrap file.
 */
require_once(dirname(dirname(realpath(__FILE__))) . DIRECTORY_SEPARATOR . 'Bootstrap.php');

// Make a Test File
$sysTmpDir = realpath(sys_get_temp_dir());
$srcPath = $sysTmpDir . '/dfp-src';
if (!file_exists($srcPath)) {
    mkdir($srcPath, 0777, true);
}
$sourceFile = $srcPath . '/temp-dfp-source-file.txt';
//file_put_contents($sourceFile, 'Some-data');
//$sourceFile = 'file://' . $sourceFile;
echo $sourceFile . PHP_EOL;

// Get a testing destination path.
$destinationDirectory = $sysTmpDir . '/dfp-dst';
if (!file_exists($destinationDirectory)) {
    mkdir($destinationDirectory, 0777, true);
}
/**
 * Instantiate the trasfer component.
 */
$transfer = new Dfp_Datafeed_Transfer();

/**
 * Create an instance of the Stream adapter.
 */
$adapter = new Dfp_Datafeed_Transfer_Adapter_Stream();
/**
 * Set the destination directory.
 */
$adapter->setBasePath($destinationDirectory);
/**
 * Set the source stream scheme to file://.
 */
$adapter->setSchema('file');
/**
 * Get the path of the source file.
 */
$adapter->setHost(pathinfo($sourceFile, PATHINFO_DIRNAME));
/**
 * Add the adapter to the transfer compomnent.
 */
$transfer->setAdapter($adapter);
/**
 * Get the filename from the souirce file. Set the source and destination file name.
 */
$filename = pathinfo($sourceFile, PATHINFO_BASENAME);
/**
 * Transfert the file...
 */
//settype($filename1, 'string');
$transfer->retrieveFile($filename, $filename);
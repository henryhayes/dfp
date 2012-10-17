<?php
/**
 * Require the examples boostrap file.
 */
require_once(dirname(dirname(realpath(__FILE__))) . DIRECTORY_SEPARATOR . 'Bootstrap.php');

// Get the system's temp path.
$tempPath = realpath(sys_get_temp_dir());

/**
 * Start: Make a temporary file and write some data ---------------------
 */

@mkdir($tempPath . DS . 'dfp');
$tempPath .= DS . 'dfp';
echo 'Temporary File Path: ' . $tempPath . PHP_EOL;
$tmpfpath = tempnam($tempPath, "dfp");
$tmpfname = trim(str_replace($tempPath, '', $tmpfpath), DIRECTORY_SEPARATOR);
echo 'File name: ' . $tmpfname . PHP_EOL;
echo 'File path: ' . $tmpfpath . PHP_EOL;

$fp = fopen($tmpfpath, "w");
fwrite($fp, "This is some demo text.");
fclose($fp);

/**
 * End: Make a temporary file and write some data ---------------------
 */

/**
 * Start: Example ---------------------
 */

$transfer = new Dfp_Datafeed_Transfer();

$adapter = new Dfp_Datafeed_Transfer_Adapter_Ftp();
/**
 * Options can either be set using the key in this array or using setters.
 */
$adapter->setOptions(
    array(
        'username' => '<your-ftp-username>',
        'password' => '<your-ftp-password>',
        'host'     => '<your-ftp-host>',
        'timeout'  => 120,
        'basePath' => $tempPath,
        /**
         * Setting FTP adapter to passive mode makes the adapter connect. The options here are
         * set in order so that the credentials are available for this connection before the
         * "passive" setting is sent. Setting "passive" first would fail as the credentials
         * would not be present for the ftp adapter to use.
         */
        'passive'  => true,
    )
);

/**
 * Alternatively, all options can be set using setters. For example:
 *
 * @example $adapter->setBasePath($tempPath);
 * @example $adapter->setPassive(true);
 */

/**
 * Add the FTP adapter to the transfer component
 */
$transfer->setAdapter($adapter);

/**
 * Attempt to send the file. This is wrapped in a try/catch as it can throw an
 * Dfp_Datafeed_Transfer_Adapter_Exception exception. If we were in a loop of
 * files, we would want this to continue if a file transfer failed.
 */
try {
    $transfer->sendFile($tmpfname);

} catch (Dfp_Datafeed_Transfer_Adapter_Exception $e) {

    echo 'Dfp_Datafeed_Transfer_Adapter_Exception Occurred with Message: ' . $e->getMessage() . PHP_EOL;
}

/**
 * All errors are saved to an array which is accessable via the getErrors() method as shown below.
 * Even when an exception is thrown, the error is recorded. This enables you to catch the exceptions
 * and continue, then grab the errors to evaluate later.
 */
if ($transfer->hasErrors()) {
    echo 'Errors: ' . print_r($transfer->getErrors(), true) . PHP_EOL;
}
echo 'End' . PHP_EOL;

/**
 * End: Example ---------------------
 */
<?php

include_once 'lib/Common.php';
include_once 'lib/IDEbay.php';

echo 'ebay<br/>';
timeLogStart($tStart);

$iDEbay = new IDEbay();

//Run seprate function
// $iDAmz->scan_data('data/amz-list.txt');
// $iDAmz->handle_data();

//Or just one
//$iDAmz->run('data/amz-list.txt');
$iDEbay->run();

timeLogEnd($tStart);
echo '<br/> DONE!!!';
?>
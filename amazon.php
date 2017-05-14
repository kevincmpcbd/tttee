<?php

include_once 'lib/Common.php';
include_once 'lib/IDAmz.php';

echo 'AMZ<br/>';
timeLogStart($tStart);

$iDAmz = new IDAmz();

//Run seprate function
// $iDAmz->scan_data('data/amz-list.txt');
// $iDAmz->handle_data();

//Or just one
//$iDAmz->run('data/amz-list.txt');
// $iDAmz->run('data/amz-list-18.txt');
// $iDAmz->run();
$iDAmz->run('data/2ao.txt');

timeLogEnd($tStart);
echo '<br/> DONE!!!';
?>
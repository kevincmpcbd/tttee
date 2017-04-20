<?php

include_once 'lib/Common.php';
include_once 'lib/IDAmz.php';

echo 'AMZ<br/>';
timeLogStart($tStart);

$iDAmz = new IDAmz();

//Run seprate function
// $iDAmz->scan_files('data/amz-list.txt');
// $iDAmz->handle_data();

//Or just one
$iDAmz->run('data/amz-list.txt');

timeLogEnd($tStart);
echo '<br/> DONE!!!';
?>
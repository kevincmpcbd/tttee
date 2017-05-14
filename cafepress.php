<?php

include_once 'lib/Common.php';
include_once 'lib/IDCafepress.php';

echo 'Cafepress<br/>';
timeLogStart($tStart);

$iDCafepress = new IDCafepress();

//Run seprate function
// $iDCafepress->scan_data('data/amz-list.txt');
// $iDCafepress->handle_data();

//Or just one
//Image Name; ; ;Title;Category;Description;Keyword;5
$iDCafepress->output_template = '%s;Basic Tees;Black;%s;%s;%s;%s;0';

$iDCafepress->category = 'Sport';
$iDCafepress->keywords = 'softball sport kevincmpcbd';

$iDCafepress->run('data/cafepress-list.txt');
// $iDCafepress->run();

timeLogEnd($tStart);
echo '<br/> DONE!!!';
?>
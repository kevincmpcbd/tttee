<?php

include_once 'lib/Common.php';
include_once 'lib/IDSpreadshirt.php';

echo 'Spreadshirt<br/>';
timeLogStart($tStart);

$iDSpreadshirt = new IDSpreadshirt();

//Run seprate function
// $iDSpreadshirt->scan_data('data/amz-list.txt');
// $iDSpreadshirt->handle_data();

//Or just one
//Image Name; ; ;Title;Category;Description;Keyword;5
$iDSpreadshirt->ext = 'png';
$iDSpreadshirt->output_template = '%s;Basic Tees;Black;%s;%s;%s;%s;0';

$iDSpreadshirt->category = 'Sports';
$iDSpreadshirt->keywords = 'softball sport kevincmpcbd';

$iDSpreadshirt->run('data/spreadshirt-list.txt');
// $iDSpreadshirt->run();

timeLogEnd($tStart);
echo '<br/> DONE!!!';
?>
<?php

include_once 'lib/Common.php';
include_once 'lib/IDDesignbyhuman.php';

echo 'Spreadshirt<br/>';
timeLogStart($tStart);

$iDDesignbyhuman = new IDDesignbyhuman();

//Run seprate function
// $iDDesignbyhuman->scan_data('data/amz-list.txt');
// $iDDesignbyhuman->handle_data();

//Or just one
//Image Name; ; ;Title;Category;Description;Keyword;5
// $iDDesignbyhuman->file_name_is_title = true;
$iDDesignbyhuman->ext = 'png';
$iDDesignbyhuman->output_template = '%s;Basic Tees;Black;%s;%s;%s;%s;0';

$iDDesignbyhuman->category = 'Sports';
$iDDesignbyhuman->keywords = 'softball sport kevincmpcbd';

$iDDesignbyhuman->run('data/designbyhuman/father_day-20170516.txt');
// $iDDesignbyhuman->run();

timeLogEnd($tStart);
echo '<br/> DONE!!!';
?>
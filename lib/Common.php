<?php

/**
* 	@author khoatx	
*	common functions
*	@date 2017-04-20
**/

function pr($input)
{
	echo '<pre>';
	print_r($input);
	echo '</pre>';
}


function timeLogStart(&$tStart)
{
	echo date('Y-m-d H:i:s') . '<br/>';
	$tStart = microtime(true);
}

function timeLogEnd($tStart)
{
	echo date('Y-m-d H:i:s') . '<br/>';
	$tEnd = microtime(true);

	$execution_time = $tEnd - $tStart;

	$hours = (int)($execution_time/60/60);
	$minutes = (int)($execution_time/60)-$hours*60;
	$seconds = (int)$execution_time-$hours*60*60-$minutes*60;

	//execution time of the script
	echo '<b>Total Execution Time:</b> ' . "{$hours}hours {$minutes}mins {$seconds}seconds";
}
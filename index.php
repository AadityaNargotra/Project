<?php

	if(file_exists('config.tpl') && is_readable('config.tpl')) {
		require_once('config.tpl');
	}
	else
		echo "config.tpl is missing, idiot!";
	
	$routing = INCLUDES.'routing.tpl';

	if(file_exists($routing) && is_readable($routing)) {
	    date_default_timezone_set('Asia/Kolkata');
		require_once($routing);
	}
	else
		echo "routing.tpl is missing, idiot!";

?>
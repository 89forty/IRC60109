<?php
/* 	File: index.php
*	Author: Thomas Madison
*	Description: IRC60109 code sample
*/
	
	// sanitize and parse query
	$whitelist = array('request','offset','limit');
	$filtered = filter_var($_SERVER['QUERY_STRING'], FILTER_SANITIZE_STRING);
	parse_str(($filtered), $params);

	// if not specified, let offset default to zero	
	if(isset($params['offset']) == false){
		$params['offset'] = 0;
	}

	
	// if not specified, let limit default to 1000 
	if(isset($params['limit']) == false){
		$params['limit'] = 1000;
	}

	
	// die w/error if negative offset or limit specified	
	if($params['offset'] < 0 || $params['limit'] < 0){
		die("Error");
	}

	// set csv file to be opened 
	switch(strtolower($params['request'])){
		case 'items':
		$file="items.csv";    
		break;
            
		case 'person':
		$file="person.csv";    
		break;
            
		default:
		die("Error");
		}
	
	//get csv as array, isolate rows to return, then print 
	$array = array_map('str_getcsv', file($file));
	$slice = array_slice($array, $params['offset'], $params['limit']);
	$output = json_encode($slice);
	echo $output;
		
?>


<?php
/* 	File: index.php
*	Author: Thomas Madison
*	Description: IRC60109 code sample
*/
	$items_file = 'items.csv';
	$person_file = 'person.csv';
	$whitelist_params = array('request','offset','limit');
	$whitelist_request = array('items', 'person');
	
	// sanitize and parse query string as array
	$filtered = filter_var($_SERVER['QUERY_STRING'], FILTER_SANITIZE_STRING);
	parse_str(($filtered), $params);	
	
	// check input against whitelist
	if (array_keys($params) != array_intersect(array_keys($params), $whitelist_params)){
		die("Error - invalid parameter\n");
	}
	if (!in_array($params['request'], $whitelist_request)){
		die("Error - invalid request type\n");
	}

	// if not specified, let offset default to zero	
	if(isset($params['offset']) == false){
		$params['offset'] = 0;
	}
	
	// if not specified, let limit default to 1000 
	if(isset($params['limit']) == false){
		$params['limit'] = 1000;
	}
	
	// exit w/error if negative offset or limit specified	
	if($params['offset'] < 0 || $params['limit'] < 0){
		die("Error - invalid parameter value\n");
	}

	// set csv file to be opened 
	switch($params['request']){
		case 'items':
		$file = $items_file;    
		break;
            
		case 'person':
		$file= $person_file;    
		break;
            
		default:
		die("Error - invalid request type\n");
		}
	
	//get csv as array, isolate rows to return, then print 
	$array = array_map('str_getcsv', file($file));
	$slice = array_slice($array, $params['offset'], $params['limit']);
	$output = json_encode($slice);
	echo $output;
		
?>

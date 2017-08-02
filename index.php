
        <?php
        parse_str($_SERVER['QUERY_STRING'], $params);
		
		if(isset($params['limit']) == false || isset($params['offset']) == false){
			die("Error");
		}
		
		if($params['offset'] < 0 || $params['limit'] < 0){
			die("Error");
		}

        switch($params['request']){
            case "items":
            $file="items.csv";    
            break;
            
            case "person":
            $file="person.csv";    
            break;
            
            default:
            die("Error");
        }
		
		$array = array_map('str_getcsv', file($file));
		if($params['offset'] + $params['limit'] > count($array)){
			die("Error");
		}
		$slice = array_slice($array, $params['offset'], $params['limit']);

		$output = json_encode($slice);
		echo "<pre>" .$output. "<pre>";
		
        ?>


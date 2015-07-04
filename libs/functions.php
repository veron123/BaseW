<?php

//custom explode to return 0 if string is blank
function my_explode($delimiter, $string, $limit = null) {
    $array = call_user_func_array('explode', func_get_args());
    if (count($array) === 1 && strlen($array[0]) === 0) {
        return array();
    }
    return $array;
}

// FUNCTION to check if restaurant exists or not 
function restExists($table)
{
		$local_query = "SHOW TABLES LIKE '$table'";
		$db = new Db();
		$result = $db->query($local_query);
		$count = count($result);
		
		if ($count > 1)
		{
			return true ;
		}
		else 
		{
			$response = array() ;
			$response["code"] = "400";
			$response["error"] = "true" ;
			$response["message"] = "Incorrect merchant ID";
			return $response;
		}
}

?>
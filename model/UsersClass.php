<?php

require_once ('DatabaseClass.php');
require_once (__DIR__ . '/../libs/functions.php');

Class RestaurantUsers  {
	/* Attributes for a restuarant, pertaining to restX_info table 
	in the ZomatoBase3 database */
	private $userID ;
	private $userName ;
	private $password ;
	private $firstName;
	private $middleName;
	private $lastName;
	private $phone;
	private $email;
	private $isActive;
	private $photoLocation;
	
	public function getUsers($restId)
	{
	    $db = new Db();
	    $table ="rest".$restId."_users";
		
		$checkRest = restExists($table) ;
		if($checkRest != true)
			return $checkRest;
		
		$local_query = "SELECT * FROM `$table`";
		$result = $db->select($local_query);
		$userCount = count($result);
		
		$configurationTable = "rest".$restId."_userConfigurations";
		$configurationMappingTable = "rest".$restId."_userConfigurationMapping";
		$userTable = "rest".$restId."_users";
		
		$local_query = "SELECT M.`userID`,M.`configurationID`, C.`configurationName`,C.`configurationDisplayText`, C.`configurationType`, 
		C.`configurationTag`, C.`configurationValueBinary`, C.`configurationValueText`, C.`configurationValueDecimal`, C.`comments`,M.`isAllowed` FROM 
		`$configurationMappingTable` AS M INNER JOIN `$configurationTable` AS C ON `M`.`configurationID` = `C`.`configurationID`  
		ORDER BY   M.`userID`, M.`configurationID`";
		
		$resultConfiguration = $db->select($local_query);
		$configurationCount = count($resultConfiguration);
		
		
		
		for ($i = 0; $i < $userCount; $i++) {
		$result[$i]['Permissions'] = array();			
			for ($j = 0; $j < $configurationCount; $j++) {
				
				
					if($result[$i]['ID'] == $resultConfiguration[$j]['userID'])
					{
						array_push($result[$i]['Permissions'],$resultConfiguration[$j]);
						
					}
			}		
		}
		
		for ($i = 0; $i < $userCount; $i++) {			
			for ($j = 0; $j <= count($result[$i]['Permissions']); $j++) {
		
		unset($result[$i]['Permissions'][$j]['userID']);
		}
		}
		
		$response = array();
		$response["Users"] = ($result);
				
		return $response ;

	}
	
	
}
/* End of Restaurant Class */
?>


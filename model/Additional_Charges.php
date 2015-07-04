<?php
///////////////    ADDITIONAL CHARGES CLASS          //////////////////////////////
require_once ('DatabaseClass.php');
require_once ('ResturantClass.php');




Class AdditionalCharges extends Restaurant {
	
	private $addChargeID ;
	private $addChargeAccTypeID ;
	private $addChargeAccID ;
	private $addChargeAccName ;
	private $appliedOnLevel ;
	private $name ;
	private $nameOnBill ;
	private $chargeType ;
	private $value;
	private $taxIDs ;
	private $isActive ;

	// FUNCTION to check if restaurant exists or not
	public function restExists($table)
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
			$response["error"] = "Restaurant ID is incorrect" ;
			return $response;
		}
}


    // FUCTION to GET additional charges list pertaining to a restaurant ID
	public function getAC($restId)
	{
		$table = "rest".$restId."_additionalCharges";
		$checkRest = restExists($table) ;
		if($checkRest)
		{
		$local_query ="SELECT * FROM `$table` ";
		$db = new Db();
		$resultArray = $db->select($local_query);
		if($resultArray != false)
		{
		$endArray["AdditionalCharges"] = $resultArray;
		return $endArray;
	}
	else 
	{
		$response = array() ; 
		$response["error"] = "Restaurant ID is correct.No Reference to the information." ;
		return $response ;
	}
	}
	else
	{
      return $checkRest ;
	}
}
///////////////    END OF CUSTOMER CLASS          //////////////////////////////
}
?>
<?php ///////////////    TEST DATA          ////////////////////////////// ?>
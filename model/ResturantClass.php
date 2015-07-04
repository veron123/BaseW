<?php
///////////////    RESTAURANT CLASS          //////////////////////////////
require_once ('DatabaseClass.php');
require_once (__DIR__ . '/../libs/functions.php');

Class Restaurant  {
	private $restName ;
	private $restId ;
	private $shortCode ;
	private $companyName;
	private $TIN;
	private $CIN;
	private $serviceTaxName;
	private $currencyCode;
	private $currency;
	private $currencyOnBill;
	private $brandPhone;
	private $brandEmail;
	private $regAddLine1;
	private $regAddLine2;
    private $regAddCity;
	private $regAddState;
	private $regAddCountry;
	private $regAddPincode;
	private $outletAddLine1;
	private $outletAddLine2;
	private $outletAddCity;
	private $outletAddState;
	private $outletAddCountry;
	private $outletAddPincode;
	private $outletPhone;
	private $outletEmail;
	private $managerName;
	private $managerPhone;
	private $startDateUTC;
	private $startDateLocal;
	private $endDateUTC;
	private $endDateLocal;
	private $timezone;
	private $registeredPhone;
	private $registeredEmail;
	private $password;
	private $isActive;
	
	
	public function getRestaurantData($restId)
	{
	    $db = new Db();
	    $table ="rest".$restId."_info";
	    $checkRest = restExists($table) ;
		if($checkRest)
		{
		$local_query = "SELECT * FROM `$table` WHERE restaurantID = '$restId' ";
		$result = $db->select($local_query);
		return $result ;
	}
	else
	{
		return $checkRest ;
	}
}
	
	public function getRestaurantName($restId)
	{
		$db = new Db();
		$table ="rest".$restId."_info";
		$checkRest = restExists($table) ;
		if($checkRest)
		{
		$local_query = "SELECT `restaurantName` FROM `$table` WHERE restaurantID = '$restId' ";
		$result = $db->select($local_query);
		return $result ;
	}
	else
	{
		return $checkRest ;
	}
}
	

	public function getMerchantAddress($restId)
	{
		$db = new Db();
		$table ="rest".$restId."_info";
		$checkRest = restExists($table) ;
		if($checkRest != true)
			return $checkRest;


		$local_query ="SELECT `regAddLine1`, `regAddLine2`,
		 `regAddCity`, `regAddState`, `regAddCountry`, `regAddPincode`, `outletAddLine1`,
		 `outletAddLine2`, `outletAddCity`, `outletAddState`, `outletAddCountry`,
		  `outletAddPincode`, `outletPhone`, `outletEmail` FROM `$table` WHERE restaurantID ='$restId' ";
		$data = $db->select($local_query);
		return $data;		
}
	// GET OPENING TIMINGS
	public function getOpeningTimes($restId)
	{
		$db = new Db();
	    $table ="rest".$restId."_info";
	    $checkRest = restExists($table) ;
	    if($checkRest != true)
			return $checkRest;
		$local_query = "SELECT openingHoursUTc,openingHoursLocal FROM `$table` WHERE restaurantID = '$restId' ";
		$result = $db->select($local_query);
		return $result ;
}
	
// GET CLOSING TIMINGS
	public function getClosingTimes($restId)
	{
		$db = new Db();
	    $table ="rest".$restId."_info";
	    $checkRest = restExists($table) ;
	    if($checkRest != true)
			return $checkRest;
		$local_query = "SELECT closingHoursUTc,closingHoursLocal FROM `$table` WHERE restaurantID = '$restId' ";
		$result = $db->select($local_query);
		return $result ;
}
	
// GET OFFICIAL TIMINGS
	public function getOfficialTime($restId)
	{
		$db = new Db();
	    $table ="rest".$restId."_info";
	    $checkRest = restExists($table) ;
	    if($checkRest != true)
			return $checkRest;
		$local_query = "SELECT openingHoursUTc,openingHoursLocal,closingHoursUTc,closingHoursLocal FROM `$table` WHERE restaurantID = '$restId' ";
		$result = $db->select($local_query);
	    return $result ;
}
}
///////////////    END OF RESTAURANT CLASS          //////////////////////////////
?>
<?php

// Test Code for GET Request Made to the Restaurant API
/*
$object = new Restaurant;
//$data1 = $object->getRestaurantData(1);
$object->getOfficialTimes(1);
*/



// Test code for POST Request Made to the Restaurant API s
/*
$input_json = "{\"restaurantName\": \"Vodka\",\"shortCode\": \"ITA1\",\"companyName\": \"MeHospitality Pvt. Ltd.\",\"TIN\": 90445620,\"CIN\": \"L2009PT196714\",\"serviceTaxNum\": \"AA80BSD002\",\"currencyCode\": \"NR\",\"currency\": \"IndiaRupees\",\"currencyOnBill\": \"Rs\",\"brandPhone\": \"99418345312\",\"brandEmail\": \"dback@pitapit.in\",\"regAddLine1\": \"Sai Upasana Bld ZerRoad\",\"regAddLine2\": \"Silver Frm Road\",\"regAddCity\": \"Dlhi\",\"regAddState\": \"elhi\",\"regAddCountry\": \"Idia\",\"regAddPincode\": 1140030,\"outletAddLine1\": \"mSQARE, Select CitywaMall\",\"outletAddLine2\": \"Atrict Center, Saket\",\"outletAddCity\": \"Dlhi\",\"outletAddState\": \"Dhi\",\"outletAddCountry\": \"Inia\",\"outletAddPincode\": 1140017,\"outletPhone\": 9765443210,\"outletEmail\": \"\",\"managerName\": \"mit\",\"managerPhone\": 983426543210,\"startDateUTC\": \"2015-05-01 03:00:00\",\"startDateLocal\":\"0400-10-00 00:00:00\",\"endDateUTC\": \"0000-00-00 00:00:00\",\"endDateLocal\": \"0000-00-00 00:00:00\",\"timezone\": \"\",\"registeredPhone\": \"\",\"registeredEmail\": \"\",\"password\": \"\",\"isActive\": 1}";
$object = new Restaurant;
$object->createRestaurant($input_json);
*/
// Test code for PUT Request Made to the Restaurant API s 
/*
$input_json = "{\"restaurantID\": 1,\"restaurantName\": \"Vodka\",\"shortCode\": \"ITA1\",\"companyName\": \"MeHospitality Pvt. Ltd.\"}";
$object = new Restaurant;
$object->updateRestaurant($input_json,1);
*/

//Test code for DELETE Request Made to the Restaurant APIs
/*
$object = new Restaurant;
$object->deleteRestaurant(1);
*/
?>

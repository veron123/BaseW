<?php
///////////////    CUSTOMER CLASS          //////////////////////////////
require_once ('DatabaseClass.php');
require_once ('ResturantClass.php');
require_once (__DIR__ . '/../libs/functions.php');


Class Customers extends Restaurant {
	
	private $ID ;
	private $customerID ;
	private $category ;
	private $salutation ;
	private $firstName ;
	private $middleName ;
	private $lastName ;
	private $DOB ;
	private $gender ;
	private $phone ;
	private $email ;
	private $addressLine1 ;
	private $addressLine2 ;
	private $city ;
	private $state ;
	private $country;
	private $pincode;
	private $nationality;
	private $allowCreditSales ;
	private $creditLimit ;
	private $creditExhausted ;
	private $advanceDeposit ;
	private $loyaltyPoints ;
	private $redeemedPoints ;
	private $balancePoints ;
	private $anniversary ;
	private $spouseName ;
	private $photoLoc1 ;
	private $photoLoc2;
	private $lastOrderID ;
	private $lastRestaurantID ;
	private $lastSpent ;
	private $totalSpent ;
	private $createdOnUTC ;
	private $createdOnLocal ;
	private $timezone ;
	private $remarks ;
	private $systemRemarks ;
	private $isActive ;
	

	// FUNCTION to convery Array to CSV
   private function array2c($array) {
    $csv = array();
    foreach ($array as $item) {
        if (is_array($item)) {
            $csv[] = $this->array2c($item);
        } else {
            $csv[] = $item;
        }
    }
    return implode(',', $csv);
}


	// FUCTION to GET customer list pertaining to a restaurant ID 
	public function getCustomers($restId)
	{
		$db = new Db();
		$table ="rest".$restId."_customers";
		$checkRest = restExists($table) ;
		if($checkRest)
		{
		$local_query = "SELECT * FROM `$table`";
		$result = $db->select($local_query);
		$final = array();
		$final["Customers"] = $result ;
 		return $final ;
	}
	else
	{
      return $checkRest ;
	}
}
	// FUNCTION to GET customer by customer ID and restaurant ID
	public function getCustomerById($restId,$custID)
	{
		$db = new Db();
		$table ="rest".$restId."_customers";
		$checkRest = restExists($table) ;
		if($checkRest)
		{
		$local_query = "SELECT * FROM `$table` WHERE customerID = '$custID' ";;
		$result = $db->select($local_query);
		$final = array();
		$final["Customer"] = $result ;
		return $final;
	}
	else
	{
      return $checkRest ;
	}		
}
	// FUNCTION to GET customer data in CSV pertaining to a restaurant ID
	public function getCustomersCSV($restId)
	{
		$db = new Db();
		$table ="rest".$restId."_customers";
		$checkRest = restExists($table) ;
		if($checkRest)
		{
		$local_query = "SELECT * FROM `$table`";
		$result = $db->select($local_query);
		$final = array();
		$final = $this->array2c($result);
		return $final;
	}
	else
	{
      return $checkRest ;
	}
}
	
	// FUNCTION to GET customer categories pertaining to a restaurant ID
	public function getCustCategory($restId)
	{
		$db = new Db();
		$table ="rest".$restId."_customerCategory";
		$checkRest = restExists($table) ;
		if($checkRest)
		{
		$local_query = "SELECT * FROM `$table`";
		$result = $db->select($local_query);
		return $result;
	}
	else
	{
      return $checkRest ;
	}
}
	

	// FUNCTION to POST : INSERT customer pertaining to a restaurant ID
	public function postCust($restId,$request)
	{   $db = new Db();
		$data = json_decode($request,true);
		$table ="rest".$restId."_customers";
        $checkRest = restExists($table) ;
		if($checkRest)
		{
		$category =$data["category"] ;
		$salutation=$data["salutation"];
		$firstName=$data["firstName"];
		$middleName=$data["middleName"];
		$lastName=$data["lastName"] ;
		$DOB=$data["DOB"];
		$gender = $data["gender"] ;
		$phone = $data["phone"] ;
		$email =$data["email"];
		$addressLine1 = $data["addressLine1"] ;
		$addressLine2 =$data["addressLine2"];
		$city= $data["city"];
		$state = $data["state"];
		$country =$data["country"] ;
		$pincode =$data["pincode"];
		$nationality = $data["nationality"];
		$allowCreditSales =$data["allowCreditSales"];
		$creditLimit=$data["creditLimit"];
		$creditExhausted=$data["creditExhausted"];
		$advanceDeposit = $data["advanceDeposit"];
		$loyaltyPoints=$data["loyaltyPoints"];
		$redeemedPoints=$data["redeemedPoints"];
		$balancePoints =$data["balancePoints"];
		$anniversary=$data["anniversary"];
		$spouseName=$data["spouseName"];
		$photoLoc1 = $data["photoLoc1"];
		$photoLoc2 = $data["photoLoc2"];
		$lastOrderID = $data["lastOrderID"];
		$lastSpent = $data["lastSpent"];
		$totalSpent=$data["totalSpent"];
		$createdOnUTC = $data["createdOnUTC"];
		$createdOnLocal = $data["createdOnLocal"];
		$timezone=$data["timezone"];
		$remarks =$data["remarks"];
		$systemRemarks =$data["systemRemarks"];
		$isActive =$data["isActive"];
		
		$local_query = "INSERT INTO `$table` (`category`, `salutation`, `firstName`, 
		`middleName`, `lastName`, `DOB`, `gender`, `phone`, `email`, `addressLine1`, `addressLine2`, 
		`city`, `state`, `country`, `pincode`, `nationality`, `allowCreditSales`, `creditLimit`, `creditExhausted`,
		`advanceDeposit`, `loyaltyPoints`, `redeemedPoints`, `balancePoints`, `anniversary`, `spouseName`, `photoLoc1`, `photoLoc2`, `lastOrderID`,
		`lastSpent`, `totalSpent`, `createdOnUTC`, `createdOnLocal`,
		`timezone`, `remarks`, `systemRemarks`, `isActive`) 
		VALUES ('$category', '$salutation', '$firstName', '$middleName', '$lastName', '$DOB', '$gender', '$phone', '$email',
		'$addressLine1', '$addressLine2', '$city', '$state', '$country', '$pincode', '$nationality', '$allowCreditSales', '$creditLimit',
		'$creditExhausted','$advanceDeposit', '$loyaltyPoints', '$redeemedPoints', '$balancePoints', '$anniversary', '$spouseName', 
		'$photoLoc1', '$photoLoc2', '$lastOrderID','$lastSpent', '$totalSpent', '$createdOnUTC', '$createdOnLocal',
		'$timezone', '$remarks', '$systemRemarks', '$isActive')";
		

		// echo $local_query;
	
	$result = $db-> query($local_query);
	if($result == false)
	{ 
		 return "FAILED";
	}
	else 
	{
		return "SUCCESS";
	}
    }
    else
    {
	return $checkRest;
    }		
}

    // FUNCTION to POST : UPDATE customer pertaining to a restaurant ID and customer ID 
    public function putCust($restId,$input_json, $custId)
    {   
	$db = new Db();
	$data = json_decode($input_json,true);
	$table ="rest".$restId."_customers";
	$checkRest = restExists($table) ;
	if($checkRest)
	{
    foreach($data as $key => $value)
    { 
	if($key!="customerID")
	{
	$local_query="UPDATE `$table` SET $key='$value' WHERE customerID = '$custId';";
	// echo $local_query;
	$result = $db-> query($local_query);
	if($result == false)
	{ 
		 return "FAILED!";
	}
	else 
	{
		return "DONE!";
	}
	
	}
    }
    }
    else 
    {
	return $checkRest ;
    }	
}

    // FUNCTION to DELETE : DELETE customer pertaining to a restaurant ID and customer ID 
    public function deleteCustomer($restId,$custId)
    {
    $db = new Db();
    $table ="rest".$restId."_customers";
    $checkRest = restExists($table) ;
	if($checkRest)
	{
	$local_query="UPDATE `$table` SET isActive=0 WHERE customerID = '$custId';";
    $result = $db-> query($local_query);
	if($result == false)
	{ 
		 echo "FAILED!";
	}
	else 
	{
		echo "DONE!";
	}
    }
    else
    {
    	return $checkRest;
    }	
}
///////////////    PHONE DETAILS PERTAINING TO A CUSTOMER          //////////////////////////////

    // FUNCTION to GET customer phone pertaining to a restaurant ID and customer ID  
    public function getCustomerPhoneNumber($restId,$custId)
	{
		$db = new Db();
		$table ="rest".$restId."_customers";
		$checkRest = restExists($table) ;
		if($checkRest)
		{
		$local_query = "SELECT phone FROM `$table` WHERE customerID = '$custId' ";;
		$result = $db->select($local_query);
		$final = array();
		$final["CustomerPhone"] = $result ;
		return $final;
	}
	else
	{
		return $checkRest;
		
	}
}
	
    // FUNCTION to POST : UPDATE customer phone details pertaining to a restaurant ID and customer ID 
    public function putCustomerPhone($restId,$custId,$phoneNumber)
    {
    $db = new Db();
    $table ="rest".$restId."_customers";
    $checkRest = restExists($table) ;
	if($checkRest)
	{
	$local_query="UPDATE `$table` SET phone='$phoneNumber' WHERE customerID = '$custId';";
    $result = $db-> query($local_query);
	if($result == false)
	{ 
		 return "FAILED!";
	}
	else 
	{
		return "DONE!";
	}
    }
    else 
    {
	return $checkRest ;
    }	
}

    // FUNCTION to DELETE : DELETE customer pertaining to a restaurant ID and customer ID 
    public function deleteCustomerPhone($restId,$custId)
    {
    $db = new Db();
    $table ="rest".$restId."_customers";
    $checkRest = restExists($table) ;
	if($checkRest)
	{
	$local_query="UPDATE `$table` SET phone='' WHERE customerID = '$custId';";
    $result = $db-> query($local_query);
	if($result == false)
	{ 
		 return "FAILED!";
	}
	else 
	{
		return "DELETED!";
	}
    }
    else
    {
	return $checkRest;
    }	
}

///////////////    EMAIL DETAILS PERTAINING TO A CUSTOMER          //////////////////////////////

    // FUNCTION to GET customer email pertaining to a restaurant ID and customer ID
    public function getCustomerEmail($restId,$custId)
	{
		$db = new Db();
		$table ="rest".$restId."_customers";
		$checkRest = restExists($table) ;
		if($checkRest)
		{
		$local_query = "SELECT email FROM `$table` WHERE customerID = '$custId' ";;
		$result = $db->select($local_query);
		$final = array();
		$final["CustomerEmail"] = $result ;
		return $final;
	}
	else
	{
		return $checkRest;
	}
}
	
	// FUNCTION to POST : UPDATE customer phone details pertaining to a restaurant ID and customer ID
    public function putCustomerEmail($restId,$custId,$email)
    {
    $db = new Db();
    $table ="rest".$restId."_customers";
    $checkRest = restExists($table) ;
	if($checkRest)
	{
	$local_query="UPDATE `$table` SET email='$email' WHERE customerID = '$custId';";
    $result = $db-> query($local_query);
	if($result == false)
	{ 
		 return "FAILED!";
	}
	else 
	{
		return "DONE!";
	}
    }
    else
    {
	return $checkRest;
    }
}

    // FUNCTION to DELETE : DELETE customer phone details pertaining to a restaurant ID and customer ID
    public function deleteEmail($restId,$custId)
    {
    $db = new Db();
    $table ="rest".$restId."_customers";
    $checkRest = restExists($table) ;
	if($checkRest)
	{
	$local_query="UPDATE `$table` SET email='' WHERE customerID = '$custId';";
    $result = $db-> query($local_query);
	if($result == false)
	{ 
		 return "FAILED!";
	}
	else 
	{
		return "DELETED!";
	}
    }
    else
    {
	return $checkRest;
    }	
}

///////////////    ADDRESS DETAILS PERTAINING TO A CUSTOMER          //////////////////////////////

    // FUNCTION to GET customer address details pertaining to a restaurant ID and customer ID
    public function getCustomerAddress($restId,$custId)
	{
		$db = new Db();
		$table ="rest".$restId."_customers";
		$checkRest = restExists($table) ;
		if($checkRest)
		{
		$local_query = "SELECT `addressLine1`, `addressLine2`, `city`, `state`, `country`, `pincode` FROM `$table` WHERE customerID = '$custId' ";;
		$result = $db->select($local_query);
		return $result ;
	}
	else
	{
		return $checkRest;
	}
}
	
	
	
    // FUNCTION to POST : UPDATE customer phone details pertaining to a restaurant ID and customer ID
    public function putCustomerAddress($restId,$input_json, $custId)
    {   
	$db = new Db();
	$table ="rest".$restId."_customers";
	$checkRest = restExists($table) ;
	if($checkRest)
	{
    $data = json_decode($input_json,true);
    foreach($data as $key => $value)
    { 
	if($key!="customerID")
	{
	$local_query="UPDATE `$table` SET $key='$value' WHERE customerID = '$custId';";
	// echo $local_query;
	$result = $db-> query($local_query);
	if($result == false)
	{ 
		 echo "FAILED!";
	}
	else 
	{
		echo "DONE!";
	}
	}
    }
    }
    else
    {
 	return $checkRest;
    }	
}

    // FUNCTION to DELETE : DELETE customer phone details pertaining to a restaurant ID and customer ID
    public function deleteCustomerAddress($restId,$custId)
    {
    $db = new Db();
    $table ="rest".$restId."_customers";
    $checkRest = restExists($table) ;
	if($checkRest)
	{
	$input_json="{\"addressLine1\":\"\",\"addressLine2\":\"\",\"city\":\"Glasgfrfrfow Village\",\"state\":\"\",\"country\":\"\",\"pincode\":\"199444\"}";
    $data = json_decode($input_json,true);
    foreach($data as $key => $value)
    { 
	if($key == "pincode")
	{
	$local_query="UPDATE `$table` SET `$key`= 0 WHERE customerID = '$custId';";
	echo $local_query;
	// echo $local_query;
	$result = $db-> query($local_query);
	if($result == false)
	{ 
		 echo "FAILED!";
	}
	else 
	{
		echo "DONE!";
	}
	}
	else if($key!="customerID")
	{
	$local_query="UPDATE `$table` SET `$key`=\"\" WHERE customerID = '$custId';";
	echo $local_query;
	// echo $local_query;
	$result = $db-> query($local_query);
	if($result == false)
	{ 
		 echo "FAILED!";
	}
	else 
	{
		echo "DELETED!";
	}
	}
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

<?php 
/* HOW TO POST CUSTOMERS IN THE API !
 * 
$object = new Customers() ;
// $object->getCustomers() ;
JSON FORMAT FOR POST 
$jsonData = "{\"category\":\"3\",\"salutation\":\"Mr\",\"firstName\":\"rtgtry\",\"middleName\":\"\",\"lastName\":\"Arcgftgleta\",\"DOB\":\"2001-05-25\",\"gender\":\"Male\",\"phone\":\"6973493610\",\"email\":\"BarryArclfrfeta@gmail.com\",\"addressLine1\":\"\",\"addressLine2\":\"\",\"city\":\"Glasgfrfrfow Village\",\"state\":\"\",\"country\":\"\",\"pincode\":\"199444\",\"nationality\":\"United Sfrftates\",\"allowCreditSales\":\"1\",\"creditLimit\":\"4910.0000\",\"creditExhausted\":\"0.0000\",\"advanceDeposit\":\"0.0000\",\"loyaltyPoints\":\"479\",\"redeemedPoints\":\"479\",\"balancePoints\":\"0\",\"anniversary\":\"2004-09-26\",\"spouseName\":\"\",\"photoLoc1\":\"\",\"photoLoc2\":\"\",\"lastOrderID\":\"ORDER\/2015-06-08\/2\",\"lastRestaurantID\":\"1\",\"lastSpent\":\"659.0000\",\"totalSpent\":\"5331.0000\",\"createdOnUTC\":\"2015-06-09 05:30:00\",\"createdOnLocal\":\"2015-06-09 11:00:00\",\"timezone\":\"PST\",\"remarks\":\"\",\"systemRemarks\":\"\",\"isActive\":\"1\"} ";

$object->postCustomer($jsonData);
*/

/* HOW TO PUT CUSTOMERS IN THE API ! 
$object = new Customers();
$jsonData = "{\"category\":\"5\",\"salutation\":\"Mr\",\"firstName\":\"234xcwertgtry\",\"middleName\":\"dedede\",\"lastName\":\"A343rcgftgleta\",\"DOB\":\"2001-05-25\",\"gender\":\"Female\",\"phone\":\"6973493610\",\"email\":\"BarryArclfrfeta@gmail.com\",\"addressLine1\":\"\",\"addressLine2\":\"\",\"city\":\"Glasgfrfrfow Village\",\"state\":\"\",\"country\":\"\",\"pincode\":\"199444\",\"nationality\":\"United Sfrftates\"}";
$object->putCustomer($jsonData,224);
*/
// HOW TO DELETE CUSTOMERS IN THE API
/*
$object = new Customers();
$object->getCustomerEmail(2);
*/
/* 
$object = new Customers();
$object->deleteCustomerAddress(2);
 */
?>
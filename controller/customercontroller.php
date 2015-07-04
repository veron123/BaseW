<?php
// require_once('CustomerClass.php');

if(  !class_exists('Customer') ) {
    require_once(__DIR__ . '/../model/CustomerClass.php');
}

if(  !class_exists('Restaurant') ) {
    require_once (__DIR__ . '/../model/ResturantClass.php');
}

if(  !class_exists('Db') ) {
    require_once(__DIR__ . '/../model/DatabaseClass.php');
}
if(  !class_exists('Orders') ) {
    require_once(__DIR__ . '/../model/OrdersClass.php');
}

Class CustomerController {


public function checkDetails($request)
{
	$apiKey = $request["apiKey"];
	$restId = $request["restaurantID"];
	
	$response = array();
	$db = new Db();
    $local_query="SELECT * FROM users WHERE apiKey='$apiKey' AND restaurantID = '$restId'; ";
    $user = $db->select($local_query);
    if (!empty($user)) {
                    return true;
                } 
               else {
               	$response = array();
               	$response["code"] = 401;
               	$response["error"] = "Access Denied" ;
                return $response;
            }	
}

public function getOrder($request)
{
	$check = $this->checkDetails($request) ;
	if($check)
	{
		$order = new Orders();
		$array = $order->getOrder($request["restaurantID"],$request["orderID"]);
		return $array;
	}
	else
	{
		return $check ;
	}
}

public function getOrderProducts($request)
{
	$check = $this->checkDetails($request) ;
	if($check)
	{
		$order = new Orders();
		$array = $order->getOrderProducts($request["restaurantID"],$request["orderID"]);
		return $array;
	}
	else
	{
		return $check ;
	}
}

// GET All Customers and their details pertaining to a particular restaurant
public function getAllCustomers($request)
{
	$check = $this->checkDetails($request) ;
	if($check)
	{
		$customersObject = new Customers();
		$array = $customersObject->getCustomers($request["restaurantID"]);
		return $array;
	}
	else
	{
		return $check ;
	}	
}

// GET Customer by his Id and by the restaurant ID 
public function getCustomers($request)
{
	$check = $this->checkDetails($request) ;
	if($check)
	{
		$customersObject = new Customers();
		$array = $customersObject->getCustomerById($request["restaurantID"],$request["customerID"]);
		return $array;
	}
	else
	{
		return $check ;
	}
	
}
// GET CUSTOMERS in CSV by RESTAURANT ID
public function getCSV($request)
{
	$check = $this->checkDetails($request) ;
	if($check)
	{
		$customersObject = new Customers();
		$array = $customersObject->getCustomersCSV($request["restaurantID"]);
		return $array;
	}
	else
	{
		return $check ;
	}
}

// GET CATEGORIES OF A CUSTOMERS by RESTAURANT ID 
public function getCategory($request)
{
	$check = $this->checkDetails($request) ;
	if($check)
	{
		$customersObject = new Customers();
		$array = $customersObject->getCustCategory($request["restaurantID"]);
		return $array;
	}
	else
	{
		return $check ;
	}
}
// GET PHONE NUMBER for CUSTOMER -> RESTAURANT ID 
public function getCustomerPhone($request)
{
	$check = $this->checkDetails($request) ;
	if($check)
	{
		$customersObject = new Customers();
		$array = $customersObject->getCustomerPhoneNumber($request["restaurantID"],$request["customerID"]);
		return $array;
	}
	else
	{
		return $check ;
	}
}

// GET EMAIL for CUSTOMER -> RESTAURANT ID 
public function getMail($request)
{
	$check = $this->checkDetails($request) ;
	if($check)
	{
		$customersObject = new Customers();
		$array = $customersObject->getCustomerEmail($request["restaurantID"],$request["customerID"]);
		return $array;
	}
	else
	{
		return $check ;
	}
}
// GET ADDRESS for CUSTOMER -> RESTAURANT ID
public function getAddress($request)
{
	$check = $this->checkDetails($request) ;
	if($check)
	{
		$customersObject = new Customers();
		$array = $customersObject->getCustomerAddress($request["restaurantID"],$request["customerID"]);
		return $array;
	}
	else
	{
		return $check ;
	}
	
}

/* POST REQUESTS FOR CUSTOMERS
 * Exact JSON format for POST to Work {"category":"5","salutation":"Mr","firstName":"Dododrtbiukbugtry","middleName":"","lastName":"dodoArcgsdftgla","DOB":"2031-05-25","gender":"Female","phone":"006676973610","email":"BarryArclfrfeta@gmail.com","addressLine1":"efqwef","addressLine2":"fqwefq3fq3","city":"Glasgfrfrfow Village","state":"dfqeq","country":"","pincode":"199444","nationality":"United Sfrftate","allowCreditSales":"1","creditLimit":"4910.0000","creditExhausted":"0.0000","advanceDeposit":"0.0000","loyaltyPoints":"479","redeemedPoints":"479","balancePoints":"0","anniversary":"2004-09-26","spouseName":"","photoLoc1":"","photoLoc2":"","lastOrderID":"ORDER\/2015-06-08\/2","lastSpent":"659.0000","totalSpent":"5331.0000","createdOnUTC":"2015-06-09 05:30:00","createdOnLocal":"2015-06-09 11:00:00","timezone":"PST","remarks":"","systemRemarks":"","isActive":"1"}
   No Quotes before/after {} for the json to work properly for insert 
 */
public function postCustomer($request)
{
	$check = $this->checkDetails($request) ;
	if($check)
	{
		$customersObject = new Customers();
		$array = $customersObject->postCust($request["restaurantID"],$request["dataJSON"]);
		return $array;
	}
	else
	{
		return $check ;
	}
}
// UPDATE CUSTOMER DATA
public function putCustomer($request)
{
	$check = $this->checkDetails($request) ;
	if($check)
	{
		$customersObject = new Customers();
		$array = $customersObject->putCust($request["restaurantID"],$request["dataJSON"],$request["customerID"]);
		return $array;
	}
	else
	{
		return $check ;
	}
}

// UPDATE CUSTOMER PHONE NUMBER 
public function postCustomerPh($request)
{
	$check = $this->checkDetails($request) ;
	if($check)
	{
		$customersObject = new Customers();
		$array = $customersObject->putCustomerPhone($request["restaurantID"],$request["customerID"],$request["phone"]);
		return $array;
	}
	else
	{
		return $check ;
	}
	
}
// UPDATE CUSTOMER EMAIL
public function postCustomerEmail($request)
{
	$check = $this->checkDetails($request) ;
	if($check)
	{
		$customersObject = new Customers();
		$array = $customersObject->putCustomerEmail($request["restaurantID"],$request["customerID"],$request["email"]);
		return $array;
	}
	else
	{
		return $check ;
	}
}
// DELETE CUSTOMER PHONE NUMBER 
public function resetCustomerPh($request)
{
	$check = $this->checkDetails($request) ;
	if($check)
	{
		$customersObject = new Customers();
		$array = $customersObject->deleteCustomerPhone($request["restaurantID"],$request["customerID"]);
		return $array;
	}
	else
	{
		return $check ;
	}
}
// DELETE EMAIL OF A CUSTOMER
public function resetCustomerEmail($request)
{
	$check = $this->checkDetails($request) ;
	if($check)
	{
		$customersObject = new Customers();
		$array = $customersObject->deleteEmail($request["restaurantID"],$request["customerID"]);
		return $array;
	}
	else
	{
		return $check ;
	}
}
}
 
?>
<?php 
/* Test Code for obtaining all Customer details for a resturant  
$object = new CustomerController();
$request = array();
$request["restaurantID"]= 1 ;
$request["apiKey"]="7749b19667964b87a3efc739e254ada2";
$tempResp = $object->getAllCustomers($request);
$response = json_encode($tempResp);
echo $response;
*/

/* Test code for obtaining customer details by customer ID and restaurant ID 
$object = new CustomerController();
$request = array();
$request["restaurantID"]= 1 ;
$request["customerID"]= 3 ;
$request["apiKey"]="7749b19667964b87a3efc739e254ada2";
$tempResp = $object->getCustomers($request);
$response = json_encode($tempResp);
echo $response;
*/

/* Test code for obtaining customer phone number details by customer ID and restaurant ID 
$object = new CustomerController();
$request = array();
$request["restaurantID"]= 1 ;
$request["customerID"]= 3 ;
$request["apiKey"]="7749b19667964b87a3efc739e254ada2";
$tempResp = $object->getCustomerPhone($request);
$response = json_encode($tempResp);
echo $response;
*/

/* Test code for obtaining customer mail details by customer ID and restaurant ID 
$object = new CustomerController();
$request = array();
$request["restaurantID"]= 1 ;
$request["customerID"]= 3 ;
$request["apiKey"]="7749b19667964b87a3efc739e254ada2";
$tempResp = $object->getMail($request);
$response = json_encode($tempResp);
echo $response;
*/

/* Test code for obtaining customer address details by customer ID and restaurant ID 
$object = new CustomerController();
$request = array();
$request["restaurantID"]= 1 ;
$request["customerID"]= 3 ;
$request["apiKey"]="7749b19667964b87a3efc739e254ada2";
$tempResp = $object->getAddress($request);
$response = json_encode($tempResp);
echo $response;
*/



/* Test Code for obtaining all Customer details for a resturant  in CSV
$object = new CustomerController();
$request = array();
$request["restaurantID"]= 1 ;
$request["apiKey"]="7749b19667964b87a3efc739e254ada2";
$tempResp = $object->getCSV($request);
print_r($tempResp);
*/
/* Test Code for obtaining all Customer Categories wrt Restaurant 
$object = new CustomerController();
$request = array();
$request["restaurantID"]= 1 ;
$request["apiKey"]="7749b19667964b87a3efc739e254ada2";
$tempResp = $object->getCategory($request);
$response = json_encode($tempResp);
echo $response;
*/

/* Test Code for POST request 
$object = new CustomerController();
$request = array();
$request["restaurantID"]= 1 ;
$request["apiKey"]="7749b19667964b87a3efc739e254ada2";
$request["dataJSon"]="{\"category\":\"5\",\"salutation\":\"Mr\",\"firstName\":\"Dododrtbiukbugtry\",\"middleName\":\"\",\"lastName\":\"dodoArcgsdftgla\",\"DOB\":\"2031-05-25\",\"gender\":\"Female\",\"phone\":\"006676973610\",\"email\":\"BarryArclfrfeta@gmail.com\",\"addressLine1\":\"efqwef\",\"addressLine2\":\"fqwefq3fq3\",\"city\":\"Glasgfrfrfow Village\",\"state\":\"dfqeq\",\"country\":\"\",\"pincode\":\"199444\",\"nationality\":\"United Sfrftates\",\"allowCreditSales\":\"1\",\"creditLimit\":\"4910.0000\",\"creditExhausted\":\"0.0000\",\"advanceDeposit\":\"0.0000\",\"loyaltyPoints\":\"479\",\"redeemedPoints\":\"479\",\"balancePoints\":\"0\",\"anniversary\":\"2004-09-26\",\"spouseName\":\"\",\"photoLoc1\":\"\",\"photoLoc2\":\"\",\"lastOrderID\":\"ORDER\/2015-06-08\/2\",\"lastSpent\":\"659.0000\",\"totalSpent\":\"5331.0000\",\"createdOnUTC\":\"2015-06-09 05:30:00\",\"createdOnLocal\":\"2015-06-09 11:00:00\",\"timezone\":\"PST\",\"remarks\":\"\",\"systemRemarks\":\"\",\"isActive\":\"1\"}";
$tempResp = $object->postCustomer($request);
$response = json_encode($tempResp);
echo $response;
*/


/* Test Code for PUT request 
$object = new CustomerController();
$request = array();
$request["restaurantID"]= 1 ;
$request["apiKey"]="7749b19667964b87a3efc739e254ada2";
$request["customerID"] = 4;
$request["dataJSon"]="{\"category\":\"5\",\"salutation\":\"Mr\",\"firstName\":\"234xcwertgtry\",\"middleName\":\"dedede\",\"lastName\":\"A343rcgftgleta\",\"DOB\":\"2001-05-25\",\"gender\":\"Female\",\"phone\":\"6973493610\",\"email\":\"BarryArclfrfeta@gmail.com\",\"addressLine1\":\"\",\"addressLine2\":\"\",\"city\":\"Glasgfrfrfow Village\",\"state\":\"\",\"country\":\"\",\"pincode\":\"199444\",\"nationality\":\"United Sfrftates\"}";
$tempResp = $object->putCustomer($request);
$response = json_encode($tempResp);
echo $response;
*/

/* Test Code for UPDATING THE PHONE NUMBER 
$object = new CustomerController();
$request = array();
$request["restaurantID"]= 1 ;
$request["apiKey"]="7749b19667964b87a3efc739e254ada2";
$request["customerID"] = 4;
$request["phone"]= 997198332329 ;
$tempResp = $object->postCustomerPh($request);
$response = json_encode($tempResp);
echo $response;
*/
/* Test Code for UPDATING THE PHONE NUMBER 
$object = new CustomerController();
$request = array();
$request["restaurantID"]= 1 ;
$request["apiKey"]="7749b19667964b87a3efc739e254ada2";
$request["customerID"] = 4;
$request["email"]= "something@something.com" ;
$tempResp = $object->postCustomerEmail($request);
$response = json_encode($tempResp);
echo $response;
*/

/* Test Code for DELETING THE PHONE NUMBER 
$object = new CustomerController();
$request = array();
$request["restaurantID"]= 1 ;
$request["apiKey"]="7749b19667964b87a3efc739e254ada2";
$request["customerID"] = 4;
$tempResp = $object->resetCustomerPh($request);
$response = json_encode($tempResp);
echo $response;
*/

/* Test Code for DELETING THE EMAIL of a USER
$object = new CustomerController();
$request = array();
$request["restaurantID"]= 1 ;
$request["apiKey"]="7749b19667964b87a3efc739e254ada2";
$request["customerID"] = 6;
$tempResp = $object->resetCustomerEmail($request);
$response = json_encode($tempResp);
echo $response;
*/


?>
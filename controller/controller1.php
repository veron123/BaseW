<?php

/* Including all files that are required within the controller class. Avoiding all types of
Redeclaration */
if(  !class_exists('Employee') ) {
    require_once(__DIR__ . '/../model/EmployeeClass.php');
}
if(  !class_exists('AdditionalCharges') ) {
    require_once(__DIR__ . '/../model/Additional_Charges.php');
}

if(  !class_exists('Discount') ) {
    require_once(__DIR__ . '/../model/DiscountClass.php');
}

if(  !class_exists('Tax') ) {
    require_once(__DIR__ . '/../model/TaxClass.php');
}
if(  !class_exists('Menu') ) {
    require_once(__DIR__ . '/../model/MenuClass.php');
}
if(  !class_exists('Products') ) {
    require_once(__DIR__ . '/../model/ProductsClass.php');
}
if(  !class_exists('Restaurant') ) {
    require_once (__DIR__ . '/../model/ResturantClass.php');
}
if(  !class_exists('Db') ) {
    require_once(__DIR__ . '/../model/DatabaseClass.php');
}
if(  !class_exists('RestaurantUsers') ) {
    require_once(__DIR__ . '/../model/UsersClass.php');
}


Class ApIController {


/* Function that checks whether the API Key and the Restaurant ID match or Not 
   The API Key and the Restaurant ID within the request array.
*/
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
                return false;
            }	
}

/* FUNCTION to obtain the Additional Charges pertaining to a request having the restaurant ID 
   returns an Array contain all additional charges pertaining to a restaurant */

public function getACharges($request)
{
	if($this->checkDetails($request))
	{
		$object= new AdditionalCharges();
		$array = $object->getAC($request["restaurantID"]);
		return $array;
		}
}


/* FUNCTION to obtain the details pertaining to a particular a restaurant ID 
   Request contains the API Key and the restaurant ID -> Details are checked 
   Response contains all details pertaining to the Restaurant 
   */

public function getRest($request)
{
	if($this->checkDetails($request))
	{
		$restObject = new Restaurant();
		$array = $restObject->getRestaurantData($request["restaurantID"]);
		return $array[0];
	}
	
}

/* FUNCTION to obtain the tax details pertaining to a particular a restaurant ID 
   Request contains the API Key and the restaurant ID -> Details are checked 
   Response contains all taxes and their details pertaining to the Restaurant 
   */

public function getTax($request)
{
	if($this->checkDetails($request))
	{
		$object= new Tax();
		$array = $object->getTaxes($request["restaurantID"]);
		return $array;
		}
}

/* FUNCTION to obtain the discount details pertaining to a particular a restaurant ID 
   Request contains the API Key and the restaurant ID -> Details are checked 
   Response contains all taxes and their details pertaining to the Restaurant 
   */

public function getDiscounts($request)
{
	if($this->checkDetails($request))
	{
		$object= new Discount();
		$array = $object->getDiscountInfo($request["restaurantID"]);
		return $array;
		}
}

/* FUNCTION to obtain the Product details pertaining to a particular a restaurant ID 
   Request contains the API Key and the restaurant ID -> Details are checked 
   Response contains all products and their details pertaining to the Restaurant 
   */
public function getData($request) // Data pertaining to only Products within the Restaurant 
{
	if($this->checkDetails($request))
	{
		$restObject = new Products();
		$array = $restObject->getAllProducts($request["restaurantID"]);
		return $array;
	}
	
}

/* FUNCTION to obtain the {Product,Category,SubCategory} details pertaining to a particular a restaurant ID 
   Request contains the API Key and the restaurant ID -> Details are checked 
   Response contains {Product,Category,SubCategory} pertaining to the Restaurant 
   */
public function getProd($request)
{
	if($this->checkDetails($request))
	{
		$object= new Products();
		$array = $object->getStuff($request["restaurantID"]);
		return $array;
		}
}
/* GET OPENING TIMINGS OF THE RESTAURANT */
public function getOpenTime($request)
{
	if($this->checkDetails($request))
	{
		$restObject = new Restaurant();
		$array = $restObject->getOpeningTimes($request["restaurantID"]);
		return $array;
	}
	
}
/* GET CLOSING TIMINGS OF THE RESTAURANT */
public function getCloseTime($request)
{
	if($this->checkDetails($request))
	{
		$restObject = new Restaurant();
		$array = $restObject->getClosingTimes($request["restaurantID"]);
		return $array;
	}
	
}
/* GET OFFICIAL TIMINGS OF THE RESTAURANT */
public function getOffTimes($request)
{
	if($this->checkDetails($request))
	{
		$restObject = new Restaurant();
		$array = $restObject->getOfficialTime($request["restaurantID"]);
		return $array;
	}
	
}

/* FUNCTION to obtain an API Key! Request contains the userName and the password
   {userName,password} == MATCH and API key is returned to the sender in the form of Response Array!
   Response contains {Error,apiKey,restID,message}
   */
public function login($request)
{
          $name =$request["userName"];
          $password =$request["password"];

          $response = array();
     

            $db = new Db();
            $local_query ="SELECT * FROM users WHERE userName = '$name' AND password ='$password'; ";
            $user = $db->select($local_query);

            if (!empty($user) ) {
                    $response['error'] = false;
                    $response['apiKey'] = $user[0]['apiKey'];
                    $response['restID'] = $user[0]['restaurantID'];
                    $response['message'] = "Success";
                } 
               else {
                $response['error'] = true;
                $response['message'] = 'Login failed. Incorrect credentials';
            }
            return $response;           
}

public function getUsers($request)
{
	if($this->checkDetails($request))
	{
		$object= new RestaurantUsers();
		$array = $object->getUsers($request["restaurantID"]);
		return $array;
	}
} 

public function Master($request)
{
if($this->checkDetails($request))
	{
		$restArray = $this->getRest($request);
		$restArray1 = array("Restaurant"=>$restArray);
		$productArray = $this->getProd($request);
		$productArray1=array("Products"=>$productArray);
		$taxArray = $this->getTax($request);
		$taxArray1=array("Taxes"=>$taxArray);
		$aChargesArray = $this->getACharges($request);
		$aChargesArray1=array("Additional Charges"=>$aChargesArray);
		$endArray = array_merge($restArray1,$productArray1,$taxArray1,$aChargesArray1);
		return $endArray;
		}
}
//////////////////////////////////////// FUNCTIONS CORRESPONDING TO EMPLOYEE API ///////////////////////////////////////////////

public function getEmp($request)
{
	if($this->checkDetails($request))
	{
		$empObject = new Employee();
		$array = $empObject->getEmployees($request["restaurantID"]);
		return $array;
	}
	
}

public function getEmpById($request)
{
	if($this->checkDetails($request))
	{
		$empObject = new Employee();
		$array = $empObject->getEmployeeById($request["restaurantID"],$request["empId"]);
		return $array;
	}
	
}

public function postEmp($request)
{
	if($this->checkDetails($request))
	{
		$empObject = new Employee();
		$array = $empObject->postEmployee($request["restaurantID"],$request["dataJSON"]);
		return $array;
	}
	
}
public function putEmp($request)
{
	if($this->checkDetails($request))
	{
		$empObject = new Employee();
		$array = $empObject->updateEmployee($request["restaurantID"],$request["dataJSON"],$request["empID"]);
		return $array;
	}	
}

public function resetEmp($request)
{
	if($this->checkDetails($request))
	{
		$empObject = new Employee();
		$array = $empObject->deleteEmployee($request["restaurantID"],$request["empid"]);
		return $array;
	}
	
}
}
?>


<?php

require_once ('DatabaseClass.php');
require_once ('ResturantClass.php');
require_once (__DIR__ . '/../libs/functions.php');

Class Employee extends Restaurant {
	private $ID ;
	private $userName ;
	private $password;
	private $pin ;
	private $firstName ;
	private $middleName ;
	private $lastName ;
	private $nickname ;
	private $phone ;
	private $email ;
	private $isActive ;
	private $photoLocation ;
// GET : Customer List
	public function getEmployees($restId)
	{
		$db = new Db();
		$table ="rest".$restId."_users";
		
		$checkRest = restExists($table) ;
		if($checkRest != true)
			return $checkRest;
		
		$local_query = "SELECT ID, userName,firstName,middleName,lastName,
		nickname,phone,email,isActive,photolocation FROM `$table`";
		$result = $db->select($local_query);
		return $result ;
	}
	
	
// GET EMPLOYEE BY REST AND EMP ID 	
   public function getEmployeeById($restId,$userid)
	{
		$db = new Db();
		$table ="rest".$restId."_users";
		$checkRest = restExists($table) ;
		if($checkRest != true)
			return $checkRest;
		
		$local_query = "SELECT ID, userName,firstName,middleName,lastName,
		nickname,phone,email,isActive,photolocation FROM `$table` WHERE ID = '$userid' ";
		$result = $db->select($local_query);
		return $result ;
	}
// POST EMPLOYEE BY REST ID 
  public function postEmployee($restId,$input_json)
  {
  	    $db = new Db();
		$table ="rest".$restId."_users";
		$data = json_decode($input_json,true);
		
		$checkRest = restExists($table) ;
		if($checkRest != true)
			return $checkRest;
	
	    $userName = $data["userName"] ;
	    $password = $data["password"];
	    $pin = $data["pin"] ;
	    $firstName = $data["firstName"] ;
	    $middleName = $data["middleName"];
	    $lastName = $data["lastName"] ;
	    $nickname = $data["nickname"] ;
	    $phone = $data["phone"];
	    $email = $data["email"] ;
	    $isActive = $data["isActive"];
	    $photoLocation = $data["photoLocation"] ;
	    
	    $local_query = "INSERT INTO `$table`(`userName`, `password`, `pin`, `firstName`, `middleName`,
	     `lastName`, `nickname`, `phone`, `email`, `isActive`, `photoLocation`) VALUES ('$userName','$password','$pin','$firstName','$middleName',
	     '$lastName','$nickname','$phone','$email','$isActive','$photoLocation') " ;
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
  
public function updateEmployee($restId,$input_json, $empid)
{   
	$db = new Db();
	$data = json_decode($input_json,true);
	$table ="rest".$restId."_users";
	
	$checkRest = restExists($table) ;
	if($checkRest != true)
		return $checkRest;
		
foreach($data as $key => $value)
{ 
	if($key!="ID")
	{
	$local_query="UPDATE `$table` SET $key='$value' ID = '$empid';";
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
  // DELETE EMPLOYEE 
  public function deleteEmployee($restId,$userid)
   {
	$db = new Db();
	$table ="rest".$restId."_users";
	
	$checkRest = restExists($table) ;
	if($checkRest != true)
		return $checkRest;
		
	$local_query ="UPDATE `$table` SET isActive = 0 WHERE ID ='$userid' ";
	$result = $db->query($local_query);
   
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
?>
<?php 
/* Test Code for getting all employees 
$object = new Employee();
$result = $object->getEmployees(1);
echo json_encode($result);
*/

/* Test code for getting employee by rest id and emp id 
$object = new Employee();
$result = $object->getEmployeebyId(1,2);
echo json_encode($result);
*/

/* Test code for delete employee by rest id and emp id 
$object = new Employee();
$result = $object->deleteEmployee(1,2);
echo json_encode($result);
*/

/* Test code for inserting employee by rest id and emp id 
$object = new Employee();
$input_json = "{\"userName\": \"nikhiuobnuonl\",\"password\": \"nikdwfwehil\",\"pin\": \"\",\"firstName\": \"Niwefekhil\",\"middleName\": \"\",\"lastName\": \"Mefwfwhta\",\"nickname\": \"\",\"phone\": \"\",\"email\": \"nikhfwefewil@zomato.com\",\"isActive\": 0,\"photoLocation\": \"https://fbcdn-sphotos-h-a.akamaihd.net/hphotos-ak-xfa1/v/t1.0-9/229199_10150185584536749_4312872_n.jpg?oh=b862bccea0ba4fd87d1486b6156ebedf&oe=561F0095&__gda__=1445508395_67fccd5450350116a875dc1bb606c3f8\"}";
$result = $object->postEmployee(1,$input_json);
echo json_encode($result);
*/


?>
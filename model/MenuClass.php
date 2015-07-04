<?php

if(  !class_exists('Restaurant') ) {
    require_once('ResturantClass.php');
}
if(  !class_exists('Db') ) {
    require_once('DatabaseClass.php');
}

Class Menu extends Restaurant {
private $ID;
private $menuId;
private $productId;
private $isDishOfTheDay;
private $price;
private $MenuItemIsActive; /* Corresponding changes should  be reciprocated in the table isActive because of the Inheritance problem */

public function getDistinctMenuId($restID)
{
	    $db = new Db();
	    $table ="rest".$restID."_menu";
		$local_query = "SELECT DISTINCT menuID FROM `$table`";
		$data = $db->select($local_query);
		return $data;
}

public function getMenuProducts($restID)
{

    $response = $this->getDistinctMenuID($restID);
    $table ="rest".$restID."_menu";
    //print_r($response); 
    $cnt = count($response);
    $i = 0;
    $main = array();
    foreach($response as $key => $value)
    {
    	$db = new Db();
    	$id = $value['menuID'];
    	$local_query =" SELECT `productID`,`isDishOfTheDay` FROM `$table` WHERE menuID = '$id' "; 
    	//echo $local_query;
    	$array[$id] = $db->select($local_query);
    	
    }
    // print_r($array);
    print_r($array[1]);
    print_r($array[2]);
    print_r($array[3]);
   // $json = json_encode($array);
    //echo $json;
    
    /*for($i=0; $i < $cnt; $i++)
    {
    	echo $response["{$i}"];
    }
    */
}
public function getMenu($restId)
{
	    $db = new Db();
	    $table ="rest".$restId."_menu";
		$local_query = "SELECT * FROM `$table` WHERE isActive=1 AND menuID ";
		$data = $db->select($local_query);
		return $data;
}


/* Method to Set Menu Item On using json */
public function setMenuItem($input_json,$restId)
{
	$data = json_decode($input_json,true);
	$db = new Db();
	/* Modify MenuItem with respect to $restId */
	$menuId =$data['ID'];
	$table = "rest".$restId."_menu";
	$local_query = "UPDATE `$table` SET isActive = 1 WHERE ID = $menuId";	
	$result = $db->query($local_query);
    if($result == false)
	{ 
		 echo "FAILED!";
	}
	else 
	{
		echo "DONE!";
	}
}

/* Method to Set Menu Item Off using json */
public function resetMenuItem($input_json,$restId)
{
	$data = json_decode($input_json,true);
	/* Modify MenuItem with respect to $restId */
	$db = new Db();
	
	$menuId =$data["ID"];
	$table = "rest".$restId."_menu";
	$local_query = "UPDATE `$table` SET isActive = 0 WHERE ID = $menuId";
	$result = $db->query($local_query);
    if($result == false)
	{ 
		 echo "FAILED!";
	}
	else 
	{
		echo "DONE!";
	}
}
public function setDishOfTheDay($input_json)
{
$data = json_decode($input_json,true);
	/* Modify MenuItem with respect to $restId */
	$db = new Db();
	
	$menuId =$data["ID"];
	$restId=$data["restId"];
	$productId=$data["productID"];
	$table = "rest".$restId."_menu";
	
	$local_query = "UPDATE `$table` SET isDishOfTheDay = 1 WHERE ID = $menuId";
	echo $local_query;
	$result = $db->query($local_query);
    if($result == false)
	{ 
		 echo "FAILED!";
	}
	else 
	{
		echo "DONE!";
	}
}

public function resetDishOfTheDay($restId)
{
$db = new Db();
$table = "rest".$restId."_menu";
$local_query = "UPDATE `$table` SET isDishOfTheDay = 0 ";
$result = $db->query($local_query);
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

?>

<?php
///////////////    PRODUCT CLASS          //////////////////////////////
require_once ('DatabaseClass.php');
require_once ('ResturantClass.php');
require_once (__DIR__ . '/../libs/functions.php');

Class Products extends Restaurant {
	private $productID;
	private $restAssignedProductID;
	private $productName;
	private $altNameForKOT;
	private $categoryID;
	private $subCategoryID;
	private $courseType;
	private $isVeg;
	private $priceIncludesTaxes;
	private $measurementUnitID;
	private $sizeVariant;
	private $productPrice;
	private $taxes;
	private $incomeHead;
	private $additionalCharges;
	private $isMRPItem;
	private $IsInventoryManaged;
	private $hasModifiers;
	private $isCombo;
	private $portion;
	private $photoLocation;
	private $shortDescription;
	private $longDescription;
	private $kotPrinter;
	private $barcode;
	private $tags;
	private $productIsActive; 
	
/* FUNCTION TO GET ALL THE PRODUCTS PERTAINING TO A PARTICULAR RESTAURANT */
       public function getAllProducts($restId)
	{
		$db = new Db();
		$table = "rest".$restId."_products";
		$checkRest = restExists($table) ;
	    if($checkRest != true)
			return $checkRest;
		$local_query = "SELECT * FROM `$table`" ;
		$result = $db->select($local_query);
		return $result;
	}

/* {PRODUCTS,CATEGORY,SUBCATEGROY}	*/ 
	public function getProducts($restId)
	{
		$table = "rest".$restId."_products";
		$table1 = "rest".$restId."_category";
		$table2 = "rest".$restId."_subCategory";
		$checkRest = restExists($table) ;
	    if($checkRest != true)
			return $checkRest;
		$db = new Db();
		$local_query = "SELECT * FROM `$table1`, `$table`
		 WHERE $table1.categoryID = $table.categoryID ORDER BY $table.categoryID,$table.subCategoryID;";
		
		$local_query1="SELECT categoryID, categoryName FROM  `$table1`";
		$local_query2="SELECT subCatID , subName FROM `$table2` ";
		
		$result = $db->select($local_query);
		$cnt = count($result);
		$i = 0;
		$categoryArray = array();
		$main = array();
		$category = array();
		foreach($result as $key => $value)
		{
			$temp = $value["categoryID"];
			$categoryArray["categoryID"]= $temp;
			$categoryArray['categoryName'] = $value["categoryName"];
			$categoryArray['subCategoryID'] = $value['subCategoryID'];
			$category[$i++] = $categoryArray;	
		}
		$unique = array_map("unserialize", array_unique(array_map("serialize", $category)));
	
		
		$i = 0;
		$j =0;
		for($i=0;$i<$cnt;$i++)
		{   if(isset($unique[$i]))
			$categoryMain[$j++] = $unique[$i];
		}
		$categoryCount = count($categoryMain);
	
		$products = array();
		$i = 0;
		foreach($result as $key => $value)
		{
			$products[$i]["productID"] = $value["productID"];
			$products[$i]["productName"]=$value["productName"];
			$products[$i]["restAssignedProductID"]=$value["restAssignedProductID"];
			$products[$i]["altNameForKOT"]=$value["altNameForKOT"];
			$products[$i]["courseType"]=$value["courseType"];
			$products[$i]["isVeg"]=$value["isVeg"];
			$products[$i]["priceIncludesTaxes"]=$value["priceIncludesTaxes"];
			$products[$i]["sizeVariant"]=$value["sizeVariant"];
			$products[$i]["productPrice"]=$value["productPrice"];
			$products[$i]["taxes"]=$value["taxes"];
			$products[$i]["incomeHead"]=$value["incomeHead"];
			$products[$i]["additionalCharges"]=$value["additionalCharges"];
			$products[$i]["isMRPItem"]=$value["isMRPItem"];
			$products[$i]["IsInventoryManaged"]=$value["IsInventoryManaged"];
			$products[$i]["isCombo"]=$value["isCombo"];
			$products[$i]["hasModifiers"]=$value["hasModifiers"];
			$products[$i]["shortDescription"]=$value["shortDescription"];
			$products[$i]["longDescription"]=$value["longDescription"];
			$products[$i]["categoryID"]=$value["categoryID"];
			$products[$i]["subCategoryID"]=$value["subCategoryID"];
			$i++;
		}
		
		$finalCount = count($categoryMain);
		$mainArray = array();
		$i = 0 ;
		$j = 0;
		for($i=0;$i < $finalCount; $i++)
		{   
			 
			$mainArray["Category"][$i] = $categoryMain[$i];
			if(isset($main["Category"][$i]["Products"]))
			{
			$mainArray["Category"][$i]["Products"] += $products[$j];
			$j++;
			}
			else
			{
				$mainArray["Category"][$i]["Products"] = $products[$j];
				$j++;
			}
		}
		return $mainArray;
		
	}
	
	/*** FUNCTION TO OBTAIN ALL CATEGORY DETAILS PERTAINING TO A RESTAURANT ID ***/

	public function getCats($restId)
	{
		$db = new Db();
		$table = "rest".$restId."_category";
		$checkRest = restExists($table) ;
	    if($checkRest != true)
			return $checkRest;
		$local_query = "SELECT * FROM `$table`" ;
		$result = $db->select($local_query);
		return $result;
		
	}
	/*** FUNCTION TO OBTAIN ALL SUBCATEGORY DETAILS PERTAINING TO A RESTAURANT ID ***/
   public function getSubs($restId)
	{
		$db = new Db();
		$table = "rest".$restId."_subCategory";
		$checkRest = restExists($table) ;
	    if($checkRest != true)
			return $checkRest;
		$local_query = "SELECT * FROM `$table`" ;
		$result = $db->select($local_query);
		return $result;
		
	}

public function getMenu($restId)
	{
		$db = new Db();
		$table = "rest".$restId."_menu";
		$checkRest = restExists($table) ;
	    if($checkRest != true)
			return $checkRest;
		$local_query = "SELECT productID,isDishOfTheDay FROM `$table`" ;
		$result = $db->select($local_query);
		return $result;
		
	}
	

/*** FUNCTION RETURNS {PRODUCTS,CATEGORY,SUBCATEGORY,MENU} INFORMATION ***/
	public function getStuff($restId)
	{
		$products = $this->getAllProducts($restId) ;
		$category = $this->getCats($restId);
		$subcategory = $this->getSubs($restId);
		$menuinfo = $this->getMenu($restId);
		$endArray = array();
		$endArray["Menu"]["Products"] = $products;
		$endArray["Menu"]["Category"] =$category ;
		$endArray["Menu"]["Subcategory"]=$subcategory;
		$endArray["Menu"]["Menu Information"] = $menuinfo;
		return $endArray;
	
	}  
	
	
	
	
	
    // FUNCTION TO INSERT DATA INTO THE TABLE, WRT TO JSON THAT COMES IN THE POST REQUEST BY THE USER
	public function createProducts($input_json,$restId)
	{
	$data = json_decode($input_json,true);
	$table = "rest".$restId."_products";
	$checkRest = restExists($table) ;
	    if($checkRest != true)
			return $checkRest;
	
	$productId = $data['productID'];
	$restAssignedProductId = $data['restAssignedProductID'];
	$altNameForKOT=$data["altNameForKOT"];
	$productName = $data['productName'];
	$categoryID = $data['categoryID'];
	$subCategoryID = $data['subCategoryID'];
	$courseType = $data['courseType'];
	$isVeg = $data['isVeg'];
	$priceIncludesTaxes = $data['priceIncludesTaxes'];
    $measurementUnitID=$data['measurementUnitID'];
	$sizeVariant = $data['sizeVariant'];
	$productPrice = $data['productPrice'];
	$taxes = $data['taxes'];
	$incomeHead = $data['incomeHead'];
	//$costHead = $data['costHead'];
	$additionalCharges = $data['additionalCharges'];
	$isMRPItem = $data['isMRPItem'];
	$isInventoryManaged = $data['IsInventoryManaged'];
	$hasModifiers = $data['hasModifiers'];
	$isCombo = $data['isCombo'];
	$portion = $data['portion'];
	$photoLocation= $data['photoLocation'];
	$shortDescription = $data['shortDescription'];
	$longDescription = $data['longDescription'];
	$kotPrinter = $data['kotPrinter'];
	$barcode=$data['barcode'];
	$tags = $data['tags'];
	$productIsActive = $data['isActive'];
	
	$db = new Db();
	$local_query = "INSERT INTO `restX_products`(`restAssignedProductID`, `productName`, `altNameForKOT`, `categoryID`,
	`subCategoryID`, `courseType`, `isVeg`, `priceIncludesTaxes`, `measurementUnitID`, `sizeVariant`, `productPrice`, `taxes`,
	`incomeHead`, `additionalCharges`, `isMRPItem`, `IsInventoryManaged`, `hasModifiers`, `isCombo`, `portion`, `photoLocation`,
    `shortDescription`, `longDescription`, `kotPrinter`, `barcode`, `tags`, `isActive`)
     VALUES ('$restAssignedProductId','$productName','$altNameForKOT','$categoryID','$subCategoryID','$courseType',
     '$isVeg','$priceIncludesTaxes','$measurementUnitID','$sizeVariant','$productPrice','$taxes','$incomeHead','$additionalCharges',
     '$isMRPItem', '$isInventoryManaged','$hasModifiers','$isCombo','$portion','$photoLocation','$shortDescription','$longDescription',
     '$kotPrinter','$barcode','$tags','$productIsActive') ";	
	echo $local_query ;
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
	
	
	public function updateProducts($input_json,$productId,$restId)
	{
	$db = new Db();
	$data = json_decode($input_json,true);
	$table = "rest".$restId."_products";
	$checkRest = restExists($table) ;
	    if($checkRest != true)
			return $checkRest;
	
    foreach($data as $key => $value)
    { 
	if($key!="restaurantID")
	{
	$local_query="UPDATE `$table` SET $key='$value';";
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
			
/*   Tentative structure for deleteProducts() . Essentially making Products inactive. 
    NOT BE DELETED UNTILL DISCUSSED
	
	public function deleteProducts($restId,$productId)
	{
		$table = "rest".$restId."_products";
		$db = new Db();
		$local_query ="UPDATE `$table` SET isActive = 0 WHERE productID = $productId";
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
	*/
}
?>


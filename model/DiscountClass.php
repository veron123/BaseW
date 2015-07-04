<?php 
///////////////    DISCOUNT CLASS          //////////////////////////////
if(  !class_exists('Restaurant') ) {
    require_once('ResturantClass.php');
}
if(  !class_exists('Db') ) {
    require_once('DatabaseClass.php');
}
require_once (__DIR__ . '/../libs/functions.php');

Class Discount extends Restaurant{

  private $discountID;
  private $discountName;
  private $discountType ;
  private $discountLevel ;
  private $discountUIDisplaySetting;
  private $discountProductList; 
  private $isTaxed;
  private $isAutoApplied ;
  private $isPasswordEnabled ;
  private $maximumOff ;
  private $minimumAmount ;
  private $isAppliedToBaseProductOnly ;
  private $startDateUTC ;
  private $startDateLocal ;
  private $endDateUTC ;
  private $endDateLocal ;
  private $timeZone ;
  private $minimumProductsRequired ;
  private $applyToEntireQualifyingCategory ;
  private $targetDiscountList ;
  private $isVoucherEnabled; 
  private $isShownBeyondTimeLimit ;
  private $isSlotted ; 
	
  
/* FUNCTION TO SIMPLY RETURN DISCOUNT DETAILS PERTAINING TO THE RESTAURANT */
  public function getDiscountDetails($restId)
  {
  	$table = "rest".$restId."_discountMaster";
    $checkRest = restExists($table) ;
      if($checkRest != true)
      return $checkRest;
    $local_query = "SELECT * FROM `$table`";
  	$db = new Db();
  	$result = $db->select($local_query);
  	$endArray = array();
  	$endArray["Discounts Information"] = $result ;
  	echo json_encode($endArray);
  	 }
	
  /* FUNCTION TO SIMPLY RETURN THE DISCOUNT DETAILS, VOUCHER DETAILS, SLOT DETAILS 
     VOUCHER AND SLOT DETAILS ARE SENT ONLY IF THEY EXIST PERTAINING TO A RESTAURANT 
  */
 public function getDiscountInfo($restId)
  {
  	$table = "rest".$restId."_discountMaster";
    $checkRest = restExists($table) ;
      if($checkRest != true)
      return $checkRest;
  	$discountVoucherTable = "rest".$restId."_discountVoucher";
  	$discountSlotsTable = "rest".$restId."_discountSlots";
  	$db = new Db();
  	$local_query = "SELECT * FROM `$table`";
  	$result = $db->select($local_query);
  	
  	foreach($result as $key => $value)
  	{
  		if ($value["isVoucherEnabled"])
  		{   
  			$temp = $value["discountID"];
  			$voucher_query = "SELECT `ID`, `voucherCode`, `validFromUTC`,
  			 `validFromLocal`, `validToUTC`, `validToLocal`, `timeZone`, `isUsed`,
  			  `orderIDUsedOn`, `customerID` FROM `$discountVoucherTable` WHERE discountID = '$temp'" ;
  			$voucher = $db->select($voucher_query);
  			$result[$key]["Voucher Details"] = $voucher ;
  		}
  	}
  	
  foreach($result as $key => $value)
  	{
  		if ($value["isSlotted"])
  		{   
  			$temp = $value["discountID"];
  			$slot_query = "SELECT * FROM `$discountSlotsTable` WHERE discountID = '$temp'" ;
  			$slot = $db->select($voucher_query);
  			$result[$key]["Slot Details"] = $slot ;
  		}
  	}
    return $result ;
}
}

?>


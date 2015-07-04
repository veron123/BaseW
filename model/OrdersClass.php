<?php

require_once ('DatabaseClass.php');
require_once (__DIR__ . '/../libs/functions.php');

Class Orders  {
	/* Attributes for a restuarant, pertaining to restX_info table 
	in the ZomatoBase3 database */
	
	private $orderID;
	private $currency;
	private $userName;
	private $deviceID;
	private $netBill;
	private $paymentType;
	private $additionalChargesIDs;
	private $additionalChargesNames;
	private $additionalChargesPrices;
	private $additionalChargesValue;
	private $discountIDs;
	private $discountName;
	private $discountValues;
	private $discountRemarks;
	private $totalTax;
	private $roundingOff;
	private $grossBill;
	private $cashPayment;
	private $cardPayment;
	private $cardNumbers;
	private $cardAmounts;
	private $otherPayments;
	private $orderType;
	private $tableID;
	private $customerID;
	private $orderCreationTimeUTC;
	private $orderCreationTimeLocal;
	private $timezone;
	private $lastmodifiedTimeUTc;
	private $tableOccupyTimeUTC;
	private $tableOccupyTimeLocal;
	private $billSettleTimeUTC;
	private $billSettleTimeLocal;
	private $voidTimeUTC;
	private $voidTimeLocal;
	private $refunds;
	private $voidRemarks;
	private $orderRemarks;
	private $numReceiptPrints;
	private $numKOTPrints;
	private $status;
	
	public function getOrderProducts($restId,$orderID)
	{
	    $db = new Db();
	    $table ="rest".$restId."_orderDetail";
		$local_query = "SELECT * FROM `$table` WHERE orderID = '$orderID' ORDER BY `orderSubID`;";
		$result = $db->select($local_query);
		
		$response = array();
		$count = count($result);
		
		$checkRest = restExists($table) ;
		
		if($checkRest != true)
			return $checkRest;
		
		if($result == false || $count < 1){
			$response['error'] = "true";
			$response['message'] = "Invalid input";
			
			return $response;
		}
		else{
			
			for($i = 0; $i < $count; $i++)
			{
				unset($result[$i]["ID"]);
				unset($result[$i]["measurementUnitID"]);
				unset($result[$i]["orderTimeUTC"]);
				unset($result[$i]["deliveryTimeUTC"]);
				unset($result[$i]["billSettledTimeUTC"]);
				unset($result[$i]["voidTimeUTC"]);
				unset($result[$i]["measurementUnitID"]);
				
				//get modifiers array
				$modifierIDs = my_explode(",",$result[$i]['modifierIDs']);
				$modifierNames = my_explode(",",$result[$i]['modifierNames']);
				$modifierPrices = my_explode(",",$result[$i]['modifierPrices']);
				$modifierQuantity = my_explode(",",$result[$i]['modifierQuantity']);
				$modifierTotalValue = $result[$i]['modifierValue'];
				
				unset($result[$i]['modifierIDs']);
				unset($result[$i]['modifierNames']);
				unset($result[$i]['modifierPrices']);
				unset($result[$i]['modifierQuantity']);
				unset($result[$i]['modifierValue']);
				
				$result[$i]['modifiers'] = array();
				$result[$i]['modifiers']['modifiersTotalValue'] = $modifierTotalValue;
				
				$modifiersCount = count($modifierIDs);
				$modifiersArray = array();
				
				for($j = 0; $j < $modifiersCount; $j++){
					$modifiersArray['id'] = $modifierIDs[$j];
					$modifiersArray['name'] = $modifierNames[$j];
					$modifiersArray['price'] = $modifierPrices[$j];
					$modifiersArray['quantity'] = $modifierQuantity[$j];
					
					array_push($result[$i]['modifiers'],$modifiersArray);
				}
				
				//create array for additional charges
				$additionalChargeIDs = my_explode(",",$result[$i]['additionalChargeIDs']);
				$additionalChargeNames = my_explode(",",$result[$i]['additionalChargeNames']);
				$additionalChargePrices = my_explode(",",$result[$i]['additionalChargePrices']);
				$additionalChargeTotal = $result[$i]['additionalChargeValue'];
				
				unset($result[$i]['additionalChargeIDs']);
				unset($result[$i]['additionalChargeNames']);
				unset($result[$i]['additionalChargePrices']);
				unset($result[$i]['additionalChargeValue']);
				
				$result[$i]['additionalCharges'] = array();
				$result[$i]['additionalCharges']['additionalChargesTotalValue'] = $additionalChargeTotal;
				
				$additionalChargeCount = count($additionalChargeIDs);
				$additionalChargeArray = array();
				
				for($j = 0; $j < $additionalChargeCount; $j++){
					$additionalChargeArray['id'] = $additionalChargeIDs[$j];
					$additionalChargeArray['name'] = $additionalChargeNames[$j];
					$additionalChargeArray['price'] = $additionalChargePrices[$j];
					
					array_push($result[$i]['additionalCharges'],$additionalChargeArray);
				}
				
				//create array for taxes
				$taxIDs = my_explode(",",$result[$i]['taxIDs']);
				$taxNames = my_explode(",",$result[$i]['taxNames']);
				$taxPercentage = my_explode(",",$result[$i]['taxPercentages']);
				$taxValue = my_explode(",",$result[$i]['taxValue']);;
				
				unset($result[$i]['taxIDs']);
				unset($result[$i]['taxNames']);
				unset($result[$i]['taxPercentage']);
				unset($result[$i]['taxValue']);
				
				$result[$i]['taxes'] = array();
				
				$taxesCount = count($taxIDs);
				$taxesArray = array();
				
				for($j = 0; $j < $taxesCount; $j++){
					$taxesArray['id'] = $taxIDs[$j];
					$taxesArray['name'] = $taxNames[$j];
					$taxesArray['percentage'] = $taxPercentage[$j];
					$taxesArray['value'] = $taxValue[$j];
					
					array_push($result[$i]['taxes'],$taxesArray);
				}						
			}
			
			$response['productsList'] = $result; 
			
			return $response;
		}
	} //function ka the end
	
	public function getOrder($restId,$orderID)
	{
	    $db = new Db();
	    $table ="rest".$restId."_orderSummary";
		$local_query = "SELECT * FROM `$table` WHERE orderID = '$orderID';";
		$result = $db->select($local_query);
		
		$response = array();
		$count = count($result);
		
		$checkRest = restExists($table) ;
		
		if($checkRest != true)
			return $checkRest;
		
		if($result == false || $count != 1){
			$response['error'] = "true";
			$response['message'] = "Invalid input";
			
			return $response;
			
		}
		else{
			
			// return $result;
			
			//create array for additional charges
			$additionalChargeIDs = my_explode(",",$result[0]['additionalChargeIDs']);
			$additionalChargeNames = my_explode(",",$result[0]['additionalChargeNames']);
			$additionalChargePrices = my_explode(",",$result[0]['additionalChargePrices']);
			$additionalChargeTotal = $result[0]['additionalChargeValue'];
			
			unset($result[0]['additionalChargeIDs']);
			unset($result[0]['additionalChargeNames']);
			unset($result[0]['additionalChargePrices']);
			unset($result[0]['additionalChargeValue']);
			
			$result[0]['additionalCharges'] = array();
			
			$additionalChargeCount = count($additionalChargeIDs);
			$additionalChargeArray = array();
			
			for($i = 0; $i < $additionalChargeCount; $i++){
				$additionalChargeArray['id'] = $additionalChargeIDs[$i];
				$additionalChargeArray['name'] = $additionalChargeNames[$i];
				$additionalChargeArray['price'] = $additionalChargePrices[$i];
				
				array_push($result[0]['additionalCharges'],$additionalChargeArray);
			}
			
			//create array for discounts
			$discountIDs = my_explode(",",$result[0]['discountIDs']);
			$discountNames = my_explode(",",$result[0]['discountNames']);
			$discountValues = my_explode(",",$result[0]['discountValues']);
			$discountTotal = $result[0]['discountTotalValue'];
			
			unset($result[0]['discountIDs']);
			unset($result[0]['discountNames']);
			unset($result[0]['discountValues']);
			unset($result[0]['discountTotalValue']);
			
			$result[0]['discounts'] = array();
			$result[0]['discounts']['totalDiscount'] = $discountTotal;
			
			$discountCount = count($discountIDs);
			$discountArray = array();
			
			for($i = 0; $i < $discountCount; $i++){
				$discountArray['id'] = $discountIDs[$i];
				$discountArray['name'] = $discountNames[$i];
				$discountArray['value'] = $discountValues[$i];
				
				array_push($result[0]['discounts'],$discountArray);
			}
			
			unset($result[0]['cardNumbers']);
			unset($result[0]['cardAmounts']);
			unset($result[0]['orderCreationTimeUTC']);
			unset($result[0]['tableOccupyTimeUTC']);
			unset($result[0]['billSettleTimeUTC']);
			unset($result[0]['voidTimeUTC']);
			unset($result[0]['refunds']);
			unset($result[0]['lastModifiedTimeUTC']);
			
			//Rename keys
			$result[0]['orderCreationTime'] = $result[0]['orderCreationTimeLocal'];
			$result[0]['tableOccupyTime'] = $result[0]['tableOccupyTimeLocal'];
			$result[0]['voidTime'] = $result[0]['voidTimeLocal'];
			
			unset($result[0]['orderCreationTimeLocal']);
			unset($result[0]['tableOccupyTimeLocal']);
			unset($result[0]['voidTimeLocal']);
			unset($result[0]['ID']);
			
			$response['Order'] = $result;
			
			return $response;
		}
        
	}
}
	
	
/* End of Order Class */
?>

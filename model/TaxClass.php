<?php
require_once ('DatabaseClass.php');
require_once ('ResturantClass.php');
require_once (__DIR__ . '/../libs/functions.php');

Class Tax extends Restaurant {
	private $ID;
	private $taxId;
	private $parentTaxId;
	private $accountId;
	private $accountName;
	private $taxName;
	private $nameOnBill;
	private $taxPercent;
	private $taxIsActive;
	
public function getTaxes($restId)
	{
		$table = "rest".$restId."_taxes";
		
		$checkRest = restExists($table) ;
		if($checkRest != true)
			return $checkRest;
		
		$db = new Db();
				
		$local_query = "SELECT taxID,parentTaxID,taxName, nameOnBill,taxPercent,isActive FROM `$table` ";
		$result = $db->select($local_query);
		$endArray = array();
		$endArray["Taxes"] = $result ;
		return $endArray ;
        // $final = json_encode($endArray);
        // echo $final;
	}
	
public function addTax($input_json,$restId)
{
	$data = json_decode($input_json,true);
	$db = new Db();
	
	$ID=$data["ID"];
	$taxId = $data['taxID'];
	$parentTaxId = $data['parentTaxID'];
	$accountId = $data['accountID'];
	$accountName = $data['accountName'];
	$taxName = $data['taxName'];
	$nameOnBill = $data['nameOnBill'];
	$taxPercent = $data['taxPercent'];
	$taxIsActive = $data['isActive'];
	
	$table = "rest".$restId."_taxes";
	
	$checkRest = restExists($table) ;
	if($checkRest != true)
			return $checkRest;
		
	$local_query="INSERT INTO `restX_taxes`(`ID`,`taxID`, `parentTaxID`, `accountID`, `accountName`, `taxName`, `nameOnBill`, `taxPercent`, `isActive`) 
	VALUES ('$ID','$taxId','$parentTaxId','$accountId','$accountName','$taxName','$nameOnBill','$taxPercent','$taxIsActive')";
	echo $local_query;
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

public function updateTax($input_json,$restId,$ID)
{
    $db = new Db();
	$data = json_decode($input_json,true);
	$table = "rest".$restId."_taxes";
	
	$checkRest = restExists($table) ;
	if($checkRest != true)
			return $checkRest;
		
    foreach($data as $key => $value)
    { 
	if($key!="restaurantID")
	{
	$local_query="UPDATE `$table` SET $key='$value' WHERE ID='$ID';";
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

private function deleteTax($input_json)
{
	$data = json_decode($input_json,true);
	$restId = $data['restId'];
	$taxId = $data['taxId'];
	
	$table = "rest".$this->restId."_taxes";
	$checkRest = restExists($table) ;
	if($checkRest != true)
			return $checkRest;
		
	$local_query = "DELETE FROM $table WHERE taxId = {$taxId}";
	
	// Execute Atomically
           try {
				$dbh->beginTransaction();
                $dbh->exec($local_query);
				$dbh->commit();
				echo "New Record Successfully created!";
			}
			catch(PDOException $e) {
				// Rollback transaction if not commit 
				$dbh->rollback();
				echo "Transaction Rolled! Couldn't create record!";
			}
}

	
}
?>
<?php 
/*
$object = new Tax;
$out = $object->getTaxes(1);
print_r($out);
*/
/*
 $input_json = "{\"ID\": 9,\"taxID\": \"TAX6\",\"parentTaxID\": \"\",\"accountID\": 7,\"accountName\": \"SviceTax\",\"taxName\": \"Service x\",\"nameOnBill\": \"Service Tax\",\"taxPercent\": 4.40,\"isActive\": 1}"; 
$input_json = "{\"ID\": 4,\"taxID\": \"TAX8\",\"parentTaxID\": \"\",\"accountID\": 63}";
$object->updateTax($input_json,"X",4);
*/
?>

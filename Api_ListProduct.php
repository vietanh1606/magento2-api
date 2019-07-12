<?php
$userData = array("username" => "testApi", "password" => "admin1234");
$ch = curl_init("http://m2-smtp.mage2develop.com/rest/V1/integration/admin/token");
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($userData));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json", "Content-Lenght: " . strlen(json_encode($userData))));

$token = curl_exec($ch);


$limit = '99999999999';
$currentPage = '1';
if(isset($_GET['limit'])){
	$limit = $_GET['limit'];
}

if(isset($_GET['page'])){
	$currentPage = $_GET['page'];
}

$ch = curl_init("http://m2-smtp.mage2develop.com/rest/V1/products?searchCriteria[pageSize]=$limit&searchCriteria[currentPage]=$currentPage&fields=items[id,sku]");
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json", "Authorization: Bearer " . json_decode($token)));

$result = json_decode(curl_exec($ch));


foreach($result->items as $item){
	
$ch_qty = curl_init("http://m2-smtp.mage2develop.com/rest/V1/stockItems/".$item->sku);	
curl_setopt($ch_qty, CURLOPT_CUSTOMREQUEST, "GET");
curl_setopt($ch_qty, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch_qty, CURLOPT_HTTPHEADER, array("Content-Type: application/json", "Authorization: Bearer " . json_decode($token)));

$result_qty = json_decode(curl_exec($ch_qty));	
	echo "Product Id: ".$item->id; echo "<br>";
	echo "Product Sku: ".$item->sku; echo "<br>";
	if($result_qty->qty){
		echo "Qty: ".$result_qty->qty; echo "<br>";
	}
	echo "---------------------------------------------------------------";echo "<br><br>";
}

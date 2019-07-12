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

$ch = curl_init("http://m2-smtp.mage2develop.com/rest/V1/shipments?searchCriteria[pageSize]=$limit&searchCriteria[currentPage]=$currentPage");
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json", "Authorization: Bearer " . json_decode($token)));

$result = json_decode(curl_exec($ch));

if(count($result->items)>0){
	foreach($result->items as $item){
		echo "Shipmment Id: ".$item->entity_id; echo "<br>";
		echo "increment_id: ".$item->increment_id; echo "<br>";
		if($item->tracks){
			foreach($item->tracks as $track){
				echo "Track Title: ".$track->title; echo "<br>";
				echo "carrier_code: ".$track->carrier_code; echo "<br>";
				echo "track_number: ".$track->track_number; echo "<br>";
			}
		}
		echo "---------------------------------------------------------------";echo "<br><br>";
	}
}else{
	echo "no result";
}



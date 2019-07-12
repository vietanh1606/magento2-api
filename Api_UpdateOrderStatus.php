<?php
$userData = array("username" => "testApi", "password" => "admin1234");
$ch = curl_init("http://m2-smtp.mage2develop.com/rest/V1/integration/admin/token");
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($userData));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json", "Content-Lenght: " . strlen(json_encode($userData))));

$token = curl_exec($ch);

$data = array();
$data['entity'] = array("entity_id" => "6","status"=> "processing","increment_id"=> "3008000006");

$ch = curl_init("http://m2-smtp.mage2develop.com/rest/V1/orders");
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json", "Authorization: Bearer " . json_decode($token)));

$result = json_decode(curl_exec($ch));

if(isset($result->message)){
	echo $result->message;
}else{
	echo "Order Status: ".$result->status;
}

<?php
$userData = array("username" => "testApi", "password" => "admin1234");
$ch = curl_init("http://m2-smtp.mage2develop.com/rest/V1/integration/admin/token");
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($userData));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json", "Content-Lenght: " . strlen(json_encode($userData))));

$token = curl_exec($ch);


// ASCII Character. %20 : space

$from = "1970-01-01%2000:00:00";
$to = "2100-01-01%2011:59:59";
$limit = '99999999999';
$currentPage = '1';


if(isset($_GET['from'])){
	$from = $_GET['from'];
}

if(isset($_GET['to'])){
	$to = $_GET['to'];
}

if(isset($_GET['limit'])){
	$limit = $_GET['limit'];
}

if(isset($_GET['page'])){
	$currentPage = $_GET['page'];
}



$ch = curl_init("http://m2-smtp.mage2develop.com/rest/V1/orders?searchCriteria[filter_groups][0][filters][0][field]=created_at&searchCriteria[filter_groups][0][filters][0][value]=$from&searchCriteria[filter_groups][0][filters][0][condition_type]=from&searchCriteria[filter_groups][1][filters][1][field]=created_at&searchCriteria[filter_groups][1][filters][1][value]=$to&searchCriteria[filter_groups][1][filters][1][condition_type]=to&searchCriteria[pageSize]=$limit&searchCriteria[currentPage]=$currentPage");

curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json", "Authorization: Bearer " . json_decode($token)));

$result = json_decode(curl_exec($ch));

echo "<pre>";var_dump($result);die;


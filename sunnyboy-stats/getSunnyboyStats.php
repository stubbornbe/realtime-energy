<?php
/***********
PHP script to read out Sunnyboy values and writeout to file in json format

Inputs needed: 
- URL of Sunnyboy (Fixed IP / DHCP reservation needed)
- Password of the "user" user
- Path to store the current API token

To prevent new API login every run, the API token is written to sunnyToken.txt and tested first before issuing a new token.
If you find the location insecure, set up a proper one.

***********/
/***********TO CONFIGURE************/
$url="https://192.168.254.251/dyn/";
$pw="SMA1234sma!";
$sunnyTokenPath=".";
/***********END TO CONFIGURE************/

$sunnySessionId=false;
$returnValue=false;

// Check if there is a tokenfile present, if so read its contents
if(file_exists($sunnyTokenPath.'/sunnyToken.txt')){
	$sunnySessionId = file_get_contents($sunnyTokenPath.'/sunnyToken.txt', true);
	if(($sunnySessionId=="")||(strlen($sunnySessionId)!=16)){
		$sunnySessionId=false;
	}
}

// If there is a sessiontoken found, try it first, if it doesn't work, issue a new token.
if($sunnySessionId!==false){
	$returnValue=getSunnyValues($url,$sunnySessionId);
	
	if((isset($returnValue['err']))&&($returnValue['err']==401)){
		echo "er kwam een loginerror";
		renewSunnySession($url,$pw);
		$returnValue=getSunnyValues($url,$sunnySessionId);
	}
}else{//If there is no token present, get one before trying.
	renewSunnySession($url,$pw);
	$returnValue=getSunnyValues($url,$sunnySessionId);
}

if(isset($returnValue['result'])){
	$key=array_key_first($returnValue["result"]);
	$opwekNu=$returnValue["result"][$key]["6100_40263F00"][1][0]["val"]/1000; 
	$opwekVandaag=$returnValue["result"][$key]["6400_00260100"][1][0]["val"];
	
	$myTarget = fopen("sunnyValues.txt",'w') ;
	fwrite($myTarget,json_encode(array('result' => "success",'sunnyOut'=> $opwekNu,'sunnyTotal'=> $opwekVandaag)));
	fclose($myTarget);
}

//Code to get a new API token from the Sunny device
function renewSunnySession($url,$pw){
	$ch = curl_init($url."login.json");

	$payload = json_encode( array( 'pass' => $pw,'right' => "usr" ) );
	curl_setopt( $ch, CURLOPT_POSTFIELDS, $payload );
	curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
	curl_setopt( $ch, CURLOPT_SSL_VERIFYHOST, 0);
	curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, 0);
	curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
	$result = curl_exec($ch);
	curl_close($ch);
	
	$jsonResult=json_decode($result);
	if(isset($jsonResult->result->sid)){
		$myTarget = fopen($sunnyTokenPath."sunnyToken.txt",'w') ;
		fwrite($myTarget,$jsonResult->result->sid);
		fclose($myTarget);
	}
}

//Get the current values of the Sunnyboy
function getSunnyValues($url,$sunnySessionId){

	$fUrl=$url."getValues.json?sid=".$sunnySessionId;
	//echo $fUrl."<br>";
	$ch = curl_init($fUrl);
	// Setup request to send json via POST.
	// device_error = {'tag': '6100_00412000', 'unit': 'W'}
	// device_state = {'tag': '6180_084B1E00', 'unit': 'W'}
	// device_warning = {'tag': '6100_00411F00', 'unit': 'W'}
	// power_amp = {'tag': '6100_40465300', 'unit': 'A'}
  // power_b = {'tag': '6380_40451F00'}
	// power_current = {'tag': '6100_40263F00', 'unit': 'W'}
	// productivity_total = {'tag': '6400_00260100'}
	// ...
	// Find all the possible codes on: https://sma-sunnyboy.readthedocs.io/en/latest/sma_sunnyboy.html#sma_sunnyboy.key.Key.power_current
	
	$payload = json_encode(array('destDev'=>array(),'keys'=>array("6100_40263F00","6400_00260100","6100_00412000","6180_084B1E00","6100_00411F00")) );//Enter the codes you're interested in
	curl_setopt( $ch, CURLOPT_POSTFIELDS, $payload );
	curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
	curl_setopt( $ch, CURLOPT_SSL_VERIFYHOST, 0);
	curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, 0);
	curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
	$result = curl_exec($ch);
	curl_close($ch);
	
	$jsonResult=json_decode($result,true);
	//print_r($jsonResult); 
	return $jsonResult;
}

?>



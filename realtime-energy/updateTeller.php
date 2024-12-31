<?php
include('config.php');
$file=file_get_contents($path_to_EnergyMeter_json,true);
$array=json_decode($file);

$arrayAssoc=array(0);
foreach($array as $key=>$value){
  $arrayAssoc[$value['0']]=array("val"=>$value['1'],"unit"=>$value['2']);
}
/*
echo "<pre>";
print_r($arrayAssoc);
echo "</pre>";
*/
if(isset($array)){
  
  $timeParts=str_split($arrayAssoc['Timestamp']["val"],2);
  
  $naarKwartier=$timeParts[4];
  if($naarKwartier>45){
    $naarKwartier-=45;
  }elseif($naarKwartier>30){
    $naarKwartier-=30;
  }elseif($naarKwartier>15){
    $naarKwartier-=15;
  }
  
  $time=str_pad($naarKwartier,2,0,STR_PAD_LEFT)." : ".$timeParts[5];

  //$arrayAssoc['All phases consumption']["val"]=0;
  //$arrayAssoc['All phases production']["val"]=2.235;

  print json_encode(array(
    'result' => "success",
    'verbruik'=> number_format($arrayAssoc['All phases consumption']["val"],3,".",""),
    'opbrengst'=> number_format($arrayAssoc['All phases production']["val"],3,".",""),
    'gas'=> $arrayAssoc['Gas consumption']["val"],
    'maandPiek'=> $arrayAssoc['Maximum demand active energy import curr month']["val"],
    'kwartPiek'=> $arrayAssoc['Current avg demand active energy import']["val"],
    'timestamp'=> $time
  ));
}else{
  //file was probably locked...return 0's for now, it will recover 1 second later.
  print json_encode(array('result' => "error",'verbruik'=> 0,'opbrengst'=> 0,'gas'=> 0,'maandPiek'=>0,'kwartPiek'=>0,'timestamp'=>0));
}

exit;
?>

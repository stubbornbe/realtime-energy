<?php
$no_http_headers = true;
error_reporting(E_ERROR);

if (!isset($called_by_script_server)) {
    array_shift($_SERVER["argv"]);
    print call_user_func_array("ss_getTellerData", $_SERVER["argv"]);
}

function ss_getTellerData() {
  $file=file_get_contents("/usr/share/tellerpoller/tellerdata.json",true);
  $array=json_decode($file);
  $arrayAssoc=array(0);
  foreach($array as $key=>$value){
    $arrayAssoc[$value['0']]=array("val"=>$value['1'],"unit"=>$value['2']);
  }
  return "opbrengst:".$arrayAssoc['All phases production']["val"]." verbruik:".$arrayAssoc['All phases consumption']["val"];
}
?>

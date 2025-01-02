<?php
$no_http_headers = true;
error_reporting(E_ERROR);

if (!isset($called_by_script_server)) {
    array_shift($_SERVER["argv"]);
    print call_user_func_array("ss_getSunnyData", $_SERVER["argv"]);
}

function ss_getSunnyData() {
  $file=file_get_contents("/usr/share/sunnypoller/sunnydata.json",true);
  $array=json_decode($file,true);
  if(isset($array)){
    return "opbrengst:".$array["sunnyOut"];
  }else{
    return "opbrengst:0";
  }
}
?>

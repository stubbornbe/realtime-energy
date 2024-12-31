<?php
include('config.php');
$file=file_get_contents($path_to_SMA_json,true);
$array=json_decode($file,true);

//$array['sunnyOut']=5.235;

if(isset($array)){
  print json_encode(array('result' => "success",'opbrengst'=> number_format($array['sunnyOut'],3,".","")));
}else{
  print json_encode(array('result' => "error",'opbrengst'=> 0));
}

exit;
?>

<?php

define('UPLOAD_DIR',$_SERVER['DOCUMENT_ROOT'].'/imageEvent/');

// after $_SERVER['DOCUMENT_ROOT']. your root inside public_html folder if any or '/'.

$Imagecode=$_POST['Image']; // parameter

$img=base64_decode($Imagecode);
$uid=uniqid();

$file = UPLOAD_DIR . $uid . '.jpg';
$success = file_put_contents($file, $img);

if ($success)
{
  echo $uid.'.jpg';
}
else
{
  echo "error";
}

?>
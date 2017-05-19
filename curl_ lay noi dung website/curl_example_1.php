<?php

set_time_limit(0);
 
$ch = curl_init();
  
curl_setopt($ch, CURLOPT_URL, "http://ketqua.net/");

curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  
$result = curl_exec($ch);
  
curl_close($ch);
  
echo ($result);
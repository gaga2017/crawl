<?php

set_time_limit(0);
 
$ch = curl_init();
  
curl_setopt($ch, CURLOPT_URL, "http://cdn.vietdesigner.net/data/images/dl/2012/05/29/Baby-Photo-VietDesigner.net-11.jpg");

curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_BINARYTRANSFER, 1);


  
$result = curl_exec($ch);
  
curl_close($ch);

header("Content-type: image/jpeg");
echo $result;
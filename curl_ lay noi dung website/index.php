<?php

$url = 'http://dantri.com.vn/';


$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 6.1; WOW64; rv:46.0) Gecko/20100101 Firefox/46.0");
curl_setopt($ch, CURLOPT_REFERER, "https://www.google.com/?gws_rd=ssl");


$data = curl_exec($ch);

curl_close($ch);

echo htmlspecialchars($data);
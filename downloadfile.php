<meta charset="utf-8">>
<?php

error_reporting(E_ERROR);

set_time_limit(0); 

//$url = 'http://mp3.zing.vn/';

$proxy = trim(file_get_contents('proxy.txt'));

//echo get_data($url,$proxy);

////////////////////////download file//////////////////////////////////////
$r = download_file('https://r2---sn-42u-nbole.googlevideo.com/videoplayback?api=videoapi.io&id=328f543f0924fb32&itag=18&source=webdrive&requiressl=yes&ttl=transient&pl=22&ei=Xef-WMbWM8_LqAXOs5XQAw&mime=video/mp4&lmt=1491093400627755&ip=42.112.92.174&ipbits=0&expire=1493114781&sparams=ei,expire,id,ip,ipbits,itag,lmt,mime,mm,mn,ms,mv,pl,requiressl,source,ttl&signature=67551CEA97626F7FABBCB0334B384F632F37878F.6512E421FA9D9A9CFF03E04ED8D2FFF4B042A280&key=cms1&app=explorer&cms_redirect=yes&mm=31&mn=sn-42u-nbole&ms=au&mt=1493103504&mv=m','cao zingmp3/nhac/b.mp4');

if(empty($r)){
    echo 'download sucess';
}else{
    echo 'download fail: ' . $r;
}



//hàm download file: return string(messeage error) :download thành công return '', thất bại return messessage error (do hàm curl_erro($ch))
 function download_file($url , $path){ //path:drectory phải đầy đủ: thư mục/tên file.định dạng~~
     $ch = curl_init($url);
     
     $f = fopen($path, 'w');// mở file để ghi
     curl_setopt($ch, CURLOPT_FILE, $f);// curl làm việc với file, download file
     curl_setopt($ch, CURLOPT_TIMEOUT, 28800);//set thời gian time out (ở đây 8 tiếng): download file có file nặng


     curl_exec($ch);
     

     //kiểm tra cào thành công hay k (ở đây là download)
     $e = curl_error($ch);// '' : sucess  , trả về $ string' messeage erro' :fail

     
     curl_close($ch);
     fclose($f);
     
     return $e;
 }

///////////////////////////end download file/////////////////////////////////////////
function get_data($link, $proxy = null, $proxy_type = null){
	$ch = curl_init(); 
	
	curl_setopt($ch, CURLOPT_URL, $link);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:46.0) Gecko/20100101 Firefox/46.0');
	curl_setopt($ch, CURLOPT_REFERER, 'https://www.google.com/');
	curl_setopt($ch, CURLOPT_ENCODING, '');
	curl_setopt($ch, CURLOPT_TIMEOUT, 20);
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 20);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
	curl_setopt($ch, CURLOPT_MAXREDIRS, 5);
        
        if(isset($proxy) && check_proxy_live($proxy)){
            //proxy
            curl_setopt($ch, CURLOPT_PROXY, $proxy);

            if(isset($proxy_type))
                curl_setopt($ch, CURLOPT_PROXYTYPE, $proxy_type);
        }
        
        
        
	$data = curl_exec($ch); 
	
	curl_close($ch);
	
	return $data;
}   




function check_proxy_live($proxy){
    $waitTimeoutInSeconds = 1; 
    
    $proxy_split = explode(':', $proxy);
    
    $ip = $proxy_split[0];
    $port = $proxy_split[1];
    
    $result = false;
         
    if($fp = fsockopen($ip,$port,$errCode,$errStr,$waitTimeoutInSeconds)){   
       $result = true;
       fclose($fp);
    }  
     
    return $result;
}

function check_proxy_lives($proxys){
    $proxy_lives = array();
    
    for($i = 0; $i < count($proxys); ++$i){
        $p = $proxys[$i];
        if(check_proxy_live($p)){
           $proxy_lives[] = $p;
        }
    }
    
    return $proxy_lives;
}


//$proxy_txt = file_get_contents('proxy_list.txt');
//$lines = explode("\r\n", $proxy_txt); 
//
//var_dump(check_proxy_lives($lines));


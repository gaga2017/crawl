<form action="index3.php" method="get" accept-charset="utf-8">
  <input type="text" name="url" value="" placeholder="link nhạc">

  <button type="submit">OK</button>
</form>


<?php 
set_time_limit(0);
//dùng function  downloadFile để download
// với những link mà như goole,zing: k có đuôi đường sau, nên dùng phương thức này download mới được, ram???   











$url = $_GET['url']; 
// echo $url;

 
if(get_data($url, $html)){
    //Get xml link
    // echo htmlspecialchars($html);


    preg_match('#data-xml="(.+?)">#is', $html, $matches);
    // var_dump( $matches);

    $xml_link = "http://mp3.zing.vn".$matches[1];
    //var_dump($xml_link);
    if(get_data($xml_link, $xml)){
         //TODO
         var_dump($xml);//in file json
         //lấy link nhạc
        preg_match('#source_list":\["(.+?)"#is', $xml, $link_nhac);
        // var_dump($link_nhac);
          echo  "<h3> link nhạc nè: ".$link_nhac[1]."</h3>";//$link_nhac[1]: lấy bên trong (.+?)

          //lấy tiêu đề bài nhạc
          preg_match('#name":"(.+?)"#is', $xml, $name_file);
          var_dump($name_file);
          echo "<h3> tên bài hét nè: ".$name_file[1]."</h3>";
          //download nhạc
          if(downloadFile($link_nhac[1],"nhac/".$name_file[1].".mp3")){
            echo "download bài nhạc thành công";
          }
          else{
            echo "download bài nhạc không thành công";
          }


     }else{
      echo 'Khong the lay duoc xml';
     }
}else{
    echo 'Khong the lay du lieu trang n';
}
 

//get data: return boolean 
// chú ý: parameter: link + biến tham chiếu (&$data) khi truyền vào sẽ lấy và trả về nội dung web:$data = curl_exec($ch); 
function get_data($link, &$data = ''){
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
         
	$data = curl_exec($ch); 
        
        $error = curl_error($ch);
        curl_close($ch);
        
        if(empty($error)){
            return true;
        } 
	 
	return false;
}   

 function downloadFile($url, $path) // url tất nhiên dạng http:// k nó nhận diện của host,,, còn path: directory/ namefile.định dạng~~
{
   $newfname = $path;
    $file = fopen ($url, 'rb');
    if ($file) {
        $newf = fopen ($newfname, 'wb');
        if ($newf) {
            while(!feof($file)) {
                fwrite($newf, fread($file, 1024 * 8), 1024 * 8);
            }
        }
    }
    else 
      return false;
    if ($file) {
        fclose($file);
    }
    if ($newf) {
        fclose($newf);
    }
    return true;
}

 ?>
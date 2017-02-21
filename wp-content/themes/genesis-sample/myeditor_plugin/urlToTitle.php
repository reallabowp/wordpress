<?php
function file_get_contents_curl($url){
  $ch = curl_init();

  if($ch === FALSE) {
    return false;
  }

  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_HEADER, false);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
  curl_setopt($ch,CURLOPT_SSL_VERIFYPEER, false);
  $data = curl_exec($ch);
  curl_close($ch);

  return $data;
}

$url = $_REQUEST["url"];
$html = file_get_contents_curl($url);

if($html == FALSE){
  $url = parse_url($url);
  $title = $url['host'];
}else{
  if(preg_match('/<title>(.*?)<\/title>/i', $html, $matches)==1){
    $title = mb_convert_encoding($matches[1], 'UTF-8', "ASCII,JIS,UTF-8,EUC-JP,SJIS-win");
  }else{
    $url = parse_url($url);
    $title = $url['host'];
  }
}

echo json_encode(array("url" => $url, "title" => $title));

?>

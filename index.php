<?php
include 'config.php';
require 'libs/phpQuery.php';
function print_arr($arr){
	echo '<pre>'.print_r($arr, true).'</pre>';
}
function get_content($url, $search){
	if (!function_exists('curl_init')){
		die('Sorry cURL is not installed!');
	}
	$get_url = $url.$search;
	$ch = curl_init($get_url);
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch,CURLOPT_USERAGENT,'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');
	curl_setopt($ch, CURLOPT_REFERER, 'https://www.google.com');
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$res = curl_exec($ch);
	
	curl_close($ch);
	return $res;
}
if(isset($_POST['search']) && $_POST['search'] != ''){
	$str = $_POST['search'];
}
$url = 'https://www.google.com.ua';
$count_links = 15;
$input_value = str_replace(' ', '+', $str);
$search = '/search?num='.$count_links.'&q='.$input_value;
$file = get_content($url, $search);
$doc = phpQuery::newDocument($file);
$title = [];
$address = [];
$text = [];
foreach($doc->find('.g') as $one){
	$one = pq($one);
	$title[] = $one->find('h3')->text();
	$address[] = $one->find('.s cite')->text();
	$text[] = $one->find('.s span')->text();
}
foreach($address as $k => $v){
	if($v == '') continue;
	$tmp = explode("/", $v);
	if($tmp[0] != 'https:'){
		array_unshift($tmp, "http:/");
	}
	$address[$k] = implode("/", $tmp); 
}
$content = [];
for($i = 0; $i < $count_links; $i++){
	$content[$i]['title'] = $title[$i];
	$content[$i]['url'] = $address[$i];
	$content[$i]['text'] = $text[$i];
}
include (TEMPLATE);
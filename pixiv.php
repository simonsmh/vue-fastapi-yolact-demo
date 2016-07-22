<?php
//图片url指向此文件即可,参数?num=NUM为排行榜第NUM-1位，限制50
$i = max(0,$_GET["num"]);
//设置图片头
header('Content-type: image/jpg');
$html = curl_get('http://www.pixiv.net/ranking.php?mode=daily&content=illust');
//匹配缩略图url \d为整数数字，{num}为位数
preg_match_all('|http://i\d\.pixiv\.net/c/240x480/img-master/img/\d{4}/\d{2}/\d{2}/\d{2}/\d{2}/\d{2}/(.*?\.\w{3})|', $html, $image);
//匹配链接
preg_match_all('|member_illust.php\?mode=medium&amp;illust_id=\d+&amp;ref=rn-b-\d+-title-\d&amp;uarea=daily|', $html, $url);
//拼凑高分辨率图片url
$url = str_ireplace('240x480','600x600',$image[0][$i]);
//输出图片
$f = curl_get($url, array('Referer: http://www.pixiv.net/login.php'));
echo $f;

//简易CURL设置header读取数据函数
function curl_get($url, array $header = array()){
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
curl_setopt($ch, CURLOPT_TIMEOUT, 10);
$data = curl_exec($ch);
curl_close($ch);
return $data;
}
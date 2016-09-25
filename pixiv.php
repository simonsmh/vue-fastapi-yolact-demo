<?php
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
//图片url指向此文件即可,参数?num=NUM为排行榜第NUM-1位，限制50
$i = max(0,$_GET["num"]);
//设置图片头
header('Content-type: image/jpg');
$html = curl_get('http://www.pixiv.net/ranking.php?mode=daily&content=illust');
//匹配缩略图url \d为整数数字，{num}为位数
preg_match_all('|http://i\d\.pixiv\.net/c/240x480/img-master/img/\d{4}/\d{2}/\d{2}/\d{2}/\d{2}/\d{2}/(.*?\.\w{3})|', $html, $image);
//拼凑高分辨率图片url
$url = str_ireplace('c/240x480/img-master','img-original',$image[0][$i]);
$url = str_ireplace('_master1200','',$url);
//输出图片
$f = curl_get($url, array('User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/55.0.2868.3 Safari/537.36','Referer: http://www.pixiv.net/member_illust.php?mode=medium&illust_id='.str_ireplace('_p0_master1200.jpg','',$image[1][$i])));
echo $f;

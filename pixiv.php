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
//匹配链接
preg_match_all('|member_illust.php\?mode=medium&amp;illust_id=\d+&amp;uarea=daily&amp;ref=rn-b-\d+-thumbnail-\d|', $html, $url);
curl_get('http://www.pixiv.net/'.$url,array('User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/55.0.2868.3 Safari/537.36')
//拼凑高分辨率图片url
//$url = str_ireplace('240x480','600x600',$image[0][$i]);
$url = str_ireplace('c/240x480/img-master','img-original',$image[0][$i]);
//输出图片
$f = curl_get($url, array('User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/55.0.2868.3 Safari/537.36','Cookie: p_ab_id=3; device_token=dc73dd297a69f83310ad0f2096efeecc; module_orders_mypage=%5B%7B%22name%22%3A%22hot_entries%22%2C%22visible%22%3Atrue%7D%2C%7B%22name%22%3A%22everyone_new_illusts%22%2C%22visible%22%3Atrue%7D%2C%7B%22name%22%3A%22sensei_courses%22%2C%22visible%22%3Atrue%7D%2C%7B%22name%22%3A%22spotlight%22%2C%22visible%22%3Atrue%7D%2C%7B%22name%22%3A%22featured_tags%22%2C%22visible%22%3Atrue%7D%2C%7B%22name%22%3A%22contests%22%2C%22visible%22%3Atrue%7D%2C%7B%22name%22%3A%22following_new_illusts%22%2C%22visible%22%3Atrue%7D%2C%7B%22name%22%3A%22mypixiv_new_illusts%22%2C%22visible%22%3Atrue%7D%2C%7B%22name%22%3A%22booth_follow_items%22%2C%22visible%22%3Atrue%7D%5D; PHPSESSID=8378198_41a5a6393b641e9390094eac65ef4bc2; __utma=235335808.227668832.1472356644.1474002779.1474787936.3; __utmb=235335808.2.10.1474787936; __utmc=235335808; __utmz=235335808.1472356644.1.1.utmcsr=(direct)|utmccn=(direct)|utmcmd=(none); __utmv=235335808.|2=login%20ever=yes=1^3=plan=normal=1^5=gender=male=1^6=user_id=8378198=1','Referer: http://www.pixiv.net/member_illust.php?mode=medium&illust_id='.str_ireplace('_p0_master1200.jpg','',$image[1][$i])));
echo $f;

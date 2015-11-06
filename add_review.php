<meta http-equiv="refresh" content="0;url=review.php">
<?php
$user = $_POST['username'];
$content = $_POST['content'];
$time = date('Y-m-d H:i',time());
if (($user=="") and ($content=="")){
echo "<script type='text/javascript'>alert('请填写内容');</script>";
}else{
$user = str_replace('<',"&lt;",$user);
$user = str_replace('>',"&gt;",$user);
$user = trim($user);
$user = preg_replace("/\t/","",$user);
$user = preg_replace("/\r\n/","<br/>",$user);
$user = preg_replace("/\r/","<br/>",$user);
$user = preg_replace("/\n/","<br/>",$user);
$content = str_replace('<',"&lt;",$content);
$content = str_replace('>',"&gt;",$content);
$content = trim($content);
$content = preg_replace("/\t/","",$content);
$content = preg_replace("/\r\n/","<br/>",$content);
$content = preg_replace("/\r/","<br/>",$content);
$content = preg_replace("/\n/","<br/>",$content);
$txt = fopen('review.txt','a+');
$hh = "\r\n";
$zc = "用户: $user 时间: $time <br> 留言: <br> $content <br> $hh ";
$write = fwrite($txt,$zc);
fclose($txt);
}
?>
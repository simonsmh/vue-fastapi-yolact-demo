<meta http-equiv="refresh" content="0;url=review.php">
<?php
$user = $_POST['username'];
$content = $_POST['content'];
$time = date('Y-m-d H:i',time());
if (($user=="") and ($content=="")){
echo "<script type='text/javascript'>alert('请填写内容');</script>";
}else{
$txt = fopen('review.txt','a+');
$hh = "\r\n";
$zc = "用户: $user 时间： $time <br> 留言： $content <br> $hh ";
$write = fwrite($txt,$zc);
fclose($txt);
}
?>
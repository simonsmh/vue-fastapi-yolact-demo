<?php
$http = "http://";
$choose = $_POST['choose'];
$website = $_POST['website'];
if (strstr($website,"https://")=="" and strstr($website,"http://")==""){
$website = $http.$_POST['website'];
}
$fh = file_get_contents($website);
if ($choose==""){
$fh = str_replace('<',"&lt;",$fh);
$fh = str_replace('>',"&gt;<br>",$fh);
} 
if ($fh==""){
echo "网址错误";
}
echo $fh;
?>
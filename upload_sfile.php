<html class="js" lang="zh-CN">
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<meta http-equiv=refresh content="5;url=files.php">
<meta name="viewport" content="width=device-width">
</head>
<body><a href="files.php">../</a></br>
<?php
$dir = "sfiles/";
if ($_FILES["file"]["error"] > 0)
  {
    echo "发生错误:".$_FILES["file"]["error"]."<br>";
  }
else
  {
    echo "上传文件:".$_FILES["file"]["name"]."<br>";
    echo "文件类型:".$_FILES["file"]["type"]."<br>";
    echo "文件大小:".($_FILES["file"]["size"]/1000000)."MiB<br>";
    echo "临时文件:".$_FILES["file"]["tmp_name"]."<br>";
    if (file_exists($dir.$_FILES["file"]["name"]))
    {
      echo $_FILES["file"]["name"]."<br>"."警告：文件已经存在并被删除."."<br>";
      unlink ($dir.$_FILES["file"]["name"]); 
    }
    move_uploaded_file($_FILES["file"]["tmp_name"],
    $dir.$_FILES["file"]["name"]);
    echo "存放位置:".$dir.$_FILES["file"]["name"];
  }
?>
</body>
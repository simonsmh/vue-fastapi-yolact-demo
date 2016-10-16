<!DOCTYPE html>
<html lang="zh-cn">
<?php 
if($_GET["up"] == 1){
echo "<script type='text/javascript'>alert('";
$dir = "/var/wwwfiles/files/";
if ($_FILES["file"]["error"] > 0){
echo "发生错误:".$_FILES["file"]["error"];
}else{
echo "上传文件:".$_FILES["file"]["name"]." \/n ";
echo "文件类型:".$_FILES["file"]["type"]." \/n ";
echo "文件大小:".($_FILES["file"]["size"]/1000000)."MiB \/n ";
echo "临时文件:".$_FILES["file"]["tmp_name"]." \/n ";
if (file_exists($dir.$_FILES["file"]["name"])){
echo "警告:文件已经存在并被删除.";
unlink ($dir.$_FILES["file"]["name"]); 
}
move_uploaded_file($_FILES["file"]["tmp_name"],
$dir.$_FILES["file"]["name"]);
echo "存放位置:".$dir.$_FILES["file"]["name"];}
echo "');location.replace(document.referrer);document.frames('ifrmname').location.reload();</script>";
}else{include( "header.php");
echo <<<EOF
 <body> 
<div class="navbar-fixed"> 
  <nav class="indigo" role="navigation"> 
   <div class="nav-wrapper container"> 
    <a id="logo-container" href="files.php" class="brand-logo"> 文件储存 </a> 
    <ul class="right hide-on-med-and-down"> 
     <li> <a class="dropdown-button waves-effect waves-light" href="#" data-activates="dropdown1"> 菜单 <i class="material-icons right"> &#xE5C5; </i> </a> </li> 
    </ul> 
    <ul id="dropdown1" class="dropdown-content"> 
EOF;
include( "nav.php"); 
echo <<<EOF
    </ul> 
    <ul id="nav-mobile" class="side-nav"> 
EOF;
include( "nav.php"); 
echo <<<EOF
    </ul> 
    <a href="#" data-activates="nav-mobile" class="button-collapse"> <i class="material-icons"> &#xE5D2; </i> </a> 
   </div> 
  </nav> 
</div> 
  <div class="section no-pad-bot" id="index-banner"> 
   <div class="container"> 
    <br /> 
    <br /> 
    <h2 class="header center orange-text"> &nbsp;simonsmh <br /> 文件储存 </h2> 
    <div class="row center"> 
     <h5 class="header col s12 light"> 恩，快交出文件！ </h5> 
    </div> 
    <div class="progress"> 
     <div class="indeterminate indigo"> 
     </div> 
    </div> 
    <br /> 
   </div> 
  </div> 
  <div class="container"> 
   <div class="section"> 
    <form id="file" name="file" action="files.php?up=1" method="post" enctype="multipart/form-data"> 
     <div class="file-field input-field"> 
      <div class="btn orange"> 
       <span> 选择文件 </span> 
       <input type="file" name="file" id="file" /> 
      </div> 
      <div class="file-path-wrapper"> 
       <input class="file-path validate" type="text" placeholder="文件名" /> 
      </div> 
      <button class="btn orange waves-effect waves-light" onclick="submit()" type="submit" name="action">上传 <i class="material-icons right">send</i> </button> 
     </div> 
    </form> 
    <br /> 
    <iframe name="showfiles" src="files/" width="100%" height="500" frameborder="0"> &lt;p&gt; visit /files/ &lt;/p&gt; </iframe> 
   </div> 
  </div> 
EOF;
include( "footer.php"); 
echo "</body></html>";}
?>
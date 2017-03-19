<!DOCTYPE html>
<html lang="zh-cn">
<?php 
if($_GET["up"] == 1){
echo "<script type='text/javascript'>alert('";
if ($_FILES["file"]["error"] > 0){
echo "发生错误:".$_FILES["file"]["error"];
}else{
$units = array(' B',' KB',' MB',' GB',' TB',' PB',' EB',' ZB',' YB'); 
for ($i = 0; $_FILES["file"]["size"] >= 1024 && $i < 8; $i++){
$_FILES["file"]["size"] /= 1024;
}
$_FILES["file"]["size"] = round($_FILES["file"]["size"], 2).$units[$i]; 
echo "上传文件:".$_FILES["file"]["name"]." \/n ";
echo "文件类型:".$_FILES["file"]["type"]." \/n ";
echo "文件大小:".$_FILES["file"]["size"]." \/n ";
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
    <a href="#" data-activates="nav-mobile" class="button-collapse"> <i class="material-icons"> &#xE5D2; </i> </a> 
   </div> 
  </nav> 
</div> 
<ul id="nav-mobile" class="side-nav"> 
EOF;
include( "nav.php"); 
echo <<<EOF
  </ul> 
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
   <div class="row">
    <div class="col s12">  
    <form id="file" name="file" action="files.php?up=1" method="post" enctype="multipart/form-data"> 
     <div class="file-field input-field"> 
      <div >
       <button class="btn orange waves-effect waves-light" onclick="submit()" type="submit" name="action">上传 <i class="material-icons right">send</i> </button> 
      </div>
      <div class="btn orange waves-effect waves-light"> 
       <span> 选择文件 </span> 
       <input type="file" name="file" id="file"> 
      </div> 
      <div class="file-path-wrapper"> 
       <input class="file-path validate" type="text" placeholder="文件名"> 
      </div> 
     </div> 
    </form> 
    </div>
    <div class="col s12"> 
EOF;
$dir = "/var/wwwfiles/files/";
$webdir = "files";
$files = array_diff(scandir(dirname($dir.urldecode($_SERVER["REQUEST_URI"]))), array('.','..',));
echo "<table class='bordered'><thead><tr><th data-field='name'>文件名</th><th data-field='time'>修改时间</th><th data-field='size'>文件大小</th></tr>";
foreach ($files as $filename){
$stat = stat($dir.$filename);
if (is_file($dir.$filename)){
$units = array(' B',' KB',' MB',' GB',' TB',' PB',' EB',' ZB',' YB'); 
for ($i = 0; $stat['size'] >= 1024 && $i < 8; $i++){
$stat['size'] /= 1024;
}
$stat['size'] = round($stat['size'], 2).$units[$i]; 
echo "<tr><td  style='word-break:break-all'><a href='".dirname(urldecode($_SERVER["REQUEST_URI"])).$webdir."/".$filename."'>".$filename."</a></td>";
}else{
$stat['size'] = "DIR";
echo "<tr><td  style='word-break:break-all'><a href='".dirname(urldecode($_SERVER["REQUEST_URI"])).$webdir."/".$filename."/index.php'>".$filename."</a></td>";
}
echo "<td>".date('Y-m-d H:i:s',$stat['mtime'])."</td>";
echo "<td>".$stat['size']."</td></tr>";
}
echo "</thead></table>";
echo "</div></div></div></div>";
include("footer.php"); 
echo "</body></html>";}
?>

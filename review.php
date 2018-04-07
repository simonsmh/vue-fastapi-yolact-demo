<!DOCTYPE html>
<html lang="zh-cn">
 <?php include( "header.php"); ?>
 <head></head>
 <body> 
<div class="navbar-fixed"> 
  <nav class="indigo" role="navigation"> 
   <div class="nav-wrapper container"> 
    <a id="logo-container" href="review.php" class="brand-logo"> 留言板 </a> 
    <?php include( "bar.php"); ?>
   </div>
  </nav>
</div>
<ul id="dropdown1" class="dropdown-content">
 <?php include( "nav.php"); ?>
</ul>
<ul id="nav-mobile" class="sidenav">
 <?php include( "nav.php"); ?>
</ul>
  <div class="section no-pad-bot" id="index-banner"> 
   <div class="container"> 
    <br /> 
    <br /> 
    <h2 class="header center orange-text"> &nbsp;simonsmh <br /> 留言板 </h2> 
    <div class="row center"> 
     <h5 class="header col s12 light"> 嘿，快来吐槽！ </h5> 
    </div> 
    <div class="progress"> 
     <div class="indeterminate indigo"> 
     </div> 
    </div> 
    <br /> 
        <div class="fixed-action-btn" style="bottom: 120px; right: 24px;">
         <a href="#review" class="waves-effect waves-light btn-floating btn-large red"><i class="large material-icons">&#xE3C9;</i></a>
        </div>
   </div> 
  </div> 
  <div class="container"> 
   <div class="section"> 
<?php
if ($_GET["post"] == 1){
echo "<meta http-equiv='refresh' content='0;url=review.php'>";
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
$zc = "用户: $user <br> 时间: $time <br> 留言: <br> $content <br> $hh ";
$write = fwrite($txt,$zc);
fclose($txt);
}
echo "</html>";
}else{
$file = file("review.txt");
$arr=array_reverse($file);
foreach($arr as $key=>$value){
for($i=1;$i<count($arr);$i++)
$s[$i] = $value;
{
echo "<div class='section'><p style='word-break:break-all'>".$value."</p></div><div class='divider'></div>";
}}}
?>
   <br /> 
   <div class="row center"> 
    <h5 class="col s12 light"> 留言撰写处 <a name="review" id="review">&nbsp;</a></h5> 
   </div> 
   <br /> 
   <div class="row"> 
    <form class="col s12" action="review.php?post=1" method="post"> 
     <div class="row"> 
      <div class="input-field col s6"> 
       <i class="material-icons prefix">&#xE853;</i> 
       <input id="username" type="text" name="username" class="validate" /> 
       <label for="username">用户</label> 
      </div> 
     </div> 
      <div class="row">
      <div class="input-field col s12"> 
       <i class="material-icons prefix">&#xE3C9;</i> 
       <textarea id="content" name="content" class="materialize-textarea" length="12450"></textarea> 
       <label for="content">留言</label> 
      </div> 
     </div> 
      <div class="row center">
     <button class="btn-large waves-effect orange" onclick="submit()" type="submit" name="action">确认并上传 <i class="material-icons right">send</i> </button> 
    </form> 
    </div>
   </div> 
  </div>    
 </div> 
  <?php include( "footer.php"); ?>
 </body>
</html>

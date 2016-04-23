<!DOCTYPE html>
<html lang="zh-cn">
 <?php include( "header.php"); ?>
 <head></head>
 <body> 
<div class="navbar-fixed"> 
  <nav class="indigo" role="navigation"> 
   <div class="nav-wrapper container"> 
    <a id="logo-container" href="review.php" class="brand-logo"> 留言板 </a> 
    <ul class="right hide-on-med-and-down"> 
     <li> <a class="dropdown-button waves-effect waves-light" href="#" data-activates="dropdown1"> 菜单 <i class="material-icons right"> &#xE5C5; </i> </a> </li> 
    </ul> 
    <ul id="dropdown1" class="dropdown-content"> 
     <?php include( "nav.php"); ?>
    </ul> 
    <ul id="nav-mobile" class="side-nav"> 
     <?php include( "navm.php"); ?>
    </ul> 
    <a href="#" data-activates="nav-mobile" class="button-collapse"> <i class="material-icons"> &#xE5D2; </i> </a> 
   </div> 
  </nav> 
</div> 
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
   </div> 
  </div> 
  <div class="container"> 
   <div class="section"> 
<?php
$file = file("review.txt");
$arr=array_reverse($file);
foreach($arr as $key=>$value){
for($i=1;$i<count($arr);$i++)
$s[$i] = $value;
{
echo <<<EOT
<div class="section"><p style="word-break:break-all">
EOT;
echo $value;
echo <<<EOT
</p></div>
<div class="divider"></div>
EOT;
}}
?>
   <br /> 
   <div class="row"> 
    <h5 class="col s12 light"> 留言撰写处 </h5> 
   </div> 
   <br /> 
   <div class="row"> 
    <form class="col s12" action="add_review.php" method="post"> 
     <div class="row"> 
      <div class="input-field col s6"> 
       <i class="material-icons prefix"></i> 
       <input id="username" type="text" name="username" class="validate" /> 
       <label for="username">用户</label> 
      </div> 
     </div> 
     <div class="row"> 
      <div class="input-field col s12"> 
       <i class="material-icons prefix"></i> 
       <textarea id="content" name="content" class="materialize-textarea" length="12450"></textarea> 
       <label for="content">留言</label> 
      </div> 
     </div> 
     <button class="btn-large waves-effect orange" onclick="submit()" type="submit" name="action">确认并上传 <i class="material-icons right">send</i> </button> 
    </form> 
   </div> 
  </div>    
 </div> 
  <?php include( "footer.php"); ?>
 </body>
</html>
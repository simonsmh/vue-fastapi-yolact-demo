<!DOCTYPE html>
<html lang="zh-cn">
 <?php include( "header.php"); ?>
 <head></head>
 <body> 
<div class="navbar-fixed"> 
  <nav class="indigo" role="navigation"> 
   <div class="nav-wrapper container"> 
    <a id="logo-container" href="index.php" class="brand-logo"> 502 </a> 
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
    <h2 class="header center orange-text"> &nbsp;simonsmh <br /> 502 </h2> 
    <div class="row center"> 
     <h5 class="header col s12 light"> 服务器错误 </h5> 
    </div> 
    <div class="progress"> 
     <div class="indeterminate indigo"> 
     </div> 
    </div> 
    <div class="row center">
     <a href="index.php" id="download-button" class="btn-large waves-effect waves-light orange">访问主页</a>
    </div>
    <br /> 
   </div> 
  </div> 
  <div class="container"> 
   <div class="section">
   
   </div> 
  </div> 
  <?php include( "footer.php"); ?>
 </body>
</html>
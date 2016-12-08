<!DOCTYPE html>
<html lang="zh-cn">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=no" />
  <meta name="theme-color" content="#3f51b5">
  <link rel="shortcut icon" type="image/x-icon" href="favicon.ico" media="screen" />
  <title>
    simonsmh - server Website
  </title>
  <!-- CSS -->
  <link href="https://app.simonsmh.cc/css/googleapi.css" type="text/css" rel="stylesheet" media="screen,projection" />
  <link href="https://app.simonsmh.cc/css/materialize.min.css" type="text/css" rel="stylesheet" media="screen,projection" />
  <style type="text/css">
  body{font-family:"Roboto","思源黑体 CN Regular","思源黑体 Regular","Noto Sans S Chinese","微软雅黑","Microsoft YaHei",sans-serif;}
  .indigo{opacity:.92;}
  .icon-block{padding: 0 15px;}
  .icon-block.material-icons{font-size: inherit;}
  </style>
</head>
 <body> 
<div class="navbar-fixed"> 
  <nav class="indigo" role="navigation"> 
   <div class="nav-wrapper container"> 
    <a id="logo-container" href="index.php" class="brand-logo"> 404 </a> 
    <ul class="right hide-on-med-and-down"> 
     <li> <a class="dropdown-button waves-effect waves-light" href="#" data-activates="dropdown1"> 菜单 <i class="material-icons right"> &#xE5C5; </i> </a> </li> 
    </ul> 
    <ul id="dropdown1" class="dropdown-content"> 
     <?php include( "nav.php"); ?>
    </ul> 
    <a href="#" data-activates="nav-mobile" class="button-collapse"> <i class="material-icons"> &#xE5D2; </i> </a> 
   </div> 
  </nav> 
</div> 
<ul id="nav-mobile" class="side-nav"> 
     <?php include( "nav.php"); ?>
    </ul> 
  <div class="section no-pad-bot" id="index-banner"> 
   <div class="container"> 
    <br /> 
    <br /> 
    <h2 class="header center orange-text"> &nbsp;simonsmh <br /> 404 </h2> 
    <div class="row center"> 
     <h5 class="header col s12 light"> 页面未找到 </h5> 
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
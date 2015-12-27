<!DOCTYPE HTML >
<html lang="zh-cn">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0" />
  <meta name="theme-color" content="#039be5">
  <link rel="shortcut icon" type="image/x-icon" href="http://simonsmh.tk/favicon.ico" media="screen" />
  <title>
    simonsmh - server Website
  </title>
  <!-- CSS -->
  <link href="http://simonsmh.tk/css/googleapi.css" type="text/css" rel="stylesheet" media="screen,projection" />
  <link href="http://simonsmh.tk/css/materialize.css" type="text/css" rel="stylesheet" media="screen,projection" />
  <link href="http://simonsmh.tk/css/style.css" type="text/css" rel="stylesheet" media="screen,projection" />
  <script src="http://simonsmh.tk/js/jquery-2.1.4.min.js">
  </script>
  <script src="http://simonsmh.tk/js/materialize.js">
  </script>
  <script src="http://simonsmh.tk/js/init.js">
  </script>
  <script>
  $('#proxyoptions label').tooltip();
  </script>
  <?=injectionJS();?>
</head>
 <body> 
  <nav class="light-blue darken-1" role="navigation"> 
   <div class="nav-wrapper container"> 
    <a id="logo-container" href="index.php" class="brand-logo"> Glype </a> 
     <a href="http://simonsmh.tk" onclick="location='http://simonsmh.tk'" class="button-collapse top-nav hide-on-large-only"><i class="large material-icons">&#xE5C4;</i></a>
      <ul class="right hide-on-med-and-down">
        <li><a href="http://simonsmh.tk">返回主站</a></li>
      </ul>
   </div> 
  </nav> 
  <div class="section no-pad-bot" id="index-banner"> 
   <div class="container"> 
    <br /> 
    <br /> 
    <h2 class="header center orange-text"> &nbsp;simonsmh <br /> Glype </h2> 
    <div class="row center"> 
     <h5 class="header col s12 light"> 科学上网 </h5> 
    </div> 
    <div class="progress"> 
     <div class="indeterminate blue"> 
     </div> 
    </div> 
    <br /> 
   </div> 
  </div> 
  <div class="container"> 
   <div class="section"> 
    <div class="row"> 
<form action="includes/process.php?action=update" method="post" onsubmit="return updateLocation(this);">
<h3 class="center">输入网址</h3>
<div class="input-field"> 
<input value="https://www.google.com" id="input" name="u" type="text" class="validate" /> 
<label class="active" for="website">输入网址</label> 
</div>
<div class="row center">
<button class="btn-large waves-effect orange" onclick="submit()" type="submit" name="action">开始浏览<i class="material-icons right">send</i> </button> 
</div>
<h4 class="center">选项</h4>
<div class="row">
</div>
<ul id="options">
<?php foreach ($toShow as $option) echo '<li><input type="checkbox" name="'.$option['name'].'" id="'.$option['name'].'"'.$option['checked'].'><label for="'.$option['name'].'">'.$option['title'].'</label></li>';?>
</ul>
</form>
<div class="row">
<p class="center">Powered by <a href="http://www.glype.com/">Glype</a>&reg; <!--[version]-->.</p>
</div>
    </div>
   </div> 
  </div> 
<footer class="page-footer orange">
   <div class="footer-copyright">
    <div class="container">
        Host by
      <a class="orange-text text-lighten-3" href="http://simonsmh.tk">
        simonsmh
      </a>
      . CSS from
      <a class="orange-text text-lighten-3" href="http://materializecss.com">
        Materialize
      </a>
      . Icons from
      <a class="orange-text text-lighten-3" href="https://www.google.com/design/icons/">
        Google
      </a>
      .
    </div>
  </div>
</footer>
 </body>
</html>
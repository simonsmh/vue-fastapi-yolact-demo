<!DOCTYPE html>
<html lang="zh-cn">
 <?php include( "header.php"); ?>
 <head></head>
 <body> 
<div class="navbar-fixed"> 
  <nav class="indigo" role="navigation"> 
   <div class="nav-wrapper container"> 
    <a id="logo-container" href="sfiles.php" class="brand-logo"> 私密文件 </a> 
    <ul class="right hide-on-med-and-down"> 
     <li> <a class="dropdown-button waves-effect waves-light" href="#" data-activates="dropdown1"> 菜单 <i class="mdi-navigation-arrow-drop-down right"> </i> </a> </li> 
    </ul> 
    <ul id="dropdown1" class="dropdown-content"> 
     <?php include( "nav.php"); ?>
    </ul> 
    <ul id="nav-mobile" class="side-nav"> 
     <?php include( "navm.php"); ?>
    </ul> 
    <a href="#" data-activates="nav-mobile" class="button-collapse"> <i class="mdi-navigation-menu"> </i> </a> 
   </div> 
  </nav> 
</div> 
  <div class="section no-pad-bot" id="index-banner"> 
   <div class="container"> 
    <br /> 
    <br /> 
    <h2 class="header center orange-text"> &nbsp;simonsmh <br /> 私密文件 </h2> 
    <div class="row center"> 
     <h5 class="header col s12 light"> 绅士，优雅而不污！ </h5> 
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
    <form id="file" name="file" action="upload_sfile.php" method="post" enctype="multipart/form-data"> 
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
    <iframe src="sfiles/" width="100%" height="500" frameborder="0"> &lt;p&gt; visit http://simonsmh.tk/sfiles/ &lt;/p&gt; </iframe> 
   </div> 
  </div> 
  <?php include( "footer.php"); ?>
 </body>
</html>
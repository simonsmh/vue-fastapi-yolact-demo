<!DOCTYPE html>
<html lang="zh-cn">
 <?php include( "header.php"); ?>
 <head></head>
 <body> 
<div class="navbar-fixed"> 
  <nav class="indigo"> 
   <div class="nav-wrapper container"> 
    <a id="logo-container" href="index.php" class="brand-logo"> 主页 </a> 
    <ul class="right hide-on-med-and-down"> 
     <li> <a class="dropdown-button waves-effect waves-light" href="#" data-activates="dropdown1"> 菜单 <i class="material-icons right"> &#xE5C5; </i> </a> </li> 
    </ul> 
    <ul id="dropdown1" class="dropdown-content"> 
     <?php include( "nav.php"); ?>
    </ul> 
    <ul id="nav-mobile" class="side-nav"> 
     <?php include( "nav.php"); ?>
    </ul> 
    <a href="#" data-activates="nav-mobile" class="button-collapse"> <i class="material-icons"> &#xE5D2; </i> </a> 
   </div> 
  </nav> 
</div> 
  <div class="section no-pad-bot" id="index-banner"> 
   <div class="container"> 
    <br /> 
    <br /> 
    <h2 class="header center orange-text"> &nbsp;simonsmh <br /> 主页 </h2> 
    <div class="row center"> 
     <h5 class="header col s12 light"> 快来与我一起发现更加广阔的互联网世界吧 </h5> 
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
    <h5 class="header col s12 light center"> 下面是simonsmh.tk运行的服务 </h5>  
    <div class="col s12 m6 center"> 
     <div class="card hoverable waves-effect waves-light orange"> 
      <div class="card-content white-text"> 
       <span class="card-title white-text"> <i class="tiny material-icons white-text">&#xE0BF;</i>simon的后花园 </span> 
       <p class="light"> 基于Typecho和Material主题的轻量级个人博客。 </p> 
      </div> 
      <div class="card-action white-text"> 
       <a class="orange-text text-lighten-3" href="https://blog.simonsmh.tk/">点这里去我的后花园</a> 
      </div> 
     </div> 
    </div> 
    <div class="col s12 m6 center"> 
     <div class="card hoverable waves-effect waves-light orange"> 
      <div class="card-content white-text"> 
       <span class="card-title white-text"> <i class="tiny material-icons white-text">&#xE862;</i>贴吧云签到 </span> 
       <p class="light"> 由StusGame团队制作的贴吧云签到服务器软件。 </p> 
      </div> 
      <div class="card-action"> 
       <a class="orange-text text-lighten-3" href="https://tieba.simonsmh.tk/">点这里去贴吧云签到</a> 
      </div> 
     </div> 
    </div>
    <div class="col s12 m6 center"> 
     <div class="card hoverable waves-effect waves-light orange"> 
      <div class="card-content white-text"> 
       <span class="card-title white-text"> <i class="tiny material-icons white-text">&#xE87A;</i>Glype </span> 
       <p class="light"> 基于PHP的在线网页浏览器，轻松实现自由浏览。 </p> 
      </div> 
      <div class="card-action white-text"> 
       <a class="orange-text text-lighten-3" href="glype/">点这里去Glype</a> 
      </div> 
     </div> 
    </div>
    <div class="col s12 m6 center"> 
     <div class="card hoverable waves-effect waves-light orange"> 
      <div class="card-content white-text"> 
       <span class="card-title white-text"> <i class="tiny material-icons white-text">&#xE884;</i>离线下载 </span> 
       <p class="light"> 基于Transmission的开源BT或PT离线下载程序。 </p> 
      </div> 
      <div class="card-action white-text"> 
       <a class="orange-text text-lighten-3" href="https://bt.simonsmh.tk/">点这里去Transmission</a>
      </div> 
     </div> 
    </div> 
    <h5 class="header col s12 light center"> 下面是simonsmh.tk运行的程序 </h5> 
    <div class="col s12 m3 center"> 
     <div class="card hoverable waves-effect waves-light orange"> 
      <div class="card-content white-text"> 
       <span class="card-title white-text"> <i class="tiny material-icons white-text">&#xE0B7;</i>留言板 </span> 
       <p class="light"> 基于HTML和PHP的留言板。 </p> 
      </div> 
      <div class="card-action white-text"> 
       <a class="orange-text text-lighten-3" href="review.php">点这里去留言板</a> 
      </div> 
     </div> 
    </div> 
    <div class="col s12 m3 center"> 
     <div class="card hoverable waves-effect waves-light orange"> 
      <div class="card-content white-text"> 
       <span class="card-title white-text"> <i class="tiny material-icons white-text">&#xE610;</i>文件储存 </span> 
       <p class="light"> 基于HTML和PHP的文件储存。 </p> 
      </div> 
      <div class="card-action"> 
       <a class="orange-text text-lighten-3" href="files.php">点这里去文件储存</a> 
      </div> 
     </div> 
    </div>
    <div class="col s12 m3 center"> 
     <div class="card hoverable waves-effect waves-light orange"> 
      <div class="card-content white-text"> 
       <span class="card-title white-text"> <i class="tiny material-icons white-text">&#xE610;</i>台风监测站 </span> 
       <p class="light"> 基于HTML和PHP的台风监测站。 </p> 
      </div> 
      <div class="card-action"> 
       <a class="orange-text text-lighten-3" href="ty.php">点这里去台风监测站</a> 
      </div> 
     </div> 
    </div> 
    <div class="col s12 m3 center"> 
     <div class="card hoverable waves-effect waves-light orange"> 
      <div class="card-content white-text"> 
       <span class="card-title white-text"> <i class="tiny material-icons white-text">&#xE86F;</i>杂货铺 </span> 
       <p class="light"> 基于HTML和PHP的有趣功能。 </p> 
      </div> 
      <div class="card-action"> 
       <a class="orange-text text-lighten-3" href="source.php">点这里去杂货铺</a> 
      </div> 
     </div> 
    </div> 
     <h5 class="header col s12 light center"> 还有更多在开发中 </h5> 
    </div> 
   </div> 
  </div>  
  <?php include( "footer.php"); ?>
 </body>
</html>
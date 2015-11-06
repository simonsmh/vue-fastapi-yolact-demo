<!DOCTYPE html>
<html lang="zh-cn">
<?php include( "header.php"); ?>
<body>
  <nav class="light-blue darken-1" role="navigation">
    <div class="nav-wrapper container">
      <a id="logo-container" href="source.php" class="brand-logo">
        源码浏览
      </a>
      <?php include( "nav.php"); ?>
    <div class="section no-pad-bot" id="index-banner">
      <div class="container">
        <br>
        <br>
        <h2 class="header center orange-text">
          &nbsp;simonsmh
          </br>
          源码浏览
        </h2>
        <div class="row center">
          <h5 class="header col s12 light">
            仅可浏览，不可使用！
          </h5>
        </div>
        <div class="progress">
          <div class="indeterminate blue">
          </div>
        </div>
        <br>
      </div>
    </div>
    <div class="container">
      <div class="section">

<div class="row">
    <form class="col s12" action="add_source.php" method="post">
<div class="switch">
    <label>
      &nbsp;&nbsp;&nbsp;&nbsp;显示源码
      <input type="checkbox" name="choose">
      <span class="lever"></span>
      显示页面
    </label>
  </div>
<br>
     <div class="input-field col s12">
      <input value="https://twitter.com/MinhaoShi" id="website" name="website" type="text" class="validate">
      <label class="active" for="website">填写网址</label>
    </div>
      <input onclick="submit()" type="checkbox" class="filled-in" id="filled-in-box">
      <label for="filled-in-box">确认</label>
    </form>
</div>



</div>
</div>
   <br>
   <br>
 <div class="section">
 </div>
</div>
<?php include( "footer.php"); ?>
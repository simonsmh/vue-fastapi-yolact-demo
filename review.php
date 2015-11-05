<!DOCTYPE html>
<html lang="zh-cn">
<?php include( "header.php"); ?>
<body>
  <nav class="light-blue darken-1" role="navigation">
    <div class="nav-wrapper container">
      <a id="logo-container" href="review.php" class="brand-logo">
        留言板
      </a>
      <?php include( "nav.php"); ?>
    <div class="section no-pad-bot" id="index-banner">
      <div class="container">
        <br>
        <br>
        <h2 class="header center orange-text">
          &nbsp;simonsmh
          </br>
          留言板
        </h2>
        <div class="row center">
          <h5 class="header col s12 light">
            嘿，快来吐槽！
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
<br>
<h5 class="header col s12 light">
 评论撰写处
</h5>
<br>
<div class="row">
  <form class="col s12" action="add_review.php" method="post">
    <div class="row">
      <div class="input-field col s6">
        <i class="material-icons prefix">&#xE853;</i>
        <input id="username" type="text" name="username" class="validate">
        <label for="username">用户</label>
      </div>
    </div>
    <div class="row">
      <div class="input-field col s12">
        <i class="material-icons prefix">&#xE150;</i>
        <textarea id="content" name="content" class="materialize-textarea" length="12450"></textarea>
        <label for="content">留言</label>
      </div>
    </div>
    <input onclick="submit()" type="checkbox" class="filled-in" id="filled-in-box">
    <label for="filled-in-box">&nbsp;&nbsp;&nbsp;确认并上传</label>
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
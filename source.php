<!DOCTYPE html>
<html lang="zh-cn">
 <?php include( "header.php"); ?>
 <head></head>
 <body> 
  <nav class="light-blue darken-1" role="navigation"> 
   <div class="nav-wrapper container"> 
    <a id="logo-container" href="source.php" class="brand-logo"> 杂货铺 </a> 
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
  <div class="section no-pad-bot" id="index-banner"> 
   <div class="container"> 
    <br /> 
    <br /> 
    <h2 class="header center orange-text"> &nbsp;simonsmh <br /> 杂货铺 </h2> 
    <div class="row center"> 
     <h5 class="header col s12 light"> 瞧一瞧，看一看，GayHub源码随便用！ </h5> 
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
    <h5 class="center">源码浏览器</h5>
    <div class="row"> 
     <form class="col s12" action="add_source.php" method="post"> 
      <div class="switch"> 
       <label> &nbsp;&nbsp;&nbsp;&nbsp;显示源码 <input type="checkbox" name="choose" /> <span class="lever"></span> 显示页面 </label> 
      </div> 
      <br /> 
      <div class="input-field"> 
       <input value="https://twitter.com/MinhaoShi" id="website" name="website" type="text" class="validate" /> 
       <label class="active" for="website">填写网址</label> 
      </div> 
      <button class="btn-large orange waves-effect waves-light" onclick="submit()" type="submit" name="action">确认 <i class="material-icons right">send</i> </button> 
     </form> 
    </div> 
    <h5 class="center">镜像源（如有其他需求请联系我）</h5>
    <div class="row"> 
     <span class="col s12 light"> INFO: <br /> <a href="http://openwrt.simonsmh.tk/"> http://openwrt.simonsmh.tk/ </a> 现在成为了 <a href="http://downloads.openwrt.org/"> http://downloads.openwrt.org/ </a> 的镜像站 </br> 快速执行替换代码： </br> sed -i 's/downloads.openwrt.org/openwrt.simonsmh.tk/g' /etc/opkg.conf </span> 
     <span class="col s12 light"> <br /> <a href="http://wiki.simonsmh.tk/"> http://wiki.simonsmh.tk/ </a> 现在成为了 <a href="http://www.wikipedia.org/"> http://www.wikipedia.org/ </a> 的镜像站(仅提供中日英三国语言) </span> 
    </div> 
    <h5 class="center">PHP试验场</h5>
<?php 
echo<<<END
<div class="row"> 
<span class="col s12 light">本机IP（PHP-cURL>members.3322.org/dyndns/getip）</span> 
<span class="col s12 light">
END;
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "http://members.3322.org/dyndns/getip");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_HEADER, 0);
$output = curl_exec($ch);
if ($output === FALSE) {
echo "cURL错误: " . curl_error($ch);
}
curl_close($ch);
echo $output;
echo<<<END
</span>
<span class="col s12 light">你的IP（PHP）</span> 
<span class="col s12 light">
END;
echo $_SERVER["REMOTE_ADDR"];
echo "</span></div>";

echo<<<END
<div class="row"> 
<span class="col s12 light">你的USERAGENT（PHP）</span> 
<span class="col s12 light">
END;
echo $_SERVER['HTTP_USER_AGENT'];
echo<<<END
</span> 
<span class="col s12 light">
你在使用
END;
if(strpos($_SERVER["HTTP_USER_AGENT"],"MSIE8")) echo"IE8";
elseif(strpos($_SERVER["HTTP_USER_AGENT"],"Firefox")) echo"Firefox";
elseif(strpos($_SERVER["HTTP_USER_AGENT"],"Chrome")) echo"Chrome";
elseif(strpos($_SERVER["HTTP_USER_AGENT"],"Safari")) echo"Safari";
elseif(strpos($_SERVER["HTTP_USER_AGENT"],"Opera")) echo"Opera"; 
else echo$_SERVER["HTTP_USER_AGENT"]; 
echo "访问本页面</span></div>" ;
?> 
 </div> 
   </div> 
  </div> 
  <?php include( "footer.php"); ?>
 </body>
</html>
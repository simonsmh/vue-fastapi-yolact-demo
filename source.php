<!DOCTYPE html>
<?php
//简易CURL设置header读取数据函数
function curl_get($url, array $header = array()){
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
curl_setopt($ch, CURLOPT_TIMEOUT, 10);
$data = curl_exec($ch);
curl_close($ch);
return $data;
}
if($_GET["githook"] == 1){
$dir = '/var/www/simonsmh/';
$handle = popen('cd '.$dir.' && git pull && chmod -R 777 * && chown -R www-data *','r');
$read = stream_get_contents($handle);
printf($read);
pclose($handle);
}elseif($_GET["bloghook"] == 1){
$dir = '/var/www/simonsmh.github.io/';
$handle = popen('cd '.$dir.' && git fetch origin && git reset origin master --hard && git pull origin master','r');
$read = stream_get_contents($handle);
printf($read);
pclose($handle);
}
elseif($_GET["url"] == 1){
$http = "http://";
$choose = $_POST['choose'];
$website = $_POST['website'];
if (strstr($website,"https://")=="" and strstr($website,"http://")==""){
$website = $http.$_POST['website'];
}
$fh = curl_get($website);
if ($choose==""){
$fh = str_replace('<',"&lt;",$fh);
$fh = str_replace('>',"&gt;<br>",$fh);
} 
if ($fh==""){
echo "<script type='text/javascript'>alert('网址错误');</script>";
}
echo $fh;
}elseif($_GET["ip"] == 1){
echo $_SERVER["REMOTE_ADDR"];
}elseif($_GET["ua"] == 1){
echo $_SERVER["HTTP_USER_AGENT"]; 
}elseif($_GET["ip"] == 2){
$output = curl_get("http://members.3322.org/dyndns/getip");
echo $output;
}else{
include( "header.php");
echo <<<END
<html lang="zh-cn">
 <head></head>
 <body> 
<div class='navbar-fixed'>
  <nav class='indigo' role='navigation'> 
   <div class='nav-wrapper container'> 
    <a id='logo-container' href='source.php' class='brand-logo'> 杂货铺 </a> 
    <ul class='right hide-on-med-and-down'> 
     <li> <a class='dropdown-button waves-effect waves-light' href='#' data-activates='dropdown1'> 菜单 <i class='material-icons right'> &#xE5C5; </i> </a> </li> 
    </ul> 
    <ul id='dropdown1' class='dropdown-content'> 
END;
include( 'nav.php');
echo <<<END
    </ul> 
    <a href='#' data-activates='nav-mobile' class='button-collapse'> <i class='material-icons'> &#xE5D2; </i> </a> 
   </div> 
  </nav> 
</div>
 <ul id='nav-mobile' class='side-nav'> 
END;
include( 'nav.php');
echo <<<END
    </ul> 
  <div class='section no-pad-bot' id='index-banner'> 
   <div class='container'> 
    <br /> 
    <br /> 
    <h2 class='header center orange-text'> &nbsp;simonsmh <br /> 杂货铺 </h2> 
    <div class='row center'> 
     <h5 class='header col s12 light'> 瞧一瞧，看一看，GayHub源码随便用！ </h5> 
    </div> 
    <div class='progress'> 
     <div class='indeterminate indigo'> 
     </div> 
    </div> 
    <br /> 
   </div> 
  </div> 
  <div class='container'> 
   <div class='section'> 
    <h5 class='center'>源码浏览器</h5>
    <div class='row'> 
     <form class='col s12' action='source.php?url=1' method='post'> 
      <div class='switch center'> 
       <label> 显示源码 <input type='checkbox' name='choose' /> <span class='lever'></span> 显示页面 </label> 
      </div> 
      <br /> 
      <div class='row input-field'> 
       <input value='https://twitter.com/MinhaoShi' id='website' name='website' type='text' class='validate' /> 
       <label class='active' for='website'>填写网址</label> 
      </div> 
      <div class='row center'>
       <button class='btn-large orange waves-effect waves-light' onclick='submit()' type='submit' name='action'>确认 <i class='material-icons right'>send</i> </button> 
      </div>
     </form> 
    </div> 
    </div>
  <div class='divider'></div>
  <div class='section'>
    <h5 class='center'>PHP INFO</h5>
    <div class='row'> 
     <span class='col s12 light'><a href='source.php?ip=2'>直接获取本机IP</a></span> 
     <span class='col s12 light'><a href='source.php?ip=1'>直接获取你的IP</a></span> 
     <span class='col s12 light'><a href='source.php?ua=1'>直接获取你的UserAgent</a></span> 
     <div class='col s12'><br></div> 

<span class="col s12 light">本机IP（PHP-cURL>members.3322.org/dyndns/getip）</span> 
<span class="col s12 light">
END;
$output = curl_get("http://members.3322.org/dyndns/getip");
echo $output;
echo <<<END
</span>
<span class="col s12 light">你的IP（PHP）</span> 
<span class="col s12 light">
END;
echo $_SERVER["REMOTE_ADDR"];
echo "</span>";
echo <<<END
<span class="col s12 light">你的USERAGENT（PHP）</span> 
<span class="col s12 light">
END;
echo $_SERVER["HTTP_USER_AGENT"]; 
echo <<<END
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
echo "访问本页面</span>" ;
echo <<<END
 </div> 
  </div> 
<div class="divider"></div>
<div class="section">
END;
echo "<h5 class='center'>PHP试验场</h5>";

echo "</div></div>";
include( "footer.php");
echo "</body></html>";
}?>

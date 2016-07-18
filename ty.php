<!DOCTYPE html>
<html lang='zh-cn'>
 <?php include( 'header.php'); ?>
 <head></head>
 <body> 
<div class='navbar-fixed'> 
  <nav class='indigo'> 
   <div class='nav-wrapper container'> 
    <a id='logo-container' href='ty.php' class='brand-logo'> 台风监测站 </a> 
    <ul class='right hide-on-med-and-down'> 
     <li> <a class='dropdown-button waves-effect waves-light' href='#' data-activates='dropdown1'> 菜单 <i class='material-icons right'> &#xE5C5; </i> </a> </li> 
    </ul> 
    <ul id='dropdown1' class='dropdown-content'> 
     <?php include( "nav.php"); ?>
    </ul> 
    <ul id='nav-mobile' class='side-nav'> 
     <?php include( "nav.php"); ?>
    </ul> 
    <a href='#' data-activates='nav-mobile' class='button-collapse'> <i class='material-icons'> &#xE5D2; </i> </a> 
   </div> 
  </nav> 
</div> 
  <div class='section no-pad-bot' id='index-banner'> 
   <div class='container'> 
    <br /> 
    <br /> 
    <h2 class='header center orange-text'> &nbsp;simonsmh <br /> 台风监测站 </h2> 
    <div class='row center'> 
     <h5 class='header col s12 light'> 气象网页报文解析 </h5> 
    </div> 
    <div class='progress'> 
     <div class='indeterminate indigo'> 
     </div> 
    </div> 
    <br /> 
   </div> 
  </div> 
  <div class='container'> 
   <div class='row'> 
<?php
$t = $_GET["type"];
if ($t == NULL){
//欢迎页
echo "<a href='https://simonsmh.tk/ty.php?type=nmc'>nmc</a>";
echo "<br>";
echo "<a href='https://simonsmh.tk/ty.php?type=nmcpic'>nmcpic</a>";
//欢迎页
}else{
echo "<div class='col s12 m4 center'><a class='white-text btn-large btn-flat orange center waves-effect waves-light ";
$i = max(0,$_GET["num"]);
if ($i == 0){
echo "disabled";
}
$ind = $i - 1;
echo "'href='ty.php?num=".$ind."&type=".$_GET["type"]."'><i class='material-icons left'>&#xE314;</i>上一页</a></div><div class='col s12 m4'>";
if ($t == "nmc"){
//获取nmc报文网址
$nmc = file_get_contents("http://www.nmc.cn/publish/typhoon/message.html");
preg_match_all ("<data-id=\"(.*?)\">",$nmc, $nmcpost);
if (count($nmcpost[1]) > $i){
//获取报文时间
$tmp = substr($nmcpost[1][$i],-17);
//报文时间
$time=array();
$time[0] = substr ($tmp,0,4);
$time[1] = substr ($tmp,4,2);
$time[2] = substr ($tmp,6,2);
$time[3] = substr ($tmp,8,2);
$time[4] = substr ($tmp,10,2);
//去除报文html标签
$nmcposts = file_get_contents ("http://www.nmc.cn/f/fetch?dataId=".$nmcpost[1][$i]);
$nmcposts = preg_replace ("/<.*?>/"," ",$nmcposts);
//分离报文元素数组化
$nmcp = preg_split ("/[\s*]+/",$nmcposts);
//print_r($nmcp);
//翻译数组数据
if ($nmcp[3] == BABJ){
$nmcp[3] = "中央气象台";
}
//输出报告时间
echo $time[0]."年".$time[1]."月".$time[2]."日".$time[3]."时".$time[4]."分"."<br>";
echo $nmcp[3]."<br>";
//搜索数组
$wtpqmode = array_search("WTPQ20",$nmcp);
$tcpqmode = array_search("TCPQ40",$nmcp);
$tytmp = array_search("TIME",$nmcp);
$windtmp = array_search("WINDS",$nmcp);
$nowtmp = array_search("00HR",$nmcp);
$movetmp = array_search("MOVE",$nmcp);
$pretmp=array();
$pretmp[1] = array_search("P+06HR",$nmcp);
$pretmp[2] = array_search("P+12HR",$nmcp);
$pretmp[3] = array_search("P+18HR",$nmcp);
$pretmp[4] = array_search("P+24HR",$nmcp);
$pretmp[5] = array_search("P+36HR",$nmcp);
$pretmp[6] = array_search("P+48HR",$nmcp);
$pretmp[7] = array_search("P+60HR",$nmcp);
//判断报文类型
if ($wtpqmode > 0){
$nmcp[$wtpqmode] = "台风预测报文";
echo "报文类型".$nmcp[$wtpqmode]."<br>";
//台风基础信息
if ($tytmp > 0){
$tytmp -= 4;
echo "台风".$nmcp[$tytmp]."<br>";
$tytmp += 1;
echo "编号".$nmcp[$tytmp]."<br>";
$tytmp -= 2;
echo "强度评级".$nmcp[$tytmp]."<br>";
}
//风圈
if ($windtmp > 0){
$windtmp += 1;
echo "东北半径".$nmcp[$windtmp]."<br>";
$windtmp += 2;
echo "东南半径".$nmcp[$windtmp]."<br>";
$windtmp += 2;
echo "西南半径".$nmcp[$windtmp]."<br>";
$windtmp += 2;
echo "西北半径".$nmcp[$windtmp]."<br>";
}
//现在位置
if ($nowtmp > 0){
$nowtmp += 1;
echo "纬度".$nmcp[$nowtmp]."<br>";
$nowtmp += 1;
echo "经度".$nmcp[$nowtmp]."<br>";
$nowtmp += 1;
echo "气压".$nmcp[$nowtmp]."<br>";
$nowtmp += 1;
echo "中心最大风速".$nmcp[$nowtmp]."<br>";
}
//移动方向
if ($movetmp > 0){
$movetmp += 1;
echo "方向".$nmcp[$movetmp]."<br>";
$movetmp += 1;
echo "移动速度".$nmcp[$movetmp]."<br>";
}
//预报路径
if ($pretmp[1] > 0){
echo "06小时预报<br>";
$pretmp[1] += 1;
echo "纬度".$nmcp[$pretmp[1]]."<br>";
$pretmp[1] += 1;
echo "经度".$nmcp[$pretmp[1]]."<br>";
$pretmp[1] += 1;
echo "气压".$nmcp[$pretmp[1]]."<br>";
$pretmp[1] += 1;
echo "中心最大风速".$nmcp[$pretmp[1]]."<br>";
}
if ($pretmp[2] > 0){
echo "12小时预报<br>";
$pretmp[2] += 1;
echo "纬度".$nmcp[$pretmp[2]]."<br>";
$pretmp[2] += 1;
echo "经度".$nmcp[$pretmp[2]]."<br>";
$pretmp[2] += 1;
echo "气压".$nmcp[$pretmp[2]]."<br>";
$pretmp[2] += 1;
echo "中心最大风速".$nmcp[$pretmp[2]]."<br>";
}
if ($pretmp[3] > 0){
echo "18小时预报<br>";
$pretmp[3] += 1;
echo "纬度".$nmcp[$pretmp[3]]."<br>";
$pretmp[3] += 1;
echo "经度".$nmcp[$pretmp[3]]."<br>";
$pretmp[3] += 1;
echo "气压".$nmcp[$pretmp[3]]."<br>";
$pretmp[3] += 1;
echo "中心最大风速".$nmcp[$pretmp[3]]."<br>";
}
if ($pretmp[4] > 0){
echo "24小时预报<br>";
$pretmp[4] += 1;
echo "纬度".$nmcp[$pretmp[4]]."<br>";
$pretmp[4] += 1;
echo "经度".$nmcp[$pretmp[4]]."<br>";
$pretmp[4] += 1;
echo "气压".$nmcp[$pretmp[4]]."<br>";
$pretmp[4] += 1;
echo "中心最大风速".$nmcp[$pretmp[4]]."<br>";
}
if ($pretmp[5] > 0){
echo "36小时预报<br>";
$pretmp[5] += 1;
echo "纬度".$nmcp[$pretmp[5]]."<br>";
$pretmp[5] += 1;
echo "经度".$nmcp[$pretmp[5]]."<br>";
$pretmp[5] += 1;
echo "气压".$nmcp[$pretmp[5]]."<br>";
$pretmp[5] += 1;
echo "中心最大风速".$nmcp[$pretmp[5]]."<br>";
}
if ($pretmp[1] > 0){
echo "48小时预报<br>";
$pretmp[6] += 1;
echo "纬度".$nmcp[$pretmp[6]]."<br>";
$pretmp[6] += 1;
echo "经度".$nmcp[$pretmp[6]]."<br>";
$pretmp[6] += 1;
echo "气压".$nmcp[$pretmp[6]]."<br>";
$pretmp[6] += 1;
echo "中心最大风速".$nmcp[$pretmp[6]]."<br>";
}
if ($pretmp[7] > 0){
echo "60小时预报<br>";
$pretmp[7] += 1;
echo "纬度".$nmcp[$pretmp[7]]."<br>";
$pretmp[7] += 1;
echo "经度".$nmcp[$pretmp[7]]."<br>";
$pretmp[7] += 1;
echo "气压".$nmcp[$pretmp[7]]."<br>";
$pretmp[7] += 1;
echo "中心最大风速".$nmcp[$pretmp[7]]."<br>";
}
}elseif ($tcpqmode > 0){
$nmcp[$tcpqmode] = "卫星云图报文";
echo "报文类型".$nmcp[$tcpqmode]."<br>";
}else{
echo "报文类型其它<br>";
}
//清空变量
unset($time);
unset($nmcp);
unset($pretmp);
$tytmp = 0;
$windtmp = 0;
$nowtmp = 0;
$movetmp = 0;
$tcpqmode = 0;
$wtpqmode = 0;
}else{
echo "暂无更多信息";
}}elseif($t == "nmcpic"){
$nmcpic = file_get_contents("http://www.nmc.cn/publish/typhoon/probability.html");
preg_match_all ("<data-original=\"(.*?)\">",$nmcpic, $nmcpicpost);
if (count($nmcpicpost[1]) > $i){
$nmcpicpost[1][$i] = str_replace("/small", "", $nmcpicpost[1][$i]);
echo "<img style='max-width:100%;' src='".$nmcpicpost[1][$i]."'>";
}else{
echo "暂无更多信息";
}}else{
echo "暂无此项信息";
}
echo "</div><div class='col s12 m4 center'><a class='btn-large btn-flat orange center waves-effect waves-light white-text' href='";
$ind = $i + 1;
echo "ty.php?num=".$ind."&type=".$_GET["type"]."'><i class='material-icons right'>&#xE315;</i>下一页</a></div>";
}
?>

    </div> 
   </div> 
  </div>  
  <?php include( "footer.php"); ?>
 </body>
</html>
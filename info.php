<!DOCTYPE html>
<html lang="zh-cn">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0" />
  <link rel="shortcut icon" type="image/x-icon" href="favicon.ico" media="screen" />
  <title>
    simonsmh - server Website
  </title>
  <!-- CSS -->
  <link href="css/googleapi.css" type="text/css" rel="stylesheet" media="screen,projection" />
  <link href="css/materialize.css" type="text/css" rel="stylesheet" media="screen,projection" />
  <link href="css/style.css" type="text/css" rel="stylesheet" media="screen,projection" />
  <script src="js/jquery-2.1.4.min.js">
  </script>
  <script src="js/materialize.js">
  </script>
  <script src="js/init.js">
  </script>
</head>
<body>
  <nav class="light-blue lighten-1" role="navigation">
    <div class="nav-wrapper container">
      <a id="logo-container" href="info.php" class="brand-logo">
        代理相关
      </a>
      <ul class="right hide-on-med-and-down">
        <li>
          <a class="dropdown-button waves-effect waves-light" href="#" data-activates="dropdown1">
            菜单
            <i class="mdi-navigation-arrow-drop-down right">
            </i>
          </a>
        </li>
      </ul>
      <ul id="dropdown1" class="dropdown-content">
        <li>
          <a href="index.php" class="waves-effect black-text">
            主页
          </a>
        </li>
        <li>
          <a href="files.php" class="waves-effect black-text">
            文件储存
          </a>
        </li>
        <li>
          <a href="http://192.168.1.1/" class="waves-effect black-text">
            光猫
          </a>
        </li>
        <li>
          <a href="http://192.168.199.1" class="waves-effect black-text">
            Openwrt
          </a>
        </li>
        <li>
          <a href="info.php" class="waves-effect black-text">
            代理相关
          </a>
        </li>
      </ul>
      <ul id="nav-mobile" class="side-nav">
        <li>
          <a href="index.php" class="waves-effect">
            主页
          </a>
        </li>
        <li>
          <a href="files.php" class="waves-effect">
            文件储存
          </a>
        </li>
        <li>
          <a href="http://192.168.1.1/" class="waves-effect">
            电信光猫
          </a>
        </li>
        <li>
          <a href="http://192.168.199.1" class="waves-effect">
            Openwrt
          </a>
        </li>
        <li>
          <a href="info.php" class="waves-effect">
            代理相关
          </a>
        </li>
      </ul>
      <a href="#" data-activates="nav-mobile" class="button-collapse">
        <i class="mdi-navigation-menu">
        </i>
      </a>
    </div>
  </nav>
    <div class="section no-pad-bot" id="index-banner">
      <div class="container">
        <br>
        <br>
        <h2 class="header center orange-text">
          &nbsp;simonsmh
          </br>
          个人代理
        </h2>
        <div class="row center">
          <h5 class="header col s12 light">
            合理使用
            </br>
            遵循可持续发展原则
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
        <!-- Icon Section -->
        <div class="row">
          <div class="col s12 m4">
            <div class="icon-block">
              <h5 class="center light-blue-text">
                Shadowsocks
                <br>
                & SSR support
              </h5>
              <p class="light">
                服务器地址 simonsmh.tk
                <br>
                日本服务器端口 444
                <br>
                美国服务器端口 543
                <br>
                加密方式 aes-256-cfb
                <br>
                密码 simonsmh
                <br>
                可选择开启SSR专有加密
              </p>
            </div>
          </div>
          <div class="col s12 m4">
            <div class="icon-block">
              <h5 class="center light-blue-text">
                Pure IPsec
                </br>
                L2TP/IPSec
              </h5>
              <p class="light">
                服务器地址 simonsmh.tk
                <br>
                用户名 simonsmh
                <br>
                密码 123456
                <br>
                预共享密钥 simonsmh
                <br>
                L2TP用户名 test[1-9]
                <br>
                p12证书密码 simonsmh
                <br>
                <a class="light" href="/CAKEY">
                  也许用得上的证书
                </a>
              </p>
            </div>
          </div>
          <div class="col s12 m4">
            <div class="icon-block">
              <h5 class="center light-blue-text">
                ShadowVPN
                </br>
                Beta
              </h5>
              <p class="light">
                服务器地址 simonsmh.tk
                <br>
                服务器端口 1123
                <br>
                密码 simonsmh
                <br>
                本地IP 10.7.0.2-254
                <br>
                MTU 1440
              </p>
            </div>
          </div>
        </div>
      </div>
      <br>
      <br>
      <div class="section">
      </div>
    </div>
    <?php include( "footer.php"); ?>
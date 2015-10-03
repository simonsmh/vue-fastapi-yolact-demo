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
      <a id="logo-container" href="files.php" class="brand-logo">
        文件存储
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
          文件储存
        </h2>
        <div class="row center">
          <h5 class="header col s12 light">
            恩，快交出文件！
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
        <form id="file" name="file" action="upload_file.php" method="post" enctype="multipart/form-data">
          <div class="file-field input-field">
            <div class="btn">
              <span>
                File
              </span>
              <input type="file" name="file" id="file">
            </div>
            <div class="file-path-wrapper">
              <input class="file-path validate" type="text" placeholder="Upload files">
            </div>
            <input onclick="submit()" type="checkbox" class="filled-in" id="filled-in-box">
            <label for="filled-in-box">
              确认并上传
            </label>
          </div>
        </form>
        <br>
        <iframe src="files/" width="100%" height="500" frameborder="0">
          <p>
            visit http://simonsmh.tk/files/
          </p>
        </iframe>
      </div>
      <br>
      <br>
    </div>
    <?php include( "footer.php"); ?>
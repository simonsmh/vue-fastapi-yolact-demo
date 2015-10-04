<!DOCTYPE html>
<html lang="zh-cn">
  <?php include( "header.php"); ?>
    
    <body>
      <nav class="light-blue lighten-1" role="navigation">
        <div class="nav-wrapper container">
          <a id="logo-container" href="files.php" class="brand-logo">
            文件储存
          </a>
          <?php include( "nav.php"); ?>
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
                    <div class="btn orange">
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
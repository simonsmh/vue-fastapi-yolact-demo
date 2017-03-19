<!DOCTYPE html>
<html lang="zh-cn">
<?php include( "header.php"); ?>
 <body> 
<div class="navbar-fixed"> 
  <nav class="indigo" role="navigation"> 
   <div class="nav-wrapper container"> 
    <a id="logo-container" href="https://app.simonsmh.cc/index.php" class="brand-logo"> 403页面 </a> 
    <ul class="right hide-on-med-and-down"> 
     <li> <a class="dropdown-button waves-effect waves-light" href="#" data-activates="dropdown1"> 菜单 <i class="material-icons right"> &#xE5C5; </i> </a> </li> 
    </ul> 
    <ul id="dropdown1" class="dropdown-content"> 
     <?php include( "nav.php"); ?>
    </ul> 
    <a href="#" data-activates="nav-mobile" class="button-collapse"> <i class="material-icons"> &#xE5D2; </i> </a> 
   </div> 
  </nav> 
</div> 
  <ul id="nav-mobile" class="side-nav"> 
     <?php include( "nav.php"); ?>
    </ul> 
  <div class="section no-pad-bot" id="index-banner"> 
   <div class="container"> 
    <br /> 
    <br /> 
    <h2 class="header center orange-text"> &nbsp;simonsmh <br /> 403 </h2> 
    <div class="row center"> 
     <h5 class="header col s12 light"> 拒绝访问 </h5> 
    </div> 
    <div class="progress"> 
     <div class="indeterminate indigo"> 
     </div> 
    </div> 
    <div class="row center">
     <a href="https://app.simonsmh.cc/" id="download-button" class="btn-large waves-effect waves-light orange">访问主页</a>
    </div>
    <br /> 
   </div> 
  </div> 
  <div class="container"> 
   <div class="section">

   </div> 
  </div> 
  <footer class="page-footer orange">
  <div id="gototop" class="fixed-action-btn" style="bottom: 45px; right: 24px;">
    <a class="waves-effect waves-light btn-floating btn-large red" href="#"><i class="large material-icons">&#xE255;</i></a>
  </div>
  <div class="footer-copyright">
    <div class="container" style="word-break:break-all">
      <a class="orange-text text-lighten-3" href="https://app.simonsmh.cc/tz.php">
        Powered by
      </a>
      <a class="orange-text text-lighten-3" href="https://app.simonsmh.cc/sfiles.php">
        simonsmh.
      </a>
      <a class="orange-text text-lighten-3" href="http://materializecss.com">
       CSS from Materialize.
      </a>
      <a class="orange-text text-lighten-3" href="https://www.google.com/design/icons/">
       Icons from Google.
      </a>
    </div>
  </div>
</footer>
  <script src="https://app.simonsmh.cc/js/jquery.min.js">
  </script>
  <script src="https://app.simonsmh.cc/js/materialize.min.js">
  </script>
  <script src="https://app.simonsmh.cc/js/fool.min.js">
  </script>
  <script>
  (function($){
    $(function(){
    // Plugin initialization
    $('.carousel.carousel-slider').carousel({full_width: true});
    $('.carousel').carousel();
    $('.slider').slider({full_width: true});
    $('.parallax').parallax();
    $('.modal').modal();
    $('.scrollspy').scrollSpy();
    $('.button-collapse').sideNav();
    $('.datepicker').pickadate();
    $('select').not('.disabled').material_select();
    $('.chips').material_chip();
    }); // end of document ready
  })(jQuery); // end of jQuery name space
  </script>
  <script>
  $(document).ready(function(){$(function(){$(window).scroll(function(){$("#gototop").openFAB();});$("#gototop").click(function(){$('body,html').animate({scrollTop: 0},400);return false;});});});
  </script>
  <script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)})(window,document,'script','js/analytics.js','ga');ga('create', 'UA-73742380-1', 'auto');ga('send', 'pageview');
  </script>
 </body>
</html>
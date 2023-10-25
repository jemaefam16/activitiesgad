<!DOCTYPE html>
<html lang="en" class="" style="height: auto;">
<?php require_once('config.php'); ?>
 <?php require_once('inc/header.php') ?>
  <body class="hold-transition layout-top-nav" >
     <?php $page = isset($_GET['page']) ? $_GET['page'] : 'portal';  ?>
     <?php require_once('inc/topBarNav.php') ?>
     <?php 
        if(!file_exists($page.".php") && !is_dir($page)){
            include '404.html';
        }else{
          if(is_dir($page))
            include $page.'/index.php';
          else
            include $page.'.php';

        }
      ?>
       <script>
        $(function(){
          if($('header.masthead').lengt <= 0)
            $('#mainNav').addClass('navbar-shrink')
        })
      </script>
      <?php require_once('inc/footer.php') ?>
    
    </div>
  </div>
  <div class="modal fade text-dark rounded-0" id="uni_modal" role='dialog'>
    <div class="modal-dialog modal-md modal-dialog-centered" role="document">
      <div class="modal-content rounded-0">
        <div class="modal-header">
        <h5 class="modal-title"></h5>
      </div>
      <div class="modal-body">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id='submit' onclick="$('#uni_modal form').submit()" style="background-color:blue;">Save</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal" style="background-color:red">Cancel</button>
      </div>
      </div>
    </div>
  </div>
  <div class="modal fade text-dark" id="uni_modal_right" role='dialog'>
    <div class="modal-dialog modal-full-height  modal-md" role="document">
      <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="background-color:red;">
          <span class="fa fa-arrow-right"></span>
        </button>
      </div>
      <div class="modal-body">
      </div>
      </div>
    </div>
  </div>
  <div class="modal fade text-dark" id="viewer_modal" role='dialog'>
    <div class="modal-dialog modal-md" role="document">
      <div class="modal-content">
              <button type="button" class="btn-close" data-dismiss="modal"><span class="fa fa-times" style="background-color:red;"></span></button>
              <img src="" alt="">
      </div>
    </div>
  </div> 

  <!--Start of Tawk.to Script-->
<script type="text/javascript">
var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
(function(){
var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
s1.async=true;
s1.src='https://embed.tawk.to/6526b5006fcfe87d54b8d62e/1hcfj62re';
s1.charset='UTF-8';
s1.setAttribute('crossorigin','*');
s0.parentNode.insertBefore(s1,s0);
})();
</script>
<!--End of Tawk.to Script-->

  </body>
</html>

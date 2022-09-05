<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title><?php echo $this->config->config["siteTitle"]?> | <?php echo $title;?></title>
  <!-- plugins:css -->
  <link rel="stylesheet" href="<?php echo base_url() ?>public/vendors/iconfonts/simple-line-icon/css/simple-line-icons.css">
  <link rel="stylesheet" href="<?php echo base_url() ?>public/vendors/iconfonts/flag-icon-css/css/flag-icon.min.css">
  <link rel="stylesheet" href="<?php echo base_url() ?>public/vendors/css/vendor.bundle.base.css">
  <link rel="stylesheet" href="<?php echo base_url() ?>public/vendors/css/vendor.bundle.addons.css">
  <!-- endinject -->
  <!-- plugin css for this page -->
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <link rel="stylesheet" href="<?php echo base_url() ?>public/css/style.css">
  <!-- endinject -->
  <link rel="shortcut icon" href="<?php echo base_url() ?>public/images/favicon.png">
</head>

<body>
  <div class="container-scroller">
    <div class="container-fluid page-body-wrapper full-page-wrapper">
      <div class="content-wrapper auth p-0 theme-two">
        <div class="row d-flex align-items-stretch">
          <div class="col-md-4 banner-section d-none d-md-flex align-items-stretch justify-content-center">
            <div class="slide-content bg-1">
            </div>
          </div>
          <div class="col-12 col-md-8 h-100 bg-white">
            <div class="auto-form-wrapper d-flex align-items-center justify-content-center flex-column">
            <?php if(isset($msg) || validation_errors() !== ''): ?>
             <div class="alert alert-warning alert-dismissible" style="width:50%;">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <h4><i class="icon fa fa-warning"></i> Alert!</h4>
                        <?php validation_errors();?>
                        <?php isset($msg)? $msg: ''; ?>
                    </div>
              <?php endif; ?>
              
              <?php if($this->session->flashdata('error')): ?>
                          <div class="alert alert-danger" style="width:50%;">
                          <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
                          <?=$this->session->flashdata('error')?>
                        </div>
                    <?php endif; ?>
                    
                    
              <?php echo form_open(base_url('auth/login'), 'class="cmxform"  id="logIn" method="post"'); ?>
                <h3 class="mr-auto">Hello! let's get started</h3>
                <p class="mb-3 mr-auto">Enter your details below.</p> 
                <span id="response" style="color:#F00; font-size:12px;"></span>
                <div class="form-group has-danger">
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="icon-user"></i></span>
                    </div>
                    <input type="text" class="form-control required" placeholder="Username" title="Please enter your username (at least 4 characters)" name="userid" id="userid" minlength="4">
                  </div>
                </div>
                <div class="form-group">
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="icon-lock"></i></span>
                    </div>
                    <input type="password" class="form-control required" placeholder="Password" title="Please enter your password, between 4 and 15 characters"  name="userpwd" id="userpwd"  maxlength="15" minlength="4">
                  </div>
                </div>
                <div class="form-group">
                  <button  type="submit" class="btn btn-primary submit-btn" name="submit" id="submit" value="Login">SIGN IN</button>
                </div>
                <div class="wrapper mt-5 text-gray">
                  <p class="footer-text">Copyright © <?php echo date('Y');?> <a href="hses.hyvesports.com" target="_blank">HYVE SPORTS</a>. All rights reserved.</p>
                  
                </div>
              <?php echo form_close(); ?>
            </div>
          </div>
        </div>
      </div>
      <!-- content-wrapper ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->
  <!-- plugins:js -->
  <script src="<?php echo base_url() ?>public/vendors/js/vendor.bundle.base.js"></script>
  <script src="<?php echo base_url() ?>public/vendors/js/vendor.bundle.addons.js"></script>
  <!-- endinject -->
  <!-- Plugin js for this page-->
  <!-- End plugin js for this page-->
  <!-- inject:js -->
  <script src="<?php echo base_url() ?>public/js/template.js"></script>
  <!-- endinject -->
  <!-- Custom js for this page-->
  <!-- End custom js for this page-->
  
<script language="javascript">
$(function() {
// validate the comment form when it is submitted
$("#logIn").validate({
errorLabelContainer: $("#response"),

});
});
</script>
</body>

</html>

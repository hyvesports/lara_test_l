<!DOCTYPE html>
<html lang="en">
<?php include('includes/_head.php'); ?>
<script src="<?php echo base_url() ?>public/vendors/js/vendor.bundle.base.js"></script>
<script src="<?php echo base_url() ?>public/vendors/js/vendor.bundle.addons.js"></script>
<body>
<div class="container-scroller">
<!-- partial:partials/_horizontal-navbar.html -->
    <nav class="navbar horizontal-layout col-lg-12 col-12 p-0">
    	<?php include('includes/_top_bar.php'); ?>
        <?php include('includes/_top_menu.php'); ?>
    </nav>

<!-- partial -->
    <div class="container-fluid page-body-wrapper">
    <div class="main-panel">
     <?php
	 //echo $view;
	 $this->load->view($view);?>
    <!-- content-wrapper ends -->
    <!-- partial:partials/_footer.html -->
    
    <?php include('includes/_footer.php'); ?>
    <!-- partial -->
    </div>
    <!-- main-panel ends -->
    </div>
<!-- page-body-wrapper ends -->
</div>
  <script src="<?php echo base_url() ?>public/js/template.js"></script>
  <script src="<?php echo base_url() ?>public/js/dashboard.js"></script>
  <script src="<?php echo base_url() ?>public/js/todolist.js"></script>
  <script src="<?php echo base_url() ?>public/js/pie-chart-js.js"></script>
 <!-- <script src="<?php echo base_url() ?>public/js/rpie.js"></script>-->
    <script src="<?php echo base_url() ?>public/js/chart-min.js"></script>

  
</body>

</html>

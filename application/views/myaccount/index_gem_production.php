<div class="container-fluid page-body-wrapper">
<div class="main-panel">
<div class="content-wrapper" id="sales_index">

<div class="row">
    <div class="col-md-12 grid-margin">
        <div class="row">
            <div class="col-12 col-xl-8 mb-4 mb-xl-0">
            <h3 class="font-weight-bold">Welcome <?php echo $this->session->userdata('username');?></h3>
            <h6 class="font-weight-normal mb-0"></h6>
            </div>
<div class="col-12 col-xl-8 mb-4 mb-xl-0">
<p style="text-align:left; float:left;" class="text-right">
<a class="btn btn-outline-info" href="<?=base_url('myaccount/index')?>">Overall</a>
<a class="btn btn-outline-danger" href="<?=base_url('myaccount/index_admin_gem_sales_single')?>">Gem Wise</a>
<a class="btn btn-outline-dark " href="<?=base_url('myaccount/index_admin_gem_production/')?>">Production</a>
</p>
</div>

            <div class="col-12 col-xl-4">
            <div class="justify-content-end d-flex">
            <div class="dropdown flex-md-grow-1 flex-xl-grow-0">
            <input name="wo_dispatch_date" id="wo_dispatch_date" type="text" class="form-control  datepicker  bg-white" readonly="readonly" 
            value="<?php echo date("d-m-Y", strtotime($this->session->userdata('date_now'))); ?>" />
            <script>
            $('.datepicker').datepicker({
            autoclose: true,
            format: 'dd-mm-yyyy',
            }).on('changeDate', function(e){
                //alert("Hiii");
                var todate = $(this).val();
                var formData="<?php echo $this->security->get_csrf_token_name(); ?>=<?php echo $this->security->get_csrf_hash(); ?>&td="+todate;
                $.ajax({  
                    type: "POST",
                    url: "<?= base_url("myaccount/set_date/");?>",  
                    data: formData,
                    beforeSend: function(){ $('#sales_index').html('<p style="text-align:center; width:100%;"><i class="fa fa-spin fa-refresh"></i><br/>Loading...</p>'); },
                    success: function(response){
                     //   alert(response);
                        //$("#day_overview").html(response);
                       // setTimeout(function() {
                         window.location.reload();
                        //}, 10);  
                    }
                });
            });
            </script>
            
            </div>
            </div>
            </div>
            </div>
        </div>
    </div>
<?php
$staff_id=$this->session->userdata('staff_id');
$selectedDate=date("Y-m-d", strtotime($this->session->userdata('date_now')));
$month=date("m", strtotime($this->session->userdata('date_now')));
$year=date("Y", strtotime($this->session->userdata('date_now')));

?>
<?php include('admin_production/statistics_1.php');?>
<?php include('admin_production/statistics_2.php');?>
<?php include('admin_production/statistics_3.php');?>
<?php include('admin_production/statistics_4.php');?>
<?php include('admin_production/statistics_5.php');?>
<?php include('admin_production/statistics_6.php');?>

</div>
<!-- content-wrapper ends -->
<!-- partial:partials/_footer.html -->

<!-- partial -->
</div>
<!-- main-panel ends -->
</div>

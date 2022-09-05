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
                        //$("#day_overview").html(response);
                        setTimeout(function() {
                         window.location.reload()
                        }, 1000);  
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
$month=date("m", strtotime($this->session->userdata('date_now')));
$leadArray=$this->myaccount_model->get_leads_statistics($staff_id,$month);
?>
<?php include('sales/statistics_1.php');?>
<?php include('sales/statistics_2.php');?>
<?php //include('sales/statistics_3.php');?>
<?php include('sales/statistics_4.php');?>
</div>
<!-- content-wrapper ends -->
<!-- partial:partials/_footer.html -->

<!-- partial -->
</div>
<!-- main-panel ends -->
</div>

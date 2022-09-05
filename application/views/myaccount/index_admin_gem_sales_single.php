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
<div class="col-6 col-xl-2 mb-4 mb-xl-0">
<form action="#" id="orderStatusChecker" name="orderStatusChecker" >
<select class="js-example-basic-multiple w-100 required"  name="sales_id"  id="sales_id" onchange="this.form.submit()">
<?php if($lead_staffs){ ?>
<option value="">--- Select ---</option>
<?php foreach($lead_staffs as $LS){ ?>
<option value="<?php echo $LS['staff_id'];?>" <?php if(($_GET['sales_id'])==$LS['staff_id']){ ?>selected <?php } ?>><?php echo $LS['staff_code'];?>-<?php echo $LS['staff_name'];?></option>	
<?php } ?>
<?php } ?>
</select>
</form>

</div>


            </div>
        </div>
    </div>
<?php


if($_GET['sales_id'])
{
$staff_id=$_GET['sales_id'];

}



$month=date("m", strtotime($this->session->userdata('date_now')));
$year=date("Y", strtotime($this->session->userdata('date_now')));
//$leadArray=$this->myaccount_model->get_leads_statistics($staff_id,$month);
$leadArray=$this->myaccount_model->get_leads_statistics_new($staff_id,$month,$year);
$orderArray = $this->myaccount_model->get_order_statistics_new($staff_id,$month,$year);
$orderRecArray = $this->myaccount_model->get_amount_to_rec_by_sales($staff_id,$month,$year);


?>

<?php include('admin/statistics_gem_1.php');?>
<?php include('admin/statistics_gem_chart.php');?>
<?php $woArray=$this->myaccount_model->get_wo_statistics($staff_id,$month,$year); ?>
<?php include('admin/statistics_task.php');?>
<?php include('admin/statistics_cost.php');?>


</div>
<!-- content-wrapper ends -->
<!-- partial:partials/_footer.html -->

<!-- partial -->
</div>
<!-- main-panel ends -->
</div>

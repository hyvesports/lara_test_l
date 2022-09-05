<div class="tab-pane fade show active pr-3" id="schedule" role="tabpanel" aria-labelledby="schedule">
        
<style>
.disabled{
	color:#F00;
}

</style>
<?php 
//echo($row['wo_dispatch_date']);
$proDate=$this->schedule_model->get_production_start_date_from_calendar_for_offfline($row['wo_dispatch_date']);
$p_start_date=date('d-m-Y');

if(isset($proDate['START_DATE'])){
	$p_start_date=date("d-m-Y", strtotime($proDate['START_DATE']));
}
$p_start_date=date('d-m-Y', strtotime('-6 day'));
?>

<form action="post" id="scheduleInputForm" name="scheduleInputForm">
    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
    <input type="hidden" name="schedule_id"  id="schedule_id" value="0">
    <input type="hidden" name="wo_uuid" id="wo_uuid" value="<?php echo $row['order_uuid'];?>"  />
    <div class="row">
    <div class="col-md-2">
    <label>Order Date <span class="text-danger">*</span></label>
     <input type="text" class="form-control" name="order_date" id="order_date" value="<?php echo $order_date=date("d-m-Y", strtotime($row['wo_date']));?> " readonly="readonly">
    </div>
    
    <!--<div class="col-md-2">
    <label>Dispatch Date <span class="text-danger">*</span></label>
     <input type="text" class="form-control" name="wo_dispatch_date" id="wo_dispatch_date" value="<?php //echo $wo_dispatch_date=date("d/m/Y", strtotime($row['wo_dispatch_date']));?> " readonly="readonly">
    </div>-->
    
    
    <div class="col-md-2">
    <label>Production Start Date <span class="text-danger">*</span></label>
     <input type="text" class="form-control required datepicker" name="production_start_date" id="production_start_date" value="<?php echo $p_start_date;?>" readonly="readonly" >
    </div>
    
     <div class="col-md-3">
    <label>Production Unit <span class="text-danger">*</span></label>
    <?php if($punits) {?>
    <select class="form-control required"  id="unit_id" name="unit_id"   > 
    <option value="">--- Select ---</option>
    <?php foreach($punits as $UN){ ?>
    <option value="<?php echo $UN['production_unit_id'];?>"><?php echo $UN['production_unit_name'];?></option>
    <?php } ?>
   
    </select>
    <?php } ?>
     
    </div>
    
    <div class="col-md-3"> <button type="submit" style="margin-top:30px;"  class="btn btn-info" id="submitData" name="submitData">Check Availability & Schedule</button>
    </div>
    
    </div>
    
    
    </form>
        
<span id="scheduleContent"></span>
       
</div>
<?php $disDates=$this->schedule_model->get_all_disabiled_days_d_m_y(date('Y-m-d')); ?>
<script>
$('.datepicker').datepicker({
autoclose: true,
format: 'dd-mm-yyyy',
todayHighlight: true,
startDate: "<?php echo $p_start_date;?>",
<?php if($disDates!=""){ ?>
datesDisabled:"<?php echo $disDates['CDATE'];?>"
<?php } ?>
});
</script>
<script type="text/javascript">
$(document).ready(function() {
$("#scheduleInputForm").validate({
highlight: function(element) {
$(element).closest('.form-control').removeClass('is-valid').addClass('is-invalid');
},
unhighlight: function(element) {
$(element).closest('.form-control').removeClass('is-invalid').addClass('is-valid');
},
errorElement: 'p',
errorClass: 'text-danger',
errorPlacement: function(error, element) {
if (element.parent('.input-group').length || element.parent('label').length) {
error.insertAfter(element.parent());
} else {
error.insertAfter(element);
}
},
submitHandler: function() {
//$("#loginAccount").attr("disabled", "disabled");
$('#submitData').html("<i class='fa fa-spin fa-spinner'></i> Please Wait ...");
$('#scheduleContent').html('<p style="text-align:center; width:100%;"><i class="fa fa-spin fa-refresh"></i><br/>Loading...</p>');
$.post('<?= base_url("orders/schedule_timeline/");?>', $("#scheduleInputForm").serialize(), function(data) {
	
	$("#scheduleContent").html(data);
	$('#submitData').html("Check Availability & Schedule");
	
});	
}
});
});
</script>
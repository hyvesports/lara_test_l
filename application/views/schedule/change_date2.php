<?php  
//echo $_POST['did'];
$arrayItems = json_decode($order_row['sh_order_json'],true);
//print_r($sdepartment);
$nextDepatartment="";
if( $_POST['did']==4){ // design
	$nextDepatartment=5;
}else if($_POST['did']==5){ //printing
	$nextDepatartment=6;
}else if($_POST['did']==6){ //fusing
	$nextDepatartment=12;
}else if($_POST['did']==12){ //bundling
	$nextDepatartment=8;
}
$nextRowArray=$scheduleArray1=$this->schedule_model->get_next_department_and_date($nextDepatartment,$sdepartment['order_id'],$sdepartment['unit_id'],$sdepartment['department_schedule_date']);
//print_r($nextRowArray);
?>
<div class="modal-body" style="background:#FFF;">
<?php
if($arrayItems) {
foreach($arrayItems as $arrayItemsKey => $arrayItemsValue){
	if($arrayItemsValue['summary_id']==$_POST['sumid']){
	?>
    <div class="alert" role="alert" style="background-color:<?php echo $arrayItemsValue['priority_color_code'];?>;color:#000;">
    <p>Designing</p>
    <h5 >#<?php echo ucwords($arrayItemsValue['orderno']);?> : <?php echo ucwords($arrayItemsValue['product_type']);?> (<?php echo ucwords($arrayItemsValue['item_unit_qty_input']);?>)</h5>
    <p>
    <?php echo ucwords($arrayItemsValue['collar_type']);?>,
    <?php echo ucwords($arrayItemsValue['sleeve_type']);?>,
    <?php echo ucwords($arrayItemsValue['fabric_type']);?>,
    <?php echo ucwords($arrayItemsValue['addon_name']);?></p>
    </div>
    <?php } ?>
<?php } ?>
<?php } ?>
 	<form id="changeDateForm" name="changeDateForm">
    <input type="hidden" name="SD" id="SD" value="<?php echo $this->input->post('SD');?>" />
    <input type="hidden" name="ED" id="ED" value="<?php echo $this->input->post('ED');?>" />
    <input type="hidden" name="UID" id="UID" value="<?php echo $this->input->post('UID');?>" />
    

    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
    
    <input type="hidden" name="schedule_department_id" id="schedule_department_id" value="<?php echo $sdepartment['schedule_department_id'];?>" />
    <div class="form-group row">
    <label for="exampleInputEmail2" class="col-sm-3 col-form-label">Scheduled Date</label>
    <div class="col-sm-9">
    <input type="text" class="form-control required" id="scheduled_date"  name="scheduled_date" placeholder="scheduled_date" value="<?php echo date('d-m-Y', strtotime($sdepartment['department_schedule_date']));?>" readonly="readonly">
    </div>
    </div>
    <div class="form-group row">
    <label for="exampleInputMobile" class="col-sm-3 col-form-label">New Date</label>
    <div class="col-sm-9">
    <input type="text" class="form-control required" id="selected_date" name="selected_date" readonly="readonly" value="<?php echo date('d-m-Y', strtotime($sdepartment['department_schedule_date']));?>" >
    </div>
    </div>
    <button type="submit" class="btn btn-primary mr-2 float-right" name="submitDataModel" id="submitDataModel" value="CPD">Save</button>
    </form>
</div>  
<script type="text/javascript" src="<?php echo base_url() ?>public/moment.min.js"></script>
<link rel="stylesheet" type="text/css" media="all" href="<?php echo base_url() ?>public/daterangepicker.css" />
<script type="text/javascript" src="<?php echo base_url() ?>public/daterangepicker.js"></script>
<script type="text/javascript">
$(function() {
	$('#selected_date').daterangepicker({
		locale: {format: 'DD-MM-YYYY'},
		singleDatePicker: true,
		 autoApply: false,
		showDropdowns: true,
		 minDate: moment(),
		"maxDate": "<?php echo date('d-m-Y', strtotime($nextRowArray['department_schedule_date']));?>"
	});
	
	$('#changeDate').on('hidden.bs.modal', function () {
    	// do somethin
		//alert("okkk");
		//_________________________________________
		
		var formData = "<?php echo $this->security->get_csrf_token_name(); ?>=<?php echo $this->security->get_csrf_hash(); ?>&start_date=<?php echo $this->input->post('SD');?>&end_date=<?php echo $this->input->post('ED');?>&unit_id=<?php echo $this->input->post('UID');?>";
		
		$.ajax({  
		type: "POST",
		url: "<?= base_url("orders/overview_result/");?>",  
		data: formData,
			beforeSend: function(){ $('#scheduleContent').html('<p style="text-align:center; width:100%;"><i class="fa fa-spin fa-refresh"></i><br/>Loading...</p>'); },
			success: function(response){
			$("#scheduleContent").html(response);
			
			}
		}); 
		
		//_________________________________________
	});
	
	$("#changeDateForm").validate({
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
	//$("#submitDataModel").attr("disabled", "disabled");
	$('#submitDataModel').html("Please Wait ...");
	//$('#response').html('<font class="text-yellow">Checking.Please wait..</font>');
	//$('#modelResp').html('<p style="text-align:center; width:100%;"><i class="fa fa-spin fa-refresh"></i><br/>Saving...</p>');
	$.post('<?= base_url("schedule/change_date_post/");?>', $("#changeDateForm").serialize(), function(data) {
																								
		var dataRs = jQuery.parseJSON(data);
		//$("#submitDataa").delay("slow").fadeIn();
		//$('#submitDataa').html("Save");
		//$('#submitDataa').removeAttr("disabled");
		$('#changeDateForm').html(dataRs.responseMsg);
		//$( '#calenderData' ).each(function(){this.reset();});
		
	});	
	}
	});	
	
	
	
});
</script>


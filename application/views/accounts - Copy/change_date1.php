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
$nextRowArray=$scheduleArray1=$this->schedule_model->get_next_department_and_date($nextDepatartment,$sdepartment['order_id'],$sdepartment['unit_id']);
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


<form  id="mf"  name="mf">
<div class="form-group row">
<label for="exampleInputEmail2" class="col-sm-3 col-form-label">Scheduled Date</label>
<div class="col-sm-9">
<input type="text" class="form-control" id="scheduled_date" placeholder="scheduled_date" value="<?php echo date('d/m/Y', strtotime($sdepartment['department_schedule_date']));?>" readonly="readonly">
</div>
</div>
<div class="form-group row">
<label for="" class="col-sm-3 col-form-label">New Date <span class="text-danger">*</span></label>
<div class="col-sm-9">
<input type="text" class="form-control" data-inputmask="'alias': 'date'" name="new_date" id="new_date" value="<?php //echo date('d/m/Y', strtotime($nextRowArray['department_schedule_date']));?>" onkeyup="loadChoosedDateStatus(this.value);">
<span id="load_resp" class='text-center'></span>
</div>
</div>
<button type="submit" class="btn btn-primary mr-2 float-right">Save</button>
</form> 
</div>   
<script>
//$(document).ready(function() {
//$('#exampleInputMobile').datepicker({
//autoclose: false,
//format: 'yyyy-mm-dd',
//});
//});

function loadChoosedDateStatus(choosed_date){
	$("#load_resp").html("<i class='fa fa-spin fa-spinner'></i>");
	var formData = "<?php echo $this->security->get_csrf_token_name(); ?>=<?php echo $this->security->get_csrf_hash(); ?>&cd="+choosed_date;
	var modal = $(this);
	$.ajax({  
	type: "POST",
	url: "<?= base_url("schedule/choosed_date/");?>",  
	data: formData,
	beforeSend: function(){
		modal.find('.modal-content').html('<i class="fa fa-cog fa-spin"></i>');},
		success: function(response){
		modal.find('.modal-content').html(response);
		
		}
	}); 
 
}
</script>
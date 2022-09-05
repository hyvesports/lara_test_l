<?php //print_r($_POST);
$rdid=$_POST['rdid'];
$sqlSel="Select * from rs_design_departments where rs_design_id='$rdid'"; 
$query = $this->db->query($sqlSel);					 
$rsRowData=$query->row_array();

$schedule_department_id=$rsRowData['schedule_department_id'];
$sql2="SELECT * FROM sh_schedule_departments WHERE schedule_department_id='$schedule_department_id' ";
$query2 = $this->db->query($sql2);					 
$sdRow=$query2->row_array();
//print_r($rsRowData);
$submitted_item=$rsRowData['submitted_item'];
$item_unit_qty_input=0;
$submitted_item_array=json_decode($submitted_item,true); // from db
foreach($submitted_item_array as $postkey=>$postvalue){
	if($rsRowData['summary_item_id']==$submitted_item_array[$postkey]['summary_id']){
		$item_unit_qty_input=$submitted_item_array[$postkey]['item_unit_qty_input'];
		$hidden_order_item_name=$submitted_item_array[$postkey]['product_type'];
	}
}
//echo $item_unit_qty_input;
//echo $item_unit_qty_input;
$schedule_id=$rsRowData['schedule_id'];
$sql2="SELECT wo_work_orders.orderform_type_id,wo_work_orders.order_id FROM sh_schedules,wo_work_orders WHERE sh_schedules.schedule_id='$schedule_id' AND sh_schedules.order_id=wo_work_orders.order_id";
$query2 = $this->db->query($sql2);					 
$orderRow=$query2->row_array();
//print_r($orderRow);

//print_r($sdRow);
?>
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-label="Close">
<span aria-hidden="true">x</span>
</button>
</div>
<div class="modal-content">

<div class="modal-body">
<div class="card-body">
                  <h4 class="card-title"><?php if($_POST['afor']==1){ echo 'Approve'; $required=""; }else{ echo 'Reject'; $required="required";}?></h4>
                 
                  <form class="forms-sample" action="" id="saveStatus">
					<input type="hidden" name="hidden_order_id" id="hidden_order_id" value="<?php echo $orderRow['order_id'];?>" />
					<input type="hidden" name="item_unit_qty_input" id="item_unit_qty_input" value="<?php echo $item_unit_qty_input;?>" />
					<input type="hidden" name="hidden_order_item_name" id="hidden_order_item_name" value="<?php echo $hidden_order_item_name;?>" />

                  <input type="hidden" name="rdid" id="rdid" value="<?php echo $_POST['rdid'];?>" />
                  <input type="hidden" name="afor" id="afor" value="<?php echo $_POST['afor'];?>" />
                  <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                    <div class="form-group">
                      <label for="exampleInputUsername1">Remark</label>
                      <textarea  class="form-control <?php echo $required;?>"  name="Remark" id="Remark"></textarea>
                    </div>
                    
                    <button type="submit" class="btn btn-primary mr-2" name="submit" value="Submit">Submit</button>
                    <button class="btn btn-danger" data-dismiss="modal">Cancel</button>
                  </form>
                </div>
</div>
</div>

<script type="text/javascript">
$(function() {
	

	
	$("#saveStatus").validate({
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
	$.post('<?= base_url("qc/save_status/");?>', $("#saveStatus").serialize(), function(data) {
																								
		window.location.reload();  
		
	});	
	}
	});	

});
</script>



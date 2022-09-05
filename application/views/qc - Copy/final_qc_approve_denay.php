<?php
//print_r($_POST);
$rdid=$_POST['rdid'];
$sqlSel="Select * from rs_design_departments where rs_design_id='$rdid'"; 
$query = $this->db->query($sqlSel);					 
$rsRowData=$query->row_array();

$schedule_id=$rsRowData['schedule_id'];
$sql2="SELECT orderform_type_id FROM sh_schedules,wo_work_orders WHERE sh_schedules.schedule_id='$schedule_id' AND sh_schedules.order_id=wo_work_orders.order_id";
$query2 = $this->db->query($sql2);					 
$orderRow=$query2->row_array();
//print_r($orderRow);
?>

<div class="modal-header">

<button type="button" class="close" data-dismiss="modal" aria-label="Close">

<span aria-hidden="true">x</span>

</button>

</div>



<div class="modal-content">



<div class="modal-body">

<div class="card-body">

                  <h4 class="card-title"><?php if($_POST['afor']==1){ echo 'Approve';$required=""; }else{ echo 'Reject';$required="required";}?></h4>

                 

                  <form class="forms-sample" action="" id="saveStatus">

                  <input type="hidden" name="rdid" id="rdid" value="<?php echo $_POST['rdid'];?>" />

                  <input type="hidden" name="afor" id="afor" value="<?php echo $_POST['afor'];?>" />

                  <input type="hidden" name="rej_schedule_id" id="rej_schedule_id" value="<?php echo $rsRowData['schedule_id'];?>" />

                  <input type="hidden" name="rej_unit_id" id="rej_unit_id" value="<?php echo $rsRowData['unit_id'];?>" />

                  <input type="hidden" name="rej_summary_item_id" id="rej_summary_item_id" value="<?php echo $rsRowData['summary_item_id'];?>" />

                  <input type="hidden" name="schedule_department_id" id="schedule_department_id" value="<?php echo $rsRowData['schedule_department_id'];?>" />
                  <input type="hidden" name="orderform_type_id" id="orderform_type_id" value="<?php echo $orderRow['orderform_type_id'];?>" />

                 

                  

                  <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">

				

                <?php if($_POST['afor']=="-1"){ ?>

                <div class="form-group">

                <label for="exampleInputUsername1">Reject To <span class="text-danger">*</span></label>

                <select class="form-control required" id="reject_dep_id" name="reject_dep_id">

                <option value="">--- Select ---</option>

              	<option value="4">Design Department</option>

                <option value="8">Stitching Department</option>

                </select>

                </div>

                <?php } ?>

                  

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

	$.post('<?= base_url("finalqc/final_qc_save_status/");?>', $("#saveStatus").serialize(), function(data) {

																								

		window.location.reload();  

		

	});	

	}

	});	



});

</script>






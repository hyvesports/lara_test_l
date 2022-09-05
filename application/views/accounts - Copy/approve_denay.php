<div class="modal-body"  >
<div class="card-body">
<h4 class="card-title">Update Account Status</h4>
<span id="action_resp"></span>
<form name="updateStatusForm" id="updateStatusForm">
<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
<input type="hidden" name="afor" id="afor" value="<?php echo $_POST['afor'];?>" />
<input type="hidden" name="rdid" id="rdid" value="<?php echo $_POST['rdid'];?>" />
<?php //print_r($schedule_data); ?>
<?php $arrayJson = json_decode($schedule_data['submitted_item'],true); ?>
<?php if($arrayJson){ $k=0; ?>
<div class="list-wrapper">
<ul class="d-flex flex-column-reverse todo-list">
	<?php foreach($arrayJson as $jKey => $jValue){  ?>
    <?php if($jValue['summary_id']==$_POST['smid']){ ?>
    <input type="hidden" name="summary_id" value='<?php echo ucwords($jValue['summary_id']);?>' />
    
    <li class="completed">
    <div class="form-check"><i class="fa fa-check-circle"></i>
    <label class=""><?php echo ucwords($jValue['product_type']);?> <em></em></label>
    <?php if(isset($jValue['online_ref_number'])){ if($jValue['online_ref_number']!=""){?>
    <p class="mb-1">
    <span class="badge" style="background-color:#ffe74c;">Ref: No:   <?php echo ucwords($jValue['online_ref_number']);?></span>
    </p>
	<?php } }?>
    <p class="mb-2"><span class="badge" style="background-color:#ffe74c;">Quantity: <?php echo ucwords($jValue['item_unit_qty_input']);?></span></p>
    
    <?php if($jValue['remark']!=""){?><p class="text-muted mb-1">Remark : <?php echo ucwords($jValue['remark']);?></p><?php } ?>
    <span class=" align-items-center mt-1">
    <span class="btn btn-xs btn-rounded btn-outline-primary mr-2"><?php echo ucwords($jValue['collar_type']);?></span>
    <span class="btn btn-xs btn-rounded btn-outline-primary mr-2"><?php echo ucwords($jValue['sleeve_type']);?></span>
    <span class="btn btn-xs btn-rounded btn-outline-primary mr-2"><?php echo ucwords($jValue['fabric_type']);?></span>
    <span class="btn btn-xs btn-rounded btn-outline-primary mr-2"><?php echo ucwords($jValue['addon_name']);?></span>
    
    <?php if($jValue['img_front']!=""){?>
    <br /><span class="btn btn-xs btn-rounded btn-outline-primary mr-2 mt-1">
    <a href="<?php echo $jValue['img_front'];?>" target="_blank">Image Front</a>
    </span>
    <?php } ?>
    <?php if($jValue['img_back']!=""){?>
    <br /><span class="btn btn-xs btn-rounded btn-outline-primary mr-2 mt-1">
    <a href="<?php echo $jValue['img_back'];?>" target="_blank">Image Back</a>
    </span>
    <?php } ?>
    
    </span>
    </div>
    </li>
    <?php $k++;  } ?>
    <?php }?>
</ul>
</div>
<?php } ?>
<?php //echo $k;?>

<div class="form-group">
<label for="exampleInputEmail1">Remark</label>
<textarea type="text" class="form-control required" id="accounts_remark"  name="accounts_remark"  rows="4"></textarea>
</div>

<?php if($k!=0){ ?>
<button type="submit" class="btn btn-primary mr-2" id="submit" name="submit" value="Submit">Submit</button>
<?php } ?>
</form>
</div>
</div>  
<script type="text/javascript">
$(function() {
	$('#approveDeny').on('hidden.bs.modal', function () {
    	location.reload();
		//_________________________________________
	});
	$("#updateStatusForm").validate({
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
	//$("#submitData").attr("disabled", "disabled");
	$('#submitData').html("Please Wait ...");
	$.post('<?= base_url("accounts/save_updates/");?>', $("#updateStatusForm").serialize(), function(data) {
		window.location.reload();  
		
	});	
	}
	});	

});
</script> 
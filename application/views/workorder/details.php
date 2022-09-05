<div class="content-wrapper">
<div class="row grid-margin">
<div class="col-12">
<div class="card">
<div class="card-body">
<?php if(isset($msg) || validation_errors() !== ''): ?>
<div class="alert alert-warning alert-dismissible" style="width:100%;">
<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
<h4><i class="icon fa fa-warning"></i> Alert!</h4>
<?php echo validation_errors();?>
</div>
<?php endif; ?>

<?php if($this->session->flashdata('error')): ?>
<div class="alert alert-danger" style="width:100%;">
<a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
<?=$this->session->flashdata('error')?>
</div>
<?php endif; ?>

<?php if($this->session->flashdata('success')): ?>
<div class="alert alert-success" style="width:100%;">
<a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
<?=$this->session->flashdata('success')?>
</div>
<?php endif; ?>


<h4 class="card-title"><?php echo $title_head;?>
<span style="text-align:right; float:right;"><a class="btn btn-primary " href="<?php echo base_url('workorder/index');?>">List</a></span> 
</h4>

<?php echo form_open_multipart(base_url('workorder/details/'.$row['order_uuid']), 'class="cmxform"  id="dataform" method="post"'); ?>
<input type="hidden" name="order_id" id="order_id" value="<?php echo $row['order_id'];?>" />
<input type="hidden" name="wo_client_id" id="wo_client_id" value="<?php echo $row['wo_client_id'];?>" />

<p class="card-description" style="border-bottom: 1px solid #f2f2f2;"><strong> Order Details</strong></p>
<div class="row">
<div class="col-md-12">
<div class="form-group row">
<label class="col-md-2 col-form-label">Special requirement</label>
<div class="col-md-10">
<textarea class="form-control" id="wo_special_requirement" name="wo_special_requirement" rows="4"><?php echo $this->input->post('wo_special_requirement');?></textarea>
</div>
</div>
</div>


<div class="col-md-6">
<div class="form-group row">
<label class="col-md-4 col-form-label">Priority *</label>
<div class="col-md-8">
<select class="form-control required" id="wo_work_priority_id" name="wo_work_priority_id"  > 
<option value="">--- Select ---</option>
<?php if($priority){ ?>
<?php foreach($priority as $prty){ ?>
<option value="<?php echo $prty['priority_id'];?>"><?php echo $prty['priority_name'];?></option>
<?php } ?>
<?php } ?>
</select>
</div>
</div>
</div>


<div class="col-md-6">
<div class="form-group row">
<label class="col-md-4 col-form-label">Shipping Mode <?php if($row['orderform_type_id']==1){ echo '*'; }?></label>
<div class="col-md-8">
<select class="form-control <?php if($row['orderform_type_id']==1){ echo 'required'; }?>" id="wo_shipping_mode_id" name="wo_shipping_mode_id"  > 
<option value="">--- Select ---</option>
<?php if($shipping_modes){ ?>
<?php foreach($shipping_modes as $SMS){ ?>
<option value="<?php echo $SMS['shipping_mode_id'];?>"><?php echo $SMS['shipping_mode_name'];?></option>
<?php } ?>
<?php } ?>
</select>
</div>
</div>
</div>




<div class="col-md-12">
<div class="form-group row">
<label class="col-md-2 col-form-label">Billing Address <?php if($row['orderform_type_id']==1){ echo '*'; }?></label>
<div class="col-md-10">
<textarea class="form-control <?php if($row['orderform_type_id']==1){ echo 'required'; }?>" id="billing_address" name="billing_address" rows="4" onkeyup="updateFields();"><?php echo $this->input->post('billing_address');?></textarea>
</div>
</div>
</div>
</div>

<div class="col-md-12">
<div class="form-group row">
<label class="col-md-2 col-form-label">Shipping Address <?php if($row['orderform_type_id']==1){ echo '*'; }?></label>
<div class="col-md-10">
<input type="checkbox"  name="sameas" id="sameas"> Same as Billing Address
<textarea class="form-control <?php if($row['orderform_type_id']==1){ echo 'required'; }?>" id="shipping_address" name="shipping_address" rows="4"><?php echo $this->input->post('shipping_address');?></textarea>
</div>
</div>
</div>



<p class="card-description" style="border-bottom: 1px solid #f2f2f2;" id=""><strong>Order Documents</strong></p>
<div class="row" >
<div class="col-md-12">
<div class="form-group row">
<label class="col-md-2 col-form-label">Images <em style="font-size:10px; color:#030;">Multiple</em>*</label>
<div class="col-md-10">
<input type="file" name="upload_file1" id="upload_file1" readonly="true"/><br/>
<div id="moreImageUpload"></div>
<div style="clear:both;"></div>
						<div id="moreImageUploadLink" style="display:none;">
							<a href="javascript:void(0);" id="attachMore">Attach another file</a>
						</div>
</div>
</div>


</div>
<script type="text/javascript">
function updateFields(){
	 if ($("#sameas").is(':checked')) {
	$('#shipping_address').val($('#billing_address').val());
	 }
}
    $(document).ready(function() {
							   
		$('#sameas').click(function() {
			if ($(this).is(':checked')) {
				$('#shipping_address').attr('readonly', true);
				$('#shipping_address').val($('#billing_address').val());
			}else{
				$('#shipping_address').removeAttr('readonly');
				$('#shipping_address').val("");
			}
		});
							   
							   
        $("input[id^='upload_file']").each(function() {
            var id = parseInt(this.id.replace("upload_file", ""));
            $("#upload_file" + id).change(function() {
                if ($("#upload_file" + id).val() !== "") {
                    $("#moreImageUploadLink").show();
                }
            });
        });
    });
</script>
<script type="text/javascript">
    $(document).ready(function() {
        var upload_number = 2;
        $('#attachMore').click(function() {
            //add more file
            var moreUploadTag = '';
            moreUploadTag += '<br/><div class="element">';
            moreUploadTag += '<input type="file" id="upload_file' + upload_number + '" name="upload_file' + upload_number + '"/>';
            moreUploadTag += '&nbsp;<a href="javascript:del_file(' + upload_number + ')" style="cursor:pointer;" onclick="return confirm(\"Are you really want to delete ?\")">Delete</a></div>';
            $('<dl id="delete_file' + upload_number + '">' + moreUploadTag + '</dl>').fadeIn('slow').appendTo('#moreImageUpload');
            upload_number++;
        });
    });
</script>
<script type="text/javascript">
    function del_file(eleId) {
        var ele = document.getElementById("delete_file" + eleId);
        ele.parentNode.removeChild(ele);
    }
</script>


<div class="col-md-12">
<div class="form-group row">
<label class="col-md-2 col-form-label">Attachment *</label>
<div class="col-md-10">
<input type="file" name="attachment" class="" id="attachment">
</div>
</div>
</div>



</div>


<input class="btn btn-primary float-right" type="submit" value="Save" id="submit" name="submit">
<?php echo form_close(); ?>
</div>
</div>
</div>
</div>
</div>
<script language="javascript">

$(function() {
		   
$("#grp_date").on("change",function(){
									
									var selected = $(this).val();
	var post_data = {
'<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>',
gpdate:selected
};								
									
	
	//alert(selected);
	//var post_data='gp_data='+selected;
	$.ajax({
	type: "POST",
	url: "<?= base_url("workorder/group_ajax/");?>",
	data: post_data
	}).done(function(reply) {
		//$('#loadClientData').html("");
		$('#grp_number').val(reply);
	});
});

$('.mydatepicker').datepicker({
enableOnReadonly: false,
todayHighlight: false,
});

$("#dataform").validate({
errorPlacement: function(label, element) {
label.addClass('mt-2 text-danger');
label.insertAfter(element);
},
highlight: function(element, errorClass) {
$(element).parent().addClass('has-danger')
$(element).addClass('form-control-danger')
}
});


});
</script>
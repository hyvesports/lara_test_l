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
<?php //print_r($row);?>
<?php
	$sumRows=$this->formdata_model->get_wo_order_summary_sum($row['order_id']); 
	//print_r();
	?>
<?php echo form_open_multipart(base_url('formdata/details/'.$row['order_uuid']), 'class="cmxform"  id="dataform" method="post"'); ?>
<input type="hidden" name="order_id" id="order_id" value="<?php echo $row['order_id'];?>" />
<input type="hidden" name="wo_client_id" id="wo_client_id" value="<?php echo $row['wo_client_id'];?>" />
<p class="card-description" style="border-bottom: 1px solid #f2f2f2;"><strong> Account Details</strong></p>
<div class="form-group row">
<div class="col-md-4" >
<div class="form-group row">
<label class="col-md-6 col-form-label">Total Quantity</label>
<div class="col-md-6">
<input type="text" class="form-control required" name="order_total_qty" id="order_total_qty"  value="<?php echo $sumRows['totalQty'];?>" readonly="readonly">
</div>
</div>
</div>

<div class="col-md-4" >
<div class="form-group row">
<label class="col-md-6 col-form-label">Total Rate</label>
<div class="col-md-6">
<input type="text" class="form-control required" name="order_total_rate" id="order_total_rate"  value="<?php echo $sumRows['totalRate'];?>" readonly="readonly">
</div>
</div>
</div>

<div class="col-md-4" >
<div class="form-group row">
<label class="col-md-6 col-form-label">Total Discount</label>
<div class="col-md-6">
<input type="text" class="form-control" name="order_total_discount" id="order_total_discount"  value="<?php echo $sumRows['totalDiscount'];?>" readonly="readonly">
</div>
</div>
</div>

<div class="col-md-6">
<div class="form-group row">
<label class="col-md-4 col-form-label">Shipping Cost*</label>
<div class="col-md-8">
<input name="wo_shipping_cost" id="wo_shipping_cost" type="text" class="form-control  required number" onkeyup="calculateAmount();"  maxlength="10" value="<?php echo $row['wo_shipping_cost'];?>"  />
</div>
</div>
</div>
<div class="col-md-6">
<div class="form-group row">
<label class="col-md-4 col-form-label">Additional Cost  *</label>
<div class="col-md-8">
<input type="text" class="form-control number" name="wo_additional_cost" id="wo_additional_cost" maxlength="8" value="<?php echo $row['wo_additional_cost'];?>"  onkeyup="calculateAmount();" >
</div>
</div>
</div>
<div class="col-md-12">
<div class="form-group row">
<label class="col-md-2 col-form-label">Additional Cost Description *</label>
<div class="col-md-10">
<input type="text" class="form-control" name="wo_additional_cost_desc" id="wo_additional_cost_desc" maxlength="500"  value="<?php echo $row['wo_additional_cost_desc'];?>">
</div>
</div>
</div>
<div class="col-md-6">
<div class="form-group row">
<label class="col-md-4 col-form-label">Tax *</label>
<div class="col-md-8">
<select class="form-control required" id="wo_tax_id" name="wo_tax_id" onchange="calculateAmount();"> 
<option value="" taxval='0'>--- Select ---</option>
<?php if($taxclass){ ?>
<?php foreach($taxclass as $taxx){ ?>
<option  value="<?php echo $taxx['taxclass_id'];?>" taxval='<?php echo $taxx['taxclass_value'];?>'  <?php if($row['wo_tax_id']==$taxx['taxclass_id']){ echo 'selected="selected"'; }?>><?php echo $taxx['taxclass_name'];?> [ Value: <?php echo $taxx['taxclass_value'];?> % ] </option>
<?php } ?>
<?php } ?>
</select>
</div>
</div>
</div>
<div class="col-md-6">
<div class="form-group row">
<label class="col-md-4 col-form-label">Adjustment *</label>
<div class="col-md-8">
<input type="text" class="form-control number" name="wo_adjustment" id="wo_adjustment" maxlength="5"  value="<?php echo $row['wo_adjustment'];?>" onkeyup="calculateAmount();" >
</div>
</div>
</div>
<div class="col-md-4" >
<div class="form-group row">
<label class="col-md-6 col-form-label">Gross Cost *</label>
<div class="col-md-6">
<input type="text" class="form-control required number" name="wo_gross_cost" id="wo_gross_cost" maxlength="10"  value="<?php echo $row['wo_gross_cost'];?>"  readonly="readonly">
</div>
</div>
</div>
<div class="col-md-4">
<div class="form-group row">
<label class="col-md-6 col-form-label">Advance*</label>
<div class="col-md-6">
<input type="text" class="form-control required number" name="wo_advance" id="wo_advance" maxlength="8"  value="<?php echo $row['wo_advance'];?>" onkeyup="calculateAmount();">
</div>
</div>
</div>
<div class="col-md-4">
<div class="form-group row">
<label class="col-md-6 col-form-label">Balance*</label>
<div class="col-md-6">
<input type="text" class="form-control number" name="wo_balance" id="wo_balance" maxlength="50"  value="<?php echo $row['wo_balance'];?>" readonly="readonly">
</div>
</div>
</div>
</div>

<script language="javascript">
function calculateAmount(){
var rateSum=parseFloat($("#order_total_rate").val());
var discountSum=parseFloat($("#order_total_discount").val());
var totalAmountWithDiscount= parseFloat(rateSum)-parseFloat(discountSum);
//alert(totalAmountWithDiscount);
//var addition_total=rateSum;
var deduction_total=0;
	var wo_additional_cost=0;
	if($("#wo_additional_cost").val()!=""){
		wo_additional_cost=parseFloat($("#wo_additional_cost").val());
		totalAmountWithDiscount += parseFloat(wo_additional_cost);
	}
	var taxTotal;
	var taxPercentage = $('option:selected','#wo_tax_id').attr('taxval');
	if(taxPercentage>0){
		//alert("ysss");
		var AMT=parseFloat(totalAmountWithDiscount);
		//alert(AMT);
		if(AMT>0 ){
			//alert("ysss");
			//alert(taxPercentage);
			var main = AMT;
			var disc = taxPercentage;
			var dec = (disc / 100).toFixed(2);
			var mult = main * dec; // gives the value for subtract from main value
			var discont = mult;
			totalAmountWithDiscount+= parseFloat(discont);
			//alert(discont);
		   // $('#result').val(discont);
		}
	}
	//alert(totalAmountWithDiscount);
	var wo_shipping_cost=0;
	if($("#wo_shipping_cost").val()!=""){
		wo_shipping_cost=parseFloat($("#wo_shipping_cost").val());
		totalAmountWithDiscount += parseFloat(wo_shipping_cost);
	}
	var wo_adjustment=0;
	if($("#wo_adjustment").val()!=""){
		wo_adjustment=parseFloat($("#wo_adjustment").val());
		deduction_total += parseFloat(wo_adjustment);
	}
	 var gross_cost;
	 gross_cost=parseFloat(totalAmountWithDiscount)-parseFloat(deduction_total);
	 $("#wo_gross_cost").val(gross_cost.toFixed( 2 ));

	var wo_advance=0;
	if($("#wo_advance").val()!=""){
		wo_advance=parseFloat($("#wo_advance").val());
		//deduction_total += parseFloat(wo_adjustment);
	}
	var gross_balance=parseFloat(gross_cost)-parseFloat(wo_advance);
	$("#wo_balance").val(gross_balance.toFixed(2));
}
</script>   
<p class="card-description" style="border-bottom: 1px solid #f2f2f2;"><strong> Order Details</strong></p>
<div class="row">
<div class="col-md-12">
<div class="form-group row">
<label class="col-md-2 col-form-label">Special requirement</label>
<div class="col-md-10">
<textarea class="form-control" id="wo_special_requirement" name="wo_special_requirement" rows="4"><?php echo $row['wo_special_requirement'];?></textarea>
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
<option value="<?php echo $prty['priority_id'];?>" <?php if($prty['priority_id']==$row['wo_work_priority_id']) { echo ' selected="selected"';} ?> ><?php echo $prty['priority_name'];?></option>
<?php } ?>
<?php } ?>
</select>
</div>
</div>
</div>

<div class="col-md-6">
<div class="form-group row">
<label class="col-md-4 col-form-label">Shipping Mode *</label>
<div class="col-md-8">
<select class="form-control required" id="wo_shipping_mode_id" name="wo_shipping_mode_id"  > 
<option value="">--- Select ---</option>
<?php if($shipping_modes){ ?>
<?php foreach($shipping_modes as $SMS){ ?>
<option value="<?php echo $SMS['shipping_mode_id'];?>" <?php if($SMS['shipping_mode_id']==$row['wo_shipping_mode_id']) { echo ' selected="selected"';} ?>><?php echo $SMS['shipping_mode_name'];?></option>
<?php } ?>
<?php } ?>
</select>
</div>
</div>
</div>

<input type="hidden" name="customer_shipping_id" id="customer_shipping_id" value="<?php echo $row['customer_shipping_id'];?>" />
<input type="hidden" name="customer_billing_id" id="customer_billing_id" value="<?php echo $row['customer_billing_id'];?>" />
<div class="col-md-12">
<div class="form-group row">
<label class="col-md-2 col-form-label">Billing Address *</label>
<div class="col-md-10">
<textarea class="form-control required" id="billing_address" name="billing_address" rows="4"><?php echo $row['billing_address'];?></textarea>
</div>
</div>
</div>
<div class="col-md-12">
<div class="form-group row">
<label class="col-md-2 col-form-label">Shipping Address *</label>
<div class="col-md-10">
<textarea class="form-control required" id="shipping_address" name="shipping_address" rows="4"><?php echo $row['shipping_address'];?></textarea>
</div>
</div>
</div>
</div>
<p class="card-description" style="border-bottom: 1px solid #f2f2f2;" id=""><strong>Order Documents</strong></p>
<div class="row" >
<div class="col-md-12">
<div class="form-group row">
<label class="col-md-2 col-form-label">Images <em style="font-size:10px; color:#030;">Multiple</em>*</label>
<div class="col-md-10">
<?php if($images) {?>
<ol>
	<?php foreach($images as $imgDoc) {?>
	<li id="doc_file<?php echo $imgDoc['document_id'];?>"><?php echo $imgDoc['document_name'];?> <em><a href="javascript:del_old_file(<?php echo $imgDoc['document_id'];?>)" style="color:#F00;" onclick="return confirm('Are you really want to delete ?')">Remove</a></em></li>
    <?php } ?>
</ol>
<?php } ?>
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
    $(document).ready(function() {
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
	function del_old_file(eleId) {
		var post_data = {
		'<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>',
		'document_id':+eleId,
		};
		//$('#orderform_number_load').html("<p style='text-align:center'>Loading... </p>");
		//alert(cid);
		$.ajax({
		type: "POST",
		url: "<?= base_url("workorder/removedoc/");?>",
		data: post_data
		}).done(function(reply) {
			$('#orderform_number_load').html("");
			$('#orderform_number').val(reply);

		});
        var ele = document.getElementById("doc_file" + eleId);
        ele.parentNode.removeChild(ele);
    }
</script>
<div class="col-md-12">
<div class="form-group row">
<label class="col-md-2 col-form-label">Attachment *</label>
<div class="col-md-10">
<?php if($Attachment) {?>
<ol>
	<?php foreach($Attachment as $AttachmentDco) {?>
	<li id="doc_file<?php echo $AttachmentDco['document_id'];?>"><?php echo $AttachmentDco['document_name'];?> <em><a href="javascript:del_old_file(<?php echo $AttachmentDco['document_id'];?>)" style="color:#F00;" >Remove</a></em></li>
    <?php } ?>
</ol>
<?php } ?>
<input type="file" name="attachment" class="" id="attachment">
</div>
</div>
</div>




</div>
<input class="btn btn-primary float-right" type="submit" value="Save" id="submit" name="submit">
<?php echo form_close(); ?>

<div class="col-lg-12 grid-margin stretch-card">
<div class="card">
<div class="card-body">
<h4 class="card-title">Jquery file upload</h4>
<form action="<?= base_url("attachment/save_img/");?>" class="dropzone align-items-center" id="my-awesome-dropzone">
<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
</form>
</div>
</div>
</div>
<script type='text/javascript'>
        Dropzone.autoDiscover = false;
        $(".dropzone").dropzone({
            addRemoveLinks: false,
            removedfile: function(file) {
                var name = file.name;    
                
                $.ajax({
                    type: 'POST',
                    url: '<?= base_url("attachment/save_img/");?>',
                    data: {name: name,request: 2},
                    sucess: function(data){
                        console.log('success: ' + data);
                    }
                });
                var _ref;
                return (_ref = file.previewElement) != null ? _ref.parentNode.removeChild(file.previewElement) : void 0;
            }
        });
        </script>
</div>
</div>
</div>
</div>
</div>
<script src="<?php echo base_url()?>public/js/jquery-file-upload.js"></script>
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
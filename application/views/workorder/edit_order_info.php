<form action="post" id="wo_form">
<input type="hidden" name="order_id"  id="order_id" value="<?php echo $woRow['order_id']; ?>"/>
<div class="row">

<?php //print_r($woRow); ?>
<div class="col-md-6"  id="orderno">
<div class="form-group row">
<label class="col-md-4 col-form-label">Order Number*</label>
<div class="col-md-8">
<input type="text" class="form-control required" name="orderform_number" id="orderform_number" value="<?php echo $woRow['orderform_number'];?>" readonly="readonly" >
<span id="orderform_number_load"></span>
</div>
</div>
</div>

<div class="col-md-6">
<div class="form-group row">
<label class="col-md-4 col-form-label">Order Nature *</label>
<div class="col-md-8">
<select class="form-control required" id="wo_order_nature_id" name="wo_order_nature_id"  > 
<option value="">--- Select ---</option>
<?php if($order_nature){ ?>
<?php foreach($order_nature as $ON){ ?>
<option value="<?php echo $ON['order_nature_id'];?>" <?php if($ON['order_nature_id']==$woRow['wo_order_nature_id']) { echo ' selected="selected"';} ?>><?php echo $ON['order_nature_name'];?></option>
<?php } ?>
<?php } ?>
</select>
</div>
</div>
</div>

<div class="col-md-6">
<div class="form-group row">
<label class="col-md-4 col-form-label">Dispatch Date *</label>
<div class="col-md-8">
<input name="wo_dispatch_date" id="wo_dispatch_date" type="text" class="form-control  datepicker required" readonly="readonly" 
value="<?php echo $woRow['wo_dispatch_date']; ?>" />
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
<option value="<?php echo $prty['priority_id'];?>" <?php if($prty['priority_id']==$woRow['wo_work_priority_id']) { echo ' selected="selected"';} ?>><?php echo $prty['priority_name'];?></option>
<?php } ?>
<?php } ?>
</select>
</div>
</div>
</div>
</div>

<span id='product_info' >
<p class="card-description" style="border-bottom: 1px solid #f2f2f2;"><strong>Product Information </strong></p>
<div class="form-group row">
<div class="col-md-12">
<div class="form-group row">

<div class="col-md-12">
<input name="wo_product_info" id="wo_product_info" type="text" class="form-control required" value="<?php echo $woRow['wo_product_info']; ?>" />
</div>
</div>
</div>


<div class="col-md-12">
</div>
</div>
</span>
<input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">
<input class="btn btn-primary float-right" type="submit" value="Update" id="submit" name="submit">
</form>
  <script>
    $('.datepicker').datepicker({
      autoclose: true,
	   format: 'yyyy-mm-dd'
    });
  </script>
<script type="text/javascript">
$(document).ready(function() {
//$("#wo_form").validate();	
$("#wo_form").validate({
submitHandler: function() {
//$("#submit").attr("disabled", "disabled");
//$("#response").html('Data Saving...');
$('#submit').html('<i class="fa fa-asterisk fa-spin  text-warning"></i> Please wait..!');
$.post('<?= base_url("workorder/save_order_data/");?>', $("#wo_form").serialize(), function(data) {
	var dataRs = jQuery.parseJSON(data);
	$("#response").html(dataRs.responseMsg);
	//return false;
});	
}
});	
});
</script>

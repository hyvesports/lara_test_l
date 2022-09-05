<div class="content-wrapper">
<div class="row grid-margin">
<div class="col-12">
<div class="card">

<div class="card-body">


<?php if(isset($msg) || validation_errors() !== ''): ?>
<div class="alert alert-warning alert-dismissible" style="width:50%;">
<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
<h4><i class="icon fa fa-warning"></i> Alert!</h4>
<?php validation_errors();?>
<?php isset($msg)? $msg: ''; ?>
</div>
<?php endif; ?>

<?php if($this->session->flashdata('error1')): ?>
<div class="alert alert-danger" style="width:100%;">
<a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
<?=$this->session->flashdata('error1')?>
</div>
<?php endif; ?>

<?php if($this->session->flashdata('success1')): ?>
<div class="alert alert-success" style="width:100%;">
<a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
<?=$this->session->flashdata('success1')?>
</div>
<?php endif; ?>



<h4 class="card-title"><?php echo $title_head;?>
<span style="text-align:right; float:right;"><a class="btn btn-primary " href="<?php echo base_url('location/index');?>">List</a></span> 
</h4>
<p class="card-description" style="border-bottom: 1px solid #f2f2f2;">Update Location  </p>


<?php echo form_open(base_url('location/edit/'.$row['location_uuid']), 'class="cmxform"  id="dataform" method="post"'); ?>
<input type="hidden"  name="location_id" id="location_id" value="<?php echo $row['location_id'];?>" />


<div class="form-group row">
<div class="col-lg-3"><label class="col-form-label">Country</label></div>
<div class="col-lg-9">
<select class="form-control required" id="location_country_id" name="location_country_id" onchange="loadStates(this.value);">
<option value="">--- Select ---</option>
<?php if($countries){ ?>
<?php foreach($countries as $country){ ?>
<option value="<?php echo $country['country_id'];?>" <?php if($country['country_id']==$row['location_country_id']){ echo 'selected="selected"'; }?>><?php echo $country['country_name'];?></option>
<?php } ?>
<?php } ?>
</select>
</div>
</div>
	<script language="javascript">
	function loadStates(locid){
	var post_data = {
          '<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>'
        };
	$('#location_state_id_load').html("Loading...");
	//alert(locid);
	$.ajax({
		    type: "POST",
			url: "<?= base_url("location/states_ajax/"); ?>"+locid,
			data: post_data,
			dataType: "json"
		}).done(function(reply) {
		    $("#location_state_id").find("option").remove();
			// Loop through JSON response
			$('#location_state_id').append($('<option>', { value: "" }).text("--- Select ---")); 
			$.each(reply, function(key, value) {   
				$('#location_state_id').append($('<option>', { value: value.state_id }).text(value.state_name)); 
			});
			$('#location_state_id_load').html("");
	});
	}
	</script>
<div class="form-group row">
<div class="col-lg-3"><label class="col-form-label">State</label></div>
<div class="col-lg-9">
<select class="form-control required" id="location_state_id" name="location_state_id">
<option value="">--- Select ---</option>
<?php if($states){ ?>
<?php foreach($states as $state){ ?>
<option value="<?php echo $state['state_id'];?>" <?php if($state['state_id']==$row['location_state_id']){ echo 'selected="selected"'; }?>><?php echo $state['state_name'];?></option>
<?php } ?>
<?php } ?>
</select>
</select>
<span id="location_state_id_load"></span>
</div>
</div>


<div class="form-group row">
<div class="col-lg-3"><label class="col-form-label">Location Name</label></div>
<div class="col-lg-9"><input class="form-control"  name="location_name" id="location_name" type="text"  value="<?php echo $row['location_name'];?>" required=""></div>
</div>

<input class="btn btn-primary float-right" type="submit" value="Submit" id="submit" name="submit">
<?php echo form_close(); ?>
</div>
</div>
</div>
</div>
</div>
<script language="javascript">
$(function() {
// validate the comment form when it is submitted
//$("#dataform").validate();
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
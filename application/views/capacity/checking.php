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

</h4>
	<form action="post" id="dateInputForm" name="dateInputForm">
    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
    <div class="row">
    <div class="col-md-4">
    <label>Date <span class="text-danger">*</span></label>
    <input type="text" class="form-control required datepicker" name="check_date" id="check_date" value="<?php echo date('d-m-Y');?>" readonly="readonly" >
    </div>
    <div class="col-md-4">
    <label>Unit <span class="text-danger">*</span></label>
    <?php if($punits) {?>
    <select class="form-control required"  id="unit_id" name="unit_id"   > 
    <option value="">--- Select ---</option>
    <?php foreach($punits as $UN){ ?>
    <option value="<?php echo $UN['production_unit_id'];?>"><?php echo $UN['production_unit_name'];?></option>
    <?php } ?>
    </select>
    <?php } ?>
    </div>
    <div class="col-md-2"> <button type="submit" style="margin-top:30px;"  class="btn btn-info" id="submitData" name="submitData">Check Capacity</button>
    </div>
    </div>
    </form>
</div>
</div>


</div>
</div>

<span id="dateContent">
</span>


</div>

<script>
$('.datepicker').datepicker({
autoclose: true,
format: 'dd-mm-yyyy',
});
</script>
<script type="text/javascript">
$(document).ready(function() {
$("#dateInputForm").validate({
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
$('#submitData').html("Please Wait ...");
$('#dateContent').html('<p style="text-align:center; width:100%;"><i class="fa fa-spin fa-refresh"></i><br/>Loading...</p>');
$.post('<?= base_url("capacity/load_capacity/");?>', $("#dateInputForm").serialize(), function(data) {
	$("#dateContent").html(data);
	$('#submitData').html("Check Capacity");
	
});	
}
});
});
</script>

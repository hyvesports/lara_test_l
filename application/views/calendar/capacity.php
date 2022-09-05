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
<span style="text-align:right; float:right;"><a class="btn btn-primary " href="<?php echo base_url('calendar/index');?>">List</a></span> 
</h4>

<h4 class="card-title"><?php echo $month_and_year;?> <?php //print_r($non_working_days);?></h4>
	<form action="post" id="dateInputForm" name="dateInputForm">
    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
	<input type="hidden" name="calendar_month" id="calendar_month" value="<?php echo $calendar_month;?>" />
	<input type="hidden" name="calendar_year" id="calendar_year" value="<?php echo $calendar_year;?>" />
   	<input type="hidden" name="month_and_year" id="month_and_year" value="<?php echo $month_and_year;?>" />
	<div class="row">
    <div class="col-md-6">
    <label>Unit <span class="text-danger">*</span></label>
    <select class="form-control required" id="unit_id" name="unit_id" onchange="loadDatesOfCalendar();" > 
    <option value="">--- Select ---</option>
	<?php if($production_units) {;?>
	<?php foreach($production_units as $PU) { ?>
   	<option value="<?php echo $PU['production_unit_id'];?>"><?php echo $PU['production_unit_name'];?></option>
    <?php } ?>
	<?php } ?>
    </select>
    </div>
    </div>
	</form>
    <div class="row mt-3">
    <div class="col-md-12">
    <span id="dateContent"></span>
    </div>
    
    </div>
    
</div>
</div>


</div>
</div>



</div>

<script language="javascript">
function loadDatesOfCalendar(){
	$('#dateContent').html('<p style="text-align:center; width:100%;"><i class="fa fa-spin fa-refresh"></i><br/>Loading...</p>');
	$.post('<?= base_url("calendar/load_dates_for_departments/");?>', $("#dateInputForm").serialize(), function(data) {
		
		$("#dateContent").html(data);
		$('#submitData').html("Load Dates");
		
	});
}
</script>
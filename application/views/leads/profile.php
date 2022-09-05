<div class="content-wrapper">
<div class="row">
<div class="col-md-12 grid-margin stretch-card">
<div class="card">
<div class="card-body">
<h4 class="card-title">LEAD FILTER</h4>
	<?php echo form_open("/",'id="lead_search"') ?>
    <div class="row">
    <div class="col-md-2"> 
    <label>Lead Date:</label>
    <input name="search_date" type="text" class="form-control  datepicker" readonly="readonly" value="<?php echo $this->session->userdata('lead_search_date');?>" />
    </div>
    
    <div class="col-md-2">
     <label>Lead Source:</label>
     <select class="form-control required" id="lead_source_id" name="lead_source_id" > 
<option value="">--- Select ---</option>
<?php if($lead_sources){ ?>
<?php foreach($lead_sources as $LS){ ?>
<option value="<?php echo $LS['lead_source_id'];?>" <?php if($this->session->userdata('lead_source_id')==$LS['lead_source_id']) { echo 'selected="selected" ';}?>  ><?php echo $LS['lead_source_name'];?></option>
<?php } ?>
<?php } ?>
</select>
     </div>
     
     
    <div class="col-md-2">
     <label>Lead Type:</label>
     <select class="form-control required" id="lead_type_id" name="lead_type_id"> 
<option value="">--- Select ---</option>
<?php if($lead_types){ ?>
<?php foreach($lead_types as $LTS){ ?>
<option value="<?php echo $LTS['lead_type_id'];?>" <?php if($this->session->userdata('lead_type_id')==$LTS['lead_type_id']) { echo 'selected="selected" ';}?> ><?php echo $LTS['lead_type_name'];?></option>
<?php } ?>
<?php } ?>
</select>
     </div>
    <div class="col-md-2"> 
    <label>Sports Type:</label><select class="form-control required"  name="sports_type_id"  id="sports_type_id">
    <option value="">--- Select ---</option>
<?php if($sports_types){ ?>
<?php foreach($sports_types as $ST){ ?>
<option value="<?php echo $ST['sports_type_id'];?>" <?php if($this->session->userdata('lead_sports_type_id')==$ST['sports_type_id']) { echo 'selected="selected" ';}?> ><?php echo $ST['sports_type_name'];?></option>
<?php } ?>
<?php } ?>
</select></div>
    
    <div class="col-md-2"> <label>Client Mobile :</label><input name="lead_search_key" type="text" class="form-control form-control-inline input-medium " id="" value="<?php echo $this->session->userdata('lead_search_key');?>" /></div>
    <div class="col-md-2"> <button type="button" style="margin-top:30px;" onclick="lead_filter()" class="btn btn-info">Submit</button>
    <a href="<?= base_url('leads/index'); ?>" class="btn btn-danger" style="margin-top:30px;"><i class="fa fa-repeat"></i></a>
</div>
    </div>
    <?php echo form_close(); ?>
</div>
</div>
</div>
</div>

<div class="card">
<div class="card-body">
<?php if($this->session->flashdata('error')): ?>
<div class="alert alert-danger" style="width:100%;">
<a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">x</a>
<?=$this->session->flashdata('error')?>
</div>
<?php endif; ?>

<?php if($this->session->flashdata('success')): ?>
<div class="alert alert-success" style="width:100%;">
<a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">x</a>
<?=$this->session->flashdata('success')?>
</div>
<?php endif; ?>


<h4 class="card-title"><?php echo $title_head;?><span style="text-align:right; float:right;"><a class="btn btn-primary " href="<?php echo base_url('leads/add');?>">ADD NEW</a></span>
</h4>
<div class="row">
<div class="col-12 table-responsive">
<table id="listing" class="table" width="100%">
<thead>
<tr>
<th>No:</th>
<th>Lead No & Date</th>
<th>Lead Client</th>
<th>Lead Source</th>
<th>Type</th>
<th style="text-align:center;">Actions</th>
</tr>
</thead>

</table>
</div>
</div>
</div>
</div>
</div>

 
  <script>
    $('.datepicker').datepicker({
      autoclose: true,
	   format: 'dd/mm/yyyy'
    });
  </script>
<script>
	var table = $('#listing').DataTable( {
      "processing": true,
      "serverSide": true,
      "ajax": "<?=base_url('leads/advance_datatable_json')?>",
     
      "columnDefs": [
        { "targets": 0, "name": "lead_id", 'searchable':true, 'orderable':true},
        { "targets": 1, "name": "lead_code", 'searchable':true, 'orderable':true},
        { "targets": 2, "name": "customer_name", 'searchable':true, 'orderable':true},
        { "targets": 3, "name": "lead_source_name", 'searchable':true, 'orderable':true},
        { "targets": 4, "name": "lead_type_name", 'searchable':true, 'orderable':false},
        { "targets": 5, "name": "lead_status", 'searchable':false, 'orderable':true,'className':'float-right'},
      ]
    });

function lead_filter()
  {
    var _form = $("#lead_search").serialize();
    $.ajax({
        data: _form,
        type: 'post',
        url: '<?php echo base_url();?>leads/filter',
        async: true,
        success: function(output){
            table.ajax.reload( null, false );
        }
    });
  }
</script>
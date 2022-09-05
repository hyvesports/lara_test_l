<div class="content-wrapper">
<div class="row">
<div class="col-md-12 grid-margin stretch-card">
<div class="card">
<div class="card-body">
<h4 class="card-title">LEAD FILTER</h4>
	<?php echo form_open("/",'id="user_search"') ?>
    <div class="row">
    <div class="col-md-2"> 
    <label>Lead Date:</label>
    <input name="user_search_from" type="text" class="form-control  datepicker" readonly="readonly" value="<?php echo date('Y-m-d');?>" />
    </div>
    
    <div class="col-md-2">
     <label>Lead Source:</label>
     <select class="form-control required" id="lead_source_id" name="lead_source_id"> 
<option value="">--- Select ---</option>
<?php if($lead_sources){ ?>
<?php foreach($lead_sources as $LS){ ?>
<option value="<?php echo $LS['lead_source_id'];?>"><?php echo $LS['lead_source_name'];?></option>
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
<option value="<?php echo $LTS['lead_type_id'];?>"><?php echo $LTS['lead_type_name'];?></option>
<?php } ?>
<?php } ?>
</select>
     </div>
    <div class="col-md-2"> 
    <label>Sports Type:</label><select class="form-control required"  name="sports_type_id"  id="sports_type_id">
    <option value="">--- Select ---</option>
<?php if($sports_types){ ?>
<?php foreach($sports_types as $ST){ ?>
<option value="<?php echo $ST['sports_type_id'];?>"><?php echo $ST['sports_type_name'];?></option>
<?php } ?>
<?php } ?>
</select></div>
    
    <div class="col-md-2"> <label>Client Email/Mobile :</label><input name="user_search_from" type="text" class="form-control form-control-inline input-medium datepicker" id="" /></div>
    <div class="col-md-2"> <button type="button" style="margin-top:30px;" onclick="user_filter()" class="btn btn-info">Submit</button>
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
<table id="listing" class="table">
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
<tbody>
<?php if($results){ $i=0; ?>
<?php foreach($results as $rslt){ $i++;?>
<tr>
<td><?php echo $i;?></td>
<td><?php echo $rslt['lead_code']." & ".$rslt['lead_date'];?></td>
<td><?php echo $rslt['customer_name'];?></td>
<td><?php echo $rslt['lead_source_name'];?></td>
<td class="<?php echo $rslt['color_code'];?>"><?php echo $rslt['lead_type_name'];?></td>
<td style="text-align:center;">
<a title="View" class="update btn btn-sm btn-success" href="<?php echo base_url('leads/view/'.$rslt['lead_uuid']);?>">View </a>
<a title="Edit" class="update btn btn-sm btn-warning" href="<?php echo base_url('leads/edit/'.$rslt['lead_uuid']);?>">Edit </a>
<a title="Delete" class="update btn btn-sm btn-danger" href="<?php echo base_url('leads/delete/'.$rslt['lead_uuid']);?>" onclick="return confirm('are you sure to delete?')">Delete </a>


</td>
</tr>
<?php }} ?>

</tbody>
</table>
</div>
</div>
</div>
</div>
</div>

 
  <script>
    $('.datepicker').datepicker({
      autoclose: true,
	   format: 'yyyy-mm-dd'
    });
  </script>
<script>

var table = $('#listing').DataTable( {
      "processing": true,
      "serverSide": true,
      "ajax": "<?=base_url('admin/example/advance_datatable_json')?>",
      "order": [[4,'desc']],
      "columnDefs": [
        { "targets": 0, "name": "id", 'searchable':true, 'orderable':true},
        { "targets": 1, "name": "username", 'searchable':true, 'orderable':true},
        { "targets": 2, "name": "email", 'searchable':true, 'orderable':true},
        { "targets": 3, "name": "mobile_no", 'searchable':true, 'orderable':true},
        { "targets": 4, "name": "created_at", 'searchable':false, 'orderable':false},
        { "targets": 5, "name": "is_active", 'searchable':true, 'orderable':true},
      ]
    });

</script>
<div class="content-wrapper">
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


<h4 class="card-title"><?php echo $title_head;?><span style="text-align:right; float:right;"><a class="btn btn-primary " href="<?php echo base_url('staff/add');?>">ADD NEW</a></span>
</h4>
<div class="row">
<div class="col-12 table-responsive">
<?php //print_r($accessArray);?>
<table id="listing" class="table">
<thead>
<tr>
<th>Sl No: #</th>
<th>User Name</th>
<th>Staff Details</th>
<th>Designation & Department</th>
<th>Location</th>
<th>Status</th>
<th style="text-align:center;">Actions</th>
</tr>
</thead>
<tbody>
<?php if($results){ $i=0; ?>
<?php foreach($results as $rslt){ $i++;?>
<tr>
<td><?php echo $i;?></td>
<td><?php echo $rslt['log_username'];?></td>
<td><?php echo $rslt['staff_code'];?> : <?php echo $rslt['staff_name'];?><br />
Email: <?php echo $rslt['staff_name'];?><br />
Mobile: <?php echo $rslt['staff_name'];?>
</td>
<td><?php echo $rslt['designation_name'];?> & <?php echo $rslt['department_name'];?></td>
<td><?php echo $rslt['location_name'];?></td>
<td><?php if($rslt['staff_status']=="1"){ ?>Active<?php }else{ echo 'In Active'; } ?></label></td>
<td style="text-align:center;"> 


<a title="Reset Password" data-toggle="modal" data-target="#resetPwd" data-slid="<?php echo $rslt['login_master_id'];?>" ><label class="badge badge-success" style="cursor: pointer;"> Reset Password</label></a>

<a title="Permission"href="<?php echo base_url('staff/permission/'.$rslt['staff_uuid']);?>"><label class="badge badge-info" style="cursor: pointer;"> Permission</label></a>

<?php if($accessArray){if(in_array("edit",$accessArray)){ ?>
<a href="<?php echo base_url('staff/edit/'.$rslt['staff_uuid']);?>" title="Edit" style="cursor: pointer;"><label class="badge badge-warning" style="cursor: pointer;"><i class="fa fa-pencil" ></i></label></a>
<?php }} ?>


<?php if($accessArray){if(in_array("delete",$accessArray)){ ?>
<a title="Delete" href="<?php echo base_url('staff/delete/'.$rslt['staff_uuid']);?>" onclick="return confirm('are you sure to delete?')" style="cursor: pointer;" ><label class="badge badge-danger" style="cursor: pointer;"><i class="fa fa-trash" ></i></label></a>
<?php }}?>



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

<div class="modal" id="resetPwd" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
<div class="modal-dialog modal-md" role="document" style="max-width: 700px;">
<div class="modal-content"></div> 
</div>
</div>
        <script>
		 $(function() {
    $('#listing').DataTable({
      "aLengthMenu": [
        [5, 10, 15, -1],
        [5, 10, 15, "All"]
      ],
      "iDisplayLength": 10,
      "language": {
        search: ""
      }
    });
    $('#listing').each(function() {
      var datatable = $(this);
      // SEARCH - Add the placeholder for Search and Turn this into in-line form control
      var search_input = datatable.closest('.dataTables_wrapper').find('div[id$=_filter] input');
      search_input.attr('placeholder', 'Search');
      search_input.removeClass('form-control-sm');
      // LENGTH - Inline-Form control
      var length_sel = datatable.closest('.dataTables_wrapper').find('div[id$=_length] select');
      length_sel.removeClass('form-control-sm');
    });
  });
  
  $(function() {
  $('#resetPwd').on('show.bs.modal', function (event) {
	var button = $(event.relatedTarget);
	var slid=button.data('slid');
	
	
	var formData = "<?php echo $this->security->get_csrf_token_name(); ?>=<?php echo $this->security->get_csrf_hash(); ?>&slid="+slid;
	//var cid=button.data('cid');
	//alert(oid);
	var modal = $(this);
	//var dataString = "cuid="+cuid;
	$.ajax({  
	type: "POST",
	url: "<?= base_url("staff/resetpwd/");?>",  
	data: formData,
	beforeSend: function(){
		modal.find('.modal-content').html('<i class="fa fa-spin fa-refresh"></i>');},
		success: function(response){
		modal.find('.modal-content').html(response); 
		}
	}); 
	});
	});  		
		</script>
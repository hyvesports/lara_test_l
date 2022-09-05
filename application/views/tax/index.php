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


<h4 class="card-title"><?php echo $title_head;?><span style="text-align:right; float:right;"><a class="btn btn-primary " href="<?php echo base_url('tax/add');?>">ADD NEW</a></span>
</h4>
<div class="row">
<div class="col-12 table-responsive">
<table id="listing" class="table">
<thead>
<tr>
<th>Sl No: #</th>
<th>Tax Name</th>

<th>Tax percentage</th>
<th>Status</th>
<th style="text-align:center;">Actions</th>
</tr>
</thead>
<tbody>
<?php if($results){ $i=0; ?>
<?php foreach($results as $rslt){ $i++;?>
<tr>
<td><?php echo $i;?></td>
<td><?php echo $rslt['taxclass_name'];?></td>
<td><?php echo $rslt['taxclass_value'];?></td>
<td><?php if($rslt['taxclass_status']=="1"){ ?>Active<?php }else{ echo 'In Active'; } ?></label></td>
<td style="text-align:center;">
<a title="Edit" class="update btn btn-sm btn-warning" href="<?php echo base_url('tax/edit/'.$rslt['taxclass_id']);?>">Edit </a>
<a title="Delete" class="update btn btn-sm btn-danger" href="<?php echo base_url('tax/delete/'.$rslt['taxclass_id']);?>" onclick="return confirm('are you sure to delete?')">Delete </a>


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
		</script>
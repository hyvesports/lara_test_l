<div class="content-wrapper">
<?php //include("filter.php")?>
<div class="card">
<div class="card-body">
<h4 class="card-title"><?php echo $title;?> | next</h4>
<div class="row">
<p style="text-align:right; float:right;" class="text-right">
<a class="btn btn-success " href="<?=base_url('task/index')?>">All</a>
<a class="btn btn-warning " href="<?=base_url('task/today')?>">Today</a>
<a class="btn btn-info " href="<?=base_url('task/nextday/')?>">Next Day</a>
<a class="btn btn-danger " href="<?=base_url('task/previousday/')?>">Previous Day</a>
</p>

<div class="col-12 table-responsive">
<table id="listing" class="table" >
<thead>
<tr>
<th>Task</th>
<th>#Lead</th>
<th>Customer</th>
<th>Reminder Date & Time</th>
</tr>
</thead>
</table>
</div>
</div>
</div>
</div>
</div>

<script>
	var table = $('#listing').DataTable( {
      	"processing": true,
      	"serverSide": true,
      	"ajax": "<?=base_url('task/list_next')?>",
     	"order": [[0,'desc']],
      "columnDefs": [
        { "targets": 0, "name": "tasks.task_id", 'searchable':true, 'orderable':true},
        { "targets": 1, "name": "tasks.lead_id", 'searchable':true, 'orderable':true},
		{ "targets": 2, "name": "tasks.customer_info", 'searchable':true, 'orderable':false},
        { "targets": 3, "name": "tasks.reminder_date", 'searchable':true, 'orderable':false,className:'text-center'},
		
      ]

    });
</script>


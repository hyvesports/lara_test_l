<div class="content-wrapper">
<?php //include("filter.php")?>
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
<h4 class="card-title"><?php echo $title_head;?></h4>
<div class="row">
<div class="col-12 table-responsive">
<table id="listing" class="table" >
<thead>
<tr>
<th>Order Number</th>
<th>Rej: Date</th>
<th>Order Date Timestamp</th>
<th>Disp: Date	</th>
<th>Summary</th>
<th>Status</th>
<th style="text-align:center;">Actions</th>
</tr>



</thead>
<?php if($records){ ?>
<?php foreach($records as $row){ ?>
<?php $dispatchRow=$this->common_model->get_order_final_dispatch_date($row['schedule_id']); ?>
<?php
$itemArray = json_decode($row['submitted_item']);
			if($itemArray) {
				foreach($itemArray as  $value1){
					if($value1->summary_id==$row['rej_summary_item_id']){
						if(isset($value1->online_ref_number)){
						$itemRefNo=$value1->online_ref_number;
						}
						$itemDetails=$value1->product_type;
						$itemDetailsQty=$value1->item_unit_qty_input;
					}
				}
			}
			?>
<tr>
<td><?php echo $row['orderform_number'];?></td>
<td><?php echo $row['rejected_timestamp'];?></td>
<td><?php echo $row['wo_date_time'];?></td>
<td><?php echo date("d-m-Y", strtotime($dispatchRow['department_schedule_date']));?></td>
<td><label class="badge badge-outline-success"><?php echo $row['wo_product_info'].'<br>'.$itemDetails;?>(<?php echo $itemDetailsQty;?>)</label></td>
<td>

<label class="badge badge-danger" style="cursor: pointer;"><i class="fa fa-thumbs-down" ></i> <?php echo $row['rejected_department'];?> Rejected </label><br />


<?php if($row['re_schedule_status']==1){ ?>
<label class="badge badge-success mt-1" >ReScheduled</label>
<?php }else if($row['re_schedule_status']==-1){?>
<label class="badge badge-warning mt-1" >In Draft</label>
<?php }else{ ?>
<label class="badge badge-danger mt-1" >Not ReScheduled</label>
<?php } ?>


</td>
<td>

<a href="<?php echo base_url('reschedule/schedule/'.$row['schedule_id'].'/'.$row['order_id'].'/'.$row['rs_design_id']);?>" title="View" style="cursor: pointer;"><label class="badge badge-info" style="cursor: pointer;"><i class="fa fa-search" ></i> Reschedule</label></a>
</td>

</tr>
<?php } ?>
<?php } ?>
</table>
</div>
</div>
</div>
</div>
</div>

<div class="modal" id="approveDeny" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
<div class="modal-dialog modal-md" role="document">
<div class="modal-content"></div> 
</div>
</div>

<script>

	var table = $('#listing1').DataTable( {
      	"processing": true,
      	"serverSide": true,
      	"ajax": "<?=base_url('reschedule/reschedule_list')?>",
     	"order": [[0,'desc']],
      "columnDefs": [
          { "targets": 0, "name": "RSO.rej_order_id", 'searchable':true, 'orderable':true},
        { "targets": 1, "name": "SHD.department_schedule_date", 'searchable':false, 'orderable':false},
		{ "targets": 2, "name": "production_unit_name", 'searchable':false, 'orderable':false},
        { "targets": 3, "name": "schedule_date", 'searchable':false, 'orderable':false,className:'text-center'},
		{ "targets": 4, "name": "schedule_date", 'searchable':false, 'orderable':false,className:'text-center'},
		{ "targets": 5, "name": "schedule_date", 'searchable':false, 'orderable':false,className:'text-center'},
		{ "targets": 6, "name": "schedule_date", 'searchable':false, 'orderable':false,className:'text-center'},
		
      ]
    });
	
	
$(function() {

	$('#listing').DataTable({
	      "paging": true,
	      "lengthChange": false,
	      "searching": true,
	      "ordering": true,
	      "info": true,
	      "autoWidth": false
	    });

	$('#approveDeny').on('show.bs.modal', function (event) {
	
	var button = $(event.relatedTarget);
	var rdid=button.data('rdid');
	var sid=button.data('sid');
	var smid=button.data('smid');
	var afor=button.data('afor');
	
	var formData = "<?php echo $this->security->get_csrf_token_name(); ?>=<?php echo $this->security->get_csrf_hash(); ?>&rdid="+rdid+"&sid="+sid+"&smid="+smid+"&afor="+afor;
	//var cid=button.data('cid');
	//alert(oid);
	var modal = $(this);
	//var dataString = "cuid="+cuid;
	$.ajax({  
	type: "POST",
	url: "<?= base_url("accounts/approve_denay/");?>",  
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

<div class="table-responsive">
<div id="actionResponse"></div>
<table class="table">
<thead>
<tr>
<th class="pt-1 pl-0">Address</th>
<th>Tracking ID</th>
<th class="pt-1">Shipping Type/Mode</th>
<th>Action</th>
</tr>
</thead>
<tbody>
	<?php 
$wo_order_id=$row['order_id'];
$trackings=$this->dispatch_model->get_my_order_trackings($wo_order_id);
if($trackings){ $i=0;  $tcount=count($trackings);?>
    <?php foreach($trackings as $track){ $i++; ?>
	<?php $dis=$this->dispatch_model->get_my_order_dispatches_by_wo($wo_order_id,$track['dispatch_tracking_id']); ?>
    <tr id="currentTD<?php echo $track['dispatch_tracking_id'];?>">
    <td class="py-1 pl-0">
    <div class="d-flex align-items-center">
   <div class="ml-0">
    <p class="mb-2"><?php echo $dis['dispatch_client_name'];?></p>
    <p class="mb-0 text-muted text-small"><?php echo nl2br($dis['dispatch_address']);?></p>
    </div>
    </div>
    </td>
	<td><?php echo $track['traking_number'];?></td>
    <td><?php echo $dis['shipping_type_name'];?>/<?php echo $dis['shipping_mode_name'];?></td>
 
    <td>
	
<a href="#" class="badge badge-primary  float-center" title="Update" style="cursor: pointer;"  data-toggle="modal" data-target="#orderDispatch" 
 data-woid="<?php echo $wo_order_id;?>" data-tid="<?php echo $track['dispatch_tracking_id'];?>" data-actn='up'  ><i class="fa fa-search"></i></a>

    </td>
    </tr>
	<?php } } ?>
</tbody>

</table>
<div class="modal" id="orderDispatch" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
<div class="modal-dialog modal-md" role="document" style="max-width: 700px;">
<div class="modal-content"></div> 
</div>
</div>

</div>
<script>

$(function() {
$('#orderDispatch').on('hidden.bs.modal', function () {location.reload();});
$('#orderDispatch').on('show.bs.modal', function (event) {
var button = $(event.relatedTarget);
var woid=button.data('woid');
var tid=button.data('tid');
var formData = "<?php echo $this->security->get_csrf_token_name(); ?>=<?php echo $this->security->get_csrf_hash(); ?>&woid="+woid+"&tid="+tid;
//var cid=button.data('cid');
//alert(oid);
var modal = $(this);
//var dataString = "cuid="+cuid;
$.ajax({  
type: "POST",
url: "<?= base_url("dispatch/load_dispatch_model/");?>",  
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


<form action="post" id="wo_summary">
<input type="hidden" name="order_id"  id="order_id" value="<?php echo $woRow['order_id']; ?>"/>
<div class="form-group row">
<div class="col-md-12">
<div class="form-group row" id="contentDiv">

<table width="100%" class="table table-striped   mt-0 "  >
    <thead>
    <tr class="item_header">
    <th width="10%"   class="text-left">Ref No:</th>
    <th width="15%"  class="text-left">Product</th>
    <th width="15%"  class="text-left">Collar</th>
    <th width="13%"  class="text-left">Sleeve</th>
    <th width="14%"  class="text-left">Fabric</th>
    <th width="11%"  class="text-left">Add-ons</th>
    <th width="12%"  class="text-left">Qty</th>
    <th width="10%">Action</th>
    </tr>
    </thead>
    
    <tbody id="invDataTableRow">
    <?php $crow=0; $wo_option_session_id=0; if($summary){ ?>
    <?php foreach($summary as $sd){ $wo_option_session_id=$sd['wo_option_session_id']; ?>
    <tr class="draftItems">
    <td>
    <?php if($sd['summary_parent']==0){ ?>
    <a href="javascript:void(0);" title="Add Sub New Item" style="cursor: pointer;" data-toggle="modal" data-target="#addNewRefNo" data-afor="<?php echo ucwords($sd['order_summary_id']);?>" ><label class="badge badge-success" style="cursor: pointer;"><i class="fa fa-plus" ></i> <?php echo ucwords($sd['wo_ref_no']);?></label></a>
    <?php }else{ ?>
    <label class="badge badge-info" style="cursor: pointer;"><i class="fa fa-arrow-circle-right"></i></label>
    <?php } ?>
    </td>
    <td><?php echo ucwords($sd['wo_product_type_name']);?></td>
    <td><?php echo ucwords($sd['wo_collar_type_name']);?></td>
    <td><?php echo ucwords($sd['wo_sleeve_type_name']);?></td>
    <td><?php echo ucwords($sd['wo_fabric_type_name']);?></td>
    <td><?php echo ucwords($sd['wo_item_addons_names']);?></td>
    <td><?php echo ucwords($sd['wo_qty']);?> <?php //echo base_url('workorder/remove_summary_item/'.$sd['online_draft_id']);?></td>
    <td>
    
                        
    <a href="javascript:void(0);" title="Edit" style="cursor: pointer;" data-toggle="modal" data-target="#editRefNo" data-afor="<?php echo ucwords($sd['order_summary_id']);?>" ><label class="badge badge-warning" style="cursor: pointer;"><i class="fa fa-pencil" ></i></label></a>
    
    <a href="javascript:void(0);" onclick="deleteMe(<?php echo $sd['order_summary_id'];?>);" title="Delete" style="cursor: pointer;" ><label class="badge badge-danger" style="cursor: pointer;"><i class="fa fa-trash" ></i></label></a>
    
    </td>
    </tr>
    <?php $crow++;} ?>
    <?php } ?>
    </tbody>
    
<tfoot>
<tr>
<td  align="center" colspan="8">
<button type="button" class="btn btn-success" data-toggle="modal" data-target="#addNewRefNo" data-afor="0"  >
<i class="icon-plus-square"></i> <i class="fa fa-plus"></i> Add New Reference Number Row <?php //echo $crow;?>
</button><?php //echo $wo_option_session_id;?>
</td>
</tr>

</tfoot>
</table>
</div>
</div>
</div>


<input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">
</form>
<script language="javascript">
$(function() {


	$('#addNewRefNo').on('show.bs.modal', function (event) {
	var post_data = {
	'<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>',
	'order_id' : '<?php echo $woRow['order_id'];?>',
    'option_session_id' : '<?php echo $wo_option_session_id;?>',
	};
	var button = $(event.relatedTarget);
	var afor=button.data('afor');
	//var cid=button.data('cid');
	//alert(oid);
	var modal = $(this);
	//var dataString = "cuid="+cuid;
	$.ajax({  
	type: "POST",
	url: "<?= base_url("workorder/update_new_summary/");?>"+afor,  
	data: post_data,
	beforeSend: function(){
		modal.find('.modal-content').html('<i class="fa fa-cog fa-spin"></i>');},
		success: function(response){
		modal.find('.modal-content').html(response); 
		}
	}); 
	});
	
	$('#editRefNo').on('show.bs.modal', function (event) {
	var post_data = {
	'<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>',
	'cid' : '<?php echo $woRow['order_id'];?>',
	};
	var button = $(event.relatedTarget);
	var afor=button.data('afor');
	//var cid=button.data('cid');
	//alert("ggg");
	var modal = $(this);
	//var dataString = "cuid="+cuid;
	$.ajax({  
	type: "POST",
	url: "<?= base_url("workorder/edit_summary_item/");?>"+afor,  
	data: post_data,
	beforeSend: function(){
		modal.find('.modal-content').html('<i class="fa fa-cog fa-spin"></i>');},
		success: function(response){
		modal.find('.modal-content').html(response); 
		}
	}); 
	});
		   

});

function deleteMe(rid){
		//$('#addNewRefNo').modal('toggle');
	if(confirm("Are you sure you want to delete.?")){
		var items=0;
		$( ".draftItems" ).each(function( index ) {items++;});
		if(items==1){
			alert("Can't Remove..");
			return false;
		}
		//$('#contentDiv').html('<p style="text-align:center; width:100%;"><i class="fa fa-spin fa-refresh"></i><br/>Loading...</p>');
		var post_data = {
		'<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>',
		'order_id' : '<?php echo $woRow['order_id'];?>',
		};
		//$('#pnoresponse').html("<p style='text-align:center; color:#030;'>Checking... </p>");
		$.ajax({
		type: "POST",
		
		url: "<?= base_url("workorder/remove_summary_in_edit/");?>"+rid,
		data: post_data
		}).done(function(reply) {
			//alert("Yesss");
			$('#contentDiv').html(reply);
		});
	return false;
	}
}
</script>



<div class="modal fade " id="addNewRefNo" >
<div class="modal-dialog modal-lg 0" role="document">
<div class="modal-content"></div>
</div>
</div> 
<div class="modal fade " id="editRefNo" >
<div class="modal-dialog modal-lg 0" role="document">
<div class="modal-content"></div>
</div>
</div>
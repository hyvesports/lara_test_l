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
    <?php //print_r($summary);
	$wo_customer_name="";
	$wo_ref_numbers="";
	$wo_client_id="";
	$pinc=0;
	?>
    <?php $crow=0; if($summary){ ?>
    <?php foreach($summary as $sd){ ?>
    <tr class="draftItems">
    <td>
    <?php if($sd['summary_parent']==0){
		if($pinc==0){
			$wo_customer_name.=$sd['summary_client_name_only'].",".$sd['summary_client_mobile'];
			$wo_ref_numbers.=$sd['wo_ref_no'];
			$wo_client_id.=$sd['summary_client_id'];
		}else{
			$wo_customer_name.="|".$sd['summary_client_name_only'].",".$sd['summary_client_mobile'];
			$wo_ref_numbers.=",".$sd['wo_ref_no'];
			$wo_client_id.=",".$sd['summary_client_id'];
		}
		?>
    <a href="javascript:void(0);" title="Add Sub New Item" style="cursor: pointer;" data-toggle="modal" data-target="#addNewRefNo" data-afor="<?php echo ucwords($sd['order_summary_id']);?>" ><label class="badge badge-success" style="cursor: pointer;"><i class="fa fa-plus" ></i> <?php echo ucwords($sd['wo_ref_no']);?></label></a>
    <?php
		$pinc++;
	}else{ ?>
    <label class="badge badge-info" style="cursor: pointer;"><i class="fa fa-arrow-circle-right"></i></label>
    <?php } ?>
    </td>
    <td><?php echo ucwords($sd['wo_product_type_name']);?></td>
    <td><?php echo ucwords($sd['wo_collar_type_name']);?></td>
    <td><?php echo ucwords($sd['wo_sleeve_type_name']);?></td>
    <td><?php echo ucwords($sd['wo_fabric_type_name']);?></td>
    <td><?php echo ucwords($sd['wo_addon_name']);?></td>
    <td><?php echo ucwords($sd['wo_qty']);?> <?php //echo base_url('workorder/remove_summary_item/'.$sd['online_draft_id']);?></td>
    <td>
    
                        
    <a href="javascript:void(0);" title="Edit" style="cursor: pointer;" data-toggle="modal" data-target="#editRefNo" data-afor="<?php echo ucwords($sd['order_summary_id']);?>" ><label class="badge badge-warning" style="cursor: pointer;"><i class="fa fa-pencil" ></i></label></a>
    
    <a href="javascript:void(0);" onclick="deleteMe(<?php echo $sd['order_summary_id'];?>);" title="Delete" style="cursor: pointer;" ><label class="badge badge-danger" style="cursor: pointer;"><i class="fa fa-trash" ></i></label></a>
    
    </td>
    </tr>
    <?php $crow++;} ?>
    <?php }
	$dataUp = array(
				'wo_customer_name' => $wo_customer_name,
				'wo_ref_numbers' => $wo_ref_numbers,
				'wo_client_id' => $wo_client_id
			);
	$this->workorder_model->update_wo_data($dataUp,$wo_order_id);
	?>
    </tbody>
    
<tfoot>
<tr>
<td  align="center" colspan="8">
<button type="button" class="btn btn-success" data-toggle="modal" data-target="#addNewRefNo" data-afor="0"  >
<i class="icon-plus-square"></i> <i class="fa fa-plus"></i> Add New Reference Number Row <?php //echo $crow;?>
</button>
</td>
</tr>

</tfoot>
</table>
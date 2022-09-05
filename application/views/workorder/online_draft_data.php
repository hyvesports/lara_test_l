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
    <?php $crow=0; if($summary_drafts){ ?>
    <?php foreach($summary_drafts as $sd){ ?>
    <tr class="draftItems">
    <td>
    <?php if($sd['online_draft_parent_id']==0){ ?>
    
    <label class="badge badge-success" style="cursor: pointer;"><?php echo ucwords($sd['wo_ref_no']);?></label><br/><br/>
    <a href="javascript:void(0);" title="Add Sub New Item" style="cursor: pointer;" data-toggle="modal" data-target="#addNewRefNo" data-afor="<?php echo ucwords($sd['online_draft_id']);?>" ><label class="badge badge-info" style="cursor: pointer;"><i class="fa fa-plus" ></i> Add Sub Item</label></a>
    <?php }else{ ?>
    <label class="badge badge-info" style="cursor: pointer;"><i class="fa fa-arrow-circle-right"></i></label>
    <?php } ?>
    </td>
    <td><?php echo ucwords($sd['product_type_name']);?></td>
    <td><?php echo ucwords($sd['collar_type_name']);?></td>
    <td><?php echo ucwords($sd['sleeve_type_name']);?></td>
    <td><?php echo ucwords($sd['fabric_type_name']);?></td>
    <td><?php echo ucwords($sd['item_addons_names']);?></td>
    <td><?php echo ucwords($sd['wo_qty']);?></td>
    <td>
    
                        
    <a href="javascript:void(0);" title="Edit" style="cursor: pointer;" data-toggle="modal" data-target="#editRefNo" data-afor="<?php echo ucwords($sd['online_draft_id']);?>" ><label class="badge badge-warning" style="cursor: pointer;"><i class="fa fa-pencil" ></i></label></a>
    <a href="javascript:void(0);" onclick="deleteMe(<?php echo $sd['online_draft_id'];?>);" title="Delete" style="cursor: pointer;"><label class="badge badge-danger" style="cursor: pointer;"><i class="fa fa-trash" ></i></label></a>
    
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
</button>
</td>
</tr>

</tfoot>
</table>
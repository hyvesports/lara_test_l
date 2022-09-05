<?php
if($cAction=="drop"){
echo $msg='<div class="alert alert-warning alert-dismissible m-2" style="width:100%;">
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
			<h4><i class="icon fa fa-warning"></i> Deleted!</h4>Item deleted successfully</div>';
}

?>
<table class="table table-striped mb-0" width="100%">
        <thead>
        <tr class="item_header">
        <th width="13%"  class="">Product</th>
        <th width="13%"  class="">Collar</th>
        <th width="13%"  class="">Sleeve</th>
        <th width="13%"  class="">Fabric</th>
        <th width="13%"  class="">Add-ons</th>
        <th width="11%"  class="">Qty</th>
        <th width="11%"  class="">Rate</th>
        <th width="13%"  class="">Discount</th>
        <th width="0%"></th>
        </tr>
        </thead>
        <tbody id="invDataTableRow">
        <?php $count_item=0;if($summary) { $inc=0; $count_item=count($summary);?>
        <?php foreach($summary as $item) {?>
        <tr id="inv-row<?php echo $inc;?>"  class="draftItems">
        <td><?php echo $item['wo_product_type_name'];?></td>
        <td><?php echo $item['wo_collar_type_name'];?></td>
        <td><?php echo $item['wo_sleeve_type_name'];?></td>
        <td><?php echo $item['wo_fabric_type_name'];?></td>
        <td><?php echo $item['wo_item_addons_names'];?></td>
        <td><?php echo $item['wo_qty'];?></td>
        <td><?php echo $item['wo_rate'];?></td>
        <td><?php echo $item['wo_discount'];?></td>
        <td>
<a href="javascript:void(0);" title="Edit" style="cursor: pointer;" data-toggle="modal" data-target="#editRefNo" data-afor="<?php echo ucwords($item['order_summary_id']);?>" ><label class="badge badge-warning m-1" style="cursor: pointer;"><i class="fa fa-pencil" ></i></label></a>
 <a href="javascript:void(0);" onclick="deleteMe(<?php echo $item['order_summary_id'];?>);" title="Delete" style="cursor: pointer;" ><label class="badge badge-danger m-1" style="cursor: pointer;"><i class="fa fa-trash" ></i><?php //echo $sd['offline_draft_id'];?></label></a>
</td>
        </tr>
		<?php $inc++; } }?>
        </tbody>
        <tfoot>
<tr>
<td  align="center" colspan="8">
<button type="button" class="btn btn-success" data-toggle="modal" data-target="#addNewRefNo" data-afor="0"  >
<i class="icon-plus-square"></i> <i class="fa fa-plus"></i> Add Order Item
</button>
</td>
</tr>
</tfoot>
        </table>
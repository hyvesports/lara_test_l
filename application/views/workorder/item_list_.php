<table class="table table-striped mb-0" width="100%">

        <thead>
        
        <tr class="item_header">
        <th width="13%"  >Product</th>
        <th width="13%"  >Collar</th>
        <th width="13%"  >Sleeve</th>
        <th width="13%"  >Fabric</th>
        <th width="13%"  >Add-ons</th>
        <th width="11%"  >Qty</th>
        <th width="11%"  >Rate</th>
        <th width="13%"  >Discount</th>
        
        </tr>
        </thead>
        <tbody id="invDataTableRow">
        <?php if($summary) { $inc=0; $count_item=count($summary);?>
        <?php foreach($summary as $item) {?>
        <tr id="inv-row<?php echo $inc;?>">
        <td><?php echo $item['wo_product_type_name'];?>(<?php echo $item['wo_product_type_value'];?>)</td>
        <td><?php echo $item['wo_collar_type_name'];?>(<?php echo $item['wo_collar_type_value'];?>)</td>
        <td><?php echo $item['wo_sleeve_type_name'];?>(<?php echo $item['wo_sleeve_type_value'];?>)</td>
        <td><?php echo $item['wo_fabric_type_name'];?>(<?php echo $item['wo_fabric_type_value'];?>)</td>
        <td><?php echo $item['wo_item_addons_names'];?></td>
        <td><?php echo $item['wo_qty'];?></td>
        <td><?php echo $item['wo_rate'];?></td>
        <td><?php echo $item['wo_discount'];?></td>
        </tr>
		<?php $options = $this->workorder_model->get_all_summary_options_latest_offline($item['order_summary_id'],$item['wo_option_session_id']); ?>
		<tr class="child-<?php echo $item['order_summary_id'];?>">
        <td colspan="8"  >
        <?php if($options) { ?>
        <table class="table m-1">
        <thead>
        <tr>
        <th class="pt-1 pl-0">Name</th>
        <th class="pt-1">Number</th>
        <th class="pt-1">Size</th>
		<th class="pt-1">Fit Type</th>
        <th class="pt-1">Quantity</th>
		<th class="pt-1">Customer Info</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach($options as $opp){ ?>
        <tr>
        <td class="py-1 pl-0"><?php echo $opp['option_name'];?></td>
        <td><?php echo $opp['option_number'];?></td>
        <td><?php echo $opp['option_size_value'];?></td>
		<td><?php echo $opp['fit_type_name'];?></td>
        <td><label class="badge badge-success"><?php echo $opp['option_qty'];?></label></td>

		<td><?php echo $opp['customer_item_info'];?></td>
        </tr>
        <?php } ?>
        </tbody>
        </table>
		<?php } ?>
        <div class="alert alert-success" role="alert"><strong>Remark : </strong> <?php echo $item['wo_remark'];?></div>
        <div class="alert alert-info" role="alert">
        <strong>Front : </strong> <a href="<?php echo $item['wo_img_front'];?>" target="_blank"><?php echo $item['wo_img_front'];?></a><br/><br/>
        <strong>Back : </strong> <a href="<?php echo $item['wo_img_back'];?>" target="_blank"><?php echo $item['wo_img_back'];?></a>
        </div>
        </td>
        </tr>

		<?php $inc++; } }?>
        
        <?php if($row['wo_special_requirement']==""){ ?>
        <tr>
        <td colspan="8"><strong>Special requirement  :</strong> <?php echo $row['wo_special_requirement'];?></td>
        </tr>
        <?php } ?>
        </tbody>
        
        
        </table>
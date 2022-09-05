	<script>
    $(function() {
    $('tr.parent td div.badge-primary').on("click", function(){
    // alert("hii");
    var idOfParent = $(this).parents('tr').attr('id');
    //alert(idOfParent);
    $('tr.child-'+idOfParent).toggle('slow');
    });
    $('tr[class^=child-]').hide().children('td');
    });
    </script>
<table class="table table-responsive mb-0" width="100%">
   
        <tbody id="invDataTableRow">
        <?php 
//print_r($summary);

if($summary) { $inc=0; $count_item=count($summary);?>
        <?php foreach($summary as $item) {?>
        <?php if($item['summary_parent']==0){ 
		
		
		?>
        <tr>
        <td colspan="9">
            <div class="col-12 results" style="border-top-color:#003;">
            <div class="pt-4 border-bottom w-100" >
            <a class="d-block h6 mb-0" href="#"><?php echo $item['summary_client_name'];?> </a>
           <p class="page-description mt-1 w-100 text-muted">Ref: No: <?php echo $item['wo_ref_no'];?> </p>
            <p class="page-description mt-1 w-100 text-muted">Shipping Type : <?php echo $item['shipping_type_name'];?></p>
            <p class="page-description mt-1 w-100 text-muted">Shipping Address : <?php echo $item['wo_shipping_address'];?></p>
            </div>
            </div>
		</td>
        </tr>
        <?php }?>
        
        <?php if($item['summary_parent']==0){ ?>
        <tr class="item_header">
        <th width="13%"  class="text-left">Product</th>
        <th width="13%"  class="text-left">Collar</th>
        <th width="13%"  class="text-left">Sleeve</th>
        <th width="13%"  class="text-left">Fabric</th>
        <th width="13%"  class="text-left">Add-ons</th>
        <th width="11%"  class="text-center">Qty</th>
      
        
        </tr>
        <?php } ?>
        <?php $options = $this->workorder_model->get_all_order_options_latest($item['order_summary_id'],$item['wo_option_session_id']); ?>
        <tr style="color:#006;" valign="top" class="parent" id="<?php echo $item['order_summary_id'];?>">
       
        <td><?php echo $item['wo_product_type_name'];?>(<?php echo $item['wo_product_type_value'];?>)</td>
        <td><?php echo $item['wo_collar_type_name'];?>(<?php echo $item['wo_collar_type_value'];?>)</td>
        <td><?php echo $item['wo_sleeve_type_name'];?>(<?php echo $item['wo_sleeve_type_value'];?>)</td>
        <td><?php echo $item['wo_fabric_type_name'];?>(<?php echo $item['wo_fabric_type_value'];?>)</td>
        <td><?php if($item['wo_item_addons_names']!=""){ echo $item['wo_item_addons_names'];?> (<?php echo $item['wo_item_addons_mk_amt'];?>) <?php }else { echo 'Nil';}?></td>
        <td class="text-center">
		<div class="badge badge-success"><?php echo $item['wo_qty'];?></div>
        <div class="badge badge-primary" style="cursor:pointer;">More...</div></a>
        
        </td>
        </tr>
        <tr class="child-<?php echo $item['order_summary_id'];?>">
        <td colspan="8" style="border-top-color:#FFF; background:#ccc;"  >
        <?php if($options) { ?>
        <table class="table">
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
        </tbody>
        </table>
<?php if($row['wo_special_requirement']!=""){ ?>
<div class="alert alert-success" role="alert">
  <h4 class="alert-heading">Special Requirement!</h4>
  <p><?php echo $row['wo_special_requirement'];?></p>

</div>
<?php } ?>
<div class="table-responsive">
<table class="table w-100" width="100%" id="listing">
<thead>
<tr>
<th width="80%" class="pt-1 pl-0">Product</th>
<th width="5%" class="pt-1">Qty</th>
<th width="5%" class="pt-1 ">Rate</th>
<th width="10%" class="pt-1">Discount</th>
</tr>
</thead>
<tbody>
<?php if($summary) { $inc=0; $count_item=count($summary);?>
<?php foreach($summary as $item) { $inc++;?>
<tr>
    <td class="py-1 pl-0" valign="top" width="70%">
    <div class="d-flex align-items-center">
    <div class=" mb-3"><strong class=" mb-3"><?php echo $inc;?>.<?php echo ucwords($item['wo_product_type_name']);?></strong><br/>
<p></p>
    <?php if(isset($item['online_ref_number'])){ if($item['online_ref_number']!=""){?>
    <p class="mb-2 mt-2">Ref: No: <?php echo ucwords($item['online_ref_number']);?></p>
    <?php } }?>
    <span class="align-items-center mt-1">
    <span class="badge badge-primary"><?php echo ucwords($item['wo_collar_type_name']);?></span>
    <span class="badge badge-primary"><?php echo ucwords($item['wo_sleeve_type_name']);?></span>
    <span class="badge badge-primary"><?php echo ucwords($item['wo_fabric_type_name']);?></span>
    <?php if($item['wo_item_addons_names']!=""){ ?>
    <span class="badge badge-primary"><?php echo ucwords($item['wo_item_addons_names']);?></span>
    <?php } ?>
    <br />
    <?php if($item['wo_img_front']!=""){?>
    <span class="btn btn-xs   mr-2 mt-1">
    <div id="lightgallery2" class="row lightGallery"><a href="<?php echo $item['wo_img_front'];?>" target="_blank"><img src="<?php echo $item['wo_img_front'];?>" title="Image Front"  style="margin-top:15px; padding:8px; border:1px solid #ccc;width:100px;height:100px;" ><br/>Front</a></div>
    </span>
    <?php } ?>
    <?php if($item['wo_img_back']!=""){?>
    <span class="btn btn-xs   mr-2 mt-1">
    <div id="lightgallery2" class="row lightGallery"><a href="<?php echo $item['wo_img_back'];?>" target="_blank"><img src="<?php echo $item['wo_img_back'];?>" title="Image Back"  style="margin-top:15px; padding:8px; border:1px solid #ccc;width:100px;height:100px;"  ><br/>Back</a></div>
    </span>
    <?php } ?>
     
    
    </span>
    </div>
    </div>

	<?php $options = $this->workorder_model->get_all_summary_options_latest_offline($item['order_summary_id'],$item['wo_option_session_id']); ?>
		<?php if($options) { ?>
        <table class="table table-bordered table-hover w-100">
        <thead>
        <tr>
        <th >Name</th>
        <th >Number</th>
        <th >Size</th>
		<th >Fit Type</th>
        <th >Quantity</th>
		<th >Customer Info</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach($options as $opp){ ?>
        <tr>
        <td class="py-1 pl-0"><?php echo $opp['option_name'];?></td>
        <td><?php echo $opp['option_number'];?></td>
        <td><?php echo $opp['option_size_value'];?></td>
		<td><?php echo $opp['fit_type_name'];?></td>
        <td><label class="badge badge-outline-primary"><?php echo $opp['option_qty'];?></label></td>

		<td><?php echo $opp['customer_item_info'];?></td>
        </tr>
        <?php } ?>
        </tbody>
        </table>
		<?php } ?>

		<?php $qcImages= $this->common_model->get_qc_uploaded_images($row['order_id'],$item['order_summary_id']); ?>
<div class="row lightGallery">
		<?php
		//$images = glob("uploads/finalqc/*.*");  
		if($qcImages){
			foreach($qcImages as $image)  
			{  
echo '
<a href="'.base_url()."uploads/finalqc/".$image['image_name'].'" class="m-1  ">
<img src="'.base_url()."uploads/finalqc/".$image['image_name'].'"  style="margin-top:15px; padding:8px; border:1px solid #ccc;width:100px;height:100px;" class="img-lg rounded" />
</a>
';  
			} 
		} 
		//echo $output; 
		?>
</div>
    </td>
	<td valign="top"><label class="badge badge-outline-success"><?php echo $item['wo_qty'];?></label></td>
	<td valign="top"><?php echo $item['wo_rate'];?></td>
	<td valign="top"><?php echo $item['wo_discount'];?></td>

</tr>

<?php }  ?>
<?php } ?>
</tbody>
</table>
</div>
<link rel="stylesheet" href="<?php echo base_url();?>public/vendors/lightgallery/css/lightgallery.css">
<script src="<?php echo base_url() ?>public/vendors/lightgallery/js/lightgallery-all.min.js"></script>
<script>
(function($) {
'use strict';
$(".lightGallery").lightGallery();
})(jQuery);
(function($) {
	'use strict';
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
})(jQuery);
</script>
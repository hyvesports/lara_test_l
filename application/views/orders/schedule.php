<div class="content-wrapper">

<div class="row profile-page">

    <div class="col-12">

    <div class="card">

    <div class="card-body">

    <h4 class="card-title"><?php echo $title_head;?><span style="text-align:right; float:right;"><a class="btn btn-primary " href="<?php echo base_url('orders/index');?>">LIST</a></span>

    </h4>

    <div class="profile-body" style="padding-top: 0px;">

    <ul class="nav tab-switch" role="tablist">

    

    <li class="nav-item">

    <a class="nav-link active" id="user-profile-info-tab" data-toggle="pill" href="#schedule" role="tab" aria-controls="schedule" aria-selected="true">Schedule Details</a>

    </li>

    

    

    <li class="nav-item">

    <a class="nav-link" id="user-profile-info-tab" data-toggle="pill" href="#user-profile-info" role="tab" aria-controls="user-profile-info" aria-selected="true">Order Details</a>

    </li>

    

    

    

    <li class="nav-item">

    <a class="nav-link" id="user-profile-activity-tab" data-toggle="pill" href="#user-profile-activity" role="tab" aria-controls="user-profile-activity" aria-selected="false">Summary</a>

    </li>

    

    <li class="nav-item">

    <a class="nav-link" id="user-profile-activity-tab" data-toggle="pill" href="#user-profile-doc" role="tab" aria-controls="user-profile-doc" aria-selected="false">Documents</a>

    </li>

    </ul>

    <div class="row">

    <div class="col-md-12">

    <div class="tab-content tab-body" id="profile-log-switch">

    	<?php

		

		if($row['schedule_id']==""){

			include('schedule.tab.php');

		}else{

			include('order_schedule.tab.php');

		}

		?>

        

        <div class="tab-pane  fade" id="user-profile-doc" role="tabpanel" aria-labelledby="user-profile-doc-tab">
        <p class="card-description" style="border-bottom: 1px solid #f2f2f2;"><strong>Images </strong></p> <?php //echo base_url() ?>
<link rel="stylesheet" href="<?php echo base_url();?>public/vendors/lightgallery/css/lightgallery.css">
        <?php if($images) {?>
        <div id="lightgallery" class="row lightGallery">
        <?php foreach($images as $imgDoc) { $pathImg= base_url().'/uploads/orderform/'.$imgDoc['document_name'];?>
        <a href="<?php echo $pathImg;?>" class="image-tile"><img src="<?php echo $pathImg;?>" alt="<?php echo $imgDoc['document_name'];?>"></a>
        <?php } ?>
        </div>
        <?php } ?>
        <p class="card-description" ><strong>Attachments </strong></p>
        <?php if($Attachment2) {?>
        <div id="lightgallery2" class="row lightGallery">
        <?php foreach($Attachment as $AttachmentDco) { $pathAttc= base_url().'/uploads/orderform/'.$AttachmentDco['document_name'];?>
        <a href="<?php echo $pathAttc;?>" class="image-tile"><img src="<?php echo $pathAttc;?>" alt="<?php echo $AttachmentDco['document_name'];?>"></a>
        <?php } ?>
        </div>
        <?php } ?>
        <script src="<?php echo base_url() ?>public/vendors/lightgallery/js/lightgallery-all.min.js"></script>
		<script>
        (function($) {
        'use strict';
        $("#lightgallery,#lightgallery2").lightGallery();
        })(jQuery);
        </script>
		<!----------------------------------------------- End ------------------------------------------------------------>
    	<?php if($Attachment){ ?>
        <div class="email-wrapper wrapper">
        <div class="row align-items-stretch">
        <div class="mail-view d-none d-md-block col-md-12 col-lg-12 bg-white">
        <div class="message-body">
        <div class="attachments-sections">
        <ul>
        	<?php foreach($Attachment as $attachment){
				$path_attachment= base_url().'uploads/orderform/'.$attachment['document_name'];
				if(file_exists('uploads/orderform/'.$attachment['document_name'])){
				?>
            <li>
            <div class="thumb"><i class="icon-paper-clip"></i></div>
            <div class="details">
            <p class="file-name"><?php echo $attachment['document_name'];?></p>
            <div class="buttons">
            <a href="<?php echo $path_attachment;?>" class="view" target="_blank">View</a>
            <a href="<?php echo $path_attachment;?>" class="download" download>Download</a>
            </div>
            </div>
            </li>
            <?php } } ?>
        </ul>
        </div>
        </div>
        </div>
        </div>
        </div>
        <?php } ?>

        </div>

    

    	<?php //print_r($row);?>

        <div class="tab-pane fade pr-3" id="user-profile-info" role="tabpanel" aria-labelledby="user-profile-info-tab">

        <table class="table table-borderless w-100 mt-4">

        <tr>

        <td><strong>Order & No :</strong> <?php echo $row['wo_type_name'];?> & <?php echo $row['orderform_number'];?></td>

        <td><strong>Lead :</strong> <?php echo $row['lead_code'];?></td>

        </tr>
<tr>
<td colspan="2"><strong>Order Info </strong>:<?php echo $row['wo_product_info'];?></td>
		</tr>
        <tr>

        <td><strong>Order Nature :</strong> <?php echo $row['order_nature_name'];?></td>

        <td><strong>Dispatch Date :</strong> <?php 

		$wo_dispatch_date = date("d/m/Y", strtotime($row['wo_dispatch_date']));

		echo $wo_dispatch_date;?></td>

        </tr>

        

        <?php if($row['orderform_type_id']=="2"){ ?>

        <tr>

        <td colspan="2"><strong>Ref: Order Number  :</strong> <?php echo $row['wo_product_info'];?></td>

        </tr>

        <?php } ?>

        

        <tr>

        <td><strong>Priority  :</strong> <?php echo $row['priority_name'];?></td>

        <td><strong>Order Timestamp  :</strong> <?php echo $row['wo_date_time'];?></td>

        </tr>

        

        </table>

        <br />

        <p class="card-description" style="border-bottom: 1px solid #f2f2f2;"><strong>Owner Details </strong></p>

        <table class="table table-borderless w-100 mt-4">

        <tr>

        <td><strong>Name :</strong> <?php echo $row['customer_code'];?> - <?php echo $row['customer_name'];?></td>

        <td><strong>Contact Email :</strong> <?php echo $row['customer_email'];?></td>

        </tr>

       

        

         <tr>

         <td><strong>Bllling Address :</strong><br /><br /><?php echo nl2br($row['billing_address']);?></td>

        <td><strong>Shipping Address :</strong> <br /><br /><address><?php echo nl2br($row['shipping_address']);?></address></td>

        

        </tr>

        

        </table>

        <br />

        <p class="card-description" style="border-bottom: 1px solid #f2f2f2;"><strong>Customer Details </strong></p>

        <table class="table table-borderless w-100 mt-4">

        <tr>

        <td><strong>Code :</strong> <?php echo $row['staff_code'];?></td>

        <td><strong>Name :</strong> <?php echo $row['staff_name'];?></td>

        </tr>

        </table>

        </div>

        


        

        

    <div class="tab-pane  fade" id="user-profile-activity" role="tabpanel" aria-labelledby="user-profile-activity-tab">

<?php if($row['wo_special_requirement']!=""){ ?>
<div class="alert alert-success" role="alert">
  <h4 class="alert-heading">Special Requirement!</h4>
  <p><?php echo $row['wo_special_requirement'];?></p>

</div>
<?php } ?>


    <table class="table table-striped mb-0" width="100%">

        <thead>



        <tr class="item_header">

        <th width="13%"  class="text-center">Product</th>

        <th width="13%"  class="text-center">Collar</th>

        <th width="13%"  class="text-center">Sleeve</th>

        <th width="13%"  class="text-center">Fabric</th>

        <th width="13%"  class="text-center">Add-ons</th>

        <th width="11%"  class="text-center">Qty</th>

        <th width="11%"  class="text-center">Rate</th>

        <th width="13%"  class="text-center">Discount</th>

        

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

        

         <br />

        <p class="card-description" style="border-bottom: 1px solid #f2f2f2;"><strong>Cost calculations </strong></p>

        <table class="table table-borderless w-100 mt-4">

        <tr>

        <td><strong>Shipping Cost :</strong> <?php echo $row['wo_shipping_cost'];?></td>

        <td><strong>Additional Cost  :</strong> <?php echo $row['wo_additional_cost'];?></td>

        </tr>

        <tr>

        <td colspan="2"><strong>Additional Cost Description :</strong> <?php echo $row['wo_additional_cost_desc'];?></td>

        </tr>

        

        <tr>

        <td><strong>Tax  :</strong> <?php echo $row['wo_tax_name'];?></td>

        <td><strong>Adjustment :</strong> <?php echo $row['wo_adjustment'];?></td>

        </tr>

        

        <tr>

        <td><strong>Gross Cost  :</strong> <?php echo $row['wo_gross_cost'];?></td>

        <td><strong>Advance :</strong> <?php echo $row['wo_advance'];?></td>

        </tr>

        

        <tr>

        <td><strong>Balance  :</strong> <?php echo $row['wo_balance'];?></td>

        

        </tr>

        

        </table>



    </div>

    </div>

    </div>

    

    </div>

    </div>

    </div>

    </div>

    </div>

</div>





</div>

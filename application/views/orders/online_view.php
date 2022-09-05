<div class="content-wrapper">
<div class="row profile-page">
    <div class="col-12">
    <div class="card">
    <div class="card-body">
    <h4 class="card-title">ONLINE ORDERS<span style="text-align:right; float:right;"><a class="btn btn-primary " href="<?php echo base_url('orders/online');?>">LIST</a></span>
    </h4>
    <div class="profile-body" style="padding-top: 0px;">
    <ul class="nav tab-switch" role="tablist">
    <li class="nav-item">
    <a class="nav-link active" id="user-profile-info-tab" data-toggle="pill" href="#user-profile-info" role="tab" aria-controls="user-profile-info" aria-selected="true">Order Details</a>
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
    <div class="tab-pane  fade" id="user-profile-doc" role="tabpanel" aria-labelledby="user-profile-doc-tab">
    <!----------------------------------------------- Start ------------------------------------------------------------>
        <p class="card-description" style="border-bottom: 1px solid #f2f2f2;"><strong>Images </strong></p> 
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
        <script src="<?php echo base_url() ?>public/vendors/lightgallery/js/lightgallery-all.min.js"></script>
		<script>
        (function($) {
        'use strict';
        $("#lightgallery,#lightgallery2").lightGallery();
        })(jQuery);
        </script>
		<!----------------------------------------------- End ------------------------------------------------------------>
    </div>
    	<?php //print_r($row);?>
        <div class="tab-pane fade show active  pr-3" id="user-profile-info" role="tabpanel" aria-labelledby="user-profile-info-tab">
        <table class="table table-borderless w-100 mt-4">
        <tr>
        <td><strong>Order & No :</strong> <?php echo $row['wo_type_name'];?> & <?php echo $row['orderform_number'];?></td>
        <td></td>
        </tr>
        <tr>
        <td><strong>Order Nature :</strong> <?php echo $row['order_nature_name'];?></td>
        <td><strong>Dispatch Date :</strong> <?php 
		$wo_dispatch_date = date("d/m/Y", strtotime($row['wo_dispatch_date']));
		echo $wo_dispatch_date;?></td>
        </tr>
        <?php if($row['orderform_type_id']=="2"){ ?>
        <tr>
        <td colspan="2"><strong>Ref: Order Number  :</strong> <?php echo $row['wo_ref_numbers'];?></td>
        </tr>
        <tr>
        <td colspan="2"><strong>Product Information  :</strong> <?php echo $row['wo_product_info'];?></td>
        </tr>
        <?php } ?>
        <tr>
        <td><strong>Priority  :</strong> <?php echo $row['priority_name'];?></td>
        <td><strong>Order Timestamp  :</strong> <?php echo $row['wo_date_time'];?></td>
        </tr>
        </table>
<?php //echo print_r($row);?>
        <br />
        </div>
    <div class="tab-pane  fade" id="user-profile-activity" role="tabpanel" aria-labelledby="user-profile-activity-tab">
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
        <?php if($summary) { $inc=0; $count_item=count($summary);?>
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
        <td><?php if($item['wo_addon_value']!=""){echo $item['wo_addon_name'];?>(<?php echo $item['wo_addon_value'];?>) <?php }else{ echo 'Nil'; } ?></td>
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
        <th class="pt-1">Quantity</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach($options as $opp){ ?>
        <tr>
        <td class="py-1 pl-0"><?php echo $opp['option_name'];?></td>
        <td><?php echo $opp['option_number'];?></td>
        <td><?php echo $opp['option_size_value'];?></td>
        <td><label class="badge badge-success"><?php echo $opp['option_qty'];?></label></td>
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
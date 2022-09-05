<div class="content-wrapper">
<div class="row profile-page">
    <div class="col-12">
    <div class="card">
    <div class="card-body">
    <h4 class="card-title"><?php echo $title_head;?><span style="text-align:right; float:right;"><a class="btn btn-primary " href="<?php echo base_url('workorder/wo_online');?>">LIST</a>

</span>
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
<li class="nav-item"><a class="nav-link" id="user-profile-disp-tab" data-toggle="pill" href="#user-profile-disp" role="tab" aria-controls="user-profile-disp" aria-selected="false">Dispatch</a>
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
        <a href="<?php echo $pathImg;?>" class="m-1"><img src="<?php echo $pathImg;?>" alt="<?php echo $imgDoc['document_name'];?>" style="margin-top:15px; padding:8px; border:1px solid #ccc;width:200px;height:200px;"></a>
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
        <br />
        </div>
        
        
        
        
    <div class="tab-pane  fade" id="user-profile-activity" role="tabpanel" aria-labelledby="user-profile-activity-tab">
	<?php include("online_items.php");?>
   
    </div>
<div class="tab-pane fade" id="user-profile-disp" role="tabpanel" aria-labelledby="user-profile-disp-tab">
	<?php include('tracking.php');?>
	<br />
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
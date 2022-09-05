<div class="content-wrapper">

<div class="row profile-page">

<div class="col-12">

<div class="card">

<div class="card-body">



<h4 class="card-title"><?php echo $title_head;?>

<span style="text-align:right; float:right;"><a class="btn btn-primary " href="<?php echo base_url('schedule/index');?>">List</a></span> 

</h4>

<p class="card-description" style="border-bottom: 1px solid #f2f2f2;"><strong>Scheduled Details</strong></p>



<div class="profile-body pt-0" >



<div class="row">

<div class="col-md-12">

<div class="tab-content tab-body" id="profile-log-switch">

<div class="tab-pane fade show active pr-3" id="user-profile-info" role="tabpanel" aria-labelledby="user-profile-info-tab">

<table class="table table-borderless w-100 mt-2">

<tbody><tr>

<td><strong>Production Start Date :</strong> <?php echo date("d-m-Y", strtotime($row['schedule_date'])); ?></td>
 <?php $dispatchRow=$this->common_model->get_order_final_dispatch_date($row['schedule_id']); ?>
<td><strong>Dispatch Date :</strong> <?php echo date("d-m-Y", strtotime($dispatchRow['department_schedule_date'])); ?></td>
</tr>

<tr>

<td><strong>Scheduled Date Time :</strong> <?php echo date("d-m-Y H:i:s", strtotime($row['schedule_time_stamp'])); ?></td>

<td><strong>Scheduled By :</strong> <?php //echo $row['lead_id'];?>
<?php if($row['lead_id']==0){ echo 'Admin'; }else{ echo $row['sales_handler']; } ?>
</td>

</tr>

<tr>

<td><strong>Order Number :</strong> <?php echo $row['orderform_number'];?></td>

<td><strong>Unit :</strong> <?php echo $row['production_unit_name'];?></td>

</tr>

 <!-- //////////////////////////////////////////////////-->
        <?php if($row['wo_product_info']!=""){ ?>
        <tr>
        <td colspan="2"><strong>Product Info:</strong> <?php echo $row['wo_product_info'];?></td>
        </tr>
        <?php } ?>
        <?php if($row['wo_special_requirement']!=""){ ?>
        <tr>
        <td colspan="2"><strong>Special Requirement :</strong> <?php echo $row['wo_special_requirement'];?></td>
        </tr>
        <?php } ?>
        <!-- //////////////////////////////////////////////////-->

</tbody>

</table>



<div class="row">

<?php $array1 = json_decode($row['sh_order_json'],true);?>



<div class="col-md-6 mt-5">

<?php if($array1) { //print_r($array1); ?>

<p class="card-description text-warning" style="border-bottom: 1px solid #f2f2f2;"><strong>Order Details</strong></p>

<div class="new-accounts">

<ul class="chats">

<?php foreach($array1 as $key1 => $value1){ ?>

	<?php if($value1['item_unit_qty_input']!=0){?>

    <li class="chat-persons">

    <a href="#">

    <div class="user w-100">

    <p class="u-name"><?php echo ucwords($value1['product_type']);?></p>

    <p class="u-designation">Production Quantity : <?php echo ucwords($value1['item_unit_qty_input']);?></p>

    <?php if($value1['remark']!=""){?>

    <p class="u-designation">Remark : <?php echo ucwords($value1['remark']);?></p>

    <?php } ?>

    <span class="d-flex align-items-center mt-1">

    <span class="btn btn-xs btn-rounded btn-outline-primary mr-2"><?php echo ucwords($value1['collar_type']);?></span>

    <span class="btn btn-xs btn-rounded btn-outline-primary mr-2"><?php echo ucwords($value1['sleeve_type']);?></span>

    <span class="btn btn-xs btn-rounded btn-outline-primary mr-2"><?php echo ucwords($value1['fabric_type']);?></span>

    <?php if($value1['addon_name']!=""){ ?>
    <span class="btn btn-xs btn-rounded btn-outline-primary mr-2"><?php echo ucwords($value1['addon_name']);?></span>
    <?php }?>

    </span>

    </div>

    </a>
    <link rel="stylesheet" href="<?php echo base_url();?>public/vendors/lightgallery/css/lightgallery.css">
    <?php if($value1['img_front']!=""){?>
    <span class="btn btn-xs btn-outline-primary mr-2 mt-1">
    <div id="lightgallery2" class="row lightGallery"><a href="<?php echo $value1['img_front'];?>" target="_blank"><img src="<?php echo $value1['img_front'];?>" title="Image Front" width="100" height="100" ><br />Front</a></div>
    </span>
    <?php } ?>
    <?php if($value1['img_back']!=""){?>
    <span class="btn btn-xs btn-outline-primary mr-2 mt-1">
    <div id="lightgallery2" class="row lightGallery"><a href="<?php echo $value1['img_back'];?>" target="_blank"><img src="<?php echo $value1['img_back'];?>" title="Image Back" width="100" height="100"  ><br/>Back</a></div>
    </span>
    <?php } ?>

    <script src="<?php echo base_url() ?>public/vendors/lightgallery/js/lightgallery-all.min.js"></script>
		<script>
        (function($) {
        'use strict';
        $(".lightGallery").lightGallery();
        })(jQuery);
        </script>

    

    

    

    </li>

    <?php }?>

<?php } ?>

</ul>

</div>

<?php } ?>

<?php

$images= $this->workorder_model->get_wo_documents($row['order_id'],'image');

$Attachment= $this->workorder_model->get_wo_documents($row['order_id'],'document');

?>

<div class="card card-inverse-secondary mb-5">

<div class="card-body">

<button class="btn btn-success">Images</button>



<?php if($images) {?>

<ol>

	<?php foreach($images as $imgDoc) { $pathImg= base_url().'/uploads/orderform/'.$imgDoc['document_name'];?>

	<li id=""><?php echo $imgDoc['document_name'];?> <em><a href="<?php echo $pathImg;?>" style="color:#030;"  target="_blank"> <i class="fa fa-download"></i> Download</a></em></li>

    <?php } ?>

</ol>

<?php } ?>

<br />

<button class="btn btn-success mt-1">Attachments</button>

<?php if($Attachment) {?>

<ol>

	<?php foreach($Attachment as $AttachmentDco) { $pathAttc= base_url().'/uploads/orderform/'.$AttachmentDco['document_name'];?>

	<li><?php echo $AttachmentDco['document_name'];?> <em><a href="<?php echo $pathAttc;?>" style="color:#030;"  target="_blank"> <i class="fa fa-download"></i> Download</a></em></li>

    <?php } ?>

</ol>

<?php } ?>



</div>

</div>



</div>



<?php $dates=$this->schedule_model->get_schedule_department_rows_by_schedule_id($row['schedule_id']); ?>

<div class="col-6 mt-5">

<p class="card-description text-warning" style="border-bottom: 1px solid #f2f2f2;"><strong>Scheduling Details</strong></p>

<h5 class="mb-2">Day</h5>

<div class="stage-wrapper pl-4">

	<?php //print_r($dates);

	date_default_timezone_set('Asia/Kolkata'); # add your city to set local time zone

	$now = date('Y-m-d');

	?>

    <?php if($dates){$i=1;?>

    <?php foreach($dates as $date){

		if($date['department_ids']){

		$department1=$this->schedule_model->get_production_department_names($date['department_ids']);

		$active="";

		if($now==$date['department_schedule_date']){

			$active="active";

		}

		?>

    <div class="stages border-left pl-5 pb-4 active">

    <div class="btn btn-icons btn-rounded stage-badge btn-inverse-success <?php echo $active;?>"><?php echo $i;?></div>

    <div class="d-flex align-items-center mb-2 justify-content-between">

    <h5 class="mb-0"><?php echo $department1['DNAME'];?>

    <?php if($date['is_re_scheduled']==-1){ ?>

    <label class="badge badge-danger">Rejected</label>

    <?php } ?>

    

    <?php if($date['is_re_scheduled']>0){ ?>

    <label class="badge badge-success">ReScheduled</label>

    <?php } ?>

    

    </h5>

    <small class="text-muted"><?php echo date("d-m-Y", strtotime($date['department_schedule_date'])); ?></small>

    

    

    

    </div>

    



    	

	<?php if($date['scheduled_order_info']!=""){} ?>

    

    

    </div>

    <?php $i++;}} ?>

    <?php } ?>

    

    

    

    <div class="stages pl-5 pb-4">

    <div class="btn btn-icons btn-rounded stage-badge btn-inverse-primary">

    <i class="icon-checkbox-marked-circle-outline"></i>

    </div>

    <div class="d-flex align-items-center mb-2 justify-content-between">

    <h5 class="mb-0">Scheduling Completed</h5>

    

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

</div>

</div>

</div>

</div>



</div>


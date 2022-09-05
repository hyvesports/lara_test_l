<div class="content-wrapper">

<div class="row profile-page">

    <div class="col-12">

    <div class="card">

    <div class="card-body">

    <h4 class="card-title"><?php echo $title_head;?>

    <span style="text-align:right; float:right;"><a class="btn btn-primary " href="<?php echo base_url('myaccount/myorders');?>">List</a></span> 

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

        <?php 
		if($schedule_data['is_re_scheduled']>0){
			$re='<span class="badge badge-outline-info w-100 mb-1" ><strong>Re Scheduled</strong></span><br/>';
			$dispatchRow=$this->common_model->get_order_final_dispatch_date($schedule_data['is_re_scheduled']);
		}else{
			$dispatchRow=$this->common_model->get_order_final_dispatch_date($schedule_data['schedule_id']);
		}
		?>

        <td><strong>Dispatch Date :</strong> <?php echo date("d-m-Y", strtotime($dispatchRow['department_schedule_date'])); ?></td>

        </tr>

        <tr>

        <td><strong>Order Scheduled Date Time :</strong> <?php echo date("d-m-Y H:i:s", strtotime($row['schedule_time_stamp'])); ?></td>

        <td><strong>Scheduled By :</strong> <?php echo $row['log_full_name'];?></td>

        </tr>
        <tr>
        <td><strong>Order Number :</strong> <?php echo $row['orderform_number'];?></td>
        <td><strong>Unit :</strong> <?php echo $row['production_unit_name'];?></td>
        </tr>

        <?php
        $did=$staffRow['department_id'];
        $sql="SELECT 
        sh_schedule_departments.*
        FROM
            sh_schedule_departments
        WHERE
        sh_schedule_departments.schedule_department_id='".$schedule_data['schedule_department_id']."'  AND FIND_IN_SET($did,sh_schedule_departments.department_ids) ";
        //echo $sql;
        $query = $this->db->query($sql);					 
        $rsRow=$query->row_array();
        ?>

        <tr>
        <td><strong>My Scheduled Date :</strong> <?php echo date("d-m-Y", strtotime($rsRow['department_schedule_date'])); ?></td>
        <td><strong>Sales Handler :</strong> <?php if($row['lead_id']==0){ echo 'Admin'; }else{ echo $row['sales_handler']; } ?></td>
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

        </div>

        </div>

        </div>

        </div>

        </div>
		
        <?php
		$images= $this->common_model->get_wo_documents($row['order_id'],'image');
		$attachments= $this->common_model->get_wo_documents($row['order_id'],'document');
		?>
        <!----------------------------------------------- Start ------------------------------------------------------------>
        
        <link rel="stylesheet" href="<?php echo base_url();?>public/vendors/lightgallery/css/lightgallery.css">
        <?php if($images) {?>
        <p class="card-description" style="border-bottom: 1px solid #f2f2f2;"><strong>Images </strong></p> 
        <div id="lightgallery" class="row lightGallery">
        <?php foreach($images as $imgDoc) { $pathImg= base_url().'/uploads/orderform/'.$imgDoc['document_name'];?>
        <a href="<?php echo $pathImg;?>" class="image-tile"><img src="<?php echo $pathImg;?>" alt="<?php echo $imgDoc['document_name'];?>"></a>
        <?php } ?>
        </div>
        <?php } ?>
        
        <?php if($Attachment) {?>
        <p class="card-description" style="border-bottom: 1px solid #f2f2f2;"><strong>Attachments </strong></p>
        <div id="lightgallery2" class="row lightGallery">
        <?php foreach($Attachment as $AttachmentDco) { $pathAttc= base_url().'/uploads/orderform/'.$AttachmentDco['document_name'];?>
        <a href="<?php echo $pathAttc;?>" class="image-tile"><img src="<?php echo $pathAttc;?>" alt="<?php echo $AttachmentDco['document_name'];?>"></a>
        <?php } ?>
        </div>
        <?php } ?>
        
		<!----------------------------------------------- End ------------------------------------------------------------>
        

        <?php //$attachments=$this->common_model->get_order_attachments($row['order_id']); ?>
        <?php if($attachments){ ?>
        <div class="email-wrapper wrapper">
        <div class="row align-items-stretch">
        <div class="mail-view d-none d-md-block col-md-12 col-lg-12 bg-white">
        <div class="message-body">
        <div class="attachments-sections">
        <ul>
        	<?php foreach($attachments as $attachment){
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
    </div>
    </div>
	<?php //print_r($schedule_data);?> 
	<?php $array1 = json_decode($schedule_data['scheduled_order_info'],true);?>
    <?php $i=0;if($array1) { //print_r($array1); ?>
    <?php foreach($array1 as $key1 => $value1){
		//if($request_row['summary_item_id']==$value1['summary_id']){
		?>
    <?php if($value1['item_unit_qty_input']!=0){ $i++?>
    <div class="col-md-4 grid-margin stretch-card mt-4">
    <div class="card">
    <div class="card-body">
    <div class="d-flex align-items-center">
    <div class="ml-0">
    <h4><?php echo $i;?>.<?php echo ucwords($value1['product_type']);?></h4>
    <?php if(isset($value1['online_ref_number'])){ if($value1['online_ref_number']!=""){?>
    <p class="mb-1">
    <span class="badge" style="background-color:#ffe74c;">Ref: No: <?php echo ucwords($value1['online_ref_number']);?></span>
    </p>
	<?php } }?>

    <p class="mb-2">
    <span class="badge" style="background-color:#ffe74c;">Quantity: <?php echo ucwords($value1['item_unit_qty_input']);?></span>
    </p>

    <?php if($value1['remark']!=""){?><p class="text-muted mb-1">Remark : <?php echo ucwords($value1['remark']);?></p><?php } ?>
    <span class="align-items-center mt-1">
    <span class="btn btn-xs btn-rounded btn-outline-primary mr-2"><?php echo ucwords($value1['collar_type']);?></span>
    <span class="btn btn-xs btn-rounded btn-outline-primary mr-2"><?php echo ucwords($value1['sleeve_type']);?></span>
    <span class="btn btn-xs btn-rounded btn-outline-primary mr-2"><?php echo ucwords($value1['fabric_type']);?></span>
    
    <?php if($value1['addon_name']!=""){ ?>
    <span class="btn btn-xs btn-rounded btn-outline-primary mr-2"><?php echo ucwords($value1['addon_name']);?></span>
    <?php }?>
    
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
    </span>

    </div>
    </div>

    <div class="border-top pt-3 mt-3">
    <div class="row">
    <div class="col-12">
   <?php $options=$this->myaccount_model->get_order_options($row['order_id'],$value1['summary_id']); ?>
    <?php if($options){ $inc=0;?>
    <div class="table-responsive w-100 mt-1">
    <table class="table">
    <thead>
    <tr class="bg-light">
    <th>Name</th>
    <th class="text-right">Number</th>
    <th class="text-right">Size</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach($options as $OP){ $inc++;?>
    <tr class="text-right">
    <td class="text-left"><?php if($OP['option_name']!=""){ echo $OP['option_name']; }else{ echo 'Nil'; }?></td>
    <td><?php if($OP['option_number']!=""){ echo $OP['option_number']; }else{ echo 'Nil'; }?></td>
    <td><?php echo $OP['option_size_value'];?></td>
    </tr>
    <?php } ?>    
    </tbody>
    </table>
    </div>
    <?php } ?>
    </div>
    </div>
    </div>

    <?php
	 $lastUpdateRow=$this->myaccount_model->get_last_updated_row_by_schedule_id($row['schedule_id'],$value1['summary_id'],'stitching','final_qc');
	 $any_rejection=$this->myaccount_model->check_any_rejection($row['schedule_department_id'],$value1['summary_id']);
	 if(isset($any_rejection)){
						$st='<span class="badge badge-outline-danger" >'.$any_rejection['rejected_department'].' Rejected :<br/> '.$any_rejection['verify_remark'].'<br>'.$any_rejection['verify_datetime'].'</span>';
					}else{
						if(isset($lastUpdateRow)){
							if($lastUpdateRow['verify_status']==1){
								echo $st='<span class="badge badge-outline-success w-100" >Final QC Approved</span>';
								if($lastUpdateRow['accounts_status']==1){
									echo $acc='<br><span class="badge badge-outline-success m-1 w-100" >Account Dept: Approved </span>';
									if($lastUpdateRow['submitted_to_accounts']==1 && $lastUpdateRow['accounts_status']==1){
			echo $dis.='<br/><a href="'.base_url('dispatch/dispatch_order/'.$row['schedule_uuid']).'/'.$lastUpdateRow['schedule_department_id'].'/'.$lastUpdateRow['rs_design_id'].'" title="View" style="cursor: pointer;"><label class="badge badge-success m-1" style="cursor: pointer;"><i class="fa fa-edit" ></i> All Dispatch Details</label></a>';
			}
								}else{
									echo $acc='<br><span class="badge badge-outline-danger m-1 w-100" >Account Dept:<br>Not Approved</span>';
								}
							}
							if($lastUpdateRow['verify_status']==-1){
							echo $st='<span class="badge badge-outline-danger m-1" >Rejected</span>';
							}
							if($lastUpdateRow['verify_status']==0){
							echo $st='<span class="badge badge-outline-warning m-1" >Not Approved</span>';
							}
						}else{
							echo $st='<span class="badge badge-outline-warning m-1" >Not Approved</span>';
						}
					}
					//echo $info='<a href="#" title="All Updates" style="cursor: pointer;"  data-toggle="modal" data-target="#allUpdates"  data-sid="'.$row['schedule_id'].'"  data-sdid="'.$row['schedule_department_id'].'" data-smid="'.$value1['summary_id'].'" data-did="'.$staffRow['department_id'].'"  ><label class="badge badge-warning" style="cursor: pointer;"><i class="fa fa-info-circle" ></i></label></a>';
	 ?>

    </div>
    </div>
    </div>
    <?php } ?>
    <?php
	//}
	}
	?>
    <?php
	//echo $i;
	}
	?>

</div>

</div>

<div class="modal" id="allUpdates" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
<div class="modal-dialog modal-md" role="document" style="max-width: 700px;">
<div class="modal-content"></div> 
</div>
</div>

<div class="modal" id="orderItemUpdate" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
<div class="modal-dialog modal-md" role="document" style="max-width: 700px;">
<div class="modal-content"></div> 
</div>
</div>

<script>

$(function() {
$('#orderItemUpdate,#allUpdates').on('hidden.bs.modal', function () {location.reload();});

	$('#allUpdates').on('show.bs.modal', function (event) {
	var button = $(event.relatedTarget);
	var sid=button.data('sid');
	var sdid=button.data('sdid');
	var smid=button.data('smid');
	var did=button.data('did');
	var act=button.data('act');
	//alert(act);
	var formData = "<?php echo $this->security->get_csrf_token_name(); ?>=<?php echo $this->security->get_csrf_hash(); ?>&sid="+sid+"&sdid="+sdid+"&smid="+smid+"&did="+did+"&act="+act;
	//var cid=button.data('cid');
	//alert(oid);
	var modal = $(this);
	//var dataString = "cuid="+cuid;
	$.ajax({  
	type: "POST",
	url: "<?= base_url("myaccount/all_updates_of_order/");?>",  
	data: formData,
	beforeSend: function(){
		modal.find('.modal-content').html('<i class="fa fa-spin fa-refresh"></i>');},
		success: function(response){
		modal.find('.modal-content').html(response); 
		}
	}); 

	});


$('#orderItemUpdate').on('show.bs.modal', function (event) {

	var button = $(event.relatedTarget);

	var sid=button.data('sid');

	var sdid=button.data('sdid');

	var smid=button.data('smid');

	var did=button.data('did');

	var act=button.data('act');

	//alert(act);

	var formData = "<?php echo $this->security->get_csrf_token_name(); ?>=<?php echo $this->security->get_csrf_hash(); ?>&sid="+sid+"&sdid="+sdid+"&smid="+smid+"&did="+did+"&act="+act;

	//var cid=button.data('cid');

	//alert(oid);

	var modal = $(this);

	//var dataString = "cuid="+cuid;

	$.ajax({  

	type: "POST",

	url: "<?= base_url("stitching/updates_order_status/");?>",  

	data: formData,

	beforeSend: function(){

		modal.find('.modal-content').html('<i class="fa fa-spin fa-refresh"></i>');},

		success: function(response){

		modal.find('.modal-content').html(response); 

		}

	}); 

	});  

});

</script>


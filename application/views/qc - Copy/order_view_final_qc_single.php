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
    <?php $dispatchRow=$this->common_model->get_order_final_dispatch_date($row['schedule_id']); ?>
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
    <td></td>
    </tr>
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
	<?php //print_r($schedule_data);?> 
	<?php $array1 = json_decode($schedule_data['scheduled_order_info'],true);?>
    <?php $i=0;if($array1) { //print_r($array1); ?>
    <?php foreach($array1 as $key1 => $value1){
		if($request_row['summary_item_id']==$value1['summary_id']){
		?>
    <?php if($value1['item_unit_qty_input']!=0){ $i++?>
    <div class="col-md-12 grid-margin stretch-card mt-4">
    <div class="card">
    <div class="card-body">
    <div class="d-flex align-items-center">
    <div class="ml-0">
    <h4><?php echo $i;?>.<?php echo ucwords($value1['product_type']);?></h4>
    <?php if(isset($value1['online_ref_number'])){ if($value1['online_ref_number']!=""){?>
    <p class="mb-1">
    <span class="badge" style="background-color:#ffe74c;">Ref: No:   <?php echo ucwords($value1['online_ref_number']);?></span>
    </p>
	<?php } }?>
    <p class="mb-2"><span class="badge" style="background-color:#ffe74c;">Quantity: <?php echo ucwords($value1['item_unit_qty_input']);?></span></p>
    
    
    <?php if($value1['remark']!=""){?><p class="text-muted mb-1">Remark : <?php echo ucwords($value1['remark']);?></p><?php } ?>
    
    <span class="d-flex align-items-center mt-1">
    <span class="btn btn-xs btn-rounded btn-outline-primary mr-2"><?php echo ucwords($value1['collar_type']);?></span>
    <span class="btn btn-xs btn-rounded btn-outline-primary mr-2"><?php echo ucwords($value1['sleeve_type']);?></span>
    <span class="btn btn-xs btn-rounded btn-outline-primary mr-2"><?php echo ucwords($value1['fabric_type']);?></span>
    <span class="btn btn-xs btn-rounded btn-outline-primary mr-2"><?php echo ucwords($value1['addon_name']);?></span>
    
    <?php if($value1['img_front']!=""){?>
    <span class="btn btn-xs btn-rounded btn-outline-primary mr-2 mt-1">
    <a href="<?php echo $value1['img_front'];?>" target="_blank">Image Front</a>
    </span>
    <?php } ?>
    <?php if($value1['img_back']!=""){?>
    <span class="btn btn-xs btn-rounded btn-outline-primary mr-2 mt-1">
    <a href="<?php echo $value1['img_back'];?>" target="_blank">Image Back</a>
    </span>
    <?php } ?>
    
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
    
    
    <div class="card card-inverse-info">
	<div class="card-body">
    <?php if($request_row['approved_dep_name']!=""){?>
    <p class="mb-2"><strong>Submitted To : Dispatch department</strong></p>
    <?php }?>
	<p class="mb-2"><strong>Remark:</strong>   <?php echo $request_row['response_remark'];?></p>
	<p class="mb-2"><strong>Submitted Time stamp:</strong>   <?php echo $request_row['submitted_datetime'];?></p>
	</div>
	</div>
    
   <?php
	$any_rejection=$this->myaccount_model->check_any_rejection($schedule_data['schedule_department_id'],$value1['summary_id']);
	
    if(isset($any_rejection)){
		?>
		 <span class="badge badge-outline-danger w-100" ><?php echo $any_rejection['rejected_department'];?> Rejected :<?php echo $any_rejection['verify_remark'];?><br><?php echo $any_rejection['verify_datetime'];?></span>
         <?php
	}
	?>
    
    </div>
    </div>
    </div>
    <?php } ?>
    <?php
	}
	}
	?>
    <?php
	//echo $i;

		
	}
	?>
</div>
</div>

<div class="modal" id="orderItemUpdate" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
<div class="modal-dialog modal-md" role="document" style="max-width: 700px;">
<div class="modal-content"></div> 
</div>
</div>
<script>
$(function() {
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
	url: "<?= base_url("myaccount/updates_design/");?>",  
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

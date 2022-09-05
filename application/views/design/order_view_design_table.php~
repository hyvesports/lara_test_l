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
    $dispatchRow=$this->common_model->get_order_final_dispatch_date_by_field($schedule_data['is_re_scheduled']);
    }else{
    $dispatchRow=$this->common_model->get_order_final_dispatch_date_by_field($schedule_data['schedule_id']);
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
    sh_schedule_departments.department_schedule_date
    FROM
    sh_schedule_departments
    WHERE
    sh_schedule_departments.schedule_department_id='".$schedule_data['schedule_department_id']."'  AND FIND_IN_SET($did,sh_schedule_departments.department_ids) ";
    //echo $sql;
    $query = $this->db->query($sql);					 
    $rsRow=$query->row_array();
    //print_r($rsRow);
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
    <td colspan="2"> <div class="alert alert-success" role="alert"><strong>Special Requirement :</strong> <?php echo $row['wo_special_requirement'];?></div></td>
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
    //$Attachment= $this->common_model->get_wo_documents($row['order_id'],'document');
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
    
    <?php //$attachments=$this->common_model->get_order_attachments($row['order_id']);
    $attachments= $this->common_model->get_wo_documents($row['order_id'],'document');
    ?>
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
    <?php }
    } ?>
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
  
  <?php 
 
  $rejectedQty=0;
  if($actionFrom=="competed"){ $actionFrom="competed";}else if($actionFrom=="pending"){ $actionFrom="pending"; }else{ $actionFrom="all"; }?>
  <?php $array1 = json_decode($schedule_data['scheduled_order_info'],true);// print_r($schedule_data['scheduled_order_info']);?>
  <?php $i=0;if($array1) {
  //print_r($array1); ?>
  <div class="col-md-12 grid-margin stretch-card mt-4">
  <div class="card">
  <div class="card-body">
  <h4 class="card-title">Order Items</h4>
  <div class="table-responsive">
  <table class="table w-100" width="100%" id="listing">
  <thead>
  <tr>
  <th width="40%" class="pt-1 pl-0">Product</th>
  <th width="10%" class="pt-1">Qty</th>
  <th width="20%" class="pt-1">Remark</th>
  <th width="15%" class="pt-1 text-center">Status</th>
  <th width="15%" class="pt-1">Actions</th>
  </tr>
  </thead>
  <tbody>
  <?php foreach($array1 as $key1 => $value1){?>
  <?php if($value1['item_unit_qty_input']!=0){ $i++?>
  <?php
  $statuss="";
  $rejStatus=0;
	$approvedQty=0;
  $sel="SELECT verify_status,verify_remark,verify_datetime,rejected_department FROM rs_design_departments WHERE schedule_department_id='".$schedule_data['schedule_department_id']."'  AND summary_item_id='".$value1['summary_id']."' and qc_name='design' ORDER BY rs_design_id DESC LIMIT 1 ";
 
  $query = $this->db->query($sel);					 
  $rsRow2=$query->row_array();
  ?>
  <?php
  $anyRejSql="SELECT rejected_from_departments,rejected_remark,rejected_datetime,rejected_qty FROM sh_schedule_department_rejections WHERE batch_number='".$schedule_data['batch_number']."' and schedule_id='".$schedule_data['schedule_id']."' and summary_id='".$value1['summary_id']."' and  FIND_IN_SET(4,rejected_to_departments) limit 1 "; 
//echo $anyRejSql;
  $queryRej = $this->db->query($anyRejSql);					 
  $any_rejection=$queryRej->row_array();
  $rowNow="all";
  if(isset($any_rejection)){
  $Rstatuss='<span class="badge badge-outline-danger mb-1 w-100" > Rejected By:'.$any_rejection['rejected_from_departments'].'<br/> '.$any_rejection['rejected_remark'].'<br>'.$any_rejection['rejected_datetime'];
  if($any_rejection['rejected_qty']!=0){
  $Rstatuss.="<br>Rejected Qty: ".$any_rejection['rejected_qty'];
  $Rqty=$any_rejection['rejected_qty'];
  }
  $Rstatuss.='</span><br/>';
  $rejStatus=1;
  }else{
  $Rstatuss="";
  $Rqty=0;
  }
  //else{
  ?>
  <?php if($rejStatus==0){ ?>
  <?php if(isset($rsRow2)){ ?>
  <?php if($rsRow2['verify_status']==1){ 
  $approvedQty=$value1['item_unit_qty_input']-$Rqty;
  if($actionFrom=="completed"){$rowNow="completed";}
  $statuss='<span class="badge badge-outline-success w-100 text-primary" style="color:000;" >Approved : '.$rsRow2['verify_remark'].'<br>'.$rsRow2['verify_datetime'].'</span>';
  }
  ?>
  
  <?php if($rsRow2['verify_status']==-1){ ?>
  <?php $statuss='<span class="badge badge-outline-danger w-100" >'.$rsRow2['rejected_department'].' Reject <br>'.$rsRow2['verify_datetime'].'</span>';?>
  <?php } ?>
  
  <?php if($rsRow2['verify_status']==0){if($actionFrom=="pending"){ $rowNow="pending"; }?>
  <?php $statuss='<span class="badge badge-outline-warning w-100" >In Design QC.</span>';?>
  <?php } ?>
  <?php }else{  if($actionFrom=="pending"){ $rowNow="pending"; } ?>
  <?php $statuss='<span class="badge badge-outline-info w-100" >In Design</span>';?>
  <?php } ?>
  <?php } ?>
  <?php //} ?>
  <?php if($rowNow==$actionFrom){?>
  <tr>
  <td class="py-1 pl-0" valign="top" width="40%">
  <div class="d-flex align-items-center">
  <div class="ml-3"><strong><?php echo ucwords($value1['product_type']);?></strong><br/>
  <?php if(isset($value1['online_ref_number'])){ if($value1['online_ref_number']!=""){?>
  <p class="mb-2 mt-2">Ref: No: <?php echo ucwords($value1['online_ref_number']);?></p>
  <?php } }?>
  <span class="align-items-center mt-1">
  <span class="btn btn-xs btn-rounded btn-outline-primary mr-2 mb-1"><?php echo ucwords($value1['collar_type']);?></span>
  <span class="btn btn-xs btn-rounded btn-outline-primary mr-2"><?php echo ucwords($value1['sleeve_type']);?></span><br />
  <span class="btn btn-xs btn-rounded btn-outline-primary mr-2"><?php echo ucwords($value1['fabric_type']);?></span>
  <?php if($value1['addon_name']!=""){ ?>
  <span class="btn btn-xs btn-rounded btn-outline-primary mr-2"><?php echo ucwords($value1['addon_name']);?></span>
  <?php } ?>
  <br />
  <?php if($value1['img_front']!=""){?>
  <span class="btn btn-xs  btn-outline-primary mr-2 mt-1">
  <div id="lightgallery2" class="row lightGallery"><a href="<?php echo $value1['img_front'];?>" target="_blank"><img src="<?php echo $value1['img_front'];?>" title="Image Front" width="100" height="100"  style="width:100px; height:100px;"><br/>Front</a></div>
  </span>
  <?php } ?>
  <?php if($value1['img_back']!=""){?>
  <span class="btn btn-xs  btn-outline-primary mr-2 mt-1">
  <div id="lightgallery2" class="row lightGallery"><a href="<?php echo $value1['img_back'];?>" target="_blank"><img src="<?php echo $value1['img_back'];?>" title="Image Back" width="100" height="100" style="width:100px; height:100px;" ><br/>Back</a></div>
  </span>
  <?php } ?>
  
  
  </span>
  </div>
  </div>
  </td>
  <td width="10%">
  <label class="badge badge-info" title="Total Quantity"><?php echo ucwords($value1['item_unit_qty_input']);?></label>
  <?php if($approvedQty>0){ echo '<label class="badge badge-success" title="Approved Quantity" >'.$approvedQty.'</label>'; } ?>
  <?php if($Rqty>0){ echo '<label class="badge badge-danger" title="Rejected Quantity" >'.$Rqty.'</label>'; } ?>
  </td>
  <td style="font-size:10px;" width="20%">
  <?php if($value1['remark']!=""){?><div class="alert alert-info" role="alert" style="font-size:10px;"><?php echo trim(ucwords($value1['remark']));?></div><?php } ?>
  <?php 
  //$design_result=$this->myaccount_model->get_design_data($value1['summary_id'],'design');
  $sql="Select response_url from rs_design_departments where summary_item_id='".$value1['summary_id']."' and from_department='design' ORDER BY rs_design_id DESC LIMIT 1";  
  //echo $sql;
  $query = $this->db->query($sql);					 
  $design_result=$query->row_array();
  ?>
  <?php if($design_result['response_url']!=""){ ?>
  <div class="alert alert-success" role="alert">
  Design URL : <br/><a href="<?php echo $design_result['response_url'];?>" target="_blank"><?php echo $design_result['response_url'];?></a>
  </div>
  <?php
  }
  ?>
  
  
  </td>
  
  <td class="text-center" width="15%" >
  <?php echo $Rstatuss;?>
  <?php echo $re;?>
  <?php echo $statuss;?>
  </td>
  <td width="40%">
  
  <a href="#" class="badge badge-warning mt-1 mb-1 float-center w-100" title="Item Info" style="cursor: pointer;"  data-toggle="modal" data-target="#itemInfo"  data-sid="<?php echo $row['schedule_id'];?>"  data-sdid='<?php echo $schedule_data['schedule_department_id'];?>' data-smid='<?php echo $value1['summary_id'];?>' data-did='<?php echo $staffRow['department_id'];?>' data-act='list' >Item Info</a><br />
  
  <?php if( $rsRow2['verify_status']!=1){ ?>
  <a href="#" class="badge badge-primary mt-1 mb-1 float-center w-100" title="Update Status" style="cursor: pointer;"  data-toggle="modal" data-target="#orderItemUpdate"  data-sid="<?php echo $row['schedule_id'];?>"  data-sdid='<?php echo $schedule_data['schedule_department_id'];?>' data-smid='<?php echo $value1['summary_id'];?>' data-did='<?php echo $staffRow['department_id'];?>' data-act='up' >Update Status</a><br />
  <?php } ?>
  
  
  <a href="#" class="badge badge-info mt-1 mb-1 float-center w-100" title="All Updates " style="cursor: pointer;"  data-toggle="modal" data-target="#orderItemUpdate"  data-sid="<?php echo $row['schedule_id'];?>"  data-sdid='<?php echo $schedule_data['schedule_department_id'];?>' data-smid='<?php echo $value1['summary_id'];?>' data-did='<?php echo $staffRow['department_id'];?>' data-act='list' >All Updates </a>
  
  
  </td>
  </tr>
  <?php } ?>
  <?php } ?>
  <?php } ?>
  </tbody>
  </table>
  </div>
  </div>
  </div>
  </div>
  <?php } ?>
  </div>
</div>

<script src="<?php echo base_url() ?>public/vendors/lightgallery/js/lightgallery-all.min.js"></script>
<script>
(function($) {
'use strict';
$(".lightGallery").lightGallery();
})(jQuery);
</script>
<div class="modal" id="orderItemUpdate" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
<div class="modal-dialog modal-md" role="document" style="max-width: 700px;">
<div class="modal-content"></div> 
</div>
</div>

<div class="modal" id="itemInfo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
<div class="modal-dialog modal-md" role="document" style="max-width: 700px;">
<div class="modal-content"></div> 
</div>
</div>
<script>
(function($) {
'use strict';
$(function() {
$('#listing').DataTable({
"aLengthMenu": [
[5, 10, 15,100, -1],
[5, 10, 15,100, "All"]
],
"iDisplayLength": 100,
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
$(function() {
$('#orderItemUpdate').on('hidden.bs.modal', function () {
location.reload();
})

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
url: "<?= base_url("design/updates_design/");?>",  
data: formData,
beforeSend: function(){
modal.find('.modal-content').html('<i class="fa fa-spin fa-refresh"></i>');},
success: function(response){
modal.find('.modal-content').html(response); 
}
}); 
}); 

$('#itemInfo').on('show.bs.modal', function (event) {
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
url: "<?= base_url("myaccount/order_info/");?>",  
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

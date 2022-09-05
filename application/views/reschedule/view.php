<div class="content-wrapper">
<div class="row profile-page">
<div class="col-12">
<div class="card">
<div class="card-body">

<h4 class="card-title"><?php echo $title_head;?>
<span style="text-align:right; float:right;"><a class="btn btn-primary " href="<?php echo base_url('accounts/index');?>">List</a></span> 
</h4>
<p class="card-description" style="border-bottom: 1px solid #f2f2f2;"><strong>Order Details</strong></p>

<div class="profile-body pt-0" >

<div class="row">
<div class="col-md-12">
<div class="tab-content tab-body" id="profile-log-switch">
<div class="tab-pane fade show active pr-3" id="user-profile-info" role="tabpanel" aria-labelledby="user-profile-info-tab">
<?php 
if($rowResponse['submitted_to_accounts']==1){
 if($rowResponse['accounts_status']==0){
	 ?>
     <span class="badge badge-outline-warning w-100" >Waiting for accounts approval.</span>
     <?php
 }else if($rowResponse['accounts_status']==1){
	 echo '<span class="badge badge-outline-success w-100" >Order approved by accounts department.</span>';
 }else{
	 echo '<span class="badge badge-outline-danger w-100" >Order rejected by accounts department.</span>';
 }
}
?>

<table class="table table-borderless w-100 mt-2">
<tbody>
<tr>
<td><strong>Order Number :</strong> <?php echo $row['orderform_number'];?></td>
<td><strong>Unit :</strong> <?php echo $row['production_unit_name'];?></td>
</tr>

<?php


?>

<tr>
<td><strong>Sales Person :</strong> 
<?php if($row['orderform_type_id']==2) { echo 'Online Sales'; }else{ 
//print_r($row);
//echo $row['wo_owner_id'].'---';
$bio=$this->auth_model->get_staff_bio_data_by_staff_id($row['wo_owner_id']);
echo $bio['bio_person'].",".$bio['bio_role'];

}
?>
</td>

<td><strong>Scheduled By :</strong> <?php echo $row['log_full_name'];?></td>
</tr>


<tr>
<td colspan="2"><strong class="mb-2">Order Submitted By :</strong><br /><br /><?php echo ucwords($rowResponse['submitted_person']);?><br /><?php echo $rowResponse['staff_role'];?> <br /> On <?php echo $rowResponse['verify_datetime'];?> </td>
</tr>

</tbody>
</table>

<div class="row">
<?php $array1 = json_decode($row['sh_order_json'],true);?>

<div class="col-md-12 mt-5">
<?php if($array1) { //print_r($array1); ?>
<p class="card-description text-warning" style="border-bottom: 1px solid #f2f2f2;"><strong>Order Details</strong></p>
<div class="new-accounts">
<ul class="chats">
<?php foreach($array1 as $key1 => $value1){ ?>
	<?php if($value1['item_unit_qty_input']!=0 && $rowResponse['summary_item_id']==$value1['summary_id']){?>
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
    <span class="btn btn-xs btn-rounded btn-outline-primary mr-2"><?php echo ucwords($value1['addon_name']);?></span>
    </span>
    </div>
    </a>
    <?php if($value1['img_front']!=""){?>
   
    <a href="<?php echo $value1['img_front'];?>" target="_blank">
    <div class="user">
    <span class="d-flex align-items-center mt-1">
    <span class="btn btn-xs btn-rounded btn-outline-warning mr-2">Image Front</span>
    </span>
    </div>
    </a>
    <?php } ?>
    
    <?php if($value1['img_back']!=""){?>
  
    <a href="<?php echo $value1['img_back'];?>" target="_blank">
    <div class="user">
    <span class="d-flex align-items-center mt-1">
    <span class="btn btn-xs btn-rounded btn-outline-warning mr-2">Image Back</span>
    </span>
    </div>
    </a>
    <?php } ?>
    
    
    
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

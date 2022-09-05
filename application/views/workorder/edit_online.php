<style>
.error{
	color:#F00;
}
</style>
<div class="content-wrapper">
<div class="row profile-page">
    <div class="col-12">
    <div class="card">
    <div class="card-body">
    <h4 class="card-title"><?php echo $title_head;?><span style="text-align:right; float:right;"><a class="btn btn-primary " href="<?php echo base_url('workorder/wo_online');?>">LIST</a><a class="btn btn-success m-1" href="<?php echo base_url('workorder/view_online/'.$woRow['order_uuid']);?>">View</a></span>
    </h4>
    <div class="profile-body" style="padding-top: 0px;">
   <span id="response"></span>
   <?php if($this->session->flashdata('success')): ?>
<div class="alert alert-success" style="width:100%;">
<a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">x</a>
<?=$this->session->flashdata('success')?>
</div>
<?php endif; ?>
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
    
    <div class="tab-pane fade show active  pr-3" id="user-profile-info" role="tabpanel" aria-labelledby="user-profile-info-tab">
    <?php include('edit_order_info.php');?>
    </div>
    <div class="tab-pane  fade" id="user-profile-activity" role="tabpanel" aria-labelledby="user-profile-activity-tab">
    <?php include('edit_online_order_summary.php');?>
    </div>
    
    <div class="tab-pane  fade" id="user-profile-doc" role="tabpanel" aria-labelledby="user-profile-doc-tab">
    <?php include('edit_online_documents.php');?>
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
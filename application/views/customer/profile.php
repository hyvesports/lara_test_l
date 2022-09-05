<div class="content-wrapper">
<div class="row profile-page">
    <div class="col-12">
    <div class="card">
    <div class="card-body">
    <h4 class="card-title"><?php echo $title_head;?><span style="text-align:right; float:right;"><a class="btn btn-primary " href="<?php echo base_url('customer/index');?>">LIST</a></span>
    </h4>
    <div class="profile-body" style="padding-top: 0px;">
    <ul class="nav tab-switch" role="tablist">
    <li class="nav-item">
    <a class="nav-link active" id="user-profile-info-tab" data-toggle="pill" href="#user-profile-info" role="tab" aria-controls="user-profile-info" aria-selected="true">Profile</a>
    </li>
    <li class="nav-item">
    <a class="nav-link" id="user-profile-activity-tab" data-toggle="pill" href="#user-profile-activity" role="tab" aria-controls="user-profile-activity" aria-selected="false">Leads</a>
    </li>
    </ul>
    <div class="row">
    <div class="col-md-12">
    <div class="tab-content tab-body" id="profile-log-switch">
    
    	<?php //print_r($row);?>
        <div class="tab-pane fade show active pr-3" id="user-profile-info" role="tabpanel" aria-labelledby="user-profile-info-tab">
        <table class="table table-borderless w-100 mt-4">
        <tr>
        <td><strong>Full Name :</strong> <?php echo $row['customer_name'];?></td>
        <td><strong>Customer Code :</strong> <?php echo $row['customer_code'];?></td>
        </tr>
        <tr>
        <td><strong>Phone :</strong> <?php echo $row['customer_mobile_no'];?></td>
        <td><strong>Email :</strong> <?php echo $row['customer_email'];?></td>
        </tr>
        
        <tr>
         <td><strong>Website :</strong> <?php echo $row['customer_website'];?></td>
        <td><strong>Social Media :</strong>
        <?php if($row['customer_social_media_links']!="") { 
			$json_decode=json_decode($row['customer_social_media_links'],true);
			foreach($json_decode as  $key => $value){?>
            
            <a href="<?php echo $value;?>" target="_blank"><div class="badge badge-success"><?php echo $key;?> </div></a>
        <?php } } ?>
        
         </td>
       
        </tr> 
        <tr>
        <td colspan="2"><strong>Location :</strong> <?php echo $row['city'];?>, <?php echo $row['state'];?>, <?php echo $row['country'];?>.</td>
        </tr>
        </table>
        </div>
        
        
        
        
    <div class="tab-pane  fade" id="user-profile-activity" role="tabpanel" aria-labelledby="user-profile-activity-tab">
    <?php $leads = $this->customer_model->get_customer_leads($row['customer_id']); //print_r($leads);?>
    
    <?php if($leads){?>
    <?php foreach($leads as $lead){?>
    <blockquote class="blockquote blockquote-primary text-success ">
    <p><?php echo $lead['lead_desc'];?></p>
    <footer class="blockquote-footer"><?php echo $lead['lead_date'];?> <cite title="Source Title" style="font-size:14px; text-decoration:blink;" ><a href="<?php echo base_url() ?>leads/view/<?php echo $lead['lead_uuid'];?>" class="<?php echo $lead['color_code'];?> text-info" target="_blank">View Lead Details</a></cite></footer>
	<?php if($lead['orderform_number']!=""){ ?>
    <div class="badge badge-warning">Order Number : <?php echo $lead['orderform_number'];?></div>
    <a href="<?php echo base_url() ?>workorder/view/<?php echo $lead['wo_order_uuid'];?>" class="badge badge-success">View Work Order</a>
	<?php } ?>
    </blockquote>

    <?php } } ?>

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
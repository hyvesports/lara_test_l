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
<td><strong>Dispatch Date :</strong> <?php echo date("d-m-Y", strtotime($row['schedule_end_date'])); ?></td>
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
sh_schedule_departments.schedule_id='".$row['schedule_id']."'  AND FIND_IN_SET($did,sh_schedule_departments.department_ids) ";
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

<div class="row">
<?php //print_r($staffRow);?>
<?php $array1 = json_decode($schedule_data['scheduled_order_info'],true);?>
<?php if($array1) { //print_r($array1); ?>
<?php //echo $row['order_id'];?>
<div class="col-md-12 mt-5">
<p class="card-description text-warning" style="border-bottom: 1px solid #f2f2f2;"><strong>Order Details</strong></p>






<div class="new-accounts">
<ul class="chats">
<?php $i=0;foreach($array1 as $key1 => $value1){ ?>
	<?php if($value1['item_unit_qty_input']!=0){ $i++?>
    <li class="chat-persons">
    <a href="#">
    <div class="user w-100 pl-0">
    <p class="u-name"><?php echo $i;?>.<?php echo ucwords($value1['product_type']);?></p>
   <!-- <p class="u-designation">Production Quantity : <?php //echo ucwords($value1['item_unit_qty_input']);?></p>-->
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
    
    <?php $options=$this->myaccount_model->get_order_options($row['order_id'],$value1['summary_id']); ?>
    <?php if($options){ $inc=0;?>
    
    <div class="table-responsive w-100 mt-1">
                                <table class="table">
                                  <thead>
                                    <tr class="bg-light">
                                        <th>#</th>
                                        <th>Name</th>
                                        <th class="text-right">Number</th>
                                        <th class="text-right">Size</th>
                                       
                                      </tr>
                                  </thead>
                                  <tbody>
                                  <?php foreach($options as $OP){ $inc++;?>
                                    <tr class="text-right">
                                      <td class="text-left"><?php echo $inc;?></td>
                                      <td class="text-left"><?php echo $OP['option_name'];?></td>
                                      <td><?php echo $OP['option_number'];?></td>
                                      <td><label class="badge badge-success"><?php echo $OP['option_size_value'];?></label></td>
                                      
                                    </tr>
                                  <?php } ?>    
                                  </tbody>
                                </table>
                              </div>
    
    <?php } ?>
    </li>
    <?php }?>
<?php } ?>
</ul>
</div>

</div>
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


<div class="col-md-4 grid-margin stretch-card mt-4">
							<div class="card">
								<div class="card-body">
									<div class="d-flex align-items-center">
										<img src="..\images\faces\face5.jpg" class="img-lg rounded-circle mb-2" alt="profile image">
										<div class="ml-3">
											<h4>Maria Johnson</h4>
											<p class="text-muted mb-0">Developer</p>
										</div>
									</div>
									<p class="mt-4 card-text">
											Lorem ipsum dolor sit amet, consectetuer adipiscing elit.
											Aenean commodo ligula eget dolor. Lorem
									</p>
									<button class="btn btn-info btn-sm mt-3 mb-4">Follow</button>
									<div class="border-top pt-3">
										<div class="row">
											<div class="col-4">
												<h6>5896</h6>
												<p>Post</p>
											</div>
											<div class="col-4">
												<h6>1596</h6>
												<p>Followers</p>
											</div>
											<div class="col-4">
												<h6>7896</h6>
												<p>Likes</p>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>


</div>

</div>

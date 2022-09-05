<div class="tab-pane fade pr-3" id="user-profile-info" role="tabpanel" aria-labelledby="user-profile-info-tab">
        <table class="table table-borderless w-100 mt-4">
        <tr>
        <td><strong>Order & No :</strong> <?php echo $row['wo_type_name'];?> & <?php echo $row['orderform_number'];?></td>
         <td><strong>Sales Handler :</strong> <?php if($row['lead_id']==0){ echo 'Admin'; }else{ echo $row['sales_handler']; } ?></td>
        </tr>
        <tr>
        <td><strong>Order Nature :</strong> <?php echo $row['order_nature_name'];?></td>
        <td><strong>Dispatch Date :</strong>
        <?php $dispatchRow=$this->common_model->get_order_final_dispatch_date($row['schedule_id']); ?>
        <?php echo date("d-m-Y", strtotime($dispatchRow['department_schedule_date'])); ?>
        </td>
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
        
        
        <?php $array1 = json_decode($response['submitted_item'],true);?>
        <?php $i=0;if($array1) { //print_r($array1); ?>
    	<?php foreach($array1 as $key1 => $value1){?>
        	<?php if($rejection_row['rej_summary_item_id']==$value1['summary_id']){ ?>
            
            <div class="col-md-12 grid-margin stretch-card mt-4">
            <div class="card">
            <div class="card-body">
            <div class="d-flex align-items-center">
            <div class="ml-0">
            <h4><?php echo ucwords($value1['product_type']);?></h4>
            
            <?php if(isset($value1['online_ref_number'])){ if($value1['online_ref_number']!=""){?>
            <p class="mb-1">
            <span class="badge" style="background-color:#ffe74c;">Ref: No: <?php echo ucwords($value1['online_ref_number']);?></span>
            </p>
            <?php } }?>
            <p class="mb-2">
            <span class="badge" style="background-color:#ffe74c;">Quantity: <?php echo ucwords($value1['item_unit_qty_input']);?></span>
            </p>
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
            
            <?php 
            $design_result=$this->myaccount_model->get_design_data($value1['summary_id'],'design');
            ?>
            <?php if($design_result['response_url']!=""){ ?>
            <div class="alert alert-success" role="alert">
            Design URL : <a href="<?php echo $design_result['response_url'];?>" target="_blank"><?php echo $design_result['response_url'];?></a>
            </div>
            <?php
            }
            ?>
            </div>
            </div>
            </div>
            <?php } ?>
        <?php } ?>
        <?php } ?>
        </div>
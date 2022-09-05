<div class="modal-header" style="">

<button type="button" class="close" data-dismiss="modal" aria-label="Close">

<span aria-hidden="true">x</span>

</button>

</div>

<div class="modal-body"  >




<?php //print_r($schedule_data);?> 

	<?php $array1 = json_decode($schedule_data['scheduled_order_info'],true);?>

    <?php $i=0;if($array1) { //print_r($array1); ?>

    <?php foreach($array1 as $key1 => $value1){

		if($item_row==$value1['summary_id']){

			

		

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
    <span class="btn btn-xs btn-rounded btn-outline-primary mr-2"><?php echo ucwords($value1['addon_name']);?></span><?php } ?>
<br/>
<?php if($value1['img_front']!=""){?>
    <span class="btn btn-xs  btn-outline-primary mr-2 mt-2">
    <div id="" class="row "><a href="<?php echo $value1['img_front'];?>" target="_blank"><img src="<?php echo $value1['img_front'];?>" title="Image Front" width="100" height="100"  style="width:200px; height:200px;"><br/>Front</a></div>
    </span>
    <?php } ?>
    <?php if($value1['img_back']!=""){?>
    <span class="btn btn-xs  btn-outline-primary mr-2 mt-1">
    <div id="" class="row "><a href="<?php echo $value1['img_back'];?>" target="_blank"><img src="<?php echo $value1['img_back'];?>" title="Image Back" width="100" height="100" style="width:200px; height:200px;" ><br/>Back</a></div>
    </span>
    <?php } ?>
    

    
   

     

    

    </span>

    

    </div>

    </div>

  

    

    

    <div class="border-top pt-3 mt-3">

    <div class="row">

    <div class="col-12">

   <?php $options=$this->myaccount_model->get_order_options($schedule_data['order_id'],$value1['summary_id']); ?>

    <?php if($options){ $inc=0;?>

    

    <div class="table-responsive w-100 mt-1">

    <table class="table">

    <thead>

    <tr class="bg-light">

    <th>Name</th>

    <th class="text-left">Number</th>
    <th class="text-left">Size</th>
	<th class="text-left">Fit Type</th>
	<th class="text-left">QTY</th>
	<th class="text-left">Customer Info</th>
    </tr>

    </thead>

    <tbody>

    <?php foreach($options as $OP){ $inc++;?>

    <tr class="text-right">

    <td class="text-left"><?php if($OP['option_name']!=""){ echo $OP['option_name']; }else{ echo 'Nil'; }?></td>

    <td class="text-left"><?php if($OP['option_number']!=""){ echo $OP['option_number']; }else{ echo 'Nil'; }?></td>

    <td class="text-left"><?php echo $OP['option_size_value'];?></td>
	<td class="text-left"><?php echo $OP['fit_type_name'];?></td>
	<td class="text-left"><?php echo $OP['option_qty'];?></td>
	<td class="text-left"><?php echo $OP['customer_item_info'];?></td>
    </tr>

    <?php } ?>    

    </tbody>

    </table>

    </div>

    <?php } ?>

    </div>

    

    

    </div>

    </div>



    

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




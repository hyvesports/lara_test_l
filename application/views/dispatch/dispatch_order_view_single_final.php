<div class="content-wrapper">

<div class="content-wrapper">

<div class="row">

<div class="col-md-4 grid-margin">

<div class="card">

<div class="card-body">

<h4 class="card-title">

Dispatch item 

<span style="text-align:right; float:right;"><a class="btn btn-primary " href="<?php echo base_url('myaccount/myorders/');?>">Back</a></span>

</h4>

<?php $totalQty=0;?>

<?php //print_r($rowResponse);



?>

	<?php $array1 = json_decode($schedule_data['scheduled_order_info'],true);?>

    <?php $i=0;if($array1) { //print_r($array1); ?>

    <?php foreach($array1 as $key1 => $value1){

		if($request_row['summary_item_id']==$value1['summary_id']){

			$totalQty=$value1['item_unit_qty_input'];

		?>

        

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

    

    <span class=" align-items-center mt-1">

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



        

  <?php } } } ?>  

  

  	<?php $attachments=$this->common_model->get_order_attachments($row['order_id']); ?>

        <?php if($attachments){ ?>

        <div class="email-wrapper wrapper">

        <div class="row align-items-stretch">

        <div class="mail-view d-none d-md-block col-md-12 col-lg-12 bg-white">

        <div class="message-body">

        <div class="attachments-sections">

        <ul>

        	<?php foreach($attachments as $attachment){

				$path_attachment= base_url().'uploads/orderform/'.$attachment['document_name'];

				if(file_exists($path_attachment)){

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



<?php

	//order_info

	//echo $totalQty;

	if($order_info['orderform_type_id']==2){ // online order

		$wo_order_id=$order_info['order_id'];

		$order_summary_id=$request_row['summary_item_id'];

		$sel="SELECT * FROM wo_order_summary WHERE  wo_order_id='$wo_order_id' AND order_summary_id='$order_summary_id' ";
		$query = $this->db->query($sel);					 
    	$itemInfo=$query->row_array();

		

		$sel2="SELECT dispatch_id FROM tbl_dispatch WHERE is_default='1' and dispatch_order_id='$wo_order_id' and dispatch_order_item_id='$order_summary_id'  ";

		//echo $sel2;

		$query2 = $this->db->query($sel2);					 

    	$dispatchRow=$query2->row_array();

		

		$shipping_type_id=$itemInfo['wo_shipping_type_id'];
		$dispatch_address=$itemInfo['wo_shipping_address'];
		$dispatch_customer_id=$itemInfo['summary_client_id'];
		$dispatch_client_name=$itemInfo['summary_client_name_only'];
		$summary_client_mobile=$itemInfo['summary_client_mobile'];
		$summary_client_email=$itemInfo['summary_client_email'];

		$dispatch_date = date('d-m-Y');

		$dispatch_datetime = date('d-m-Y H:i:s');

		$dispatch_status=0;

		$dispatch_by=$this->session->userdata('loginid');

		

		if(!isset($dispatchRow)){

			$ins="INSERT INTO `tbl_dispatch` (`dispatch_id`, `is_default`, `dispatch_order_id`, `dispatch_order_item_id`, `dispatch_customer_id`, `dispatch_client_name`, `dispatch_address`, `shipping_type_id`, `shipping_qty`, `dispatch_by`, `dispatch_date`, `dispatch_datetime`, `dispatch_status`) VALUES (NULL, '1', '$wo_order_id', '$order_summary_id', '$dispatch_customer_id', '$dispatch_client_name', '$dispatch_address', '$shipping_type_id', '$totalQty', '$dispatch_by', '$dispatch_date', '$dispatch_date', '$dispatch_status');";

			$this->db->query($ins);

		}

	

	}else{ //offline order

		//wo_customer_shipping

		

		$wo_order_id=$order_info['order_id'];

		$sel="SELECT * FROM wo_customer_shipping WHERE  wo_order_id='$wo_order_id' LIMIT 1 ";

		$query = $this->db->query($sel);					 

    	$itemInfo=$query->row_array();

		

		$order_summary_id=$request_row['summary_item_id'];

		$wo_client_id=$order_info['wo_client_id'];

		

		$sel_cus="SELECT * FROM customer_master WHERE  customer_id='$wo_client_id' LIMIT 1 ";

		$query_cus = $this->db->query($sel_cus);					 

    	$custInfo=$query_cus->row_array();

		//print_r($order_info);

		$shipping_type_id=0;

		$shipping_mode_id=$order_info['wo_shipping_mode_id'];

		$dispatch_address=$itemInfo['shipping_address'];

		$dispatch_customer_id=$itemInfo['shipping_customer_id'];

		

		$dispatch_client_name=$custInfo['customer_name'];

		$summary_client_mobile=$custInfo['customer_mobile_no'];

		$summary_client_email=$custInfo['customer_email'];

		

		$dispatch_date = date('d-m-Y');

		$dispatch_datetime = date('d-m-Y H:i:s');

		$dispatch_status=0;

		$dispatch_by=$this->session->userdata('loginid');

		

		$sel2="SELECT dispatch_id FROM tbl_dispatch WHERE is_default='1' and dispatch_order_id='$wo_order_id' and  dispatch_order_item_id='$order_summary_id'    ";

		//echo $sel2;

		$query2 = $this->db->query($sel2);					 

    	$dispatchRow=$query2->row_array();

		

		if(!isset($dispatchRow)){

			$ins="INSERT INTO `tbl_dispatch` (`dispatch_id`, `is_default`, `dispatch_order_id`, `dispatch_order_item_id`, `dispatch_customer_id`, `dispatch_client_name`, `dispatch_address`, `shipping_type_id`, `shipping_qty`, `dispatch_by`, `dispatch_date`, `dispatch_datetime`, `dispatch_status`) VALUES (NULL, '1', '$wo_order_id', '$order_summary_id', '$dispatch_customer_id', '$dispatch_client_name', '$dispatch_address', '$shipping_type_id', '$totalQty', '$dispatch_by', '$dispatch_date', '$dispatch_date', '$dispatch_status');";

			$this->db->query($ins);

		}

	}

	?>





<?php $dispatches=$this->dispatch_model->get_my_order_dispatches($wo_order_id,$order_summary_id); ?>

<div class="col-md-8 grid-margin">

<div class="card">

<div class="card-body">

<h4 class="card-title">Shipping Details <br /> <a href="#" class="badge badge-primary mt-3 mb-4 float-center" title="Add new" style="cursor: pointer;"  data-toggle="modal" data-target="#orderDispatch"  data-dipsid="0"  data-qty="<?php echo $totalQty;?>"  data-oid="<?php echo $wo_order_id;?>" data-smid="<?php echo $order_summary_id;?>" data-actn="add" data-rsid="<?php echo $rowResponse['rs_design_id'];?>"  >New Another Address</a></h4>



<div class="table-responsive">

<table class="table">

<thead>

<tr>

<th class="pt-1 pl-0">Address</th>

<th class="pt-1">Shipping Type/Mode</th>

<th class="pt-1">Qty</th>

<th>Status</th>

<th>Action</th>

</tr>

</thead>

<tbody>

	<?php if($dispatches){ ?>

    <?php foreach($dispatches as $dis){ ?>

    <tr>

    <td class="py-1 pl-0">

    <div class="d-flex align-items-center">

    

    <div class="ml-0">

    <p class="mb-2"><?php echo $dis['dispatch_client_name'];?></p>

    <p class="mb-0 text-muted text-small"><?php echo $dis['dispatch_address'];?></p>

    </div>

    </div>

    </td>

    <td><?php echo $dis['shipping_type_name'];?>/<?php echo $dis['shipping_mode_name'];?></td>

    <td><label class="badge badge-success"><?php echo $dis['shipping_qty'];?></label></td>

    

    <td>

    <?php if($dis['dispatch_status']==1){ echo '<label class="badge badge-success">Dispatched</label>'; }else{ echo '<label class="badge badge-danger">Not Dispatched</label>'; } ?>

    </td>

    <td>

    <a href="#" class="badge badge-primary  float-center" title="Update" style="cursor: pointer;"  data-toggle="modal" data-target="#orderDispatch"  data-dipsid="<?php echo $dis['dispatch_id'];?>"  data-qty="<?php echo $totalQty;?>"  data-oid="<?php echo $wo_order_id;?>" data-smid="<?php echo $order_summary_id;?>" data-actn='up' data-rsid="<?php echo $rowResponse['rs_design_id'];?>" >

    Update</a>

    </td>

    </tr>

	<?php } } ?>







</tbody>

</table>

</div>

</div>

</div>

</div>

</div>

</div>

</div>

<div class="modal" id="orderDispatch" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">

<div class="modal-dialog modal-md" role="document" style="max-width: 700px;">

<div class="modal-content"></div> 

</div>

</div>



<script>

$(function() {

	$('#orderDispatch').on('hidden.bs.modal', function () {location.reload();});

$('#orderDispatch').on('show.bs.modal', function (event) {

var button = $(event.relatedTarget);

var dipsid=button.data('dipsid');

var qty=button.data('qty');

var oid=button.data('oid');

var smid=button.data('smid');

var actn=button.data('actn');

var rsid=button.data('rsid');





var formData = "<?php echo $this->security->get_csrf_token_name(); ?>=<?php echo $this->security->get_csrf_hash(); ?>&dipsid="+dipsid+"&qty="+qty+"&oid="+oid+"&smid="+smid+"&actn="+actn+"&rsid="+rsid;

//var cid=button.data('cid');

//alert(oid);

var modal = $(this);

//var dataString = "cuid="+cuid;

$.ajax({  

type: "POST",

url: "<?= base_url("dispatch/load_dispatch/");?>",  

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


<div class="content-wrapper">
<div class="row">
<div class="col-md-12 grid-margin stretch-card">
<div class="card">
<div class="card-body">
<h4 class="card-title">ORDER STATUS FILTER</h4>
<form action="#" id="orderStatusChecker" name="orderStatusChecker" >
    <div class="row">

    
    <div class="col-md-4"> 
    <label>Order no:</label>
    <input name="orderform_number" type="text" class="form-control"  value="<?php echo $_GET['orderform_number'];?>" required placeholder="Order No"/>
    </div>
<!--    <div class="col-md-4"> 
    <label>Reference no:</label>
    <input name="reference_number" type="text" class="form-control"  value="<?php echo $_GET['orderform_number'];?>" placeholder="Reference No"/>
    </div>-->
    
    
<!--    <div class="col-md-3"> 
    <label>Order Type :</label>
    <select class="form-control required" id="orderform_type_id" name="orderform_type_id" > 
    <option value="">--- Select ---</option>
    <?php if($order_types){ ?>
    <?php foreach($order_types as $OT){ ?>
    <option value="<?php echo $OT['wo_type_id'];?>" <?php if($OT['wo_type_id']==$this->session->userdata('orderform_type_id')) { echo ' selected="selected"';} ?>><?php echo $OT['wo_type_name'];?></option>
    <?php } ?>
    <?php } ?>
    </select>
    </div>
   -->
    
    <div class="col-md-2"> <input type="submit" name = "submit"  style="margin-top:30px;"        value="Search"               class="btn btn-info" / >
    <a href="<?= base_url('orderstatus/orderstatus'); ?>" class="btn btn-danger" style="margin-top:30px;"><i class="fa fa-repeat"></i></a>
</div>
    </div>
    <?php echo form_close(); ?>
</div>
</div>
</div>
</div>


<div class="card">
<div class="card-body">
<?php if($this->session->flashdata('error')): ?>
<div class="alert alert-danger" style="width:100%;">
<a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">x</a>
<?=$this->session->flashdata('error')?>
</div>
<?php endif; ?>

<?php if($this->session->flashdata('success')): ?>
<div class="alert alert-success" style="width:100%;">
<a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">x</a>
<?=$this->session->flashdata('success')?>
</div>
<?php endif; ?>

<?php //echo date('Ymdhis').$this->session->has_userdata('loginid');?>
<h4 class="card-title">
<?php echo $title_head;?>

</h4>
<div class="row">
<div class="col-12 table-responsive">
<?php if(isset($_GET['submit'])): ?> 
<div style="text-align:center"><strong>Status for order  : <?php echo $_GET['orderform_number'];?></strong></div><br>
 <?php include('status_offline.php');?>
<?php endif; ?>


</div>
</div>
</div>
</div>
</div>


<script>
function wo_filter()
{
  var _form = $("#ors_search").serialize();
  $.ajax({
	  data: _form,
	  type: 'post',
	  url: '<?php echo base_url();?>orderstatus/filter',
	  async: true,
	  success: function(output){
		  table.ajax.reload( null, false );
	  }
  });
}
</script>
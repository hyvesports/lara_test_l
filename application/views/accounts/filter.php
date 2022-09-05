<div class="row">
<div class="col-md-12 grid-margin stretch-card">
<div class="card">
<div class="card-body">
<h4 class="card-title">WORK ORDER FILTER</h4>
	<?php echo form_open("/",'id="wo_search"') ?>
    <div class="row">
    <div class="col-md-2"> 
    <label>Order Date:</label>
    <input name="wo_date" type="text" class="form-control  datepicker" readonly="readonly" value="<?php echo $this->session->userdata('wo_date');?>" />
    </div>
    
    <div class="col-md-2"> 
    <label>Dispatch Date:</label>
    <input name="wo_dispatch_date" type="text" class="form-control  datepicker" readonly="readonly" value="<?php echo $this->session->userdata('wo_dispatch_date');?>" />
    </div>
    
    <div class="col-md-4"> 
    <label>Order no:</label>
    <input name="orderform_number" type="text" class="form-control"  value="<?php echo $this->session->userdata('orderform_number');?>" />
    </div>
    
    <div class="col-md-4"> 
    <label>Order Owner:</label>
    <input name="wo_staff_name" type="text" class="form-control"  value="<?php echo $this->session->userdata('wo_staff_name');?>" />
    </div>
    
    <div class="col-md-3"> 
    <label>Customer:</label>
    <input name="wo_customer_name" type="text" class="form-control "  value="<?php echo $this->session->userdata('wo_customer_name');?>" />
    </div>
    
    <div class="col-md-3"> 
    <label>Priority :</label>
    <select class="form-control required" id="wo_work_priority_id" name="wo_work_priority_id"  > 
    <option value="">--- Select ---</option>
    <?php if($priority){ ?>
    <?php foreach($priority as $prty){ ?>
    <option value="<?php echo $prty['priority_id'];?>"  <?php if($prty['priority_id']==$this->session->userdata('wo_work_priority_id')) { echo ' selected="selected"';} ?>  ><?php echo $prty['priority_name'];?></option>
    <?php } ?>
    <?php } ?>
    </select>
    </div>
    
    <div class="col-md-3"> 
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
   
    
    <div class="col-md-2"> <button type="button" style="margin-top:30px;" onclick="wo_filter()" class="btn btn-info">Submit</button>
    <a href="<?= base_url('workorder/index'); ?>" class="btn btn-danger" style="margin-top:30px;"><i class="fa fa-repeat"></i></a>
</div>
    </div>
    <?php echo form_close(); ?>
</div>
</div>
</div>
</div>
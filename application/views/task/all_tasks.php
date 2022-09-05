<div class="container-fluid page-body-wrapper">

      <div class="main-panel">

        <div class="content-wrapper">

        <div class="row">

<div class="col-md-12 grid-margin stretch-card">

<div class="card">

<div class="card-body">

<?php if(isset($msg) || validation_errors() !== ''): ?>

<div class="alert alert-warning alert-dismissible" style="width:100%;">

<button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>

<h4><i class="icon fa fa-warning"></i> Alert!</h4>

<?php echo validation_errors();?>

<?php isset($msg)? $msg: ''; ?>

</div>

<?php endif; ?>



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

<h4 class="card-title">Create Task

<span style="text-align:right; float:right;"><a class="btn btn-primary " href="<?php echo base_url('leads/index');?>">All Leads</a></span> 

</h4>



<?php echo form_open(base_url('leads/task/'.$lead_info['lead_uuid']), 'class="cmxform"  id="taskForm" method="post"'); ?>

    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">

    <input type="hidden" name="lead_id"  id="lead_id" value="<?php echo $lead_info['lead_id'];?>" />

    <div class="row">

    

    <div class="col-md-12">

    <label>Task <span class="text-danger">*</span></label>

     <input type="text" class="form-control required mb-2" name="task_desc" id="task_desc"   >

    </div>

    <div class="col-md-3">

    <label>Reminder Date <span class="text-danger">*</span></label>

     <div id="datepicker-popup" class="input-group date datepicker">

	<input type="text" class="form-control required"  name="reminder_date"  id="reminder_date"  value="<?php echo date("d-m-Y");?>">

	<span class="input-group-addon input-group-append border-left">

	<span class="icon-calendar input-group-text"></span>

	</span>

	</div>

    

    </div>

    <?php

	$timezone='Asia/Kolkata';

	date_default_timezone_set($timezone);

	$ctimee= date("h:i A");

	?>

    <div class="col-md-3">

    <label>Reminder Time <span class="text-danger">*</span></label>

    <div class="input-group date" id="timepicker-example" data-target-input="nearest">

                        <div class="input-group" data-target="#timepicker-example" data-toggle="datetimepicker">

                          <input type="text" class="form-control datetimepicker-input required" name="reminder_time"  id="reminder_time" data-target="#timepicker-example" value="<?php echo $ctimee;?>">

                          <div class="input-group-addon input-group-append"><i class="icon-clock input-group-text"></i></div>

                        </div>

                      </div>

    </div>

    <div class="col-md-6"> <button type="submit" style="margin-top:30px; width:100%;"  class="btn btn-info" id="submitData" name="submitData" value="submitData">Save Task</button>

    </div>

    </div>

    </form>

</div>

</div>

</div>

</div>

<?php if($all_tasks){ ?> 

<div class="row">

<div class="col-lg-12 grid-margin stretch-card">

              <div class="card">

                <div class="card-body">

                  <h4 class="card-title">Task List</h4>

                 

                  <div class="table-responsive">

                    <table class="table table-hover">

                      <thead>

                        <tr>

                          <th width="70%">Task</th>

                          <th width="15%">Reminder Date & Time</th>

                          <th width="15%">Action</th>

                         

                        </tr>

                      </thead>

                      <tbody>

                      <?php foreach($all_tasks as $TSK){ ?>

                        <tr>

                          <td><?php echo $TSK['task_desc'];?></td>

                          <td><small class="text-muted ml-4">

                       <em> <?php echo date("d-m-Y",strtotime($TSK['reminder_date']));?>, <?php echo $TSK['reminder_time'];?></em>

                      </small></td>

                         

                          <td>

                          <a href="<?php echo base_url('leads/task_edit/'.$TSK['task_uuid']);?>"><label class="badge badge-warning" style="cursor: pointer;">Edit</label></a>

                          <a href="<?php echo base_url('leads/task_remove/'.$TSK['task_uuid']);?>" onclick="return  deleteRow();"><label  style="cursor: pointer;" class="badge badge-danger">Delete</label></a>

                          </td>

                        </tr>

                        <?php } ?>

                      </tbody>

                    </table>

                  </div>

                </div>

              </div>

            </div>      

</div>

<?php } ?>

        </div>

      </div>

    </div>

    

    

    

    <script>

	function deleteRow(){

	  if(confirm("Are you sure you want to delete.?")){

		  return true;

	  }

	  return false;

}

      $(function(){

				 

				 

		$('#datepicker-popup').datepicker({

		enableOnReadonly: true,

		todayHighlight: true,

		format :'dd-mm-yyyy',

		startDate: "<?php echo date('d-m-Y');?>"

		});

   

				 

				 

		$('#timepicker-example').datetimepicker({

		  format: 'h:mm A',

		   minDate:moment(),

			maxDate:false,

		});





$("#taskForm").validate({

highlight: function(element) {

$(element).closest('.form-control').removeClass('is-valid').addClass('is-invalid');

},

unhighlight: function(element) {

$(element).closest('.form-control').removeClass('is-invalid').addClass('is-valid');

},

errorElement: 'p',

errorClass: 'text-danger',

errorPlacement: function(error, element) {

if (element.parent('.input-group').length || element.parent('label').length) {

error.insertAfter(element.parent());

} else {

error.insertAfter(element);

}

},



});      



      });

    </script>
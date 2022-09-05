<div class="container-fluid page-body-wrapper">
      <div class="main-panel">
        <div class="content-wrapper">
        <div class="row">
<div class="col-md-12 grid-margin stretch-card">
<div class="card">
<div class="card-body">
<h4 class="card-title">Create Task</h4>
	<form action="post" id="taskForm" name="taskForm">
    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
    <div class="row">
    <div class="col-md-2">
    <label>Reminder Date  <span class="text-danger">*</span></label>
	<input type="text" class="form-control required"   name="reminder_date" id="reminder_date"  value="<?php echo date('d-m-Y');?>" readonly="readonly"/>
    </div>
    
    <div class="col-md-2">
    <label>Reminder Time <span class="text-danger">*</span></label>
	
    <div class="input-group date form_datetime "   data-date-format="dd MM yyyy - HH:ii p" data-link-field="dtp_input1">
    <input class="form-control required" size="16" type="text"  name="reminder_time"  id="reminder_time">
    <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
    <span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
    </div>
    <input type="hidden" id="dtp_input1" value="" /><br/>
    </div>
    
    <div class="col-md-7">
    <label>Task <span class="text-danger">*</span></label>
     <input type="text" class="form-control required" name="end_date" id="end_date"   >
    </div>
    
     
    <div class="col-md-2"> <button type="submit" style="margin-top:30px; width:100%;"  class="btn btn-info" id="submitData" name="submitData">Save Task</button>
    </div>
    </div>
    </form>
</div>
</div>
</div>
</div>
        
          <div class="row">
            <div class="col-lg-12">
              <div class="card px-3">
                <div class="card-body">
                  <h4 class="card-title">Todo list</h4>
                  <div class="add-items d-flex">
                    <input type="text" class="form-control todo-list-input" placeholder="What do you need to do today?">
                    <button class="add btn btn-primary font-weight-bold todo-list-add-btn" id="add-task">Add</button>
                  </div>
                  <div class="list-wrapper">
                    <ul class="d-flex flex-column-reverse todo-list">
                      <li>
                        <div class="form-check">
                          <label class="form-check-label">
                            <input class="checkbox" type="checkbox">
                            Meeting with Alisa
                          </label>
                        </div>
                        <i class="remove icon-close"></i>
                      </li>
                      <li class="completed">
                        <div class="form-check">
                          <label class="form-check-label">
                            <input class="checkbox" type="checkbox" checked="">
                            Call John
                          </label>
                        </div>
                        <i class="remove icon-close"></i>
                      </li>
                      <li>
                        <div class="form-check">
                          <label class="form-check-label">
                            <input class="checkbox" type="checkbox">
                            Create invoice
                          </label>
                        </div>
                        <i class="remove icon-close"></i>
                      </li>
                      <li>
                        <div class="form-check">
                          <label class="form-check-label">
                            <input class="checkbox" type="checkbox">
                            Print Statements
                          </label>
                        </div>
                        <i class="remove icon-close"></i>
                      </li>
                      <li class="completed">
                        <div class="form-check">
                          <label class="form-check-label">
                            <input class="checkbox" type="checkbox" checked="">
                            Prepare for presentation
                          </label>
                        </div>
                        <i class="remove icon-close"></i>
                      </li>
                      <li>
                        <div class="form-check">
                          <label class="form-check-label">
                            <input class="checkbox" type="checkbox">
                            Pick up kids from school
                          </label>
                        </div>
                        <i class="remove icon-close"></i>
                      </li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- content-wrapper ends -->
        <!-- partial:../../partials/_footer.html -->
        <footer class="footer">
          <div class="w-100 clearfix">
            <span class="text-muted d-block text-center text-sm-left d-sm-inline-block">Copyright © 2018 <a href="http://www.bootstrapdash.com/" target="_blank">Bootstrapdash</a>. All rights reserved.</span>
            <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">Hand-crafted & made with <i class="icon-heart text-danger"></i></span>
          </div>
        </footer>
        <!-- partial -->
      </div>
      <!-- main-panel ends -->
    </div>
    
    
    
    <script>
      $(function(){
		$('#reminder_date').datepicker({ 
		format: 'dd-mm-yyyy',
		startDate: "<?php echo date('d-m-Y');?>" }
		);
		
		$('.form_datetime').datetimepicker({
        //language:  'fr',
         format: 'LT'
		minDate:1,
		maxDate:1
		
    });		
      });
    </script>
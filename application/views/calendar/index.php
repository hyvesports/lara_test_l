<div class="content-wrapper">
<div class="row">
<div class="col-md-12 grid-margin stretch-card">
<div class="card">
<div class="card-body">
<h4 class="card-title">calendar FILTER</h4>
	<?php echo form_open("/",'id="search"') ?>
    <div class="row">
    
    
    <div class="col-md-4">
     <label>Year:</label>
     <select class="form-control required" id="calendar_year" name="calendar_year" > 
    <option value="">--- Select ---</option>
    <option value="<?php echo date('Y', strtotime('-1 year')); ?>"  <?php if(date('Y', strtotime('-1 year'))==$this->session->userdata('calendar_year')){ echo 'selected="selected"';}?> ><?php echo date('Y', strtotime('-1 year')); ?></option>
    <option value="<?php echo date('Y');?>" <?php if(date('Y')==$this->session->userdata('calendar_year')){ echo 'selected="selected"';}?>><?php echo date('Y');?></option>
    <option value="<?php echo date('Y', strtotime('+1 year')); ?>" <?php if(date('Y', strtotime('+1 year'))==$this->session->userdata('calendar_year')){ echo 'selected="selected"';}?>><?php echo date('Y', strtotime('+1 year')); ?></option>
    </select>
     </div>
     
     
    <div class="col-md-4">
     <label>Month:</label>
     <select class="form-control required" id="calendar_month" name="calendar_month"> 
<option value="">--- Select ---</option>
    
    <option value='01' <?php if('01'==$this->session->userdata('calendar_month')){ echo 'selected="selected"';}?> >Janaury</option>
    <option value='02' <?php if('02'==$this->session->userdata('calendar_month')){ echo 'selected="selected"';}?>>February</option>
    <option value='03' <?php if('03'==$this->session->userdata('calendar_month')){ echo 'selected="selected"';}?>>March</option>
    <option value='04' <?php if('04'==$this->session->userdata('calendar_month')){ echo 'selected="selected"';}?>>April</option>
    <option value='05' <?php if('05'==$this->session->userdata('calendar_month')){ echo 'selected="selected"';}?>>May</option>
    <option value='06' <?php if('06'==$this->session->userdata('calendar_month')){ echo 'selected="selected"';}?>>June</option>
    <option value='07' <?php if('07'==$this->session->userdata('calendar_month')){ echo 'selected="selected"';}?>>July</option>
    <option value='08' <?php if('08'==$this->session->userdata('calendar_month')){ echo 'selected="selected"';}?>>August</option>
    <option value='09' <?php if('09'==$this->session->userdata('calendar_month')){ echo 'selected="selected"';}?>>September</option>
    <option value='10' <?php if('10'==$this->session->userdata('calendar_month')){ echo 'selected="selected"';}?>>October</option>
    <option value='11' <?php if('11'==$this->session->userdata('calendar_month')){ echo 'selected="selected"';}?>>November</option>
    <option value='12' <?php if('12'==$this->session->userdata('calendar_month')){ echo 'selected="selected"';}?>>December</option>

</select>
     </div>
    



    
    
    <div class="col-md-4"> <button type="button" style="margin-top:30px;" onclick="filter()" class="btn btn-info">Submit</button>
    <a href="<?= base_url('calendar/reset_filter'); ?>" class="btn btn-danger" style="margin-top:30px;"><i class="fa fa-repeat"></i> Reset</a>
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


<h4 class="card-title"><?php echo $title_head;?>
<?php if($accessArray){if(in_array("add",$accessArray)){ ?>
<span style="text-align:right; float:right;"><a class="btn btn-primary " href="<?php echo base_url('calendar/add');?>">ADD NEW</a></span>
<?php } } ?>
</h4>
<div class="row">
<div class="col-12 table-responsive">
<table id="listing" class="table" width="100%">
<thead>
<tr wi>
<th width="6%">No:</th>
<th width="30%">Month & Year</th>
<th width="20%">No Of Days</th>


<th width="13%" class="text-center">Actions</th>
</tr>
</thead>

<tbody>
<?php if($results){ $i=0; ?>
<?php foreach($results as $rslt){ $i++;?>
<tr>
<td><?php echo $i;?></td>
<td><?php echo $month_and_year=date("F Y", strtotime($rslt['calendar_date']));?> <?php //echo strtotime($rslt['calendar_date']);?></td>
<td><?php echo $data['no_of_days']=$this->calendar_model->days_in_month($rslt['calendar_month'],$rslt['calendar_year']);?></td>
<td style="text-align:center;">

<?php if($accessArray){if(in_array("add",$accessArray)){ ?>
<a href="<?php echo base_url('calendar/capacity/'.strtotime($rslt['calendar_date']));?>" title="Edit" style="cursor: pointer;"><label class="badge badge-info" style="cursor: pointer;"><i class="fa fa-gavel" ></i> Set Departments Capacity</label></a>
<?php } } ?>

<?php if($accessArray){if(in_array("view",$accessArray)){ ?>
<a href="<?php echo base_url('calendar/view/'.strtotime($rslt['calendar_date']));?>" title="View" style="cursor: pointer;"><label class="badge badge-success" style="cursor: pointer;"><i class="fa fa-search" ></i></label></a>
<?php } } ?>


<?php if($accessArray){if(in_array("edit",$accessArray)){ ?>
<a href="<?php echo base_url('calendar/edit/'.strtotime($rslt['calendar_date']));?>" title="Edit" style="cursor: pointer;"><label class="badge badge-warning" style="cursor: pointer;"><i class="fa fa-pencil" ></i></label></a>
<?php } } ?>

<?php if($accessArray){if(in_array("delete",$accessArray)){ ?>
<a title="Delete" class="" href="<?php echo base_url('calendar/delete/'.strtotime($rslt['calendar_date']));?>" onclick="return confirm('are you sure to delete?')"><label class="badge badge-danger" style="cursor: pointer;"><i class="fa fa-trash" ></i></label> </a>
<?php } } ?>

</td>
</tr>
<?php }} ?>

</tbody>
</table>
</div>
</div>
</div>
</div>
</div>

        <script>
		
		function filter()
  {
    var _form = $("#search").serialize();
    $.ajax({
        data: _form,
        type: 'post',
        url: '<?php echo base_url();?>calendar/filter',
        async: true,
        success: function(output){
           location.reload();
        }
    });
  }
		 $(function() {
    $('#listing').DataTable({
      "aLengthMenu": [
        [5, 10, 15, -1],
        [5, 10, 15, "All"]
      ],
      "iDisplayLength": 10,
      "language": {
        search: ""
      }
    });
    $('#listing').each(function() {
      var datatable = $(this);
      // SEARCH - Add the placeholder for Search and Turn this into in-line form control
      var search_input = datatable.closest('.dataTables_wrapper').find('div[id$=_filter] input');
      search_input.attr('placeholder', 'Search');
      search_input.removeClass('form-control-sm');
      // LENGTH - Inline-Form control
      var length_sel = datatable.closest('.dataTables_wrapper').find('div[id$=_length] select');
      length_sel.removeClass('form-control-sm');
    });
  });
		</script>


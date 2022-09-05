<style>
  .fs-30 {
  font-size: 30px;
  }
  .cardWo {
    height: 100%;
  max-height: 390px;
  overflow: scroll;
  }
</style>
<?php $woArrayFinalQc=$this->dashboard_model->get_wo_from_pending_finalqc('13',$selectedDate);?>
<?php $woArrayFinalQcc=$this->dashboard_model->get_wo_from_completed_finalqc('13',$selectedDate);?>
<div class="row">
  
  <div class="col-md-4 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
	<p class="card-title mb-0">Final QC</p>
	
	<div class="row">
	  
          <div class="col-md-12 pl-md-1 pt-4 pt-md-0">
	    
            <ul class="nav nav-tabs tab-basic" role="tablist">
              <li class="nav-item">
                <a class="nav-link" id="finalqc-p-tab" data-toggle="tab" href="#finalqcp" role="tab" aria-controls="finalqcp" aria-selected="true">Pending</a>
              </li>
              <li class="nav-item">
                <a class="nav-link active" id="finalqc-c-tab" data-toggle="tab" href="#finalqcc" role="tab" aria-controls="finalqcc" aria-selected="false">Today</a>
              </li>
            </ul>
	    
            <div class="tab-content tab-content-basic"  >
              <div class="tab-pane fade" id="finalqcp" role="tabpanel" aria-labelledby="finalqc-p-tab" >
		
		<div class="table-responsive ">
		  <table class="table table-striped table-borderless finalqcaccdis" id="finalqc">
		    <thead>
		      <tr>
			<th>Order No:</th>
			<th>Date</th>
			<th>Qty</th>
		      </tr>  
		    </thead>
		    <tbody>
		      <?php if($woArrayFinalQc){ ?>
		      <?php foreach($woArrayFinalQc as $ODS){
		      ?>
		      <tr  class="m-1">
			<td class="font-weight-bold"><div class="badge badge-success"><?php echo $ODS['orderform_number'];?></div></td>
            <td><?php echo $ODS['date'];?></td>
            <td><?php echo $ODS['TOTAL_COUNT'];?></td>
		      </tr>
		      <?php } ?>

		      <?php } ?>
		      
		      
		      
		    </tbody>
		  </table>
		</div>
	      </div>
	      
	      <div class="tab-pane fade show active" id="finalqcc" role="tabpanel" aria-labelledby="finalqc-c-tab">
		<div class="table-responsive ">
		  <table class="table table-striped table-borderless finalqcaccdis" id="finalqc">
		    <thead>
		      <tr>
			<th>Order No:</th>
			<th>Date</th>
			<th>Qty</th>
		      </tr>  
		    </thead>
		    <tbody>
		      <?php if($woArrayFinalQcc){ ?>
		      <?php foreach($woArrayFinalQcc as $ODSC){
		      ?>
		      <tr  class="m-1">
			<td class="font-weight-bold"><div class="badge badge-<?php echo $ODSC['order_scheduled_color'];?>"><?php echo $ODSC['orderform_number'];?></div></td>
            <td><?php echo $ODSC['date'];?></td>
            <td><?php echo $ODSC['TOTAL_COUNT'];?></td>
		      </tr>
		      <?php } ?>

		      <?php } ?>
		      
		      
		      
		    </tbody>
		  </table>
		</div>
	      </div>
	    </div>
	  </div>
	</div>
	
	
      </div>
    </div>
  </div>
  
  <div class="col-md-4  grid-margin  stretch-card">
    <?php $woArrayAccountsPending=$this->dashboard_model->get_wo_pending_with_accounts($selectedDate);?>
    <div class="card">
      <div class="card-body">
        <p class="card-title mb-0">Accounts </p>
	<div class="row">
	  <div class="col-md-12 pl-md-1 pt-4 pt-md-0">
            <ul class="nav nav-tabs tab-basic" role="tablist">
	      <li class="nav-item">
                <a class="nav-link active" id="accounts-p-tab" data-toggle="tab" href="#accountsp" role="tab" aria-controls="accountsp" aria-selected="true">Pending</a>
	      </li>
	      <li class="nav-item">
                <a class="nav-link" id="accounts-c-tab" data-toggle="tab" href="#accountsc" role="tab" aria-controls="accountsc" aria-selected="false">Completed</a>
	      </li>
            </ul>
	    
            <div class="tab-content tab-content-basic"  >
	      <div class="tab-pane fade show active" id="accountsp" role="tabpanel" aria-labelledby="accounts-p-tab" >
		<div class="table-responsive ">
		  <table class="table table-striped table-borderless finalqcaccdis" id="accounts_pending_list">
		    <thead>
		      <tr>
			<th>Order No:</th>
			<th>Amount</th>
		      </tr>  
		    </thead>
		    <tbody>
		      <?php if($woArrayAccountsPending){ ?>
		      <?php foreach($woArrayAccountsPending as $ACP){
			    ?>
		      <tr  class="m-1">
			<td class="font-weight-bold"><div class="badge badge-success"><?php echo $ACP['orderform_number'];?></div></td>
			<td><?php echo $ACP['wo_gross_cost'];?></td>
		      </tr>
		      
		      <?php } ?>
		      <?php } ?>
		    </tbody>
		  </table>
		</div>
	      </div>
    <?php $woArrayAccountsCompleted=$this->dashboard_model->get_wo_completed_with_accounts($selectedDate);?>
	      
	      <div class="tab-pane fade " id="accountsc" role="tabpanel" aria-labelledby="accounts-c-tab" >
		<div class="table-responsive ">
		  <table class="table table-striped table-borderless finalqcaccdis" id="accounts_pending_list">
		      <thead>
			<tr>
			  <th>Order No:</th>
			  <th>Amount</th>
			</tr>  
		      </thead>
		      		    <tbody>
		      <?php if($woArrayAccountsCompleted){ ?>
		      <?php foreach($woArrayAccountsCompleted as $ACC){
			    ?>
		      <tr  class="m-1">
			<td class="font-weight-bold"><div class="badge badge-success"><?php echo $ACC['orderform_number'];?></div></td>
			<td><?php echo $ACC['wo_gross_cost'];?></td>
		      </tr>
		      
		      <?php } ?>
		      <?php } ?>
		    </tbody>
		    </table>
		  </div>
		</div>
	      </div>
	    </div>
	  </div>

	  
	</div>
      </div>
    </div>



	<div class="col-md-4  grid-margin  stretch-card">
	<?php $woDispatchUnit=$this->dashboard_model->get_dispatch_pending_orders($selectedDate);?>
    <div class="card">
        <div class="card-body">
        <p class="card-title mb-0">Dispatch</p>
	<div class="row">
	  <div class="col-md-12 pl-md-1 pt-4 pt-md-0">
            <ul class="nav nav-tabs tab-basic" role="tablist">
	      <li class="nav-item">
                <a class="nav-link active" id="accounts-p-tab" data-toggle="tab" href="#disaptchp" role="tab" aria-controls="dispatchp" aria-selected="true">Pending</a>
	      </li>
            </ul>
	    
            <div class="tab-content tab-content-basic"  >
	      <div class="tab-pane fade show active" id="dispatchp" role="tabpanel" aria-labelledby="dispatch-p-tab" >
        <div class="table-responsive ">
        <table class="table table-striped table-borderless finalqcaccdis" id="accounts_pending_list">
        <thead>
        <tr>
        <th>Order No:</th>
        <th>Date</th>
        <th>Qty</th>
        </tr>  
        </thead>
        <tbody>
        <?php if($woDispatchUnit){ ?>
        <?php foreach($woDispatchUnit as $ODSU){
?>
            <tr  class="m-1">
            <td class="font-weight-bold"><div class="badge badge-success"><?php echo $ODSU['orderform_number'];?></div></td>
            <td><?php echo $ODSU['date'];?></td>
            <td><?php echo $ODSU['TOTAL_COUNT'];?></td>
            </tr>
            <?php } ?>
            <?php } ?>

        </tbody>
        </table>
        </div>
        </div>
        </div>
        </div>
        </div>
    
    
        </div>
    </div>
    </div>

</div>
<script>
(function($) {
'use strict';
$(function() {
$('.finalqcaccdis').DataTable({
"aLengthMenu": [
[10, 15, 25, -1],
[10, 15, 25, "All"]
],
"iDisplayLength": 10,
"language": {
search: ""
}
});
$('.finalqcaccdis').each(function() {
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
})(jQuery);
</script>

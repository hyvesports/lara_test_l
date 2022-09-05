<style>
  .fs-30 {
  font-size: 30px;
  }
  .cardWo {
    height: 100%;
  max-height: 390px;
  overflow: scroll;
  }
  
  .tab-basic .nav-item .nav-link{
    margin:1em auto;
  }
</style>

<div class="row">
  
  <div class="col-md-4 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
	  <p class="card-title mb-0 float-left">Final QC</p>
	<a href="javascript:void(0)" class="btn btn-info btn-xs float-right"  id="finalqc-ref"><i class="fa fa-refresh" aria-hidden="true">
Load </i></a>
<div class="clearfix"></div>
	
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
		  <table class="table table-striped table-borderless finalqcTable" id="finalqcTable">
		    <thead>
		      <tr>
			<th>Order No:</th>
			<th>Qty</th>
						<th>Date</th>

		      </tr>  
		    </thead>
		   
		  </table>
		</div>
	      </div>
	      
	      <div class="tab-pane fade show active" id="finalqcc" role="tabpanel" aria-labelledby="finalqc-c-tab">
		<div class="table-responsive ">
		  <table class="table table-striped table-borderless finalqcTablec" id="finalqcTablec">
		    <thead>
		      <tr>
			<th>Order No:</th>
						<th>Qty</th>
			<th>Date</th>

		      </tr>  
		    </thead>
		   
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

    <div class="card">
      <div class="card-body">
           <p class="card-title mb-0 float-left">Accounts</p>
	<a href="javascript:void(0)" class="btn btn-info btn-xs float-right"  id="accounts-ref"><i class="fa fa-refresh" aria-hidden="true">
Load </i></a>
<div class="clearfix"></div>
     
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
		  <table class="table table-striped table-borderless accounts_pending_list" id="accounts_pending_list">
		    <thead>
		      <tr>
			<th>Order No:</th>
			<th>Amount</th>
		      </tr>  
		    </thead>
		   
		  </table>
		</div>
	      </div>

	      
	      <div class="tab-pane fade " id="accountsc" role="tabpanel" aria-labelledby="accounts-c-tab" >
		<div class="table-responsive ">
		  <table class="table table-striped table-borderless accounts_completed_list" id="accounts_completed_list">
		      <thead>
			<tr>
			  <th>Order No:</th>
			  <th>Amount</th>
			</tr>  
		      </thead>
		      		
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

    <div class="card">
        <div class="card-body">
        <p class="card-title mb-0 float-left">Dispatch</p>
        	<a href="javascript:void(0)" class="btn btn-info btn-xs float-right"  id="disaptch-ref"><i class="fa fa-refresh" aria-hidden="true">
Load </i></a>
<div class="clearfix"></div>
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
        <table class="table table-striped table-borderless dispatchTable" id="dispatchTable">
        <thead>
        <tr>
        <th>Order No:</th>
        <th>Qty</th>
	        <th>Date</th>

        </tr>  
        </thead>
      
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
 $("#accounts-ref").click(function() {

var newUrlS = "<?= base_url('myaccount/get_wo_pending_with_accounts/'.$selectedDate) ;?>";
accounts_pending_list.ajax.url(newUrlS).load();

var newUrlSc = "<?= base_url('myaccount/get_wo_completed_with_accounts/'.$selectedDate) ;?>";
accounts_completed_list.ajax.url(newUrlSc).load();
});

 $("#finalqc-ref").click(function() {

var newUrlAp = "<?= base_url('myaccount/get_wo_from_pending_finalqc/13/'.$selectedDate) ;?>";
finalqcTable.ajax.url(newUrlAp).load();

var newUrlAc = "<?= base_url('myaccount/get_wo_from_completed_finalqc/13/'.$selectedDate) ;?>";
finalqcTablec.ajax.url(newUrlAc).load();
});


$("#disaptch-ref").click(function() {

var newUrlDis = "<?= base_url('myaccount/get_dispatch_pending_orders/'.$selectedDate) ;?>";
dispatchTable.ajax.url(newUrlDis).load();


});

var dispatchTable = $("#dispatchTable").DataTable({
    pageLength: 10,
    lengthMenu: [10, 20, 30, 40, 50],
    responsive: true,
    order: [2, 'asc'],
    paging: true,
    searching: true,
    processing: true,
    info: true,
    data: [],
    columns: [{
        data: "orderform_number"
      },
      {
        data: "TOTAL_COUNT"
      },
      {
        data: "date"
      }
    ]
  });

  var finalqcTable = $("#finalqcTable").DataTable({
    pageLength: 10,
    lengthMenu: [10, 20, 30, 40, 50],
    responsive: true,
    order: [2, 'asc'],
    paging: true,
    searching: true,
    processing: true,
    info: true,
    data: [],
    columns: [{
        data: "orderform_number"
      },
      {
        data: "TOTAL_COUNT"
      },
      {
        data: "date"
      }
    ]
  });

  var finalqcTablec = $("#finalqcTablec").DataTable({
    pageLength: 10,
    lengthMenu: [10, 20, 30, 40, 50],
    responsive: true,
    order: [2, 'asc'],
    paging: true,
    searching: true,
    processing: true,
    info: true,
    data: [],
    columns: [{
        data: "orderform_number"
      },
      {
        data: "TOTAL_COUNT"
      },
      {
        data: "date"
      }
    ]
  });


var accounts_pending_list = $("#accounts_pending_list").DataTable({
    pageLength: 10,
    lengthMenu: [10, 20, 30, 40, 50],
    responsive: true,
    order: [1, 'asc'],
    paging: true,
    searching: true,
    processing: true,
    info: true,
    data: [],
    columns: [{
        data: "orderform_number"
      },
      {
        data: "amount"
      }
    ]
  });

  var accounts_completed_list = $("#accounts_completed_list").DataTable({
    pageLength: 10,
    lengthMenu: [10, 20, 30, 40, 50],
    responsive: true,
    order: [1, 'asc'],
    paging: true,
    searching: true,
    processing: true,
    info: true,
    data: [],
    columns: [{
        data: "orderform_number"
      },
      {
        data: "amount"
      }
    ]
  });




});
})(jQuery);
</script>
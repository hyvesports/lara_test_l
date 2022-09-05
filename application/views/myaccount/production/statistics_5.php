<style>
.fs-30 {
  font-size: 30px;
}
.cardWo {
    height: 100%;
    max-height: 390px;
    overflow: scroll;
}

.tab-basic .nav-item .nav-link.active{
    margin:1em auto;
  }
</style>

<div class="row">
  
  <div class="col-md-4 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
	<p class="card-title mb-0 float-left">Fusing </p>
	<a href="javascript:void(0)" class="btn btn-info btn-xs float-right"  id="fusing-ref"><i class="fa fa-refresh" aria-hidden="true">
Load </i></a>
<div class="clearfix"></div>
	<div class="row">
          <div class="col-md-12 pl-md-1 pt-4 pt-md-0">
	    
            <ul class="nav nav-tabs tab-basic" role="tablist" >
              <li class="nav-item">
                <a class="nav-link " id="fusing-p-tab" data-toggle="tab" href="#fusingp" role="tab" aria-controls="fusingp" aria-selected="true">Pending</a>
              </li>
              <li class="nav-item">
                <a class="nav-link active" id="fusing-c-tab" data-toggle="tab" href="#fusingc" role="tab" aria-controls="fusingc" aria-selected="false">Today</a>
              </li>
            </ul>
	    
            <div class="tab-content tab-content-basic"  >
              <div class="tab-pane fade" id="fusingp" role="tabpanel" aria-labelledby="fusing-p-tab" >
		
		
		<div class="table-responsive ">
		  <table class="table table-striped table-borderless fusingTable" id="fusingTable">
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
	      <div class="tab-pane fade show active" id="fusingc" role="tabpanel" aria-labelledby="fusing-c-tab">
		<div class="table-responsive ">
		  <table class="table table-striped table-borderless fusingTablec" id="fusingTablec">
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
	  <p class="card-title mb-0 float-left">Bundling QC</p>
		<a href="javascript:void(0)" class="btn btn-info btn-xs float-right"  id="bundling-ref"><i class="fa fa-refresh" aria-hidden="true">
Load </i></a>
<div class="clearfix"></div>
        
	<div class="row">
          <div class="col-md-12 pl-md-1 pt-4 pt-md-0">
	    
            <ul class="nav nav-tabs tab-basic" role="tablist" >
              <li class="nav-item">
             <a class="nav-link " id="bundling-p-tab" data-toggle="tab" href="#bundlingp" role="tab" aria-controls="bundlingp" aria-selected="true">Pending</a>
              </li>
              <li class="nav-item">
                <a class="nav-link active" id="bundling-c-tab" data-toggle="tab" href="#bundlingc" role="tab" aria-controls="bundlingc" aria-selected="false">Today</a>
              </li>
            </ul>
	    
            <div class="tab-content tab-content-basic"  >
              <div class="tab-pane fade" id="bundlingp" role="tabpanel" aria-labelledby="bundling-p-tab" >
		<div class="table-responsive ">
		  <table class="table table-striped table-borderless bundlingTable" id="bundlingTable">
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
	          
	      <div class="tab-pane fade show active" id="bundlingc" role="tabpanel" aria-labelledby="bundling-c-tab">
		<div class="table-responsive ">
		  <table class="table table-striped table-borderless bundlingTablec" id="bundlingTablec">
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
		<p class="card-title mb-0 float-left">Stitching</p>
		<a href="javascript:void(0)" class="btn btn-info btn-xs float-right"  id="stiching-ref"><i class="fa fa-refresh" aria-hidden="true">
Load </i></a>
<div class="clearfix"></div>
     

 <div class="row">
           <div class="col-md-12 pl-md-1 pt-4 pt-md-0">

             <ul class="nav nav-tabs tab-basic" role="tablist" >
               <li class="nav-item">
                 <a class="nav-link " id="stiching-p-tab" data-toggle="tab" href="#stichingp" role="tab" aria-controls="stichingp" aria-selected="true">Pending</a>
               </li>
               <li class="nav-item">
                 <a class="nav-link active" id="stiching-c-tab" data-toggle="tab" href="#stichingc" role="tab" aria-controls="stichingc" aria-selected="false">Today</a>
               </li>
             </ul>

             <div class="tab-content tab-content-basic"  >
               <div class="tab-pane fade" id="stichingp" role="tabpanel" aria-labelledby="stiching-p-tab" >

        <div class="table-responsive ">
        <table class="table table-striped table-borderless stichingTable" id="stichingTable">
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
    
<div class="tab-pane fade show active" id="stichingc" role="tabpanel" aria-labelledby="stiching-c-tab">
        <div class="table-responsive ">
        <table class="table table-striped table-borderless stichingTablec" id="stichingTablec">
        <thead>
        <tr>
        <th>Order Nos:</th>
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
  $(document).ready(function() {
		$("#fusing-ref").click(function() {

		var newUrl = "<?= base_url('myaccount/get_works_fusing/6/'.$selectedDate.'/pending') ;?>";
		fusingTable.ajax.url(newUrl).load();

		var newUrlc = "<?= base_url('myaccount/get_works_fusing/6/'.$selectedDate.'/today') ;?>";
		fusingTablec.ajax.url(newUrlc).load();
		});

    $("#bundling-ref").click(function() {

var newUrlQc = "<?= base_url('myaccount/get_works_bundling/12/'.$selectedDate.'/pending') ;?>";
bundlingTable.ajax.url(newUrlQc).load();
var newUrlQcc = "<?= base_url('myaccount/get_works_bundling/12/'.$selectedDate.'/today') ;?>";
bundlingTablec.ajax.url(newUrlQcc).load();

});
$("#stiching-ref").click(function() {

var newUrlS = "<?= base_url('myaccount/get_works_stitching/8/'.$selectedDate.'/pending') ;?>";
stichingTable.ajax.url(newUrlS).load();
var newUrlSc = "<?= base_url('myaccount/get_works_stitching/8/'.$selectedDate.'/today') ;?>";
stichingTablec.ajax.url(newUrlSc).load();

});

  var fusingTable = $("#fusingTable").DataTable({
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


  var bundlingTable = $("#bundlingTable").DataTable({
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


  var stichingTable = $("#stichingTable").DataTable({
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
  var fusingTablec = $("#fusingTablec").DataTable({
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


  var bundlingTablec = $("#bundlingTablec").DataTable({
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


  var stichingTablec = $("#stichingTablec").DataTable({
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
});
</script>


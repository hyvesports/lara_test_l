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
    <p class="card-title mb-0 float-left">Designing </p>
    <a href="javascript:void(0)" class="btn btn-info btn-xs float-right"  id="design-ref"><i class="fa fa-refresh" aria-hidden="true">
Load </i></a>
<div class="clearfix"></div>

 <div class="row">

	   <div class="col-md-12 pl-md-1 pt-4 pt-md-0">

	     <ul class="nav nav-tabs tab-basic" role="tablist">
	       <li class="nav-item">
		 <a class="nav-link" id="design-p-tab" data-toggle="tab" href="#designp" role="tab" aria-controls="designp" aria-selected="true">Pending</a>
	       </li>
	       <li class="nav-item">
		 <a class="nav-link active" id="design-c-tab" data-toggle="tab" href="#designc" role="tab" aria-controls="designc" aria-selected="false">Today</a>
	       </li>
	     </ul>

	     <div class="tab-content tab-content-basic"  >
	       <div class="tab-pane fade" id="designp" role="tabpanel" aria-labelledby="design-p-tab" >
    <div class="table-responsive ">
    <table class="table table-striped table-borderless designorders" id="designorders">
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
	       <div class="tab-pane fade show active" id="designc" role="tabpanel" aria-labelledby="design-c-tab">

    <div class="table-responsive ">
    <table class="table table-striped table-borderless designordersc" id="designordersc">
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
        <p class="card-title mb-0 float-left">Designing QC</p>
        <a href="javascript:void(0)" class="btn btn-info btn-xs float-right"  id="designqc-ref"><i class="fa fa-refresh" aria-hidden="true">
Load </i></a>
<div class="clearfix"></div>
 <div class="row">

	   <div class="col-md-12 pl-md-1 pt-4 pt-md-0">

	     <ul class="nav nav-tabs tab-basic" role="tablist">
	       <li class="nav-item">
		 <a class="nav-link" id="designqc-p-tab" data-toggle="tab" href="#designqcp" role="tab" aria-controls="designqcp" aria-selected="true">Pending</a>
	       </li>
	       <li class="nav-item">
		 <a class="nav-link active" id="designqc-c-tab" data-toggle="tab" href="#designqcc" role="tab" aria-controls="designqcc" aria-selected="false">Today</a>
	       </li>
	     </ul>

	     <div class="tab-content tab-content-basic"  >
	       <div class="tab-pane fade" id="designqcp" role="tabpanel" aria-labelledby="designqc-p-tab" >


        <div class="table-responsive ">
        <table class="table table-striped table-borderless designqcTable" id="designqcTable">
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
	<div class="tab-pane fade show active" id="designqcc" role="tabpanel" aria-labelledby="designqc-c-tab">


        <div class="table-responsive ">
        <table class="table table-striped table-borderless designqcTablec" id="designqcTablec">
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
        <p class="card-title mb-0 float-left">Printing</p>
        <a href="javascript:void(0)" class="btn btn-info btn-xs float-right"  id="printing-ref"><i class="fa fa-refresh" aria-hidden="true">
Load </i></a>
<div class="clearfix"></div>
        
 <div class="row">
	   <div class="col-md-12 pl-md-1 pt-4 pt-md-0">

	     <ul class="nav nav-tabs tab-basic" role="tablist" >
	       <li class="nav-item">
		 <a class="nav-link " id="printing-p-tab" data-toggle="tab" href="#printingp" role="tab" aria-controls="printingp" aria-selected="true">Pending</a>
	       </li>
	       <li class="nav-item">
		 <a class="nav-link active" id="printing-c-tab" data-toggle="tab" href="#printingc" role="tab" aria-controls="printingc" aria-selected="false">Today</a>
	       </li>
	     </ul>

	     <div class="tab-content tab-content-basic"  >
	       <div class="tab-pane fade" id="printingp" role="tabpanel" aria-labelledby="printing-p-tab" >

        <div class="table-responsive "	 >
        <table class="table table-striped table-borderless printingTable" id="printingTable">
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

	<div class="tab-pane fade show active" id="printingc" role="tabpanel" aria-labelledby="printing-c-tab">
        <div class="table-responsive ">
        <table class="table table-striped table-borderless printingTablec" id="printingTablec">
        <thead>
        <tr>
          <th>Orders No:</th>
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
    $("#design-ref").click(function() {

      var newUrl = "<?= base_url('myaccount/get_works_design/4/'.$selectedDate.'/pending') ;?>";
      designorders.ajax.url(newUrl).load();
      var newUrld = "<?= base_url('myaccount/get_works_design/4/'.$selectedDate.'/today') ;?>";
      designordersc.ajax.url(newUrld).load();


    });

    $("#designqc-ref").click(function() {

var newUrlQc = "<?= base_url('myaccount/get_works_designqc/11/'.$selectedDate.'/pending') ;?>";
designqcTable.ajax.url(newUrlQc).load();


var newUrlQcc = "<?= base_url('myaccount/get_works_designqc/11/'.$selectedDate.'/today') ;?>";
designqcTablec.ajax.url(newUrlQcc).load();
});
$("#printing-ref").click(function() {

var newUrlP = "<?= base_url('myaccount/get_works_printing/5/'.$selectedDate.'/pending') ;?>";
printingTable.ajax.url(newUrlP).load();
var newUrlPc = "<?= base_url('myaccount/get_works_printing/5/'.$selectedDate.'/today') ;?>";
printingTablec.ajax.url(newUrlPc).load();

});

  var designorders = $("#designorders").DataTable({
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


  var designqcTable = $("#designqcTable").DataTable({
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


  var printingTable = $("#printingTable").DataTable({
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

  var designordersc = $("#designordersc").DataTable({
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


  var designqcTablec = $("#designqcTablec").DataTable({
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


  var printingTablec = $("#printingTablec").DataTable({
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
  /*
    $(document).ready(function () {
    $("#design-ref").click(function () {
      var newUrl = "<?= base_url('myaccount/get_works_design/') ?>";
        $.ajax({
          url: "https://api.srv3r.com/table/",
          type: "GET"
        }).done(function (result) {
          designorders.clear().draw();
          designorders.rows.add(result).draw();
        });
      
    });
  });

  var designorders = $("#designorders").DataTable({
    pageLength: 20,
    lengthMenu: [20, 30, 50, 75, 100],
    order: [],
    paging: true,
    searching: true,
    info: true,
    data: [],
    columns: [
      { data: "id" },
      { data: "guid" },
      { data: "name" },
      { data: "status" }
    ]
  });
  */
</script>
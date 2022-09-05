<div class="card-body">









<div class="row">

<div class="col-12 table-responsive">

<table width="100%" class="table table-bordered  mt-0 "  >

    <thead>

    <tr class="item_header">

    <th width="10%"   class="text-left">DATE</th>

    <th width="18%"  class="text-left">DESIGNING</th>

    <th width="18%"  class="text-left">PRINTING</th>

    <th width="18%"  class="text-left">FUSING</th>

    <th width="18%"  class="text-left">BUNDLING</th>

    <th width="18%"  class="text-left">STITCHING</th>

    <th width="18%"  class="text-left">FINAL QC</th>

    <th width="18%"  class="text-left">DISPATCH</th>

    </tr>

    </thead>

    <tbody>

    <?php if($dates){ ?>

    <?php foreach($dates as $SH){?>

    <tr>

    <td valign="top" style="vertical-align:top;"><?php echo date('d/m/Y', strtotime($SH['DSD']));?></td>

    <?php include("td_1.php");?>

    <?php include("td_2.php");?>

    <?php include("td_3.php");?>

    <?php include("td_4.php");?>

    <?php include("td_5.php");?>

    <?php include("td_6.php");?>

    <?php include("td_7.php");?>

    </tr>

    <?php } ?>

    <?php }else{ ?>

    <tr>

    <td  colspan="6">

    <div class="alert alert-warning" role="alert">No result found...!!</div>

    <?php }?>

    </td>

    </tbody>

    </table>

    </div>

    </div>

    </div>

    



    

<script type="text/javascript">





$(document).ready(function() {

	$('[data-toggle="tooltip"]').tooltip();

	$('#changeDate').on('show.bs.modal', function (event) {

	var button = $(event.relatedTarget);

	var sdid=button.data('sdid');

	var did=button.data('did');

	var sumid=button.data('sumid');

	var SD=button.data('sd');

	var ED=button.data('ed');

	var CD=button.data('cd');

	var UID=button.data('uid');

	

	//alert("ggg");

	var formData = "<?php echo $this->security->get_csrf_token_name(); ?>=<?php echo $this->security->get_csrf_hash(); ?>&sdid="+sdid+"&did="+did+"&sumid="+sumid+"&SD="+SD+"&ED="+ED+"&UID="+UID+"&CD="+CD;

	//var cid=button.data('cid');

	//alert(formData);

	var modal = $(this);

	//var dataString = "cuid="+cuid;

	$.ajax({  

	type: "POST",

	url: "<?= base_url("schedule/change_date/");?>",  

	data: formData,

	beforeSend: function(){

		modal.find('.modal-content').html('<i class="fa fa-cog fa-spin"></i>');},

		success: function(response){

		modal.find('.modal-content').html(response);

		

		}

	}); 

	}); 

});

</script>





    <div class="modal" id="changeDate" tabindex="-1" >

    <div class="modal-dialog modal-lg" role="document">

    <div class="modal-content"></div> 

    </div>

    </div>
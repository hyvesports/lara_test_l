<?php
//print_r($_POST);
$schedule_id=$_POST['sid'];
$sql2="SELECT wo_work_orders.orderform_type_id,wo_work_orders.order_id FROM sh_schedules,wo_work_orders WHERE sh_schedules.schedule_id='$schedule_id' AND sh_schedules.order_id=wo_work_orders.order_id";
$query2 = $this->db->query($sql2);					 
$orderRow=$query2->row_array();
//print_r($orderRow);

$images = $this->qc_model->get_qc_images($orderRow['order_id'],$_POST['smid']);  
?>

<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-label="Close">
<span aria-hidden="true">x</span>
</button>
</div>
<div class="modal-content">

<div class="modal-body">
<div class="card-body">
<h4 class="card-title">Upload Images</h4>

<form method="post" id="upload_form" class="forms-sample" enctype="multipart/form-data">  
<input type="file" name="images[]" id="select_image" multiple />  
<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
<input type="hidden" name="order_id" value="<?php echo $orderRow['order_id']; ?>">
<input type="hidden" name="order_item_id" value="<?php echo $_POST['smid']; ?>">
</form> 
<div class="col-12 table-responsive"><span id="actionResponse"></span>
<div id="lightgalleryModel" class="row lightGallery" >

<?php
//$images = glob("uploads/finalqc/*.*");  
foreach($images as $image)  
{  
$output .= '<div id="currentTD'.$image['qc_image_id'].'"><a href="'.base_url()."uploads/finalqc/".$image['image_name'].'" target="_blank" class="m-1"><img  src="' .base_url()."uploads/finalqc/".$image['image_name'].'"  width="100px" height="100px" style="margin-top:15px; padding:8px; border:1px solid #ccc;" /></a><br/>
<p class="w" align="center"><a href="javascript:void(0);" class="delete_button" id="'.$image['qc_image_id'].'"  title="Delete">Remove</a></p></div>
';  
}  
echo $output; 
?>
                   
</div>


</div>
</div>
</div>
</div>
<script>  
 $(document).ready(function(){  
      $('#select_image').change(function(){
		             $('#upload_form').submit();  
      });  
      $('#upload_form').on('submit', function(e){  
           e.preventDefault();  
						$('#actionResponse').html('<i class="fa fa-spin fa-refresh"></i> Uploading...'); 
           $.ajax({  
                url :"<?= base_url("finalqc/upload/");?>",  
                method:"POST",  
                data:new FormData(this),  
                contentType:false,  
                processData:false,  
                success:function(data){  
                     $('#select_image').val('');  
											$('#actionResponse').html(""); 
                     //$('#uploadModal').modal('hide');  
                     $('#lightgalleryModel').html(data);  
                }  
           })  
      });  
 });  
 </script>  

<script type="text/javascript">

$(function() {
	
	$(".delete_button").click(function() {
	var id = $(this).attr("id");
	var dataString = '<?php echo $this->security->get_csrf_token_name(); ?>=<?php echo $this->security->get_csrf_hash(); ?>&id='+id;
	//alert(dataString);
	var parent = $(this).closest("tr");
		if(confirm("Are you want to delete.?")){
			$("#currentTD"+id).fadeOut();
			$('#actionResponse').html('<div style="text-align:center;"><img src="loader/round.gif"></br><strong>Please wait...</strong></div>');
			$.ajax({
			type: "POST",
			url: '<?= base_url("finalqc/removeupload/");?>',
			data: dataString,
			cache: false,
			success: function(data)
			{
				if(data==1){
					$("#actionResponse").html('<div class="alert alert-success fade in block w-100 mt-2"><button data-dismiss="alert" class="close" type="button">x</button><i class="icon-checkmark3"></i>Success. Image deleted successfully..!</div>');
					parent.slideUp(300,function() {
						parent.remove();
					});
				}else {
					$("#actionResponse").html(data);
				}
			}
		   
			});
	
		return false;
		}
	});
	



	$("#saveStatus").validate({
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

	submitHandler: function() {

	//$("#submitDataModel").attr("disabled", "disabled");

	$('#submitDataModel').html("Please Wait ...");

	//$('#response').html('<font class="text-yellow">Checking.Please wait..</font>');

	//$('#modelResp').html('<p style="text-align:center; width:100%;"><i class="fa fa-spin fa-refresh"></i><br/>Saving...</p>');

	$.post('<?= base_url("finalqc/final_qc_save_status/");?>', $("#saveStatus").serialize(), function(data) {

																								

		window.location.reload();  

		

	});	

	}

	});	



});

</script>






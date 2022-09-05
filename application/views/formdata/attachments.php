<div class="content-wrapper">
    <div class="row grid-margin">
    <div class="col-12">
    <div class="card">
    <div class="card-body">
    <?php if(isset($msg) || validation_errors() !== ''): ?>
    <div class="alert alert-warning alert-dismissible" style="width:100%;">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    <h4><i class="icon fa fa-warning"></i> Alert!</h4>
    <?php echo validation_errors();?>
    </div>
    <?php endif; ?>
    
    <?php if($this->session->flashdata('error')): ?>
    <div class="alert alert-danger" style="width:100%;">
    <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
    <?=$this->session->flashdata('error')?>
    </div>
    <?php endif; ?>
    
    <?php if($this->session->flashdata('success')): ?>
    <div class="alert alert-success" style="width:100%;">
    <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
    <?=$this->session->flashdata('success')?>
    </div>
    <?php endif; ?>
    
    <h4 class="card-title"><?php echo $title_head;?>
    <span style="text-align:right; float:right;"><a class="btn btn-primary " href="<?php echo base_url('workorder/index');?>">List</a></span> 
    </h4>
    <?php
	$sumRows=$this->formdata_model->get_wo_order_summary_sum($row['order_id']); 
	//print_r();
	?>
    <?php echo form_open_multipart(base_url('workorder/attachments/'.$row['order_uuid']), 'class="cmxform"  id="dataform" method="post"'); ?>
    <input type="hidden" name="order_id" id="order_id" value="<?php echo $row['order_id'];?>" />
    <input type="hidden" name="wo_client_id" id="wo_client_id" value="<?php echo $row['wo_client_id'];?>" />

  

    
    
    <p class="card-description" style="border-bottom: 1px solid #f2f2f2;" id=""><strong>Order Documents</strong></p>
    <div class="row" >
<div class="col-lg-6 ">
<h4 class="card-title">Images upload</h4>
<div class="file-upload-wrapper">
<div id="fileuploader">Upload</div>
</div>
</div>
<div class="col-lg-6 ">
<h4 class="card-title">Attachment upload</h4>
<div class="file-upload-wrapper">
<div id="fileuploader2" style="color:#FFF;">Upload</div>
</div>
</div>
</div>
    <input class="btn btn-primary float-right" type="submit" value="Complete Order" id="submit" name="submit">
    <?php echo form_close(); ?>
    </div>
    </div>
    </div>
    </div>
	
</div>
<script language="javascript">
$(function() {
var post_data = {
'<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>',
'<?php echo 'order_id'; ?>' : '<?php echo $row['order_id']; ?>'
};


$("#fileuploader").uploadFile({url: "<?php echo base_url()?>attachment/image/<?php echo $row['order_id']; ?>",
dragDrop: true,
formData: post_data,
fileName: "myfile",
returnType: "json",
showDelete: true,
showDownload:false,
statusBarWidth:600,
dragdropWidth:600,
maxFileSize:10000*1024,
showPreview:false,
allowedTypes:"jpg,png,gif,jpeg",
onLoad:function(obj){
	$.ajax({
	cache: false,
	formData: post_data,
	url: "<?php echo base_url()?>attachment/load_image/<?php echo $row['order_id'];?>",
	dataType: "json",
	success: function(data) 
	{
	for(var i=0;i<data.length;i++)
	{ 
	  //alert(data.length);
	  obj.createProgress(data[i]["name"],data[i]["path"],data[i]["size"],data[i]["document_id"]);
	}
	}
	});
},
deleteCallback: function (data, pd) {
	for (var i = 0; i < data.length; i++) {
	//alert(data[i]);
	$.post("<?php echo base_url()?>attachment/drop_image/<?php echo $row['order_id']; ?>", {'<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>',name: data[i]},
	function (resp,textStatus, jqXHR) {
	//Show Message	
	alert("File Deleted");
	});
	}
	pd.statusbar.hide(); //You choice.
},
downloadCallback:function(filename,pd){
	location.href="download.php?filename="+filename;
}
}); 

$("#fileuploader2").uploadFile({url: "<?php echo base_url()?>attachment/document/<?php echo $row['order_id']; ?>",
dragDrop: true,
formData: post_data,
fileName: "myfile",
returnType: "json",
showDelete: true,
showDownload:false,
statusBarWidth:600,
dragdropWidth:600,
maxFileSize:10000*1024,
showPreview:false,
onLoad:function(obj){
	$.ajax({
	cache: false,
	formData: post_data,
	url: "<?php echo base_url()?>attachment/load_document/<?php echo $row['order_id'];?>",
	dataType: "json",
	success: function(data) 
	{
	for(var i=0;i<data.length;i++)
	{ 
	  //alert(data.length);
	  obj.createProgress(data[i]["name"],data[i]["path"],data[i]["size"],data[i]["document_id"]);
	}
	}
	});
},
deleteCallback: function (data, pd) {
	for (var i = 0; i < data.length; i++) {
	//alert(data[i]);
	$.post("<?php echo base_url()?>attachment/drop_document/<?php echo $row['order_id']; ?>", {'<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>',name: data[i]},
	function (resp,textStatus, jqXHR) {
	//Show Message	
	alert("File Deleted");
	});
	}
	pd.statusbar.hide(); //You choice.
},
downloadCallback:function(filename,pd){
	location.href="download.php?filename="+filename;
}
});


$("#grp_date").on("change",function(){
var selected = $(this).val();
var post_data = {
'<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>',
gpdate:selected
};								
//alert(selected);
//var post_data='gp_data='+selected;
$.ajax({
type: "POST",
url: "<?= base_url("workorder/group_ajax/");?>",
data: post_data
}).done(function(reply) {
//$('#loadClientData').html("");
$('#grp_number').val(reply);
});
});
$('.mydatepicker').datepicker({
enableOnReadonly: false,
todayHighlight: false,
});
$("#dataform").validate({
errorPlacement: function(label, element) {
label.addClass('mt-2 text-danger');
label.insertAfter(element);
},
highlight: function(element, errorClass) {
$(element).parent().addClass('has-danger')
$(element).addClass('form-control-danger')
}
});
});

</script>
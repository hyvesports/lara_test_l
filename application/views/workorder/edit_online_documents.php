<?php echo form_open_multipart(base_url('workorder/edit_online/'.$woRow['order_uuid']), 'class="cmxform"  id="dataform" method="post"'); ?>
<input type="hidden" name="order_id" id="order_id" value="<?php echo $woRow['order_id'];?>" />
<input type="hidden" name="wo_client_id" id="wo_client_id" value="<?php echo $woRow['wo_client_id'];?>" />
<div class="row mt-2" >
<div class="col-lg-6 ">
<h4 class="card-title">Images upload</h4>
<div class="file-upload-wrapper">
<div id="fileuploader">Upload</div>
</div>
</div>
<div class="col-lg-6 ">
<h4 class="card-title">Attachment upload </h4>
<div class="file-upload-wrapper">
<div id="fileuploader2" style="color:#FFF;">Upload</div>
</div>
</div>
</div>

<?php echo form_close(); ?>
<script language="javascript">
$(function() {
var post_data = {
'<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>',
'<?php echo 'order_id'; ?>' : '<?php echo $woRow['order_id']; ?>'
};


$("#fileuploader").uploadFile({url: "<?php echo base_url()?>attachment/image/<?php echo $woRow['order_id']; ?>",
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
	url: "<?php echo base_url()?>attachment/load_image/<?php echo $woRow['order_id'];?>",
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
	$.post("<?php echo base_url()?>attachment/drop_image/<?php echo $woRow['order_id']; ?>", {'<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>',name: data[i]},
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

$("#fileuploader2").uploadFile({url: "<?php echo base_url()?>attachment/document/<?php echo $woRow['order_id']; ?>",
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
	url: "<?php echo base_url()?>attachment/load_document/<?php echo $woRow['order_id'];?>",
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
	$.post("<?php echo base_url()?>attachment/drop_document/<?php echo $woRow['order_id']; ?>", {'<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>',name: data[i]},
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

});

</script>
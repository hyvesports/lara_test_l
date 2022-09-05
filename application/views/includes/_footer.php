<footer class="footer">
<div class="w-100 clearfix">
<span class="text-muted d-block text-center text-sm-left d-sm-inline-block">Copyright © <?php echo date('Y');?> <a href="http://hses.hyvesports.com" target="_blank">HYVE SPORTS</a>. All rights reserved.</span>

</div>
</footer>
<div class="modal" id="scheduleInfo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
<div class="modal-dialog modal-md" role="document" style="max-width: 700px;">
<div class="modal-content"></div> 
</div>
</div>

<div class="modal" id="statusInfo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
<div class="modal-dialog modal-md" role="document" style="max-width: 700px;">
<div class="modal-content"></div> 
</div>
</div>

<script>
$(function() {
	$('#scheduleInfo').on('show.bs.modal', function (event) {
	var button = $(event.relatedTarget);
	var sid=button.data('sid');
	var formData = "<?php echo $this->security->get_csrf_token_name(); ?>=<?php echo $this->security->get_csrf_hash(); ?>&sid="+sid;
	//var cid=button.data('cid');
	//alert(oid);
	var modal = $(this);
	//var dataString = "cuid="+cuid;
	$.ajax({  
	type: "POST",
	url: "<?= base_url("myaccount/iteminfo/");?>",  
	data: formData,
	beforeSend: function(){
	modal.find('.modal-content').html('<i class="fa fa-spin fa-refresh"></i>');},
	success: function(response){
	modal.find('.modal-content').html(response); 
	}
	}); 
	});

	$('#statusInfo').on('show.bs.modal', function (event) {
	var button = $(event.relatedTarget);
	var sid=button.data('sid');
	var fd=button.data('fd');
	var did=button.data('did');
	var formData = "<?php echo $this->security->get_csrf_token_name(); ?>=<?php echo $this->security->get_csrf_hash(); ?>&sid="+sid+"&fd="+fd+"&did="+did;
	//var cid=button.data('cid');
	//alert(oid);
	var modal = $(this);
	//var dataString = "cuid="+cuid;
	$.ajax({  
	type: "POST",
	url: "<?= base_url("myaccount/statusinfo/");?>",  
	data: formData,
	beforeSend: function(){
	modal.find('.modal-content').html('<i class="fa fa-spin fa-refresh"></i>');},
	success: function(response){
	modal.find('.modal-content').html(response); 
	}
	}); 
	});  

});
</script>

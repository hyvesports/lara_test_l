<?php echo form_open_multipart(base_url('workorder/edit_online/'.$woRow['order_uuid']), 'class="cmxform"  id="dataform" method="post"'); ?>
<input type="hidden" name="order_id" id="order_id" value="<?php echo $woRow['order_id'];?>" />
<input type="hidden" name="wo_client_id" id="wo_client_id" value="<?php echo $woRow['wo_client_id'];?>" />
<div class="row" >
<div class="col-md-12">
<div class="form-group row">
<label class="col-md-2 col-form-label">Images <em style="font-size:10px; color:#030;">Multiple</em>*</label>
<div class="col-md-10">

<?php if($images) {?>
<ol>
	<?php foreach($images as $imgDoc) {?>
	<li id="doc_file<?php echo $imgDoc['document_id'];?>"><?php echo $imgDoc['document_name'];?> <em><a href="javascript:del_old_file(<?php echo $imgDoc['document_id'];?>)" style="color:#F00;" onclick="return confirm('Are you really want to delete ?')">Remove</a></em></li>
    <?php } ?>
</ol>
<?php } ?>
<input type="file" name="upload_file1" id="upload_file1" readonly="true"/><br/>
<div id="moreImageUpload"></div>
<div style="clear:both;"></div>
						<div id="moreImageUploadLink" style="display:none;">
							<a href="javascript:void(0);" id="attachMore">Attach another file</a>
						</div>
</div>
</div>


</div>
<script type="text/javascript">
    $(document).ready(function() {
        $("input[id^='upload_file']").each(function() {
            var id = parseInt(this.id.replace("upload_file", ""));
            $("#upload_file" + id).change(function() {
                if ($("#upload_file" + id).val() !== "") {
                    $("#moreImageUploadLink").show();
                }
            });
        });
    });
</script>
<script type="text/javascript">
    $(document).ready(function() {
        var upload_number = 2;
        $('#attachMore').click(function() {
            //add more file
            var moreUploadTag = '';
            moreUploadTag += '<br/><div class="element">';
            moreUploadTag += '<input type="file" id="upload_file' + upload_number + '" name="upload_file' + upload_number + '"/>';
            moreUploadTag += '&nbsp;<a href="javascript:del_file(' + upload_number + ')" style="cursor:pointer;" onclick="return confirm(\"Are you really want to delete ?\")">Delete</a></div>';
            $('<dl id="delete_file' + upload_number + '">' + moreUploadTag + '</dl>').fadeIn('slow').appendTo('#moreImageUpload');
            upload_number++;
        });
    });
</script>
<script type="text/javascript">
    function del_file(eleId) {
        var ele = document.getElementById("delete_file" + eleId);
        ele.parentNode.removeChild(ele);
    }
	
	function del_old_file(eleId) {
		
		
		var post_data = {
		'<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>',
		'document_id':+eleId,
		};
		//$('#orderform_number_load').html("<p style='text-align:center'>Loading... </p>");
		//alert(cid);
		$.ajax({
		type: "POST",
		url: "<?= base_url("workorder/removedoc/");?>",
		data: post_data
		}).done(function(reply) {
			$('#orderform_number_load').html("");
			$('#orderform_number').val(reply);
		});
		
		
        var ele = document.getElementById("doc_file" + eleId);
        ele.parentNode.removeChild(ele);
    }
</script>






</div>



<div class="col-md-12">
<div class="form-group row">
<label class="col-md-2 col-form-label">Attachment *</label>
<div class="col-md-10">
<?php if($Attachment){?>
<ol>
	<?php foreach($Attachment as $AttachmentDco){?>
	<li id="doc_file<?php echo $AttachmentDco['document_id'];?>"><?php echo $AttachmentDco['document_name'];?> <em><a href="javascript:del_old_file(<?php echo $AttachmentDco['document_id'];?>)" style="color:#F00;" >Remove</a></em></li>
    <?php } ?>
</ol>
<?php } ?>
<input type="file" name="attachment" class="" id="attachment">
</div>
</div>
</div>

<input class="btn btn-primary float-right" type="submit" value="Save" id="submit" name="submit">
<?php echo form_close(); ?>

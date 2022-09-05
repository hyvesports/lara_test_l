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
<span style="text-align:right; float:right;"><a class="btn btn-primary " href="#" onclick="window.history.go(-1); return false;"><i class="fa fa-reply mr5"></i> Back</a></span> 
</h4>

<?php echo form_open(base_url('staff/add'), 'class="cmxform"  id="dataform" method="post"'); ?>
<?php //print_r($result);?>
<div class="row">
       	
	        
<div class="col-md-12 grid-margin">
<div class="card">
<div class="card-body">
<h4 class="card-title mb-0"><?php echo $result['staff_code'];?></h4>
<div class="d-flex justify-content-between align-items-center">
<div class="d-inline-block pt-3">
<div class="d-md-flex">
<h2 class="mb-0"><?php echo $result['staff_name'];?></h2>
<div class="d-flex align-items-center ml-md-2 mt-2 mt-md-0">
<i class="icon-mail text-muted"></i>
<small class=" ml-1 mb-0"><?php echo $result['designation_name'];?></small>
</div>
</div>
<small class="text-gray"><?php echo $result['department_name'];?></small>
</div>
<div class="d-inline-block">

</div>
</div>
</div>
</div>
</div>

</div>

<div class="row">
<?php if($MainModules){ ?>
	<?php foreach($MainModules as $MM){ ?>
    <?php if($MM['is_in_permission']==1){ ?>
    <div class="col-md-12">
	<p class="card-description" style="border-bottom: 1px solid #f2f2f2;"><strong><?php echo $MM['menu_name'];?></strong></p>
    </div>
    	<?php $SubModules = $this->auth_model->menu_master_data($MM['menu_master_id']); ?>
        <?php if($SubModules){ ?>
        <div class="col-md-12">
			<?php foreach($SubModules as $SM){ ?>
                <div class="row">
                <div class="col-md-3"><p class="card-description" style="border-bottom: 1px solid #f2f2f2;">&nbsp;<?php echo $SM['menu_name'];?></p></div>
                <div class="col-md-9">
                <div class="row">
                <?php $actions=explode('|',$SM['menu_actions']);?>
                <?php if($actions){ ?>
                	<?php foreach($actions as $operation){ 
						$accessRow=$this->staff_model->check_access($result['login_id'],$MM['menu_master_id'],$SM['menu_master_id'],$operation);
						
					?>
                        <div class="col-md-2">
                        <div class="form-check form-check-success">
                        <label class="form-check-label">
                        <input type="checkbox" class="form-check-input tgl_checkbox" id="<?php echo $SM['menu_master_id'];?>" 
                        data-module='<?php echo $SM['menu_controller'];?>' data-operation='<?php echo $operation; ?>' data-main='<?php echo $MM['menu_master_id'];?>' data-sub='<?php echo $SM['menu_master_id'];?>' <?php if($accessRow['staff_permission_id']!=""){ echo 'checked="checked"';} ?>  >
                        <?php echo ucwords($operation);?>
                        <i class="input-helper"></i></label>
                        </div>
                        </div>
                	<?php } ?>
                <?php } ?>
                </div>
                </div>

                </div>
            <?php } ?>
        </div>
        <?php } ?>
        
    <?php } ?>
    <?php } ?>
<?php } ?>
</div>
<script>
$("body").on("change",".tgl_checkbox",function(){
	$.post('<?=base_url("staff/set_access")?>',
	{
		'<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>',
		permission_module : $(this).data('module'),
		permission_operation : $(this).data('operation'),
		main_module_id : $(this).data('main'),
		sub_module_id : $(this).data('sub'),
		staff_login_id : <?=$result['login_id']?>,
		status : $(this).is(':checked')==true?1:0
	},
	function(data){
		//$.notify("Status Changed Successfully", "success");
		$.toast({
      heading: 'Success',
      text: 'Status Changed Successfully.',
      showHideTransition: 'slide',
      icon: 'success',
      loaderBg: '#f96868',
      position: 'top-center'
    });

		
	});
});
</script>




<?php echo form_close(); ?>
</div>
</div>
</div>
</div>
</div>

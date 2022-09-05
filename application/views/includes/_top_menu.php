
	
	<div class="nav-bottom">
    <div class="container">
    <ul class="nav page-navigation">
    <?php if($this->session->userdata('role_id')=="1"){ ?>
   		<?php 
		$parent_menus= $this->auth_model->menu_master_data('0');
		if($parent_menus){ foreach($parent_menus as $menu1){?>
        <?php if($menu1['menu_has_child']==0){ ?>
    <li class="nav-item"><a href="<?php echo base_url() ?><?php echo $menu1['menu_controller'];?>" class="nav-link"><i class="<?php echo $menu1['menu_icon'];?>"></i><span class="menu-title"><?php echo $menu1['menu_name'];?></span></a></li>
        <?php }else { 
            $sub_menu = $this->auth_model->menu_master_data($menu1['menu_master_id']);
            //print_r($results2);
        ?>
        <li class="nav-item" style="text-align: left;">
            <a href="#" class="nav-link"><i class="<?php echo $menu1['menu_icon'];?>"></i><span class="menu-title"><?php echo $menu1['menu_name'];?></span><i class="menu-arrow"></i></a>
            <div class="submenu">
                <ul class="submenu-item">
                <?php if($sub_menu){ foreach($sub_menu as $submenu1){?>
                <li class="nav-item"><a class="nav-link" href="<?php echo base_url() ?><?php echo $submenu1['menu_controller'];?>/<?php echo $submenu1['menu_controller_function'];?>"><?php echo $submenu1['menu_name'];?></a></li>
                <?php } } ?>
                </ul>
            </div>
        </li>
        <?php } ?>
        <?php } } ?>
        
    <?php }else{ ?>
    	<?php
		$parent_menus= $this->auth_model->staff_menu_master_data($this->session->userdata('loginid'));
		//$this->load->model('myaccount_model', 'myaccount_model');
		$staffDataRow=$this->auth_model->get_staff_profile_data($this->session->userdata('loginid'));
		$anyTask=$this->auth_model->check_any_task($this->session->userdata('loginid'));
		?>
        
        <li class="nav-item">
        <a href="#" class="nav-link"><i class="link-icon icon-book-open"></i><span class="menu-title">My Account</span><i class="menu-arrow"></i></a>
        <div class="submenu">
        <ul class="submenu-item">
        <li class="nav-item"><a class="nav-link" href="<?php echo base_url() ?>myaccount">Dashboard</a></li>
        <?php if($anyTask){ ?>
        <li class="nav-item"><a class="nav-link" href="<?php echo base_url() ?>task">Tasks</a></li>
        <?php } ?>
        
        <?php if($staffDataRow['department_id']==4 || $staffDataRow['department_id']==5 || $staffDataRow['department_id']==6 || $staffDataRow['department_id']==7 || $staffDataRow['department_id']==8 || $staffDataRow['department_id']==9 || $staffDataRow['department_id']==10 || $staffDataRow['department_id']==11 || $staffDataRow['department_id']==12 || $staffDataRow['department_id']==13  && $staffDataRow['unit_managed']!="") { ?>
        <!--<li class="nav-item"><a class="nav-link" href="<?php //echo base_url() ?>qc/design">Design Requests</a></li>--> 
        <li class="nav-item"><a class="nav-link" href="<?php echo base_url() ?>myaccount/myorders">My Scheduled Orders</a></li>
        <?php } ?>
        
        
        
       
        </ul>
        </div>
        </li>
    
        
        <?php if($parent_menus){ ?>
        <?php foreach($parent_menus as $menu1){ ?>
        	<?php  $sub_menu = $this->auth_model->staff_sub_menu_master_data($menu1['menu_master_id']); ?>
            <li class="nav-item" style="text-align: left;">
            <a href="#" class="nav-link"><i class="<?php echo $menu1['menu_icon'];?>"></i><span class="menu-title"><?php echo $menu1['menu_name'];?></span><i class="menu-arrow"></i></a>
            
                <div class="submenu">
                <ul class="submenu-item">
                <?php if($sub_menu){ foreach($sub_menu as $submenu1){?>
                <li class="nav-item"><a class="nav-link" href="<?php echo base_url() ?><?php echo $submenu1['menu_controller'];?>/<?php echo $submenu1['menu_controller_function'];?>"><?php echo $submenu1['menu_name'];?></a></li>
                <?php } } ?>
                </ul>
                </div>
            
            
        	</li>
        <?php } ?>
        <?php } ?>
    
	<?php } ?>    
    </ul>
    </div>
    </div>
    
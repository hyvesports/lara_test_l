<?php
//print_r($parent_menus);
?>

<div class="nav-top flex-grow-1">
        <div class="container d-flex flex-row h-100 align-items-center">
        <div class="text-center navbar-brand-wrapper d-flex align-items-center"> 
        <a class="navbar-brand brand-logo" href="<?php echo base_url()?>myaccount/index"><img src="<?php echo base_url()?>public/images/white-logo.png" alt="logo"></a>
        <a class="navbar-brand brand-logo-mini" href="<?php echo base_url()?>myaccount/index"><img src="<?php echo base_url() ?>public/images/logo-small.png" alt="logo"></a>
        </div>
        <div class="navbar-menu-wrapper d-flex align-items-center justify-content-between flex-grow-1">
        
        <ul class="navbar-nav navbar-nav-right mr-0 ml-auto">
        
            <!--<li class="nav-item dropdown">
            <a class="nav-link count-indicator dropdown-toggle" id="messageDropdown" href="#" data-toggle="dropdown" aria-expanded="false">
            <i class="icon-envelope mx-0"></i>
            <span class="count"></span>
            </a>
            <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="messageDropdown">
            <div class="dropdown-item">
            <p class="mb-0 font-weight-normal float-left">You have 7 unread mails
            </p>
            <span class="badge badge-info badge-pill float-right">View all</span>
            </div>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item preview-item">
            <div class="preview-thumbnail">
            <img src="<?php //echo base_url() ?>public/images\faces\face4.jpg" alt="image" class="profile-pic">
            </div>
            <div class="preview-item-content flex-grow">
            <h6 class="preview-subject ellipsis font-weight-medium">David Grey
            <span class="float-right font-weight-light small-text">1 Minutes ago</span>
            </h6>
            <p class="font-weight-light small-text">
            The meeting is cancelled
            </p>
            </div>
            </a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item preview-item">
            <div class="preview-thumbnail">
            <img src="<?php //echo base_url() ?>public/images\faces\face2.jpg" alt="image" class="profile-pic">
            </div>
            <div class="preview-item-content flex-grow">
            <h6 class="preview-subject ellipsis font-weight-medium">Tim Cook
            <span class="float-right font-weight-light small-text">15 Minutes ago</span>
            </h6>
            <p class="font-weight-light small-text">
            New product launch
            </p>
            </div>
            </a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item preview-item">
            <div class="preview-thumbnail">
            <img src="<?php //echo base_url() ?>public/images\faces\face3.jpg" alt="image" class="profile-pic">
            </div>
            <div class="preview-item-content flex-grow">
            <h6 class="preview-subject ellipsis font-weight-medium"> Johnson
            <span class="float-right font-weight-light small-text">18 Minutes ago</span>
            </h6>
            <p class="font-weight-light small-text">
            Upcoming board meeting
            </p>
            </div>
            </a>
            </div>
            </li>
-->        <!--<li class="nav-item dropdown">
        <a class="nav-link count-indicator dropdown-toggle" id="notificationDropdown" href="#" data-toggle="dropdown">
        <i class="icon-bell"></i>
        <span class="count"></span>
        </a>
        <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="notificationDropdown">
        <a class="dropdown-item py-3">
        <p class="mb-0 font-weight-medium float-left">You have 4 new notifications
        </p>
        <span class="badge badge-pill badge-info float-right">View all</span>
        </a>
        <div class="dropdown-divider"></div>
        <a class="dropdown-item preview-item">
        <div class="preview-thumbnail">
        <div class="preview-icon bg-success">
        <i class="icon-exclamation mx-0"></i>
        </div>
        </div>
        <div class="preview-item-content">
        <h6 class="preview-subject font-weight-normal text-dark mb-1">Application Error</h6>
        <p class="font-weight-light small-text mb-0">
        Just now
        </p>
        </div>
        </a>
        <div class="dropdown-divider"></div>
        <a class="dropdown-item preview-item">
        <div class="preview-thumbnail">
        <div class="preview-icon bg-warning">
        <i class="icon-bubble mx-0"></i>
        </div>
        </div>
        <div class="preview-item-content">
        <h6 class="preview-subject font-weight-normal text-dark mb-1">Settings</h6>
        <p class="font-weight-light small-text mb-0">
        Private message
        </p>
        </div>
        </a>
        <div class="dropdown-divider"></div>
        <a class="dropdown-item preview-item">
        <div class="preview-thumbnail">
        <div class="preview-icon bg-info">
        <i class="icon-user-following mx-0"></i>
        </div>
        </div>
        <div class="preview-item-content">
        <h6 class="preview-subject font-weight-normal text-dark mb-1">New user registration</h6>
        <p class="font-weight-light small-text mb-0">
        2 days ago
        </p>
        </div>
        </a>
        </div>
        </li>-->
        <li class="nav-item nav-profile dropdown">
        <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" id="profileDropdown">
        <!--<img src="<?php //echo base_url() ?>public/images\faces\face4.jpg" alt="profile">-->
        <span class="nav-profile-name"><?php echo $this->session->userdata('username');?></span>
        </a>
        <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown">
        <a class="dropdown-item" href="<?php echo base_url()?>myaccount/profile/">
        <i class="icon-user text-primary mr-2"></i>Myaccount</a>
        
        <div class="dropdown-divider"></div>
        <a class="dropdown-item" href="<?php echo base_url()?>auth/logout/"><i class="icon-logout text-primary mr-2"></i>Logout</a>
        </div>
        </li>
        </ul>
        <button class="navbar-toggler align-self-center" type="button" data-toggle="minimize">
        <span class="icon-menu"></span>
        </button>
        </div>
        </div>
        </div>
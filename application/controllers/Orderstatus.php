<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class orderstatus extends CI_Controller {
  public function __construct(){
          parent::__construct();
          $this->load->model('auth_model', 'auth_model');
          $this->load->model('workorder_model', 'workorder_model');
          $this->load->model('schedule_model', 'schedule_model');
          $this->load->model('settings_model', 'settings_model');
          $this->load->model('leads_model', 'leads_model');
          $this->load->model('common_model', 'common_model');
          $this->load->model('formdata_model', 'formdata_model');
        $this->load->model('dispatch_model', 'dispatch_model');
                 $this->load->model('notification_model', 'notification_model');

          $this->load->library('datatable');
          if(!$this->session->has_userdata('loginid')){
                  redirect('auth/login');
          }
}
 public function orderstatus(){
$accessArray=$this->rbac->check_operation_access(); // check opration permission
                if($accessArray==""){
                        redirect('access/not_found');
                }
                $data['title']=$accessArray['module_parent']." | ".$accessArray['menu_name'];
                $data['title_head']=$accessArray['menu_name'];


 $data['view']='orderstatus/index';
          $this->load->view('layout',$data);


}
}
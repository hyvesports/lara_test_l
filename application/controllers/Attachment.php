<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Attachment extends CI_Controller {

	public function __construct(){ 
		parent::__construct();
		$this->load->model('auth_model', 'auth_model');
		$this->load->model('workorder_model', 'workorder_model');
		$this->load->model('order_model', 'order_model');
		$this->load->model('accounts_model', 'accounts_model');
		$this->load->model('schedule_model', 'schedule_model');
		$this->load->model('calendar_model', 'calendar_model');
		$this->load->library('datatable');
		if(!$this->session->has_userdata('loginid')){
			redirect('auth/login');
		}
	}
	//drop_image
	public function drop_document($oid){
		$document_name=$_POST['name'];
		//$this->workorder_model->remove_wo_document($document_id);
		$del="DELETE FROM wo_work_order_documents WHERE wo_order_id='$oid' and document_type='document' and document_name='$document_name' ";
		$query = $this->db->query($del);
		$path= $_SERVER['DOCUMENT_ROOT'].'/uploads/orderform1/'.$document_name ;
		if(is_file($path)){
			unlink($path);
			//echo 'File '.$filename.' has been deleted';
		}
	}
	public function drop_image($oid){
		$document_name=$_POST['name'];
		//$this->workorder_model->remove_wo_document($document_id);
		$del="DELETE FROM wo_work_order_documents WHERE wo_order_id='$oid' and document_type='image' and document_name='$document_name' ";
		$query = $this->db->query($del);
		$path= $_SERVER['DOCUMENT_ROOT'].'/uploads/orderform1/'.$document_name ;
		if(is_file($path)){
			unlink($path);
			//echo 'File '.$filename.' has been deleted';
		}
	}

	public function load_document($oid=0){
		//echo $oid;
		$files=$this->workorder_model->get_wo_documents($oid,'document');
		$dir=base_url()."uploads/orderform/";
		//$files = scandir($dir);
		$ret= array();
		foreach($files as $file)
		{
			//echo $file['document_name'];
			//if($file == "." || $file == "..")
			//ontinue;
			$filePath=$dir."/".$file['document_name'];
			$details = array();
			$details['name']=$file['document_name'];
			$details['document_id']=$file['document_id'];
			$details['path']=$filePath;
			$details['size']=filesize($filePath);
			$ret[] = $details;
		
		}
		echo json_encode($ret);
	}
	public function load_image($oid=0){
		//echo $oid;
		$files=$this->workorder_model->get_wo_documents($oid,'image');
		$dir=base_url()."uploads/orderform/";
		//$files = scandir($dir);
		$ret= array();
		foreach($files as $file)
		{
			//echo $file['document_name'];
			//if($file == "." || $file == "..")
			//ontinue;
			$filePath=$dir."/".$file['document_name'];
			$details = array();
			$details['name']=$file['document_name'];
			$details['document_id']=$file['document_id'];
			$details['path']=$filePath;
			$details['size']=filesize($filePath);
			$ret[] = $details;
		
		}
		echo json_encode($ret);
	}

public function handle_error($msg)
{
return $msg;
}


	public function document($order_id=0){
		$config = array(
			'upload_path' => "./uploads/orderform/",
			'allowed_types' => "*",
			'overwrite' => FALSE,
			'max_size' => "2048000", // Can be set to particular file size , here it is 2 MB(2048 Kb)
		);
		$this->load->library('upload', $config);
		if(isset($_FILES["myfile"]))
		{
			$ret = array();
			foreach ($_FILES as $key => $value) {
			if (!empty($value['name'])) {
				if (!$this->upload->do_upload($key)) {
					$this->handle_error($this->upload->display_errors());

					$is_file_error = TRUE;
				} else {
					$up_file = $this->upload->data();
					$file_name=$up_file['file_name'];
					$ret[]= $file_name;
					$files[$i]=$up_file;
					$data = array(
					'wo_order_id' => $order_id,
					'document_type' => 'document',
					'document_name' => $file_name
					);
					$rs = $this->workorder_model->save_order_form_document($data);
					++$i;
				}

			}
			}
		
			echo json_encode($ret);
		 }
	}
	public function image($order_id=0){
		$config = array(
			'upload_path' => "./uploads/orderform/",
			'allowed_types' => "*",
			'overwrite' => FALSE,
			'max_size' => "2048000", // Can be set to particular file size , here it is 2 MB(2048 Kb)
		);
		$this->load->library('upload', $config);
		if(isset($_FILES["myfile"]))
		{
			$ret = array();
			foreach ($_FILES as $key => $value) {
			if (!empty($value['name'])) {
				if (!$this->upload->do_upload($key)) {
				    $this->handle_error($this->upload->display_errors());
error_log($this->handle_error($this->upload->display_errors()),0);
				//    error_log($this->upload->display_errors(),0);
					$is_file_error = TRUE;
									} else {
					$up_file = $this->upload->data();
					$file_name=$up_file['file_name'];
					$ret[]= $file_name;
					$files[$i]=$up_file;
					$data = array(
					'wo_order_id' => $order_id,
					'document_type' => 'image',
					'document_name' => $file_name
					);
					$rs = $this->workorder_model->save_order_form_document($data);
					++$i;
				}

			}
			}
		
			echo json_encode($ret);
		 }
	}
}

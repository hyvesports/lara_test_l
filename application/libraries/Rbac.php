<?php
class RBAC 
{	
	function __construct()
	{
		$this->obj =& get_instance();
		//$this->obj->module_access = $this->obj->session->userdata('module_access');
	}
	//--------------------------------------------------------------	
	function check_operation_access()
	{
		//echo ($this->obj->session->userdata('is_admin_login'));  
		$menu_controller=$this->obj->uri->segment(1);
		//echo $menu_controller;
		
			
		if($this->obj->session->userdata('role_id')=="1"){
			$this->obj->db->select('C.*,P.menu_name as module_parent');
			$this->obj->db->from('menu_master as C');
			$this->obj->db->where('C.menu_controller',$menu_controller);
			$this->obj->db->join('menu_master as P', 'P.menu_master_id = C.menu_parent', 'Left');
			$query=$this->obj->db->get();
			$mdata=$query->row_array(); 
			$operations=explode('|',$mdata['menu_actions']);
			return array_merge($mdata,$operations);
		}else{
			
			$staff_login_id=$this->obj->session->userdata('loginid');
			
			$this->obj->db->select('C.*,P.menu_name as module_parent');
			$this->obj->db->from('staff_permissions as SP');
			$this->obj->db->where('SP.permission_module',$menu_controller);
			$this->obj->db->where('SP.staff_login_id',$staff_login_id);
			$this->obj->db->join('menu_master as C', 'C.menu_master_id = SP.sub_module_id', 'Left');
			$this->obj->db->join('menu_master as P', 'P.menu_master_id = C.menu_parent', 'Left');
			$this->obj->db->limit(1);  
			$query=$this->obj->db->get();
			
			$mdata=$query->row_array();
			if($mdata){
				
				$this->obj->db->select('GROUP_CONCAT(SP.permission_operation) as access_functions');
				$this->obj->db->from('staff_permissions as SP');
				$this->obj->db->where('SP.permission_module',$menu_controller);
				$this->obj->db->where('SP.staff_login_id',$staff_login_id);
				$query=$this->obj->db->get();
				//echo $this->obj->db->last_query();;
				$array=$query->row_array();
				//echo $array['access_functions'];
				if($array){
					$operations=explode(',',$array['access_functions']);
					return array_merge($mdata,$operations);
				}else{
					return $mdata;
				}

			}else{
				return $mdata;
			}
			
						
		}
		
	}
	
	function check_operation_access_my_account($menu_controller)
	{
		//echo ($this->obj->session->userdata('is_admin_login'));  
		//$menu_controller=$this->obj->uri->segment(1);
		//echo $menu_controller;
		
			
		if($this->obj->session->userdata('role_id')=="1"){
			$this->obj->db->select('C.*,P.menu_name as module_parent');
			$this->obj->db->from('menu_master as C');
			$this->obj->db->where('C.menu_controller',$menu_controller);
			$this->obj->db->join('menu_master as P', 'P.menu_master_id = C.menu_parent', 'Left');
			$query=$this->obj->db->get();
			$mdata=$query->row_array(); 
			$operations=explode('|',$mdata['menu_actions']);
			return array_merge($mdata,$operations);
		}else{
			
			$staff_login_id=$this->obj->session->userdata('loginid');
			
			$this->obj->db->select('C.*,P.menu_name as module_parent');
			$this->obj->db->from('staff_permissions as SP');
			$this->obj->db->where('SP.permission_module',$menu_controller);
			$this->obj->db->where('SP.staff_login_id',$staff_login_id);
			$this->obj->db->join('menu_master as C', 'C.menu_master_id = SP.sub_module_id', 'Left');
			$this->obj->db->join('menu_master as P', 'P.menu_master_id = C.menu_parent', 'Left');
			$this->obj->db->limit(1);  
			$query=$this->obj->db->get();
			
			$mdata=$query->row_array();
			if($mdata){
				
				$this->obj->db->select('GROUP_CONCAT(SP.permission_operation) as access_functions');
				$this->obj->db->from('staff_permissions as SP');
				$this->obj->db->where('SP.permission_module',$menu_controller);
				$this->obj->db->where('SP.staff_login_id',$staff_login_id);
				$query=$this->obj->db->get();
				//echo $this->obj->db->last_query();;
				$array=$query->row_array();
				//echo $array['access_functions'];
				if($array){
					$operations=explode(',',$array['access_functions']);
					return array_merge($mdata,$operations);
				}else{
					return $mdata;
				}

			}else{
				return $mdata;
			}
			
						
		}
		
	}


}
?>
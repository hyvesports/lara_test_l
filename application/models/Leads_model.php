<?php defined('BASEPATH') OR exit('No direct script access allowed');



class Leads_model extends CI_Model{

	

	//check_priority_exist get_all_leads_by_owner

	public function get_leads_data($uuid){

			$this->db->select('leads_master.*,lead_sources.lead_source_name,lead_category.lead_cat_name,staff_master.staff_code,staff_master.staff_name,customer_master.*,lead_types.lead_type_name,lead_stages.lead_stage_name');

	    	$this->db->from('leads_master');

			$this->db->join('lead_stages', 'lead_stages.lead_stage_id = leads_master.lead_stage_id', 'Left');

			$this->db->join('lead_sources', 'lead_sources.lead_source_id = leads_master.lead_source_id', 'Left');

			$this->db->join('lead_types', 'lead_types.lead_type_id = leads_master.lead_type_id', 'Left');

			$this->db->join('lead_category', 'lead_category.lead_cat_id = leads_master.lead_cat_id', 'Left');

			$this->db->join('staff_master', 'staff_master.staff_id = leads_master.lead_owner_id', 'Left');

			$this->db->join('customer_master', 'customer_master.customer_id = leads_master.lead_client_id', 'Left');

			$this->db->where('lead_uuid',$uuid);

	    	$query = $this->db->get();					 

			return $query->row_array();

	}

	public function get_leads_data_by_id($lead_id){

			$this->db->select('leads_master.*,lead_sources.lead_source_name,staff_master.staff_code,staff_master.staff_name,customer_master.*,lead_types.lead_type_name,lead_stages.lead_stage_name');

	    	$this->db->from('leads_master');

			$this->db->join('lead_stages', 'lead_stages.lead_stage_id = leads_master.lead_stage_id', 'Left');

			$this->db->join('lead_sources', 'lead_sources.lead_source_id = leads_master.lead_source_id', 'Left');

			$this->db->join('lead_types', 'lead_types.lead_type_id = leads_master.lead_type_id', 'Left');

			$this->db->join('staff_master', 'staff_master.staff_id = leads_master.lead_owner_id', 'Left');

			$this->db->join('customer_master', 'customer_master.customer_id = leads_master.lead_client_id', 'Left');

			$this->db->where('lead_id',$lead_id);

	    	$query = $this->db->get();					 

			return $query->row_array();

	}

	public function get_all_leads(){

			$wh =array();

			$SQL ='SELECT LM.*,lead_sources.lead_source_name,lead_types.lead_type_name,lead_types.color_code,customer_master.*,staff_master.staff_code,staff_master.staff_name,lead_category.lead_cat_name,lead_stages.lead_stage_name

			FROM leads_master  as LM ';

			$SQL.="LEFT JOIN lead_stages ON lead_stages.lead_stage_id = LM.lead_stage_id ";

			$SQL.="LEFT JOIN lead_sources ON lead_sources.lead_source_id = LM.lead_source_id ";

			$SQL.="LEFT JOIN lead_types ON lead_types.lead_type_id = LM.lead_type_id ";

			$SQL.="LEFT JOIN lead_category ON lead_category.lead_cat_id = LM.lead_cat_id ";

			$SQL.="LEFT JOIN customer_master ON customer_master.customer_id = LM.lead_client_id ";

			$SQL.="LEFT JOIN staff_master ON staff_master.staff_id = LM.lead_owner_id ";

			

			//$order_by=" ORDER BY  leads_master.lead_id DESC";

			//$finalSql=$SQL.$order_by;

			//echo $finalSql;

			

			if($this->session->userdata('lead_stage_id')!='')

			$wh[]="LM.lead_stage_id = '".$this->session->userdata('lead_stage_id')."'";

			

			if($this->session->userdata('lead_search_date')!='')

			$wh[]="LM.lead_date = '".$this->session->userdata('lead_search_date')."'";

			

			if($this->session->userdata('lead_source_id')!='')

			$wh[]="LM.lead_source_id = '".$this->session->userdata('lead_source_id')."'";

			

			if($this->session->userdata('lead_type_id')!='')

			$wh[]="LM.lead_type_id = '".$this->session->userdata('lead_type_id')."'";

			

			if($this->session->userdata('lead_sports_type_id')!=''){

				$i=0;

				$str="";

				foreach($this->session->userdata('lead_sports_type_id') as $sptype){

					if($i==0){

						$str.=$sptype;

					}else{

						$str.="|".$sptype;

					}

					$i++;

				}

				if($str!=""){

				$wh[]=" LM.lead_sports_types REGEXP '(^|,)(".$str.")(,|$)' ";

				}

			}

			

			if($this->session->userdata('lead_search_key')!=""){
				//$sql="Select customer_id from customer_master WHERE customer_mobile_no='".$this->session->userdata('lead_search_key')."' ";
				//echo $sql;
    			//$query = $this->db->query($sql);					 
				//$crow=$query->row_array();
				//$customer_id=0;
				//if($crow['customer_id']!=""){
				//$customer_id=$crow['customer_id'];
				//}
				//$wh[]=" LM.lead_client_id='".$customer_id."'  ";
				
				//$wh[]="LM.cust_info = '".$this->session->userdata('lead_search_key')."'";
				$key=$this->session->userdata('lead_search_key');
				$wh[]=" LM.cust_info LIKE '%$key%'  ";

			}

			$wh[] = " LM.lead_id!= 0 ";

			$WHERE = implode(' and ',$wh);

			//echo $SQL;

			return $this->datatable->LoadJson($SQL,$WHERE);

	}

	public function get_all_leads_by_owner($lead_owner_id){

			$wh =array();

			$SQL ='SELECT LM.*,lead_sources.lead_source_name,lead_types.lead_type_name,lead_types.color_code,customer_master.*,staff_master.staff_code,staff_master.staff_name,lead_category.lead_cat_name,lead_stages.lead_stage_name

			FROM leads_master  as LM ';

			$SQL.="LEFT JOIN lead_stages ON lead_stages.lead_stage_id = LM.lead_stage_id ";

			$SQL.="LEFT JOIN lead_sources ON lead_sources.lead_source_id = LM.lead_source_id ";

			$SQL.="LEFT JOIN lead_types ON lead_types.lead_type_id = LM.lead_type_id ";

			$SQL.="LEFT JOIN lead_category ON lead_category.lead_cat_id = LM.lead_cat_id ";

			$SQL.="LEFT JOIN customer_master ON customer_master.customer_id = LM.lead_client_id ";

			$SQL.="LEFT JOIN staff_master ON staff_master.staff_id = LM.lead_owner_id ";

			

			//$order_by=" ORDER BY  leads_master.lead_id DESC";

			//$finalSql=$SQL.$order_by;

			//echo $finalSql;

			if($this->session->userdata('lead_stage_id')!='')

			$wh[]="LM.lead_stage_id = '".$this->session->userdata('lead_stage_id')."'";

			

			if($this->session->userdata('lead_search_date')!='')

			$wh[]="LM.lead_date = '".$this->session->userdata('lead_search_date')."'";

			

			if($this->session->userdata('lead_source_id')!='')

			$wh[]="LM.lead_source_id = '".$this->session->userdata('lead_source_id')."'";

			

			if($this->session->userdata('lead_type_id')!='')

			$wh[]="LM.lead_type_id = '".$this->session->userdata('lead_type_id')."'";

			

			if($this->session->userdata('lead_sports_type_id')!=''){

				$i=0;

				$str="";

				foreach($this->session->userdata('lead_sports_type_id') as $sptype){

					if($i==0){

						$str.=$sptype;

					}else{

						$str.="|".$sptype;

					}

					$i++;

				}

				if($str!=""){

				$wh[]=" LM.lead_sports_types REGEXP '(^|,)(".$str.")(,|$)' ";

				}

			}

			

			if($this->session->userdata('lead_search_key')!=""){

				//$sql="Select customer_id from customer_master WHERE customer_mobile_no='".$this->session->userdata('lead_search_key')."' ";
				//echo $sql;
    			//$query = $this->db->query($sql);					 
				//$crow=$query->row_array();
				//$customer_id=0;
				//if($crow['customer_id']!=""){
				//$customer_id=$crow['customer_id'];
				//}
				//$wh[]=" LM.lead_client_id='".$customer_id."'  ";
				$key=$this->session->userdata('lead_search_key');
				$wh[]=" LM.cust_info LIKE '%$key%'  ";
			}

			$wh[] = " LM.lead_id!= 0  and LM.lead_owner_id='$lead_owner_id'";

			$WHERE = implode(' and ',$wh);

			

			//echo $SQL;

			return $this->datatable->LoadJson($SQL,$WHERE);

	}

	

	public function get_all_staffs_sales(){

			$sql="Select staff_master.* from staff_master,department_master WHERE staff_master.staff_status='1' and staff_master.department_id=department_master.department_id and department_master.department_parent=2 order by staff_master.staff_name ";  

			//echo $sql;

    		$query = $this->db->query($sql);					 

			return $query->result_array();

	}

	

	public function get_all_staffs(){

			$sql="Select * from staff_master WHERE staff_master.staff_status='1' ";  

			//echo $sql;

    		$query = $this->db->query($sql);					 

			return $query->result_array();

	}

	

	public function get_lead_sports_types($lead_sports_types){

			$sql="Select * from sports_types WHERE sports_types.sports_type_id IN ($lead_sports_types) ";  

			//echo $sql;

    		$query = $this->db->query($sql);					 

			return $query->result_array();

	}

	public function delete_lead_data($uuid){

		$this->db->where('lead_uuid',$uuid);

		$this->db->delete('leads_master');

		return true;

	}



	public function update_leads_data($data, $id){

		$this->db->where('lead_id', $id);

		$this->db->update('leads_master', $data);

		return true;

	}

	public function update_leads_data_by_uuid($data, $id){

		$this->db->where('lead_uuid', $id);

		$this->db->update('leads_master', $data);

		return true;

	}

	

	

	

	

	public function get_all_leads_old(){

			$this->db->select('leads_master.*,lead_sources.lead_source_name,lead_types.lead_type_name,lead_types.color_code,customer_master.*');

	    	$this->db->from('leads_master');

			$this->db->join('lead_sources', 'lead_sources.lead_source_id = leads_master.lead_source_id', 'Left');

			$this->db->join('lead_types', 'lead_types.lead_type_id = leads_master.lead_type_id', 'Left');

			$this->db->join('customer_master', 'customer_master.customer_id = leads_master.lead_client_id', 'Left');

			$this->db->order_by("leads_master.lead_id", "DESC");

			print_r($query);

	    	$query = $this->db->get();					 

			return $query->result_array();

	}

	

	

	

	public function insert_lead_data($data){

		$this->db->set('lead_uuid', 'UUID()', FALSE);

		$this->db->insert('leads_master', $data);

		$insert_id = $this->db->insert_id();

		$lead_code_sl_no=1000;

		$lead_code=$lead_code_sl_no+$insert_id;

		$lead_code="L".$lead_code;

		$dataup = [

            'lead_code' =>$lead_code,

        ];

        $this->db->where('lead_id', $insert_id);

        $this->db->update('leads_master', $dataup);

		

		return $lead_code;

	}

	//____________________end of leads



	

}

?>
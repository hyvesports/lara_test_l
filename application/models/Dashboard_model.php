<?php defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard_model extends CI_Model
{
    //


    public function get_my_notifications_admin($date)
    {

        $sql = "SELECT notification_master.*,login_master.log_full_name FROM notification_master 
		LEFT JOIN login_master ON login_master.login_master_id=notification_master.created_by
 WHERE notification_master.notification_date='$date'  ORDER BY notification_master.notification_id DESC";
        $query = $this->db->query($sql);
        return $query->result_array();
    }



    public function get_my_notifications($date, $myid)
    {

        $sql = "SELECT notification_master.*,login_master.log_full_name FROM notification_master 
		LEFT JOIN login_master ON login_master.login_master_id=notification_master.created_by
 WHERE notification_master.notification_date='$date' and FIND_IN_SET(" . $myid . ",notification_master.notification_recipients) ORDER BY notification_master.notification_id DESC";
        $query = $this->db->query($sql);
        return $query->result_array();
    }
    public function get_dispatch_done($dispatch_date)
    {
        $sql = "SELECT
			WO.orderform_number,wo_shipping_types.shipping_type_name,wo_shipping_mode.shipping_mode_name
		FROM 
			tbl_dispatch
			LEFT JOIN wo_work_orders as WO on WO.order_id=tbl_dispatch.dispatch_order_id
			LEFT JOIN wo_shipping_types on wo_shipping_types.shipping_type_id=tbl_dispatch.shipping_type_id
			LEFT JOIN wo_shipping_mode ON wo_shipping_mode.shipping_mode_id=tbl_dispatch.shipping_mode_id
		WHERE
			 tbl_dispatch.dispatch_datetime LIKE '%$dispatch_date%' ";
        //			 echo $sql;
        $query = $this->db->query($sql);
        return $query->result_array();
    }


    public function get_dispatch_done_by_mode($dispatch_date, $mode)
    {
        $sql = "SELECT
			WO.orderform_number,tbl_dispatch.shipping_qty
		FROM 
			tbl_dispatch
			LEFT JOIN wo_work_orders as WO on WO.order_id=tbl_dispatch.dispatch_order_id
			LEFT JOIN wo_shipping_types on wo_shipping_types.shipping_type_id=tbl_dispatch.shipping_type_id
			LEFT JOIN wo_shipping_mode ON wo_shipping_mode.shipping_mode_id=tbl_dispatch.shipping_mode_id
		WHERE
			 tbl_dispatch.dispatch_datetime LIKE '%$dispatch_date%' and tbl_dispatch.shipping_mode_id='" . $mode . "'";
        //			 echo $sql;
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function get_design_done($date)
    {
    $totalDesignCount=0;
        $sql = "SELECT summary_item_id,submitted_item FROM rs_design_departments,wo_order_summary WHERE wo_order_summary.order_summary_id=rs_design_departments.summary_item_id and rs_design_departments.from_department='design' and to_department='design_qc' and submitted_datetime LIKE '%$date%' AND row_status!='rejected' ";

//        echo $sql;
        $query = $this->db->query($sql);
	           $dataArray =    $query->result_array();
        $totalDesignCount = 0;
        if ($dataArray) {
            foreach ($dataArray as $d) {
                $dataJson = json_decode($d['submitted_item'], true);

                foreach ($dataJson as $postkey => $postvalue) {
			                    if ($dataJson[$postkey]['item_unit_qty_input'] != 0  && $dataJson[$postkey]['item_re_schedule_id'] !=1  && $d['summary_item_id'] == $dataJson[$postkey]['summary_id'] ) {
                        //print_r($dataJson[$postkey]['item_unit_qty_input']);
                       $totalDesignCount = $totalDesignCount + $dataJson[$postkey]['item_unit_qty_input'];
                    }
                }
            }
        }

return $totalDesignCount;

    }



    public function get_design_qc_done($date)
    {
    $totalDesignCount=0;
        $sql = "SELECT summary_item_id,submitted_item FROM rs_design_departments,wo_order_summary WHERE wo_order_summary.order_summary_id=rs_design_departments.summary_item_id and rs_design_departments.from_department='design' and to_department='design_qc' and verify_status='1' and row_status='approved' and  submitted_datetime LIKE '%$date%' AND row_status!='rejected' ";

//        echo $sql;
        $query = $this->db->query($sql);
	                $dataArray =    $query->result_array();
        $totalDesignCount = 0;
        if ($dataArray) {
            foreach ($dataArray as $d) {
                $dataJson = json_decode($d['submitted_item'], true);

                foreach ($dataJson as $postkey => $postvalue) {

                    if ($dataJson[$postkey]['item_unit_qty_input'] != 0  && $dataJson[$postkey]['item_re_schedule_id'] !=1 && $d['summary_item_id'] == $dataJson[$postkey]['summary_id'] ) {
                        //print_r($dataJson[$postkey]['item_unit_qty_input']);
                       $totalDesignCount = $totalDesignCount + $dataJson[$postkey]['item_unit_qty_input'];
                    }
                }
            }
        }

return $totalDesignCount;

    }


    public function get_print_done($date)
    {
    $totalDesignCount=0;
        $sql = "SELECT summary_item_id,submitted_item FROM rs_design_departments,wo_order_summary WHERE wo_order_summary.order_summary_id=rs_design_departments.summary_item_id and rs_design_departments.from_department='printing' and to_department='fusing' and verify_status='1'  and  submitted_datetime LIKE '%$date%' AND row_status!='rejected' ";

//        echo $sql;
        $query = $this->db->query($sql);
	                $dataArray =    $query->result_array();
        $totalDesignCount = 0;
        if ($dataArray) {
            foreach ($dataArray as $d) {
                $dataJson = json_decode($d['submitted_item'], true);

                foreach ($dataJson as $postkey => $postvalue) {
                    if ($dataJson[$postkey]['item_unit_qty_input'] != 0  && $dataJson[$postkey]['item_re_schedule_id'] !=1 && $d['summary_item_id'] == $dataJson[$postkey]['summary_id'] ) {
                        //print_r($dataJson[$postkey]['item_unit_qty_input']);
                       $totalDesignCount = $totalDesignCount + $dataJson[$postkey]['item_unit_qty_input'];
                    }
                }
            }
        }

return $totalDesignCount;

    }


        public function get_fusing_done($date)
    {
    $totalDesignCount=0;
        $sql = "SELECT summary_item_id,submitted_item FROM rs_design_departments,wo_order_summary WHERE wo_order_summary.order_summary_id=rs_design_departments.summary_item_id and rs_design_departments.from_department='fusing' and to_department='bundling' and verify_status !='-1'  and submitted_datetime LIKE '%$date%' AND row_status!='rejected' ";

//        echo $sql;
        $query = $this->db->query($sql);
	                $dataArray =    $query->result_array();
        $totalDesignCount = 0;
        if ($dataArray) {
            foreach ($dataArray as $d) {
                $dataJson = json_decode($d['submitted_item'], true);

                foreach ($dataJson as $postkey => $postvalue) {
                    if ($dataJson[$postkey]['item_unit_qty_input'] != 0  && $dataJson[$postkey]['item_re_schedule_id'] !=1 && $d['summary_item_id'] == $dataJson[$postkey]['summary_id'] ) {
                        //print_r($dataJson[$postkey]['item_unit_qty_input']);
                       $totalDesignCount = $totalDesignCount + $dataJson[$postkey]['item_unit_qty_input'];
                    }
                }
            }
        }

return $totalDesignCount;

    }


        public function get_bundling_done($date)
    {
    $totalDesignCount=0;
        $sql = "SELECT summary_item_id,submitted_item FROM rs_design_departments,wo_order_summary WHERE wo_order_summary.order_summary_id=rs_design_departments.summary_item_id and rs_design_departments.from_department='fusing' and to_department='bundling' and verify_status='1' and row_status='approved' and  submitted_datetime LIKE '%$date%' AND row_status!='rejected' ";

//        echo $sql;
        $query = $this->db->query($sql);
	                $dataArray =    $query->result_array();
        $totalDesignCount = 0;
        if ($dataArray) {
            foreach ($dataArray as $d) {
                $dataJson = json_decode($d['submitted_item'], true);

                foreach ($dataJson as $postkey => $postvalue) {
                    if ($dataJson[$postkey]['item_unit_qty_input'] != 0  && $dataJson[$postkey]['item_re_schedule_id'] !=1 && $d['summary_item_id'] == $dataJson[$postkey]['summary_id'] ) {
                        //print_r($dataJson[$postkey]['item_unit_qty_input']);
                       $totalDesignCount = $totalDesignCount + $dataJson[$postkey]['item_unit_qty_input'];
                    }
                }
            }
        }

return $totalDesignCount;

    }


        public function get_stitching_done($date)
    {
    $totalDesignCount=0;
        $sql = "SELECT summary_item_id,submitted_item FROM rs_design_departments,wo_order_summary WHERE wo_order_summary.order_summary_id=rs_design_departments.summary_item_id and rs_design_departments.from_department='stitching' and to_department='final_qc' and verify_status !='-1' and  submitted_datetime LIKE '%$date%' AND row_status!='rejected' ";

//        echo $sql;
        $query = $this->db->query($sql);
	                $dataArray =    $query->result_array();
        $totalDesignCount = 0;
        if ($dataArray) {
            foreach ($dataArray as $d) {
                $dataJson = json_decode($d['submitted_item'], true);

                foreach ($dataJson as $postkey => $postvalue) {
                    if ($dataJson[$postkey]['item_unit_qty_input'] != 0  && $dataJson[$postkey]['item_re_schedule_id'] !=1 && $d['summary_item_id'] == $dataJson[$postkey]['summary_id'] ) {
                        //print_r($dataJson[$postkey]['item_unit_qty_input']);
                       $totalDesignCount = $totalDesignCount + $dataJson[$postkey]['item_unit_qty_input'];
                    }
                }
            }
        }

return $totalDesignCount;

    }



        public function get_final_qc_done($date)
    {
    $totalDesignCount=0;
        $sql = "SELECT summary_item_id,submitted_item FROM rs_design_departments,wo_order_summary WHERE wo_order_summary.order_summary_id=rs_design_departments.summary_item_id and rs_design_departments.from_department='stitching' and to_department='final_qc' and verify_status='1' and row_status='approved' and  submitted_datetime LIKE '%$date%' AND row_status!='rejected' ";

//        echo $sql;
        $query = $this->db->query($sql);
	                $dataArray =    $query->result_array();
        $totalDesignCount = 0;
        if ($dataArray) {
            foreach ($dataArray as $d) {
                $dataJson = json_decode($d['submitted_item'], true);

                foreach ($dataJson as $postkey => $postvalue) {
                    if ($dataJson[$postkey]['item_unit_qty_input'] != 0  && $dataJson[$postkey]['item_re_schedule_id'] !=1 && $d['summary_item_id'] == $dataJson[$postkey]['summary_id'] ) {
                        //print_r($dataJson[$postkey]['item_unit_qty_input']);
                       $totalDesignCount = $totalDesignCount + $dataJson[$postkey]['item_unit_qty_input'];
                    }
                }
            }
        }

return $totalDesignCount;

    }





    
    public function get_design_total($date)
    {
        $sql = "SELECT scheduled_order_info FROM sh_schedule_departments WHERE  FIND_IN_SET('4',department_ids)  and department_schedule_date  LIKE '%$date%' ";
//		     echo $sql;
        $query = $this->db->query($sql);
        $dataArray =    $query->result_array();
        $totalDesignCount = 0;
        if ($dataArray) {
            foreach ($dataArray as $d) {
                $dataJson = json_decode($d['scheduled_order_info'], true);

                foreach ($dataJson as $postkey => $postvalue) {
                    if ($dataJson[$postkey]['item_unit_qty_input'] != 0 && $dataJson[$postkey]['item_re_schedule_id'] !=1) {
                        //print_r($dataJson[$postkey]['item_unit_qty_input']);
                       $totalDesignCount = $totalDesignCount + $dataJson[$postkey]['item_unit_qty_input'];
                    }
                }
            }
        }

        return $totalDesignCount;
    }
    public function get_dispatch_done_total($date)
    {
        $sql = "SELECT sum(shipping_qty) as  cnt from tbl_dispatch tbl,wo_work_orders wo where wo.order_id=dispatch_order_id and dispatch_datetime  LIKE '%$date%' ";
//group by wo.order_id ";
        //	echo $sql;
        $query = $this->db->query($sql);
        $record=$query->row_array();
	$rec = $record['cnt'];
    if($rec =='')
    {
        $rec = 0;
    }
	return $rec;
    }

    public function get_design_qc_rejected($dd)
    {

        $sql = "SELECT  submitted_item,summary_item_id FROM sh_schedule_departments AS SHD ,  sh_schedules as SH , rs_design_departments AS RDS,  wo_work_orders AS WO,wo_order_summary WOS WHERE RDS.summary_item_id=WOS.order_summary_id and   WOS.wo_order_id=WO.order_id and   WO.order_id=SHD.order_id and RDS.schedule_id=SHD.schedule_id  and   SHD.schedule_id=SH.schedule_id and FIND_IN_SET(11,SHD.department_ids) AND   rejected_department='Design QC' and row_status='rejected' and submitted_datetime LIKE '%$dd%' ";

        //	      echo $sql;
        $query = $this->db->query($sql);
        $dataArray =     $query->result_array();
        $totalDesignCount = 0;




        if ($dataArray) {
            foreach ($dataArray as $d) {
                $dataJson = json_decode($d['submitted_item'], true);
                foreach ($dataJson as $postkey => $postvalue) {
                    if ($dataJson[$postkey]['item_unit_qty_input'] != 0 && $d['summary_item_id'] == $dataJson[$postkey]['summary_id']) {

                        $designQc['order_no'] = $dataJson[$postkey]['orderno'];
                        $designQc['qty'] = $dataJson[$postkey]['item_unit_qty_input'];
                        $designQcArray[] = $designQc;
                    }
                }
            }
        }

        return $designQcArray;
    }

    public function get_design_bundling_rejected($dd)
    {

        //$sql="SELECT  SHD.department_schedule_date,WO.orderform_number,order_total_submitted_qty FROM sh_schedule_departments AS SHD ,  sh_schedules as SH , rs_design_departments AS RDS,  wo_work_orders AS WO WHERE WO.order_id=SHD.order_id and RDS.schedule_id=SHD.schedule_id  and   SHD.schedule_id=SH.schedule_id and FIND_IN_SET(12,SHD.department_ids) AND   rejected_department='Bundling QC' and row_status='rejected' and submitted_datetime LIKE '%$dd%' GROUP BY WO.order_id";

        $sql = "select rejected_qty as qty,orderform_number as order_no from sh_schedule_department_rejections RDS, wo_work_orders AS WO,wo_order_summary WOS WHERE RDS.summary_id=WOS.order_summary_id and   WOS.wo_order_id=WO.order_id AND rejected_from_departments='Bundling QC' and rejected_datetime LIKE '%$dd%'";

        //	      echo $sql;
        $query = $this->db->query($sql);
        return                  $query->result_array();
    }

    public function get_design_final_qc_rejected($dd)
    {
        $sql = "select rejected_qty as qty,orderform_number as order_no from sh_schedule_department_rejections RDS, wo_work_orders AS WO,wo_order_summary WOS WHERE RDS.summary_id=WOS.order_summary_id and   WOS.wo_order_id=WO.order_id AND rejected_from_departments='Final QC' and rejected_datetime LIKE '%$dd%'";

        //	      echo $sql;
        $query = $this->db->query($sql);
        return                  $query->result_array();
    }


    public function get_wo_pending_with_accounts($selDate)
    {

        $sql = "select orderform_number,wo_gross_cost ,(wo_advance+wo_balance) as amount from wo_work_orders WHERE accounts_completed_status='0' AND orderform_type_id='1' and production_completed_status='1'  order by wo_date desc";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function get_wo_completed_with_accounts($selDate)
    {

        $sql = "select orderform_number,wo_gross_cost, (wo_advance+wo_balance) as amount from wo_work_orders WHERE accounts_completed_status='1' AND orderform_type_id='1' and production_completed_status='1'  order by wo_date desc";

        //print_r($sql);
        //exit();
        $query = $this->db->query($sql);
        return $query->result_array();
    }




    //design

    public function get_wo_form_designing_stage($id, $date)
    {
        $wh = array();
        $SQL = 'SELECT IFNULL(RDS.verify_status,0) as verify_status,
				SH.*,
				SHD.department_schedule_date,
				SHD.scheduled_order_info,
				SHD.schedule_department_id,
				SHD.order_is_approved,
				SHD.is_re_scheduled,SHD.batch_number,
				WO.wo_date_time,WO.lead_id,
				WO.orderform_type_id,WO.orderform_number,WO.wo_product_info
			FROM
				sh_schedule_departments AS SHD  ';
        $SQL .= 'LEFT JOIN sh_schedules  as SH on  SHD.schedule_id=SH.schedule_id ';
        $SQL .= "LEFT JOIN rs_design_departments AS RDS ON RDS.schedule_id=SHD.schedule_id  and RDS.schedule_department_id=SHD.schedule_department_id and from_department='design'";
        $SQL .= ", wo_work_orders AS WO ";
        //echo $SQL;
        $cdate = date('Y-m-d');
        $WHERE = ' WHERE   WO.order_id=SHD.order_id and FIND_IN_SET(' . $id . ',SHD.department_ids) AND SHD.department_schedule_date ="' . $date . '"  ';

        $query = $SQL . $WHERE;

        //echo $query;
        $query = $this->db->query($query);
        return $query->result_array();
    }


    public function get_wo_form_other_stage($id, $date)
    {
        $wh = array();
        $SQL = 'SELECT IFNULL(RDS.verify_status,0) as verify_status,
				SH.*,
				SHD.department_schedule_date,
				SHD.scheduled_order_info,
				SHD.schedule_department_id,
				SHD.order_is_approved,
				SHD.is_re_scheduled,SHD.batch_number,
				WO.wo_date_time,WO.lead_id,
				WO.orderform_type_id,WO.orderform_number,WO.wo_product_info
			FROM
				sh_schedule_departments AS SHD  ';
        $SQL .= 'LEFT JOIN sh_schedules  as SH on  SHD.schedule_id=SH.schedule_id ';
        $SQL .= "LEFT JOIN rs_design_departments AS RDS ON RDS.schedule_id=SHD.schedule_id   and from_department='design'";
        $SQL .= ", wo_work_orders AS WO ";

        $cdate = date('Y-m-d');
        $WHERE = 'WHERE RDS.verify_status="1" AND  WO.order_id=SHD.order_id and FIND_IN_SET(' . $id . ',SHD.department_ids) AND SHD.department_schedule_date ="' . $date . '"  ';

        $query = $SQL . $WHERE;

        //echo $query;
        $query = $this->db->query($query);
        return $query->result_array();
    }


    public function get_wo_form_normal_stage($id, $date)
    {
        $wh = array();
        $SQL = 'SELECT IFNULL(RDS.verify_status,0) as verify_status,
				SH.*,
				SHD.department_schedule_date,
				SHD.scheduled_order_info,
				SHD.schedule_department_id,
				SHD.order_is_approved,
				SHD.is_re_scheduled,SHD.batch_number,
				WO.wo_date_time,WO.lead_id,
				WO.orderform_type_id,WO.orderform_number,WO.wo_product_info
			FROM
				sh_schedule_departments AS SHD  ';
        $SQL .= 'LEFT JOIN sh_schedules  as SH on  SHD.schedule_id=SH.schedule_id ';
        $SQL .= "LEFT JOIN rs_design_departments AS RDS ON RDS.schedule_id=SHD.schedule_id   and from_department='design'";
        $SQL .= ", wo_work_orders AS WO ";

        $cdate = date('Y-m-d');
        $WHERE = 'WHERE    WO.order_id=SHD.order_id and FIND_IN_SET(' . $id . ',SHD.department_ids) AND SHD.department_schedule_date ="' . $date . '"  ';

        $query = $SQL . $WHERE;

        //echo $query;
        $query = $this->db->query($query);
        return $query->result_array();
    }

    public function get_wo_total_stitching_orders($date)
    {
        $sql = " select SUM(WOS.wo_qty) AS qty from wo_work_orders WO, wo_order_summary WOS,
                  sh_schedules SHD where         WOS.wo_order_id=WO.order_id  
                   AND  
                  WO.order_id=SHD.order_id and
                  accounts_completed_status='0' AND SHD.schedule_date   LIKE '%$date%'";

        //echo $sql;
        $query = $this->db->query($sql);
        return $query->row_array();
    }

    public function get_wo_total_stitching($month,$year)
    {
        $sql = " select submitted_item,summary_item_id from
              wo_work_orders WO, 
              wo_order_summary WOS,
              rs_design_departments RDS
              where        
               WOS.wo_order_id=WO.order_id  and
                summary_item_id=order_summary_id and   
                    from_department='stitching'  
                    AND (verify_status='1' || verify_status='0') AND is_current='1'
                         AND substr(submitted_datetime,7,5)='".$year."'
                         AND substr(submitted_datetime,4,2)='".$month."'
                           ";

//                echo $sql;
        $query = $this->db->query($sql);
        $dataArray =    $query->result_array();
        $totalQtyCount = 0;

        if ($dataArray) {
            foreach ($dataArray as $d) {
                
                $dataJson = json_decode($d['submitted_item'], true);


                foreach ($dataJson as $postkey => $postvalue) {
                    if ($dataJson[$postkey]['item_unit_qty_input'] != 0 && $d['summary_item_id'] == $dataJson[$postkey]['summary_id']) {
                        
          
                        $totalQtyCount = (int)$totalQtyCount + (int) $dataJson[$postkey]['item_unit_qty_input'];

                        //              echo  $totalQtyCount."<br>";
                    }
                }
            }
        }

        
        return $totalQtyCount;
        
        
    }


    public function get_wo_total_counts_by_stage($date, $type, $department)
    {
        $sql = " select count(*) as cnt from wo_work_orders WO, wo_order_summary WOS,rs_design_departments RDS,sh_schedules SHD,sh_schedule_departments SH where         WOS.wo_order_id=WO.order_id  and summary_item_id=order_summary_id and    SH.order_id=WO.order_id and FIND_IN_SET($type,SH.department_ids) AND   WO.order_id=SHD.order_id  AND   RDS.schedule_id=SHD.schedule_id AND  from_department='" . $department . "'  AND verify_status='1'  AND verify_datetime LIKE '%$date%' group by WO.order_id";

        //echo $sql;
        $query = $this->db->query($sql);
        return $query->row_array();
    }
    public function get_wo_total_counts_by_stage_design($date, $did)
    {

        $cdate = $date;
	$totalQtyCount=0;
        $SQL = 'SELECT order_uuid,order_total_submitted_qty,
                                SH.schedule_uuid,
                                SH.order_id,
                                SH.schedule_id,
                                SHD.batch_number,
                                SHD.department_schedule_date,
                                SHD.scheduled_order_info,
                                SHD.schedule_department_id,
                                SHD.order_is_approved,
                                SHD.is_re_scheduled
                        FROM
                                sh_schedule_departments AS SHD  ';
        $SQL .= 'LEFT JOIN sh_schedules  as SH on  SHD.schedule_id=SH.schedule_id ';
        $SQL .= "LEFT JOIN wo_work_orders as WO on WO.order_id=SH.order_id ";
	$SQL .= 'WHERE FIND_IN_SET(' . $did . ',SHD.department_ids) AND SHD.department_schedule_date like "' . $cdate . '%"'; 
        $SQL .= ' ORDER BY SHD.department_schedule_date ASC ';

//echo $SQL;

        $query = $this->db->query($SQL);
        $dataArrayF =     $query->result_array();
        if ($dataArrayF) {
            foreach ($dataArrayF as  $d) {
                
                $dataJson = json_decode($d['scheduled_order_info'], true);
                foreach ($dataJson as $postkey => $postvalue) {
                    if ($dataJson[$postkey]['item_unit_qty_input'] != 0 && $dataJson[$postkey]['is_re_scheduled'] !='1') {
                        $totalQtyCount = (int)$totalQtyCount + (int) $dataJson[$postkey]['item_unit_qty_input'];
                    }
					
                }
            }
        }
        return $totalQtyCount;
        
        
    }
    
    public function get_wo_total_counts_by_fusing($date, $type, $department)
    {
        $sql = " select count(*) as cnt from wo_work_orders WO, wo_order_summary WOS,rs_design_departments RDS,sh_schedules SHD,sh_schedule_departments SH where         WOS.wo_order_id=WO.order_id  and summary_item_id=order_summary_id and    SH.order_id=WO.order_id and FIND_IN_SET($type,SH.department_ids) AND   WO.order_id=SHD.order_id and   RDS.schedule_id=SHD.schedule_id AND  from_department='" . $department . "'  AND verify_status='0'  AND submitted_datetime LIKE '%$date%' group by WO.order_id";

        //echo $sql;
        $query = $this->db->query($sql);
        return $query->row_array();
    }

    public function get_wo_total_counts_by_stitching($date, $type, $department)
    {
        $sql = " select count(*) as cnt from wo_work_orders WO, wo_order_summary WOS,rs_design_departments RDS,sh_schedules SHD,sh_schedule_departments SH where         WOS.wo_order_id=WO.order_id  and summary_item_id=order_summary_id and    SH.order_id=WO.order_id and FIND_IN_SET($type,SH.department_ids) AND   WO.order_id=SHD.order_id and   RDS.schedule_id=SHD.schedule_id AND  from_department='" . $department . "'  AND verify_status in('0','1')   AND submitted_datetime LIKE '%$date%' group by WO.order_id";

        //echo $sql;
        $query = $this->db->query($sql);
        return $query->row_array();
    }





    public function get_wo_total_qty_count($month, $year)
    {
        //$sql=" select WO.order_id from wo_work_orders WO, wo_order_summary WOS,rs_design_departments RDS,sh_schedules SHD,sh_schedule_departments SH where         WOS.wo_order_id=WO.order_id  and summary_item_id=order_summary_id and    SH.order_id=WO.order_id and FIND_IN_SET(8,SH.department_ids) AND   WO.order_id=SHD.order_id and  RDS.schedule_id=SHD.schedule_id AND  from_department='stitching'  AND (verify_status='0' || verify_status='1') AND accounts_completed_status='0' AND submitted_datetime LIKE '%$date%' group by WO.order_id";
       
        $sql = "SELECT 	wo_work_orders.order_id
        FROM wo_work_orders  
          LEFT JOIN wo_status ON wo_status.wo_status_id = wo_work_orders.wo_status_id 
          LEFT JOIN priority_master as PM on PM.priority_id=wo_work_orders.wo_work_priority_id
           LEFT JOIN sh_schedules ON sh_schedules.order_id=wo_work_orders.order_id
     WHERE    wo_work_orders.order_id != '0' 
     AND wo_work_orders.submited_to_production='yes'
      AND wo_work_orders.wo_row_status='1' AND 
      MONTH(sh_schedules.schedule_date) ='" . $month . "' 
      AND year(sh_schedules.schedule_date) ='" . $year . "'
      group by wo_work_orders.order_id    ";
        
	        //echo $sql;

        $query = $this->db->query($sql);
	$records=$query->result_array();
	$rec['cnt'] =count($records);


	return  $rec;
    }


    public function get_wo_total_stitching_orders_by_type($month, $year, $type)
    {
        $sql = "SELECT 	wo_work_orders.order_id
        FROM wo_work_orders  
          LEFT JOIN wo_status ON wo_status.wo_status_id = wo_work_orders.wo_status_id 
          LEFT JOIN priority_master as PM on PM.priority_id=wo_work_orders.wo_work_priority_id
           LEFT JOIN sh_schedules ON sh_schedules.order_id=wo_work_orders.order_id 
     WHERE   wo_work_orders.orderform_type_id='" . $type . "' AND wo_work_orders.order_id != '0' 
     AND wo_work_orders.submited_to_production='yes'
      AND wo_work_orders.wo_row_status='1' AND 
      MONTH(sh_schedules.schedule_date) ='" . $month . "' 
      AND year(sh_schedules.schedule_date) ='" . $year . "'
      group by wo_work_orders.order_id  ";

                $query = $this->db->query($sql);
                     $records=$query->result_array();
		     	              $rec['cnt'] =count($records);


        return  $rec;
	
    }


    public function get_wo_total_stitching_orders_avg($date)
    {
        $sql = " select WO.wo_gross_cost as avg  from wo_work_orders WO, wo_order_summary WOS,rs_design_departments RDS,sh_schedules SHD,sh_schedule_departments SH where         WOS.wo_order_id=WO.order_id  and summary_item_id=order_summary_id and    SH.order_id=WO.order_id and FIND_IN_SET(8,SH.department_ids) AND   WO.order_id=SHD.order_id AND   RDS.schedule_id=SHD.schedule_id AND  from_department='stitching'  AND (verify_status='0' || verify_status='1') AND accounts_completed_status='0' AND submitted_datetime LIKE '%$date%'  group by WO.order_id";
        $amount = 0;

        $query = $this->db->query($sql);
        $result = $query->result_array();
        foreach ($result as $ra) {
            $amount += $ra['avg'];
        }
        $averageAmount = $amount / count($result);
        return floor($averageAmount);
    }


    public function get_wo_form_stitching_unit($unit_managed, $date)
    {
        $wh = array();
        $SQL = 'SELECT 
				SH.*,
				SHD.department_schedule_date,
				SHD.scheduled_order_info,
				SHD.schedule_department_id,
				SHD.order_is_approved,
				SHD.is_re_scheduled,SHD.batch_number,
				WO.wo_date_time,WO.lead_id,
				WO.orderform_type_id,WO.orderform_number,WO.wo_product_info
			FROM
				sh_schedule_departments AS SHD  ';
        $SQL .= 'LEFT JOIN sh_schedules  as SH on  SHD.schedule_id=SH.schedule_id ';
        $SQL .= ", wo_work_orders AS WO ";
        //echo $SQL;
        $cdate = date('Y-m-d');
        $WHERE = ' WHERE   WO.order_id=SHD.order_id and FIND_IN_SET(8,SHD.department_ids) AND SHD.department_schedule_date ="' . $date . '" AND SHD.unit_id IN(' . $unit_managed . ') ';

        $query = $SQL . $WHERE;

        //echo $query;
        $query = $this->db->query($query);
        return $query->result_array();
    }
    public function get_wo_form_stitching($type, $date)
    {
        $wh = array();
        $SQL = 'SELECT 
				SH.*,
				SHD.department_schedule_date,
				SHD.scheduled_order_info,
				SHD.schedule_department_id,
				SHD.order_is_approved,
				SHD.is_re_scheduled,SHD.batch_number,
				WO.wo_date_time,WO.lead_id,
				WO.orderform_type_id,WO.orderform_number,WO.wo_product_info
			FROM
				sh_schedule_departments AS SHD  ';
        $SQL .= 'LEFT JOIN sh_schedules  as SH on  SHD.schedule_id=SH.schedule_id ';
        $SQL .= ", wo_work_orders AS WO ";
        //echo $SQL;
        $cdate = date('Y-m-d');
        $WHERE = ' WHERE   WO.order_id=SHD.order_id and FIND_IN_SET(8,SHD.department_ids) AND SHD.department_schedule_date ="' . $date . '" and WO.orderform_type_id="' . $type . '" ';

        $query = $SQL . $WHERE;
        $query = $this->db->query($query);
        return $query->result_array();
    }
    public function get_wo_submitted($date)
    {
        $this->db->select('wo_work_orders.*,customer_master.customer_name,customer_master.customer_email,customer_master.customer_mobile_no,staff_master.staff_code,staff_master.staff_name');
        $this->db->from('wo_work_orders');
        $this->db->join('customer_master', 'customer_master.customer_id= wo_work_orders.wo_client_id', 'Left');
        $this->db->join('staff_master', 'staff_master.staff_id = wo_work_orders.wo_owner_id', 'Left');
        $this->db->order_by("wo_work_orders.order_id", "DESC");
        $this->db->where('wo_work_orders.submited_to_production', 'yes');
        $this->db->like('wo_work_orders.submited_date', $date);

        $query = $this->db->get();
        //print_r($this->db->last_query());				 
        return $query->result_array();
    }

    public function get_wo_orders_by_nature($date, $type)
    {
        $sql = "select sh_schedules.order_total_qty,wo_work_orders.orderform_number,customer_master.customer_name,customer_master.customer_email,customer_master.customer_mobile_no,staff_master.staff_code,staff_master.staff_name from sh_schedules,wo_work_orders LEFT join customer_master ON customer_master.customer_id= wo_work_orders.wo_client_id Left JOIN staff_master ON staff_master.staff_id = wo_work_orders.wo_owner_id  	where  wo_order_nature_id='" . $type . "' AND sh_schedules.order_id=wo_work_orders.order_id  AND wo_c_date LIKE '%$date%'
		order by wo_work_orders.order_id  DESC ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function get_wo_edit_request($date)
    {
        $this->db->select('wo_work_orders.*,customer_master.customer_name,customer_master.customer_email,customer_master.customer_mobile_no,staff_master.staff_code,staff_master.staff_name');
        $this->db->from('wo_work_orders');
        $this->db->join('customer_master', 'customer_master.customer_id= wo_work_orders.wo_client_id', 'Left');
        $this->db->join('staff_master', 'staff_master.staff_id = wo_work_orders.wo_owner_id', 'Left');
        $this->db->order_by("wo_work_orders.order_id", "DESC");
        $this->db->where('wo_work_orders.wo_edit_request_status', 1);
        $query = $this->db->get();
        //print_r($this->db->last_query());				 
        return $query->result_array();
    }


    //_________________________________________________________________



    public function get_dispatch_pending_orders($cdate)
    {


        $wh = array();
        $records = array();
        $SQL = 'SELECT  order_uuid ,
			order_total_submitted_qty,
                                SHD.department_schedule_date,
                                SHD.scheduled_order_info,
                                SHD.schedule_department_id,
                                SHD.is_re_scheduled,
                                WO.wo_date_time,SH.schedule_id,
                                WO.orderform_type_id,WO.orderform_number,PO.production_unit_name,WO.wo_product_info,PM.priority_color_code,PM.priority_name,
SHD.total_order_items as TOTAL_COUNT,IFNULL(WO.accounts_completed_status,0) as account_status
                        FROM
                                sh_schedule_departments AS SHD  ';
        $SQL .= 'LEFT JOIN sh_schedules  as SH on  SHD.schedule_id=SH.schedule_id ';
        $SQL .= "LEFT JOIN wo_work_orders as WO on WO.order_id=SH.order_id ";
        $SQL .= "LEFT JOIN staff_master as SM on SM.staff_id=WO.wo_owner_id AND WO.lead_id!=0 ";
        $SQL .= "LEFT JOIN pr_production_units as PO on PO.production_unit_id=SHD.unit_id ";
        $SQL .= "LEFT JOIN priority_master as PM on PM.priority_id=WO.wo_work_priority_id ";
        $SQL .= " where FIND_IN_SET(10,SHD.department_ids) AND SHD.unit_id IN(0,1,2,3) and SHD.department_schedule_date <'" . $cdate . "'";
        $SQL .= ' and SHD.total_order_items!=(SELECT count(*) FROM rs_design_departments as T111 WHERE T111.schedule_id=SHD.schedule_id and T111.is_current=1 and T111.to_department="final_qc" and T111.verify_status=1) GROUP BY SHD.order_id';

        $SQL .= ' AND SH.order_id!=""  ORDER BY SHD.department_schedule_date ASC ';
        
        $query = $this->db->query($SQL);
        $dataArray =     $query->result_array();
        if ($dataArray) {
            foreach ($dataArray as  $row) {


                /*if ($row['is_re_scheduled'] > 0) {
                    $dispatchRow = $this->common_model->get_order_final_dispatch_date_by_field($row['is_re_scheduled']);
                } else {
                    $dispatchRow = $this->common_model->get_order_final_dispatch_date_by_field($row['schedule_id']);
                }
                */

                $data['orderform_number'] = $row['orderform_number'];
                //$data['TOTAL_COUNT']=$row['TOTAL_COUNT'];
                $data['TOTAL_COUNT'] = $row['order_total_submitted_qty'];
                //$data['date'] = date("d-m-Y", strtotime($dispatchRow['department_schedule_date']));
                $data['date'] = $row['department_schedule_date'] ;
                $records[] = $data;
            }
        }

        //error_log(print_r($records,TRUE),0);
        return $records;
    }




    public function get_wo_from_pending_finalqc($department_id, $date)
    {

        $recordsF = array();
        $SQLF = "SELECT  order_uuid ,
       SH.schedule_uuid,SH.order_id,SH.schedule_id,
      SHD.batch_number,order_total_submitted_qty,
      SHD.department_schedule_date,
      SHD.scheduled_order_info,SHD.schedule_department_id,
      SHD.order_is_approved,SHD.is_re_scheduled,WO.wo_date_time,WO.lead_id,WO.orderform_type_id,WO.orderform_number,PO.production_unit_name,WO.wo_product_info,PM.priority_color_code,PM.priority_name, SHD.total_order_items as TOTAL_COUNT 
     FROM sh_schedule_departments AS SHD  
     LEFT JOIN sh_schedules  as SH on  SHD.schedule_id=SH.schedule_id 
     LEFT JOIN wo_work_orders as WO on WO.order_id=SH.order_id 
     LEFT JOIN staff_master as SM on SM.staff_id=WO.wo_owner_id AND WO.lead_id!=0 
     LEFT JOIN pr_production_units as PO on PO.production_unit_id=SHD.unit_id 
     LEFT JOIN priority_master as PM on PM.priority_id=WO.wo_work_priority_id 
    where  SHD.department_schedule_date < '" . $date . "' AND 
    FIND_IN_SET(13,SHD.department_ids) AND SHD.unit_id IN(0,1,2,3) and 
   SHD.total_order_items!=(SELECT count(*) FROM rs_design_departments as T111 WHERE T111.schedule_id=SHD.schedule_id and T111.is_current=1 and T111.to_department='final_qc' and T111.verify_status='1') and WO.order_id !='' ";

        //print_r($SQL);
        //exit();
                $SQLF .= ' AND SH.order_id!=""  ORDER BY SHD.department_schedule_date ASC ';
        $query = $this->db->query($SQLF);
        $dataArrayF =     $query->result_array();
        if ($dataArrayF) {
            foreach ($dataArrayF as  $rowF) {

                /*if ($rowF['is_re_scheduled'] > 0) {
                    $dispatchRowF = $this->common_model->get_order_final_dispatch_date_by_field($rowF['is_re_scheduled']);
                } else {
                    $dispatchRowF = $this->common_model->get_order_final_dispatch_date_by_field($rowF['schedule_id']);
                }
                */
                $dataF['orderform_number'] = '<td><a href="' . base_url('/workorder/view/' . $rowF['order_uuid']) . '"><span class="badge" style="background-color:' . $rowF['priority_color_code'] . ';" >' . $rowF['orderform_number'] . '</span></a></td>';
                //$dataF['orderform_number']=$rowF['orderform_number'];
                $dataF['priority_color_code'] = $rowF['priority_color_code'];
                //$data['TOTAL_COUNT']=$row['TOTAL_COUNT'];
                $dataF['TOTAL_COUNT'] = $rowF['order_total_submitted_qty'];
                //$dataF['date'] = date("d-m-Y", strtotime($dispatchRowF['department_schedule_date']));
                                        $dataF['date'] = $rowF['department_schedule_date'] ;
                $recordsF[] = $dataF;
            }
        }

        //error_log(print_r($records,TRUE),0);
        return $recordsF;
    }



    public function get_wo_from_completed_finalqc($department_id, $date)
    {

        $recordsF = array();
        $SQLF = "SELECT  order_uuid ,
       SH.schedule_uuid,SH.order_id,SH.schedule_id,
      SHD.batch_number,order_total_submitted_qty,
      SHD.department_schedule_date,
      SHD.scheduled_order_info,SHD.schedule_department_id,
      SHD.order_is_approved,SHD.is_re_scheduled,WO.wo_date_time,WO.lead_id,WO.orderform_type_id,WO.orderform_number,PO.production_unit_name,WO.wo_product_info,PM.priority_color_code,PM.priority_name, SHD.total_order_items as TOTAL_COUNT ,(SELECT count(*) FROM rs_design_departments as T111 WHERE T111.schedule_id=SHD.schedule_id and T111.is_current=1 and T111.to_department='final_qc' and T111.verify_status='1') as completed_items
     FROM sh_schedule_departments AS SHD  
     LEFT JOIN sh_schedules  as SH on  SHD.schedule_id=SH.schedule_id 
     LEFT JOIN wo_work_orders as WO on WO.order_id=SH.order_id 
     LEFT JOIN staff_master as SM on SM.staff_id=WO.wo_owner_id AND WO.lead_id!=0 
     LEFT JOIN pr_production_units as PO on PO.production_unit_id=SHD.unit_id 
     LEFT JOIN priority_master as PM on PM.priority_id=WO.wo_work_priority_id 
    where  SHD.department_schedule_date < '" . $date . "' AND 
    FIND_IN_SET(13,SHD.department_ids) AND SHD.unit_id IN(0,1,2,3) and SHD.department_schedule_date like '" . $date . "%' and (
   (SHD.total_order_items=(SELECT count(*) FROM rs_design_departments as T111 WHERE T111.schedule_id=SHD.schedule_id and T111.is_current=1 and T111.to_department='final_qc' and T111.verify_status='1')) ||    (SHD.total_order_items!=(SELECT count(*) FROM rs_design_departments as T111 WHERE T111.schedule_id=SHD.schedule_id and T111.is_current=1 and T111.to_department='final_qc' and T111.verify_status='1')))";

        //print_r($SQL);
        //exit();
                $SQLF .= ' AND SH.order_id!=""  ORDER BY SHD.department_schedule_date ASC ';
        $query = $this->db->query($SQLF);
        $dataArrayF =     $query->result_array();
        if ($dataArrayF) {
            foreach ($dataArrayF as  $rowF) {
                if ($rowF['completed_items'] == $rowF['TOTAL_COUNT']) {
                    $dataF['order_scheduled_color'] = "success";
                } else {
                    $dataF['order_scheduled_color'] = "danger";
                }

                /* if ($rowF['is_re_scheduled'] > 0) {
                    $dispatchRowF = $this->common_model->get_order_final_dispatch_date_by_field($rowF['is_re_scheduled']);
                } else {
                    $dispatchRowF = $this->common_model->get_order_final_dispatch_date_by_field($rowF['schedule_id']);
                }
                */
                $dataF['orderform_number'] = $rowF['orderform_number'];
                $dataF['priority_color_code'] = $rowF['priority_color_code'];
                //$data['TOTAL_COUNT']=$row['TOTAL_COUNT'];
                $dataF['TOTAL_COUNT'] = $rowF['order_total_submitted_qty'];
                //                $dataF['date'] = date("d-m-Y", strtotime($dispatchRowF['department_schedule_date']));
                                        $dataF['date'] = $rowF['department_schedule_date'] ;
                $recordsF[] = $dataF;
            }
        }

        //error_log(print_r($records,TRUE),0);
        return $recordsF;
    }






    public function get_works_fusing($did, $unit_managed, $type, $date)
    {
        $cdate = $date;
        $recordsF = array();
        $SQL = 'SELECT  order_uuid ,
                                SH.schedule_uuid,
                                SH.order_id,
                                SH.schedule_id,
                                SHD.department_schedule_date,
                                SHD.is_re_scheduled,order_total_submitted_qty,
                                WO.orderform_type_id,WO.orderform_number,PO.production_unit_name,WO.wo_product_info,PM.priority_color_code,PM.priority_name,
SHD.total_order_items as TOTAL_COUNT,(SELECT count(*) FROM rs_design_departments as T11 WHERE T11.schedule_department_id=SHD.schedule_department_id and T11.is_current=1 and T11.from_department="fusing") as completed_items
                        FROM
                                sh_schedule_departments AS SHD  ';
        $SQL .= 'LEFT JOIN sh_schedules  as SH on  SHD.schedule_id=SH.schedule_id ';
        $SQL .= "LEFT JOIN wo_work_orders as WO on WO.order_id=SH.order_id ";
        $SQL .= "LEFT JOIN staff_master as SM on SM.staff_id=WO.wo_owner_id AND WO.lead_id!=0 ";
        $SQL .= "LEFT JOIN pr_production_units as PO on PO.production_unit_id=SHD.unit_id ";
        $SQL .= "LEFT JOIN priority_master as PM on PM.priority_id=WO.wo_work_priority_id ";
        //echo $SQL;
        if ($type == "all") {
            $SQL .= ' WHERE FIND_IN_SET(' . $did . ',SHD.department_ids) AND SHD.unit_id IN(' . $unit_managed . ')  ';
        }
        if ($type == "active") {
            $SQL .= ' WHERE FIND_IN_SET(' . $did . ',SHD.department_ids) AND SHD.unit_id IN(' . $unit_managed . ') AND SHD.department_schedule_date="' . $cdate . '"';
        }
        if ($type == "pending") {
            $SQL .= ' WHERE FIND_IN_SET(' . $did . ',SHD.department_ids) AND SHD.unit_id IN(' . $unit_managed . ') AND SHD.department_schedule_date <"' . $cdate . '"
                        and SHD.total_order_items!=(SELECT count(*) FROM rs_design_departments as T11 WHERE T11.schedule_department_id=SHD.schedule_department_id and T11.is_current=1 and T11.from_department="fusing") and WO.order_id !="" ';
        }
        if ($type == "completed") {
            $SQL .= ' WHERE  FIND_IN_SET(' . $did . ',SHD.department_ids) AND SHD.unit_id IN(' . $unit_managed . ')
                        and SHD.total_order_items=(SELECT count(*) FROM rs_design_departments as T11 WHERE T11.schedule_department_id=SHD.schedule_department_id and T11.is_current=1 and T11.from_department="fusing") ';
        }

        if ($type == "today") {
            $SQL .= ' WHERE  FIND_IN_SET(' . $did . ',SHD.department_ids) AND SHD.unit_id IN(' . $unit_managed . ') and SHD.department_schedule_date like "' . $cdate . '%"
                        and ((SHD.total_order_items=(SELECT count(*) FROM rs_design_departments as T11 WHERE T11.schedule_department_id=SHD.schedule_department_id and T11.is_current=1 and T11.from_department="fusing") || (SHD.total_order_items!=(SELECT count(*) FROM rs_design_departments as T11 WHERE T11.schedule_department_id=SHD.schedule_department_id and T11.is_current=1 and T11.from_department="fusing"))))';
        }

        $SQL .= ' AND SH.order_id!=""  ORDER BY SHD.department_schedule_date ASC ';

        $query = $this->db->query($SQL);
        $dataArrayF =     $query->result_array();
        if ($dataArrayF) {
            foreach ($dataArrayF as  $rowF) {

                if ($rowF['completed_items'] == $rowF['TOTAL_COUNT']) {
                    $dataF['order_scheduled_color'] = "success";
                } else {
                    $dataF['order_scheduled_color'] = "danger";
                }

                /*                if ($rowF['is_re_scheduled'] > 0) {
                    $dispatchRowF = $this->common_model->get_order_final_dispatch_date_by_field($rowF['is_re_scheduled']);
                } else {
                    $dispatchRowF = $this->common_model->get_order_final_dispatch_date_by_field($rowF['schedule_id']);
                }
                */
                $dataF['orderform_number'] = '<td><a href="' . base_url('/workorder/view/' . $rowF['order_uuid']) . '"><span class="badge" style="background-color:' . $rowF['priority_color_code'] . ';" >' . $rowF['orderform_number'] . '</span></a></td>';
                //$dataF['orderform_number']=$rowF['orderform_number'];
                $dataF['priority_color_code'] = $rowF['priority_color_code'];
                //$data['TOTAL_COUNT']=$row['TOTAL_COUNT'];
                $dataF['TOTAL_COUNT'] = $rowF['order_total_submitted_qty'];
                //                $dataF['date'] = date("d-m-Y", strtotime($dispatchRowF['department_schedule_date']));
                                        $dataF['date'] = $rowF['department_schedule_date'] ;
                $recordsF[] = $dataF;
            }
        }

        //error_log(print_r($records,TRUE),0);
        return $recordsF;
    }




    public function get_works_bundling($did, $unit_managed, $date, $type)
    {
        $cdate = $date;
        $recordsF = array();


        $SQL = 'SELECT  order_uuid ,
      order_total_submitted_qty,                          SH.schedule_uuid,
                                SH.order_id,
                                SH.schedule_id,
                                SHD.batch_number,
                                SHD.department_schedule_date,
                                SHD.scheduled_order_info,
                                SHD.schedule_department_id,
                                SHD.order_is_approved,
                                SHD.is_re_scheduled,
                                WO.wo_date_time,WO.lead_id,CONCAT(SM.staff_code,"-",SM.staff_name) as sales_handler1,SM.staff_name as sales_handler,
                                WO.orderform_type_id,WO.orderform_number,PO.production_unit_name,WO.wo_product_info,PM.priority_color_code,PM.priority_name,
SHD.total_order_items as TOTAL_COUNT,(SELECT count(*) FROM rs_design_departments as T11 WHERE T11.schedule_id=SHD.schedule_id and T11.is_current=1 and T11.to_department="bundling") as completed_items
                        FROM
                                sh_schedule_departments AS SHD  ';
        $SQL .= 'LEFT JOIN sh_schedules  as SH on  SHD.schedule_id=SH.schedule_id ';
        $SQL .= "LEFT JOIN wo_work_orders as WO on WO.order_id=SH.order_id ";
        $SQL .= "LEFT JOIN staff_master as SM on SM.staff_id=WO.wo_owner_id AND WO.lead_id!=0 ";
        $SQL .= "LEFT JOIN pr_production_units as PO on PO.production_unit_id=SHD.unit_id ";
        $SQL .= "LEFT JOIN priority_master as PM on PM.priority_id=WO.wo_work_priority_id ";
        //echo $SQL;
        if ($type == "all") {
            $SQL .= 'WHERE FIND_IN_SET(' . $did . ',SHD.department_ids) AND SHD.unit_id IN(' . $unit_managed . ')  ';
        }
        if ($type == "active") {
            $SQL .= 'WHERE FIND_IN_SET(' . $did . ',SHD.department_ids) AND SHD.unit_id IN(' . $unit_managed . ') AND SHD.department_schedule_date="' . $cdate . '"  ';
        }
        if ($type == "pending") {
            $SQL .= ' WHERE FIND_IN_SET(' . $did . ',SHD.department_ids) AND SHD.unit_id IN(' . $unit_managed . ') AND SHD.department_schedule_date <"' . $cdate . '"
                        and SHD.total_order_items!=(SELECT count(*) FROM rs_design_departments as T11 WHERE T11.schedule_id=SHD.schedule_id and T11.is_current=1 and T11.to_department="bundling") and WO.order_id !="" ';
            //
        }
        if ($type == "completed") {
            $SQL .= 'WHERE FIND_IN_SET(' . $did . ',SHD.department_ids) AND SHD.unit_id IN(' . $unit_managed . ')
                        and SHD.total_order_items=(SELECT count(*) FROM rs_design_departments as T11 WHERE T11.schedule_id=SHD.schedule_id and T11.is_current=1 and T11.to_department="bundling") and WO.order_id !=""';
        }

        if ($type == "today") {
            $SQL .= 'WHERE FIND_IN_SET(' . $did . ',SHD.department_ids) AND SHD.unit_id IN(' . $unit_managed . ') and SHD.department_schedule_date like "' . $cdate . '%"
                        and ((SHD.total_order_items=(SELECT count(*) FROM rs_design_departments as T11 WHERE T11.schedule_id=SHD.schedule_id and T11.is_current=1 and T11.to_department="bundling") || (SHD.total_order_items!=(SELECT count(*) FROM rs_design_departments as T11 WHERE T11.schedule_id=SHD.schedule_id and T11.is_current=1 and T11.to_department="bundling")))) ';
            //print_r($SQL);
            //exit();
        }

        $SQL .= ' AND SH.order_id!=""  ORDER BY SHD.department_schedule_date ASC ';

        //print_r($SQL);
        //exit();
        //        error_log($SQL);

        $query = $this->db->query($SQL);
        $dataArrayF =     $query->result_array();
        if ($dataArrayF) {
            foreach ($dataArrayF as  $rowF) {
                if ($rowF['completed_items'] == $rowF['TOTAL_COUNT']) {
                    $dataF['order_scheduled_color'] = "success";
                } else {
                    $dataF['order_scheduled_color'] = "danger";
                }

                /*                if ($rowF['is_re_scheduled'] > 0) {
                    $dispatchRowF = $this->common_model->get_order_final_dispatch_date_by_field($rowF['is_re_scheduled']);
                } else {
                    $dispatchRowF = $this->common_model->get_order_final_dispatch_date_by_field($rowF['schedule_id']);
                }
                */
                $dataF['orderform_number'] = '<td><a href="' . base_url('/workorder/view/' . $rowF['order_uuid']) . '"><span class="badge" style="background-color:' . $rowF['priority_color_code'] . ';" >' . $rowF['orderform_number'] . '</span></a></td>';
                //$dataF['orderform_number']=$rowF['orderform_number'];
                $dataF['priority_color_code'] = $rowF['priority_color_code'];
                //$data['TOTAL_COUNT']=$row['TOTAL_COUNT'];
                $dataF['TOTAL_COUNT'] = $rowF['order_total_submitted_qty'];
                //                $dataF['date'] = date("d-m-Y", strtotime($dispatchRowF['department_schedule_date']));
                                        $dataF['date'] = $rowF['department_schedule_date'] ;
                $recordsF[] = $dataF;
            }
        }

        //error_log(print_r($records,TRUE),0);
        return $recordsF;
    }



    public function get_works_stitching($did, $unit_managed, $date, $type)
    {
        $cdate = $date;
        $recordsF = array();

        $SQL = 'SELECT  order_uuid ,order_total_submitted_qty, 
                                SH.schedule_uuid,
                                SH.order_id,
                                SH.schedule_id,
                                SHD.batch_number,
                                SHD.department_schedule_date,
                                SHD.scheduled_order_info,
                                SHD.schedule_department_id,
                                SHD.order_is_approved,
                                SHD.is_re_scheduled,
                                WO.wo_date_time,WO.lead_id,CONCAT(SM.staff_code,"-",SM.staff_name) as sales_handler1,SM.staff_name as sales_handler,
                                WO.orderform_type_id,WO.orderform_number,PO.production_unit_name,WO.wo_product_info,PM.priority_color_code,PM.priority_name,
SHD.total_order_items as TOTAL_COUNT,(SELECT count(*) FROM rs_design_departments as T11 WHERE T11.schedule_department_id=SHD.schedule_department_id and T11.is_current=1 and T11.from_department="stitching") AS completed_items
                        FROM
                                sh_schedule_departments AS SHD  ';
        $SQL .= 'LEFT JOIN sh_schedules  as SH on  SHD.schedule_id=SH.schedule_id ';
        $SQL .= "LEFT JOIN wo_work_orders as WO on WO.order_id=SH.order_id ";
        $SQL .= "LEFT JOIN staff_master as SM on SM.staff_id=WO.wo_owner_id AND WO.lead_id!=0 ";
        $SQL .= "LEFT JOIN pr_production_units as PO on PO.production_unit_id=SHD.unit_id ";
        $SQL .= "LEFT JOIN priority_master as PM on PM.priority_id=WO.wo_work_priority_id ";
        //echo $SQL;
        if ($type == "all") {
            $SQL .= ' where FIND_IN_SET(' . $did . ',SHD.department_ids) AND SHD.unit_id IN(' . $unit_managed . ')  ';
        }
        if ($type == "active") {
            $SQL .= 'where FIND_IN_SET(' . $did . ',SHD.department_ids) AND SHD.unit_id IN(' . $unit_managed . ') AND SHD.department_schedule_date="' . $cdate . '"  ';
        }
        if ($type == "pending") {
            $SQL .= ' where FIND_IN_SET(' . $did . ',SHD.department_ids) AND SHD.unit_id IN(' . $unit_managed . ') AND SHD.department_schedule_date <"' . $cdate . '"
                        and SHD.total_order_items!=(SELECT count(*) FROM rs_design_departments as T11 WHERE T11.schedule_department_id=SHD.schedule_department_id and T11.is_current=1 and T11.from_department="stitching") and WO.order_id !=""';
        }
        if ($type == "completed") {
            $SQL .= 'where FIND_IN_SET(' . $did . ',SHD.department_ids) AND SHD.unit_id IN(' . $unit_managed . ') and SHD.total_order_items=(SELECT count(*) FROM    as T11 WHERE T11.schedule_department_id=SHD.schedule_department_id and T11.is_current=1 and T11.from_department="stitching") and WO.order_id !=""';
        }

        if ($type == "today") {
            $SQL .= 'where FIND_IN_SET(' . $did . ',SHD.department_ids) AND SHD.unit_id IN(' . $unit_managed . ') and  SHD.department_schedule_date LIKE "' . $cdate . '%" and
((SHD.total_order_items=(SELECT count(*) FROM rs_design_departments as T11 WHERE T11.schedule_department_id=SHD.schedule_department_id and T11.is_current=1 and T11.from_department="stitching") || (SHD.total_order_items!=(SELECT count(*) FROM rs_design_departments as T11 WHERE T11.schedule_department_id=SHD.schedule_department_id and T11.is_current=1 and T11.from_department="stitching") )))';
            //print_r($SQL);exit();
        }


        $SQL .= ' AND SH.order_id!=""  ORDER BY SHD.department_schedule_date ASC ';
        $query = $this->db->query($SQL);
        $dataArrayF =     $query->result_array();
        if ($dataArrayF) {
            foreach ($dataArrayF as  $rowF) {

                if ($rowF['completed_items'] == $rowF['TOTAL_COUNT']) {
                    $dataF['order_scheduled_color'] = "success";
                } else {
                    $dataF['order_scheduled_color'] = "danger";
                }
                /*
                if ($rowF['is_re_scheduled'] > 0) {
                    $dispatchRowF = $this->common_model->get_order_final_dispatch_date_by_field($rowF['is_re_scheduled']);
                } else {
                    $dispatchRowF = $this->common_model->get_order_final_dispatch_date_by_field($rowF['schedule_id']);
                }
                */
                $dataF['orderform_number'] = '<td><a href="' . base_url('/workorder/view/' . $rowF['order_uuid']) . '"><span class="badge" style="background-color:' . $rowF['priority_color_code'] . ';" >' . $rowF['orderform_number'] . '</span></a></td>';
                //$dataF['orderform_number']=$rowF['orderform_number'];
                $dataF['priority_color_code'] = $rowF['priority_color_code'];
                //$data['TOTAL_COUNT']=$row['TOTAL_COUNT'];
                $dataF['TOTAL_COUNT'] = $rowF['order_total_submitted_qty'];
                //                $dataF['date'] = date("d-m-Y", strtotime($dispatchRowF['department_schedule_date']));
                                        $dataF['date'] = $rowF['department_schedule_date'] ;
                $recordsF[] = $dataF;
            }
        }

        //error_log(print_r($records,TRUE),0);
        return $recordsF;
    }






    public function get_works_design($did, $unit_managed, $date, $type)
    {
        $cdate = $date;
        $recordsF = array();

        $SQL = 'SELECT order_uuid ,order_total_submitted_qty,
                                SH.schedule_uuid,
                                SH.order_id,
                                SH.schedule_id,
                                SHD.batch_number,
                                SHD.department_schedule_date,
                                SHD.scheduled_order_info,
                                SHD.schedule_department_id,
                                SHD.order_is_approved,
                                SHD.is_re_scheduled,
                                WO.wo_date_time,WO.lead_id,CONCAT(SM.staff_code,"-",SM.staff_name) as sales_handler1,SM.staff_name as sales_handler,
                                WO.orderform_type_id,WO.orderform_number,PO.production_unit_name,WO.wo_product_info,PM.priority_color_code,PM.priority_name,
SHD.total_order_items as TOTAL_COUNT,
(SELECT count(*) FROM rs_design_departments as T11 WHERE T11.schedule_department_id=SHD.schedule_department_id and T11.is_current=1 and T11.from_department="design") AS completed_items
                        FROM
                                sh_schedule_departments AS SHD  ';
        $SQL .= 'LEFT JOIN sh_schedules  as SH on  SHD.schedule_id=SH.schedule_id ';
        $SQL .= "LEFT JOIN wo_work_orders as WO on WO.order_id=SH.order_id ";
        $SQL .= "LEFT JOIN staff_master as SM on SM.staff_id=WO.wo_owner_id AND WO.lead_id!=0 ";
        $SQL .= "LEFT JOIN pr_production_units as PO on PO.production_unit_id=SHD.unit_id ";
        $SQL .= "LEFT JOIN priority_master as PM on PM.priority_id=WO.wo_work_priority_id ";
        //echo $SQL;
        if ($type == "all") {
            $SQL .= 'where FIND_IN_SET(' . $did . ',SHD.department_ids) AND SHD.unit_id IN(' . $unit_managed . ')  ';
        }
        if ($type == "active") {
            $SQL .= 'where FIND_IN_SET(' . $did . ',SHD.department_ids) AND SHD.unit_id IN(' . $unit_managed . ') AND SHD.department_schedule_date="' . $cdate . '"  ';
        }
        if ($type == "pending") {
            $SQL .= 'where FIND_IN_SET(' . $did . ',SHD.department_ids) AND SHD.unit_id IN(' . $unit_managed . ') AND SHD.department_schedule_date <"' . $cdate . '"
                        and SHD.total_order_items!=(SELECT count(*) FROM rs_design_departments as T11 WHERE T11.schedule_department_id=SHD.schedule_department_id and T11.is_current=1 and T11.from_department="design") ';
        }
        if ($type == "completed") {
            $SQL .= ' where FIND_IN_SET(' . $did . ',SHD.department_ids) AND SHD.unit_id IN(' . $unit_managed . ')
                        and SHD.total_order_items=(SELECT count(*) FROM rs_design_departments as T11 WHERE T11.schedule_department_id=SHD.schedule_department_id and T11.is_current=1 and T11.from_department="design") ';
        }

        if ($type == "today") {
            $SQL .= ' where FIND_IN_SET(' . $did . ',SHD.department_ids) AND SHD.unit_id IN(' . $unit_managed . ') AND SHD.department_schedule_date like "' . $cdate . '%"
                        and ( (SHD.total_order_items=(SELECT count(*) FROM rs_design_departments as T11 WHERE T11.schedule_department_id=SHD.schedule_department_id
                         and T11.is_current=1 and T11.from_department="design") ) 
                         || (SHD.total_order_items!=(SELECT count(*) FROM 
                         rs_design_departments as T11 
                         WHERE T11.schedule_department_id=SHD.schedule_department_id 
                         and T11.is_current=1 and T11.from_department="design"))) ';
        }
        $SQL .= ' AND SH.order_id!=""  ORDER BY SHD.department_schedule_date ASC ';


        
        $query = $this->db->query($SQL);
        $dataArrayF =     $query->result_array();
        $data = array();
        foreach ($dataArrayF as  $rowF) {

            /*            if ($rowF['is_re_scheduled'] > 0) {
                $dispatchRowF = $this->common_model->get_order_final_dispatch_date_by_field($rowF['is_re_scheduled']);
            } else {
                $dispatchRowF = $this->common_model->get_order_final_dispatch_date_by_field($rowF['schedule_id']);
            }
            */
            $data[] = array(

                $rowF['orderform_number']

            );
            if ($rowF['completed_items'] == $rowF['TOTAL_COUNT']) {
                $dataF['order_scheduled_color'] = "success";
            } else {
                $dataF['order_scheduled_color'] = "danger";
            }
            $dataF['orderform_number'] = '<td><a href="' . base_url('/workorder/view/' . $rowF['order_uuid']) . '"><span class="badge" style="background-color:' . $rowF['priority_color_code'] . ';" >' . $rowF['orderform_number'] . '</span></a></td>';
            $dataF['TOTAL_COUNT'] = $rowF['order_total_submitted_qty'];
            //            $dataF['date'] = date("d-m-Y", strtotime($dispatchRowF['department_schedule_date']));
                        $dataF['date'] = $rowF['department_schedule_date'] ;
            $recordsF[] = $dataF;
        }




        //error_log(print_r($records,TRUE),0);
        return $recordsF;
    }


    public function get_works_designqc($did, $unit_managed, $date, $type)
    {
        $cdate = $date;
        $recordsF = array();
        $SQL = 'SELECT order_uuid,order_total_submitted_qty,
                                SH.schedule_uuid,
                                SH.order_id,
                                SH.schedule_id,
                                SHD.batch_number,
                                SHD.department_schedule_date,
                                SHD.scheduled_order_info,
                                SHD.schedule_department_id,
                                SHD.order_is_approved,
                                SHD.is_re_scheduled,
                                WO.wo_date_time,WO.lead_id,CONCAT(SM.staff_code,"-",SM.staff_name) as sales_handler1,SM.staff_name as sales_handler,
                                WO.orderform_type_id,WO.orderform_number,PO.production_unit_name,WO.wo_product_info,PM.priority_color_code,PM.priority_name,
SHD.total_order_items as TOTAL_COUNT,(SELECT count(*) FROM rs_design_departments as T11 WHERE T11.schedule_department_id=SHD.schedule_department_id and T11.is_current=1 and T11.to_department="design_qc") AS completed_items
                        FROM
                                sh_schedule_departments AS SHD  ';
        $SQL .= 'LEFT JOIN sh_schedules  as SH on  SHD.schedule_id=SH.schedule_id ';
        $SQL .= "LEFT JOIN wo_work_orders as WO on WO.order_id=SH.order_id ";
        $SQL .= "LEFT JOIN staff_master as SM on SM.staff_id=WO.wo_owner_id AND WO.lead_id!=0 ";
        $SQL .= "LEFT JOIN pr_production_units as PO on PO.production_unit_id=SHD.unit_id ";
        $SQL .= "LEFT JOIN priority_master as PM on PM.priority_id=WO.wo_work_priority_id ";
        //$SQL;
        if ($type == "all") {
            $SQL .= 'WHERE FIND_IN_SET(' . $did . ',SHD.department_ids) AND SHD.unit_id IN(' . $unit_managed . ')  ';
        }
        if ($type == "active") {
            $SQL .= 'WHERE FIND_IN_SET(' . $did . ',SHD.department_ids) AND SHD.unit_id IN(' . $unit_managed . ') AND SHD.department_schedule_date="' . $cdate . '"  ';
        }
        if ($type == "pending") {
            $SQL .= 'WHERE FIND_IN_SET(' . $did . ',SHD.department_ids) AND SHD.unit_id IN(' . $unit_managed . ') AND SHD.department_schedule_date <"' . $cdate . '"
                        and SHD.total_order_items!=(SELECT count(*) FROM rs_design_departments as T11 WHERE T11.schedule_department_id=SHD.schedule_department_id and T11.is_current=1 and T11.to_department="design_qc") ';
        }
        if ($type == "completed") {
            $SQL .= 'WHERE FIND_IN_SET(' . $did . ',SHD.department_ids) AND SHD.unit_id IN(' . $unit_managed . ') AND SHD.department_schedule_date <"' . $cdate . '"
                        and SHD.total_order_items=(SELECT count(*) FROM rs_design_departments as T11 WHERE T11.schedule_department_id=SHD.schedule_department_id and T11.is_current=1 and T11.to_department="design_qc") ';
        }

        if ($type == "today") {
            $SQL .= 'WHERE FIND_IN_SET(' . $did . ',SHD.department_ids) AND SHD.unit_id IN(' . $unit_managed . ') AND SHD.department_schedule_date  like "' . $cdate . '%"
                        and ( (SHD.total_order_items=(SELECT count(*) FROM rs_design_departments as T11 WHERE T11.schedule_department_id=SHD.schedule_department_id and T11.is_current=1 and T11.to_department="design_qc") ) || (SHD.total_order_items!=(SELECT count(*) FROM rs_design_departments as T11 WHERE T11.schedule_department_id=SHD.schedule_department_id and T11.is_current=1 and T11.to_department="design_qc") ))';
        }


        $SQL .= ' AND SH.order_id!=""  ORDER BY SHD.department_schedule_date ASC ';

        //error_log($SQL);

        $query = $this->db->query($SQL);
        $dataArrayF =     $query->result_array();
        if ($dataArrayF) {
            foreach ($dataArrayF as  $rowF) {
                if ($rowF['completed_items'] == $rowF['TOTAL_COUNT']) {
                    $dataF['order_scheduled_color'] = "success";
                } else {
                    $dataF['order_scheduled_color'] = "danger";
                }

                /*                if ($rowF['is_re_scheduled'] > 0) {
                    $dispatchRowF = $this->common_model->get_order_final_dispatch_date_by_field($rowF['is_re_scheduled']);
                } else {
                    $dispatchRowF = $this->common_model->get_order_final_dispatch_date_by_field($rowF['schedule_id']);
                }

                */
                $dataF['orderform_number'] = '<td><a href="' . base_url('/workorder/view/' . $rowF['order_uuid']) . '"><span class="badge" style="background-color:' . $rowF['priority_color_code'] . ';" >' . $rowF['orderform_number'] . '</span></a></td>';
                //$dataF['orderform_number']=$rowF['orderform_number'];
                $dataF['priority_color_code'] = $rowF['priority_color_code'];
                //$data['TOTAL_COUNT']=$row['TOTAL_COUNT'];
                $dataF['TOTAL_COUNT'] = $rowF['order_total_submitted_qty'];
                                        $dataF['date'] = $rowF['department_schedule_date'] ;
                                        //                $dataF['date'] = date("d-m-Y", strtotime($dispatchRowF['department_schedule_date']));
                $recordsF[] = $dataF;
            }
        }

        //error_log(print_r($records,TRUE),0);
        return $recordsF;
    }

    public function get_works_printing($did, $unit_managed, $date, $type)
    {
        $cdate = $date;
        $recordsF = array();
        $SQL = 'SELECT order_uuid,order_total_submitted_qty,
                                SH.schedule_uuid,
                                SH.order_id,
                                SH.schedule_id,
                                SHD.batch_number,
                                SHD.department_schedule_date,
                                SHD.scheduled_order_info,
                                SHD.schedule_department_id,
                                SHD.order_is_approved,
                                SHD.is_re_scheduled,
                                WO.wo_date_time,WO.lead_id,CONCAT(SM.staff_code,"-",SM.staff_name) as sales_handler1,SM.staff_name as sales_handler,
                                WO.orderform_type_id,WO.orderform_number,PO.production_unit_name,WO.wo_product_info,PM.priority_color_code,PM.priority_name,
SHD.total_order_items as TOTAL_COUNT,(SELECT count(*) FROM rs_design_departments as T11 WHERE T11.schedule_department_id=SHD.schedule_department_id and T11.is_current=1 and T11.from_department="printing") AS completed_items
                        FROM
                                sh_schedule_departments AS SHD  ';
        $SQL .= 'LEFT JOIN sh_schedules  as SH on  SHD.schedule_id=SH.schedule_id ';
        $SQL .= "LEFT JOIN wo_work_orders as WO on WO.order_id=SH.order_id ";
        $SQL .= "LEFT JOIN staff_master as SM on SM.staff_id=WO.wo_owner_id AND WO.lead_id!=0 ";
        $SQL .= "LEFT JOIN pr_production_units as PO on PO.production_unit_id=SHD.unit_id ";
        $SQL .= "LEFT JOIN priority_master as PM on PM.priority_id=WO.wo_work_priority_id ";
        //echo $SQL;
        if ($type == "all") {
            $SQL .= 'WHERE FIND_IN_SET(' . $did . ',SHD.department_ids) AND SHD.unit_id IN(' . $unit_managed . ')  ';
        }
        if ($type == "active") {
            $SQL .= 'WHERE FIND_IN_SET(' . $did . ',SHD.department_ids) AND SHD.unit_id IN(' . $unit_managed . ') AND SHD.department_schedule_date="' . $cdate . '"  ';
        }
        if ($type == "pending") {
            $SQL .= 'WHERE FIND_IN_SET(' . $did . ',SHD.department_ids) AND SHD.unit_id IN(' . $unit_managed . ') AND SHD.department_schedule_date <"' . $cdate . '"
                        and SHD.total_order_items!=(SELECT count(*) FROM rs_design_departments as T11 WHERE T11.schedule_department_id=SHD.schedule_department_id and T11.is_current=1 and T11.from_department="printing") ';
        }
        if ($type == "completed") {
            $SQL .= ' where FIND_IN_SET(' . $did . ',SHD.department_ids) AND SHD.unit_id IN(' . $unit_managed . ') 
                        and SHD.total_order_items=(SELECT count(*) FROM rs_design_departments as T11 WHERE T11.schedule_department_id=SHD.schedule_department_id and T11.is_current=1 and T11.from_department="printing") ';
        }

        if ($type == "today") {
            $SQL .= ' where FIND_IN_SET(' . $did . ',SHD.department_ids) AND SHD.unit_id IN(' . $unit_managed . ') AND SHD.department_schedule_date like "' . $cdate . '%"
                        and ((SHD.total_order_items=(SELECT count(*) FROM rs_design_departments as T11 WHERE T11.schedule_department_id=SHD.schedule_department_id and T11.is_current=1 and T11.from_department="printing")) || (SHD.total_order_items!=(SELECT count(*) FROM rs_design_departments as T11 WHERE T11.schedule_department_id=SHD.schedule_department_id and T11.is_current=1 and T11.from_department="printing")))';
        }


$SQL .= ' AND SH.order_id!=""  ORDER BY SHD.department_schedule_date ASC ';

        //        error_log($SQL);
        $query = $this->db->query($SQL);
        $dataArrayF =     $query->result_array();
        if ($dataArrayF) {
            foreach ($dataArrayF as  $rowF) {

                if ($rowF['completed_items'] == $rowF['TOTAL_COUNT']) {
                    $dataF['order_scheduled_color'] = "success";
                } else {
                    $dataF['order_scheduled_color'] = "danger";
                }
                /*                if ($rowF['is_re_scheduled'] > 0) {
                    $dispatchRowF = $this->common_model->get_order_final_dispatch_date_by_field($rowF['is_re_scheduled']);
                } else {
                    $dispatchRowF = $this->common_model->get_order_final_dispatch_date_by_field($rowF['schedule_id']);
                }
                */
                $dataF['orderform_number'] = '<td><a href="' . base_url('/workorder/view/' . $rowF['order_uuid']) . '"><span class="badge" style="background-color:' . $rowF['priority_color_code'] . ';" >' . $rowF['orderform_number'] . '</span></a></td>';
                //$dataF['orderform_number']=$rowF['orderform_number'];
                $dataF['priority_color_code'] = $rowF['priority_color_code'];
                //$data['TOTAL_COUNT']=$row['TOTAL_COUNT'];
                $dataF['TOTAL_COUNT'] = $rowF['order_total_submitted_qty'];
                //$dataF['date'] = date("d-m-Y", strtotime($dispatchRowF['department_schedule_date']));
                $dataF['date'] = $rowF['department_schedule_date'] ;
                $recordsF[] = $dataF;
            }
        }

        //error_log(print_r($records,TRUE),0);
        return $recordsF;
    }
}

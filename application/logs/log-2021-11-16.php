<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2021-11-16 00:00:47 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-16 00:00:48 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-16 00:00:48 --> 404 Page Not Found: Public/css
ERROR - 2021-11-16 00:00:48 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-16 00:00:48 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near 'asc LIMIT 10 OFFSET 0' at line 11 - Invalid query: SELECT 
				SH.*,
				SHD.department_schedule_date,
				SHD.scheduled_order_info,
				SHD.schedule_department_id,
				SHD.order_is_approved,
				SHD.is_re_scheduled,
				WO.wo_date_time,WO.lead_id,CONCAT(SM.staff_code,"-",SM.staff_name) as sales_handler1,SM.staff_name as sales_handler,
				WO.orderform_type_id,WO.orderform_number,PO.production_unit_name,WO.wo_product_info,PM.priority_color_code,PM.priority_name
			FROM
				sh_schedule_departments AS SHD  LEFT JOIN sh_schedules  as SH on  SHD.schedule_id=SH.schedule_id LEFT JOIN wo_work_orders as WO on WO.order_id=SH.order_id LEFT JOIN staff_master as SM on SM.staff_id=WO.wo_owner_id AND WO.lead_id!=0 LEFT JOIN pr_production_units as PO on PO.production_unit_id=SHD.unit_id LEFT JOIN priority_master as PM on PM.priority_id=WO.wo_work_priority_id  WHERE ( FIND_IN_SET(4,SHD.department_ids) AND SHD.unit_id IN(0,1,2,3)  ) ORDER BY  asc LIMIT 10 OFFSET 0 
ERROR - 2021-11-16 00:00:48 --> Severity: Error --> Call to a member function result_array() on boolean C:\xampp\htdocs\hy\hyvesports\application\libraries\Datatable.php 49
ERROR - 2021-11-16 00:01:26 --> 404 Page Not Found: Public/css
ERROR - 2021-11-16 00:01:26 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-16 00:01:26 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-16 00:01:27 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-16 00:01:27 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near 'asc LIMIT 10 OFFSET 0' at line 11 - Invalid query: SELECT 
				SH.*,
				SHD.department_schedule_date,
				SHD.scheduled_order_info,
				SHD.schedule_department_id,
				SHD.order_is_approved,
				SHD.is_re_scheduled,
				WO.wo_date_time,WO.lead_id,CONCAT(SM.staff_code,"-",SM.staff_name) as sales_handler1,SM.staff_name as sales_handler,
				WO.orderform_type_id,WO.orderform_number,PO.production_unit_name,WO.wo_product_info,PM.priority_color_code,PM.priority_name
			FROM
				sh_schedule_departments AS SHD  LEFT JOIN sh_schedules  as SH on  SHD.schedule_id=SH.schedule_id LEFT JOIN wo_work_orders as WO on WO.order_id=SH.order_id LEFT JOIN staff_master as SM on SM.staff_id=WO.wo_owner_id AND WO.lead_id!=0 LEFT JOIN pr_production_units as PO on PO.production_unit_id=SHD.unit_id LEFT JOIN priority_master as PM on PM.priority_id=WO.wo_work_priority_id  WHERE ( FIND_IN_SET(4,SHD.department_ids) AND SHD.unit_id IN(0,1,2,3)  ) ORDER BY  asc LIMIT 10 OFFSET 0 
ERROR - 2021-11-16 00:01:27 --> Severity: Error --> Call to a member function result_array() on boolean C:\xampp\htdocs\hy\hyvesports\application\libraries\Datatable.php 49
ERROR - 2021-11-16 00:01:49 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-16 00:01:50 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-16 00:01:50 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-16 00:01:50 --> 404 Page Not Found: Public/css
ERROR - 2021-11-16 00:07:58 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-16 00:07:59 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-16 00:07:59 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-16 00:07:59 --> 404 Page Not Found: Public/css
ERROR - 2021-11-16 00:08:54 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-16 00:08:55 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-16 00:08:55 --> 404 Page Not Found: Public/css
ERROR - 2021-11-16 00:08:55 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-16 00:09:24 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-16 00:09:24 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-16 00:09:24 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-16 00:09:25 --> 404 Page Not Found: Public/css
ERROR - 2021-11-16 08:36:13 --> 404 Page Not Found: Uploads/orderform
ERROR - 2021-11-16 08:36:13 --> 404 Page Not Found: Uploads/orderform
ERROR - 2021-11-16 08:36:13 --> 404 Page Not Found: Uploads/orderform
ERROR - 2021-11-16 08:36:19 --> 404 Page Not Found: Uploads/orderform
ERROR - 2021-11-16 08:36:47 --> 404 Page Not Found: Uploads/orderform
ERROR - 2021-11-16 08:36:47 --> 404 Page Not Found: Uploads/orderform
ERROR - 2021-11-16 08:36:47 --> 404 Page Not Found: Uploads/orderform
ERROR - 2021-11-16 08:37:15 --> 404 Page Not Found: Uploads/orderform
ERROR - 2021-11-16 08:37:15 --> 404 Page Not Found: Uploads/orderform
ERROR - 2021-11-16 08:37:31 --> 404 Page Not Found: Uploads/orderform
ERROR - 2021-11-16 08:37:31 --> 404 Page Not Found: Uploads/orderform
ERROR - 2021-11-16 08:38:07 --> 404 Page Not Found: Uploads/orderform
ERROR - 2021-11-16 08:38:07 --> 404 Page Not Found: Uploads/orderform
ERROR - 2021-11-16 08:38:21 --> 404 Page Not Found: Uploads/orderform
ERROR - 2021-11-16 08:38:21 --> 404 Page Not Found: Uploads/orderform
ERROR - 2021-11-16 08:38:21 --> 404 Page Not Found: Uploads/orderform
ERROR - 2021-11-16 08:38:38 --> 404 Page Not Found: Uploads/orderform
ERROR - 2021-11-16 08:38:38 --> 404 Page Not Found: Uploads/orderform
ERROR - 2021-11-16 08:38:38 --> 404 Page Not Found: Uploads/orderform
ERROR - 2021-11-16 08:39:23 --> 404 Page Not Found: Uploads/orderform
ERROR - 2021-11-16 08:39:23 --> 404 Page Not Found: Uploads/orderform
ERROR - 2021-11-16 08:39:23 --> 404 Page Not Found: Uploads/orderform
ERROR - 2021-11-16 08:39:41 --> 404 Page Not Found: Uploads/orderform
ERROR - 2021-11-16 08:39:41 --> 404 Page Not Found: Uploads/orderform
ERROR - 2021-11-16 08:39:45 --> 404 Page Not Found: Uploads/orderform
ERROR - 2021-11-16 08:40:09 --> 404 Page Not Found: Uploads/orderform
ERROR - 2021-11-16 08:40:09 --> 404 Page Not Found: Uploads/orderform
ERROR - 2021-11-16 08:57:52 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-16 08:57:52 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-16 08:57:52 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-16 08:57:52 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-16 08:57:52 --> 404 Page Not Found: Public/css
ERROR - 2021-11-16 08:59:29 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-16 08:59:29 --> 404 Page Not Found: Public/css
ERROR - 2021-11-16 08:59:29 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-16 08:59:29 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-16 08:59:29 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-16 08:59:30 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-16 08:59:31 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-16 08:59:31 --> 404 Page Not Found: Public/css
ERROR - 2021-11-16 08:59:31 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-16 08:59:31 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-16 09:47:40 --> 404 Page Not Found: Uploads/orderform
ERROR - 2021-11-16 09:48:26 --> 404 Page Not Found: Uploads/orderform
ERROR - 2021-11-16 09:48:35 --> 404 Page Not Found: Uploads/orderform
ERROR - 2021-11-16 09:48:44 --> 404 Page Not Found: Uploads/orderform
ERROR - 2021-11-16 09:49:06 --> 404 Page Not Found: Uploads/orderform
ERROR - 2021-11-16 09:49:28 --> 404 Page Not Found: Uploads/orderform
ERROR - 2021-11-16 09:49:32 --> 404 Page Not Found: Uploads/orderform
ERROR - 2021-11-16 09:50:03 --> 404 Page Not Found: Uploads/orderform
ERROR - 2021-11-16 10:17:41 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\hy\hyvesports\application\views\orders\order_schedule.tab.php 38
ERROR - 2021-11-16 10:17:41 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\hy\hyvesports\application\views\orders\order_schedule.tab.php 62
ERROR - 2021-11-16 10:17:41 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\hy\hyvesports\application\views\orders\order_schedule.tab.php 84
ERROR - 2021-11-16 10:17:41 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\hy\hyvesports\application\views\orders\order_schedule.tab.php 105
ERROR - 2021-11-16 10:17:41 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\hy\hyvesports\application\views\orders\order_schedule.tab.php 125
ERROR - 2021-11-16 10:19:44 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\hy\hyvesports\application\views\orders\order_schedule.tab.php 38
ERROR - 2021-11-16 10:19:44 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\hy\hyvesports\application\views\orders\order_schedule.tab.php 62
ERROR - 2021-11-16 10:19:44 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\hy\hyvesports\application\views\orders\order_schedule.tab.php 84
ERROR - 2021-11-16 10:19:44 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\hy\hyvesports\application\views\orders\order_schedule.tab.php 105
ERROR - 2021-11-16 10:19:44 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\hy\hyvesports\application\views\orders\order_schedule.tab.php 125
ERROR - 2021-11-16 10:43:38 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\hy\hyvesports\application\views\orders\order_schedule.tab.php 38
ERROR - 2021-11-16 10:43:38 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\hy\hyvesports\application\views\orders\order_schedule.tab.php 62
ERROR - 2021-11-16 10:43:38 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\hy\hyvesports\application\views\orders\order_schedule.tab.php 84
ERROR - 2021-11-16 10:43:38 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\hy\hyvesports\application\views\orders\order_schedule.tab.php 105
ERROR - 2021-11-16 10:43:38 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\hy\hyvesports\application\views\orders\order_schedule.tab.php 125
ERROR - 2021-11-16 10:48:37 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-16 10:48:37 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-16 10:48:37 --> 404 Page Not Found: Public/css
ERROR - 2021-11-16 10:48:37 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-16 10:48:40 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-16 10:48:41 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-16 10:48:41 --> 404 Page Not Found: Public/css
ERROR - 2021-11-16 10:48:42 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-16 10:55:31 --> Query error: Unknown column 'RDD.scheduled_order_info' in 'field list' - Invalid query: SELECT 
				SH.*,
				SHD.department_schedule_date,
				SHD.scheduled_order_info,
				RDD.scheduled_order_info,
				SHD.schedule_department_id,
				SHD.order_is_approved,
				SHD.is_re_scheduled,
				WO.wo_date_time,WO.lead_id,CONCAT(SM.staff_code,"-",SM.staff_name) as sales_handler1,SM.staff_name as sales_handler,
				WO.orderform_type_id,WO.orderform_number,PO.production_unit_name,WO.wo_product_info,PM.priority_color_code,PM.priority_name,RDD.rs_design_id
			FROM
				rs_design_departments AS RDD,
				sh_schedule_departments AS SHD  LEFT JOIN sh_schedules  as SH on  SHD.schedule_id=SH.schedule_id LEFT JOIN wo_work_orders as WO on WO.order_id=SH.order_id LEFT JOIN staff_master as SM on SM.staff_id=WO.wo_owner_id AND WO.lead_id!=0 LEFT JOIN pr_production_units as PO on PO.production_unit_id=SHD.unit_id LEFT JOIN priority_master as PM on PM.priority_id=WO.wo_work_priority_id  WHERE (  SHD.unit_id IN(0,1,2,3) and SHD.department_schedule_date<"2021-11-16" and
			SHD.schedule_department_id=RDD.schedule_department_id and
			RDD.to_department="design_qc" and
			RDD.row_status="approved" and RDD.printing_submitted=0
			 )
ERROR - 2021-11-16 10:55:31 --> Severity: Error --> Call to a member function num_rows() on boolean C:\xampp\htdocs\hy\hyvesports\application\libraries\Datatable.php 20
ERROR - 2021-11-16 10:55:45 --> Query error: Unknown column 'RDD.scheduled_order_info' in 'field list' - Invalid query: SELECT 
				SH.*,
				SHD.department_schedule_date,
				SHD.scheduled_order_info,
				RDD.scheduled_order_info,
				SHD.schedule_department_id,
				SHD.order_is_approved,
				SHD.is_re_scheduled,
				WO.wo_date_time,WO.lead_id,CONCAT(SM.staff_code,"-",SM.staff_name) as sales_handler1,SM.staff_name as sales_handler,
				WO.orderform_type_id,WO.orderform_number,PO.production_unit_name,WO.wo_product_info,PM.priority_color_code,PM.priority_name,RDD.rs_design_id
			FROM
				rs_design_departments AS RDD,
				sh_schedule_departments AS SHD  LEFT JOIN sh_schedules  as SH on  SHD.schedule_id=SH.schedule_id LEFT JOIN wo_work_orders as WO on WO.order_id=SH.order_id LEFT JOIN staff_master as SM on SM.staff_id=WO.wo_owner_id AND WO.lead_id!=0 LEFT JOIN pr_production_units as PO on PO.production_unit_id=SHD.unit_id LEFT JOIN priority_master as PM on PM.priority_id=WO.wo_work_priority_id  WHERE (  SHD.unit_id IN(0,1,2,3) and SHD.department_schedule_date<"2021-11-16" and
			SHD.schedule_department_id=RDD.schedule_department_id and
			RDD.to_department="design_qc" and
			RDD.row_status="approved" and RDD.printing_submitted=0
			 )
ERROR - 2021-11-16 10:55:45 --> Severity: Error --> Call to a member function num_rows() on boolean C:\xampp\htdocs\hy\hyvesports\application\libraries\Datatable.php 20
ERROR - 2021-11-16 10:55:48 --> Query error: Unknown column 'RDD.scheduled_order_info' in 'field list' - Invalid query: SELECT 
				SH.*,
				SHD.department_schedule_date,
				SHD.scheduled_order_info,
				RDD.scheduled_order_info,
				SHD.schedule_department_id,
				SHD.order_is_approved,
				SHD.is_re_scheduled,
				WO.wo_date_time,WO.lead_id,CONCAT(SM.staff_code,"-",SM.staff_name) as sales_handler1,SM.staff_name as sales_handler,
				WO.orderform_type_id,WO.orderform_number,PO.production_unit_name,WO.wo_product_info,PM.priority_color_code,PM.priority_name,RDD.rs_design_id
			FROM
				rs_design_departments AS RDD,
				sh_schedule_departments AS SHD  LEFT JOIN sh_schedules  as SH on  SHD.schedule_id=SH.schedule_id LEFT JOIN wo_work_orders as WO on WO.order_id=SH.order_id LEFT JOIN staff_master as SM on SM.staff_id=WO.wo_owner_id AND WO.lead_id!=0 LEFT JOIN pr_production_units as PO on PO.production_unit_id=SHD.unit_id LEFT JOIN priority_master as PM on PM.priority_id=WO.wo_work_priority_id  WHERE (  SHD.unit_id IN(0,1,2,3) and SHD.department_schedule_date<"2021-11-16" and
			SHD.schedule_department_id=RDD.schedule_department_id and
			RDD.to_department="design_qc" and
			RDD.row_status="approved" and RDD.printing_submitted=0
			 )
ERROR - 2021-11-16 10:55:48 --> Severity: Error --> Call to a member function num_rows() on boolean C:\xampp\htdocs\hy\hyvesports\application\libraries\Datatable.php 20
ERROR - 2021-11-16 10:59:23 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\hy\hyvesports\application\controllers\Printing.php 135
ERROR - 2021-11-16 10:59:23 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\hy\hyvesports\application\controllers\Printing.php 135
ERROR - 2021-11-16 10:59:23 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\hy\hyvesports\application\controllers\Printing.php 135
ERROR - 2021-11-16 10:59:23 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\hy\hyvesports\application\controllers\Printing.php 135
ERROR - 2021-11-16 10:59:23 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\hy\hyvesports\application\controllers\Printing.php 135
ERROR - 2021-11-16 10:59:23 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\hy\hyvesports\application\controllers\Printing.php 135
ERROR - 2021-11-16 10:59:23 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\hy\hyvesports\application\controllers\Printing.php 135
ERROR - 2021-11-16 10:59:23 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\hy\hyvesports\application\controllers\Printing.php 135
ERROR - 2021-11-16 10:59:23 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\hy\hyvesports\application\controllers\Printing.php 135
ERROR - 2021-11-16 10:59:23 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\hy\hyvesports\application\controllers\Printing.php 135
ERROR - 2021-11-16 10:59:30 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\hy\hyvesports\application\controllers\Printing.php 135
ERROR - 2021-11-16 10:59:30 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\hy\hyvesports\application\controllers\Printing.php 135
ERROR - 2021-11-16 10:59:30 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\hy\hyvesports\application\controllers\Printing.php 135
ERROR - 2021-11-16 10:59:30 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\hy\hyvesports\application\controllers\Printing.php 135
ERROR - 2021-11-16 10:59:30 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\hy\hyvesports\application\controllers\Printing.php 135
ERROR - 2021-11-16 10:59:30 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\hy\hyvesports\application\controllers\Printing.php 135
ERROR - 2021-11-16 10:59:30 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\hy\hyvesports\application\controllers\Printing.php 135
ERROR - 2021-11-16 10:59:30 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\hy\hyvesports\application\controllers\Printing.php 135
ERROR - 2021-11-16 10:59:30 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\hy\hyvesports\application\controllers\Printing.php 135
ERROR - 2021-11-16 10:59:30 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\hy\hyvesports\application\controllers\Printing.php 135
ERROR - 2021-11-16 11:01:49 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-16 11:01:49 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-16 11:01:49 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-16 11:01:49 --> 404 Page Not Found: Public/css
ERROR - 2021-11-16 11:01:52 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-16 11:01:53 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-16 11:01:53 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-16 11:01:53 --> 404 Page Not Found: Public/css
ERROR - 2021-11-16 11:03:02 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-16 11:03:02 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-16 11:03:02 --> 404 Page Not Found: Public/css
ERROR - 2021-11-16 11:03:02 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-16 11:07:16 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-16 11:07:16 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-16 11:07:17 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-16 12:40:00 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-16 12:40:00 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-16 12:40:00 --> 404 Page Not Found: Public/css
ERROR - 2021-11-16 12:40:00 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-16 12:40:25 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-16 12:40:26 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-16 12:40:26 --> 404 Page Not Found: Public/css
ERROR - 2021-11-16 12:40:26 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-16 13:20:04 --> Severity: Warning --> Missing argument 2 for Myaccount::order_view() C:\xampp\htdocs\hy\hyvesports\application\controllers\Myaccount.php 185
ERROR - 2021-11-16 13:53:28 --> Query error: Unknown column 'RDD.submitted_item' in 'field list' - Invalid query: SELECT 
				SH.*,
				SHD.department_schedule_date,
				SHD.scheduled_order_info,
				RDD.submitted_item,
				RDD.summary_item_id,
				SHD.schedule_department_id,
				SHD.order_is_approved,
				SHD.is_re_scheduled,
				WO.wo_date_time,WO.lead_id,CONCAT(SM.staff_code,"-",SM.staff_name) as sales_handler1,SM.staff_name as sales_handler,
				WO.orderform_type_id,WO.orderform_number,PO.production_unit_name,WO.wo_product_info,PM.priority_color_code,PM.priority_name
			FROM
				sh_schedule_departments AS SHD  LEFT JOIN sh_schedules  as SH on  SHD.schedule_id=SH.schedule_id LEFT JOIN wo_work_orders as WO on WO.order_id=SH.order_id LEFT JOIN staff_master as SM on SM.staff_id=WO.wo_owner_id AND WO.lead_id!=0 LEFT JOIN pr_production_units as PO on PO.production_unit_id=SHD.unit_id LEFT JOIN priority_master as PM on PM.priority_id=WO.wo_work_priority_id  WHERE ( FIND_IN_SET(4,SHD.department_ids) AND SHD.unit_id IN(0,1,2,3) AND SHD.department_schedule_date<"2021-11-16"
			 )
ERROR - 2021-11-16 13:53:28 --> Severity: Error --> Call to a member function num_rows() on boolean C:\xampp\htdocs\hy\hyvesports\application\libraries\Datatable.php 20
ERROR - 2021-11-16 13:53:32 --> Query error: Unknown column 'RDD.submitted_item' in 'field list' - Invalid query: SELECT 
				SH.*,
				SHD.department_schedule_date,
				SHD.scheduled_order_info,
				RDD.submitted_item,
				RDD.summary_item_id,
				SHD.schedule_department_id,
				SHD.order_is_approved,
				SHD.is_re_scheduled,
				WO.wo_date_time,WO.lead_id,CONCAT(SM.staff_code,"-",SM.staff_name) as sales_handler1,SM.staff_name as sales_handler,
				WO.orderform_type_id,WO.orderform_number,PO.production_unit_name,WO.wo_product_info,PM.priority_color_code,PM.priority_name
			FROM
				sh_schedule_departments AS SHD  LEFT JOIN sh_schedules  as SH on  SHD.schedule_id=SH.schedule_id LEFT JOIN wo_work_orders as WO on WO.order_id=SH.order_id LEFT JOIN staff_master as SM on SM.staff_id=WO.wo_owner_id AND WO.lead_id!=0 LEFT JOIN pr_production_units as PO on PO.production_unit_id=SHD.unit_id LEFT JOIN priority_master as PM on PM.priority_id=WO.wo_work_priority_id  WHERE ( FIND_IN_SET(4,SHD.department_ids) AND SHD.unit_id IN(0,1,2,3) AND SHD.department_schedule_date<"2021-11-16"
			 )
ERROR - 2021-11-16 13:53:32 --> Severity: Error --> Call to a member function num_rows() on boolean C:\xampp\htdocs\hy\hyvesports\application\libraries\Datatable.php 20
ERROR - 2021-11-16 14:00:50 --> Severity: Error --> Call to a member function get_design_works_pending() on null C:\xampp\htdocs\hy\hyvesports\application\views\design\orders_design_pending_new.php 32
ERROR - 2021-11-16 14:01:14 --> Severity: Error --> Call to a member function get_design_works_pending() on null C:\xampp\htdocs\hy\hyvesports\application\views\design\orders_design_pending_new.php 32
ERROR - 2021-11-16 14:01:18 --> Severity: Error --> Call to a member function get_design_works_pending() on null C:\xampp\htdocs\hy\hyvesports\application\views\design\orders_design_pending_new.php 32
ERROR - 2021-11-16 14:01:19 --> Severity: Error --> Call to a member function get_design_works_pending() on null C:\xampp\htdocs\hy\hyvesports\application\views\design\orders_design_pending_new.php 32
ERROR - 2021-11-16 14:01:30 --> Severity: Error --> Call to a member function get_design_works_pending() on null C:\xampp\htdocs\hy\hyvesports\application\views\design\orders_design_pending_new.php 32
ERROR - 2021-11-16 14:01:44 --> Severity: Error --> Call to a member function get_design_works_pending() on null C:\xampp\htdocs\hy\hyvesports\application\views\design\orders_design_pending_new.php 32
ERROR - 2021-11-16 14:02:17 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near 'LIMIT  OFFSET' at line 12 - Invalid query: SELECT 
				SH.*,
				SHD.department_schedule_date,
				SHD.scheduled_order_info,
				SHD.schedule_department_id,
				SHD.order_is_approved,
				SHD.is_re_scheduled,
				WO.wo_date_time,WO.lead_id,CONCAT(SM.staff_code,"-",SM.staff_name) as sales_handler1,SM.staff_name as sales_handler,
				WO.orderform_type_id,WO.orderform_number,PO.production_unit_name,WO.wo_product_info,PM.priority_color_code,PM.priority_name
			FROM
				sh_schedule_departments AS SHD  LEFT JOIN sh_schedules  as SH on  SHD.schedule_id=SH.schedule_id LEFT JOIN wo_work_orders as WO on WO.order_id=SH.order_id LEFT JOIN staff_master as SM on SM.staff_id=WO.wo_owner_id AND WO.lead_id!=0 LEFT JOIN pr_production_units as PO on PO.production_unit_id=SHD.unit_id LEFT JOIN priority_master as PM on PM.priority_id=WO.wo_work_priority_id  WHERE ( FIND_IN_SET(4,SHD.department_ids) AND SHD.unit_id IN(0,1,2,3) AND SHD.department_schedule_date<"2021-11-16"
			 ) ORDER BY   LIMIT  OFFSET  
ERROR - 2021-11-16 14:02:17 --> Severity: Error --> Call to a member function result_array() on boolean C:\xampp\htdocs\hy\hyvesports\application\libraries\Datatable.php 49
ERROR - 2021-11-16 14:02:21 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near 'LIMIT  OFFSET' at line 12 - Invalid query: SELECT 
				SH.*,
				SHD.department_schedule_date,
				SHD.scheduled_order_info,
				SHD.schedule_department_id,
				SHD.order_is_approved,
				SHD.is_re_scheduled,
				WO.wo_date_time,WO.lead_id,CONCAT(SM.staff_code,"-",SM.staff_name) as sales_handler1,SM.staff_name as sales_handler,
				WO.orderform_type_id,WO.orderform_number,PO.production_unit_name,WO.wo_product_info,PM.priority_color_code,PM.priority_name
			FROM
				sh_schedule_departments AS SHD  LEFT JOIN sh_schedules  as SH on  SHD.schedule_id=SH.schedule_id LEFT JOIN wo_work_orders as WO on WO.order_id=SH.order_id LEFT JOIN staff_master as SM on SM.staff_id=WO.wo_owner_id AND WO.lead_id!=0 LEFT JOIN pr_production_units as PO on PO.production_unit_id=SHD.unit_id LEFT JOIN priority_master as PM on PM.priority_id=WO.wo_work_priority_id  WHERE ( FIND_IN_SET(4,SHD.department_ids) AND SHD.unit_id IN(0,1,2,3) AND SHD.department_schedule_date<"2021-11-16"
			 ) ORDER BY   LIMIT  OFFSET  
ERROR - 2021-11-16 14:02:21 --> Severity: Error --> Call to a member function result_array() on boolean C:\xampp\htdocs\hy\hyvesports\application\libraries\Datatable.php 49
ERROR - 2021-11-16 14:02:42 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near 'LIMIT  OFFSET' at line 12 - Invalid query: SELECT 
				SH.*,
				SHD.department_schedule_date,
				SHD.scheduled_order_info,
				SHD.schedule_department_id,
				SHD.order_is_approved,
				SHD.is_re_scheduled,
				WO.wo_date_time,WO.lead_id,CONCAT(SM.staff_code,"-",SM.staff_name) as sales_handler1,SM.staff_name as sales_handler,
				WO.orderform_type_id,WO.orderform_number,PO.production_unit_name,WO.wo_product_info,PM.priority_color_code,PM.priority_name
			FROM
				sh_schedule_departments AS SHD  LEFT JOIN sh_schedules  as SH on  SHD.schedule_id=SH.schedule_id LEFT JOIN wo_work_orders as WO on WO.order_id=SH.order_id LEFT JOIN staff_master as SM on SM.staff_id=WO.wo_owner_id AND WO.lead_id!=0 LEFT JOIN pr_production_units as PO on PO.production_unit_id=SHD.unit_id LEFT JOIN priority_master as PM on PM.priority_id=WO.wo_work_priority_id  WHERE ( FIND_IN_SET(4,SHD.department_ids) AND SHD.unit_id IN(0,1,2,3) AND SHD.department_schedule_date<"2021-11-16"
			 ) ORDER BY   LIMIT  OFFSET  
ERROR - 2021-11-16 14:02:43 --> Severity: Error --> Call to a member function result_array() on boolean C:\xampp\htdocs\hy\hyvesports\application\libraries\Datatable.php 49
ERROR - 2021-11-16 14:02:55 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near 'LIMIT  OFFSET' at line 12 - Invalid query: SELECT 
				SH.*,
				SHD.department_schedule_date,
				SHD.scheduled_order_info,
				SHD.schedule_department_id,
				SHD.order_is_approved,
				SHD.is_re_scheduled,
				WO.wo_date_time,WO.lead_id,CONCAT(SM.staff_code,"-",SM.staff_name) as sales_handler1,SM.staff_name as sales_handler,
				WO.orderform_type_id,WO.orderform_number,PO.production_unit_name,WO.wo_product_info,PM.priority_color_code,PM.priority_name
			FROM
				sh_schedule_departments AS SHD  LEFT JOIN sh_schedules  as SH on  SHD.schedule_id=SH.schedule_id LEFT JOIN wo_work_orders as WO on WO.order_id=SH.order_id LEFT JOIN staff_master as SM on SM.staff_id=WO.wo_owner_id AND WO.lead_id!=0 LEFT JOIN pr_production_units as PO on PO.production_unit_id=SHD.unit_id LEFT JOIN priority_master as PM on PM.priority_id=WO.wo_work_priority_id  WHERE ( FIND_IN_SET(4,SHD.department_ids) AND SHD.unit_id IN(0,1,2,3) AND SHD.department_schedule_date<"2021-11-16"
			 ) ORDER BY   LIMIT  OFFSET  
ERROR - 2021-11-16 14:02:55 --> Severity: Error --> Call to a member function result_array() on boolean C:\xampp\htdocs\hy\hyvesports\application\libraries\Datatable.php 49
ERROR - 2021-11-16 14:03:14 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near 'LIMIT  OFFSET' at line 12 - Invalid query: SELECT 
				SH.*,
				SHD.department_schedule_date,
				SHD.scheduled_order_info,
				SHD.schedule_department_id,
				SHD.order_is_approved,
				SHD.is_re_scheduled,
				WO.wo_date_time,WO.lead_id,CONCAT(SM.staff_code,"-",SM.staff_name) as sales_handler1,SM.staff_name as sales_handler,
				WO.orderform_type_id,WO.orderform_number,PO.production_unit_name,WO.wo_product_info,PM.priority_color_code,PM.priority_name
			FROM
				sh_schedule_departments AS SHD  LEFT JOIN sh_schedules  as SH on  SHD.schedule_id=SH.schedule_id LEFT JOIN wo_work_orders as WO on WO.order_id=SH.order_id LEFT JOIN staff_master as SM on SM.staff_id=WO.wo_owner_id AND WO.lead_id!=0 LEFT JOIN pr_production_units as PO on PO.production_unit_id=SHD.unit_id LEFT JOIN priority_master as PM on PM.priority_id=WO.wo_work_priority_id  WHERE ( FIND_IN_SET(4,SHD.department_ids) AND SHD.unit_id IN(0,1,2,3) AND SHD.department_schedule_date<"2021-11-16"
			 ) ORDER BY   LIMIT  OFFSET  
ERROR - 2021-11-16 14:03:14 --> Severity: Error --> Call to a member function result_array() on boolean C:\xampp\htdocs\hy\hyvesports\application\libraries\Datatable.php 49
ERROR - 2021-11-16 14:03:31 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near 'LIMIT  OFFSET' at line 12 - Invalid query: SELECT 
				SH.*,
				SHD.department_schedule_date,
				SHD.scheduled_order_info,
				SHD.schedule_department_id,
				SHD.order_is_approved,
				SHD.is_re_scheduled,
				WO.wo_date_time,WO.lead_id,CONCAT(SM.staff_code,"-",SM.staff_name) as sales_handler1,SM.staff_name as sales_handler,
				WO.orderform_type_id,WO.orderform_number,PO.production_unit_name,WO.wo_product_info,PM.priority_color_code,PM.priority_name
			FROM
				sh_schedule_departments AS SHD  LEFT JOIN sh_schedules  as SH on  SHD.schedule_id=SH.schedule_id LEFT JOIN wo_work_orders as WO on WO.order_id=SH.order_id LEFT JOIN staff_master as SM on SM.staff_id=WO.wo_owner_id AND WO.lead_id!=0 LEFT JOIN pr_production_units as PO on PO.production_unit_id=SHD.unit_id LEFT JOIN priority_master as PM on PM.priority_id=WO.wo_work_priority_id  WHERE ( FIND_IN_SET(4,SHD.department_ids) AND SHD.unit_id IN(0,1,2,3) AND SHD.department_schedule_date<"2021-11-16"
			 ) ORDER BY   LIMIT  OFFSET  
ERROR - 2021-11-16 14:03:31 --> Severity: Error --> Call to a member function result_array() on boolean C:\xampp\htdocs\hy\hyvesports\application\libraries\Datatable.php 49
ERROR - 2021-11-16 14:03:50 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near 'LIMIT  OFFSET' at line 12 - Invalid query: SELECT 
				SH.*,
				SHD.department_schedule_date,
				SHD.scheduled_order_info,
				SHD.schedule_department_id,
				SHD.order_is_approved,
				SHD.is_re_scheduled,
				WO.wo_date_time,WO.lead_id,CONCAT(SM.staff_code,"-",SM.staff_name) as sales_handler1,SM.staff_name as sales_handler,
				WO.orderform_type_id,WO.orderform_number,PO.production_unit_name,WO.wo_product_info,PM.priority_color_code,PM.priority_name
			FROM
				sh_schedule_departments AS SHD  LEFT JOIN sh_schedules  as SH on  SHD.schedule_id=SH.schedule_id LEFT JOIN wo_work_orders as WO on WO.order_id=SH.order_id LEFT JOIN staff_master as SM on SM.staff_id=WO.wo_owner_id AND WO.lead_id!=0 LEFT JOIN pr_production_units as PO on PO.production_unit_id=SHD.unit_id LEFT JOIN priority_master as PM on PM.priority_id=WO.wo_work_priority_id  WHERE ( FIND_IN_SET(4,SHD.department_ids) AND SHD.unit_id IN(0,1,2,3) AND SHD.department_schedule_date<"2021-11-16"
			 ) ORDER BY   LIMIT  OFFSET  
ERROR - 2021-11-16 14:03:50 --> Severity: Error --> Call to a member function result_array() on boolean C:\xampp\htdocs\hy\hyvesports\application\libraries\Datatable.php 49
ERROR - 2021-11-16 14:04:23 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near 'LIMIT  OFFSET' at line 12 - Invalid query: SELECT 
				SH.*,
				SHD.department_schedule_date,
				SHD.scheduled_order_info,
				SHD.schedule_department_id,
				SHD.order_is_approved,
				SHD.is_re_scheduled,
				WO.wo_date_time,WO.lead_id,CONCAT(SM.staff_code,"-",SM.staff_name) as sales_handler1,SM.staff_name as sales_handler,
				WO.orderform_type_id,WO.orderform_number,PO.production_unit_name,WO.wo_product_info,PM.priority_color_code,PM.priority_name
			FROM
				sh_schedule_departments AS SHD  LEFT JOIN sh_schedules  as SH on  SHD.schedule_id=SH.schedule_id LEFT JOIN wo_work_orders as WO on WO.order_id=SH.order_id LEFT JOIN staff_master as SM on SM.staff_id=WO.wo_owner_id AND WO.lead_id!=0 LEFT JOIN pr_production_units as PO on PO.production_unit_id=SHD.unit_id LEFT JOIN priority_master as PM on PM.priority_id=WO.wo_work_priority_id  WHERE ( FIND_IN_SET(4,SHD.department_ids) AND SHD.unit_id IN(0,1,2,3) AND SHD.department_schedule_date<"2021-11-16"
			 ) ORDER BY   LIMIT  OFFSET  
ERROR - 2021-11-16 14:04:23 --> Severity: Error --> Call to a member function result_array() on boolean C:\xampp\htdocs\hy\hyvesports\application\libraries\Datatable.php 49
ERROR - 2021-11-16 14:09:21 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\hy\hyvesports\application\views\design\orders_design_pending_new.php 53
ERROR - 2021-11-16 14:10:31 --> Severity: Warning --> mysqli::query(): Empty query C:\xampp\htdocs\hy\hyvesports\system\database\drivers\mysqli\mysqli_driver.php 307
ERROR - 2021-11-16 14:10:31 --> Query error:  - Invalid query: 
ERROR - 2021-11-16 14:10:31 --> Severity: Error --> Call to a member function result_array() on boolean C:\xampp\htdocs\hy\hyvesports\application\models\Design_model.php 51
ERROR - 2021-11-16 14:11:02 --> Severity: Warning --> mysqli::query(): Empty query C:\xampp\htdocs\hy\hyvesports\system\database\drivers\mysqli\mysqli_driver.php 307
ERROR - 2021-11-16 14:11:02 --> Query error:  - Invalid query: 
ERROR - 2021-11-16 14:11:02 --> Severity: Error --> Call to a member function result_array() on boolean C:\xampp\htdocs\hy\hyvesports\application\models\Design_model.php 51
ERROR - 2021-11-16 14:13:24 --> Severity: Parsing Error --> syntax error, unexpected '$row' (T_VARIABLE) C:\xampp\htdocs\hy\hyvesports\application\views\design\orders_design_pending_new.php 145
ERROR - 2021-11-16 14:22:05 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-16 14:22:05 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-16 14:22:06 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-16 14:22:06 --> 404 Page Not Found: Public/css
ERROR - 2021-11-16 14:30:32 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near 'LIMIT  OFFSET' at line 11 - Invalid query: SELECT 
				SH.*,
				SHD.department_schedule_date,
				SHD.scheduled_order_info,
				SHD.schedule_department_id,
				SHD.order_is_approved,
				SHD.is_re_scheduled,
				WO.wo_date_time,WO.lead_id,CONCAT(SM.staff_code,"-",SM.staff_name) as sales_handler1,SM.staff_name as sales_handler,
				WO.orderform_type_id,WO.orderform_number,PO.production_unit_name,WO.wo_product_info,PM.priority_color_code,PM.priority_name
			FROM
				sh_schedule_departments AS SHD  LEFT JOIN sh_schedules  as SH on  SHD.schedule_id=SH.schedule_id LEFT JOIN wo_work_orders as WO on WO.order_id=SH.order_id LEFT JOIN staff_master as SM on SM.staff_id=WO.wo_owner_id AND WO.lead_id!=0 LEFT JOIN pr_production_units as PO on PO.production_unit_id=SHD.unit_id LEFT JOIN priority_master as PM on PM.priority_id=WO.wo_work_priority_id  WHERE ( FIND_IN_SET(4,SHD.department_ids) AND SHD.unit_id IN(0,1,2,3)  ) ORDER BY   LIMIT  OFFSET  
ERROR - 2021-11-16 14:30:32 --> Severity: Error --> Call to a member function result_array() on boolean C:\xampp\htdocs\hy\hyvesports\application\libraries\Datatable.php 49
ERROR - 2021-11-16 14:30:35 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near 'LIMIT  OFFSET' at line 11 - Invalid query: SELECT 
				SH.*,
				SHD.department_schedule_date,
				SHD.scheduled_order_info,
				SHD.schedule_department_id,
				SHD.order_is_approved,
				SHD.is_re_scheduled,
				WO.wo_date_time,WO.lead_id,CONCAT(SM.staff_code,"-",SM.staff_name) as sales_handler1,SM.staff_name as sales_handler,
				WO.orderform_type_id,WO.orderform_number,PO.production_unit_name,WO.wo_product_info,PM.priority_color_code,PM.priority_name
			FROM
				sh_schedule_departments AS SHD  LEFT JOIN sh_schedules  as SH on  SHD.schedule_id=SH.schedule_id LEFT JOIN wo_work_orders as WO on WO.order_id=SH.order_id LEFT JOIN staff_master as SM on SM.staff_id=WO.wo_owner_id AND WO.lead_id!=0 LEFT JOIN pr_production_units as PO on PO.production_unit_id=SHD.unit_id LEFT JOIN priority_master as PM on PM.priority_id=WO.wo_work_priority_id  WHERE ( FIND_IN_SET(4,SHD.department_ids) AND SHD.unit_id IN(0,1,2,3)  ) ORDER BY   LIMIT  OFFSET  
ERROR - 2021-11-16 14:30:35 --> Severity: Error --> Call to a member function result_array() on boolean C:\xampp\htdocs\hy\hyvesports\application\libraries\Datatable.php 49
ERROR - 2021-11-16 14:30:53 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near 'LIMIT  OFFSET' at line 11 - Invalid query: SELECT 
				SH.*,
				SHD.department_schedule_date,
				SHD.scheduled_order_info,
				SHD.schedule_department_id,
				SHD.order_is_approved,
				SHD.is_re_scheduled,
				WO.wo_date_time,WO.lead_id,CONCAT(SM.staff_code,"-",SM.staff_name) as sales_handler1,SM.staff_name as sales_handler,
				WO.orderform_type_id,WO.orderform_number,PO.production_unit_name,WO.wo_product_info,PM.priority_color_code,PM.priority_name
			FROM
				sh_schedule_departments AS SHD  LEFT JOIN sh_schedules  as SH on  SHD.schedule_id=SH.schedule_id LEFT JOIN wo_work_orders as WO on WO.order_id=SH.order_id LEFT JOIN staff_master as SM on SM.staff_id=WO.wo_owner_id AND WO.lead_id!=0 LEFT JOIN pr_production_units as PO on PO.production_unit_id=SHD.unit_id LEFT JOIN priority_master as PM on PM.priority_id=WO.wo_work_priority_id  WHERE ( FIND_IN_SET(4,SHD.department_ids) AND SHD.unit_id IN(0,1,2,3)  ) ORDER BY   LIMIT  OFFSET  
ERROR - 2021-11-16 14:30:53 --> Severity: Error --> Call to a member function result_array() on boolean C:\xampp\htdocs\hy\hyvesports\application\libraries\Datatable.php 49
ERROR - 2021-11-16 14:30:56 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near 'LIMIT  OFFSET' at line 11 - Invalid query: SELECT 
				SH.*,
				SHD.department_schedule_date,
				SHD.scheduled_order_info,
				SHD.schedule_department_id,
				SHD.order_is_approved,
				SHD.is_re_scheduled,
				WO.wo_date_time,WO.lead_id,CONCAT(SM.staff_code,"-",SM.staff_name) as sales_handler1,SM.staff_name as sales_handler,
				WO.orderform_type_id,WO.orderform_number,PO.production_unit_name,WO.wo_product_info,PM.priority_color_code,PM.priority_name
			FROM
				sh_schedule_departments AS SHD  LEFT JOIN sh_schedules  as SH on  SHD.schedule_id=SH.schedule_id LEFT JOIN wo_work_orders as WO on WO.order_id=SH.order_id LEFT JOIN staff_master as SM on SM.staff_id=WO.wo_owner_id AND WO.lead_id!=0 LEFT JOIN pr_production_units as PO on PO.production_unit_id=SHD.unit_id LEFT JOIN priority_master as PM on PM.priority_id=WO.wo_work_priority_id  WHERE ( FIND_IN_SET(4,SHD.department_ids) AND SHD.unit_id IN(0,1,2,3)  ) ORDER BY   LIMIT  OFFSET  
ERROR - 2021-11-16 14:30:56 --> Severity: Error --> Call to a member function result_array() on boolean C:\xampp\htdocs\hy\hyvesports\application\libraries\Datatable.php 49
ERROR - 2021-11-16 14:31:07 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near 'LIMIT  OFFSET' at line 11 - Invalid query: SELECT 
				SH.*,
				SHD.department_schedule_date,
				SHD.scheduled_order_info,
				SHD.schedule_department_id,
				SHD.order_is_approved,
				SHD.is_re_scheduled,
				WO.wo_date_time,WO.lead_id,CONCAT(SM.staff_code,"-",SM.staff_name) as sales_handler1,SM.staff_name as sales_handler,
				WO.orderform_type_id,WO.orderform_number,PO.production_unit_name,WO.wo_product_info,PM.priority_color_code,PM.priority_name
			FROM
				sh_schedule_departments AS SHD  LEFT JOIN sh_schedules  as SH on  SHD.schedule_id=SH.schedule_id LEFT JOIN wo_work_orders as WO on WO.order_id=SH.order_id LEFT JOIN staff_master as SM on SM.staff_id=WO.wo_owner_id AND WO.lead_id!=0 LEFT JOIN pr_production_units as PO on PO.production_unit_id=SHD.unit_id LEFT JOIN priority_master as PM on PM.priority_id=WO.wo_work_priority_id  WHERE ( FIND_IN_SET(4,SHD.department_ids) AND SHD.unit_id IN(0,1,2,3)  ) ORDER BY   LIMIT  OFFSET  
ERROR - 2021-11-16 14:31:07 --> Severity: Error --> Call to a member function result_array() on boolean C:\xampp\htdocs\hy\hyvesports\application\libraries\Datatable.php 49
ERROR - 2021-11-16 14:31:13 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near 'LIMIT  OFFSET' at line 11 - Invalid query: SELECT 
				SH.*,
				SHD.department_schedule_date,
				SHD.scheduled_order_info,
				SHD.schedule_department_id,
				SHD.order_is_approved,
				SHD.is_re_scheduled,
				WO.wo_date_time,WO.lead_id,CONCAT(SM.staff_code,"-",SM.staff_name) as sales_handler1,SM.staff_name as sales_handler,
				WO.orderform_type_id,WO.orderform_number,PO.production_unit_name,WO.wo_product_info,PM.priority_color_code,PM.priority_name
			FROM
				sh_schedule_departments AS SHD  LEFT JOIN sh_schedules  as SH on  SHD.schedule_id=SH.schedule_id LEFT JOIN wo_work_orders as WO on WO.order_id=SH.order_id LEFT JOIN staff_master as SM on SM.staff_id=WO.wo_owner_id AND WO.lead_id!=0 LEFT JOIN pr_production_units as PO on PO.production_unit_id=SHD.unit_id LEFT JOIN priority_master as PM on PM.priority_id=WO.wo_work_priority_id  WHERE ( FIND_IN_SET(4,SHD.department_ids) AND SHD.unit_id IN(0,1,2,3)  ) ORDER BY   LIMIT  OFFSET  
ERROR - 2021-11-16 14:31:13 --> Severity: Error --> Call to a member function result_array() on boolean C:\xampp\htdocs\hy\hyvesports\application\libraries\Datatable.php 49
ERROR - 2021-11-16 14:31:37 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near 'LIMIT  OFFSET' at line 11 - Invalid query: SELECT 
				SH.*,
				SHD.department_schedule_date,
				SHD.scheduled_order_info,
				SHD.schedule_department_id,
				SHD.order_is_approved,
				SHD.is_re_scheduled,
				WO.wo_date_time,WO.lead_id,CONCAT(SM.staff_code,"-",SM.staff_name) as sales_handler1,SM.staff_name as sales_handler,
				WO.orderform_type_id,WO.orderform_number,PO.production_unit_name,WO.wo_product_info,PM.priority_color_code,PM.priority_name
			FROM
				sh_schedule_departments AS SHD  LEFT JOIN sh_schedules  as SH on  SHD.schedule_id=SH.schedule_id LEFT JOIN wo_work_orders as WO on WO.order_id=SH.order_id LEFT JOIN staff_master as SM on SM.staff_id=WO.wo_owner_id AND WO.lead_id!=0 LEFT JOIN pr_production_units as PO on PO.production_unit_id=SHD.unit_id LEFT JOIN priority_master as PM on PM.priority_id=WO.wo_work_priority_id  WHERE ( FIND_IN_SET(4,SHD.department_ids) AND SHD.unit_id IN(0,1,2,3)  ) ORDER BY   LIMIT  OFFSET  
ERROR - 2021-11-16 14:31:37 --> Severity: Error --> Call to a member function result_array() on boolean C:\xampp\htdocs\hy\hyvesports\application\libraries\Datatable.php 49
ERROR - 2021-11-16 14:34:10 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near 'LIMIT  OFFSET' at line 11 - Invalid query: SELECT 
				SH.*,
				SHD.department_schedule_date,
				SHD.scheduled_order_info,
				SHD.schedule_department_id,
				SHD.order_is_approved,
				SHD.is_re_scheduled,
				WO.wo_date_time,WO.lead_id,CONCAT(SM.staff_code,"-",SM.staff_name) as sales_handler1,SM.staff_name as sales_handler,
				WO.orderform_type_id,WO.orderform_number,PO.production_unit_name,WO.wo_product_info,PM.priority_color_code,PM.priority_name
			FROM
				sh_schedule_departments AS SHD  LEFT JOIN sh_schedules  as SH on  SHD.schedule_id=SH.schedule_id LEFT JOIN wo_work_orders as WO on WO.order_id=SH.order_id LEFT JOIN staff_master as SM on SM.staff_id=WO.wo_owner_id AND WO.lead_id!=0 LEFT JOIN pr_production_units as PO on PO.production_unit_id=SHD.unit_id LEFT JOIN priority_master as PM on PM.priority_id=WO.wo_work_priority_id  WHERE ( FIND_IN_SET(4,SHD.department_ids) AND SHD.unit_id IN(0,1,2,3)  ) ORDER BY   LIMIT  OFFSET  
ERROR - 2021-11-16 14:34:10 --> Severity: Error --> Call to a member function result_array() on boolean C:\xampp\htdocs\hy\hyvesports\application\libraries\Datatable.php 49
ERROR - 2021-11-16 14:34:14 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near 'LIMIT  OFFSET' at line 11 - Invalid query: SELECT 
				SH.*,
				SHD.department_schedule_date,
				SHD.scheduled_order_info,
				SHD.schedule_department_id,
				SHD.order_is_approved,
				SHD.is_re_scheduled,
				WO.wo_date_time,WO.lead_id,CONCAT(SM.staff_code,"-",SM.staff_name) as sales_handler1,SM.staff_name as sales_handler,
				WO.orderform_type_id,WO.orderform_number,PO.production_unit_name,WO.wo_product_info,PM.priority_color_code,PM.priority_name
			FROM
				sh_schedule_departments AS SHD  LEFT JOIN sh_schedules  as SH on  SHD.schedule_id=SH.schedule_id LEFT JOIN wo_work_orders as WO on WO.order_id=SH.order_id LEFT JOIN staff_master as SM on SM.staff_id=WO.wo_owner_id AND WO.lead_id!=0 LEFT JOIN pr_production_units as PO on PO.production_unit_id=SHD.unit_id LEFT JOIN priority_master as PM on PM.priority_id=WO.wo_work_priority_id  WHERE ( FIND_IN_SET(4,SHD.department_ids) AND SHD.unit_id IN(0,1,2,3)  ) ORDER BY   LIMIT  OFFSET  
ERROR - 2021-11-16 14:34:14 --> Severity: Error --> Call to a member function result_array() on boolean C:\xampp\htdocs\hy\hyvesports\application\libraries\Datatable.php 49
ERROR - 2021-11-16 14:34:16 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near 'LIMIT  OFFSET' at line 11 - Invalid query: SELECT 
				SH.*,
				SHD.department_schedule_date,
				SHD.scheduled_order_info,
				SHD.schedule_department_id,
				SHD.order_is_approved,
				SHD.is_re_scheduled,
				WO.wo_date_time,WO.lead_id,CONCAT(SM.staff_code,"-",SM.staff_name) as sales_handler1,SM.staff_name as sales_handler,
				WO.orderform_type_id,WO.orderform_number,PO.production_unit_name,WO.wo_product_info,PM.priority_color_code,PM.priority_name
			FROM
				sh_schedule_departments AS SHD  LEFT JOIN sh_schedules  as SH on  SHD.schedule_id=SH.schedule_id LEFT JOIN wo_work_orders as WO on WO.order_id=SH.order_id LEFT JOIN staff_master as SM on SM.staff_id=WO.wo_owner_id AND WO.lead_id!=0 LEFT JOIN pr_production_units as PO on PO.production_unit_id=SHD.unit_id LEFT JOIN priority_master as PM on PM.priority_id=WO.wo_work_priority_id  WHERE ( FIND_IN_SET(4,SHD.department_ids) AND SHD.unit_id IN(0,1,2,3)  ) ORDER BY   LIMIT  OFFSET  
ERROR - 2021-11-16 14:34:16 --> Severity: Error --> Call to a member function result_array() on boolean C:\xampp\htdocs\hy\hyvesports\application\libraries\Datatable.php 49
ERROR - 2021-11-16 15:21:23 --> 404 Page Not Found: Uploads/orderform
ERROR - 2021-11-16 16:30:52 --> Severity: Warning --> Packets out of order. Expected 189 received 97. Packet size=7233401 C:\xampp\htdocs\hy\hyvesports\system\database\drivers\mysqli\mysqli_driver.php 307
ERROR - 2021-11-16 16:31:12 --> Severity: Error --> Maximum execution time of 30 seconds exceeded C:\xampp\htdocs\hy\hyvesports\system\core\Common.php 595
ERROR - 2021-11-16 16:32:31 --> Severity: Error --> Out of memory (allocated 3145728) (tried to allocate 262128 bytes) C:\xampp\htdocs\hy\hyvesports\system\database\drivers\mysqli\mysqli_driver.php 307
ERROR - 2021-11-16 16:36:13 --> Severity: Error --> Maximum execution time of 30 seconds exceeded C:\xampp\htdocs\hy\hyvesports\system\database\drivers\mysqli\mysqli_driver.php 307
ERROR - 2021-11-16 16:38:44 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-16 16:38:44 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-16 16:39:04 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-16 16:39:04 --> 404 Page Not Found: Public/css
ERROR - 2021-11-16 16:39:04 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-16 16:39:05 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-16 16:39:05 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-16 16:39:05 --> 404 Page Not Found: Public/css
ERROR - 2021-11-16 16:41:15 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-16 16:41:16 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-16 16:41:16 --> 404 Page Not Found: Public/css
ERROR - 2021-11-16 16:41:16 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-16 23:04:34 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-16 23:04:34 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-16 23:04:35 --> 404 Page Not Found: Public/css
ERROR - 2021-11-16 23:04:35 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-16 23:06:38 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-16 23:06:39 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-16 23:06:39 --> 404 Page Not Found: Public/css
ERROR - 2021-11-16 23:06:39 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-16 23:07:03 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-16 23:07:04 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-16 23:07:04 --> 404 Page Not Found: Public/css
ERROR - 2021-11-16 23:07:04 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-16 23:07:16 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-16 23:07:16 --> 404 Page Not Found: Public/css
ERROR - 2021-11-16 23:07:16 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-16 23:07:17 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-16 23:07:26 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-16 23:07:26 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-16 23:07:27 --> 404 Page Not Found: Public/css
ERROR - 2021-11-16 23:07:27 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-16 23:07:30 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-16 23:07:30 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-16 23:07:30 --> 404 Page Not Found: Public/css
ERROR - 2021-11-16 23:07:30 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-16 23:07:34 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-16 23:07:35 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-16 23:07:35 --> 404 Page Not Found: Public/css
ERROR - 2021-11-16 23:07:35 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-16 23:08:02 --> 404 Page Not Found: Public/css
ERROR - 2021-11-16 23:08:02 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-16 23:08:02 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-16 23:08:03 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-16 23:08:09 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-16 23:08:10 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-16 23:08:10 --> 404 Page Not Found: Public/css
ERROR - 2021-11-16 23:08:10 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-16 23:37:43 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-16 23:37:43 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-16 23:37:43 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-16 23:37:43 --> 404 Page Not Found: Public/css
ERROR - 2021-11-16 23:39:06 --> 404 Page Not Found: Finalqc/upload
ERROR - 2021-11-16 23:47:54 --> Severity: Warning --> is_uploaded_file() expects parameter 1 to be string, array given C:\xampp\htdocs\hy\hyvesports\system\libraries\Upload.php 412
ERROR - 2021-11-16 23:47:54 --> Severity: Error --> Call to undefined method Finalqc::handle_error() C:\xampp\htdocs\hy\hyvesports\application\controllers\Finalqc.php 48
ERROR - 2021-11-16 23:48:39 --> Severity: Warning --> is_uploaded_file() expects parameter 1 to be string, array given C:\xampp\htdocs\hy\hyvesports\system\libraries\Upload.php 412
ERROR - 2021-11-16 23:48:39 --> Severity: Error --> Call to undefined method Finalqc::handle_error() C:\xampp\htdocs\hy\hyvesports\application\controllers\Finalqc.php 48
ERROR - 2021-11-16 23:49:40 --> Severity: Warning --> is_uploaded_file() expects parameter 1 to be string, array given C:\xampp\htdocs\hy\hyvesports\system\libraries\Upload.php 412
ERROR - 2021-11-16 23:49:40 --> Severity: Error --> Call to undefined method Finalqc::handle_error() C:\xampp\htdocs\hy\hyvesports\application\controllers\Finalqc.php 49
ERROR - 2021-11-16 23:51:01 --> Severity: Warning --> is_uploaded_file() expects parameter 1 to be string, array given C:\xampp\htdocs\hy\hyvesports\system\libraries\Upload.php 412
ERROR - 2021-11-16 23:51:01 --> Severity: Error --> Call to undefined method Finalqc::handle_error() C:\xampp\htdocs\hy\hyvesports\application\controllers\Finalqc.php 50
ERROR - 2021-11-16 23:51:50 --> Severity: Warning --> is_uploaded_file() expects parameter 1 to be string, array given C:\xampp\htdocs\hy\hyvesports\system\libraries\Upload.php 412
ERROR - 2021-11-16 23:51:50 --> Severity: Error --> Call to undefined method Finalqc::handle_error() C:\xampp\htdocs\hy\hyvesports\application\controllers\Finalqc.php 51
ERROR - 2021-11-16 23:52:26 --> Severity: Warning --> is_uploaded_file() expects parameter 1 to be string, array given C:\xampp\htdocs\hy\hyvesports\system\libraries\Upload.php 412
ERROR - 2021-11-16 23:52:26 --> Severity: Error --> Call to undefined method Finalqc::handle_error() C:\xampp\htdocs\hy\hyvesports\application\controllers\Finalqc.php 51
ERROR - 2021-11-16 23:58:22 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-16 23:58:23 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-16 23:58:24 --> 404 Page Not Found: Public/css
ERROR - 2021-11-16 23:58:24 --> 404 Page Not Found: Public/vendors

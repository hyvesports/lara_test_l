<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2021-11-28 09:24:37 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-28 09:24:37 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-28 09:24:37 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-28 09:24:37 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-28 09:24:37 --> 404 Page Not Found: Public/css
ERROR - 2021-11-28 09:24:58 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-28 09:24:58 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-28 09:25:11 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-28 09:25:11 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-28 09:25:11 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-28 09:25:11 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-28 09:25:11 --> 404 Page Not Found: Public/css
ERROR - 2021-11-28 09:26:13 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-28 09:26:14 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-28 09:26:14 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-28 09:26:14 --> 404 Page Not Found: Public/css
ERROR - 2021-11-28 09:26:14 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-28 09:47:31 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near '"' at line 11 - Invalid query: SELECT 
				SH.*,
				SHD.department_schedule_date,
				SHD.scheduled_order_info,
				SHD.schedule_department_id,
				SHD.order_is_approved,
				SHD.is_re_scheduled,
				WO.wo_date_time,WO.lead_id,CONCAT(SM.staff_code,"-",SM.staff_name) as sales_handler1,SM.staff_name as sales_handler,
				WO.orderform_type_id,WO.orderform_number,PO.production_unit_name,WO.wo_product_info,PM.priority_color_code,PM.priority_name
			FROM
				sh_schedule_departments AS SHD  LEFT JOIN sh_schedules  as SH on  SHD.schedule_id=SH.schedule_id LEFT JOIN wo_work_orders as WO on WO.order_id=SH.order_id LEFT JOIN staff_master as SM on SM.staff_id=WO.wo_owner_id AND WO.lead_id!=0 LEFT JOIN pr_production_units as PO on PO.production_unit_id=SHD.unit_id LEFT JOIN priority_master as PM on PM.priority_id=WO.wo_work_priority_id WHERE FIND_IN_SET(4,SHD.department_ids) AND SHD.unit_id IN(0,1,2,3)"
			
ERROR - 2021-11-28 09:47:31 --> Severity: Error --> Call to a member function result_array() on boolean C:\xampp\htdocs\hy\hyvesports\application\models\Design_model.php 124
ERROR - 2021-11-28 09:47:33 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near '"' at line 11 - Invalid query: SELECT 
				SH.*,
				SHD.department_schedule_date,
				SHD.scheduled_order_info,
				SHD.schedule_department_id,
				SHD.order_is_approved,
				SHD.is_re_scheduled,
				WO.wo_date_time,WO.lead_id,CONCAT(SM.staff_code,"-",SM.staff_name) as sales_handler1,SM.staff_name as sales_handler,
				WO.orderform_type_id,WO.orderform_number,PO.production_unit_name,WO.wo_product_info,PM.priority_color_code,PM.priority_name
			FROM
				sh_schedule_departments AS SHD  LEFT JOIN sh_schedules  as SH on  SHD.schedule_id=SH.schedule_id LEFT JOIN wo_work_orders as WO on WO.order_id=SH.order_id LEFT JOIN staff_master as SM on SM.staff_id=WO.wo_owner_id AND WO.lead_id!=0 LEFT JOIN pr_production_units as PO on PO.production_unit_id=SHD.unit_id LEFT JOIN priority_master as PM on PM.priority_id=WO.wo_work_priority_id WHERE FIND_IN_SET(4,SHD.department_ids) AND SHD.unit_id IN(0,1,2,3)"
			
ERROR - 2021-11-28 09:47:33 --> Severity: Error --> Call to a member function result_array() on boolean C:\xampp\htdocs\hy\hyvesports\application\models\Design_model.php 124
ERROR - 2021-11-28 09:47:50 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near '"' at line 11 - Invalid query: SELECT 
				SH.*,
				SHD.department_schedule_date,
				SHD.scheduled_order_info,
				SHD.schedule_department_id,
				SHD.order_is_approved,
				SHD.is_re_scheduled,
				WO.wo_date_time,WO.lead_id,CONCAT(SM.staff_code,"-",SM.staff_name) as sales_handler1,SM.staff_name as sales_handler,
				WO.orderform_type_id,WO.orderform_number,PO.production_unit_name,WO.wo_product_info,PM.priority_color_code,PM.priority_name
			FROM
				sh_schedule_departments AS SHD  LEFT JOIN sh_schedules  as SH on  SHD.schedule_id=SH.schedule_id LEFT JOIN wo_work_orders as WO on WO.order_id=SH.order_id LEFT JOIN staff_master as SM on SM.staff_id=WO.wo_owner_id AND WO.lead_id!=0 LEFT JOIN pr_production_units as PO on PO.production_unit_id=SHD.unit_id LEFT JOIN priority_master as PM on PM.priority_id=WO.wo_work_priority_id WHERE FIND_IN_SET(4,SHD.department_ids) AND SHD.unit_id IN(0,1,2,3) "
			
ERROR - 2021-11-28 09:47:50 --> Severity: Error --> Call to a member function result_array() on boolean C:\xampp\htdocs\hy\hyvesports\application\models\Design_model.php 124
ERROR - 2021-11-28 09:48:02 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near '"' at line 11 - Invalid query: SELECT 
				SH.*,
				SHD.department_schedule_date,
				SHD.scheduled_order_info,
				SHD.schedule_department_id,
				SHD.order_is_approved,
				SHD.is_re_scheduled,
				WO.wo_date_time,WO.lead_id,CONCAT(SM.staff_code,"-",SM.staff_name) as sales_handler1,SM.staff_name as sales_handler,
				WO.orderform_type_id,WO.orderform_number,PO.production_unit_name,WO.wo_product_info,PM.priority_color_code,PM.priority_name
			FROM
				sh_schedule_departments AS SHD  LEFT JOIN sh_schedules  as SH on  SHD.schedule_id=SH.schedule_id LEFT JOIN wo_work_orders as WO on WO.order_id=SH.order_id LEFT JOIN staff_master as SM on SM.staff_id=WO.wo_owner_id AND WO.lead_id!=0 LEFT JOIN pr_production_units as PO on PO.production_unit_id=SHD.unit_id LEFT JOIN priority_master as PM on PM.priority_id=WO.wo_work_priority_id WHERE FIND_IN_SET(4,SHD.department_ids) AND SHD.unit_id IN(0,1,2,3) "
			
ERROR - 2021-11-28 09:48:02 --> Severity: Error --> Call to a member function result_array() on boolean C:\xampp\htdocs\hy\hyvesports\application\models\Design_model.php 124
ERROR - 2021-11-28 09:48:04 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near '"' at line 11 - Invalid query: SELECT 
				SH.*,
				SHD.department_schedule_date,
				SHD.scheduled_order_info,
				SHD.schedule_department_id,
				SHD.order_is_approved,
				SHD.is_re_scheduled,
				WO.wo_date_time,WO.lead_id,CONCAT(SM.staff_code,"-",SM.staff_name) as sales_handler1,SM.staff_name as sales_handler,
				WO.orderform_type_id,WO.orderform_number,PO.production_unit_name,WO.wo_product_info,PM.priority_color_code,PM.priority_name
			FROM
				sh_schedule_departments AS SHD  LEFT JOIN sh_schedules  as SH on  SHD.schedule_id=SH.schedule_id LEFT JOIN wo_work_orders as WO on WO.order_id=SH.order_id LEFT JOIN staff_master as SM on SM.staff_id=WO.wo_owner_id AND WO.lead_id!=0 LEFT JOIN pr_production_units as PO on PO.production_unit_id=SHD.unit_id LEFT JOIN priority_master as PM on PM.priority_id=WO.wo_work_priority_id WHERE FIND_IN_SET(4,SHD.department_ids) AND SHD.unit_id IN(0,1,2,3) "
			
ERROR - 2021-11-28 09:48:04 --> Severity: Error --> Call to a member function result_array() on boolean C:\xampp\htdocs\hy\hyvesports\application\models\Design_model.php 124
ERROR - 2021-11-28 09:48:07 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near '"' at line 11 - Invalid query: SELECT 
				SH.*,
				SHD.department_schedule_date,
				SHD.scheduled_order_info,
				SHD.schedule_department_id,
				SHD.order_is_approved,
				SHD.is_re_scheduled,
				WO.wo_date_time,WO.lead_id,CONCAT(SM.staff_code,"-",SM.staff_name) as sales_handler1,SM.staff_name as sales_handler,
				WO.orderform_type_id,WO.orderform_number,PO.production_unit_name,WO.wo_product_info,PM.priority_color_code,PM.priority_name
			FROM
				sh_schedule_departments AS SHD  LEFT JOIN sh_schedules  as SH on  SHD.schedule_id=SH.schedule_id LEFT JOIN wo_work_orders as WO on WO.order_id=SH.order_id LEFT JOIN staff_master as SM on SM.staff_id=WO.wo_owner_id AND WO.lead_id!=0 LEFT JOIN pr_production_units as PO on PO.production_unit_id=SHD.unit_id LEFT JOIN priority_master as PM on PM.priority_id=WO.wo_work_priority_id WHERE FIND_IN_SET(4,SHD.department_ids) AND SHD.unit_id IN(0,1,2,3) "
			
ERROR - 2021-11-28 09:48:07 --> Severity: Error --> Call to a member function result_array() on boolean C:\xampp\htdocs\hy\hyvesports\application\models\Design_model.php 124
ERROR - 2021-11-28 09:48:09 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near '"' at line 11 - Invalid query: SELECT 
				SH.*,
				SHD.department_schedule_date,
				SHD.scheduled_order_info,
				SHD.schedule_department_id,
				SHD.order_is_approved,
				SHD.is_re_scheduled,
				WO.wo_date_time,WO.lead_id,CONCAT(SM.staff_code,"-",SM.staff_name) as sales_handler1,SM.staff_name as sales_handler,
				WO.orderform_type_id,WO.orderform_number,PO.production_unit_name,WO.wo_product_info,PM.priority_color_code,PM.priority_name
			FROM
				sh_schedule_departments AS SHD  LEFT JOIN sh_schedules  as SH on  SHD.schedule_id=SH.schedule_id LEFT JOIN wo_work_orders as WO on WO.order_id=SH.order_id LEFT JOIN staff_master as SM on SM.staff_id=WO.wo_owner_id AND WO.lead_id!=0 LEFT JOIN pr_production_units as PO on PO.production_unit_id=SHD.unit_id LEFT JOIN priority_master as PM on PM.priority_id=WO.wo_work_priority_id WHERE FIND_IN_SET(4,SHD.department_ids) AND SHD.unit_id IN(0,1,2,3) "
			
ERROR - 2021-11-28 09:48:09 --> Severity: Error --> Call to a member function result_array() on boolean C:\xampp\htdocs\hy\hyvesports\application\models\Design_model.php 124
ERROR - 2021-11-28 09:48:22 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near '"' at line 11 - Invalid query: SELECT 
				SH.*,
				SHD.department_schedule_date,
				SHD.scheduled_order_info,
				SHD.schedule_department_id,
				SHD.order_is_approved,
				SHD.is_re_scheduled,
				WO.wo_date_time,WO.lead_id,CONCAT(SM.staff_code,"-",SM.staff_name) as sales_handler1,SM.staff_name as sales_handler,
				WO.orderform_type_id,WO.orderform_number,PO.production_unit_name,WO.wo_product_info,PM.priority_color_code,PM.priority_name
			FROM
				sh_schedule_departments AS SHD  LEFT JOIN sh_schedules  as SH on  SHD.schedule_id=SH.schedule_id LEFT JOIN wo_work_orders as WO on WO.order_id=SH.order_id LEFT JOIN staff_master as SM on SM.staff_id=WO.wo_owner_id AND WO.lead_id!=0 LEFT JOIN pr_production_units as PO on PO.production_unit_id=SHD.unit_id LEFT JOIN priority_master as PM on PM.priority_id=WO.wo_work_priority_id WHERE FIND_IN_SET(4,SHD.department_ids) AND SHD.unit_id IN(0,1,2,3) "
			
ERROR - 2021-11-28 09:48:22 --> Severity: Error --> Call to a member function result_array() on boolean C:\xampp\htdocs\hy\hyvesports\application\models\Design_model.php 124
ERROR - 2021-11-28 09:48:26 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near '"' at line 11 - Invalid query: SELECT 
				SH.*,
				SHD.department_schedule_date,
				SHD.scheduled_order_info,
				SHD.schedule_department_id,
				SHD.order_is_approved,
				SHD.is_re_scheduled,
				WO.wo_date_time,WO.lead_id,CONCAT(SM.staff_code,"-",SM.staff_name) as sales_handler1,SM.staff_name as sales_handler,
				WO.orderform_type_id,WO.orderform_number,PO.production_unit_name,WO.wo_product_info,PM.priority_color_code,PM.priority_name
			FROM
				sh_schedule_departments AS SHD  LEFT JOIN sh_schedules  as SH on  SHD.schedule_id=SH.schedule_id LEFT JOIN wo_work_orders as WO on WO.order_id=SH.order_id LEFT JOIN staff_master as SM on SM.staff_id=WO.wo_owner_id AND WO.lead_id!=0 LEFT JOIN pr_production_units as PO on PO.production_unit_id=SHD.unit_id LEFT JOIN priority_master as PM on PM.priority_id=WO.wo_work_priority_id WHERE FIND_IN_SET(4,SHD.department_ids) AND SHD.unit_id IN(0,1,2,3) "
			
ERROR - 2021-11-28 09:48:26 --> Severity: Error --> Call to a member function result_array() on boolean C:\xampp\htdocs\hy\hyvesports\application\models\Design_model.php 124
ERROR - 2021-11-28 09:48:47 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near '"' at line 11 - Invalid query: SELECT 
				SH.*,
				SHD.department_schedule_date,
				SHD.scheduled_order_info,
				SHD.schedule_department_id,
				SHD.order_is_approved,
				SHD.is_re_scheduled,
				WO.wo_date_time,WO.lead_id,CONCAT(SM.staff_code,"-",SM.staff_name) as sales_handler1,SM.staff_name as sales_handler,
				WO.orderform_type_id,WO.orderform_number,PO.production_unit_name,WO.wo_product_info,PM.priority_color_code,PM.priority_name
			FROM
				sh_schedule_departments AS SHD  LEFT JOIN sh_schedules  as SH on  SHD.schedule_id=SH.schedule_id LEFT JOIN wo_work_orders as WO on WO.order_id=SH.order_id LEFT JOIN staff_master as SM on SM.staff_id=WO.wo_owner_id AND WO.lead_id!=0 LEFT JOIN pr_production_units as PO on PO.production_unit_id=SHD.unit_id LEFT JOIN priority_master as PM on PM.priority_id=WO.wo_work_priority_id WHERE FIND_IN_SET(4,SHD.department_ids) AND SHD.unit_id IN(0,1,2,3) "
			
ERROR - 2021-11-28 09:48:47 --> Severity: Error --> Call to a member function result_array() on boolean C:\xampp\htdocs\hy\hyvesports\application\models\Design_model.php 124
ERROR - 2021-11-28 10:47:44 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-28 10:47:44 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-28 10:47:44 --> 404 Page Not Found: Public/css
ERROR - 2021-11-28 10:47:44 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-28 10:47:44 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-28 12:08:55 --> Severity: Error --> Maximum execution time of 30 seconds exceeded C:\xampp\htdocs\hy\hyvesports\system\database\drivers\mysqli\mysqli_driver.php 307
ERROR - 2021-11-28 14:29:22 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-28 14:29:22 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-28 14:29:23 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-28 14:29:23 --> 404 Page Not Found: Public/css
ERROR - 2021-11-28 14:29:23 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-28 14:29:24 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-28 14:29:24 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-28 14:29:24 --> 404 Page Not Found: Public/css
ERROR - 2021-11-28 14:29:54 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-28 14:29:55 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-28 14:29:55 --> 404 Page Not Found: Public/css
ERROR - 2021-11-28 14:29:55 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-28 14:30:35 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-28 14:30:36 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-28 14:30:36 --> 404 Page Not Found: Public/css
ERROR - 2021-11-28 14:30:36 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-28 14:59:29 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-28 14:59:30 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-28 14:59:30 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-28 14:59:30 --> 404 Page Not Found: Public/css
ERROR - 2021-11-28 14:59:30 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-28 14:59:31 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-28 14:59:32 --> 404 Page Not Found: Public/css
ERROR - 2021-11-28 14:59:32 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-28 15:00:13 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-28 15:00:13 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-28 15:00:14 --> 404 Page Not Found: Public/css
ERROR - 2021-11-28 15:00:14 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-28 15:01:56 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-28 15:01:56 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-28 15:01:57 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-28 15:01:57 --> 404 Page Not Found: Public/css
ERROR - 2021-11-28 15:02:29 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-28 15:02:30 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-28 15:02:30 --> 404 Page Not Found: Public/css
ERROR - 2021-11-28 15:02:30 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-28 15:04:33 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-28 15:04:33 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-28 15:04:33 --> 404 Page Not Found: Public/css
ERROR - 2021-11-28 15:04:33 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-28 15:04:52 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-28 15:04:52 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-28 15:04:52 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-28 15:04:53 --> 404 Page Not Found: Public/css
ERROR - 2021-11-28 15:52:58 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-28 15:52:58 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-28 15:52:58 --> 404 Page Not Found: Public/css
ERROR - 2021-11-28 15:52:58 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-28 15:53:00 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-28 15:53:00 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-28 15:53:01 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-28 15:53:01 --> 404 Page Not Found: Public/css
ERROR - 2021-11-28 15:53:24 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-28 15:53:25 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-28 15:53:25 --> 404 Page Not Found: Public/css
ERROR - 2021-11-28 15:53:25 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-28 15:53:29 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-28 15:53:30 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-28 15:53:30 --> 404 Page Not Found: Public/css
ERROR - 2021-11-28 15:53:30 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-28 15:53:42 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-28 15:53:42 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-28 15:53:42 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-28 15:53:42 --> 404 Page Not Found: Public/css
ERROR - 2021-11-28 15:53:54 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-28 15:53:55 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-28 15:53:55 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-28 15:53:55 --> 404 Page Not Found: Public/css
ERROR - 2021-11-28 16:38:39 --> Severity: Warning --> mysqli::real_connect(): (HY000/2002): No connection could be made because the target machine actively refused it.
 C:\xampp\htdocs\hy\hyvesports\system\database\drivers\mysqli\mysqli_driver.php 203
ERROR - 2021-11-28 16:38:39 --> Unable to connect to the database
ERROR - 2021-11-28 16:38:42 --> Severity: Warning --> mysqli::real_connect(): (HY000/2002): No connection could be made because the target machine actively refused it.
 C:\xampp\htdocs\hy\hyvesports\system\database\drivers\mysqli\mysqli_driver.php 203
ERROR - 2021-11-28 16:38:42 --> Unable to connect to the database
ERROR - 2021-11-28 16:38:42 --> Query error: No connection could be made because the target machine actively refused it.
 - Invalid query: SELECT * FROM staff_master WHERE login_id='12' 
ERROR - 2021-11-28 16:38:42 --> Severity: Error --> Call to a member function row_array() on boolean C:\xampp\htdocs\hy\hyvesports\application\models\Myaccount_model.php 200
ERROR - 2021-11-28 16:45:29 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-28 16:45:29 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-28 16:45:30 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-28 16:45:30 --> 404 Page Not Found: Public/css
ERROR - 2021-11-28 16:45:35 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-28 16:45:36 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-28 16:45:36 --> 404 Page Not Found: Public/css
ERROR - 2021-11-28 16:45:36 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-28 16:45:38 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-28 16:45:39 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-28 16:45:39 --> 404 Page Not Found: Public/css
ERROR - 2021-11-28 16:45:39 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-28 16:55:14 --> Severity: Compile Error --> Cannot redeclare Qc::list_design_qc_pending() C:\xampp\htdocs\hy\hyvesports\application\controllers\Qc.php 112
ERROR - 2021-11-28 16:55:20 --> Severity: Compile Error --> Cannot redeclare Qc::list_design_qc_pending() C:\xampp\htdocs\hy\hyvesports\application\controllers\Qc.php 112
ERROR - 2021-11-28 17:00:43 --> Severity: Compile Error --> Cannot redeclare Qc::list_design_qc_pending() C:\xampp\htdocs\hy\hyvesports\application\controllers\Qc.php 112
ERROR - 2021-11-28 17:00:51 --> Severity: Compile Error --> Cannot redeclare Qc::list_design_qc_pending() C:\xampp\htdocs\hy\hyvesports\application\controllers\Qc.php 112
ERROR - 2021-11-28 17:00:54 --> Severity: Compile Error --> Cannot redeclare Qc::list_design_qc_pending() C:\xampp\htdocs\hy\hyvesports\application\controllers\Qc.php 112
ERROR - 2021-11-28 17:48:13 --> 404 Page Not Found: Myaccount/updates_design
ERROR - 2021-11-28 18:10:34 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-28 18:10:34 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-28 18:10:35 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-28 18:10:35 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-28 18:10:35 --> 404 Page Not Found: Public/css
ERROR - 2021-11-28 18:14:32 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-28 18:14:32 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-28 18:14:32 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-28 18:14:32 --> 404 Page Not Found: Public/css
ERROR - 2021-11-28 18:14:32 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-28 18:14:37 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-28 18:14:38 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-28 18:14:38 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-28 18:14:38 --> 404 Page Not Found: Public/css
ERROR - 2021-11-28 18:14:38 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-28 18:15:43 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-28 18:15:44 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-28 18:15:44 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-28 18:15:44 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-28 18:15:45 --> 404 Page Not Found: Public/css
ERROR - 2021-11-28 18:24:43 --> 404 Page Not Found: Myaccount/updates_design
ERROR - 2021-11-28 18:25:15 --> 404 Page Not Found: Myaccount/updates_design
ERROR - 2021-11-28 18:25:19 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-28 18:25:19 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-28 18:25:19 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-28 18:25:19 --> 404 Page Not Found: Public/css
ERROR - 2021-11-28 18:25:19 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-28 18:25:20 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-28 18:25:21 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-28 18:25:22 --> 404 Page Not Found: Public/css
ERROR - 2021-11-28 18:25:22 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-28 18:25:22 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-28 18:25:23 --> 404 Page Not Found: Myaccount/updates_design
ERROR - 2021-11-28 18:27:39 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-28 18:27:40 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-28 18:27:41 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-28 18:27:41 --> 404 Page Not Found: Public/css
ERROR - 2021-11-28 18:27:41 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-28 18:29:25 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-28 18:29:25 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-28 18:29:25 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-28 18:29:25 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-28 18:29:25 --> 404 Page Not Found: Public/css
ERROR - 2021-11-28 18:41:14 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-28 18:41:14 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-28 18:41:14 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-28 18:41:14 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-28 18:41:14 --> 404 Page Not Found: Public/css
ERROR - 2021-11-28 19:31:07 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-28 19:31:07 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-28 19:31:07 --> 404 Page Not Found: Public/css
ERROR - 2021-11-28 19:31:07 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-28 19:31:07 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-28 19:31:08 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-28 19:31:09 --> 404 Page Not Found: Public/css
ERROR - 2021-11-28 19:31:09 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-28 19:32:45 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-28 19:32:45 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-28 19:32:46 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-28 19:32:46 --> 404 Page Not Found: Public/css
ERROR - 2021-11-28 19:33:23 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-28 19:33:24 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-28 19:33:24 --> 404 Page Not Found: Public/css
ERROR - 2021-11-28 19:33:24 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-28 19:34:26 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-28 19:34:26 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-28 19:34:26 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-28 19:34:26 --> 404 Page Not Found: Public/css
ERROR - 2021-11-28 19:34:49 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-28 19:34:50 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-28 19:34:50 --> 404 Page Not Found: Public/css
ERROR - 2021-11-28 19:34:50 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-28 19:42:44 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-28 19:42:44 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-28 19:42:44 --> 404 Page Not Found: Public/css
ERROR - 2021-11-28 19:42:44 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-28 19:42:44 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-28 19:42:45 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-28 19:42:45 --> 404 Page Not Found: Public/css
ERROR - 2021-11-28 19:42:45 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-28 19:46:01 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-28 19:46:02 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-28 19:46:03 --> 404 Page Not Found: Public/css
ERROR - 2021-11-28 19:46:03 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-28 19:46:29 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-28 19:46:29 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-28 19:46:30 --> 404 Page Not Found: Public/css
ERROR - 2021-11-28 19:46:30 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-28 19:48:44 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-28 19:48:44 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-28 19:48:44 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-28 19:48:44 --> 404 Page Not Found: Public/css
ERROR - 2021-11-28 19:48:45 --> Severity: Warning --> json_decode() expects parameter 1 to be string, array given C:\xampp\htdocs\hy\hyvesports\application\controllers\Qc.php 206
ERROR - 2021-11-28 19:49:36 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-28 19:49:36 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-28 19:49:37 --> 404 Page Not Found: Public/css
ERROR - 2021-11-28 19:49:37 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-28 19:51:18 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-28 19:51:18 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-28 19:51:19 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-28 19:51:19 --> 404 Page Not Found: Public/css
ERROR - 2021-11-28 19:52:13 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-28 19:52:13 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-28 19:52:13 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-28 19:52:13 --> 404 Page Not Found: Public/css
ERROR - 2021-11-28 19:53:49 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-28 19:53:49 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-28 19:53:49 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-28 19:53:49 --> 404 Page Not Found: Public/css
ERROR - 2021-11-28 19:53:53 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-28 19:53:53 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-28 19:53:54 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-28 19:53:54 --> 404 Page Not Found: Public/css
ERROR - 2021-11-28 19:54:45 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-28 19:54:46 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-28 19:54:46 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-28 19:54:46 --> 404 Page Not Found: Public/css
ERROR - 2021-11-28 19:57:15 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-28 19:57:16 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-28 19:57:16 --> 404 Page Not Found: Public/css
ERROR - 2021-11-28 19:57:16 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-28 19:58:28 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-28 19:58:29 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-28 19:58:29 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-28 19:58:29 --> 404 Page Not Found: Public/css

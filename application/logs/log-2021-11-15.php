<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2021-11-15 16:36:57 --> 404 Page Not Found: Public/vendors
<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2021-11-15 16:36:57 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-15 16:36:58 --> 404 Page Not Found: Public/css
ERROR - 2021-11-15 16:36:58 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-15 16:37:01 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-15 16:37:02 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-15 16:37:02 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-15 16:37:02 --> 404 Page Not Found: Public/css
ERROR - 2021-11-15 16:39:40 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-15 16:39:40 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-15 16:39:41 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-15 16:39:41 --> 404 Page Not Found: Public/css
ERROR - 2021-11-15 16:40:32 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-15 16:40:33 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-15 16:40:33 --> 404 Page Not Found: Public/css
ERROR - 2021-11-15 16:40:33 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-15 16:40:37 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-15 16:40:37 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-15 16:40:38 --> 404 Page Not Found: Public/css
ERROR - 2021-11-15 16:40:38 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-15 19:16:06 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-15 19:16:06 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-15 19:16:06 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-15 19:16:06 --> 404 Page Not Found: Public/css
ERROR - 2021-11-15 19:16:06 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-15 19:16:07 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-15 19:16:08 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-15 19:16:08 --> 404 Page Not Found: Public/css
ERROR - 2021-11-15 19:16:12 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-15 19:16:12 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-15 19:16:13 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-15 19:16:13 --> 404 Page Not Found: Public/css
ERROR - 2021-11-15 19:21:42 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-15 19:21:42 --> 404 Page Not Found: Public/css
ERROR - 2021-11-15 19:21:42 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-15 19:21:44 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-15 19:40:55 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-15 19:40:55 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-15 19:40:55 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-15 19:40:55 --> 404 Page Not Found: Public/css
ERROR - 2021-11-15 20:45:06 --> 404 Page Not Found: Uploads/orderform
ERROR - 2021-11-15 20:45:08 --> 404 Page Not Found: Uploads/orderform
ERROR - 2021-11-15 20:46:12 --> 404 Page Not Found: Uploads/orderform
ERROR - 2021-11-15 21:38:20 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-15 21:38:21 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-15 21:38:21 --> 404 Page Not Found: Public/css
ERROR - 2021-11-15 21:38:21 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-15 21:38:56 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-15 21:38:56 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-15 21:38:57 --> 404 Page Not Found: Public/css
ERROR - 2021-11-15 21:38:57 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-15 21:53:48 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near 'LIMIT  OFFSET' at line 11 - Invalid query: SELECT 
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
ERROR - 2021-11-15 21:53:49 --> Severity: Error --> Call to a member function result_array() on boolean C:\xampp\htdocs\hy\hyvesports\application\libraries\Datatable.php 49
ERROR - 2021-11-15 21:54:31 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near 'LIMIT  OFFSET' at line 11 - Invalid query: SELECT 
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
ERROR - 2021-11-15 21:54:31 --> Severity: Error --> Call to a member function result_array() on boolean C:\xampp\htdocs\hy\hyvesports\application\libraries\Datatable.php 49
ERROR - 2021-11-15 21:56:48 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-15 21:56:48 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-15 21:56:48 --> 404 Page Not Found: Public/css
ERROR - 2021-11-15 21:56:48 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-15 21:56:55 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-15 21:56:56 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-15 21:56:56 --> 404 Page Not Found: Public/css
ERROR - 2021-11-15 21:56:56 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-15 21:57:22 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-15 21:57:23 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-15 21:57:23 --> 404 Page Not Found: Public/css
ERROR - 2021-11-15 21:57:23 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-15 21:58:45 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-15 21:58:46 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-15 21:58:46 --> 404 Page Not Found: Public/css
ERROR - 2021-11-15 21:58:46 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-15 21:58:49 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-15 21:58:50 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-15 21:58:50 --> 404 Page Not Found: Public/css
ERROR - 2021-11-15 21:58:50 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-15 22:00:12 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-15 22:00:12 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-15 22:00:13 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-15 22:00:13 --> 404 Page Not Found: Public/css
ERROR - 2021-11-15 22:00:48 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-15 22:00:49 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-15 22:00:49 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-15 22:00:49 --> 404 Page Not Found: Public/css
ERROR - 2021-11-15 22:02:44 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near 'LIMIT  OFFSET' at line 11 - Invalid query: SELECT 
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
ERROR - 2021-11-15 22:02:44 --> Severity: Error --> Call to a member function result_array() on boolean C:\xampp\htdocs\hy\hyvesports\application\libraries\Datatable.php 49
ERROR - 2021-11-15 22:02:51 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-15 22:02:51 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-15 22:02:51 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-15 22:02:51 --> 404 Page Not Found: Public/css
ERROR - 2021-11-15 22:02:52 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near 'LIMIT  OFFSET' at line 11 - Invalid query: SELECT 
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
ERROR - 2021-11-15 22:02:52 --> Severity: Error --> Call to a member function result_array() on boolean C:\xampp\htdocs\hy\hyvesports\application\libraries\Datatable.php 49
ERROR - 2021-11-15 22:03:17 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near 'LIMIT  OFFSET' at line 11 - Invalid query: SELECT 
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
ERROR - 2021-11-15 22:03:17 --> Severity: Error --> Call to a member function result_array() on boolean C:\xampp\htdocs\hy\hyvesports\application\libraries\Datatable.php 49
ERROR - 2021-11-15 22:03:48 --> 404 Page Not Found: Public/css
ERROR - 2021-11-15 22:03:48 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-15 22:03:48 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-15 22:03:48 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-15 22:03:50 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near 'LIMIT  OFFSET' at line 11 - Invalid query: SELECT 
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
ERROR - 2021-11-15 22:03:50 --> Severity: Error --> Call to a member function result_array() on boolean C:\xampp\htdocs\hy\hyvesports\application\libraries\Datatable.php 49
ERROR - 2021-11-15 22:05:46 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-15 22:05:47 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-15 22:05:47 --> 404 Page Not Found: Public/css
ERROR - 2021-11-15 22:05:47 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-15 22:06:01 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near 'LIMIT  OFFSET' at line 11 - Invalid query: SELECT 
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
ERROR - 2021-11-15 22:06:01 --> Severity: Error --> Call to a member function result_array() on boolean C:\xampp\htdocs\hy\hyvesports\application\libraries\Datatable.php 49
ERROR - 2021-11-15 22:07:06 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near 'LIMIT  OFFSET' at line 11 - Invalid query: SELECT 
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
ERROR - 2021-11-15 22:07:06 --> Severity: Error --> Call to a member function result_array() on boolean C:\xampp\htdocs\hy\hyvesports\application\libraries\Datatable.php 49
ERROR - 2021-11-15 22:07:06 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-15 22:07:07 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-15 22:07:07 --> 404 Page Not Found: Public/css
ERROR - 2021-11-15 22:07:07 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-15 22:07:15 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-15 22:07:16 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-15 22:07:16 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-15 22:07:16 --> 404 Page Not Found: Public/css
ERROR - 2021-11-15 22:07:37 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-15 22:07:38 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-15 22:07:38 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-15 22:07:38 --> 404 Page Not Found: Public/css
ERROR - 2021-11-15 22:07:52 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-15 22:07:52 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near 'LIMIT  OFFSET' at line 11 - Invalid query: SELECT 
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
ERROR - 2021-11-15 22:07:52 --> Severity: Error --> Call to a member function result_array() on boolean C:\xampp\htdocs\hy\hyvesports\application\libraries\Datatable.php 49
ERROR - 2021-11-15 22:07:53 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-15 22:07:53 --> 404 Page Not Found: Public/css
ERROR - 2021-11-15 22:07:53 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-15 22:08:16 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near 'LIMIT  OFFSET' at line 11 - Invalid query: SELECT 
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
ERROR - 2021-11-15 22:08:16 --> Severity: Error --> Call to a member function result_array() on boolean C:\xampp\htdocs\hy\hyvesports\application\libraries\Datatable.php 49
ERROR - 2021-11-15 22:08:16 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-15 22:08:17 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-15 22:08:18 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-15 22:08:18 --> 404 Page Not Found: Public/css
ERROR - 2021-11-15 22:08:18 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-15 22:11:58 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near 'LIMIT  OFFSET' at line 11 - Invalid query: SELECT 
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
ERROR - 2021-11-15 22:11:58 --> Severity: Error --> Call to a member function result_array() on boolean C:\xampp\htdocs\hy\hyvesports\application\libraries\Datatable.php 49
ERROR - 2021-11-15 22:11:59 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-15 22:12:00 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-15 22:12:00 --> 404 Page Not Found: Public/css
ERROR - 2021-11-15 22:12:00 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-15 22:12:18 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near 'LIMIT  OFFSET' at line 11 - Invalid query: SELECT 
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
ERROR - 2021-11-15 22:12:18 --> Severity: Error --> Call to a member function result_array() on boolean C:\xampp\htdocs\hy\hyvesports\application\libraries\Datatable.php 49
ERROR - 2021-11-15 22:12:19 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-15 22:12:19 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-15 22:12:20 --> 404 Page Not Found: Public/css
ERROR - 2021-11-15 22:12:20 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-15 22:12:28 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near 'LIMIT  OFFSET' at line 11 - Invalid query: SELECT 
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
ERROR - 2021-11-15 22:12:28 --> Severity: Error --> Call to a member function result_array() on boolean C:\xampp\htdocs\hy\hyvesports\application\libraries\Datatable.php 49
ERROR - 2021-11-15 22:12:44 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near 'LIMIT  OFFSET' at line 11 - Invalid query: SELECT 
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
ERROR - 2021-11-15 22:12:44 --> Severity: Error --> Call to a member function result_array() on boolean C:\xampp\htdocs\hy\hyvesports\application\libraries\Datatable.php 49
ERROR - 2021-11-15 22:12:45 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near 'LIMIT  OFFSET' at line 11 - Invalid query: SELECT 
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
ERROR - 2021-11-15 22:12:45 --> Severity: Error --> Call to a member function result_array() on boolean C:\xampp\htdocs\hy\hyvesports\application\libraries\Datatable.php 49
ERROR - 2021-11-15 22:12:47 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near 'LIMIT  OFFSET' at line 11 - Invalid query: SELECT 
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
ERROR - 2021-11-15 22:12:47 --> Severity: Error --> Call to a member function result_array() on boolean C:\xampp\htdocs\hy\hyvesports\application\libraries\Datatable.php 49
ERROR - 2021-11-15 22:12:50 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near 'LIMIT  OFFSET' at line 11 - Invalid query: SELECT 
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
ERROR - 2021-11-15 22:12:50 --> Severity: Error --> Call to a member function result_array() on boolean C:\xampp\htdocs\hy\hyvesports\application\libraries\Datatable.php 49
ERROR - 2021-11-15 22:12:53 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-15 22:12:53 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-15 22:12:54 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-15 22:12:54 --> 404 Page Not Found: Public/css
ERROR - 2021-11-15 22:13:03 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near 'LIMIT  OFFSET' at line 11 - Invalid query: SELECT 
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
ERROR - 2021-11-15 22:13:03 --> Severity: Error --> Call to a member function result_array() on boolean C:\xampp\htdocs\hy\hyvesports\application\libraries\Datatable.php 49
ERROR - 2021-11-15 22:13:06 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near 'LIMIT  OFFSET' at line 11 - Invalid query: SELECT 
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
ERROR - 2021-11-15 22:13:06 --> Severity: Error --> Call to a member function result_array() on boolean C:\xampp\htdocs\hy\hyvesports\application\libraries\Datatable.php 49
ERROR - 2021-11-15 22:13:08 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near 'LIMIT  OFFSET' at line 11 - Invalid query: SELECT 
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
ERROR - 2021-11-15 22:13:08 --> Severity: Error --> Call to a member function result_array() on boolean C:\xampp\htdocs\hy\hyvesports\application\libraries\Datatable.php 49
ERROR - 2021-11-15 22:13:10 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near 'LIMIT  OFFSET' at line 11 - Invalid query: SELECT 
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
ERROR - 2021-11-15 22:13:10 --> Severity: Error --> Call to a member function result_array() on boolean C:\xampp\htdocs\hy\hyvesports\application\libraries\Datatable.php 49
ERROR - 2021-11-15 22:14:21 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-15 22:14:22 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-15 22:14:22 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-15 22:14:22 --> 404 Page Not Found: Public/css
ERROR - 2021-11-15 22:14:41 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-15 22:14:41 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-15 22:14:42 --> 404 Page Not Found: Public/css
ERROR - 2021-11-15 22:14:42 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-15 22:17:10 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-15 22:17:11 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-15 22:17:11 --> 404 Page Not Found: Public/css
ERROR - 2021-11-15 22:17:11 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-15 22:17:15 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near 'LIMIT  OFFSET' at line 11 - Invalid query: SELECT 
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
ERROR - 2021-11-15 22:17:15 --> Severity: Error --> Call to a member function result_array() on boolean C:\xampp\htdocs\hy\hyvesports\application\libraries\Datatable.php 49
ERROR - 2021-11-15 22:17:19 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near 'LIMIT  OFFSET' at line 11 - Invalid query: SELECT 
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
ERROR - 2021-11-15 22:17:19 --> Severity: Error --> Call to a member function result_array() on boolean C:\xampp\htdocs\hy\hyvesports\application\libraries\Datatable.php 49
ERROR - 2021-11-15 22:17:29 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-15 22:17:30 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-15 22:17:30 --> 404 Page Not Found: Public/css
ERROR - 2021-11-15 22:17:30 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-15 22:19:00 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-15 22:19:00 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near 'LIMIT  OFFSET' at line 11 - Invalid query: SELECT 
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
ERROR - 2021-11-15 22:19:00 --> Severity: Error --> Call to a member function result_array() on boolean C:\xampp\htdocs\hy\hyvesports\application\libraries\Datatable.php 49
ERROR - 2021-11-15 22:19:00 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-15 22:19:00 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-15 22:19:00 --> 404 Page Not Found: Public/css
ERROR - 2021-11-15 22:19:25 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-15 22:19:25 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-15 22:19:25 --> 404 Page Not Found: Public/css
ERROR - 2021-11-15 22:19:26 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-15 22:19:38 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-15 22:19:39 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-15 22:19:39 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-15 22:19:39 --> 404 Page Not Found: Public/css
ERROR - 2021-11-15 22:24:36 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-15 22:24:37 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-15 22:24:37 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-15 22:24:37 --> 404 Page Not Found: Public/css
ERROR - 2021-11-15 22:24:40 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near 'LIMIT  OFFSET' at line 11 - Invalid query: SELECT 
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
ERROR - 2021-11-15 22:24:40 --> Severity: Error --> Call to a member function result_array() on boolean C:\xampp\htdocs\hy\hyvesports\application\libraries\Datatable.php 49
ERROR - 2021-11-15 22:57:29 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-15 22:57:30 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-15 22:57:30 --> 404 Page Not Found: Public/css
ERROR - 2021-11-15 22:57:30 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-15 22:57:34 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near 'LIMIT  OFFSET' at line 11 - Invalid query: SELECT 
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
ERROR - 2021-11-15 22:57:34 --> Severity: Error --> Call to a member function result_array() on boolean C:\xampp\htdocs\hy\hyvesports\application\libraries\Datatable.php 49
ERROR - 2021-11-15 22:59:33 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-15 22:59:34 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-15 22:59:34 --> 404 Page Not Found: Public/css
ERROR - 2021-11-15 22:59:34 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-15 22:59:53 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-15 22:59:54 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-15 22:59:54 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-15 22:59:54 --> 404 Page Not Found: Public/css
ERROR - 2021-11-15 22:59:59 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near 'LIMIT  OFFSET' at line 11 - Invalid query: SELECT 
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
ERROR - 2021-11-15 22:59:59 --> Severity: Error --> Call to a member function result_array() on boolean C:\xampp\htdocs\hy\hyvesports\application\libraries\Datatable.php 49
ERROR - 2021-11-15 23:01:39 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-15 23:01:40 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-15 23:01:40 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-15 23:01:41 --> 404 Page Not Found: Public/css
ERROR - 2021-11-15 23:03:57 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near 'LIMIT  OFFSET' at line 11 - Invalid query: SELECT 
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
ERROR - 2021-11-15 23:03:57 --> Severity: Error --> Call to a member function result_array() on boolean C:\xampp\htdocs\hy\hyvesports\application\libraries\Datatable.php 49
ERROR - 2021-11-15 23:05:01 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near 'LIMIT  OFFSET' at line 11 - Invalid query: SELECT 
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
ERROR - 2021-11-15 23:05:01 --> Severity: Error --> Call to a member function result_array() on boolean C:\xampp\htdocs\hy\hyvesports\application\libraries\Datatable.php 49
ERROR - 2021-11-15 23:05:02 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near 'LIMIT  OFFSET' at line 11 - Invalid query: SELECT 
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
ERROR - 2021-11-15 23:05:02 --> Severity: Error --> Call to a member function result_array() on boolean C:\xampp\htdocs\hy\hyvesports\application\libraries\Datatable.php 49
ERROR - 2021-11-15 23:05:54 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near 'LIMIT  OFFSET' at line 11 - Invalid query: SELECT 
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
ERROR - 2021-11-15 23:05:54 --> Severity: Error --> Call to a member function result_array() on boolean C:\xampp\htdocs\hy\hyvesports\application\libraries\Datatable.php 49
ERROR - 2021-11-15 23:05:58 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-15 23:05:58 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-15 23:05:58 --> 404 Page Not Found: Public/css
ERROR - 2021-11-15 23:05:58 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-15 23:06:20 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-15 23:06:21 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-15 23:06:21 --> 404 Page Not Found: Public/css
ERROR - 2021-11-15 23:06:21 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-15 23:06:25 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near 'LIMIT  OFFSET' at line 11 - Invalid query: SELECT 
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
ERROR - 2021-11-15 23:06:25 --> Severity: Error --> Call to a member function result_array() on boolean C:\xampp\htdocs\hy\hyvesports\application\libraries\Datatable.php 49
ERROR - 2021-11-15 23:06:28 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near 'LIMIT  OFFSET' at line 11 - Invalid query: SELECT 
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
ERROR - 2021-11-15 23:06:28 --> Severity: Error --> Call to a member function result_array() on boolean C:\xampp\htdocs\hy\hyvesports\application\libraries\Datatable.php 49
ERROR - 2021-11-15 23:06:46 --> 404 Page Not Found: Public/css
ERROR - 2021-11-15 23:06:46 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-15 23:06:46 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-15 23:06:47 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-15 23:07:03 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-15 23:07:04 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-15 23:07:04 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-15 23:07:04 --> 404 Page Not Found: Public/css
ERROR - 2021-11-15 23:35:23 --> 404 Page Not Found: Staff/SpryAssets
ERROR - 2021-11-15 23:35:23 --> 404 Page Not Found: Staff/SpryAssets
ERROR - 2021-11-15 23:35:25 --> 404 Page Not Found: Staff/SpryAssets
ERROR - 2021-11-15 23:35:25 --> 404 Page Not Found: Staff/SpryAssets
ERROR - 2021-11-15 23:35:54 --> 404 Page Not Found: Staff/SpryAssets
ERROR - 2021-11-15 23:35:54 --> 404 Page Not Found: Staff/SpryAssets
ERROR - 2021-11-15 23:35:54 --> 404 Page Not Found: Staff/SpryAssets
ERROR - 2021-11-15 23:35:54 --> 404 Page Not Found: Staff/SpryAssets
ERROR - 2021-11-15 23:48:09 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near 'desc LIMIT 10 OFFSET 0' at line 11 - Invalid query: SELECT 
				SH.*,
				SHD.department_schedule_date,
				SHD.scheduled_order_info,
				SHD.schedule_department_id,
				SHD.order_is_approved,
				SHD.is_re_scheduled,
				WO.wo_date_time,WO.lead_id,CONCAT(SM.staff_code,"-",SM.staff_name) as sales_handler1,SM.staff_name as sales_handler,
				WO.orderform_type_id,WO.orderform_number,PO.production_unit_name,WO.wo_product_info,PM.priority_color_code,PM.priority_name
			FROM
				sh_schedule_departments AS SHD  LEFT JOIN sh_schedules  as SH on  SHD.schedule_id=SH.schedule_id LEFT JOIN wo_work_orders as WO on WO.order_id=SH.order_id LEFT JOIN staff_master as SM on SM.staff_id=WO.wo_owner_id AND WO.lead_id!=0 LEFT JOIN pr_production_units as PO on PO.production_unit_id=SHD.unit_id LEFT JOIN priority_master as PM on PM.priority_id=WO.wo_work_priority_id  WHERE ( FIND_IN_SET(4,SHD.department_ids) AND SHD.unit_id IN(0,1,2,3)  ) ORDER BY  desc LIMIT 10 OFFSET 0 
ERROR - 2021-11-15 23:48:09 --> Severity: Error --> Call to a member function result_array() on boolean C:\xampp\htdocs\hy\hyvesports\application\libraries\Datatable.php 49
ERROR - 2021-11-15 23:48:35 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near 'desc LIMIT 10 OFFSET 0' at line 11 - Invalid query: SELECT 
				SH.*,
				SHD.department_schedule_date,
				SHD.scheduled_order_info,
				SHD.schedule_department_id,
				SHD.order_is_approved,
				SHD.is_re_scheduled,
				WO.wo_date_time,WO.lead_id,CONCAT(SM.staff_code,"-",SM.staff_name) as sales_handler1,SM.staff_name as sales_handler,
				WO.orderform_type_id,WO.orderform_number,PO.production_unit_name,WO.wo_product_info,PM.priority_color_code,PM.priority_name
			FROM
				sh_schedule_departments AS SHD  LEFT JOIN sh_schedules  as SH on  SHD.schedule_id=SH.schedule_id LEFT JOIN wo_work_orders as WO on WO.order_id=SH.order_id LEFT JOIN staff_master as SM on SM.staff_id=WO.wo_owner_id AND WO.lead_id!=0 LEFT JOIN pr_production_units as PO on PO.production_unit_id=SHD.unit_id LEFT JOIN priority_master as PM on PM.priority_id=WO.wo_work_priority_id  WHERE ( FIND_IN_SET(4,SHD.department_ids) AND SHD.unit_id IN(0,1,2,3)  ) ORDER BY  desc LIMIT 10 OFFSET 0 
ERROR - 2021-11-15 23:48:35 --> Severity: Error --> Call to a member function result_array() on boolean C:\xampp\htdocs\hy\hyvesports\application\libraries\Datatable.php 49
ERROR - 2021-11-15 23:48:40 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-15 23:48:40 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-15 23:48:40 --> 404 Page Not Found: Public/css
ERROR - 2021-11-15 23:48:40 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-15 23:48:42 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near 'desc LIMIT 10 OFFSET 0' at line 11 - Invalid query: SELECT 
				SH.*,
				SHD.department_schedule_date,
				SHD.scheduled_order_info,
				SHD.schedule_department_id,
				SHD.order_is_approved,
				SHD.is_re_scheduled,
				WO.wo_date_time,WO.lead_id,CONCAT(SM.staff_code,"-",SM.staff_name) as sales_handler1,SM.staff_name as sales_handler,
				WO.orderform_type_id,WO.orderform_number,PO.production_unit_name,WO.wo_product_info,PM.priority_color_code,PM.priority_name
			FROM
				sh_schedule_departments AS SHD  LEFT JOIN sh_schedules  as SH on  SHD.schedule_id=SH.schedule_id LEFT JOIN wo_work_orders as WO on WO.order_id=SH.order_id LEFT JOIN staff_master as SM on SM.staff_id=WO.wo_owner_id AND WO.lead_id!=0 LEFT JOIN pr_production_units as PO on PO.production_unit_id=SHD.unit_id LEFT JOIN priority_master as PM on PM.priority_id=WO.wo_work_priority_id  WHERE ( FIND_IN_SET(4,SHD.department_ids) AND SHD.unit_id IN(0,1,2,3)  ) ORDER BY  desc LIMIT 10 OFFSET 0 
ERROR - 2021-11-15 23:48:42 --> Severity: Error --> Call to a member function result_array() on boolean C:\xampp\htdocs\hy\hyvesports\application\libraries\Datatable.php 49
ERROR - 2021-11-15 23:48:50 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-15 23:48:51 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-15 23:48:51 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-15 23:48:51 --> 404 Page Not Found: Public/css
ERROR - 2021-11-15 23:48:51 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near 'desc LIMIT 10 OFFSET 0' at line 11 - Invalid query: SELECT 
				SH.*,
				SHD.department_schedule_date,
				SHD.scheduled_order_info,
				SHD.schedule_department_id,
				SHD.order_is_approved,
				SHD.is_re_scheduled,
				WO.wo_date_time,WO.lead_id,CONCAT(SM.staff_code,"-",SM.staff_name) as sales_handler1,SM.staff_name as sales_handler,
				WO.orderform_type_id,WO.orderform_number,PO.production_unit_name,WO.wo_product_info,PM.priority_color_code,PM.priority_name
			FROM
				sh_schedule_departments AS SHD  LEFT JOIN sh_schedules  as SH on  SHD.schedule_id=SH.schedule_id LEFT JOIN wo_work_orders as WO on WO.order_id=SH.order_id LEFT JOIN staff_master as SM on SM.staff_id=WO.wo_owner_id AND WO.lead_id!=0 LEFT JOIN pr_production_units as PO on PO.production_unit_id=SHD.unit_id LEFT JOIN priority_master as PM on PM.priority_id=WO.wo_work_priority_id  WHERE ( FIND_IN_SET(4,SHD.department_ids) AND SHD.unit_id IN(0,1,2,3)  ) ORDER BY  desc LIMIT 10 OFFSET 0 
ERROR - 2021-11-15 23:48:51 --> Severity: Error --> Call to a member function result_array() on boolean C:\xampp\htdocs\hy\hyvesports\application\libraries\Datatable.php 49
ERROR - 2021-11-15 23:49:26 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-15 23:49:27 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-15 23:49:27 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-15 23:49:27 --> 404 Page Not Found: Public/css
ERROR - 2021-11-15 23:49:27 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near 'asc LIMIT 10 OFFSET 0' at line 11 - Invalid query: SELECT 
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
ERROR - 2021-11-15 23:49:27 --> Severity: Error --> Call to a member function result_array() on boolean C:\xampp\htdocs\hy\hyvesports\application\libraries\Datatable.php 49
ERROR - 2021-11-15 23:51:01 --> 404 Page Not Found: Staff/SpryAssets
ERROR - 2021-11-15 23:51:01 --> 404 Page Not Found: Staff/SpryAssets
ERROR - 2021-11-15 23:51:02 --> 404 Page Not Found: Staff/SpryAssets
ERROR - 2021-11-15 23:51:02 --> 404 Page Not Found: Staff/SpryAssets
ERROR - 2021-11-15 23:53:58 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-15 23:53:58 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-15 23:53:58 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-15 23:53:59 --> 404 Page Not Found: Public/css

<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2021-10-08 10:45:08 --> 404 Page Not Found: Myaccount/images
ERROR - 2021-10-08 10:45:08 --> 404 Page Not Found: Myaccount/images
ERROR - 2021-10-08 10:45:09 --> 404 Page Not Found: Myaccount/images
ERROR - 2021-10-08 10:45:09 --> 404 Page Not Found: Myaccount/images
ERROR - 2021-10-08 10:45:09 --> 404 Page Not Found: Myaccount/images
ERROR - 2021-10-08 10:45:09 --> 404 Page Not Found: Myaccount/images
ERROR - 2021-10-08 10:45:09 --> 404 Page Not Found: Myaccount/images
ERROR - 2021-10-08 10:45:09 --> 404 Page Not Found: Myaccount/images
ERROR - 2021-10-08 10:45:09 --> 404 Page Not Found: Myaccount/images
ERROR - 2021-10-08 10:45:09 --> 404 Page Not Found: Myaccount/images
ERROR - 2021-10-08 10:45:09 --> 404 Page Not Found: Myaccount/images
ERROR - 2021-10-08 10:45:09 --> 404 Page Not Found: Myaccount/images
ERROR - 2021-10-08 10:46:22 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'like '%s%'  )' at line 11 - Invalid query: SELECT 
				SH.*,
				SHD.department_schedule_date,
				SHD.scheduled_order_info,
				SHD.schedule_department_id,
				SHD.order_is_approved,
				SHD.is_re_scheduled,
				WO.wo_date_time,WO.lead_id,CONCAT(SM.staff_code,"-",SM.staff_name) as sales_handler1,SM.staff_name as sales_handler,
				WO.orderform_type_id,WO.orderform_number,PO.production_unit_name,WO.wo_product_info,PM.priority_color_code,PM.priority_name
			FROM
				sh_schedule_departments AS SHD  LEFT JOIN sh_schedules  as SH on  SHD.schedule_id=SH.schedule_id LEFT JOIN wo_work_orders as WO on WO.order_id=SH.order_id LEFT JOIN staff_master as SM on SM.staff_id=WO.wo_owner_id AND WO.lead_id!=0 LEFT JOIN pr_production_units as PO on PO.production_unit_id=SHD.unit_id LEFT JOIN priority_master as PM on PM.priority_id=WO.wo_work_priority_id  WHERE ( FIND_IN_SET(4,SHD.department_ids) AND SHD.unit_id IN(0,1,2,3) AND SHD.department_schedule_date<now() )AND (  SHD.department_schedule_date like '%s%' OR WO.orderform_number like '%s%' OR WO.wo_product_info like '%s%' OR PM.priority_name like '%s%' OR PO.production_unit_name like '%s%' OR WO.wo_product_info like '%s%' OR WO.wo_product_info like '%s%' OR  like '%s%'  ) 
ERROR - 2021-10-08 10:46:45 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'like '%s%'  )' at line 11 - Invalid query: SELECT 
				SH.*,
				SHD.department_schedule_date,
				SHD.scheduled_order_info,
				SHD.schedule_department_id,
				SHD.order_is_approved,
				SHD.is_re_scheduled,
				WO.wo_date_time,WO.lead_id,CONCAT(SM.staff_code,"-",SM.staff_name) as sales_handler1,SM.staff_name as sales_handler,
				WO.orderform_type_id,WO.orderform_number,PO.production_unit_name,WO.wo_product_info,PM.priority_color_code,PM.priority_name
			FROM
				sh_schedule_departments AS SHD  LEFT JOIN sh_schedules  as SH on  SHD.schedule_id=SH.schedule_id LEFT JOIN wo_work_orders as WO on WO.order_id=SH.order_id LEFT JOIN staff_master as SM on SM.staff_id=WO.wo_owner_id AND WO.lead_id!=0 LEFT JOIN pr_production_units as PO on PO.production_unit_id=SHD.unit_id LEFT JOIN priority_master as PM on PM.priority_id=WO.wo_work_priority_id  WHERE ( FIND_IN_SET(4,SHD.department_ids) AND SHD.unit_id IN(0,1,2,3)  )AND (  SHD.department_schedule_date like '%s%' OR WO.orderform_number like '%s%' OR WO.wo_product_info like '%s%' OR PM.priority_name like '%s%' OR PO.production_unit_name like '%s%' OR WO.wo_product_info like '%s%' OR WO.wo_product_info like '%s%' OR  like '%s%'  ) 
ERROR - 2021-10-08 10:51:17 --> 404 Page Not Found: Myaccount/images
ERROR - 2021-10-08 10:51:17 --> 404 Page Not Found: Myaccount/images
ERROR - 2021-10-08 10:51:17 --> 404 Page Not Found: Myaccount/images
ERROR - 2021-10-08 10:51:17 --> 404 Page Not Found: Myaccount/images
ERROR - 2021-10-08 10:51:17 --> 404 Page Not Found: Myaccount/images
ERROR - 2021-10-08 10:51:17 --> 404 Page Not Found: Myaccount/images
ERROR - 2021-10-08 10:51:17 --> 404 Page Not Found: Myaccount/images
ERROR - 2021-10-08 10:51:17 --> 404 Page Not Found: Myaccount/images
ERROR - 2021-10-08 10:51:17 --> 404 Page Not Found: Myaccount/images
ERROR - 2021-10-08 10:51:17 --> 404 Page Not Found: Myaccount/images
ERROR - 2021-10-08 10:51:17 --> 404 Page Not Found: Myaccount/images
ERROR - 2021-10-08 10:51:17 --> 404 Page Not Found: Myaccount/images
ERROR - 2021-10-08 11:06:48 --> 404 Page Not Found: Myaccount/images
ERROR - 2021-10-08 11:06:48 --> 404 Page Not Found: Myaccount/images
ERROR - 2021-10-08 11:06:48 --> 404 Page Not Found: Myaccount/images
ERROR - 2021-10-08 11:06:48 --> 404 Page Not Found: Myaccount/images
ERROR - 2021-10-08 11:06:48 --> 404 Page Not Found: Myaccount/images
ERROR - 2021-10-08 11:06:48 --> 404 Page Not Found: Myaccount/images
ERROR - 2021-10-08 11:06:48 --> 404 Page Not Found: Myaccount/images
ERROR - 2021-10-08 11:06:48 --> 404 Page Not Found: Myaccount/images
ERROR - 2021-10-08 11:06:48 --> 404 Page Not Found: Myaccount/images
ERROR - 2021-10-08 11:06:48 --> 404 Page Not Found: Myaccount/images
ERROR - 2021-10-08 11:06:48 --> 404 Page Not Found: Myaccount/images
ERROR - 2021-10-08 11:06:48 --> 404 Page Not Found: Myaccount/images
ERROR - 2021-10-08 16:37:17 --> 404 Page Not Found: Myaccount/images
ERROR - 2021-10-08 16:37:17 --> 404 Page Not Found: Myaccount/images
ERROR - 2021-10-08 16:37:17 --> 404 Page Not Found: Myaccount/images
ERROR - 2021-10-08 16:37:17 --> 404 Page Not Found: Myaccount/images
ERROR - 2021-10-08 16:37:17 --> 404 Page Not Found: Myaccount/images
ERROR - 2021-10-08 16:37:17 --> 404 Page Not Found: Myaccount/images
ERROR - 2021-10-08 16:37:17 --> 404 Page Not Found: Myaccount/images
ERROR - 2021-10-08 16:37:17 --> 404 Page Not Found: Myaccount/images
ERROR - 2021-10-08 16:37:17 --> 404 Page Not Found: Myaccount/images
ERROR - 2021-10-08 16:37:17 --> 404 Page Not Found: Myaccount/images
ERROR - 2021-10-08 16:37:17 --> 404 Page Not Found: Myaccount/images
ERROR - 2021-10-08 16:37:17 --> 404 Page Not Found: Myaccount/images
ERROR - 2021-10-08 16:40:46 --> 404 Page Not Found: Myaccount/images
ERROR - 2021-10-08 16:40:46 --> 404 Page Not Found: Myaccount/images
ERROR - 2021-10-08 16:40:46 --> 404 Page Not Found: Myaccount/images
ERROR - 2021-10-08 16:40:46 --> 404 Page Not Found: Myaccount/images
ERROR - 2021-10-08 16:40:46 --> 404 Page Not Found: Myaccount/images
ERROR - 2021-10-08 16:40:46 --> 404 Page Not Found: Myaccount/images
ERROR - 2021-10-08 16:40:46 --> 404 Page Not Found: Myaccount/images
ERROR - 2021-10-08 16:40:47 --> 404 Page Not Found: Myaccount/images
ERROR - 2021-10-08 16:40:47 --> 404 Page Not Found: Myaccount/images
ERROR - 2021-10-08 16:40:47 --> 404 Page Not Found: Myaccount/images
ERROR - 2021-10-08 16:40:47 --> 404 Page Not Found: Myaccount/images
ERROR - 2021-10-08 16:40:47 --> 404 Page Not Found: Myaccount/images
ERROR - 2021-10-08 16:45:46 --> 404 Page Not Found: Myaccount/images
ERROR - 2021-10-08 16:45:46 --> 404 Page Not Found: Myaccount/images
ERROR - 2021-10-08 16:45:46 --> 404 Page Not Found: Myaccount/images
ERROR - 2021-10-08 16:45:46 --> 404 Page Not Found: Myaccount/images
ERROR - 2021-10-08 16:45:46 --> 404 Page Not Found: Myaccount/images
ERROR - 2021-10-08 16:45:46 --> 404 Page Not Found: Myaccount/images
ERROR - 2021-10-08 16:45:46 --> 404 Page Not Found: Myaccount/images
ERROR - 2021-10-08 16:45:46 --> 404 Page Not Found: Myaccount/images
ERROR - 2021-10-08 16:45:46 --> 404 Page Not Found: Myaccount/images
ERROR - 2021-10-08 16:45:46 --> 404 Page Not Found: Myaccount/images
ERROR - 2021-10-08 16:45:46 --> 404 Page Not Found: Myaccount/images
ERROR - 2021-10-08 16:45:46 --> 404 Page Not Found: Myaccount/images

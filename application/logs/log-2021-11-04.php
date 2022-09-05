<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2021-11-04 09:09:42 --> Severity: Notice --> Undefined index: socialmedia /home4/solutiil/public_html/hyvesports/application/controllers/Leads.php 591
ERROR - 2021-11-04 09:39:52 --> Severity: Notice --> Undefined index: socialmedia /home4/solutiil/public_html/hyvesports/application/controllers/Leads.php 591
ERROR - 2021-11-04 09:40:39 --> Severity: Notice --> Undefined index: socialmedia /home4/solutiil/public_html/hyvesports/application/controllers/Leads.php 591
ERROR - 2021-11-04 09:41:35 --> Severity: Notice --> Undefined index: socialmedia /home4/solutiil/public_html/hyvesports/application/controllers/Leads.php 591
ERROR - 2021-11-04 09:42:15 --> Severity: Notice --> Undefined index: socialmedia /home4/solutiil/public_html/hyvesports/application/controllers/Leads.php 591
ERROR - 2021-11-04 10:54:42 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-04 10:54:42 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-04 10:54:42 --> 404 Page Not Found: Public/vendors
ERROR - 2021-11-04 10:54:43 --> 404 Page Not Found: Public/css
ERROR - 2021-11-04 11:51:16 --> Severity: Notice --> Undefined index: socialmedia /home4/solutiil/public_html/hyvesports/application/controllers/Leads.php 591
ERROR - 2021-11-04 11:51:35 --> Severity: Notice --> Undefined index: socialmedia /home4/solutiil/public_html/hyvesports/application/controllers/Leads.php 591
ERROR - 2021-11-04 11:53:32 --> Severity: Notice --> Undefined variable: approved_by /home4/solutiil/public_html/hyvesports/application/controllers/Qc.php 755
ERROR - 2021-11-04 11:53:52 --> Severity: Notice --> Undefined variable: id /home4/solutiil/public_html/hyvesports/application/controllers/Leads.php 178
ERROR - 2021-11-04 11:55:23 --> Severity: Notice --> Undefined variable: id /home4/solutiil/public_html/hyvesports/application/controllers/Leads.php 146
ERROR - 2021-11-04 12:07:26 --> Severity: Notice --> Undefined variable: imgDoc /home4/solutiil/public_html/hyvesports/application/views/orders/schedule.php 55
ERROR - 2021-11-04 12:29:37 --> Severity: Notice --> Undefined index: socialmedia /home4/solutiil/public_html/hyvesports/application/controllers/Leads.php 591
ERROR - 2021-11-04 12:31:27 --> Severity: Notice --> Undefined index: socialmedia /home4/solutiil/public_html/hyvesports/application/controllers/Leads.php 591
ERROR - 2021-11-04 12:33:30 --> Severity: Notice --> Undefined variable: id /home4/solutiil/public_html/hyvesports/application/controllers/Leads.php 178
ERROR - 2021-11-04 12:51:23 --> Severity: Notice --> Undefined index: socialmedia /home4/solutiil/public_html/hyvesports/application/controllers/Leads.php 591
ERROR - 2021-11-04 12:52:21 --> Severity: Notice --> Undefined index: socialmedia /home4/solutiil/public_html/hyvesports/application/controllers/Leads.php 591
ERROR - 2021-11-04 13:25:21 --> Severity: Notice --> Undefined index: socialmedia /home4/solutiil/public_html/hyvesports/application/controllers/Leads.php 591
ERROR - 2021-11-04 14:20:50 --> Severity: Notice --> Undefined variable: customer_shipping_id /home4/solutiil/public_html/hyvesports/application/models/Workorder_model.php 212
ERROR - 2021-11-04 14:20:50 --> Severity: Notice --> Undefined variable: customer_billing_id /home4/solutiil/public_html/hyvesports/application/models/Workorder_model.php 217
ERROR - 2021-11-04 14:21:14 --> Severity: Notice --> Undefined variable: customer_shipping_id /home4/solutiil/public_html/hyvesports/application/models/Workorder_model.php 212
ERROR - 2021-11-04 14:21:14 --> Severity: Notice --> Undefined variable: customer_billing_id /home4/solutiil/public_html/hyvesports/application/models/Workorder_model.php 217
ERROR - 2021-11-04 14:25:06 --> Severity: Notice --> Undefined variable: customer_shipping_id /home4/solutiil/public_html/hyvesports/application/models/Workorder_model.php 212
ERROR - 2021-11-04 14:25:06 --> Severity: Notice --> Undefined variable: customer_billing_id /home4/solutiil/public_html/hyvesports/application/models/Workorder_model.php 217
ERROR - 2021-11-04 16:00:12 --> Severity: Notice --> Undefined index: socialmedia /home4/solutiil/public_html/hyvesports/application/controllers/Leads.php 591
ERROR - 2021-11-04 16:19:26 --> Severity: Notice --> Undefined index: socialmedia /home4/solutiil/public_html/hyvesports/application/controllers/Leads.php 591
ERROR - 2021-11-04 16:35:09 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '%' OR WO.orderform_number like '%n1180'%' OR WO.wo_product_info like '%n1180'%' ' at line 11 - Invalid query: SELECT 
				SH.*,
				SHD.department_schedule_date,
				SHD.scheduled_order_info,
				SHD.schedule_department_id,
				SHD.order_is_approved,
				SHD.is_re_scheduled,
				WO.wo_date_time,WO.lead_id,CONCAT(SM.staff_code,"-",SM.staff_name) as sales_handler1,SM.staff_name as sales_handler,
				WO.orderform_type_id,WO.orderform_number,PO.production_unit_name,WO.wo_product_info,PM.priority_color_code,PM.priority_name
			FROM
				sh_schedule_departments AS SHD  LEFT JOIN sh_schedules  as SH on  SHD.schedule_id=SH.schedule_id LEFT JOIN wo_work_orders as WO on WO.order_id=SH.order_id LEFT JOIN staff_master as SM on SM.staff_id=WO.wo_owner_id AND WO.lead_id!=0 LEFT JOIN pr_production_units as PO on PO.production_unit_id=SHD.unit_id LEFT JOIN priority_master as PM on PM.priority_id=WO.wo_work_priority_id  WHERE ( FIND_IN_SET(4,SHD.department_ids) AND SHD.unit_id IN(0,1,2) AND SHD.department_schedule_date="2021-11-04" )AND (  SHD.department_schedule_date like '%n1180'%' OR WO.orderform_number like '%n1180'%' OR WO.wo_product_info like '%n1180'%' OR PM.priority_name like '%n1180'%' OR SM.staff_name like '%n1180'%' OR WO.wo_product_info like '%n1180'%'  ) 
ERROR - 2021-11-04 16:46:09 --> Severity: Notice --> Undefined variable: id /home4/solutiil/public_html/hyvesports/application/controllers/Leads.php 178
ERROR - 2021-11-04 16:46:23 --> Severity: Notice --> Undefined variable: id /home4/solutiil/public_html/hyvesports/application/controllers/Leads.php 146
ERROR - 2021-11-04 16:53:05 --> Severity: Notice --> Undefined variable: id /home4/solutiil/public_html/hyvesports/application/controllers/Leads.php 178
ERROR - 2021-11-04 16:53:13 --> Severity: Notice --> Undefined variable: id /home4/solutiil/public_html/hyvesports/application/controllers/Leads.php 146
ERROR - 2021-11-04 16:53:24 --> Severity: Notice --> Undefined index: socialmedia /home4/solutiil/public_html/hyvesports/application/controllers/Leads.php 591
ERROR - 2021-11-04 16:53:55 --> Severity: Notice --> Undefined variable: id /home4/solutiil/public_html/hyvesports/application/controllers/Leads.php 178
ERROR - 2021-11-04 16:54:04 --> Severity: Notice --> Undefined variable: id /home4/solutiil/public_html/hyvesports/application/controllers/Leads.php 146
ERROR - 2021-11-04 16:55:08 --> Severity: Notice --> Undefined variable: id /home4/solutiil/public_html/hyvesports/application/controllers/Leads.php 178
ERROR - 2021-11-04 16:55:09 --> Severity: Notice --> Undefined index: wo_tax_id /home4/solutiil/public_html/hyvesports/application/models/Workorder_model.php 353
ERROR - 2021-11-04 16:55:21 --> Severity: Notice --> Undefined variable: id /home4/solutiil/public_html/hyvesports/application/controllers/Leads.php 146
ERROR - 2021-11-04 16:55:27 --> Severity: Notice --> Undefined variable: id /home4/solutiil/public_html/hyvesports/application/controllers/Leads.php 178
ERROR - 2021-11-04 16:55:32 --> Severity: Notice --> Undefined variable: id /home4/solutiil/public_html/hyvesports/application/controllers/Leads.php 146
ERROR - 2021-11-04 16:55:44 --> Severity: Notice --> Undefined variable: id /home4/solutiil/public_html/hyvesports/application/controllers/Leads.php 178
ERROR - 2021-11-04 16:55:58 --> Severity: Notice --> Undefined variable: id /home4/solutiil/public_html/hyvesports/application/controllers/Leads.php 146
ERROR - 2021-11-04 16:56:27 --> Severity: Notice --> Undefined index: socialmedia /home4/solutiil/public_html/hyvesports/application/controllers/Leads.php 591
ERROR - 2021-11-04 16:57:02 --> Severity: Notice --> Undefined variable: id /home4/solutiil/public_html/hyvesports/application/controllers/Leads.php 178
ERROR - 2021-11-04 16:57:12 --> Severity: Notice --> Undefined variable: id /home4/solutiil/public_html/hyvesports/application/controllers/Leads.php 146
ERROR - 2021-11-04 17:00:09 --> Severity: Notice --> Undefined index: socialmedia /home4/solutiil/public_html/hyvesports/application/controllers/Leads.php 591
ERROR - 2021-11-04 17:02:00 --> Severity: Notice --> Undefined index: socialmedia /home4/solutiil/public_html/hyvesports/application/controllers/Leads.php 591
ERROR - 2021-11-04 17:02:04 --> Severity: Notice --> Undefined index: socialmedia /home4/solutiil/public_html/hyvesports/application/controllers/Leads.php 591
ERROR - 2021-11-04 17:02:31 --> Severity: Notice --> Undefined variable: id /home4/solutiil/public_html/hyvesports/application/controllers/Leads.php 178
ERROR - 2021-11-04 17:02:40 --> Severity: Notice --> Undefined variable: id /home4/solutiil/public_html/hyvesports/application/controllers/Leads.php 146
ERROR - 2021-11-04 17:04:35 --> Severity: Notice --> Undefined index: socialmedia /home4/solutiil/public_html/hyvesports/application/controllers/Leads.php 591
ERROR - 2021-11-04 17:04:50 --> Severity: Notice --> Undefined variable: id /home4/solutiil/public_html/hyvesports/application/controllers/Leads.php 178
ERROR - 2021-11-04 17:04:56 --> Severity: Notice --> Undefined variable: id /home4/solutiil/public_html/hyvesports/application/controllers/Leads.php 146
ERROR - 2021-11-04 17:05:49 --> Severity: Notice --> Undefined index: socialmedia /home4/solutiil/public_html/hyvesports/application/controllers/Leads.php 591
ERROR - 2021-11-04 17:06:18 --> Severity: Notice --> Undefined variable: imgDoc /home4/solutiil/public_html/hyvesports/application/views/orders/online_view.php 37
ERROR - 2021-11-04 17:08:14 --> Severity: Notice --> Undefined variable: id /home4/solutiil/public_html/hyvesports/application/controllers/Leads.php 178
ERROR - 2021-11-04 17:08:27 --> Severity: Notice --> Undefined variable: id /home4/solutiil/public_html/hyvesports/application/controllers/Leads.php 146
ERROR - 2021-11-04 17:08:52 --> Severity: Notice --> Undefined index: socialmedia /home4/solutiil/public_html/hyvesports/application/controllers/Leads.php 591
ERROR - 2021-11-04 17:08:57 --> Severity: Notice --> Undefined variable: imgDoc /home4/solutiil/public_html/hyvesports/application/views/orders/online_view.php 37
ERROR - 2021-11-04 17:09:00 --> Severity: Notice --> Undefined variable: id /home4/solutiil/public_html/hyvesports/application/controllers/Leads.php 178
ERROR - 2021-11-04 17:09:09 --> Severity: Notice --> Undefined variable: id /home4/solutiil/public_html/hyvesports/application/controllers/Leads.php 146
ERROR - 2021-11-04 17:11:14 --> Severity: Notice --> Undefined variable: id /home4/solutiil/public_html/hyvesports/application/controllers/Leads.php 178
ERROR - 2021-11-04 17:11:20 --> Severity: Notice --> Undefined variable: id /home4/solutiil/public_html/hyvesports/application/controllers/Leads.php 146
ERROR - 2021-11-04 17:16:43 --> Severity: Notice --> Undefined variable: id /home4/solutiil/public_html/hyvesports/application/controllers/Leads.php 178
ERROR - 2021-11-04 17:16:50 --> Severity: Notice --> Undefined variable: id /home4/solutiil/public_html/hyvesports/application/controllers/Leads.php 146
ERROR - 2021-11-04 17:22:26 --> Severity: Notice --> Undefined index: socialmedia /home4/solutiil/public_html/hyvesports/application/controllers/Leads.php 591
ERROR - 2021-11-04 17:23:39 --> Severity: Notice --> Undefined variable: id /home4/solutiil/public_html/hyvesports/application/controllers/Leads.php 178
ERROR - 2021-11-04 17:23:57 --> Severity: Notice --> Undefined variable: id /home4/solutiil/public_html/hyvesports/application/controllers/Leads.php 146
ERROR - 2021-11-04 17:24:31 --> Severity: Notice --> Undefined index: socialmedia /home4/solutiil/public_html/hyvesports/application/controllers/Leads.php 591
ERROR - 2021-11-04 17:40:40 --> Severity: Notice --> Undefined index: socialmedia /home4/solutiil/public_html/hyvesports/application/controllers/Leads.php 591
ERROR - 2021-11-04 17:45:36 --> Severity: Notice --> Undefined variable: id /home4/solutiil/public_html/hyvesports/application/controllers/Leads.php 178
ERROR - 2021-11-04 17:45:45 --> Severity: Notice --> Undefined variable: id /home4/solutiil/public_html/hyvesports/application/controllers/Leads.php 146
ERROR - 2021-11-04 17:47:26 --> Severity: Notice --> Undefined index: socialmedia /home4/solutiil/public_html/hyvesports/application/controllers/Leads.php 591
ERROR - 2021-11-04 17:55:26 --> Severity: Notice --> Undefined index: socialmedia /home4/solutiil/public_html/hyvesports/application/controllers/Leads.php 591
ERROR - 2021-11-04 17:56:46 --> Severity: Notice --> Undefined index: socialmedia /home4/solutiil/public_html/hyvesports/application/controllers/Leads.php 591
ERROR - 2021-11-04 17:57:13 --> Severity: Notice --> Undefined variable: id /home4/solutiil/public_html/hyvesports/application/controllers/Leads.php 178
ERROR - 2021-11-04 17:57:22 --> Severity: Notice --> Undefined variable: id /home4/solutiil/public_html/hyvesports/application/controllers/Leads.php 146
ERROR - 2021-11-04 17:59:55 --> Severity: Notice --> Undefined index: socialmedia /home4/solutiil/public_html/hyvesports/application/controllers/Leads.php 591
ERROR - 2021-11-04 18:00:44 --> Severity: Notice --> Undefined index: socialmedia /home4/solutiil/public_html/hyvesports/application/controllers/Leads.php 591
ERROR - 2021-11-04 18:04:31 --> Severity: Notice --> Undefined index: socialmedia /home4/solutiil/public_html/hyvesports/application/controllers/Leads.php 591
ERROR - 2021-11-04 18:07:02 --> Severity: Notice --> Undefined index: socialmedia /home4/solutiil/public_html/hyvesports/application/controllers/Leads.php 591
ERROR - 2021-11-04 18:09:11 --> Severity: Notice --> Undefined variable: id /home4/solutiil/public_html/hyvesports/application/controllers/Leads.php 178
ERROR - 2021-11-04 18:09:16 --> Severity: Notice --> Undefined variable: id /home4/solutiil/public_html/hyvesports/application/controllers/Leads.php 146
ERROR - 2021-11-04 18:14:11 --> Severity: Notice --> Undefined index: socialmedia /home4/solutiil/public_html/hyvesports/application/controllers/Leads.php 591
ERROR - 2021-11-04 19:37:01 --> Severity: Notice --> Undefined index: socialmedia /home4/solutiil/public_html/hyvesports/application/controllers/Leads.php 591

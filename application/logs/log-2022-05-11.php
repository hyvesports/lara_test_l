<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2022-05-11 02:27:12 --> 404 Page Not Found: Owa/auth
ERROR - 2022-05-11 02:27:21 --> 404 Page Not Found: Faviconico/index
ERROR - 2022-05-11 06:33:22 --> 404 Page Not Found: Dns-query/index
ERROR - 2022-05-11 06:33:22 --> 404 Page Not Found: Dns-query/index
ERROR - 2022-05-11 06:33:23 --> 404 Page Not Found: Dns-query/index
ERROR - 2022-05-11 06:33:23 --> 404 Page Not Found: Dns-query/index
ERROR - 2022-05-11 06:33:23 --> 404 Page Not Found: Query/index
ERROR - 2022-05-11 06:33:23 --> 404 Page Not Found: Query/index
ERROR - 2022-05-11 06:33:24 --> 404 Page Not Found: Query/index
ERROR - 2022-05-11 06:33:24 --> 404 Page Not Found: Query/index
ERROR - 2022-05-11 06:33:24 --> 404 Page Not Found: Resolve/index
ERROR - 2022-05-11 06:33:24 --> 404 Page Not Found: Resolve/index
ERROR - 2022-05-11 06:33:24 --> 404 Page Not Found: Resolve/index
ERROR - 2022-05-11 06:33:25 --> 404 Page Not Found: Resolve/index
ERROR - 2022-05-11 06:59:46 --> 404 Page Not Found: Owa/auth
ERROR - 2022-05-11 07:41:35 --> 404 Page Not Found: Faviconico/index
ERROR - 2022-05-11 08:28:06 --> 404 Page Not Found: Faviconico/index
ERROR - 2022-05-11 08:28:52 --> 404 Page Not Found: Faviconico/index
ERROR - 2022-05-11 08:28:52 --> 404 Page Not Found: Faviconico/index
ERROR - 2022-05-11 08:30:42 --> 404 Page Not Found: Faviconico/index
ERROR - 2022-05-11 08:32:15 --> 404 Page Not Found: Faviconico/index
ERROR - 2022-05-11 08:34:36 --> 404 Page Not Found: Images/auth
ERROR - 2022-05-11 08:34:49 --> 404 Page Not Found: Faviconico/index
ERROR - 2022-05-11 08:39:24 --> 404 Page Not Found: Faviconico/index
ERROR - 2022-05-11 08:39:54 --> 404 Page Not Found: Auth/hses.hyvesports.com
ERROR - 2022-05-11 08:39:55 --> 404 Page Not Found: Faviconico/index
ERROR - 2022-05-11 08:41:05 --> 404 Page Not Found: Faviconico/index
ERROR - 2022-05-11 08:41:45 --> 404 Page Not Found: Faviconico/index
ERROR - 2022-05-11 08:42:13 --> 404 Page Not Found: Faviconico/index
ERROR - 2022-05-11 08:42:16 --> 404 Page Not Found: Faviconico/index
ERROR - 2022-05-11 08:43:39 --> 404 Page Not Found: Faviconico/index
ERROR - 2022-05-11 08:46:58 --> 404 Page Not Found: Faviconico/index
ERROR - 2022-05-11 08:46:59 --> 404 Page Not Found: Images/auth
ERROR - 2022-05-11 08:49:42 --> 404 Page Not Found: Faviconico/index
ERROR - 2022-05-11 08:50:14 --> 404 Page Not Found: Faviconico/index
ERROR - 2022-05-11 08:57:40 --> 404 Page Not Found: Faviconico/index
ERROR - 2022-05-11 08:58:09 --> 404 Page Not Found: Faviconico/index
ERROR - 2022-05-11 09:13:29 --> 404 Page Not Found: Faviconico/index
ERROR - 2022-05-11 09:17:00 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near ''  )' at line 3 - Invalid query: SELECT 	
				wo_work_orders.*,customer_master.customer_name,customer_master.customer_email,customer_master.customer_mobile_no,	staff_master.staff_code,staff_master.staff_name,wo_status.wo_status_title,wo_status.style_class,PM.priority_name,PM.priority_color_code,sh_schedules.schedule_id
			FROM wo_work_orders  LEFT JOIN customer_master ON customer_master.customer_id = wo_work_orders.wo_client_id LEFT JOIN staff_master ON staff_master.staff_id = wo_work_orders.wo_owner_id LEFT JOIN wo_status ON wo_status.wo_status_id = wo_work_orders.wo_status_id LEFT JOIN priority_master as PM on PM.priority_id=wo_work_orders.wo_work_priority_id LEFT JOIN sh_schedules ON sh_schedules.order_id=wo_work_orders.order_id AND sh_schedules.schedule_is_completed=1 AND sh_schedules.schedule_status=1  WHERE ( wo_work_orders.orderform_type_id='1' AND wo_work_orders.order_id != 0 AND wo_work_orders.submited_to_production='yes' AND wo_work_orders.wo_row_status=1 )AND (  orderform_number like ''%' OR wo_customer_name like ''%' OR wo_staff_name like ''%' OR wo_date_time like ''%' OR wo_dispatch_date like ''%'  ) 
ERROR - 2022-05-11 09:17:00 --> Severity: Error --> Call to a member function num_rows() on a non-object /home/hyveerp/public_html/application/libraries/Datatable.php 41
ERROR - 2022-05-11 09:17:01 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near 'F%' OR wo_customer_name like ''F%' OR wo_staff_name like ''F%' OR wo_date_tim...' at line 3 - Invalid query: SELECT 	
				wo_work_orders.*,customer_master.customer_name,customer_master.customer_email,customer_master.customer_mobile_no,	staff_master.staff_code,staff_master.staff_name,wo_status.wo_status_title,wo_status.style_class,PM.priority_name,PM.priority_color_code,sh_schedules.schedule_id
			FROM wo_work_orders  LEFT JOIN customer_master ON customer_master.customer_id = wo_work_orders.wo_client_id LEFT JOIN staff_master ON staff_master.staff_id = wo_work_orders.wo_owner_id LEFT JOIN wo_status ON wo_status.wo_status_id = wo_work_orders.wo_status_id LEFT JOIN priority_master as PM on PM.priority_id=wo_work_orders.wo_work_priority_id LEFT JOIN sh_schedules ON sh_schedules.order_id=wo_work_orders.order_id AND sh_schedules.schedule_is_completed=1 AND sh_schedules.schedule_status=1  WHERE ( wo_work_orders.orderform_type_id='1' AND wo_work_orders.order_id != 0 AND wo_work_orders.submited_to_production='yes' AND wo_work_orders.wo_row_status=1 )AND (  orderform_number like ''F%' OR wo_customer_name like ''F%' OR wo_staff_name like ''F%' OR wo_date_time like ''F%' OR wo_dispatch_date like ''F%'  ) 
ERROR - 2022-05-11 09:17:01 --> Severity: Error --> Call to a member function num_rows() on a non-object /home/hyveerp/public_html/application/libraries/Datatable.php 41
ERROR - 2022-05-11 09:17:02 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near 'F2%' OR wo_customer_name like ''F2%' OR wo_staff_name like ''F2%' OR wo_date_...' at line 3 - Invalid query: SELECT 	
				wo_work_orders.*,customer_master.customer_name,customer_master.customer_email,customer_master.customer_mobile_no,	staff_master.staff_code,staff_master.staff_name,wo_status.wo_status_title,wo_status.style_class,PM.priority_name,PM.priority_color_code,sh_schedules.schedule_id
			FROM wo_work_orders  LEFT JOIN customer_master ON customer_master.customer_id = wo_work_orders.wo_client_id LEFT JOIN staff_master ON staff_master.staff_id = wo_work_orders.wo_owner_id LEFT JOIN wo_status ON wo_status.wo_status_id = wo_work_orders.wo_status_id LEFT JOIN priority_master as PM on PM.priority_id=wo_work_orders.wo_work_priority_id LEFT JOIN sh_schedules ON sh_schedules.order_id=wo_work_orders.order_id AND sh_schedules.schedule_is_completed=1 AND sh_schedules.schedule_status=1  WHERE ( wo_work_orders.orderform_type_id='1' AND wo_work_orders.order_id != 0 AND wo_work_orders.submited_to_production='yes' AND wo_work_orders.wo_row_status=1 )AND (  orderform_number like ''F2%' OR wo_customer_name like ''F2%' OR wo_staff_name like ''F2%' OR wo_date_time like ''F2%' OR wo_dispatch_date like ''F2%'  ) 
ERROR - 2022-05-11 09:17:02 --> Severity: Error --> Call to a member function num_rows() on a non-object /home/hyveerp/public_html/application/libraries/Datatable.php 41
ERROR - 2022-05-11 09:17:06 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near 'F24%' OR wo_customer_name like ''F24%' OR wo_staff_name like ''F24%' OR wo_da...' at line 3 - Invalid query: SELECT 	
				wo_work_orders.*,customer_master.customer_name,customer_master.customer_email,customer_master.customer_mobile_no,	staff_master.staff_code,staff_master.staff_name,wo_status.wo_status_title,wo_status.style_class,PM.priority_name,PM.priority_color_code,sh_schedules.schedule_id
			FROM wo_work_orders  LEFT JOIN customer_master ON customer_master.customer_id = wo_work_orders.wo_client_id LEFT JOIN staff_master ON staff_master.staff_id = wo_work_orders.wo_owner_id LEFT JOIN wo_status ON wo_status.wo_status_id = wo_work_orders.wo_status_id LEFT JOIN priority_master as PM on PM.priority_id=wo_work_orders.wo_work_priority_id LEFT JOIN sh_schedules ON sh_schedules.order_id=wo_work_orders.order_id AND sh_schedules.schedule_is_completed=1 AND sh_schedules.schedule_status=1  WHERE ( wo_work_orders.orderform_type_id='1' AND wo_work_orders.order_id != 0 AND wo_work_orders.submited_to_production='yes' AND wo_work_orders.wo_row_status=1 )AND (  orderform_number like ''F24%' OR wo_customer_name like ''F24%' OR wo_staff_name like ''F24%' OR wo_date_time like ''F24%' OR wo_dispatch_date like ''F24%'  ) 
ERROR - 2022-05-11 09:17:06 --> Severity: Error --> Call to a member function num_rows() on a non-object /home/hyveerp/public_html/application/libraries/Datatable.php 41
ERROR - 2022-05-11 09:17:07 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near 'F243%' OR wo_customer_name like ''F243%' OR wo_staff_name like ''F243%' OR wo...' at line 3 - Invalid query: SELECT 	
				wo_work_orders.*,customer_master.customer_name,customer_master.customer_email,customer_master.customer_mobile_no,	staff_master.staff_code,staff_master.staff_name,wo_status.wo_status_title,wo_status.style_class,PM.priority_name,PM.priority_color_code,sh_schedules.schedule_id
			FROM wo_work_orders  LEFT JOIN customer_master ON customer_master.customer_id = wo_work_orders.wo_client_id LEFT JOIN staff_master ON staff_master.staff_id = wo_work_orders.wo_owner_id LEFT JOIN wo_status ON wo_status.wo_status_id = wo_work_orders.wo_status_id LEFT JOIN priority_master as PM on PM.priority_id=wo_work_orders.wo_work_priority_id LEFT JOIN sh_schedules ON sh_schedules.order_id=wo_work_orders.order_id AND sh_schedules.schedule_is_completed=1 AND sh_schedules.schedule_status=1  WHERE ( wo_work_orders.orderform_type_id='1' AND wo_work_orders.order_id != 0 AND wo_work_orders.submited_to_production='yes' AND wo_work_orders.wo_row_status=1 )AND (  orderform_number like ''F243%' OR wo_customer_name like ''F243%' OR wo_staff_name like ''F243%' OR wo_date_time like ''F243%' OR wo_dispatch_date like ''F243%'  ) 
ERROR - 2022-05-11 09:17:07 --> Severity: Error --> Call to a member function num_rows() on a non-object /home/hyveerp/public_html/application/libraries/Datatable.php 41
ERROR - 2022-05-11 09:17:14 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near 'F2438%' OR wo_customer_name like ''F2438%' OR wo_staff_name like ''F2438%' OR...' at line 3 - Invalid query: SELECT 	
				wo_work_orders.*,customer_master.customer_name,customer_master.customer_email,customer_master.customer_mobile_no,	staff_master.staff_code,staff_master.staff_name,wo_status.wo_status_title,wo_status.style_class,PM.priority_name,PM.priority_color_code,sh_schedules.schedule_id
			FROM wo_work_orders  LEFT JOIN customer_master ON customer_master.customer_id = wo_work_orders.wo_client_id LEFT JOIN staff_master ON staff_master.staff_id = wo_work_orders.wo_owner_id LEFT JOIN wo_status ON wo_status.wo_status_id = wo_work_orders.wo_status_id LEFT JOIN priority_master as PM on PM.priority_id=wo_work_orders.wo_work_priority_id LEFT JOIN sh_schedules ON sh_schedules.order_id=wo_work_orders.order_id AND sh_schedules.schedule_is_completed=1 AND sh_schedules.schedule_status=1  WHERE ( wo_work_orders.orderform_type_id='1' AND wo_work_orders.order_id != 0 AND wo_work_orders.submited_to_production='yes' AND wo_work_orders.wo_row_status=1 )AND (  orderform_number like ''F2438%' OR wo_customer_name like ''F2438%' OR wo_staff_name like ''F2438%' OR wo_date_time like ''F2438%' OR wo_dispatch_date like ''F2438%'  ) 
ERROR - 2022-05-11 09:17:14 --> Severity: Error --> Call to a member function num_rows() on a non-object /home/hyveerp/public_html/application/libraries/Datatable.php 41
ERROR - 2022-05-11 09:17:57 --> 404 Page Not Found: Faviconico/index
ERROR - 2022-05-11 09:21:11 --> 404 Page Not Found: Public/vendors
ERROR - 2022-05-11 09:21:11 --> 404 Page Not Found: Public/vendors
ERROR - 2022-05-11 09:21:11 --> 404 Page Not Found: Public/vendors
ERROR - 2022-05-11 09:21:57 --> 404 Page Not Found: Images/auth
ERROR - 2022-05-11 09:22:21 --> 404 Page Not Found: Images/auth
ERROR - 2022-05-11 09:23:01 --> 404 Page Not Found: Images/auth
ERROR - 2022-05-11 09:23:06 --> 404 Page Not Found: Public/vendors
ERROR - 2022-05-11 09:23:06 --> 404 Page Not Found: Public/vendors
ERROR - 2022-05-11 09:23:06 --> 404 Page Not Found: Public/vendors
ERROR - 2022-05-11 09:37:25 --> 404 Page Not Found: Faviconico/index
ERROR - 2022-05-11 09:38:10 --> 404 Page Not Found: ReportServer/index
ERROR - 2022-05-11 09:44:49 --> 404 Page Not Found: Public/vendors
ERROR - 2022-05-11 09:44:49 --> 404 Page Not Found: Public/vendors
ERROR - 2022-05-11 09:44:49 --> 404 Page Not Found: Public/vendors
ERROR - 2022-05-11 09:45:19 --> 404 Page Not Found: Images/auth
ERROR - 2022-05-11 09:45:48 --> 404 Page Not Found: Public/vendors
ERROR - 2022-05-11 09:45:48 --> 404 Page Not Found: Public/vendors
ERROR - 2022-05-11 09:45:48 --> 404 Page Not Found: Public/vendors
ERROR - 2022-05-11 09:46:14 --> 404 Page Not Found: Faviconico/index
ERROR - 2022-05-11 09:46:28 --> 404 Page Not Found: Faviconico/index
ERROR - 2022-05-11 09:49:19 --> 404 Page Not Found: Faviconico/index
ERROR - 2022-05-11 09:49:59 --> 404 Page Not Found: Images/auth
ERROR - 2022-05-11 10:14:08 --> 404 Page Not Found: Faviconico/index
ERROR - 2022-05-11 10:16:30 --> 404 Page Not Found: Login/index
ERROR - 2022-05-11 10:22:56 --> 404 Page Not Found: Faviconico/index
ERROR - 2022-05-11 10:29:15 --> Severity: Warning --> filesize(): stat failed for https://hses.hyvesports.com/uploads/orderform//WhatsApp_Image_2022-04-12_at_1.00.10_PM_(1).jpeg /home/hyveerp/public_html/application/controllers/Attachment.php 80
ERROR - 2022-05-11 10:29:15 --> Severity: Warning --> filesize(): stat failed for https://hses.hyvesports.com/uploads/orderform//WhatsApp_Image_2022-04-12_at_1.00.12_PM_(1).jpeg /home/hyveerp/public_html/application/controllers/Attachment.php 80
ERROR - 2022-05-11 10:33:00 --> Severity: Warning --> filesize(): stat failed for https://hses.hyvesports.com/uploads/orderform//WhatsApp_Image_2022-04-12_at_1.00.10_PM_(1).jpeg /home/hyveerp/public_html/application/controllers/Attachment.php 80
ERROR - 2022-05-11 10:33:00 --> Severity: Warning --> filesize(): stat failed for https://hses.hyvesports.com/uploads/orderform//WhatsApp_Image_2022-04-12_at_1.00.12_PM_(1).jpeg /home/hyveerp/public_html/application/controllers/Attachment.php 80
ERROR - 2022-05-11 10:33:00 --> Severity: Warning --> filesize(): stat failed for https://hses.hyvesports.com/uploads/orderform//Jersey_Order_Form_2nd_Batch_HYVE_V1_UPDATED_(1).xlsx /home/hyveerp/public_html/application/controllers/Attachment.php 58
ERROR - 2022-05-11 10:34:16 --> Severity: Warning --> filesize(): stat failed for https://hses.hyvesports.com/uploads/orderform//WhatsApp_Image_2022-04-12_at_1.00.10_PM_(1).jpeg /home/hyveerp/public_html/application/controllers/Attachment.php 80
ERROR - 2022-05-11 10:34:16 --> Severity: Warning --> filesize(): stat failed for https://hses.hyvesports.com/uploads/orderform//WhatsApp_Image_2022-04-12_at_1.00.12_PM_(1).jpeg /home/hyveerp/public_html/application/controllers/Attachment.php 80
ERROR - 2022-05-11 10:34:16 --> Severity: Warning --> filesize(): stat failed for https://hses.hyvesports.com/uploads/orderform//Jersey_Order_Form_2nd_Batch_HYVE_V1_UPDATED_(1).xlsx /home/hyveerp/public_html/application/controllers/Attachment.php 58
ERROR - 2022-05-11 10:35:25 --> Severity: Warning --> filesize(): stat failed for https://hses.hyvesports.com/uploads/orderform//WhatsApp_Image_2022-04-12_at_1.00.10_PM_(1).jpeg /home/hyveerp/public_html/application/controllers/Attachment.php 80
ERROR - 2022-05-11 10:35:25 --> Severity: Warning --> filesize(): stat failed for https://hses.hyvesports.com/uploads/orderform//WhatsApp_Image_2022-04-12_at_1.00.12_PM_(1).jpeg /home/hyveerp/public_html/application/controllers/Attachment.php 80
ERROR - 2022-05-11 10:35:25 --> Severity: Warning --> filesize(): stat failed for https://hses.hyvesports.com/uploads/orderform//Jersey_Order_Form_2nd_Batch_HYVE_V1_UPDATED_(1).xlsx /home/hyveerp/public_html/application/controllers/Attachment.php 58
ERROR - 2022-05-11 10:42:58 --> 404 Page Not Found: Images/auth
ERROR - 2022-05-11 10:43:59 --> 404 Page Not Found: Images/auth
ERROR - 2022-05-11 11:13:31 --> Severity: Warning --> in_array() expects parameter 2 to be array, string given /home/hyveerp/public_html/application/views/formdata/offlinemodeledit.php 109
ERROR - 2022-05-11 11:13:31 --> Severity: Warning --> in_array() expects parameter 2 to be array, string given /home/hyveerp/public_html/application/views/formdata/offlinemodeledit.php 109
ERROR - 2022-05-11 11:13:31 --> Severity: Warning --> in_array() expects parameter 2 to be array, string given /home/hyveerp/public_html/application/views/formdata/offlinemodeledit.php 109
ERROR - 2022-05-11 11:13:31 --> Severity: Warning --> in_array() expects parameter 2 to be array, string given /home/hyveerp/public_html/application/views/formdata/offlinemodeledit.php 109
ERROR - 2022-05-11 11:13:31 --> Severity: Warning --> in_array() expects parameter 2 to be array, string given /home/hyveerp/public_html/application/views/formdata/offlinemodeledit.php 109
ERROR - 2022-05-11 11:13:31 --> Severity: Warning --> in_array() expects parameter 2 to be array, string given /home/hyveerp/public_html/application/views/formdata/offlinemodeledit.php 109
ERROR - 2022-05-11 11:13:31 --> Severity: Warning --> in_array() expects parameter 2 to be array, string given /home/hyveerp/public_html/application/views/formdata/offlinemodeledit.php 109
ERROR - 2022-05-11 11:13:31 --> Severity: Warning --> in_array() expects parameter 2 to be array, string given /home/hyveerp/public_html/application/views/formdata/offlinemodeledit.php 109
ERROR - 2022-05-11 11:13:31 --> Severity: Warning --> in_array() expects parameter 2 to be array, string given /home/hyveerp/public_html/application/views/formdata/offlinemodeledit.php 109
ERROR - 2022-05-11 11:13:31 --> Severity: Warning --> in_array() expects parameter 2 to be array, string given /home/hyveerp/public_html/application/views/formdata/offlinemodeledit.php 109
ERROR - 2022-05-11 11:13:31 --> Severity: Warning --> in_array() expects parameter 2 to be array, string given /home/hyveerp/public_html/application/views/formdata/offlinemodeledit.php 109
ERROR - 2022-05-11 11:13:31 --> Severity: Warning --> in_array() expects parameter 2 to be array, string given /home/hyveerp/public_html/application/views/formdata/offlinemodeledit.php 109
ERROR - 2022-05-11 11:13:31 --> Severity: Warning --> in_array() expects parameter 2 to be array, string given /home/hyveerp/public_html/application/views/formdata/offlinemodeledit.php 109
ERROR - 2022-05-11 11:13:31 --> Severity: Warning --> in_array() expects parameter 2 to be array, string given /home/hyveerp/public_html/application/views/formdata/offlinemodeledit.php 109
ERROR - 2022-05-11 11:13:31 --> Severity: Warning --> in_array() expects parameter 2 to be array, string given /home/hyveerp/public_html/application/views/formdata/offlinemodeledit.php 109
ERROR - 2022-05-11 11:13:31 --> Severity: Warning --> in_array() expects parameter 2 to be array, string given /home/hyveerp/public_html/application/views/formdata/offlinemodeledit.php 109
ERROR - 2022-05-11 11:13:31 --> Severity: Warning --> in_array() expects parameter 2 to be array, string given /home/hyveerp/public_html/application/views/formdata/offlinemodeledit.php 109
ERROR - 2022-05-11 11:13:31 --> Severity: Warning --> in_array() expects parameter 2 to be array, string given /home/hyveerp/public_html/application/views/formdata/offlinemodeledit.php 109
ERROR - 2022-05-11 11:13:31 --> Severity: Warning --> in_array() expects parameter 2 to be array, string given /home/hyveerp/public_html/application/views/formdata/offlinemodeledit.php 109
ERROR - 2022-05-11 11:13:31 --> Severity: Warning --> in_array() expects parameter 2 to be array, string given /home/hyveerp/public_html/application/views/formdata/offlinemodeledit.php 109
ERROR - 2022-05-11 11:18:35 --> Severity: Warning --> in_array() expects parameter 2 to be array, string given /home/hyveerp/public_html/application/views/formdata/offlinemodeledit.php 109
ERROR - 2022-05-11 11:18:35 --> Severity: Warning --> in_array() expects parameter 2 to be array, string given /home/hyveerp/public_html/application/views/formdata/offlinemodeledit.php 109
ERROR - 2022-05-11 11:18:35 --> Severity: Warning --> in_array() expects parameter 2 to be array, string given /home/hyveerp/public_html/application/views/formdata/offlinemodeledit.php 109
ERROR - 2022-05-11 11:18:35 --> Severity: Warning --> in_array() expects parameter 2 to be array, string given /home/hyveerp/public_html/application/views/formdata/offlinemodeledit.php 109
ERROR - 2022-05-11 11:18:35 --> Severity: Warning --> in_array() expects parameter 2 to be array, string given /home/hyveerp/public_html/application/views/formdata/offlinemodeledit.php 109
ERROR - 2022-05-11 11:18:35 --> Severity: Warning --> in_array() expects parameter 2 to be array, string given /home/hyveerp/public_html/application/views/formdata/offlinemodeledit.php 109
ERROR - 2022-05-11 11:18:35 --> Severity: Warning --> in_array() expects parameter 2 to be array, string given /home/hyveerp/public_html/application/views/formdata/offlinemodeledit.php 109
ERROR - 2022-05-11 11:18:35 --> Severity: Warning --> in_array() expects parameter 2 to be array, string given /home/hyveerp/public_html/application/views/formdata/offlinemodeledit.php 109
ERROR - 2022-05-11 11:18:35 --> Severity: Warning --> in_array() expects parameter 2 to be array, string given /home/hyveerp/public_html/application/views/formdata/offlinemodeledit.php 109
ERROR - 2022-05-11 11:18:35 --> Severity: Warning --> in_array() expects parameter 2 to be array, string given /home/hyveerp/public_html/application/views/formdata/offlinemodeledit.php 109
ERROR - 2022-05-11 11:18:35 --> Severity: Warning --> in_array() expects parameter 2 to be array, string given /home/hyveerp/public_html/application/views/formdata/offlinemodeledit.php 109
ERROR - 2022-05-11 11:18:35 --> Severity: Warning --> in_array() expects parameter 2 to be array, string given /home/hyveerp/public_html/application/views/formdata/offlinemodeledit.php 109
ERROR - 2022-05-11 11:18:35 --> Severity: Warning --> in_array() expects parameter 2 to be array, string given /home/hyveerp/public_html/application/views/formdata/offlinemodeledit.php 109
ERROR - 2022-05-11 11:18:35 --> Severity: Warning --> in_array() expects parameter 2 to be array, string given /home/hyveerp/public_html/application/views/formdata/offlinemodeledit.php 109
ERROR - 2022-05-11 11:18:35 --> Severity: Warning --> in_array() expects parameter 2 to be array, string given /home/hyveerp/public_html/application/views/formdata/offlinemodeledit.php 109
ERROR - 2022-05-11 11:18:35 --> Severity: Warning --> in_array() expects parameter 2 to be array, string given /home/hyveerp/public_html/application/views/formdata/offlinemodeledit.php 109
ERROR - 2022-05-11 11:18:35 --> Severity: Warning --> in_array() expects parameter 2 to be array, string given /home/hyveerp/public_html/application/views/formdata/offlinemodeledit.php 109
ERROR - 2022-05-11 11:18:35 --> Severity: Warning --> in_array() expects parameter 2 to be array, string given /home/hyveerp/public_html/application/views/formdata/offlinemodeledit.php 109
ERROR - 2022-05-11 11:18:35 --> Severity: Warning --> in_array() expects parameter 2 to be array, string given /home/hyveerp/public_html/application/views/formdata/offlinemodeledit.php 109
ERROR - 2022-05-11 11:18:35 --> Severity: Warning --> in_array() expects parameter 2 to be array, string given /home/hyveerp/public_html/application/views/formdata/offlinemodeledit.php 109
ERROR - 2022-05-11 11:32:52 --> 404 Page Not Found: Faviconico/index
ERROR - 2022-05-11 11:33:46 --> 404 Page Not Found: Faviconico/index
ERROR - 2022-05-11 11:52:47 --> 404 Page Not Found: Faviconico/index
ERROR - 2022-05-11 12:16:27 --> Severity: Warning --> filesize(): stat failed for https://hses.hyvesports.com/uploads/orderform//WhatsApp_Image_2022-05-11_at_12.11.50_PM.jpeg /home/hyveerp/public_html/application/controllers/Attachment.php 80
ERROR - 2022-05-11 12:16:27 --> Severity: Warning --> filesize(): stat failed for https://hses.hyvesports.com/uploads/orderform//WhatsApp_Image_2022-05-07_at_12.40.57_PM_(1).jpeg /home/hyveerp/public_html/application/controllers/Attachment.php 80
ERROR - 2022-05-11 12:16:56 --> 404 Page Not Found: Aws/credentials
ERROR - 2022-05-11 12:17:46 --> Severity: Warning --> filesize(): stat failed for https://hses.hyvesports.com/uploads/orderform//WhatsApp_Image_2022-05-11_at_12.11.50_PM.jpeg /home/hyveerp/public_html/application/controllers/Attachment.php 80
ERROR - 2022-05-11 12:17:46 --> Severity: Warning --> filesize(): stat failed for https://hses.hyvesports.com/uploads/orderform//WhatsApp_Image_2022-05-07_at_12.40.57_PM_(1).jpeg /home/hyveerp/public_html/application/controllers/Attachment.php 80
ERROR - 2022-05-11 12:19:23 --> 404 Page Not Found: Images/auth
ERROR - 2022-05-11 12:19:46 --> 404 Page Not Found: Images/auth
ERROR - 2022-05-11 12:20:12 --> 404 Page Not Found: Images/auth
ERROR - 2022-05-11 12:23:11 --> 404 Page Not Found: Images/auth
ERROR - 2022-05-11 12:23:22 --> 404 Page Not Found: Faviconico/index
ERROR - 2022-05-11 12:23:38 --> 404 Page Not Found: Faviconico/index
ERROR - 2022-05-11 12:41:47 --> 404 Page Not Found: Faviconico/index
ERROR - 2022-05-11 14:50:38 --> 404 Page Not Found: Faviconico/index
ERROR - 2022-05-11 15:16:09 --> 404 Page Not Found: Faviconico/index
ERROR - 2022-05-11 15:16:42 --> 404 Page Not Found: Env/index
ERROR - 2022-05-11 15:17:58 --> 404 Page Not Found: Faviconico/index
ERROR - 2022-05-11 15:38:08 --> Severity: Warning --> filesize(): stat failed for https://hses.hyvesports.com/uploads/orderform//WhatsApp_Image_2022-05-06_at_12.07.57_PM.jpeg /home/hyveerp/public_html/application/controllers/Attachment.php 80
ERROR - 2022-05-11 15:38:08 --> Severity: Warning --> filesize(): stat failed for https://hses.hyvesports.com/uploads/orderform//WhatsApp_Image_2022-05-06_at_12.07.58_PM.jpeg /home/hyveerp/public_html/application/controllers/Attachment.php 80
ERROR - 2022-05-11 15:38:08 --> Severity: Warning --> filesize(): stat failed for https://hses.hyvesports.com/uploads/orderform//WhatsApp_Image_2022-05-06_at_12.07.58_PM_(1).jpeg /home/hyveerp/public_html/application/controllers/Attachment.php 80
ERROR - 2022-05-11 15:38:08 --> Severity: Warning --> filesize(): stat failed for https://hses.hyvesports.com/uploads/orderform//WhatsApp_Image_2022-05-06_at_12.07.57_PM_(1).jpeg /home/hyveerp/public_html/application/controllers/Attachment.php 80
ERROR - 2022-05-11 15:38:08 --> Severity: Warning --> filesize(): stat failed for https://hses.hyvesports.com/uploads/orderform//WhatsApp_Image_2022-05-07_at_4.20.37_PM.jpeg /home/hyveerp/public_html/application/controllers/Attachment.php 80
ERROR - 2022-05-11 15:38:08 --> Severity: Warning --> filesize(): stat failed for https://hses.hyvesports.com/uploads/orderform//WhatsApp_Image_2022-05-07_at_4.20.36_PM.jpeg /home/hyveerp/public_html/application/controllers/Attachment.php 80
ERROR - 2022-05-11 15:38:08 --> Severity: Warning --> filesize(): stat failed for https://hses.hyvesports.com/uploads/orderform//WhatsApp_Image_2022-05-07_at_4.20.35_PM.jpeg /home/hyveerp/public_html/application/controllers/Attachment.php 80
ERROR - 2022-05-11 15:38:08 --> Severity: Warning --> filesize(): stat failed for https://hses.hyvesports.com/uploads/orderform//WhatsApp_Image_2022-05-07_at_4.20.34_PM.jpeg /home/hyveerp/public_html/application/controllers/Attachment.php 80
ERROR - 2022-05-11 15:38:08 --> Severity: Warning --> filesize(): stat failed for https://hses.hyvesports.com/uploads/orderform//C3_Jersey_Order_May_2022_(Hyve)_(1)_(2).xlsx /home/hyveerp/public_html/application/controllers/Attachment.php 58
ERROR - 2022-05-11 16:55:00 --> 404 Page Not Found: Public/vendors
ERROR - 2022-05-11 16:55:00 --> 404 Page Not Found: Public/vendors
ERROR - 2022-05-11 16:55:00 --> 404 Page Not Found: Public/vendors
ERROR - 2022-05-11 16:55:31 --> 404 Page Not Found: Images/auth
ERROR - 2022-05-11 17:28:38 --> 404 Page Not Found: Images/auth
ERROR - 2022-05-11 17:31:48 --> Severity: Warning --> in_array() expects parameter 2 to be array, string given /home/hyveerp/public_html/application/views/formdata/model_order_edit.php 114
ERROR - 2022-05-11 17:31:48 --> Severity: Warning --> in_array() expects parameter 2 to be array, string given /home/hyveerp/public_html/application/views/formdata/model_order_edit.php 114
ERROR - 2022-05-11 17:31:48 --> Severity: Warning --> in_array() expects parameter 2 to be array, string given /home/hyveerp/public_html/application/views/formdata/model_order_edit.php 114
ERROR - 2022-05-11 17:31:48 --> Severity: Warning --> in_array() expects parameter 2 to be array, string given /home/hyveerp/public_html/application/views/formdata/model_order_edit.php 114
ERROR - 2022-05-11 17:31:48 --> Severity: Warning --> in_array() expects parameter 2 to be array, string given /home/hyveerp/public_html/application/views/formdata/model_order_edit.php 114
ERROR - 2022-05-11 17:31:48 --> Severity: Warning --> in_array() expects parameter 2 to be array, string given /home/hyveerp/public_html/application/views/formdata/model_order_edit.php 114
ERROR - 2022-05-11 17:31:48 --> Severity: Warning --> in_array() expects parameter 2 to be array, string given /home/hyveerp/public_html/application/views/formdata/model_order_edit.php 114
ERROR - 2022-05-11 17:31:48 --> Severity: Warning --> in_array() expects parameter 2 to be array, string given /home/hyveerp/public_html/application/views/formdata/model_order_edit.php 114
ERROR - 2022-05-11 17:31:48 --> Severity: Warning --> in_array() expects parameter 2 to be array, string given /home/hyveerp/public_html/application/views/formdata/model_order_edit.php 114
ERROR - 2022-05-11 17:31:48 --> Severity: Warning --> in_array() expects parameter 2 to be array, string given /home/hyveerp/public_html/application/views/formdata/model_order_edit.php 114
ERROR - 2022-05-11 17:31:48 --> Severity: Warning --> in_array() expects parameter 2 to be array, string given /home/hyveerp/public_html/application/views/formdata/model_order_edit.php 114
ERROR - 2022-05-11 17:31:48 --> Severity: Warning --> in_array() expects parameter 2 to be array, string given /home/hyveerp/public_html/application/views/formdata/model_order_edit.php 114
ERROR - 2022-05-11 17:31:48 --> Severity: Warning --> in_array() expects parameter 2 to be array, string given /home/hyveerp/public_html/application/views/formdata/model_order_edit.php 114
ERROR - 2022-05-11 17:31:48 --> Severity: Warning --> in_array() expects parameter 2 to be array, string given /home/hyveerp/public_html/application/views/formdata/model_order_edit.php 114
ERROR - 2022-05-11 17:31:48 --> Severity: Warning --> in_array() expects parameter 2 to be array, string given /home/hyveerp/public_html/application/views/formdata/model_order_edit.php 114
ERROR - 2022-05-11 17:31:48 --> Severity: Warning --> in_array() expects parameter 2 to be array, string given /home/hyveerp/public_html/application/views/formdata/model_order_edit.php 114
ERROR - 2022-05-11 17:31:48 --> Severity: Warning --> in_array() expects parameter 2 to be array, string given /home/hyveerp/public_html/application/views/formdata/model_order_edit.php 114
ERROR - 2022-05-11 17:31:48 --> Severity: Warning --> in_array() expects parameter 2 to be array, string given /home/hyveerp/public_html/application/views/formdata/model_order_edit.php 114
ERROR - 2022-05-11 17:31:48 --> Severity: Warning --> in_array() expects parameter 2 to be array, string given /home/hyveerp/public_html/application/views/formdata/model_order_edit.php 114
ERROR - 2022-05-11 17:31:48 --> Severity: Warning --> in_array() expects parameter 2 to be array, string given /home/hyveerp/public_html/application/views/formdata/model_order_edit.php 114
ERROR - 2022-05-11 17:43:55 --> 404 Page Not Found: Images/auth
ERROR - 2022-05-11 18:11:55 --> Severity: Warning --> filesize(): stat failed for https://hses.hyvesports.com/uploads/orderform//WhatsApp_Image_2022-05-05_at_12.32.51_PM.jpeg /home/hyveerp/public_html/application/controllers/Attachment.php 80
ERROR - 2022-05-11 18:11:55 --> Severity: Warning --> filesize(): stat failed for https://hses.hyvesports.com/uploads/orderform//WhatsApp_Image_2022-05-05_at_12.32.50_PM.jpeg /home/hyveerp/public_html/application/controllers/Attachment.php 80
ERROR - 2022-05-11 18:11:55 --> Severity: Warning --> filesize(): stat failed for https://hses.hyvesports.com/uploads/orderform//Steadfast_X_Hyve.xlsx /home/hyveerp/public_html/application/controllers/Attachment.php 58
ERROR - 2022-05-11 18:17:08 --> 404 Page Not Found: Owa/auth
ERROR - 2022-05-11 18:18:44 --> 404 Page Not Found: Owa/auth
ERROR - 2022-05-11 18:19:25 --> 404 Page Not Found: Ecp/Current
ERROR - 2022-05-11 18:20:59 --> Severity: Warning --> filesize(): stat failed for https://hses.hyvesports.com/uploads/orderform//WhatsApp_Image_2022-05-05_at_12.32.51_PM.jpeg /home/hyveerp/public_html/application/controllers/Attachment.php 80
ERROR - 2022-05-11 18:20:59 --> Severity: Warning --> filesize(): stat failed for https://hses.hyvesports.com/uploads/orderform//WhatsApp_Image_2022-05-05_at_12.32.50_PM.jpeg /home/hyveerp/public_html/application/controllers/Attachment.php 80
ERROR - 2022-05-11 18:20:59 --> Severity: Warning --> filesize(): stat failed for https://hses.hyvesports.com/uploads/orderform//Steadfast_X_Hyve.xlsx /home/hyveerp/public_html/application/controllers/Attachment.php 58
ERROR - 2022-05-11 18:22:15 --> 404 Page Not Found: Images/auth
ERROR - 2022-05-11 18:25:11 --> 404 Page Not Found: Actuator/gateway
ERROR - 2022-05-11 19:00:01 --> 404 Page Not Found: Faviconico/index
ERROR - 2022-05-11 19:00:12 --> 404 Page Not Found: Faviconico/index
ERROR - 2022-05-11 19:32:02 --> 404 Page Not Found: Admin/index
ERROR - 2022-05-11 19:34:26 --> 404 Page Not Found: Public/vendors
ERROR - 2022-05-11 19:34:26 --> 404 Page Not Found: Public/vendors
ERROR - 2022-05-11 19:34:26 --> 404 Page Not Found: Public/vendors
ERROR - 2022-05-11 19:51:20 --> Severity: Warning --> Division by zero /home/hyveerp/public_html/application/models/Dashboard_model.php 310
ERROR - 2022-05-11 22:42:37 --> 404 Page Not Found: _ignition/execute-solution
ERROR - 2022-05-11 22:46:56 --> 404 Page Not Found: Faviconico/index
ERROR - 2022-05-11 23:13:29 --> 404 Page Not Found: Env/index
ERROR - 2022-05-11 23:13:41 --> 404 Page Not Found: Env/index
ERROR - 2022-05-11 23:42:59 --> 404 Page Not Found: Actuator/health
ERROR - 2022-05-11 23:52:38 --> 404 Page Not Found: Mgmt/shared

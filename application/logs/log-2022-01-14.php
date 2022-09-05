<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2022-01-14 00:21:49 --> 404 Page Not Found: Cgi-bin/.%2e
ERROR - 2022-01-14 02:43:14 --> 404 Page Not Found: Env/index
ERROR - 2022-01-14 04:21:14 --> 404 Page Not Found: Env/index
ERROR - 2022-01-14 07:13:43 --> 404 Page Not Found: Dns-query/index
ERROR - 2022-01-14 07:13:44 --> 404 Page Not Found: Dns-query/index
ERROR - 2022-01-14 07:13:46 --> 404 Page Not Found: Dns-query/index
ERROR - 2022-01-14 07:13:47 --> 404 Page Not Found: Dns-query/index
ERROR - 2022-01-14 07:13:47 --> 404 Page Not Found: Query/index
ERROR - 2022-01-14 07:13:48 --> 404 Page Not Found: Query/index
ERROR - 2022-01-14 07:13:50 --> 404 Page Not Found: Query/index
ERROR - 2022-01-14 07:13:51 --> 404 Page Not Found: Query/index
ERROR - 2022-01-14 07:13:52 --> 404 Page Not Found: Resolve/index
ERROR - 2022-01-14 07:13:52 --> 404 Page Not Found: Resolve/index
ERROR - 2022-01-14 07:13:54 --> 404 Page Not Found: Resolve/index
ERROR - 2022-01-14 07:13:55 --> 404 Page Not Found: Resolve/index
ERROR - 2022-01-14 08:39:42 --> 404 Page Not Found: Faviconico/index
ERROR - 2022-01-14 08:40:15 --> 404 Page Not Found: Faviconico/index
ERROR - 2022-01-14 08:41:50 --> 404 Page Not Found: Faviconico/index
ERROR - 2022-01-14 08:43:45 --> 404 Page Not Found: Faviconico/index
ERROR - 2022-01-14 08:48:53 --> 404 Page Not Found: Faviconico/index
ERROR - 2022-01-14 08:52:09 --> 404 Page Not Found: Faviconico/index
ERROR - 2022-01-14 08:53:16 --> 404 Page Not Found: Faviconico/index
ERROR - 2022-01-14 08:55:53 --> 404 Page Not Found: Faviconico/index
ERROR - 2022-01-14 08:58:53 --> Severity: Warning --> mysqli::query(): (08S01/1053): Server shutdown in progress /home/hyveerp/public_html/system/database/drivers/mysqli/mysqli_driver.php 307
ERROR - 2022-01-14 08:58:53 --> Query error: Server shutdown in progress - Invalid query: SELECT 
				SH.*,
				SHD.batch_number,
				SHD.department_schedule_date,
				SHD.scheduled_order_info,
				SHD.schedule_department_id,
				SHD.order_is_approved,
				SHD.is_re_scheduled,
				WO.wo_date_time,WO.lead_id,CONCAT(SM.staff_code,"-",SM.staff_name) as sales_handler1,SM.staff_name as sales_handler,
				WO.orderform_type_id,WO.orderform_number,PO.production_unit_name,WO.wo_product_info,PM.priority_color_code,PM.priority_name,
SHD.total_order_items as TOTAL_COUNT,
(SELECT count(*) FROM rs_design_departments as T1 WHERE T1.schedule_department_id=SHD.schedule_department_id and T1.is_current=1 and T1.from_department="design" ) as SUBMITTED_COUNT,
(SELECT count(*) FROM rs_design_departments as T2 WHERE T2.schedule_department_id=SHD.schedule_department_id and T2.verify_status=1 and T2.is_current=1 and T2.from_department="design") as APPROVED_COUNT,
(SELECT count(*) FROM rs_design_departments as T3 WHERE T3.schedule_department_id=SHD.schedule_department_id and T3.verify_status=-1 and T3.is_current=1 and T3.from_department="design") as REJECTED_COUNT,
(SELECT count(*) FROM sh_schedule_department_rejections as SDR WHERE  SDR.batch_number=SHD.batch_number and FIND_IN_SET(4,rejected_to_departments) limit 1 ) as BUNDLING_REJECTED_COUNT
			FROM
				sh_schedule_departments AS SHD  LEFT JOIN sh_schedules  as SH on  SHD.schedule_id=SH.schedule_id LEFT JOIN wo_work_orders as WO on WO.order_id=SH.order_id LEFT JOIN staff_master as SM on SM.staff_id=WO.wo_owner_id AND WO.lead_id!=0 LEFT JOIN pr_production_units as PO on PO.production_unit_id=SHD.unit_id LEFT JOIN priority_master as PM on PM.priority_id=WO.wo_work_priority_id  WHERE ( FIND_IN_SET(4,SHD.department_ids) AND SHD.unit_id IN(0,1,2)   )AND (  SHD.department_schedule_date like 'F%' OR WO.orderform_number like 'F%' OR WO.wo_product_info like 'F%' OR PM.priority_name like 'F%' OR SM.staff_name like 'F%' OR WO.wo_product_info like 'F%'  ) 
ERROR - 2022-01-14 08:58:53 --> Severity: error --> Exception: Call to a member function num_rows() on bool /home/hyveerp/public_html/application/libraries/Datatable.php 41
ERROR - 2022-01-14 08:58:53 --> Severity: Warning --> Error while sending QUERY packet. PID=14207 /home/hyveerp/public_html/system/database/drivers/mysqli/mysqli_driver.php 307
ERROR - 2022-01-14 08:58:53 --> Query error: MySQL server has gone away - Invalid query: SELECT `C`.*, `P`.`menu_name` as `module_parent`
FROM `staff_permissions` as `SP`
LEFT JOIN `menu_master` as `C` ON `C`.`menu_master_id` = `SP`.`sub_module_id`
LEFT JOIN `menu_master` as `P` ON `P`.`menu_master_id` = `C`.`menu_parent`
WHERE `SP`.`permission_module` = 'design'
AND `SP`.`staff_login_id` = '33'
 LIMIT 1
ERROR - 2022-01-14 08:58:53 --> Severity: error --> Exception: Call to a member function row_array() on bool /home/hyveerp/public_html/application/libraries/Rbac.php 39
ERROR - 2022-01-14 08:58:53 --> Severity: Warning --> Error while sending QUERY packet. PID=14212 /home/hyveerp/public_html/system/database/drivers/mysqli/mysqli_driver.php 307
ERROR - 2022-01-14 08:58:53 --> Query error: MySQL server has gone away - Invalid query: SELECT `C`.*, `P`.`menu_name` as `module_parent`
FROM `staff_permissions` as `SP`
LEFT JOIN `menu_master` as `C` ON `C`.`menu_master_id` = `SP`.`sub_module_id`
LEFT JOIN `menu_master` as `P` ON `P`.`menu_master_id` = `C`.`menu_parent`
WHERE `SP`.`permission_module` = 'design'
AND `SP`.`staff_login_id` = '33'
 LIMIT 1
ERROR - 2022-01-14 08:58:53 --> Severity: error --> Exception: Call to a member function row_array() on bool /home/hyveerp/public_html/application/libraries/Rbac.php 39
ERROR - 2022-01-14 09:01:30 --> 404 Page Not Found: Faviconico/index
ERROR - 2022-01-14 09:16:12 --> 404 Page Not Found: Faviconico/index
ERROR - 2022-01-14 09:18:29 --> 404 Page Not Found: Faviconico/index
ERROR - 2022-01-14 09:20:06 --> 404 Page Not Found: Faviconico/index
ERROR - 2022-01-14 09:20:22 --> 404 Page Not Found: Faviconico/index
ERROR - 2022-01-14 09:27:48 --> 404 Page Not Found: Faviconico/index
ERROR - 2022-01-14 09:48:59 --> 404 Page Not Found: Faviconico/index
ERROR - 2022-01-14 09:53:54 --> 404 Page Not Found: Faviconico/index
ERROR - 2022-01-14 09:54:35 --> 404 Page Not Found: Faviconico/index
ERROR - 2022-01-14 09:55:27 --> Severity: Warning --> Use of undefined constant fusing1 - assumed 'fusing1' (this will throw an Error in a future version of PHP) /home/hyveerp/public_html/application/views/workorder/td_6_status_offline.php 19
ERROR - 2022-01-14 09:55:41 --> Severity: Warning --> Use of undefined constant fusing1 - assumed 'fusing1' (this will throw an Error in a future version of PHP) /home/hyveerp/public_html/application/views/workorder/td_6_status_offline.php 19
ERROR - 2022-01-14 09:55:58 --> Severity: Warning --> Use of undefined constant fusing1 - assumed 'fusing1' (this will throw an Error in a future version of PHP) /home/hyveerp/public_html/application/views/workorder/td_6_status_offline.php 19
ERROR - 2022-01-14 09:59:26 --> 404 Page Not Found: Faviconico/index
ERROR - 2022-01-14 10:01:41 --> Severity: Warning --> Use of undefined constant fusing1 - assumed 'fusing1' (this will throw an Error in a future version of PHP) /home/hyveerp/public_html/application/views/workorder/td_6_status_offline.php 19
ERROR - 2022-01-14 10:02:05 --> Severity: Warning --> Use of undefined constant fusing1 - assumed 'fusing1' (this will throw an Error in a future version of PHP) /home/hyveerp/public_html/application/views/workorder/td_6_status_offline.php 19
ERROR - 2022-01-14 10:05:38 --> 404 Page Not Found: Faviconico/index
ERROR - 2022-01-14 10:08:51 --> Severity: Warning --> Use of undefined constant fusing1 - assumed 'fusing1' (this will throw an Error in a future version of PHP) /home/hyveerp/public_html/application/views/workorder/td_6_status_offline.php 19
ERROR - 2022-01-14 10:19:10 --> Severity: Warning --> Use of undefined constant fusing1 - assumed 'fusing1' (this will throw an Error in a future version of PHP) /home/hyveerp/public_html/application/views/workorder/td_6_status_offline.php 19
ERROR - 2022-01-14 10:36:42 --> 404 Page Not Found: Actuator/health
ERROR - 2022-01-14 10:54:58 --> Severity: Warning --> Use of undefined constant fusing1 - assumed 'fusing1' (this will throw an Error in a future version of PHP) /home/hyveerp/public_html/application/views/workorder/td_6_status_offline.php 19
ERROR - 2022-01-14 10:57:04 --> 404 Page Not Found: Sitemapxml/index
ERROR - 2022-01-14 10:57:05 --> 404 Page Not Found: Well-known/security.txt
ERROR - 2022-01-14 11:14:10 --> Severity: Warning --> Use of undefined constant fusing1 - assumed 'fusing1' (this will throw an Error in a future version of PHP) /home/hyveerp/public_html/application/views/workorder/td_6_status_offline.php 19
ERROR - 2022-01-14 11:14:10 --> Severity: Warning --> Use of undefined constant fusing1 - assumed 'fusing1' (this will throw an Error in a future version of PHP) /home/hyveerp/public_html/application/views/workorder/td_6_status_offline.php 19
ERROR - 2022-01-14 11:14:10 --> Severity: Warning --> Use of undefined constant fusing1 - assumed 'fusing1' (this will throw an Error in a future version of PHP) /home/hyveerp/public_html/application/views/workorder/td_6_status_offline.php 19
ERROR - 2022-01-14 11:14:10 --> Severity: Warning --> Use of undefined constant fusing1 - assumed 'fusing1' (this will throw an Error in a future version of PHP) /home/hyveerp/public_html/application/views/workorder/td_6_status_offline.php 19
ERROR - 2022-01-14 11:14:10 --> Severity: Warning --> Use of undefined constant fusing1 - assumed 'fusing1' (this will throw an Error in a future version of PHP) /home/hyveerp/public_html/application/views/workorder/td_6_status_offline.php 19
ERROR - 2022-01-14 11:14:10 --> Severity: Warning --> Use of undefined constant fusing1 - assumed 'fusing1' (this will throw an Error in a future version of PHP) /home/hyveerp/public_html/application/views/workorder/td_6_status_offline.php 19
ERROR - 2022-01-14 11:23:49 --> Severity: Warning --> Use of undefined constant fusing1 - assumed 'fusing1' (this will throw an Error in a future version of PHP) /home/hyveerp/public_html/application/views/workorder/td_6_status_offline.php 19
ERROR - 2022-01-14 11:23:49 --> Severity: Warning --> Use of undefined constant fusing1 - assumed 'fusing1' (this will throw an Error in a future version of PHP) /home/hyveerp/public_html/application/views/workorder/td_6_status_offline.php 19
ERROR - 2022-01-14 11:24:51 --> Severity: Warning --> Use of undefined constant fusing1 - assumed 'fusing1' (this will throw an Error in a future version of PHP) /home/hyveerp/public_html/application/views/workorder/td_6_status_offline.php 19
ERROR - 2022-01-14 11:25:22 --> Severity: Warning --> Use of undefined constant fusing1 - assumed 'fusing1' (this will throw an Error in a future version of PHP) /home/hyveerp/public_html/application/views/workorder/td_6_status_offline.php 19
ERROR - 2022-01-14 11:27:39 --> Severity: Warning --> in_array() expects parameter 2 to be array, int given /home/hyveerp/public_html/application/views/workorder/onlinemodeledit.php 199
ERROR - 2022-01-14 11:27:39 --> Severity: Warning --> in_array() expects parameter 2 to be array, int given /home/hyveerp/public_html/application/views/workorder/onlinemodeledit.php 199
ERROR - 2022-01-14 11:27:39 --> Severity: Warning --> in_array() expects parameter 2 to be array, int given /home/hyveerp/public_html/application/views/workorder/onlinemodeledit.php 199
ERROR - 2022-01-14 11:27:39 --> Severity: Warning --> in_array() expects parameter 2 to be array, int given /home/hyveerp/public_html/application/views/workorder/onlinemodeledit.php 199
ERROR - 2022-01-14 11:27:39 --> Severity: Warning --> in_array() expects parameter 2 to be array, int given /home/hyveerp/public_html/application/views/workorder/onlinemodeledit.php 199
ERROR - 2022-01-14 11:27:39 --> Severity: Warning --> in_array() expects parameter 2 to be array, int given /home/hyveerp/public_html/application/views/workorder/onlinemodeledit.php 199
ERROR - 2022-01-14 11:27:39 --> Severity: Warning --> in_array() expects parameter 2 to be array, int given /home/hyveerp/public_html/application/views/workorder/onlinemodeledit.php 199
ERROR - 2022-01-14 11:27:39 --> Severity: Warning --> in_array() expects parameter 2 to be array, int given /home/hyveerp/public_html/application/views/workorder/onlinemodeledit.php 199
ERROR - 2022-01-14 11:34:12 --> Severity: Warning --> Use of undefined constant fusing1 - assumed 'fusing1' (this will throw an Error in a future version of PHP) /home/hyveerp/public_html/application/views/workorder/td_6_status_offline.php 19
ERROR - 2022-01-14 11:35:02 --> 404 Page Not Found: Env/index
ERROR - 2022-01-14 11:35:55 --> Severity: Warning --> Use of undefined constant fusing1 - assumed 'fusing1' (this will throw an Error in a future version of PHP) /home/hyveerp/public_html/application/views/workorder/td_6_status_offline.php 19
ERROR - 2022-01-14 11:59:52 --> Severity: Warning --> Use of undefined constant fusing1 - assumed 'fusing1' (this will throw an Error in a future version of PHP) /home/hyveerp/public_html/application/views/workorder/td_6_status_offline.php 19
ERROR - 2022-01-14 11:59:52 --> Severity: Warning --> Use of undefined constant fusing1 - assumed 'fusing1' (this will throw an Error in a future version of PHP) /home/hyveerp/public_html/application/views/workorder/td_6_status_offline.php 19
ERROR - 2022-01-14 12:34:05 --> 404 Page Not Found: Vendor/phpunit
ERROR - 2022-01-14 12:36:02 --> Severity: Warning --> Use of undefined constant fusing1 - assumed 'fusing1' (this will throw an Error in a future version of PHP) /home/hyveerp/public_html/application/views/workorder/td_6_status_offline.php 19
ERROR - 2022-01-14 12:36:02 --> Severity: Warning --> Use of undefined constant fusing1 - assumed 'fusing1' (this will throw an Error in a future version of PHP) /home/hyveerp/public_html/application/views/workorder/td_6_status_offline.php 19
ERROR - 2022-01-14 13:25:54 --> Severity: Warning --> Use of undefined constant fusing1 - assumed 'fusing1' (this will throw an Error in a future version of PHP) /home/hyveerp/public_html/application/views/workorder/td_6_status_offline.php 19
ERROR - 2022-01-14 13:26:07 --> Severity: Warning --> Use of undefined constant fusing1 - assumed 'fusing1' (this will throw an Error in a future version of PHP) /home/hyveerp/public_html/application/views/workorder/td_6_status_offline.php 19
ERROR - 2022-01-14 13:33:58 --> Severity: Warning --> Use of undefined constant fusing1 - assumed 'fusing1' (this will throw an Error in a future version of PHP) /home/hyveerp/public_html/application/views/workorder/td_6_status_offline.php 19
ERROR - 2022-01-14 13:57:53 --> 404 Page Not Found: Env/index
ERROR - 2022-01-14 14:14:33 --> 404 Page Not Found: Well-known/security.txt
ERROR - 2022-01-14 14:36:19 --> Severity: Warning --> Use of undefined constant fusing1 - assumed 'fusing1' (this will throw an Error in a future version of PHP) /home/hyveerp/public_html/application/views/workorder/td_6_status_offline.php 19
ERROR - 2022-01-14 14:44:48 --> Severity: Warning --> Use of undefined constant fusing1 - assumed 'fusing1' (this will throw an Error in a future version of PHP) /home/hyveerp/public_html/application/views/workorder/td_6_status_offline.php 19
ERROR - 2022-01-14 15:00:19 --> 404 Page Not Found: Faviconico/index
ERROR - 2022-01-14 15:01:01 --> Severity: Warning --> filesize(): stat failed for https://hses.hyvesports.com/uploads/orderform//WhatsApp_Image_2021-10-05_at_2.55.46_PM.jpeg /home/hyveerp/public_html/application/controllers/Attachment.php 80
ERROR - 2022-01-14 15:01:01 --> Severity: Warning --> filesize(): stat failed for https://hses.hyvesports.com/uploads/orderform//WhatsApp_Image_2021-10-05_at_2.55.46_PM_(1).jpeg /home/hyveerp/public_html/application/controllers/Attachment.php 80
ERROR - 2022-01-14 15:01:01 --> Severity: Warning --> filesize(): stat failed for https://hses.hyvesports.com/uploads/orderform//WhatsApp_Image_2021-10-08_at_4.29.50_PM.jpeg /home/hyveerp/public_html/application/controllers/Attachment.php 80
ERROR - 2022-01-14 15:01:01 --> Severity: Warning --> filesize(): stat failed for https://hses.hyvesports.com/uploads/orderform//WhatsApp_Image_2021-10-08_at_5.52.17_PM.jpeg /home/hyveerp/public_html/application/controllers/Attachment.php 80
ERROR - 2022-01-14 15:01:01 --> Severity: Warning --> filesize(): stat failed for https://hses.hyvesports.com/uploads/orderform//sky.xlsx /home/hyveerp/public_html/application/controllers/Attachment.php 58
ERROR - 2022-01-14 15:31:58 --> 404 Page Not Found: Faviconico/index
ERROR - 2022-01-14 15:39:22 --> Severity: Warning --> Use of undefined constant fusing1 - assumed 'fusing1' (this will throw an Error in a future version of PHP) /home/hyveerp/public_html/application/views/workorder/td_6_status_offline.php 19
ERROR - 2022-01-14 15:40:39 --> 404 Page Not Found: Faviconico/index
ERROR - 2022-01-14 15:52:51 --> Severity: Warning --> filesize(): stat failed for https://hses.hyvesports.com/uploads/orderform//Dream_esports_final.docx /home/hyveerp/public_html/application/controllers/Attachment.php 58
ERROR - 2022-01-14 15:52:51 --> Severity: Warning --> filesize(): stat failed for https://hses.hyvesports.com/uploads/orderform//Dream_esports.pdf /home/hyveerp/public_html/application/controllers/Attachment.php 58
ERROR - 2022-01-14 15:52:51 --> Severity: Warning --> filesize(): stat failed for https://hses.hyvesports.com/uploads/orderform//WhatsApp_Image_2021-12-30_at_16.48.44_(1).jpeg /home/hyveerp/public_html/application/controllers/Attachment.php 80
ERROR - 2022-01-14 15:52:51 --> Severity: Warning --> filesize(): stat failed for https://hses.hyvesports.com/uploads/orderform//WhatsApp_Image_2021-12-30_at_16.48.44_(2).jpeg /home/hyveerp/public_html/application/controllers/Attachment.php 80
ERROR - 2022-01-14 15:52:51 --> Severity: Warning --> filesize(): stat failed for https://hses.hyvesports.com/uploads/orderform//WhatsApp_Image_2022-01-03_at_13.05.24.jpeg /home/hyveerp/public_html/application/controllers/Attachment.php 80
ERROR - 2022-01-14 15:56:11 --> 404 Page Not Found: Wp-admin/admin-ajax.php
ERROR - 2022-01-14 15:58:56 --> 404 Page Not Found: Ecp/Current
ERROR - 2022-01-14 16:15:31 --> 404 Page Not Found: Owa/auth
ERROR - 2022-01-14 17:23:55 --> 404 Page Not Found: Env/index
ERROR - 2022-01-14 18:01:06 --> Severity: Warning --> filesize(): stat failed for https://hses.hyvesports.com/uploads/orderform//WhatsApp_Image_2021-12-21_at_5.03.52_PM.jpeg /home/hyveerp/public_html/application/controllers/Attachment.php 80
ERROR - 2022-01-14 18:01:06 --> Severity: Warning --> filesize(): stat failed for https://hses.hyvesports.com/uploads/orderform//cott.jpeg /home/hyveerp/public_html/application/controllers/Attachment.php 80
ERROR - 2022-01-14 18:02:17 --> 404 Page Not Found: Wp-admin/admin-ajax.php
ERROR - 2022-01-14 18:03:18 --> 404 Page Not Found: Wp-admin/admin-ajax.php
ERROR - 2022-01-14 18:03:23 --> Severity: Warning --> Use of undefined constant fusing1 - assumed 'fusing1' (this will throw an Error in a future version of PHP) /home/hyveerp/public_html/application/views/workorder/td_6_status_offline.php 19
ERROR - 2022-01-14 18:03:23 --> Severity: Warning --> Use of undefined constant fusing1 - assumed 'fusing1' (this will throw an Error in a future version of PHP) /home/hyveerp/public_html/application/views/workorder/td_6_status_offline.php 19
ERROR - 2022-01-14 18:03:23 --> Severity: Warning --> Use of undefined constant fusing1 - assumed 'fusing1' (this will throw an Error in a future version of PHP) /home/hyveerp/public_html/application/views/workorder/td_6_status_offline.php 19
ERROR - 2022-01-14 18:03:23 --> Severity: Warning --> Use of undefined constant fusing1 - assumed 'fusing1' (this will throw an Error in a future version of PHP) /home/hyveerp/public_html/application/views/workorder/td_6_status_offline.php 19
ERROR - 2022-01-14 18:03:51 --> 404 Page Not Found: Env/index
ERROR - 2022-01-14 18:04:20 --> 404 Page Not Found: Wp-admin/admin-ajax.php
ERROR - 2022-01-14 18:14:04 --> 404 Page Not Found: _ignition/execute-solution
ERROR - 2022-01-14 18:37:31 --> 404 Page Not Found: Sitemapxml/index
ERROR - 2022-01-14 18:37:32 --> 404 Page Not Found: Well-known/security.txt
ERROR - 2022-01-14 19:52:58 --> 404 Page Not Found: Env/index
ERROR - 2022-01-14 20:46:37 --> 404 Page Not Found: Cgi-bin/.%2e
ERROR - 2022-01-14 23:49:12 --> 404 Page Not Found: Cgi-bin/welcome

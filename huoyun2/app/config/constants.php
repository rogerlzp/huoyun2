<?php
return array (
		"HORDER_STATUS_NEW" => 0, // 新建
		"HORDER_STATUS_CONFIRMED" => 1, // 设定DRIVER， 待取货
		"HORDER_STATUS_SHIPPING" => 2, // 取货后，待送达
		"HORDER_STATUS_ARRIVED" => 3, // 车主修改为送达后
		"HORDER_STATUS_CONFIRMED_ARRIVED" => 4, // 货主确认送达后
		"HORDER_STATUS_COMMENTED" => 5, // 评价后，彻底结束
		
		"TRUCK_STATUS_NEW" => 0, // 新建
		"TRUCK_STATUS_IN_AUDIT" => 1, // 提交审计
		"TRUCK_STATUS_AUDIT_PASS" => 2, // 审计通过
		"TRUCK_STATUS_AUDIT_FAIL" => 3, // 审计没通过
		
		"USER_STATUS_NEW" => 0, // 新建
		"USER_STATUS_IN_AUDIT" => 1, // 提交审计
		"USER_STATUS_AUDIT_PASS" => 2, // 审计通过
		"USER_STATUS_AUDIT_FAIL" => 3, // 审计没通过
		                               
		// login 返回
		"DRIVER_ROLE_ID" => 1, // 车主角色ID
		"HUOZHU_ROLE_ID" => 2, // 货主角色ID
		
		"ID" => "id",
		"NAME" => "name",
		"MOBILE" => "mobile",
		
		"TRUCK_ID" => "truck_id",
		"TRUCK_MOBILE" => "truck_mobile",
		"TRUCK_PLATE" => "truck_plate",
		"TRUCK_TYPE" => "truck_type",
		"TRUCK_LENGTH" => "truck_length",
		"TRUCK_WEIGHT" => "truck_weight",
		"TRUCK_AUDIT_STATUS" => "ta_status",
		"TRUCK_LICENSE_IAMGE_URL" => 'tl_image',
		"TRUCK_PHOTO_IAMGE_URL" => 'tp_image',
		
		"USERNAME" => "username",
		"USER_AUDIT_STATUS" => "ua_status",
		"IDENTITY_FRONT_IMAGE_URL" => "id_fimage",
		"IDENTITY_BACK_IMAGE_URL" => "id_bimage",
		"PROFILE_IMAGE_URL" => "p_image",
		
		"DRIVER_LICENSE_IAMGE_URL" => 'dl_image',
		
		"SHIPPER_ADDRESS_CODE" => "sa_code",
		"CONSIGNEE_ADDRESS_CODE" => "ca_code" 
		
		
)
;



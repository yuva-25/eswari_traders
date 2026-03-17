

CREATE TABLE `eswari_traders_` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `created_date_time` datetime DEFAULT NULL,
  `updated_date_time` datetime DEFAULT NULL,
  `creator` mediumtext DEFAULT NULL,
  `creator_name` mediumtext DEFAULT NULL,
  `bill_company_id` mediumtext DEFAULT NULL,
  `estimate_id` mediumtext DEFAULT NULL,
  `estimate_number` mediumtext DEFAULT NULL,
  `estimate_date` mediumtext DEFAULT NULL,
  `party_id` mediumtext DEFAULT NULL,
  `party_name` mediumtext DEFAULT NULL,
  `party_mobile_number` mediumtext DEFAULT NULL,
  `party_name_mobile_city` mediumtext DEFAULT NULL,
  `party_details` mediumtext DEFAULT NULL,
  `product_id` mediumtext DEFAULT NULL,
  `product_name` mediumtext DEFAULT NULL,
  `unit_id` mediumtext DEFAULT NULL,
  `unit_name` mediumtext DEFAULT NULL,
  `size_id` mediumtext DEFAULT NULL,
  `size_name` mediumtext DEFAULT NULL,
  `quantity` mediumtext DEFAULT NULL,
  `rate` mediumtext DEFAULT NULL,
  `amount` mediumtext DEFAULT NULL,
  `sub_total` mediumtext DEFAULT NULL,
  `discount` mediumtext DEFAULT NULL,
  `discount_name` mediumtext DEFAULT NULL,
  `discount_value` mediumtext DEFAULT NULL,
  `discounted_total` mediumtext DEFAULT NULL,
  `extra_charges` mediumtext DEFAULT NULL,
  `extra_charges_name` mediumtext DEFAULT NULL,
  `extra_charges_value` mediumtext DEFAULT NULL,
  `extra_charges_total` mediumtext DEFAULT NULL,
  `extra_charges_tax` mediumtext DEFAULT NULL,
  `company_state` mediumtext DEFAULT NULL,
  `party_state` mediumtext DEFAULT NULL,
  `taxable_value` mediumtext DEFAULT NULL,
  `cgst_value` mediumtext DEFAULT NULL,
  `sgst_value` mediumtext DEFAULT NULL,
  `igst_value` mediumtext DEFAULT NULL,
  `total_tax_value` mediumtext DEFAULT NULL,
  `total_amount` mediumtext DEFAULT NULL,
  `total_quantity` mediumtext DEFAULT NULL,
  `description` mediumtext DEFAULT NULL,
  `notes` mediumtext DEFAULT NULL,
  `hsn_code` mediumtext DEFAULT NULL,
  `round_off` mediumtext DEFAULT NULL,
  `bill_total` mediumtext DEFAULT NULL,
  `splitup_tax` mediumtext DEFAULT NULL,
  `splitup_quantity` mediumtext DEFAULT NULL,
  `splitup_amount` mediumtext DEFAULT NULL,
  `splitup_tax_amount` mediumtext DEFAULT NULL,
  `splitup_hsn_code` mediumtext DEFAULT NULL,
  `gst_option` mediumtext DEFAULT NULL,
  `tax_option` mediumtext DEFAULT NULL,
  `tax_type` mediumtext DEFAULT NULL,
  `overall_tax` mediumtext DEFAULT NULL,
  `final_price` mediumtext DEFAULT NULL,
  `product_tax` mediumtext DEFAULT NULL,
  `product_tax_value` mediumtext DEFAULT NULL,
  `deleted` int(100) DEFAULT 0,
  `cancelled` int(100) DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



CREATE TABLE `eswari_traders_bank` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `created_date_time` datetime DEFAULT NULL,
  `updated_date_time` datetime DEFAULT NULL,
  `creator` mediumtext DEFAULT NULL,
  `creator_name` mediumtext DEFAULT NULL,
  `bill_company_id` mediumtext DEFAULT NULL,
  `bank_id` mediumtext DEFAULT NULL,
  `account_name` mediumtext DEFAULT NULL,
  `account_number` mediumtext DEFAULT NULL,
  `bank_name` mediumtext DEFAULT NULL,
  `ifsc_code` mediumtext DEFAULT NULL,
  `account_type` mediumtext DEFAULT NULL,
  `bank_name_account_number` mediumtext DEFAULT NULL,
  `branch` mediumtext DEFAULT NULL,
  `payment_mode_id` mediumtext DEFAULT NULL,
  `deleted` int(100) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


INSERT INTO eswari_traders_bank (id, created_date_time, updated_date_time, creator, creator_name, bill_company_id, bank_id, account_name, account_number, bank_name, ifsc_code, account_type, bank_name_account_number, branch, payment_mode_id, deleted) VALUES ('1','2026-03-07 18:27:02','2026-03-07 18:27:02','Z8cBZ3pB085303050b000750090357570200685450','Z8cBZ3pB6b165a45565641115845011e','Z8cBZ3pB545356045105010304500054570d6f0503','Z8cBZ3pB085303050b000750090156530706685450','Z8cBZ3pB7d1744574b59','Z8cBZ3pB015c07050e050d5f0e0f53510f020f53','Z8cBZ3pB6b267a','NULL','NULL','Z8cBZ3pB6b267a1611090d520a00515c0e030f53545b06010148','Z8cBZ3pB6b0d45575251460f','Z8cBZ3pB085303050b000750090155570403685450','0');


CREATE TABLE `eswari_traders_company` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `created_date_time` datetime DEFAULT NULL,
  `updated_date_time` datetime DEFAULT NULL,
  `creator` mediumtext DEFAULT NULL,
  `creator_name` mediumtext DEFAULT NULL,
  `company_id` mediumtext DEFAULT NULL,
  `name` mediumtext DEFAULT NULL,
  `lower_case_name` mediumtext DEFAULT NULL,
  `email` mediumtext DEFAULT NULL,
  `address` mediumtext DEFAULT NULL,
  `state` mediumtext DEFAULT NULL,
  `district` mediumtext DEFAULT NULL,
  `city` mediumtext DEFAULT NULL,
  `others_city` mediumtext DEFAULT NULL,
  `pincode` mediumtext DEFAULT NULL,
  `gst_number` mediumtext DEFAULT NULL,
  `mobile_number` mediumtext DEFAULT NULL,
  `company_details` mediumtext DEFAULT NULL,
  `logo` mediumtext DEFAULT NULL,
  `watermark` mediumtext DEFAULT NULL,
  `primary_company` int(100) NOT NULL DEFAULT 0,
  `deleted` int(100) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


INSERT INTO eswari_traders_company (id, created_date_time, updated_date_time, creator, creator_name, company_id, name, lower_case_name, email, address, state, district, city, others_city, pincode, gst_number, mobile_number, company_details, logo, watermark, primary_company, deleted) VALUES ('1','2026-02-10 17:51:55','2026-03-09 10:33:46','Z8cBZ3pB555a5604510501030454045753016f0503','Z8cBZ3pB6b165a45565641115845011e','Z8cBZ3pB545356045105010304500054570d6f0503','Z8cBZ3pB7d1744574b5915324b5600014547','Z8cBZ3pB5d1744574b5915124b5600014547','NULL','Z8cBZ3pB5617595d5154530c51530e0c50','Z8cBZ3pB6c055e5f55107b075d42','NULL','NULL','NULL','NULL','Z8cBZ3pB0b5772756176665509035321066e6f','Z8cBZ3pB0154070e0c08005e0c00','Z8cBZ3pB7d1744574b5915324b56000145471340450d43535d0905045f5b050b5d0113411c30525b505c152858531140131017290e01595553415b5b050759540d530f500f4017121977663219790b440d1404572020687f655251560276503b6d','NULL','watermark_12_02_2026_03_01_26.jpeg','1','0');


CREATE TABLE `eswari_traders_estimate` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `created_date_time` datetime DEFAULT NULL,
  `updated_date_time` datetime DEFAULT NULL,
  `creator` mediumtext DEFAULT NULL,
  `creator_name` mediumtext DEFAULT NULL,
  `bill_company_id` mediumtext DEFAULT NULL,
  `estimate_id` mediumtext DEFAULT NULL,
  `estimate_number` mediumtext DEFAULT NULL,
  `estimate_date` mediumtext DEFAULT NULL,
  `party_id` mediumtext DEFAULT NULL,
  `party_name` mediumtext DEFAULT NULL,
  `party_mobile_number` mediumtext DEFAULT NULL,
  `party_name_mobile_city` mediumtext DEFAULT NULL,
  `party_details` mediumtext DEFAULT NULL,
  `product_id` mediumtext DEFAULT NULL,
  `product_name` mediumtext DEFAULT NULL,
  `unit_id` mediumtext DEFAULT NULL,
  `unit_name` mediumtext DEFAULT NULL,
  `size_id` mediumtext DEFAULT NULL,
  `size_name` mediumtext DEFAULT NULL,
  `quantity` mediumtext DEFAULT NULL,
  `rate` mediumtext DEFAULT NULL,
  `amount` mediumtext DEFAULT NULL,
  `sub_total` mediumtext DEFAULT NULL,
  `discount` mediumtext DEFAULT NULL,
  `discount_name` mediumtext DEFAULT NULL,
  `discount_value` mediumtext DEFAULT NULL,
  `discounted_total` mediumtext DEFAULT NULL,
  `extra_charges` mediumtext DEFAULT NULL,
  `extra_charges_name` mediumtext DEFAULT NULL,
  `extra_charges_value` mediumtext DEFAULT NULL,
  `extra_charges_total` mediumtext DEFAULT NULL,
  `extra_charges_tax` mediumtext DEFAULT NULL,
  `company_state` mediumtext DEFAULT NULL,
  `party_state` mediumtext DEFAULT NULL,
  `taxable_value` mediumtext DEFAULT NULL,
  `cgst_value` mediumtext DEFAULT NULL,
  `sgst_value` mediumtext DEFAULT NULL,
  `igst_value` mediumtext DEFAULT NULL,
  `total_tax_value` mediumtext DEFAULT NULL,
  `total_amount` mediumtext DEFAULT NULL,
  `total_quantity` mediumtext DEFAULT NULL,
  `description` mediumtext DEFAULT NULL,
  `notes` mediumtext DEFAULT NULL,
  `hsn_code` mediumtext DEFAULT NULL,
  `round_off` mediumtext DEFAULT NULL,
  `bill_total` mediumtext DEFAULT NULL,
  `splitup_tax` mediumtext DEFAULT NULL,
  `splitup_quantity` mediumtext DEFAULT NULL,
  `splitup_amount` mediumtext DEFAULT NULL,
  `splitup_tax_amount` mediumtext DEFAULT NULL,
  `splitup_hsn_code` mediumtext DEFAULT NULL,
  `gst_option` mediumtext DEFAULT NULL,
  `tax_option` mediumtext DEFAULT NULL,
  `tax_type` mediumtext DEFAULT NULL,
  `overall_tax` mediumtext DEFAULT NULL,
  `final_price` mediumtext DEFAULT NULL,
  `product_tax` mediumtext DEFAULT NULL,
  `product_tax_value` mediumtext DEFAULT NULL,
  `order_form_id` mediumtext DEFAULT NULL,
  `converted` int(11) NOT NULL DEFAULT 0,
  `conversion_id` mediumtext DEFAULT NULL,
  `conversion_number` mediumtext DEFAULT NULL,
  `deleted` int(100) DEFAULT 0,
  `cancelled` int(100) DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


INSERT INTO eswari_traders_estimate (id, created_date_time, updated_date_time, creator, creator_name, bill_company_id, estimate_id, estimate_number, estimate_date, party_id, party_name, party_mobile_number, party_name_mobile_city, party_details, product_id, product_name, unit_id, unit_name, size_id, size_name, quantity, rate, amount, sub_total, discount, discount_name, discount_value, discounted_total, extra_charges, extra_charges_name, extra_charges_value, extra_charges_total, extra_charges_tax, company_state, party_state, taxable_value, cgst_value, sgst_value, igst_value, total_tax_value, total_amount, total_quantity, description, notes, hsn_code, round_off, bill_total, splitup_tax, splitup_quantity, splitup_amount, splitup_tax_amount, splitup_hsn_code, gst_option, tax_option, tax_type, overall_tax, final_price, product_tax, product_tax_value, order_form_id, converted, conversion_id, conversion_number, deleted, cancelled) VALUES ('1','2026-03-09 11:23:08','2026-03-09 15:14:49','Z8cBZ3pB085303050b000750090357570200685450','Z8cBZ3pB6b165a45565641115845011e','Z8cBZ3pB545356045105010304500054570d6f0503','Z8cBZ3pB085d03050b00075008065657070c685450','EST001/25-26','2026-03-09','Z8cBZ3pB085303050b000750090255560306685450','Z8cBZ3pB6b0c525a505e5c','Z8cBZ3pB015c00020e050d510d0f','Z8cBZ3pB6b0c525a505e5c46110e5c570303025c56570810','Z8cBZ3pB6b0c525a505e5c5a5b455a3056595e08412d515d435d03100b7e0e035c0a524502440a0e0a0402530100505c','Z8cBZ3pB085d03050b000750080750550207685450','Z8cBZ3pB6f055f5a1973540a5c59000545','Z8cBZ3pB085d03050b0007500807575d070c685453','Z8cBZ3pB710a505e5c43','Z8cBZ3pB085303050b00075009015556050d685453','Z8cBZ3pB09564b0701','50','10.00','500','500','NULL','NULL','NULL','500','NULL','NULL','NULL','500','0','Z8cBZ3pB6c055e5f55107b075d42','Z8cBZ3pB6c055e5f55107b075d42','500','45.00','45.00','0','90.00','590.00','50','','NULL','','0','590.00','18','50','500.00','90','NULL','1','1','2','18%','10.00','NULL','NULL','NULL','0','','','0','0');


CREATE TABLE `eswari_traders_invoice` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `created_date_time` datetime DEFAULT NULL,
  `updated_date_time` datetime DEFAULT NULL,
  `creator` mediumtext DEFAULT NULL,
  `creator_name` mediumtext DEFAULT NULL,
  `bill_company_id` mediumtext DEFAULT NULL,
  `invoice_id` mediumtext DEFAULT NULL,
  `invoice_number` mediumtext DEFAULT NULL,
  `invoice_date` mediumtext DEFAULT NULL,
  `party_id` mediumtext DEFAULT NULL,
  `party_name` mediumtext DEFAULT NULL,
  `party_mobile_number` mediumtext DEFAULT NULL,
  `party_name_mobile_city` mediumtext DEFAULT NULL,
  `party_details` mediumtext DEFAULT NULL,
  `product_id` mediumtext DEFAULT NULL,
  `product_name` mediumtext DEFAULT NULL,
  `unit_id` mediumtext DEFAULT NULL,
  `unit_name` mediumtext DEFAULT NULL,
  `size_id` mediumtext DEFAULT NULL,
  `size_name` mediumtext DEFAULT NULL,
  `quantity` mediumtext DEFAULT NULL,
  `rate` mediumtext DEFAULT NULL,
  `amount` mediumtext DEFAULT NULL,
  `sub_total` mediumtext DEFAULT NULL,
  `discount` mediumtext DEFAULT NULL,
  `discount_name` mediumtext DEFAULT NULL,
  `discount_value` mediumtext DEFAULT NULL,
  `discounted_total` mediumtext DEFAULT NULL,
  `extra_charges` mediumtext DEFAULT NULL,
  `extra_charges_name` mediumtext DEFAULT NULL,
  `extra_charges_value` mediumtext DEFAULT NULL,
  `extra_charges_total` mediumtext DEFAULT NULL,
  `extra_charges_tax` mediumtext DEFAULT NULL,
  `company_state` mediumtext DEFAULT NULL,
  `party_state` mediumtext DEFAULT NULL,
  `taxable_value` mediumtext DEFAULT NULL,
  `cgst_value` mediumtext DEFAULT NULL,
  `sgst_value` mediumtext DEFAULT NULL,
  `igst_value` mediumtext DEFAULT NULL,
  `total_tax_value` mediumtext DEFAULT NULL,
  `total_amount` mediumtext DEFAULT NULL,
  `total_quantity` mediumtext DEFAULT NULL,
  `description` mediumtext DEFAULT NULL,
  `notes` mediumtext DEFAULT NULL,
  `hsn_code` mediumtext DEFAULT NULL,
  `round_off` mediumtext DEFAULT NULL,
  `bill_total` mediumtext DEFAULT NULL,
  `splitup_tax` mediumtext DEFAULT NULL,
  `splitup_quantity` mediumtext DEFAULT NULL,
  `splitup_amount` mediumtext DEFAULT NULL,
  `splitup_tax_amount` mediumtext DEFAULT NULL,
  `splitup_hsn_code` mediumtext DEFAULT NULL,
  `gst_option` mediumtext DEFAULT NULL,
  `tax_option` mediumtext DEFAULT NULL,
  `tax_type` mediumtext DEFAULT NULL,
  `overall_tax` mediumtext DEFAULT NULL,
  `final_price` mediumtext DEFAULT NULL,
  `product_tax` mediumtext DEFAULT NULL,
  `product_tax_value` mediumtext DEFAULT NULL,
  `estimate_id` mediumtext DEFAULT NULL,
  `bank_id` mediumtext DEFAULT NULL,
  `deleted` int(100) DEFAULT 0,
  `cancelled` int(100) DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


INSERT INTO eswari_traders_invoice (id, created_date_time, updated_date_time, creator, creator_name, bill_company_id, invoice_id, invoice_number, invoice_date, party_id, party_name, party_mobile_number, party_name_mobile_city, party_details, product_id, product_name, unit_id, unit_name, size_id, size_name, quantity, rate, amount, sub_total, discount, discount_name, discount_value, discounted_total, extra_charges, extra_charges_name, extra_charges_value, extra_charges_total, extra_charges_tax, company_state, party_state, taxable_value, cgst_value, sgst_value, igst_value, total_tax_value, total_amount, total_quantity, description, notes, hsn_code, round_off, bill_total, splitup_tax, splitup_quantity, splitup_amount, splitup_tax_amount, splitup_hsn_code, gst_option, tax_option, tax_type, overall_tax, final_price, product_tax, product_tax_value, estimate_id, bank_id, deleted, cancelled) VALUES ('1','2026-03-09 12:56:38','2026-03-09 13:23:32','Z8cBZ3pB085303050b000750090357570200685450','Z8cBZ3pB6b165a45565641115845011e','Z8cBZ3pB545356045105010304500054570d6f0503','Z8cBZ3pB085d03050b00075008055152040c685450','INV001/25-26','2026-03-09','Z8cBZ3pB085d03050b000750080557560407685452','Z8cBZ3pB7305455f4051','Z8cBZ3pB005d07010c0701510d02','Z8cBZ3pB7305455f4051154e010e505302030353555619','Z8cBZ3pB7305455f405109044b09270b5e595505150c425c1e250811411d485d5714093159095a5a197e54024c0b061609795806080f55190c41595b0104545601510350','Z8cBZ3pB085d03050b000750080750550207685450','Z8cBZ3pB6f055f5a1973540a5c59000545','Z8cBZ3pB085d03050b0007500807575d070c685453','Z8cBZ3pB710a505e5c43','Z8cBZ3pB085303050b00075009015556050d685453','Z8cBZ3pB09564b0701','20','100.00','1695','1695','NULL','NULL','NULL','1695','2%','Z8cBZ3pB7d1c47445810760e5845030144','33.90','1728.9','0','Z8cBZ3pB6c055e5f55107b075d42','Z8cBZ3pB6c055e5f55107b075d42','1728.9','155.60','155.60','0','311.20','2040','20','','NULL','','-0.10','2040','18','20','1695.00','305.1','NULL','1','2','2','18%','84.75','NULL','NULL','NULL','Z8cBZ3pB085303050b000750090156530706685450','0','0');


CREATE TABLE `eswari_traders_login` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `loginer_name` mediumtext DEFAULT NULL,
  `login_date_time` datetime DEFAULT NULL,
  `logout_date_time` datetime DEFAULT NULL,
  `ip_address` mediumtext DEFAULT NULL,
  `browser` mediumtext DEFAULT NULL,
  `os_detail` mediumtext DEFAULT NULL,
  `type` mediumtext DEFAULT NULL,
  `user_id` mediumtext DEFAULT NULL,
  `deleted` int(100) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


INSERT INTO eswari_traders_login (id, loginer_name, login_date_time, logout_date_time, ip_address, browser, os_detail, type, user_id, deleted) VALUES ('1','Z8cBZ3pB6b165a45565641115845011e171c0e545957050e025659571c','2026-03-07 16:55:48','','127.0.0.1','Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:148.0) Gecko/20100101 Firefox/148.0','Linux srisoftwarez-Latitude-7410 6.17.0-14-generic #14~24.04.1-Ubuntu SMP PREEMPT_DYNAMIC Thu Jan 15 15:52:10 UTC 2 x86_64','Super Admin','Z8cBZ3pB085303050b000750090357570200685450','0');

INSERT INTO eswari_traders_login (id, loginer_name, login_date_time, logout_date_time, ip_address, browser, os_detail, type, user_id, deleted) VALUES ('2','Z8cBZ3pB6b165a45565641115845011e171c0e545957050e025659571c','2026-03-07 18:42:53','','127.0.0.1','Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:148.0) Gecko/20100101 Firefox/148.0','Linux srisoftwarez-Latitude-7410 6.17.0-14-generic #14~24.04.1-Ubuntu SMP PREEMPT_DYNAMIC Thu Jan 15 15:52:10 UTC 2 x86_64','Super Admin','Z8cBZ3pB085303050b000750090357570200685450','0');

INSERT INTO eswari_traders_login (id, loginer_name, login_date_time, logout_date_time, ip_address, browser, os_detail, type, user_id, deleted) VALUES ('3','Z8cBZ3pB6b165a45565641115845011e171c0e545957050e025659571c','2026-03-09 09:22:18','2026-03-09 11:21:46','127.0.0.1','Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:148.0) Gecko/20100101 Firefox/148.0','Linux srisoftwarez-Latitude-7410 6.17.0-14-generic #14~24.04.1-Ubuntu SMP PREEMPT_DYNAMIC Thu Jan 15 15:52:10 UTC 2 x86_64','Super Admin','Z8cBZ3pB085303050b000750090357570200685450','0');

INSERT INTO eswari_traders_login (id, loginer_name, login_date_time, logout_date_time, ip_address, browser, os_detail, type, user_id, deleted) VALUES ('4','Z8cBZ3pB6b165a45565641115845011e171c0e545957050e025659571c','2026-03-09 11:21:52','','127.0.0.1','Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:148.0) Gecko/20100101 Firefox/148.0','Linux srisoftwarez-Latitude-7410 6.17.0-14-generic #14~24.04.1-Ubuntu SMP PREEMPT_DYNAMIC Thu Jan 15 15:52:10 UTC 2 x86_64','Super Admin','Z8cBZ3pB085303050b000750090357570200685450','0');


CREATE TABLE `eswari_traders_order_form` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `created_date_time` datetime DEFAULT NULL,
  `updated_date_time` datetime DEFAULT NULL,
  `creator` mediumtext DEFAULT NULL,
  `creator_name` mediumtext DEFAULT NULL,
  `bill_company_id` mediumtext DEFAULT NULL,
  `order_form_id` mediumtext DEFAULT NULL,
  `order_form_number` mediumtext DEFAULT NULL,
  `order_form_date` mediumtext DEFAULT NULL,
  `party_id` mediumtext DEFAULT NULL,
  `party_name` mediumtext DEFAULT NULL,
  `party_mobile_number` mediumtext DEFAULT NULL,
  `party_name_mobile_city` mediumtext DEFAULT NULL,
  `party_details` mediumtext DEFAULT NULL,
  `product_id` mediumtext DEFAULT NULL,
  `product_name` mediumtext DEFAULT NULL,
  `unit_id` mediumtext DEFAULT NULL,
  `unit_name` mediumtext DEFAULT NULL,
  `size_id` mediumtext DEFAULT NULL,
  `size_name` mediumtext DEFAULT NULL,
  `quantity` mediumtext DEFAULT NULL,
  `rate` mediumtext DEFAULT NULL,
  `amount` mediumtext DEFAULT NULL,
  `hsn_code` mediumtext DEFAULT NULL,
  `total_amount` mediumtext DEFAULT NULL,
  `total_quantity` mediumtext DEFAULT NULL,
  `description` mediumtext DEFAULT NULL,
  `notes` mediumtext DEFAULT NULL,
  `converted` int(11) NOT NULL DEFAULT 0,
  `conversion_id` mediumtext DEFAULT NULL,
  `conversion_number` mediumtext DEFAULT NULL,
  `deleted` int(100) DEFAULT 0,
  `cancelled` int(100) DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



CREATE TABLE `eswari_traders_party` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `created_date_time` datetime DEFAULT NULL,
  `updated_date_time` datetime DEFAULT NULL,
  `creator` mediumtext DEFAULT NULL,
  `creator_name` mediumtext DEFAULT NULL,
  `bill_company_id` mediumtext DEFAULT NULL,
  `party_id` mediumtext DEFAULT NULL,
  `party_name` mediumtext DEFAULT NULL,
  `lower_case_name` mediumtext DEFAULT NULL,
  `address` mediumtext DEFAULT NULL,
  `city` mediumtext DEFAULT NULL,
  `district` mediumtext DEFAULT NULL,
  `state` mediumtext DEFAULT NULL,
  `pincode` mediumtext DEFAULT NULL,
  `mobile_number` mediumtext DEFAULT NULL,
  `others_city` mediumtext DEFAULT NULL,
  `party_details` mediumtext DEFAULT NULL,
  `name_mobile_city` mediumtext DEFAULT NULL,
  `identification` mediumtext DEFAULT NULL,
  `opening_balance` mediumtext DEFAULT NULL,
  `opening_balance_type` mediumtext DEFAULT NULL,
  `email` mediumtext DEFAULT NULL,
  `gst_number` mediumtext DEFAULT NULL,
  `party_type` int(11) NOT NULL DEFAULT 0,
  `deleted` int(100) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


INSERT INTO eswari_traders_party (id, created_date_time, updated_date_time, creator, creator_name, bill_company_id, party_id, party_name, lower_case_name, address, city, district, state, pincode, mobile_number, others_city, party_details, name_mobile_city, identification, opening_balance, opening_balance_type, email, gst_number, party_type, deleted) VALUES ('1','2026-03-07 17:12:42','2026-03-09 11:44:43','Z8cBZ3pB085303050b000750090357570200685450','Z8cBZ3pB6b165a45565641115845011e','Z8cBZ3pB545356045105010304500054570d6f0503','Z8cBZ3pB085303050b000750090255560306685450','Z8cBZ3pB6b0c525a505e5c','Z8cBZ3pB4b0c525a505e5c','NULL','NULL','NULL','Z8cBZ3pB6c055e5f55107b075d42','NULL','Z8cBZ3pB015c00020e050d510d0f','','Z8cBZ3pB6b0c525a505e5c5a5b455a3056595e08412d515d435d03100b7e0e035c0a524502440a0e0a0402530100505c','Z8cBZ3pB6b0c525a505e5c46110e5c570303025c56570810','','5000','Credit','','NULL','3','0');

INSERT INTO eswari_traders_party (id, created_date_time, updated_date_time, creator, creator_name, bill_company_id, party_id, party_name, lower_case_name, address, city, district, state, pincode, mobile_number, others_city, party_details, name_mobile_city, identification, opening_balance, opening_balance_type, email, gst_number, party_type, deleted) VALUES ('2','2026-03-09 11:28:25','2026-03-09 11:28:25','Z8cBZ3pB085303050b000750090357570200685450','Z8cBZ3pB6b165a45565641115845011e','Z8cBZ3pB545356045105010304500054570d6f0503','Z8cBZ3pB085d03050b0007500806565c0501685453','Z8cBZ3pB6a05455f','Z8cBZ3pB4a05455f','NULL','NULL','NULL','Z8cBZ3pB730141575551','NULL','Z8cBZ3pB0057070f010406510e0f','','Z8cBZ3pB6a05455f05524758725216055b550b06135d7d5654080d071509415906520e5d0c57040101','Z8cBZ3pB6a05455f19180d550d0e5c500403005c48','','','','','NULL','1','0');

INSERT INTO eswari_traders_party (id, created_date_time, updated_date_time, creator, creator_name, bill_company_id, party_id, party_name, lower_case_name, address, city, district, state, pincode, mobile_number, others_city, party_details, name_mobile_city, identification, opening_balance, opening_balance_type, email, gst_number, party_type, deleted) VALUES ('3','2026-03-09 12:32:33','2026-03-09 12:32:33','Z8cBZ3pB085303050b000750090357570200685450','Z8cBZ3pB6b165a45565641115845011e','Z8cBZ3pB545356045105010304500054570d6f0503','Z8cBZ3pB085d03050b000750080557560407685452','Z8cBZ3pB7305455f4051','Z8cBZ3pB5305455f4051','NULL','NULL','Z8cBZ3pB7b0b5a5b5b5141094b52','Z8cBZ3pB6c055e5f55107b075d42','Z8cBZ3pB0e5605070b03','Z8cBZ3pB005d07010c0701510d02','','Z8cBZ3pB7305455f405109044b09270b5e595505150c425c1e250811411d485d5714093159095a5a197e54024c0b061609795806080f55190c41595b0104545601510350','Z8cBZ3pB7305455f4051154e010e505302030353555619','','','','','NULL','2','0');

INSERT INTO eswari_traders_party (id, created_date_time, updated_date_time, creator, creator_name, bill_company_id, party_id, party_name, lower_case_name, address, city, district, state, pincode, mobile_number, others_city, party_details, name_mobile_city, identification, opening_balance, opening_balance_type, email, gst_number, party_type, deleted) VALUES ('4','2026-03-09 13:06:30','2026-03-09 13:06:30','Z8cBZ3pB085303050b000750090357570200685450','Z8cBZ3pB6b165a45565641115845011e','Z8cBZ3pB545356045105010304500054570d6f0503','Z8cBZ3pB085d03050b000750090654520404685455','Z8cBZ3pB6805455f4d584707','Z8cBZ3pB4805455f4d584707','NULL','NULL','NULL','Z8cBZ3pB6c055e5f55107b075d42','NULL','Z8cBZ3pB005707010e0400500e01','','Z8cBZ3pB6805455f4d5847070555165a63555a0d0d437e5852145d00470d2c0e570f5b00185e130e0a0402510d02525301','Z8cBZ3pB6805455f4d584707191f5c57030300505455070f1f','','','','','NULL','3','0');


CREATE TABLE `eswari_traders_payment` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `created_date_time` datetime DEFAULT NULL,
  `updated_date_time` datetime DEFAULT NULL,
  `creator` mediumtext DEFAULT NULL,
  `creator_name` mediumtext DEFAULT NULL,
  `bill_company_id` mediumtext DEFAULT NULL,
  `bill_id` mediumtext DEFAULT NULL,
  `bill_number` mediumtext DEFAULT NULL,
  `bill_date` date DEFAULT NULL,
  `bill_type` mediumtext DEFAULT NULL,
  `party_id` mediumtext DEFAULT NULL,
  `party_name` mediumtext DEFAULT NULL,
  `party_type` mediumtext DEFAULT NULL,
  `bank_id` mediumtext DEFAULT NULL,
  `bank_name` mediumtext DEFAULT NULL,
  `payment_mode_id` mediumtext DEFAULT NULL,
  `payment_mode_name` mediumtext DEFAULT NULL,
  `opening_balance` mediumtext DEFAULT NULL,
  `opening_balance_type` mediumtext DEFAULT NULL,
  `credit` decimal(15,2) DEFAULT 0.00,
  `debit` decimal(15,2) DEFAULT 0.00,
  `deleted` int(100) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;


INSERT INTO eswari_traders_payment (id, created_date_time, updated_date_time, creator, creator_name, bill_company_id, bill_id, bill_number, bill_date, bill_type, party_id, party_name, party_type, bank_id, bank_name, payment_mode_id, payment_mode_name, opening_balance, opening_balance_type, credit, debit, deleted) VALUES ('1','2026-03-09 10:01:47','2026-03-09 11:44:43','Z8cBZ3pB085303050b000750090357570200685450','Z8cBZ3pB6b165a45565641115845011e','Z8cBZ3pB545356045105010304500054570d6f0503','Z8cBZ3pB085303050b000750090255560306685450','NULL','1970-01-01','Opening Balance','Z8cBZ3pB085303050b000750090255560306685450','Z8cBZ3pB6b0c525a505e5c','3','NULL','NULL','NULL','NULL','5000','Credit','0.00','0.00','0');

INSERT INTO eswari_traders_payment (id, created_date_time, updated_date_time, creator, creator_name, bill_company_id, bill_id, bill_number, bill_date, bill_type, party_id, party_name, party_type, bank_id, bank_name, payment_mode_id, payment_mode_name, opening_balance, opening_balance_type, credit, debit, deleted) VALUES ('2','2026-03-09 10:02:43','2026-03-09 10:02:43','Z8cBZ3pB085303050b000750090357570200685450','Z8cBZ3pB6b165a45565641115845011e','Z8cBZ3pB545356045105010304500054570d6f0503','Z8cBZ3pB085d03050b000750080754560307685450','001/25-26','2026-03-09','Voucher','Z8cBZ3pB085303050b000750090255560306685450','Z8cBZ3pB6b0c525a505e5c','3','Z8cBZ3pB085303050b000750090156530706685450','Z8cBZ3pB6b267a','Z8cBZ3pB085303050b000750090155570403685450','Gpay','0','NULL','0.00','1000.00','0');

INSERT INTO eswari_traders_payment (id, created_date_time, updated_date_time, creator, creator_name, bill_company_id, bill_id, bill_number, bill_date, bill_type, party_id, party_name, party_type, bank_id, bank_name, payment_mode_id, payment_mode_name, opening_balance, opening_balance_type, credit, debit, deleted) VALUES ('3','2026-03-09 10:12:46','2026-03-09 10:12:46','Z8cBZ3pB085303050b000750090357570200685450','Z8cBZ3pB6b165a45565641115845011e','Z8cBZ3pB545356045105010304500054570d6f0503','Z8cBZ3pB085d03050b000750080755560302685450','001/25-26','2026-03-09','Receipt','Z8cBZ3pB085303050b000750090255560306685450','Z8cBZ3pB6b0c525a505e5c','3','NULL','NULL','Z8cBZ3pB085303050b0007500901565c0407685453','Phone Pay','0','NULL','1500.00','0.00','0');

INSERT INTO eswari_traders_payment (id, created_date_time, updated_date_time, creator, creator_name, bill_company_id, bill_id, bill_number, bill_date, bill_type, party_id, party_name, party_type, bank_id, bank_name, payment_mode_id, payment_mode_name, opening_balance, opening_balance_type, credit, debit, deleted) VALUES ('4','2026-03-09 11:45:32','2026-03-09 15:14:49','Z8cBZ3pB085303050b000750090357570200685450','Z8cBZ3pB6b165a45565641115845011e','Z8cBZ3pB545356045105010304500054570d6f0503','Z8cBZ3pB085d03050b00075008065657070c685450','EST001/25-26','2026-03-09','Estimate','Z8cBZ3pB085303050b000750090255560306685450','Z8cBZ3pB6b0c525a505e5c','3','NULL','NULL','NULL','NULL','NULL','NULL','0.00','590.00','0');

INSERT INTO eswari_traders_payment (id, created_date_time, updated_date_time, creator, creator_name, bill_company_id, bill_id, bill_number, bill_date, bill_type, party_id, party_name, party_type, bank_id, bank_name, payment_mode_id, payment_mode_name, opening_balance, opening_balance_type, credit, debit, deleted) VALUES ('5','2026-03-09 12:56:38','2026-03-09 13:23:32','Z8cBZ3pB085303050b000750090357570200685450','Z8cBZ3pB6b165a45565641115845011e','Z8cBZ3pB545356045105010304500054570d6f0503','Z8cBZ3pB085d03050b00075008055152040c685450','INV001/25-26','2026-03-09','Invoice','Z8cBZ3pB085d03050b000750080557560407685452','Z8cBZ3pB7305455f4051','2','NULL','NULL','NULL','NULL','NULL','NULL','0.00','2040.00','0');

INSERT INTO eswari_traders_payment (id, created_date_time, updated_date_time, creator, creator_name, bill_company_id, bill_id, bill_number, bill_date, bill_type, party_id, party_name, party_type, bank_id, bank_name, payment_mode_id, payment_mode_name, opening_balance, opening_balance_type, credit, debit, deleted) VALUES ('6','2026-03-09 13:00:31','2026-03-09 13:00:57','Z8cBZ3pB085303050b000750090357570200685450','Z8cBZ3pB6b165a45565641115845011e','Z8cBZ3pB545356045105010304500054570d6f0503','Z8cBZ3pB085d03050b000750080556540705685450','PR001/25-26','2026-03-09','Purchase','Z8cBZ3pB085d03050b0007500806565c0501685453','Z8cBZ3pB6a05455f','1','NULL','NULL','NULL','NULL','NULL','NULL','1980.00','0.00','0');


CREATE TABLE `eswari_traders_payment_mode` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `created_date_time` datetime DEFAULT NULL,
  `updated_date_time` datetime DEFAULT NULL,
  `creator` mediumtext DEFAULT NULL,
  `creator_name` mediumtext DEFAULT NULL,
  `bill_company_id` mediumtext DEFAULT NULL,
  `payment_mode_id` mediumtext DEFAULT NULL,
  `payment_mode_name` mediumtext DEFAULT NULL,
  `lower_case_name` mediumtext DEFAULT NULL,
  `deleted` int(100) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


INSERT INTO eswari_traders_payment_mode (id, created_date_time, updated_date_time, creator, creator_name, bill_company_id, payment_mode_id, payment_mode_name, lower_case_name, deleted) VALUES ('1','2026-03-07 18:13:37','2026-03-07 18:13:37','Z8cBZ3pB085303050b000750090357570200685450','Z8cBZ3pB6b165a45565641115845011e','Z8cBZ3pB545356045105010304500054570d6f0503','Z8cBZ3pB085303050b000750090155570403685450','Gpay','gpay','0');

INSERT INTO eswari_traders_payment_mode (id, created_date_time, updated_date_time, creator, creator_name, bill_company_id, payment_mode_id, payment_mode_name, lower_case_name, deleted) VALUES ('2','2026-03-07 18:28:33','2026-03-07 18:28:33','Z8cBZ3pB085303050b000750090357570200685450','Z8cBZ3pB6b165a45565641115845011e','Z8cBZ3pB545356045105010304500054570d6f0503','Z8cBZ3pB085303050b0007500901565c0407685453','Phone Pay','phone pay','0');


CREATE TABLE `eswari_traders_product` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `created_date_time` datetime DEFAULT NULL,
  `updated_date_time` datetime DEFAULT NULL,
  `creator` mediumtext DEFAULT NULL,
  `creator_name` mediumtext DEFAULT NULL,
  `bill_company_id` mediumtext DEFAULT NULL,
  `product_id` mediumtext DEFAULT NULL,
  `product_name` mediumtext DEFAULT NULL,
  `lower_case_name` mediumtext DEFAULT NULL,
  `unit_id` mediumtext DEFAULT NULL,
  `unit_name` mediumtext DEFAULT NULL,
  `size_id` mediumtext DEFAULT NULL,
  `size_name` mediumtext DEFAULT NULL,
  `hsn_code` mediumtext DEFAULT NULL,
  `product_tax` mediumtext DEFAULT NULL,
  `description` mediumtext DEFAULT NULL,
  `deleted` int(100) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


INSERT INTO eswari_traders_product (id, created_date_time, updated_date_time, creator, creator_name, bill_company_id, product_id, product_name, lower_case_name, unit_id, unit_name, size_id, size_name, hsn_code, product_tax, description, deleted) VALUES ('1','2026-03-09 10:41:53','2026-03-09 10:41:53','Z8cBZ3pB085303050b000750090357570200685450','Z8cBZ3pB6b165a45565641115845011e','5130394e5545464f575638784e7a41314d6a41794e4441794d7a55314f4638774d513d3d','Z8cBZ3pB085d03050b000750080750550207685450','Z8cBZ3pB6f055f5a1973540a5c59000545','Z8cBZ3pB4f055f5a1953540a5c59000545','Z8cBZ3pB085d03050b0007500807575d070c685453','Z8cBZ3pB710a505e5c43','Z8cBZ3pB085303050b00075009015556050d685453','Z8cBZ3pB09564b0701','NULL','18%','NULL','0');


CREATE TABLE `eswari_traders_purchase` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `created_date_time` datetime DEFAULT NULL,
  `updated_date_time` datetime DEFAULT NULL,
  `creator` mediumtext DEFAULT NULL,
  `creator_name` mediumtext DEFAULT NULL,
  `bill_company_id` mediumtext DEFAULT NULL,
  `purchase_id` mediumtext DEFAULT NULL,
  `purchase_number` mediumtext DEFAULT NULL,
  `purchase_date` mediumtext DEFAULT NULL,
  `party_id` mediumtext DEFAULT NULL,
  `party_name` mediumtext DEFAULT NULL,
  `party_mobile_number` mediumtext DEFAULT NULL,
  `party_name_mobile_city` mediumtext DEFAULT NULL,
  `party_details` mediumtext DEFAULT NULL,
  `product_id` mediumtext DEFAULT NULL,
  `product_name` mediumtext DEFAULT NULL,
  `unit_id` mediumtext DEFAULT NULL,
  `unit_name` mediumtext DEFAULT NULL,
  `size_id` mediumtext DEFAULT NULL,
  `size_name` mediumtext DEFAULT NULL,
  `quantity` mediumtext DEFAULT NULL,
  `rate` mediumtext DEFAULT NULL,
  `amount` mediumtext DEFAULT NULL,
  `sub_total` mediumtext DEFAULT NULL,
  `discount` mediumtext DEFAULT NULL,
  `discount_name` mediumtext DEFAULT NULL,
  `discount_value` mediumtext DEFAULT NULL,
  `discounted_total` mediumtext DEFAULT NULL,
  `extra_charges` mediumtext DEFAULT NULL,
  `extra_charges_name` mediumtext DEFAULT NULL,
  `extra_charges_value` mediumtext DEFAULT NULL,
  `extra_charges_total` mediumtext DEFAULT NULL,
  `extra_charges_tax` mediumtext DEFAULT NULL,
  `company_state` mediumtext DEFAULT NULL,
  `party_state` mediumtext DEFAULT NULL,
  `taxable_value` mediumtext DEFAULT NULL,
  `cgst_value` mediumtext DEFAULT NULL,
  `sgst_value` mediumtext DEFAULT NULL,
  `igst_value` mediumtext DEFAULT NULL,
  `total_tax_value` mediumtext DEFAULT NULL,
  `total_amount` mediumtext DEFAULT NULL,
  `total_quantity` mediumtext DEFAULT NULL,
  `description` mediumtext DEFAULT NULL,
  `notes` mediumtext DEFAULT NULL,
  `hsn_code` mediumtext DEFAULT NULL,
  `round_off` mediumtext DEFAULT NULL,
  `bill_total` mediumtext DEFAULT NULL,
  `splitup_tax` mediumtext DEFAULT NULL,
  `splitup_quantity` mediumtext DEFAULT NULL,
  `splitup_amount` mediumtext DEFAULT NULL,
  `splitup_tax_amount` mediumtext DEFAULT NULL,
  `splitup_hsn_code` mediumtext DEFAULT NULL,
  `gst_option` mediumtext DEFAULT NULL,
  `tax_option` mediumtext DEFAULT NULL,
  `tax_type` mediumtext DEFAULT NULL,
  `overall_tax` mediumtext DEFAULT NULL,
  `final_price` mediumtext DEFAULT NULL,
  `product_tax` mediumtext DEFAULT NULL,
  `product_tax_value` mediumtext DEFAULT NULL,
  `deleted` int(100) DEFAULT 0,
  `cancelled` int(100) DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


INSERT INTO eswari_traders_purchase (id, created_date_time, updated_date_time, creator, creator_name, bill_company_id, purchase_id, purchase_number, purchase_date, party_id, party_name, party_mobile_number, party_name_mobile_city, party_details, product_id, product_name, unit_id, unit_name, size_id, size_name, quantity, rate, amount, sub_total, discount, discount_name, discount_value, discounted_total, extra_charges, extra_charges_name, extra_charges_value, extra_charges_total, extra_charges_tax, company_state, party_state, taxable_value, cgst_value, sgst_value, igst_value, total_tax_value, total_amount, total_quantity, description, notes, hsn_code, round_off, bill_total, splitup_tax, splitup_quantity, splitup_amount, splitup_tax_amount, splitup_hsn_code, gst_option, tax_option, tax_type, overall_tax, final_price, product_tax, product_tax_value, deleted, cancelled) VALUES ('1','2026-03-09 12:20:01','2026-03-09 13:00:57','Z8cBZ3pB085303050b000750090357570200685450','Z8cBZ3pB6b165a45565641115845011e','Z8cBZ3pB545356045105010304500054570d6f0503','Z8cBZ3pB085d03050b000750080556540705685450','PR001/25-26','2026-03-09','Z8cBZ3pB085d03050b0007500806565c0501685453','Z8cBZ3pB6a05455f','Z8cBZ3pB0057070f010406510e0f','Z8cBZ3pB6a05455f19180d550d0e5c500403005c48','Z8cBZ3pB6a05455f05524758725216055b550b06135d7d5654080d071509415906520e5d0c57040101','Z8cBZ3pB085d03050b000750080750550207685450','Z8cBZ3pB6f055f5a1973540a5c59000545','Z8cBZ3pB085d03050b0007500807575d070c685453','Z8cBZ3pB710a505e5c43','Z8cBZ3pB085303050b00075009015556050d685453','Z8cBZ3pB09564b0701','100','20.00','2000','2000','1%','Z8cBZ3pB7d1c47445810710f4a540b115940','20.00','1980','NULL','NULL','NULL','1980','0','Z8cBZ3pB6c055e5f55107b075d42','Z8cBZ3pB730141575551','0','0','0','0','0','1980.00','100','','NULL','','0','1980.00','NULL','NULL','NULL','NULL','NULL','','','','NULL','20.00','','NULL','0','0');


CREATE TABLE `eswari_traders_quotation` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `created_date_time` datetime DEFAULT NULL,
  `updated_date_time` datetime DEFAULT NULL,
  `creator` mediumtext DEFAULT NULL,
  `creator_name` mediumtext DEFAULT NULL,
  `bill_company_id` mediumtext DEFAULT NULL,
  `quotation_id` mediumtext DEFAULT NULL,
  `quotation_number` mediumtext DEFAULT NULL,
  `quotation_date` mediumtext DEFAULT NULL,
  `party_id` mediumtext DEFAULT NULL,
  `party_name` mediumtext DEFAULT NULL,
  `party_mobile_number` mediumtext DEFAULT NULL,
  `party_name_mobile_city` mediumtext DEFAULT NULL,
  `party_details` mediumtext DEFAULT NULL,
  `product_id` mediumtext DEFAULT NULL,
  `product_name` mediumtext DEFAULT NULL,
  `unit_id` mediumtext DEFAULT NULL,
  `unit_name` mediumtext DEFAULT NULL,
  `size_id` mediumtext DEFAULT NULL,
  `size_name` mediumtext DEFAULT NULL,
  `quantity` mediumtext DEFAULT NULL,
  `rate` mediumtext DEFAULT NULL,
  `amount` mediumtext DEFAULT NULL,
  `sub_total` mediumtext DEFAULT NULL,
  `discount` mediumtext DEFAULT NULL,
  `discount_name` mediumtext DEFAULT NULL,
  `discount_value` mediumtext DEFAULT NULL,
  `discounted_total` mediumtext DEFAULT NULL,
  `extra_charges` mediumtext DEFAULT NULL,
  `extra_charges_name` mediumtext DEFAULT NULL,
  `extra_charges_value` mediumtext DEFAULT NULL,
  `extra_charges_total` mediumtext DEFAULT NULL,
  `extra_charges_tax` mediumtext DEFAULT NULL,
  `company_state` mediumtext DEFAULT NULL,
  `party_state` mediumtext DEFAULT NULL,
  `taxable_value` mediumtext DEFAULT NULL,
  `cgst_value` mediumtext DEFAULT NULL,
  `sgst_value` mediumtext DEFAULT NULL,
  `igst_value` mediumtext DEFAULT NULL,
  `total_tax_value` mediumtext DEFAULT NULL,
  `total_amount` mediumtext DEFAULT NULL,
  `total_quantity` mediumtext DEFAULT NULL,
  `description` mediumtext DEFAULT NULL,
  `notes` mediumtext DEFAULT NULL,
  `hsn_code` mediumtext DEFAULT NULL,
  `round_off` mediumtext DEFAULT NULL,
  `bill_total` mediumtext DEFAULT NULL,
  `splitup_tax` mediumtext DEFAULT NULL,
  `splitup_quantity` mediumtext DEFAULT NULL,
  `splitup_amount` mediumtext DEFAULT NULL,
  `splitup_tax_amount` mediumtext DEFAULT NULL,
  `splitup_hsn_code` mediumtext DEFAULT NULL,
  `gst_option` mediumtext DEFAULT NULL,
  `tax_option` mediumtext DEFAULT NULL,
  `tax_type` mediumtext DEFAULT NULL,
  `overall_tax` mediumtext DEFAULT NULL,
  `final_price` mediumtext DEFAULT NULL,
  `product_tax` mediumtext DEFAULT NULL,
  `product_tax_value` mediumtext DEFAULT NULL,
  `deleted` int(100) DEFAULT 0,
  `cancelled` int(100) DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


INSERT INTO eswari_traders_quotation (id, created_date_time, updated_date_time, creator, creator_name, bill_company_id, quotation_id, quotation_number, quotation_date, party_id, party_name, party_mobile_number, party_name_mobile_city, party_details, product_id, product_name, unit_id, unit_name, size_id, size_name, quantity, rate, amount, sub_total, discount, discount_name, discount_value, discounted_total, extra_charges, extra_charges_name, extra_charges_value, extra_charges_total, extra_charges_tax, company_state, party_state, taxable_value, cgst_value, sgst_value, igst_value, total_tax_value, total_amount, total_quantity, description, notes, hsn_code, round_off, bill_total, splitup_tax, splitup_quantity, splitup_amount, splitup_tax_amount, splitup_hsn_code, gst_option, tax_option, tax_type, overall_tax, final_price, product_tax, product_tax_value, deleted, cancelled) VALUES ('1','2026-03-09 12:44:31','2026-03-09 12:44:31','Z8cBZ3pB085303050b000750090357570200685450','Z8cBZ3pB6b165a45565641115845011e','Z8cBZ3pB545356045105010304500054570d6f0503','Z8cBZ3pB085d03050b000750080550500405685450','QUT001/25-26','2026-03-09','Z8cBZ3pB085d03050b000750080557560407685452','Z8cBZ3pB7305455f4051','Z8cBZ3pB005d07010c0701510d02','Z8cBZ3pB7305455f4051154e010e505302030353555619','Z8cBZ3pB7305455f405109044b09270b5e595505150c425c1e250811411d485d5714093159095a5a197e54024c0b061609795806080f55190c41595b0104545601510350','Z8cBZ3pB085d03050b000750080750550207685450','Z8cBZ3pB6f055f5a1973540a5c59000545','Z8cBZ3pB085d03050b0007500807575d070c685453','Z8cBZ3pB710a505e5c43','Z8cBZ3pB085303050b00075009015556050d685453','Z8cBZ3pB09564b0701','50','400','16949','16949','NULL','NULL','NULL','16949','NULL','NULL','NULL','16949','0','Z8cBZ3pB6c055e5f55107b075d42','Z8cBZ3pB6c055e5f55107b075d42','16949','1525.41','1525.41','0','3050.82','20000','50','','NULL','','0.18','20000','18','50','16949.00','3050.82','NULL','1','2','2','18%','338.98','NULL','NULL','0','0');


CREATE TABLE `eswari_traders_receipt` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `created_date_time` datetime DEFAULT NULL,
  `updated_date_time` datetime DEFAULT NULL,
  `creator` mediumtext DEFAULT NULL,
  `creator_name` mediumtext DEFAULT NULL,
  `bill_company_id` mediumtext DEFAULT NULL,
  `receipt_id` mediumtext DEFAULT NULL,
  `receipt_number` mediumtext DEFAULT NULL,
  `receipt_date` date DEFAULT NULL,
  `party_id` mediumtext DEFAULT NULL,
  `party_name` mediumtext DEFAULT NULL,
  `name_mobile_city` mediumtext DEFAULT NULL,
  `party_type` mediumtext DEFAULT NULL,
  `amount` mediumtext DEFAULT NULL,
  `narration` mediumtext DEFAULT NULL,
  `payment_mode_id` mediumtext DEFAULT NULL,
  `payment_mode_name` mediumtext DEFAULT NULL,
  `bank_id` mediumtext DEFAULT NULL,
  `bank_name` mediumtext DEFAULT NULL,
  `total_amount` mediumtext DEFAULT NULL,
  `paid_bills` mediumtext DEFAULT NULL,
  `deleted` int(100) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;


INSERT INTO eswari_traders_receipt (id, created_date_time, updated_date_time, creator, creator_name, bill_company_id, receipt_id, receipt_number, receipt_date, party_id, party_name, name_mobile_city, party_type, amount, narration, payment_mode_id, payment_mode_name, bank_id, bank_name, total_amount, paid_bills, deleted) VALUES ('1','2026-03-09 10:12:46','2026-03-09 10:12:46','Z8cBZ3pB085303050b000750090357570200685450','Z8cBZ3pB6b165a45565641115845011e','Z8cBZ3pB545356045105010304500054570d6f0503','Z8cBZ3pB085d03050b000750080755560302685450','001/25-26','2026-03-09','Z8cBZ3pB085303050b000750090255560306685450','Z8cBZ3pB6b0c525a505e5c','Z8cBZ3pB6b0c525a505e5c46110e5c570303025c56570810','3','1500','Z8cBZ3pB6a015053504041','Z8cBZ3pB085303050b0007500901565c0407685453','Phone Pay','','','1500','','0');


CREATE TABLE `eswari_traders_role` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `created_date_time` datetime DEFAULT NULL,
  `updated_date_time` datetime DEFAULT NULL,
  `creator` mediumtext DEFAULT NULL,
  `creator_name` mediumtext DEFAULT NULL,
  `bill_company_id` mediumtext DEFAULT NULL,
  `role_id` mediumtext DEFAULT NULL,
  `role_name` mediumtext DEFAULT NULL,
  `lower_case_name` mediumtext DEFAULT NULL,
  `type` mediumtext DEFAULT NULL,
  `admin` mediumtext DEFAULT NULL,
  `access_pages` mediumtext DEFAULT NULL,
  `access_page_actions` mediumtext DEFAULT NULL,
  `deleted` int(100) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


INSERT INTO eswari_traders_role (id, created_date_time, updated_date_time, creator, creator_name, bill_company_id, role_id, role_name, lower_case_name, type, admin, access_pages, access_page_actions, deleted) VALUES ('1','2026-03-07 16:48:09','2026-03-07 16:48:09','Z8cBZ3pB085303050b000750090357570200685450','Z8cBZ3pB6b165a45565641115845011e','Z8cBZ3pB545356045105010304500054570d6f0503','Z8cBZ3pB085303050b0007500903505c070d685450','Z8cBZ3pB6b1143534b107402545e0a','Z8cBZ3pB4b1143534b105402545e0a','Super Admin','1','','','0');


CREATE TABLE `eswari_traders_role_permission` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `created_date_time` datetime DEFAULT NULL,
  `creator` mediumtext DEFAULT NULL,
  `creator_name` mediumtext DEFAULT NULL,
  `bill_company_id` mediumtext DEFAULT NULL,
  `role_permission_id` mediumtext DEFAULT NULL,
  `role_id` mediumtext DEFAULT NULL,
  `module` mediumtext DEFAULT NULL,
  `module_actions` mediumtext DEFAULT NULL,
  `deleted` int(100) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



CREATE TABLE `eswari_traders_size` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `created_date_time` datetime DEFAULT NULL,
  `updated_date_time` datetime DEFAULT NULL,
  `creator` mediumtext DEFAULT NULL,
  `creator_name` mediumtext DEFAULT NULL,
  `bill_company_id` mediumtext DEFAULT NULL,
  `size_id` mediumtext DEFAULT NULL,
  `size_name` mediumtext DEFAULT NULL,
  `lower_case_name` mediumtext DEFAULT NULL,
  `deleted` int(100) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


INSERT INTO eswari_traders_size (id, created_date_time, updated_date_time, creator, creator_name, bill_company_id, size_id, size_name, lower_case_name, deleted) VALUES ('1','2026-03-07 18:12:29','2026-03-07 18:12:29','Z8cBZ3pB085303050b000750090357570200685450','Z8cBZ3pB6b165a45565641115845011e','Z8cBZ3pB545356045105010304500054570d6f0503','Z8cBZ3pB085303050b00075009015556050d685450','Z8cBZ3pB0954136e190205','10 x 20','0');

INSERT INTO eswari_traders_size (id, created_date_time, updated_date_time, creator, creator_name, bill_company_id, size_id, size_name, lower_case_name, deleted) VALUES ('2','2026-03-07 18:12:29','2026-03-09 10:41:33','Z8cBZ3pB085303050b000750090357570200685450','Z8cBZ3pB6b165a45565641115845011e','Z8cBZ3pB545356045105010304500054570d6f0503','Z8cBZ3pB085303050b00075009015556050d685453','Z8cBZ3pB09564b0701','12x18','0');


CREATE TABLE `eswari_traders_stock` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `created_date_time` datetime DEFAULT NULL,
  `updated_date_time` datetime DEFAULT NULL,
  `creator` mediumtext DEFAULT NULL,
  `creator_name` mediumtext DEFAULT NULL,
  `bill_company_id` mediumtext DEFAULT NULL,
  `stock_date` date DEFAULT NULL,
  `party_id` mediumtext DEFAULT NULL,
  `unit_id` mediumtext DEFAULT NULL,
  `unit_name` mediumtext DEFAULT NULL,
  `size_id` mediumtext DEFAULT NULL,
  `size_name` mediumtext DEFAULT NULL,
  `product_id` mediumtext DEFAULT NULL,
  `product_name` mediumtext DEFAULT NULL,
  `inward_unit` mediumtext DEFAULT NULL,
  `outward_unit` mediumtext DEFAULT NULL,
  `stock_type` mediumtext DEFAULT NULL,
  `stock_action` mediumtext DEFAULT NULL,
  `bill_unique_id` mediumtext DEFAULT NULL,
  `bill_unique_number` mediumtext DEFAULT NULL,
  `remarks` mediumtext DEFAULT NULL,
  `deleted` int(100) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



CREATE TABLE `eswari_traders_unit` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `created_date_time` datetime DEFAULT NULL,
  `updated_date_time` datetime DEFAULT NULL,
  `creator` mediumtext DEFAULT NULL,
  `creator_name` mediumtext DEFAULT NULL,
  `bill_company_id` mediumtext DEFAULT NULL,
  `unit_id` mediumtext DEFAULT NULL,
  `unit_name` mediumtext DEFAULT NULL,
  `lower_case_name` mediumtext DEFAULT NULL,
  `deleted` int(100) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


INSERT INTO eswari_traders_unit (id, created_date_time, updated_date_time, creator, creator_name, bill_company_id, unit_id, unit_name, lower_case_name, deleted) VALUES ('1','2026-03-09 10:39:08','2026-03-09 10:39:08','Z8cBZ3pB085303050b000750090357570200685450','Z8cBZ3pB6b165a45565641115845011e','5130394e5545464f575638784e7a41314d6a41794e4441794d7a55314f4638774d513d3d','Z8cBZ3pB085d03050b0007500807575d070c685450','Z8cBZ3pB680740','pcs','0');

INSERT INTO eswari_traders_unit (id, created_date_time, updated_date_time, creator, creator_name, bill_company_id, unit_id, unit_name, lower_case_name, deleted) VALUES ('2','2026-03-09 10:39:08','2026-03-09 10:40:12','Z8cBZ3pB085303050b000750090357570200685450','Z8cBZ3pB6b165a45565641115845011e','5130394e5545464f575638784e7a41314d6a41794e4441794d7a55314f4638774d513d3d','Z8cBZ3pB085d03050b0007500807575d070c685453','Z8cBZ3pB710a505e5c43','inches','0');

INSERT INTO eswari_traders_unit (id, created_date_time, updated_date_time, creator, creator_name, bill_company_id, unit_id, unit_name, lower_case_name, deleted) VALUES ('3','2026-03-09 10:40:38','2026-03-09 13:04:18','Z8cBZ3pB085303050b000750090357570200685450','Z8cBZ3pB6b165a45565641115845011e','5130394e5545464f575638784e7a41314d6a41794e4441794d7a55314f4638774d513d3d','Z8cBZ3pB085d03050b00075008075054040c685452','Z8cBZ3pB680f47','pkt','0');

INSERT INTO eswari_traders_unit (id, created_date_time, updated_date_time, creator, creator_name, bill_company_id, unit_id, unit_name, lower_case_name, deleted) VALUES ('4','2026-03-09 10:40:38','2026-03-09 13:04:10','Z8cBZ3pB085303050b000750090357570200685450','Z8cBZ3pB6b165a45565641115845011e','5130394e5545464f575638784e7a41314d6a41794e4441794d7a55314f4638774d513d3d','Z8cBZ3pB085d03050b00075008075054040c685455','Z8cBZ3pB7a115d525555','bundle','0');


CREATE TABLE `eswari_traders_user` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `created_date_time` datetime DEFAULT NULL,
  `updated_date_time` datetime DEFAULT NULL,
  `creator` mediumtext DEFAULT NULL,
  `creator_name` mediumtext DEFAULT NULL,
  `user_id` mediumtext DEFAULT NULL,
  `name` mediumtext DEFAULT NULL,
  `mobile_number` mediumtext DEFAULT NULL,
  `name_mobile` mediumtext DEFAULT NULL,
  `role_id` mediumtext DEFAULT NULL,
  `login_id` mediumtext DEFAULT NULL,
  `lower_case_login_id` mediumtext DEFAULT NULL,
  `password` mediumtext DEFAULT NULL,
  `admin` int(100) NOT NULL DEFAULT 0,
  `type` mediumtext DEFAULT NULL,
  `deleted` int(100) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


INSERT INTO eswari_traders_user (id, created_date_time, updated_date_time, creator, creator_name, user_id, name, mobile_number, name_mobile, role_id, login_id, lower_case_login_id, password, admin, type, deleted) VALUES ('1','2026-03-07 16:33:54','2026-03-07 16:33:54','','Z8cBZ3pB6b165a45565641115845011e','Z8cBZ3pB085303050b000750090357570200685450','Z8cBZ3pB6b165a45565641115845011e','Z8cBZ3pB01540b020c0701510102','Z8cBZ3pB6b165a45565641115845011e171c0e545957050e025659571c','NULL','Z8cBZ3pB6b165a45565641115845011e','Z8cBZ3pB4b165a45565641115845011e','Z8cBZ3pB79005e5f5701075579','1','Super Admin','0');


CREATE TABLE `eswari_traders_voucher` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `created_date_time` datetime DEFAULT NULL,
  `updated_date_time` datetime DEFAULT NULL,
  `creator` mediumtext DEFAULT NULL,
  `creator_name` mediumtext DEFAULT NULL,
  `bill_company_id` mediumtext DEFAULT NULL,
  `voucher_id` mediumtext DEFAULT NULL,
  `voucher_number` mediumtext DEFAULT NULL,
  `voucher_date` date DEFAULT NULL,
  `party_id` mediumtext DEFAULT NULL,
  `party_name` mediumtext DEFAULT NULL,
  `name_mobile_city` mediumtext DEFAULT NULL,
  `party_type` mediumtext DEFAULT NULL,
  `amount` mediumtext DEFAULT NULL,
  `narration` mediumtext DEFAULT NULL,
  `payment_mode_id` mediumtext DEFAULT NULL,
  `payment_mode_name` mediumtext DEFAULT NULL,
  `bank_id` mediumtext DEFAULT NULL,
  `bank_name` mediumtext DEFAULT NULL,
  `total_amount` decimal(15,2) NOT NULL DEFAULT 0.00,
  `paid_bills` mediumtext DEFAULT NULL,
  `deleted` int(100) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;


INSERT INTO eswari_traders_voucher (id, created_date_time, updated_date_time, creator, creator_name, bill_company_id, voucher_id, voucher_number, voucher_date, party_id, party_name, name_mobile_city, party_type, amount, narration, payment_mode_id, payment_mode_name, bank_id, bank_name, total_amount, paid_bills, deleted) VALUES ('1','2026-03-09 10:02:43','2026-03-09 10:02:43','Z8cBZ3pB085303050b000750090357570200685450','Z8cBZ3pB6b165a45565641115845011e','Z8cBZ3pB545356045105010304500054570d6f0503','Z8cBZ3pB085d03050b000750080754560307685450','001/25-26','2026-03-09','Z8cBZ3pB085303050b000750090255560306685450','Z8cBZ3pB6b0c525a505e5c','Z8cBZ3pB6b0c525a505e5c46110e5c570303025c56570810','3','1000','Z8cBZ3pB6e0b4655515547','Z8cBZ3pB085303050b000750090155570403685450','Gpay','Z8cBZ3pB085303050b000750090156530706685450','Z8cBZ3pB6b267a','1000.00','','0');

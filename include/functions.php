<?php
	require_once "sanitizer.php"; 	
	require_once "basic_functions.php";
	require_once "creation_functions.php";
	require_once "billing_functions.php";
	require_once "report_functions.php";
	require_once "payment_functions.php";



	$creation_obj = new Creation_functions();
	$basic_obj = new Basic_Functions($creation_obj);

    $creation_obj->initialize($basic_obj);


	$billing_obj = new Billing_functions();
    $billing_obj->initialize($basic_obj);

	$report_obj = new Report_functions();
    $report_obj->initialize($basic_obj);

	$payment_obj = new Payment_Functions();
	$payment_obj->initialize($basic_obj);


	class Functions {
		private $basic_obj; 
		private $creation_obj;
		private $billing_obj;
		private $report_obj;
		private $payment_obj;


		public function __construct(Basic_Functions $basic_obj, Creation_functions $creation_obj, Billing_functions $billing_obj, Report_functions $report_obj, Payment_Functions $payment_obj) {
			$this->basic_obj = $basic_obj; 
			$this->creation_obj = $creation_obj;	
			$this->billing_obj = $billing_obj;	
			$this->report_obj = $report_obj;
			$this->payment_obj = $payment_obj;
		}
	
		// Basic Functions
		public function getProjectTitle() {
			$result = $this->basic_obj->getProjectTitle();
			return $result;
		}
		public function encode_decode($action, $string) {
			$result = $this->basic_obj->encode_decode($action, $string);
			return $result;
		}
		public function generateKey($salt) {
			$result = $this->basic_obj->generateKey($salt);
			return $result;
		}
		public function xorEncrypt($data, $key) {
			$result = $this->basic_obj->xorEncrypt($data, $key);
			return $result;
		}
		public function toHex($input) {
			$result = $this->basic_obj->toHex($input);
			return $result;
		}
		public function fromHex($input) {
			$result = $this->basic_obj->fromHex($input);
			return $result;
		}
		public function generateSalt() {
			$result = $this->basic_obj->generateSalt();
			return $result;
		}
		public function getLastRecordIDFromTable($table) {
			$result = $this->basic_obj->getLastRecordIDFromTable($table);
			return $result;
		}
		public function automate_number($table, $column, $last_insert_id) {
			$result = $this->basic_obj->automate_number($table, $column, $last_insert_id);
			return $result;
		}
		public function InsertSQL($table, $columns, $values, $custom_id, $unique_number, $action) {
			$result = $this->basic_obj->InsertSQL($table, $columns, $values, $custom_id, $unique_number, $action);
			return $result;
		}
		public function UpdateSQL($table, $update_id, $columns, $values, $action) {
			$result = $this->basic_obj->UpdateSQL($table, $update_id, $columns, $values, $action);
			return $result;
		}
		public function add_log($table, $table_unique_id, $query, $action) {
			$result = $this->basic_obj->add_log($table, $table_unique_id, $query, $action);
			return $result;
		}
		public function getTableColumnValue($table, $column, $value, $return_value) {
			$result = $this->basic_obj->getTableColumnValue($table, $column, $value, $return_value);
			return $result;
		}
		public function getCancelledTableColumnValue($table, $column, $value, $return_value) {
			$result = $this->basic_obj->getCancelledTableColumnValue($table, $column, $value, $return_value);
			return $result;
		}
		public function getTableRecords($table, $column, $value, $order) {
			$result = $this->basic_obj->getTableRecords($table, $column, $value, $order);
			return $result;
		}
		public function getQueryRecords($table, $select_query, $params = array()) {
			$result = $this->basic_obj->getQueryRecords($table, $select_query, $params = array());
			return $result;
		}
		public function debugQuery($query, $params) {
			$result = $this->basic_obj->debugQuery($query, $params);
			return $result;
		}
		public function getPDOType($value) {
			$result = $this->basic_obj->getPDOType($value);
			return $result;
		}
		public function parseQueryForParams($query) {
			$result = $this->basic_obj->parseQueryForParams($query);
			return $result;
		}
		public function getAllRecords($table, $column, $value) {
			$result = $this->basic_obj->getAllRecords($table, $column, $value);
			return $result;
		}
		public function getCancelledRecords($table, $column, $value) {
			$result = $this->basic_obj->getCancelledRecords($table, $column, $value);
			return $result;
		}
		public function daily_db_backup() {
			$result = $this->basic_obj->daily_db_backup();
			return $result;
		}
		public function image_directory() {
			$result = $this->basic_obj->image_directory();
			return $result;
		}
		public function temp_image_directory() {
			$result = $this->basic_obj->temp_image_directory();
			return $result;
		}
		public function clear_temp_image_directory() {
			$result = $this->basic_obj->clear_temp_image_directory();
			return $result;
		}
		public function check_user_id_ip_address() {
			$result = $this->basic_obj->check_user_id_ip_address();
			return $result;
		}
		public function checkUser() {
			$result = $this->basic_obj->checkUser();
			return $result;
		}
		public function getDailyReport($from_date, $to_date) {
			$result = $this->basic_obj->getDailyReport($from_date, $to_date);
			return $result;
		}
		public function CheckRoleAccessPage($company_id,$role_id,$permission_module) {
			$result = $this->basic_obj->CheckRoleAccessPage($company_id,$role_id,$permission_module);
			return $result;
		}
		public function accessPageAction($bill_company_id,$role_id,$permission_module) {
			$result = $this->basic_obj->accessPageAction($bill_company_id,$role_id,$permission_module);
			return $result;
		}
		public function numberFormat($number, $decimals) {
			$result = $this->basic_obj->numberFormat($number, $decimals);
			return $result;
		}
		public function sanitize_post() {
			$result = $this->basic_obj->sanitize_post();
			return $result;
		}
		public function getOtherCityList($district) {
			$list = $this->basic_obj->getOtherCityList($district);
			return $list;
		}
		public function BillCompanyDetails($bill_company_id) {
			$bill_company_details = $this->basic_obj->BillCompanyDetails($bill_company_id);
			return $bill_company_details;
		}
		public function CompanyCount(){
			$list = 0;
			$list = $this->basic_obj->CompanyCount();
			return $list;
		}
		public function CheckStaffAccessPage($staff_id, $bill_company_id, $permission_page)  {
			$bill_company_details = $this->basic_obj->CheckStaffAccessPage($staff_id, $bill_company_id, $permission_page) ;
			return $bill_company_details;
		}

		public function CheckUnitAlreadyExists($unit_name) {
			$result = $this->creation_obj->CheckUnitAlreadyExists($unit_name);
			return $result;
		}
		public function getUnitList($row, $rowperpage, $order_column, $order_direction, $search_text) {
			$result = $this->creation_obj->getUnitList($row, $rowperpage, $order_column, $order_direction, $search_text);
			return $result;
		}
		public function GetLinkedCount($table, $creation_id) {
			$count = $this->creation_obj->GetLinkedCount($table, $creation_id);
			return $count;
		}	

		public function getProductList($row, $rowperpage, $order_column, $order_direction, $search_value,$filter_product_id) {
			$result = $this->creation_obj->getProductList($row, $rowperpage, $order_column, $order_direction, $search_value,$filter_product_id);
			return $result;
		}


		public function CustomerMobileExists($mobile_number)
		{
			$result = $this->creation_obj->CustomerMobileExists($mobile_number);
			return $result;
		}

		public function CombineAndSumUp ($myArray)
		{
			$result = $this->creation_obj->CombineAndSumUp ($myArray);
			return $result;
		}	

		
		public function GetRoleLinkedCount($role_id) {
			$result = $this->creation_obj->GetRoleLinkedCount($role_id);
			return $result;
		}

		public function getPermissionId($bill_company_id,$role_id,$module_key) {
			$result = $this->creation_obj->getPermissionId($bill_company_id,$role_id,$module_key);
			return $result;
		}

		public function getRolePermissionId($bill_company_id,$role_id,$module_key) {
			$result = $this->creation_obj->getRolePermissionId($bill_company_id,$role_id,$module_key);
			return $result;
		}

		public function CheckPaymentModeAlreadyExists($company_id, $payment_mode_name) {
			$result = $this->creation_obj->CheckPaymentModeAlreadyExists($company_id, $payment_mode_name);
			return $result;
		}

		
		public function GetPaymentModeList() {
			$result = $this->creation_obj->GetPaymentModeList();
			return $result;
		}

		public function CheckSizeAlreadyExists($unit_name) {
			$result = $this->creation_obj->CheckSizeAlreadyExists($unit_name);
			return $result;
		}
		public function getSizeList($row, $rowperpage, $order_column, $order_direction, $search_text) {
			$result = $this->creation_obj->getSizeList($row, $rowperpage, $order_column, $order_direction, $search_text);
			return $result;
		}

		public function getPaymentModeTable($row, $rowperpage, $order_column, $order_direction, $search_text) {
			$result = $this->creation_obj->getPaymentModeTable($row, $rowperpage, $order_column, $order_direction, $search_text);
			return $result;
		}

		public function getSalesReportList($from_date,$to_date, $filter_type, $filter_group_id, $filter_category_id){
			$list = $this->report_obj->getSalesReportList($from_date,$to_date, $filter_type, $filter_group_id, $filter_category_id);
			return $list;
		}

		public function customer_balance_report($bill_company_id,$customer_id, $from_date, $to_date,$filter_bill_type){
			$list = $this->report_obj->customer_balance_report($bill_company_id,$customer_id, $from_date, $to_date,$filter_bill_type);
			return $list;
		}

		
		public function GetBankLinkedCount($bank_id) {
            $result = $this->creation_obj->GetBankLinkedCount($bank_id);
            return $result;
        }

        public function GetPaymentmodeLinkedCount($payment_mode_id) {
            $result = $this->creation_obj->GetPaymentmodeLinkedCount($payment_mode_id);
            return $result;
        }

		public function getOpeningBalance($customer_id, $from_date, $to_date, $bill_company_id){
			$result = $this->report_obj->getOpeningBalance($customer_id, $from_date, $to_date, $bill_company_id);
            return $result;
		}


		public function getPaymentReportList($from_date, $to_date, $filter_bill_type, $filter_party_type, $filter_party_id, $payment_mode_id, $bank_id) {
            $list = $this->report_obj->getPaymentReportList($from_date, $to_date, $filter_bill_type, $filter_party_type, $filter_party_id, $payment_mode_id, $bank_id);
            return $list;
        }

		public function PartyMobileExists($mobile_number,$table,$column)
        {
            $result = $this->creation_obj->PartyMobileExists($mobile_number,$table,$column);
            return $result;
        }

        public function getPartyList($row, $rowperpage, $order_column, $order_direction, $search_value, $filter_party_id, $filter_party_type)
        {
            $result = $this->creation_obj->getPartyList($row, $rowperpage, $order_column, $order_direction, $search_value, $filter_party_id, $filter_party_type);
            return $result;
        }
		public function getBankList($row, $rowperpage, $order_column, $order_direction, $search_text) {
            $result = $this->creation_obj->getBankList($row, $rowperpage, $order_column, $order_direction, $search_text);
            return $result;
        }

		public function getOrderFormList($row, $rowperpage, $searchValue, $from_date, $to_date, $party_id,$cancelled, $order_column, $order_direction) {
			$result = $this->billing_obj->getOrderFormList($row, $rowperpage, $searchValue, $from_date, $to_date, $party_id,$cancelled, $order_column, $order_direction);
            return $result;
		}

		public function getEstimateRecordList($row, $rowperpage, $searchValue, $from_date, $to_date, $party_id,$cancelled, $order_column, $order_direction) {
			$result = $this->billing_obj->getEstimateRecordList($row, $rowperpage, $searchValue, $from_date, $to_date, $party_id,$cancelled, $order_column, $order_direction);
            return $result;
		}
		public function getQuotationRecordList($row, $rowperpage, $searchValue, $from_date, $to_date, $party_id,$cancelled, $order_column, $order_direction) {
			$result = $this->billing_obj->getQuotationRecordList($row, $rowperpage, $searchValue, $from_date, $to_date, $party_id,$cancelled, $order_column, $order_direction);
            return $result;
		}
		public function getPurchaseRecordList($row, $rowperpage, $searchValue, $from_date, $to_date, $party_id,$cancelled, $order_column, $order_direction) {
			$result = $this->billing_obj->getPurchaseRecordList($row, $rowperpage, $searchValue, $from_date, $to_date, $party_id,$cancelled, $order_column, $order_direction);
            return $result;
		}
		public function setClearTableRecords($table) {
            $list = array();
            $list = $this->creation_obj->setClearTableRecords($table);
            return $list;
        }

		public function getPartyDetailList($type) {
			$result = $this->creation_obj->getPartyDetailList($type);
			return $result;
		}

		public function StockUpdate($page_table,$in_out_type,$bill_unique_id,$bill_unique_number,$product_id,$unit_id,$size_id, $remarks, $stock_date, $quantity,$party_id) 			{
			$stock_update = $this->creation_obj->StockUpdate($page_table,$in_out_type,$bill_unique_id,$bill_unique_number,$product_id,$unit_id,$size_id, $remarks, $stock_date, $quantity,$party_id);
			return $stock_update;
		}

		public function getStockUniqueID($bill_unique_id,$product_id, $unit_id, $size_id) {
            $stock_update = $this->creation_obj->getStockUniqueID($bill_unique_id,$product_id, $unit_id, $size_id);
            return $stock_update;
        }


		public function DeletePrevList($bill_id, $stock_unique_ids) {
			$stock_update = $this->creation_obj->DeletePrevList($bill_id, $stock_unique_ids);
			return $stock_update;
		}
		public function PrevStockList($bill_unique_id) {
			$stock_update = $this->creation_obj->PrevStockList($bill_unique_id);
			return $stock_update;
		}

		public function getOutwardQty($bill_unique_id,$unit_id,$size_id,$product_id,$party_id) {
			$result = $this->creation_obj->getOutwardQty($bill_unique_id,$unit_id,$size_id,$product_id,$party_id);
			return $result;
		}
		

		//Report Functions
		public function getOrderFormReport($bill_company_id,$filter_party_id,$from_date, $to_date,$cancel_bill_btn) {
			$list = $this->report_obj->getOrderFormReport($bill_company_id,$filter_party_id,$from_date, $to_date,$cancel_bill_btn);
			return $list;
		}
		
		public function getInvoiceRecordList($row, $rowperpage, $searchValue, $from_date, $to_date, $party_id,$cancelled, $order_column, $order_direction) {
			$result = $this->billing_obj->getInvoiceRecordList($row, $rowperpage, $searchValue, $from_date, $to_date, $party_id,$cancelled, $order_column, $order_direction);
            return $result;
		}
		public function getSalesBillReport($bill_company_id,$filter_party_id,$from_date, $to_date,$view_type,$cancel_bill_btn) {
            $list = $this->report_obj->getSalesBillReport($bill_company_id,$filter_party_id,$from_date, $to_date,$view_type,$cancel_bill_btn);
            return $list;
        }
		public function getPurchaseBillReport($bill_company_id,$filter_party_id,$from_date, $to_date,$cancel_bill_btn) {
            $list = $this->report_obj->getPurchaseBillReport($bill_company_id,$filter_party_id,$from_date, $to_date,$cancel_bill_btn);
            return $list;
        }
        public function GetSalesTaxReportList($from_date, $to_date, $customer_id) {
            $result = $this->report_obj->GetSalesTaxReportList($from_date, $to_date, $customer_id);
            return $result;
        }
        public function GetPurchaseTaxReportList($from_date, $to_date, $party_id) {
            $result = $this->report_obj->GetPurchaseTaxReportList($from_date, $to_date, $party_id);
            return $result;
        }
		public function getDashboardCounList() {
            $result = $this->billing_obj->getDashboardCounList();
            return $result;
        }
		public function getSalesChartDetails($from_date, $to_date)
		{
			  $result = $this->billing_obj->getSalesChartDetails($from_date, $to_date);
            return $result;
        }
		public function getRecentSales(){
	 		 $result = $this->billing_obj->getRecentSales();
            return $result;
        }


		public function getSalesStockReportList($party_id,$product_id){
            $result = $this->report_obj->getSalesStockReportList($party_id,$product_id);
            return $result;
        }

		public function getSalesDetailStockReportList($from_date, $to_date,$filter_party_id,$filter_product_id,$filter_size_id,$filter_unit_id){
            $result = $this->report_obj->getSalesDetailStockReportList($from_date, $to_date,$filter_party_id,$filter_product_id,$filter_size_id,$filter_unit_id);
            return $result;
        }

		public function getDayBookReportList($bill_company_id,$from_date,$to_date,$party_id,$payment_mode_id,$bill_type) {
            $result = $this->report_obj->getDayBookReportList($bill_company_id,$from_date,$to_date,$party_id,$payment_mode_id,$bill_type);
            return $result;
        }

		// Payment Functions
		public function PaymentlinkedParty($party_id) {
			$result = $this->payment_obj->PaymentlinkedParty($party_id);
			return $result;
		}

		public function getPartyTypeList($type) {
			$result = $this->payment_obj->getPartyTypeList($type);
			return $result;
		}

		public function getPartyBills($bill_company_id, $party_id, $from_page) {
			$result = $this->payment_obj->getPartyBills($bill_company_id, $party_id,$from_page);
			return $result;
		}

		public function getBillDetails($bill_id) {
			$result = $this->payment_obj->getBillDetails($bill_id);
			return $result;
		}

		public function PreviousPaidAmount($party_id, $bill_id, $bill_company_id, $from_page) {
			$result = $this->payment_obj->PreviousPaidAmount($party_id, $bill_id, $bill_company_id,$from_page);
			return $result;
		}

		public function RevertBillStatus($table, $type, $bill_id) {
			$result = $this->payment_obj->RevertBillStatus($table, $type, $bill_id);
			return $result;
		}

		public function UpdateBalance($bill_company_id,$bill_id,$bill_number,$bill_date,$bill_type,$party_id,$party_name,$party_type,$payment_mode_id,$payment_mode_name,$bank_id,$bank_name,$opening_balance,$opening_balance_type,$credit,$debit) {
			$list = $this->payment_obj->UpdateBalance($bill_company_id,$bill_id,$bill_number,$bill_date,$bill_type,$party_id,$party_name,$party_type,$payment_mode_id,$payment_mode_name,$bank_id,$bank_name,$opening_balance,$opening_balance_type,$credit,$debit);
			return $list;
		}
		
		public function PartyOpeningList($party_id) {
			$result = $this->payment_obj->PartyOpeningList($party_id);
			return $result;
		}
		
		public function getVoucherList($row, $rowperpage, $order_column, $order_direction, $search_text,$cancelled,$filter_from_date,$filter_to_date,$filter_party_id ) {
			$result = $this->payment_obj->getVoucherList($row, $rowperpage, $order_column, $order_direction, $search_text,$cancelled,$filter_from_date,$filter_to_date,$filter_party_id );
			return $result;
		}

		public function DeletePayment($bill_id) {
			$result =  $this->payment_obj->DeletePayment($bill_id);
			return $result;
		}

		public function getPendingList($party_id) {
			$result = $this->payment_obj->getPendingList($party_id);
			return $result;
		}

		public function getReceiptList($row, $rowperpage, $order_column, $order_direction, $search_text,$cancelled,$filter_from_date,$filter_to_date,$filter_party_id ) {
			$result = $this->payment_obj->getReceiptList($row, $rowperpage, $order_column, $order_direction, $search_text,$cancelled,$filter_from_date,$filter_to_date,$filter_party_id );
			return $result;
		}
	}
?>
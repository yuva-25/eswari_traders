<?php
    include("../include_user_check_and_files.php");
    include("../include/number2words.php");
    

    $view_estimate_id = ""; 
    if (isset($_REQUEST['view_estimate_id'])) {
        $view_estimate_id = $_REQUEST['view_estimate_id'];
    }else {
        header("Location: ../estimate.php");
        exit;
    }  

    $estimate_date = date('d-m-Y'); $bill_number = ""; $party_id = ""; $godown_type = "";  $product_count = 0; $gst_option = 2; $tax_option = 1;$tax_type = 2;$party_state = ""; $company_state = "";
    $company_state = $obj->getTableColumnValue($GLOBALS['company_table'], 'company_id', $GLOBALS['bill_company_id'], 'state');

    $godown_ids = array();$product_ids = array(); $product_names = array(); $unit_ids = array();$unit_names = array(); $product_quantity = array(); $product_price = array();$overall_tax = "";$product_tax = array(); $final_price = array(); $product_amount = array(); $discount = ""; $discount_name = ""; 
    $discount_value = 0; $extra_charges = ""; $extra_charges_name = ""; $extra_charges_value = 0; 
    $grand_total = 0; $delivery_date = "";$hsn_code = ""; $selected_godown_id = ""; $godown_names = array(); $selected_godown_name = ""; $estimate_number = ""; $party_name = ""; $cancelled = 0; $party_details = array(); $total_amount = 0; $discounted_total = 0; $extra_charges_total = 0; $cgst_value = $sgst_value = $igst_value = $round_off = $bill_total = 0; $sub_total = 0; $category_ids = $category_names =  array(); $size_ids = $size_names = $description = array(); 
    if(!empty($view_estimate_id)){
        $estimate_list = array();
        $estimate_list = $obj->getTableRecords($GLOBALS['estimate_table'], 'estimate_id', $view_estimate_id, '');
        if(!empty($estimate_list)) {
            foreach($estimate_list as $data) {
                if(!empty($data['estimate_date'])) {
                    $estimate_date = date('d-m-Y', strtotime($data['estimate_date']));
                }
                if(!empty($data['estimate_number']) && $data['estimate_number'] != $GLOBALS['null_value']) {
                    $estimate_number = $data['estimate_number'];
                }
                if(!empty($data['bill_number']) && $data['bill_number'] != $GLOBALS['null_value']) {
                    $bill_number = $data['bill_number'];
                }
                if(!empty($data['party_id'])){
                    $party_id = $data['party_id'];
                }
                if(!empty($data['party_name'])){
                    $party_name = $data['party_name'];
                }
                if(!empty($data['gst_option']) && $data['gst_option'] != $GLOBALS['null_value']) {
                    $gst_option = $data['gst_option'];
                }
                if(!empty($data['tax_option']) && $data['tax_option'] != $GLOBALS['null_value']) {
                    $tax_option = $data['tax_option'];
                }
                if(!empty($data['tax_type']) && $data['tax_type'] != $GLOBALS['null_value']) {
                    $tax_type = $data['tax_type'];
                }
                if(!empty($data['party_state']) && $data['party_state'] != $GLOBALS['null_value']) {
                    $party_state = $data['party_state'];
                }
                if(!empty($data['godown_type']) && $data['godown_type'] != $GLOBALS['null_value']) {
                    $godown_type = $data['godown_type'];
                }
                if(!empty($data['godown_id']) && $data['godown_id'] != $GLOBALS['null_value']) {
                    $godown_ids = explode(",", $data['godown_id']);
                    if($godown_type == '1') {
                        $selected_godown_id = $godown_ids[0];
                    }
                }
                if(!empty($data['godown_name']) && $data['godown_name'] != $GLOBALS['null_value']) {
                    $godown_names = explode(",", $data['godown_name']);
                    if($godown_type == '1') {
                        $selected_godown_name = $godown_names[0];
                    }
                }
                if(!empty($data['product_id']) && $data['product_id'] != $GLOBALS['null_value']) {
                    $product_ids = explode(',', $data['product_id']);
                    $product_count = count($product_ids);
                }
                if(!empty($data['product_name']) && $data['product_name'] != $GLOBALS['null_value']) {
                    $product_names = explode(',', $data['product_name']);
                }
                if(!empty($data['hsn_code']) && $data['hsn_code'] != $GLOBALS['null_value']) {
                    $hsn_code = explode(',', $data['hsn_code']);
                }
                if(!empty($data['unit_id']) && $data['unit_id'] != $GLOBALS['null_value']) {
                    $unit_ids = explode(',', $data['unit_id']);
                }
                if(!empty($data['unit_name']) && $data['unit_name'] != $GLOBALS['null_value']) {
                    $unit_names = explode(',', $data['unit_name']);  
                }
                 if(!empty($data['size_id']) && $data['size_id'] != $GLOBALS['null_value']) {
                    $size_ids = explode(',', $data['size_id']);
                }
                if(!empty($data['size_name']) && $data['size_name'] != $GLOBALS['null_value']) {
                    $size_names = explode(',', $data['size_name']);  
                }
                if(!empty($data['quantity']) && $data['quantity'] != $GLOBALS['null_value']) {
                    $product_quantity = explode(',', $data['quantity']);
                }
                if(!empty($data['rate']) && $data['rate'] != $GLOBALS['null_value']) {
                    $product_price = explode(',', $data['rate']);
                }
                if(!empty($data['product_tax']) && $data['product_tax'] != $GLOBALS['null_value']) {
                    $product_tax = explode(',', $data['product_tax']);
                }
                if(!empty($data['final_price']) && $data['final_price'] != $GLOBALS['null_value']) {
                    $final_price = explode(',', $data['final_price']);
                }
                if(!empty($data['amount']) && $data['amount'] != $GLOBALS['null_value']) {
                    $product_amount = explode(',', $data['amount']);
                }
                if(!empty($data['overall_tax']) && $data['overall_tax'] != $GLOBALS['null_value']) {
                    $overall_tax = $data['overall_tax'];
                }
                if(!empty($data['discount']) && $data['discount'] != $GLOBALS['null_value']) {
                    $discount = $data['discount'];
                }
                if(!empty($data['discount_name']) && $data['discount_name'] != $GLOBALS['null_value']) {
                    $discount_name = $obj->encode_decode('decrypt', $data['discount_name']);
                }
                if(!empty($data['discount_value']) && $data['discount_value'] != $GLOBALS['null_value']) {
                    $discount_value = $data['discount_value'];
                }
                if(!empty($data['extra_charges']) && $data['extra_charges'] != $GLOBALS['null_value']) {
                    $extra_charges = $data['extra_charges'];
                }
                if(!empty($data['extra_charges_name']) && $data['extra_charges_name'] != $GLOBALS['null_value']) {
                    $extra_charges_name = $obj->encode_decode('decrypt', $data['extra_charges_name']);
                }
                if(!empty($data['extra_charges_value']) && $data['extra_charges_value'] != $GLOBALS['null_value']) {
                    $extra_charges_value = $data['extra_charges_value'];
                } 
                if(!empty($data['delivery_date'])){
                    $delivery_date = explode(",",$data['delivery_date']);
                }
                if(!empty($data['cancelled']) && $data['cancelled'] != $GLOBALS['null_value']) {
                    $cancelled = $data['cancelled'];
                }
                if(!empty($data['party_details']) && $data['party_details'] != $GLOBALS['null_value']) {
                    $party_details = $data['party_details'];
                    $party_details = $obj->encode_decode('decrypt', $party_details);
                    $party_details = explode("<br>", $party_details);
                }
                if(!empty($data['category_id']) && $data['category_id'] != $GLOBALS['null_value']) {
                    $category_ids = explode(',', $data['category_id']);
                    $category_count = count($category_ids);
                }
                if(!empty($data['category_name']) && $data['category_name'] != $GLOBALS['null_value']) {
                    $category_names = explode(',', $data['category_name']);
                }
                 if(!empty($data['total_amount']) && $data['total_amount'] != $GLOBALS['null_value']) {
                    $total_amount = $data['total_amount'];
                }
                if(!empty($data['discounted_total']) && $data['discounted_total'] != $GLOBALS['null_value']) {
                    $discounted_total = $data['discounted_total'];
                }
                if(!empty($data['extra_charges_total']) && $data['extra_charges_total'] != $GLOBALS['null_value']) {
                    $extra_charges_total = $data['extra_charges_total'];
                }
                if(!empty($data['cgst_value']) && $data['cgst_value'] != $GLOBALS['null_value']) {
                    $cgst_value = $data['cgst_value'];
                }
                if(!empty($data['sgst_value']) && $data['sgst_value'] != $GLOBALS['null_value']) {
                    $sgst_value = $data['sgst_value'];
                }
                if(!empty($data['igst_value']) && $data['igst_value'] != $GLOBALS['null_value']) {
                    $igst_value = $data['igst_value'];
                }
                if(!empty($data['round_off']) && $data['round_off'] != $GLOBALS['null_value']) {
                    $round_off = $data['round_off'];
                }
                if(!empty($data['sub_total']) && $data['sub_total'] != $GLOBALS['null_value']) {
                    $sub_total = $data['sub_total'];
                }
                if(!empty($data['bill_total']) && $data['bill_total'] != $GLOBALS['null_value']) {
                    $bill_total = $data['bill_total'];
                }
                if(!empty($data['description']) && $data['description'] != $GLOBALS['null_value']) {
                    $description = explode(',', $data['description']);
                }
            }
        }
        $company_name = ""; $company_city = "";
        $company_name = $obj->getTableColumnValue($GLOBALS['company_table'], 'company_id', $GLOBALS['bill_company_id'], 'name');
        $company_city = $obj->getTableColumnValue($GLOBALS['company_table'], 'company_id',$GLOBALS['bill_company_id'], 'city');
        if(!empty($company_name) && $company_name != $GLOBALS['null_value']){
            $company_name = $obj->encode_decode('decrypt', $company_name);
        }
        if(!empty($company_city) && $company_city != $GLOBALS['null_value']){
            $company_city = $obj->encode_decode('decrypt', $company_city);
        }
        require_once __DIR__ . '/../fpdf/AlphaPDF.php';
        $pdf = new AlphaPDF('P', 'mm', 'A4');
        $pdf->AliasNbPages();
        $pdf->AddPage();
        $pdf->SetAutoPageBreak(false);
        $pdf->SetTitle('Estimate');
        $pdf->SetFont('Arial', 'B', 10);
        $height = 0;
        $display = '';
        $y2 = $pdf->GetY();
        $y = $pdf->GetY();
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->SetY(11);

        $file_name = 'Estimate';
        include("rpt_header.php");
        if($cancelled == '0'){
            include("rpt_watermark.php");
        }
        if($cancelled == '1') {
            if(file_exists('../include/images/cancelled.jpg')) {
                $pdf->SetAlpha(0.3);
                $pdf->Image('../include/images/cancelled.jpg',45,110,125,70);
                $pdf->SetAlpha(1);
            }
        }     
        $bill_to_y = $pdf->GetY();
        $pdf->SetFont('Arial','B',10);
        $pdf->SetX(10);
        $pdf->Cell(0,1,'',0,1,'L',0);
        $pdf->Cell(63,4,'To : ',0,1,'L',0);
        $pdf->Cell(0,1,'',0,1,'L',0);
        $pdf->SetFont('Arial','B',10);
        $pdf->SetX(12);
        if(!empty($party_details)){
            for($i=0;$i<count($party_details);$i++){
                if($party_details[$i]!="NULL" && $party_details[$i]!=""){
                    $pdf->SetFont('Arial','',9);
                    $pdf->SetX(15);
                    if($i==0)
                    {
                        $pdf->SetFont('Arial','B',9);
                        $pdf->Cell(65,4,$party_details[$i],0,1,'L',0);
                        $pdf->Cell(0,1,'',0,1,'L',0);
                    }
                    else{
                        $party_details[$i] = trim($party_details[$i]);
                        $pdf->MultiCell(90,4,$party_details[$i],0,'L',0);
                        $pdf->Cell(0,0.7,'',0,1,'L',0);
                    }
                }
            }
        }
        $party_y = $pdf->GetY();
        $pdf->SetFont('Arial','B',10);
        $pdf->SetY($bill_to_y);
        $pdf->SetX(113);
        $pdf->Cell(80,8,'Estimate No.              :  ',0,0,'L',0);

        $pdf->SetFont('Arial','',9);
        $pdf->SetX(153);
        $pdf->Cell(40,8,$estimate_number,0,1,'L',0);

        $pdf->SetFont('Arial','B',10);
        $pdf->SetX(113);
        $pdf->Cell(30,8,'Dated                          : ',0,0,'L',0);

        $pdf->SetFont('Arial','',9);
        $pdf->SetX(153);
        $pdf->Cell(40,8,date('d-m-Y',strtotime($estimate_date)),0,1,'L',0);
        $bill_to_y2 = $pdf->GetY();
        $y_array = array($party_y,$bill_to_y2);
        $max_bill_y = max($y_array);
        $pdf->SetY($bill_to_y);
        $pdf->SetX(10);
        $pdf->Cell(100,40,'',1,0,'L',0);
        $pdf->SetX(110);
        $pdf->Cell(90,40,'',1,1,'L',0);
       
            
        $pdf->SetFont('Arial','B',9);   
        $y=$pdf->GetY();
        $pdf->SetX(10);
        $pdf->SetFillColor(52,58,64);
        $pdf->SetTextColor(255,255,255);
        
        if($tax_option == '2' && $tax_type == '2'){
            $pdf->Cell(10,8,'S.No',1,0,'C',1);
            $pdf->Cell(45,8,'Product Name',1,0,'C',1);
            $pdf->Cell(25,8,'Size',1,0,'C',1);
            $pdf->Cell(20,8,'HSN Code',1,0,'C',1);
            $pdf->Cell(20,8,'QTY/Unit',1,0,'C',1);
            $pdf->Cell(20,8,'Rate',1,0,'C',1);
            $pdf->Cell(20,8,'Final rate',1,0,'C',1);
            $pdf->Cell(30,8,'Amount',1,1,'C',1);
        } elseif($tax_option == '2' && $tax_type == '1'){
            $pdf->Cell(10,8,'S.No',1,0,'C',1);
            $pdf->Cell(45,8,'Product Name',1,0,'C',1);
            $pdf->Cell(20,8,'Size',1,0,'C',1);
            $pdf->Cell(20,8,'HSN Code',1,0,'C',1);
            $pdf->Cell(20,8,'QTY/Unit',1,0,'C',1);
            $pdf->Cell(20,8,'Rate',1,0,'C',1);
            $pdf->Cell(20,8,'Final rate',1,0,'C',1);
            $pdf->Cell(15,8,'Tax',1,0,'C',1);
            $pdf->Cell(20,8,'Amount',1,1,'C',1);
        } elseif($tax_type == '1'){
            $pdf->Cell(10,8,'S.No',1,0,'C',1);
            $pdf->Cell(45,8,'Product Name',1,0,'C',1);
            $pdf->Cell(25,8,'Size',1,0,'C',1);
            $pdf->Cell(20,8,'HSN Code',1,0,'C',1);
            $pdf->Cell(20,8,'QTY/Unit',1,0,'C',1);
            $pdf->Cell(25,8,'Rate',1,0,'C',1);
            $pdf->Cell(15,8,'Tax',1,0,'C',1);
            $pdf->Cell(30,8,'Amount',1,1,'C',1);
        } else {
            $pdf->Cell(10,8,'S.No',1,0,'C',1);
            $pdf->Cell(50,8,'Product Name',1,0,'C',1);
            $pdf->Cell(25,8,'Size',1,0,'C',1);
            $pdf->Cell(25,8,'HSN Code',1,0,'C',1);
            $pdf->Cell(25,8,'QTY/Unit',1,0,'C',1);
            $pdf->Cell(25,8,'Rate',1,0,'C',1);
            $pdf->Cell(30,8,'Amount',1,1,'C',1);    
        }
        
        $pdf->SetFont('Arial','',8);
        $pdf->SetTextColor(0,0,0);
        $y_axis = $pdf->GetY();
        $start_y = $pdf->GetY();

        $s_no = 1; $footer_height = 0; $height = 0;
        $footer_height += 27;
        $total_pages = array(1);
        $page_number = 1;
        $last_count = 0; 
        $total_quantity = 0;
        $l = 0;

        if(!empty($round_off)){
            $footer_height += 6;
            $height -= 5;
        }
        if(!empty($discount_value) && $discount_value != $GLOBALS['null_value']) {
            $footer_height += 12;
            $height -= 15;
        }

        if(!empty($extra_charges_value) && $extra_charges_value != $GLOBALS['null_value']) {
            $footer_height += 12;
            $height -= 15;
        }

        if($gst_option == '1'){
            if($company_state == $party_state){
                $footer_height += 12;
                $height -= 12;

            }else{
                $footer_height += 6;
                $height -= 6;
            }
        }

        if(!empty($view_estimate_id) && !empty($product_ids)) { 
            for($p = 0; $p < count($product_ids); $p++) { 
                if($pdf->GetY() >= 270){
                    $pdf->SetY($y_axis);
                    $y = $pdf->GetY();
                    $pdf->SetFont('Arial','B',8);
                    $next_page = $pdf->PageNo() +1;

                    $pdf->SetFont('Arial','I',7);
                    $pdf->setY(-15);
                    $pdf->SetX(10);
                    $pdf->Cell(190,4,'Page No : '.$pdf->PageNo().' / {nb}',0,0,'R');

                    $pdf->AddPage();
                    $pdf->SetAutoPageBreak(false);
                    $page_number += 1;
                    $total_pages[] = $page_number;
                    $last_count = $l+1;
                    $file_name = 'Estimate';
                    include("rpt_header.php");
                    if($cancelled == '0'){
                        include("rpt_watermark.php");
                    }
                    if($cancelled == '1') {
                        if(file_exists('../include/images/cancelled.jpg')) {
                            $pdf->SetAlpha(0.3);
                            $pdf->Image('../include/images/cancelled.jpg',45,110,125,70);
                            $pdf->SetAlpha(1);
                        }
                    }     
                    $bill_to_y = $pdf->GetY();
                    $pdf->SetFont('Arial','B',10);
                    $pdf->SetX(10);
                    $pdf->Cell(0,1,'',0,1,'L',0);
                    $pdf->Cell(63,4,'To : ',0,1,'L',0);
                    $pdf->Cell(0,1,'',0,1,'L',0);
                    $pdf->SetFont('Arial','B',10);
                    $pdf->SetX(12);
                    if(!empty($party_details)){
                        for($i=0;$i<count($party_details);$i++){
                            if($party_details[$i]!="NULL" && $party_details[$i]!=""){
                                $pdf->SetFont('Arial','',9);
                                $pdf->SetX(15);
                                if($i==0)
                                {
                                    $pdf->SetFont('Arial','B',9);
                                    $pdf->Cell(65,4,$party_details[$i],0,1,'L',0);
                                    $pdf->Cell(0,1,'',0,1,'L',0);
                                }
                                else{
                                    $party_details[$i] = trim($party_details[$i]);
                                    $pdf->MultiCell(90,4,$party_details[$i],0,'L',0);
                                    $pdf->Cell(0,0.7,'',0,1,'L',0);
                                }
                            }
                        }
                    }
                    $party_y = $pdf->GetY();
                    $pdf->SetFont('Arial','B',10);
                    $pdf->SetY($bill_to_y);
                    $pdf->SetX(113);
                    $pdf->Cell(80,8,'Estimate No.              :  ',0,0,'L',0);
                    $pdf->SetFont('Arial','',9);
                    $pdf->SetX(153);
                    $pdf->Cell(40,8,$estimate_number,0,1,'L',0);

                    $pdf->SetFont('Arial','B',10);
                    $pdf->SetX(113);
                    $pdf->Cell(30,8,'Dated                          : ',0,0,'L',0);

                    $pdf->SetFont('Arial','',9);
                    $pdf->SetX(153);
                    $pdf->Cell(40,8,date('d-m-Y',strtotime($estimate_date)),0,1,'L',0);
                    $bill_to_y2 = $pdf->GetY();
                    $y_array = array($party_y,$bill_to_y2);
                    $max_bill_y = max($y_array);
                    $pdf->SetY($bill_to_y);
                    $pdf->SetX(10);
                    $pdf->Cell(100,40,'',1,0,'L',0);
                    $pdf->SetX(110);
                    $pdf->Cell(90,40,'',1,1,'L',0);

                    if($godown_type == "1"){
                        $bill_to_y = $pdf->GetY();
                        $pdf->SetFont('Arial', 'B', 9);
                        $pdf->SetX(10);
                        $pdf->Cell(0, 1, '', 0, 1, 'L', 0);
                        $pdf->Cell(90, 4, 'Godown  : ', 0, 0, 'L', 0);
                        $pdf->SetFont('Arial', '', 9);
                        $pdf->SetX(40);
                        $pdf->Cell(20, 4,$obj->encode_decode('decrypt', $selected_godown_name), 0, 1, 'L', 0);
                        $pdf->Cell(0, 2, '', 0, 1, 'L', 0);  
                        $pdf->SetY($bill_to_y);
                        $pdf->SetX(10);
                        $pdf->cell(0,6, '', 1, 1, 'L', 0);

                    }                 
                        
                    $pdf->SetFont('Arial','B',9);   
                    $y=$pdf->GetY();
                    $pdf->SetX(10);
                    $pdf->SetFillColor(52,58,64);
                    $pdf->SetTextColor(255,255,255);
                  
                    if($tax_option == '2' && $tax_type == '2'){
                        $pdf->Cell(10,8,'S.No',1,0,'C',1);
                        $pdf->Cell(45,8,'Product Name',1,0,'C',1);
                        $pdf->Cell(25,8,'Size',1,0,'C',1);
                        $pdf->Cell(20,8,'HSN Code',1,0,'C',1);
                        $pdf->Cell(20,8,'QTY/Unit',1,0,'C',1);
                        $pdf->Cell(20,8,'Rate',1,0,'C',1);
                        $pdf->Cell(20,8,'Final rate',1,0,'C',1);
                        $pdf->Cell(30,8,'Amount',1,1,'C',1);
                    } elseif($tax_option == '2' && $tax_type == '1'){
                        $pdf->Cell(10,8,'S.No',1,0,'C',1);
                        $pdf->Cell(45,8,'Product Name',1,0,'C',1);
                        $pdf->Cell(20,8,'Size',1,0,'C',1);
                        $pdf->Cell(20,8,'HSN Code',1,0,'C',1);
                        $pdf->Cell(20,8,'QTY/Unit',1,0,'C',1);
                        $pdf->Cell(20,8,'Rate',1,0,'C',1);
                        $pdf->Cell(20,8,'Final rate',1,0,'C',1);
                        $pdf->Cell(15,8,'Tax',1,0,'C',1);
                        $pdf->Cell(20,8,'Amount',1,1,'C',1);
                    } elseif($tax_type == '1'){
                        $pdf->Cell(10,8,'S.No',1,0,'C',1);
                        $pdf->Cell(45,8,'Product Name',1,0,'C',1);
                        $pdf->Cell(25,8,'Size',1,0,'C',1);
                        $pdf->Cell(20,8,'HSN Code',1,0,'C',1);
                        $pdf->Cell(20,8,'QTY/Unit',1,0,'C',1);
                        $pdf->Cell(25,8,'Rate',1,0,'C',1);
                        $pdf->Cell(15,8,'Tax',1,0,'C',1);
                        $pdf->Cell(30,8,'Amount',1,1,'C',1);
                    } else {
                        $pdf->Cell(10,8,'S.No',1,0,'C',1);
                        $pdf->Cell(50,8,'Product Name',1,0,'C',1);
                        $pdf->Cell(25,8,'Size',1,0,'C',1);
                        $pdf->Cell(25,8,'HSN Code',1,0,'C',1);
                        $pdf->Cell(25,8,'QTY/Unit',1,0,'C',1);
                        $pdf->Cell(25,8,'Rate',1,0,'C',1);
                        $pdf->Cell(30,8,'Amount',1,1,'C',1);    
                    }
                                    
                    $pdf->SetFont('Arial','',8);
                    $pdf->SetTextColor(0,0,0);
                    $y_axis = $pdf->GetY();
                    $start_y = $pdf->GetY();


                }
                $y = $pdf->GetY();


                $pdf->SetFont('Arial','',9);
                

                if($tax_option == '2' && $tax_type == '2'){
                    $pdf->SetY($start_y);
                    $pdf->SetX(10);
                    $pdf->Cell(10, 7, $s_no, 0, 0, 'C', 0);

                    $pdf->SetY($start_y);
                    $pdf->SetX(20);
                    if(!empty($product_names[$p])){
                        $pdf->MultiCell(45, 7, html_entity_decode($obj->encode_decode('decrypt', $product_names[$p])), 0, 'L');
                    }else{
                        $pdf->MultiCell(45, 7, '-', 0, 'L');
                    }

                    if(!empty($description[$p])){
                        $pdf->SetTextColor(128, 128, 128);
                        $pdf->SetFont('Arial', 'I', 8);
                        $pdf->SetX(20);
                        $pdf->MultiCell(45, 3,"Description : ".html_entity_decode($obj->encode_decode('decrypt', $description[$p])), 0, 'L');
                        $pdf->SetTextColor(0, 0, 0);
                        $pdf->SetFont('Arial', '', 8);
                    }
                    $product_names_y = $pdf->GetY() - $start_y;

                    $pdf->SetY($start_y);
                    $pdf->SetX(65);
                    if(!empty($size_names[$p])){
                          $pdf->MultiCell(25, 7,  $obj->encode_decode('decrypt',$size_names[$p]), 0, 'C');
                    }else{
                        $pdf->MultiCell(25, 7,  '-', 0, 'C');
                    }
                  
                    $unit_names_y = $pdf->GetY() - $start_y;

                    $pdf->SetY($start_y);
                    $pdf->SetX(90);
                    if(!empty($hsn_code[$p])){
                        $pdf->MultiCell(20, 7, $hsn_code[$p], 0, 'C');
                    }else{
                        $pdf->MultiCell(20, 7, '-', 0, 'C');
                    }
                    $hsn_code_y = $pdf->GetY() - $start_y;

                    
                    if(!empty($product_quantity[$p])){
                        $pdf->SetY($start_y);
                        $pdf->SetX(110);
                        $pdf->MultiCell(20, 7,$product_quantity[$p]." ".$obj->encode_decode('decrypt',$unit_names[$p]), 0, 'C');
                    } else {
                        $pdf->SetY($start_y);
                        $pdf->SetX(110);
                        $pdf->MultiCell(20, 7,'-', 0, 'C');
                    }
                    $product_quantity_y = $pdf->GetY() - $start_y;

                    if(!empty($product_price[$p])){
                        $pdf->SetY($start_y);
                        $pdf->SetX(130);
                        $pdf->MultiCell(20, 7,$obj->numberFormat($product_price[$p],2), 0, 'R');
                    } else {
                        $pdf->SetY($start_y);
                        $pdf->SetX(130);
                        $pdf->MultiCell(20, 7,'-', 0, 'C');
                    }
                    $product_price_y = $pdf->GetY() - $start_y;


                    if(!empty($final_price[$p])){
                        $pdf->SetY($start_y);
                        $pdf->SetX(150);
                        $pdf->MultiCell(20, 7,$obj->numberFormat($final_price[$p],2), 0, 'R');
                    } else {
                        $pdf->SetY($start_y);
                        $pdf->SetX(150);
                        $pdf->MultiCell(20, 7,'-', 0, 'C');
                    }
                    $final_price_y = $pdf->GetY() - $start_y;

                    if(!empty($product_amount[$p])){
                        $pdf->SetY($start_y);
                        $pdf->SetX(170);
                        $pdf->MultiCell(30, 7,$obj->numberFormat($product_amount[$p],2), 0, 'R');
                    } else {
                        $pdf->SetY($start_y);
                        $pdf->SetX(170);
                        $pdf->MultiCell(30, 7,'-', 0, 'C');
                    }
                    $product_amount_y = $pdf->GetY() - $start_y;

                    $y_array = array($product_names_y,$unit_names_y, $product_quantity_y,$product_price_y,$final_price_y,$product_amount_y, $hsn_code_y);
                    $product_max = max($y_array);

                    $pdf->SetY($start_y);
                    $pdf->SetX(10);
                    $pdf->Cell(10,$product_max,'',1,0,'C');
                    $pdf->Cell(45,$product_max,'',1,0,'C');
                    $pdf->Cell(25,$product_max,'',1,0,'C');
                    $pdf->Cell(20,$product_max,'',1,0,'C');
                    $pdf->Cell(20,$product_max,'',1,0,'C');
                    $pdf->Cell(20,$product_max,'',1,0,'C');
                    $pdf->Cell(20,$product_max,'',1,0,'C');
                    $pdf->Cell(30,$product_max,'',1,1,'C');

                    $start_y += $product_max;
                    $s_no++;
                    $total_quantity += $product_quantity[$p]; 
                }
                elseif($tax_option == '2' && $tax_type == '1'){
                    
                    $pdf->SetY($start_y);
                    $pdf->SetX(10);
                    $pdf->Cell(10, 7, $s_no, 0, 0, 'C', 0);

                    $pdf->SetY($start_y);
                    $pdf->SetX(20);
                    if(!empty($product_names[$p])){
                            $pdf->MultiCell(45, 7, html_entity_decode($obj->encode_decode('decrypt', $product_names[$p])), 0, 'L');
                    }else{
                        $pdf->MultiCell(45, 7, '-', 0, 'L');
                    }

                    if(!empty($description[$p])){
                        $pdf->SetTextColor(128, 128, 128);
                        $pdf->SetFont('Arial', 'I', 8);
                        $pdf->SetX(20);
                        $pdf->MultiCell(45, 3,"Description : ".html_entity_decode($obj->encode_decode('decrypt', $description[$p])), 0, 'L');
                        $pdf->SetTextColor(0, 0, 0);
                        $pdf->SetFont('Arial', '', 8);
                    }
                    $product_names_y = $pdf->GetY() - $start_y;

                    $pdf->SetY($start_y);
                    $pdf->SetX(65);
                    if(!empty($size_names)){
                        $pdf->MultiCell(20, 7,  html_entity_decode($obj->encode_decode('decrypt', $size_names[$p])), 0, 'C');
                    }else{
                        $pdf->MultiCell(20, 7, '-', 0, 'C');
                    }
                    $unit_names_y = $pdf->GetY() - $start_y;

                    $pdf->SetY($start_y);
                    $pdf->SetX(85);
                    if(!empty($hsn_code[$p])){
                        $pdf->MultiCell(20, 7,  $hsn_code[$p], 0, 'C');
                    }else{
                        $pdf->MultiCell(20, 7,  '-', 0, 'C');
                    }
                    $hsn_code_y = $pdf->GetY() - $start_y;

                    
                    if(!empty($product_quantity[$p])){
                        $pdf->SetY($start_y);
                        $pdf->SetX(105);
                        $pdf->MultiCell(20, 7,$product_quantity[$p]." ".$obj->encode_decode('decrypt', $unit_names[$p]), 0, 'C');
                    } else {
                        $pdf->SetY($start_y);
                        $pdf->SetX(105);
                        $pdf->MultiCell(20, 7,'', 0, 'C');
                    }
                    $product_quantity_y = $pdf->GetY() - $start_y;

                    if(!empty($product_price[$p])){
                        $pdf->SetY($start_y);
                        $pdf->SetX(125);
                        $pdf->MultiCell(20, 7,$obj->numberFormat($product_price[$p],2), 0, 'R');
                    } else {
                        $pdf->SetY($start_y);
                        $pdf->SetX(125);
                        $pdf->MultiCell(20, 7,'-', 0, 'C');
                    }
                    $product_price_y = $pdf->GetY() - $start_y;


                    if(!empty($final_price[$p])){
                        $pdf->SetY($start_y);
                        $pdf->SetX(145);
                        $pdf->MultiCell(20, 7,$obj->numberFormat($final_price[$p],2), 0, 'R');
                    } else {
                        $pdf->SetY($start_y);
                        $pdf->SetX(145);
                        $pdf->MultiCell(20, 7,'-', 0, 'C');
                    }
                    $final_price_y = $pdf->GetY() - $start_y;

                    if(!empty($product_tax[$p])){
                        $pdf->SetY($start_y);
                        $pdf->SetX(165);
                        $pdf->MultiCell(15, 7,$product_tax[$p], 0, 'C');
                    } else {
                        $pdf->SetY($start_y);
                        $pdf->SetX(165);
                        $pdf->MultiCell(15, 7,'-', 0, 'C');
                    }
                    $product_tax_y = $pdf->GetY() - $start_y;

                    if(!empty($product_amount[$p])){
                        $pdf->SetY($start_y);
                        $pdf->SetX(180);
                        $pdf->MultiCell(20, 7,$obj->numberFormat($product_amount[$p],2), 0, 'R');
                    } else {
                        $pdf->SetY($start_y);
                        $pdf->SetX(180);
                        $pdf->MultiCell(20, 7,'-', 0, 'C');
                    }
                    $product_amount_y = $pdf->GetY() - $start_y;

                    $y_array = array($product_names_y,$unit_names_y, $product_quantity_y,$product_price_y,$final_price_y,$product_amount_y,$product_tax_y, $hsn_code_y);
                    $product_max = max($y_array);

                    $pdf->SetY($start_y);
                
                    $pdf->SetX(10);
                    $pdf->Cell(10,$product_max,'',1,0,'C');
                    $pdf->Cell(45,$product_max,'',1,0,'C');
                    $pdf->Cell(20,$product_max,'',1,0,'C');
                    $pdf->Cell(20,$product_max,'',1,0,'C');
                    $pdf->Cell(20,$product_max,'',1,0,'C');
                    $pdf->Cell(20,$product_max,'',1,0,'C');
                    $pdf->Cell(20,$product_max,'',1,0,'C');
                    $pdf->Cell(15,$product_max,'',1,0,'C');
                    $pdf->Cell(20,$product_max,'',1,1,'C');

                    $start_y += $product_max;
                    $s_no++;
                    $total_quantity += $product_quantity[$p];
                }
                elseif($tax_type == '1'){
                    $pdf->SetY($start_y);
                    $pdf->SetX(10);
                    $pdf->Cell(10, 7, $s_no, 0, 0, 'C', 0);

                    $pdf->SetY($start_y);
                    $pdf->SetX(20);
                    if(!empty($product_names[$p])){
                        $pdf->MultiCell(45, 7, html_entity_decode($obj->encode_decode('decrypt', $product_names[$p])), 0, 'L');
                    }else{
                        $pdf->MultiCell(45, 7, '-', 0, 'L');
                    }

                    if(!empty($description[$p])){
                        $pdf->SetTextColor(128, 128, 128);
                        $pdf->SetFont('Arial', 'I', 8);
                        $pdf->SetX(20);
                        $pdf->MultiCell(45, 3,"Description : ".html_entity_decode($obj->encode_decode('decrypt', $description[$p])), 0, 'L');
                        $pdf->SetTextColor(0, 0, 0);
                        $pdf->SetFont('Arial', '', 8);
                    }
                    $product_names_y = $pdf->GetY() - $start_y;

                    $pdf->SetY($start_y);
                    $pdf->SetX(65);
                    if(!empty($size_names[$p])){
                        $pdf->MultiCell(25, 7,  $obj->encode_decode('decrypt', $size_names[$p]), 0, 'C');
                    }else{
                        $pdf->MultiCell(25, 7,  '-', 0, 'C');
                    }
                    $unit_names_y = $pdf->GetY() - $start_y;

                    $pdf->SetY($start_y);
                    $pdf->SetX(90);
                    if(!empty($hsn_code[$p])){
                        $pdf->MultiCell(20, 7,  $hsn_code[$p], 0, 'C');
                    }else{
                        $pdf->MultiCell(20, 7,  '-', 0, 'C');
                    }
                    $hsn_code_y = $pdf->GetY() - $start_y;

                    if(!empty($product_quantity[$p])){
                        $pdf->SetY($start_y);
                        $pdf->SetX(110);
                        $pdf->MultiCell(20, 7,$product_quantity[$p]." ".$obj->encode_decode('decrypt', $unit_names[$p]), 0, 'C');
                    } else {
                        $pdf->SetY($start_y);
                        $pdf->SetX(110);
                        $pdf->MultiCell(20, 7,'', 0, 'C');
                    }
                    $product_quantity_y = $pdf->GetY() - $start_y;

                    if(!empty($product_price[$p])){
                        $pdf->SetY($start_y);
                        $pdf->SetX(130);
                        $pdf->MultiCell(20, 7,$obj->numberFormat($product_price[$p],2), 0, 'R');
                    } else {
                        $pdf->SetY($start_y);
                        $pdf->SetX(130);
                        $pdf->MultiCell(20, 7,'-', 0, 'C');
                    }
                    $product_price_y = $pdf->GetY() - $start_y;

                    if(!empty($product_tax[$p])){
                        $pdf->SetY($start_y);
                        $pdf->SetX(150);
                        $pdf->MultiCell(15, 7,$product_tax[$p], 0, 'R');
                    } else {
                        $pdf->SetY($start_y);
                        $pdf->SetX(150);
                        $pdf->MultiCell(15, 7,'-', 0, 'C');
                    }
                    $product_tax_y = $pdf->GetY() - $start_y;

                    if(!empty($product_amount[$p])){
                        $pdf->SetY($start_y);
                        $pdf->SetX(165);
                        $pdf->MultiCell(30, 7,$obj->numberFormat($product_amount[$p],2), 0, 'R');
                    } else {
                        $pdf->SetY($start_y);
                        $pdf->SetX(165);
                        $pdf->MultiCell(30, 7,'-', 0, 'C');
                    }
                    $product_amount_y = $pdf->GetY() - $start_y;

                    $y_array = array($product_names_y,$unit_names_y, $product_quantity_y,$product_price_y,$product_tax_y,$product_amount_y, $hsn_code_y);
                    $product_max = max($y_array);

                    $pdf->SetY($start_y);
                    $pdf->SetX(10);
                    $pdf->Cell(10,$product_max,'',1,0,'C');
                    $pdf->Cell(45,$product_max,'',1,0,'C');
                    $pdf->Cell(25,$product_max,'',1,0,'C');
                    $pdf->Cell(20,$product_max,'',1,0,'C');
                    $pdf->Cell(20,$product_max,'',1,0,'C');
                    $pdf->Cell(25,$product_max,'',1,0,'C');
                    $pdf->Cell(15,$product_max,'',1,0,'C');
                    $pdf->Cell(30,$product_max,'',1,1,'C');

                    $start_y += $product_max;
                    $s_no++;
                    $total_quantity += $product_quantity[$p];
                }
                else{
                    $pdf->SetY($start_y);
                    $pdf->SetX(10);
                    $pdf->Cell(10, 7, $s_no, 0, 0, 'C', 0);
                    $pdf->SetY($start_y);
                    $pdf->SetX(20);
                    if(!empty($product_names[$p])){
                        $pdf->MultiCell(50, 7, html_entity_decode($obj->encode_decode('decrypt', $product_names[$p])), 0, 'L');
                    }else{
                        $pdf->MultiCell(50, 7, '-', 0, 'L');
                    }

                    if(!empty($description[$p])){
                        $pdf->SetTextColor(128, 128, 128);
                        $pdf->SetFont('Arial', 'I', 8);
                        $pdf->SetX(20);
                        $pdf->MultiCell(50, 3,"Description : ".html_entity_decode($obj->encode_decode('decrypt', $description[$p])), 0, 'L');
                        $pdf->SetTextColor(0, 0, 0);
                        $pdf->SetFont('Arial', '', 8);
                    }
                    $product_names_y = $pdf->GetY() - $start_y;

                    $pdf->SetY($start_y);
                    $pdf->SetX(70);
                    if(!empty($size_names[$p])){
                        $pdf->MultiCell(25, 7,  html_entity_decode($obj->encode_decode('decrypt', $size_names[$p])), 0, 'C');
                    }
                    $unit_names_y = $pdf->GetY() - $start_y;

                    $pdf->SetY($start_y);
                    $pdf->SetX(95);
                    if(!empty($hsn_code[$p])){
                        $pdf->MultiCell(25, 7,  $hsn_code[$p], 0, 'C');
                    }else{
                        $pdf->MultiCell(25, 7,  '-', 0, 'C');
                    }
                    $hsn_code_y = $pdf->GetY() - $start_y;
                    
                    if(!empty($product_quantity[$p])){
                        $pdf->SetY($start_y);
                        $pdf->SetX(120);
                        $pdf->MultiCell(25, 7,$product_quantity[$p]."".$obj->encode_decode('decrypt', $unit_names[$p]), 0, 'C');
                    } else {
                        $pdf->SetY($start_y);
                        $pdf->SetX(120);
                        $pdf->MultiCell(25, 7,'', 0, 'C');
                    }
                    $product_quantity_y = $pdf->GetY() - $start_y;

                    if(!empty($product_price[$p])){
                        $pdf->SetY($start_y);
                        $pdf->SetX(145);
                        $pdf->MultiCell(25, 7,$obj->numberFormat($product_price[$p],2), 0, 'R');
                    } else {
                        $pdf->SetY($start_y);
                        $pdf->SetX(145);
                        $pdf->MultiCell(25, 7,'-', 0, 'C');
                    }
                    $product_price_y = $pdf->GetY() - $start_y;

                    if(!empty($product_amount[$p])){
                        $pdf->SetY($start_y);
                        $pdf->SetX(170);
                        $pdf->MultiCell(30, 7,$obj->numberFormat($product_amount[$p],2), 0, 'R');
                    } else {
                        $pdf->SetY($start_y);
                        $pdf->SetX(170);
                        $pdf->MultiCell(30, 7,'-', 0, 'C');
                    }
                    $product_amount_y = $pdf->GetY() - $start_y;


                    $y_array = array($product_names_y,$unit_names_y, $product_quantity_y,$product_price_y,$product_amount_y, $hsn_code_y);
                    $product_max = max($y_array);
                    // echo $product_max;

                    $pdf->SetY($start_y);
                    $pdf->SetX(10);
                    $pdf->Cell(10,$product_max,'',1,0,'C');
                    $pdf->Cell(50,$product_max,'',1,0,'C');
                    $pdf->Cell(25,$product_max,'',1,0,'C');
                    $pdf->Cell(25,$product_max,'',1,0,'C');
                    $pdf->Cell(25,$product_max,'',1,0,'C');
                    $pdf->Cell(25,$product_max,'',1,0,'C');
                    $pdf->Cell(30,$product_max,'',1,1,'C');

                    $start_y += $product_max;
                    $s_no++;
                    $total_quantity += $product_quantity[$p];
                }
            }
            
        }

        $end_y = $pdf->GetY();
        $last_page_count = $s_no - $last_count;
        if (($footer_height + $end_y) > 270) { 
            $y = $pdf->GetY();
            $pdf->SetY($y_axis);
            $pdf->SetX(10);

            if($tax_option == '2' && $tax_type == '2'){
                $pdf->Cell(10,(276 - $y_axis),'',1,0,'C',0);
                $pdf->Cell(45,(276 - $y_axis),'',1,0,'C',0);
                $pdf->Cell(20,(276 - $y_axis),'',1,0,'C',0);
                $pdf->Cell(20,(276 - $y_axis),'',1,0,'C',0);
                $pdf->Cell(20,(276 - $y_axis),'',1,0,'C',0);
                $pdf->Cell(20,(276 - $y_axis),'',1,0,'C',0);
                $pdf->Cell(20,(276 - $y_axis),'',1,0,'C',0);
                $pdf->Cell(30,(276 - $y_axis),'',1,1,'C',0);
            } elseif($tax_option == '2' && $tax_type == '1'){
                $pdf->Cell(10,(276 - $y_axis),'',1,0,'C',0);
                $pdf->Cell(45,(276 - $y_axis),'',1,0,'C',0);
                $pdf->Cell(20,(276 - $y_axis),'',1,0,'C',0);
                $pdf->Cell(20,(276 - $y_axis),'',1,0,'C',0);
                $pdf->Cell(20,(276 - $y_axis),'',1,0,'C',0);
                $pdf->Cell(20,(276 - $y_axis),'',1,0,'C',0);
                $pdf->Cell(20,(276 - $y_axis),'',1,0,'C',0);
                $pdf->Cell(15,(276 - $y_axis),'',1,0,'C',0);
                $pdf->Cell(20,(276 - $y_axis),'',1,1,'C',0);
            } elseif($tax_type == '1'){
                $pdf->Cell(10,(276 - $y_axis),'',1,0,'C',0);
                $pdf->Cell(45,(276 - $y_axis),'',1,0,'C',0);
                $pdf->Cell(25,(276 - $y_axis),'',1,0,'C',0);
                $pdf->Cell(20,(276 - $y_axis),'',1,0,'C',0);
                $pdf->Cell(20,(276 - $y_axis),'',1,0,'C',0);
                $pdf->Cell(25,(276 - $y_axis),'',1,0,'C',0);
                $pdf->Cell(15,(276 - $y_axis),'',1,0,'C',0);
                $pdf->Cell(30,(276 - $y_axis),'',1,1,'C',0);
            } else {
                $pdf->Cell(10,(276 - $y_axis),'',1,0,'C',0);
                $pdf->Cell(50,(276 - $y_axis),'',1,0,'C',0);
                $pdf->Cell(25,(276 - $y_axis),'',1,0,'C',0);
                $pdf->Cell(25,(276 - $y_axis),'',1,0,'C',0);
                $pdf->Cell(25,(276 - $y_axis),'',1,0,'C',0);
                $pdf->Cell(25,(276 - $y_axis),'',1,0,'C',0);
                $pdf->Cell(30,(276 - $y_axis),'',1,1,'C',0);    
            }
                
            $pdf->SetFont('Arial','I',7);
            $pdf->SetY(-15);
            $pdf->SetX(10);
            $pdf->Cell(190,4,'Page No : '.$pdf->PageNo().' / {nb}',0,0,'R');
            $pdf->AddPage();
            $pdf->SetAutoPageBreak(false);
            $pdf->SetTitle('Estimate');
            $pdf->SetFont('Arial', 'B', 10);
            $pdf->SetFont('Arial', 'BI', 10);
            $height = 0;
            $display = '';
            $y2 = $pdf->GetY();
            $y = $pdf->GetY();
            $pdf->SetFont('Arial', 'B', 12);
            $pdf->SetY(11);
            $file_name = 'Estimate';
            include("rpt_header.php");
            if($cancelled == '0'){
                include("rpt_watermark.php");
            }
            if($cancelled == '1') {
                if(file_exists('../include/images/cancelled.jpg')) {
                    $pdf->SetAlpha(0.3);
                    $pdf->Image('../include/images/cancelled.jpg',45,110,125,70);
                    $pdf->SetAlpha(1);
                }
            }     
            $bill_to_y = $pdf->GetY();
            $pdf->SetFont('Arial','B',10);
            $pdf->SetX(10);
            $pdf->Cell(0,1,'',0,1,'L',0);
            $pdf->Cell(63,4,'To : ',0,1,'L',0);
            $pdf->Cell(0,1,'',0,1,'L',0);
            $pdf->SetFont('Arial','B',10);
            $pdf->SetX(12);
            if(!empty($party_details)){
                for($i=0;$i<count($party_details);$i++){
                    if($party_details[$i]!="NULL" && $party_details[$i]!=""){
                        $pdf->SetFont('Arial','',9);
                        $pdf->SetX(15);
                        if($i==0)
                        {
                            $pdf->SetFont('Arial','B',9);
                            $pdf->Cell(65,4,$party_details[$i],0,1,'L',0);
                            $pdf->Cell(0,1,'',0,1,'L',0);
                        }
                        else{
                            $party_details[$i] = trim($party_details[$i]);
                            $pdf->MultiCell(90,4,$party_details[$i],0,'L',0);
                            $pdf->Cell(0,0.7,'',0,1,'L',0);
                        }
                    }
                }
            }
            $party_y = $pdf->GetY();
            $pdf->SetFont('Arial','B',10);
            $pdf->SetY($bill_to_y);
            $pdf->SetX(113);
            $pdf->Cell(80,8,'Estimate No.              :  ',0,0,'L',0);

            $pdf->SetFont('Arial','',9);
            $pdf->SetX(153);
            $pdf->Cell(40,8,$estimate_number,0,1,'L',0);

            $pdf->SetFont('Arial','B',10);
            $pdf->SetX(113);
            $pdf->Cell(30,8,'Dated                          : ',0,0,'L',0);

            $pdf->SetFont('Arial','',9);
            $pdf->SetX(153);
            $pdf->Cell(40,8,date('d-m-Y',strtotime($estimate_date)),0,1,'L',0);
            $bill_to_y2 = $pdf->GetY();
            $y_array = array($party_y,$bill_to_y2);
            $max_bill_y = max($y_array);
            $pdf->SetY($bill_to_y);
            $pdf->SetX(10);
            $pdf->Cell(100,40,'',1,0,'L',0);
            $pdf->SetX(110);
            $pdf->Cell(90,40,'',1,1,'L',0);

             
            $pdf->SetFont('Arial','B',9);   
            $y=$pdf->GetY();
            $pdf->SetX(10);
            $pdf->SetFillColor(52,58,64);
            $pdf->SetTextColor(255,255,255);
            
            if($tax_option == '2' && $tax_type == '2'){
                $pdf->Cell(10,8,'S.No',1,0,'C',1);
                $pdf->Cell(45,8,'Product Name',1,0,'C',1);
                $pdf->Cell(25,8,'Size',1,0,'C',1);
                $pdf->Cell(20,8,'HSN Code',1,0,'C',1);
                $pdf->Cell(20,8,'QTY/Unit',1,0,'C',1);
                $pdf->Cell(20,8,'Rate',1,0,'C',1);
                $pdf->Cell(20,8,'Final rate',1,0,'C',1);
                $pdf->Cell(30,8,'Amount',1,1,'C',1);
            } elseif($tax_option == '2' && $tax_type == '1'){
                $pdf->Cell(10,8,'S.No',1,0,'C',1);
                $pdf->Cell(45,8,'Product Name',1,0,'C',1);
                $pdf->Cell(20,8,'Size',1,0,'C',1);
                $pdf->Cell(20,8,'HSN Code',1,0,'C',1);
                $pdf->Cell(20,8,'QTY/Unit',1,0,'C',1);
                $pdf->Cell(20,8,'Rate',1,0,'C',1);
                $pdf->Cell(20,8,'Final rate',1,0,'C',1);
                $pdf->Cell(15,8,'Tax',1,0,'C',1);
                $pdf->Cell(20,8,'Amount',1,1,'C',1);
            } elseif($tax_type == '1'){
                $pdf->Cell(10,8,'S.No',1,0,'C',1);
                $pdf->Cell(45,8,'Product Name',1,0,'C',1);
                $pdf->Cell(25,8,'Size',1,0,'C',1);
                $pdf->Cell(20,8,'HSN Code',1,0,'C',1);
                $pdf->Cell(20,8,'QTY/Unit',1,0,'C',1);
                $pdf->Cell(25,8,'Rate',1,0,'C',1);
                $pdf->Cell(15,8,'Tax',1,0,'C',1);
                $pdf->Cell(30,8,'Amount',1,1,'C',1);
            } else {
                $pdf->Cell(10,8,'S.No',1,0,'C',1);
                $pdf->Cell(50,8,'Product Name',1,0,'C',1);
                $pdf->Cell(25,8,'Size',1,0,'C',1);
                $pdf->Cell(25,8,'HSN Code',1,0,'C',1);
                $pdf->Cell(25,8,'QTY/Unit',1,0,'C',1);
                $pdf->Cell(25,8,'Rate',1,0,'C',1);
                $pdf->Cell(30,8,'Amount',1,1,'C',1);    
            }
                
            $pdf->SetFont('Arial','',8);
            $pdf->SetTextColor(0,0,0);
            $y_axis = $pdf->GetY();
            $content_height = 265 - $footer_height;
            $pdf->SetY($y_axis);
            $pdf->SetX(10);

            if($tax_option == '2' && $tax_type == '2'){
                $pdf->Cell(10,($content_height - $y_axis),'',1,0,'C',0);
                $pdf->Cell(45,($content_height - $y_axis),'',1,0,'C',0);
                $pdf->Cell(25,($content_height - $y_axis),'',1,0,'C',0);
                $pdf->Cell(20,($content_height - $y_axis),'',1,0,'C',0);
                $pdf->Cell(20,($content_height - $y_axis),'',1,0,'C',0);
                $pdf->Cell(20,($content_height - $y_axis),'',1,0,'C',0);
                $pdf->Cell(20,($content_height - $y_axis),'',1,0,'C',0);
                $pdf->Cell(30,($content_height - $y_axis),'',1,1,'C',0);
            } elseif($tax_option == '2' && $tax_type == '1'){
                $pdf->Cell(10,($content_height - $y_axis),'',1,0,'C',0);
                $pdf->Cell(45,($content_height - $y_axis),'',1,0,'C',0);
                $pdf->Cell(20,($content_height - $y_axis),'',1,0,'C',0);
                $pdf->Cell(20,($content_height - $y_axis),'',1,0,'C',0);
                $pdf->Cell(20,($content_height - $y_axis),'',1,0,'C',0);
                $pdf->Cell(20,($content_height - $y_axis),'',1,0,'C',0);
                $pdf->Cell(20,($content_height - $y_axis),'',1,0,'C',0);
                $pdf->Cell(15,($content_height - $y_axis),'',1,0,'C',0);
                $pdf->Cell(20,($content_height - $y_axis),'',1,1,'C',0);
            } elseif($tax_type == '1'){
                $pdf->Cell(10,($content_height - $y_axis),'',1,0,'C',0);
                $pdf->Cell(45,($content_height - $y_axis),'',1,0,'C',0);
                $pdf->Cell(25,($content_height - $y_axis),'',1,0,'C',0);
                $pdf->Cell(20,($content_height - $y_axis),'',1,0,'C',0);
                $pdf->Cell(20,($content_height - $y_axis),'',1,0,'C',0);
                $pdf->Cell(25,($content_height - $y_axis),'',1,0,'C',0);
                $pdf->Cell(15,($content_height - $y_axis),'',1,0,'C',0);
                $pdf->Cell(30,($content_height - $y_axis),'',1,1,'C',0);
            } else {
                $pdf->Cell(10,($content_height - $y_axis),'',1,0,'C',0);
                $pdf->Cell(50,($content_height - $y_axis),'',1,0,'C',0);
                $pdf->Cell(25,($content_height - $y_axis),'',1,0,'C',0);
                $pdf->Cell(25,($content_height - $y_axis),'',1,0,'C',0);
                $pdf->Cell(25,($content_height - $y_axis),'',1,0,'C',0);
                $pdf->Cell(25,($content_height - $y_axis),'',1,0,'C',0);
                $pdf->Cell(30,($content_height - $y_axis),'',1,1,'C',0);    
            }
                
        }else{
            $content_height = 265 - $footer_height;
            $pdf->SetY($y_axis);
            $pdf->SetX(10);

            if($tax_option == '2' && $tax_type == '2'){
                $pdf->Cell(10,($content_height - $y_axis),'',1,0,'C',0);
                $pdf->Cell(45,($content_height - $y_axis),'',1,0,'C',0);
                $pdf->Cell(25,($content_height - $y_axis),'',1,0,'C',0);
                $pdf->Cell(20,($content_height - $y_axis),'',1,0,'C',0);
                $pdf->Cell(20,($content_height - $y_axis),'',1,0,'C',0);
                $pdf->Cell(20,($content_height - $y_axis),'',1,0,'C',0);
                $pdf->Cell(20,($content_height - $y_axis),'',1,0,'C',0);
                $pdf->Cell(30,($content_height - $y_axis),'',1,1,'C',0);
            } elseif($tax_option == '2' && $tax_type == '1'){
                $pdf->Cell(10,($content_height - $y_axis),'',1,0,'C',0);
                $pdf->Cell(45,($content_height - $y_axis),'',1,0,'C',0);
                $pdf->Cell(20,($content_height - $y_axis),'',1,0,'C',0);
                $pdf->Cell(20,($content_height - $y_axis),'',1,0,'C',0);
                $pdf->Cell(20,($content_height - $y_axis),'',1,0,'C',0);
                $pdf->Cell(20,($content_height - $y_axis),'',1,0,'C',0);
                $pdf->Cell(20,($content_height - $y_axis),'',1,0,'C',0);
                $pdf->Cell(15,($content_height - $y_axis),'',1,0,'C',0);
                $pdf->Cell(20,($content_height - $y_axis),'',1,1,'C',0);
            } elseif($tax_type == '1'){
                $pdf->Cell(10,($content_height - $y_axis),'',1,0,'C',0);
                $pdf->Cell(45,($content_height - $y_axis),'',1,0,'C',0);
                $pdf->Cell(25,($content_height - $y_axis),'',1,0,'C',0);
                $pdf->Cell(20,($content_height - $y_axis),'',1,0,'C',0);
                $pdf->Cell(20,($content_height - $y_axis),'',1,0,'C',0);
                $pdf->Cell(25,($content_height - $y_axis),'',1,0,'C',0);
                $pdf->Cell(15,($content_height - $y_axis),'',1,0,'C',0);
                $pdf->Cell(30,($content_height - $y_axis),'',1,1,'C',0);
            } else {
                $pdf->Cell(10,($content_height - $y_axis),'',1,0,'C',0);
                $pdf->Cell(50,($content_height - $y_axis),'',1,0,'C',0);
                $pdf->Cell(25,($content_height - $y_axis),'',1,0,'C',0);
                $pdf->Cell(25,($content_height - $y_axis),'',1,0,'C',0);
                $pdf->Cell(25,($content_height - $y_axis),'',1,0,'C',0);
                $pdf->Cell(25,($content_height - $y_axis),'',1,0,'C',0);
                $pdf->Cell(30,($content_height - $y_axis),'',1,1,'C',0);    
            }
                
        }


        if($tax_option == '2' && $tax_type == '2'){
            if(!empty($total_quantity)){
                $pdf->SetX(10);
                $pdf->SetFont('Arial','B',8.5);
                $pdf->Cell(100,6.5,'Total Qty',1,0,'R',0);
                $pdf->SetFont('Arial','',8.5);
                $pdf->Cell(20,6.5,$total_quantity,1,0,'C',0);
            }


            if(!empty($sub_total)) {
                $pdf->SetX(10);
                $pdf->SetFont('Arial','B',8.5);
                $pdf->Cell(160,6.5,'Sub Total',1,0,'R',0);
                $pdf->SetFont('Arial','',8.5);
                $pdf->Cell(30,6.5,$obj->numberFormat($sub_total,2),1,1,'R',0);
            }

            if(!empty($discount_value)){
                $pdf->SetX(10);
                $pdf->SetFont('Arial','B',8.5);
                $pdf->Cell(160,6,$discount_name. " (" .$discount. ")",1,0,'R',0);
                $pdf->SetFont('Arial','',8.5);
                $pdf->Cell(30,6,$discount_value,1,1,'R',0);

                $pdf->SetX(10);
                $pdf->SetFont('Arial','B',8.5);
                $pdf->Cell(160,6,'Discounted Total',1,0,'R',0);
                $pdf->SetFont('Arial','',8.5);
                $pdf->Cell(30,6,$obj->numberFormat($discounted_total,2),1,1,'R',0);
            }

            if(!empty($extra_charges_value)){
                $pdf->SetX(10);
                $pdf->SetFont('Arial','B',8.5);
                $pdf->Cell(160,6,$extra_charges_name. " (" .$extra_charges. ")",1,0,'R',0);
                $pdf->SetFont('Arial','',8.5);
                $pdf->Cell(30,6,$extra_charges_value,1,1,'R',0);

                $pdf->SetX(10);
                $pdf->SetFont('Arial','B',8.5);
                $pdf->Cell(160,6,'Charges Total',1,0,'R',0);
                $pdf->SetFont('Arial','',8.5);
                $pdf->Cell(30,6,$obj->numberFormat($extra_charges_total,2),1,1,'R',0);
            }

            if($company_state == $party_state){
                $tax_value = ""; $tax = "";
                if(!empty($overall_tax)){
                    $tax_value = str_replace('%','',$overall_tax);
                    $tax = $tax_value / 2;
                    $tax = ' ('.$tax.'%)';
                }
                if(!empty($gst_option)){
                    $pdf->SetX(10);
                    $pdf->SetFont('Arial','B',8.5);
                    $pdf->Cell(160,6,'CGST'. $tax,1,0,'R',0);
                    $pdf->SetFont('Arial','',8.5);
                    $pdf->Cell(30,6,number_format($cgst_value,2),1,1,'R',0);   
                    $pdf->SetX(10);
                    $pdf->SetFont('Arial','B',8.5);
                    $pdf->Cell(160,6,'SGST'. $tax,1,0,'R',0);
                    $pdf->SetFont('Arial','',8.5);
                    $pdf->Cell(30,6,number_format($sgst_value,2),1,1,'R',0);   
                }
            }
            else{
                $tax_value = "";
                if(!empty($overall_tax)){
                    $tax_value = $overall_tax;
                }
                $pdf->SetX(10);
                $pdf->SetFont('Arial','B',8.5);
                $pdf->Cell(160,6,'IGST',1,0,'R',0);
                $pdf->SetFont('Arial','',8.5);
                $pdf->Cell(30,6,$igst_value,1,1,'R',0);
            }

            if(!empty($round_off)){
                $pdf->SetX(10);
                $pdf->SetFont('Arial','B',8.5);
                $pdf->Cell(160,6,'Round Off',1,0,'R',0);
                $pdf->SetFont('Arial','',8.5);
                $pdf->Cell(30,6,$obj->numberFormat($round_off,2),1,1,'R',0);
            }

            if(!empty($bill_total)) {
                $pdf->SetX(10);
                $pdf->SetFont('Arial','B',8.5);
                $pdf->Cell(160,6.5,'Total',1,0,'R',0);
                $pdf->SetFont('Arial','',8.5);
                $pdf->Cell(30,6.5,$obj->numberFormat($bill_total,2),1,1,'R',0);
            }

        } elseif($tax_option == '2' && $tax_type == '1'){
            if(!empty($total_quantity)){
                $pdf->SetX(10);
                $pdf->SetFont('Arial','B',8.5);
                $pdf->Cell(95,6.5,'Total Qty',1,0,'R',0);
                $pdf->SetFont('Arial','',8.5);
                $pdf->Cell(20,6.5,$total_quantity,1,0,'R',0);
            }


            if(!empty($sub_total)) {
                $pdf->SetX(10);
                $pdf->SetFont('Arial','B',8.5);
                $pdf->Cell(155,6.5,'Sub Total',1,0,'R',0);
                $pdf->SetFont('Arial','',8.5);
                $pdf->Cell(35,6.5,$obj->numberFormat($sub_total,2),1,1,'R',0);
            }

            if(!empty($discount_value)){
                $pdf->SetX(10);
                $pdf->SetFont('Arial','B',8.5);
                $pdf->Cell(155,6,$discount_name. " (" .$discount. ")",1,0,'R',0);
                $pdf->SetFont('Arial','',8.5);
                $pdf->Cell(35,6,$discount_value,1,1,'R',0);

                $pdf->SetX(10);
                $pdf->SetFont('Arial','B',8.5);
                $pdf->Cell(155,6,'Discounted Total',1,0,'R',0);
                $pdf->SetFont('Arial','',8.5);
                $pdf->Cell(35,6,$obj->numberFormat($discounted_total,2),1,1,'R',0);
            }

            if(!empty($extra_charges_value)){
                $pdf->SetX(10);
                $pdf->SetFont('Arial','B',8.5);
                $pdf->Cell(155,6,$extra_charges_name. " (" .$extra_charges. ")",1,0,'R',0);
                $pdf->SetFont('Arial','',8.5);
                $pdf->Cell(35,6,$extra_charges_value,1,1,'R',0);

                $pdf->SetX(10);
                $pdf->SetFont('Arial','B',8.5);
                $pdf->Cell(155,6,'Charges Total',1,0,'R',0);
                $pdf->SetFont('Arial','',8.5);
                $pdf->Cell(35,6,$obj->numberFormat($extra_charges_total,2),1,1,'R',0);
            }

            if($company_state == $party_state){
                $tax_value = ""; $tax = "";
                if(!empty($overall_tax)){
                    $tax_value = str_replace('%','',$overall_tax);
                    $tax = $tax_value / 2;
                    $tax = ' ('.$tax.'%)';
                }
                if(!empty($gst_option)){
                    $pdf->SetX(10);
                    $pdf->SetFont('Arial','B',8.5);
                    $pdf->Cell(155,6,'CGST'. $tax,1,0,'R',0);
                    $pdf->SetFont('Arial','',8.5);
                    $pdf->Cell(35,6,number_format($cgst_value,2),1,1,'R',0);   
                    $pdf->SetX(10);
                    $pdf->SetFont('Arial','B',8.5);
                    $pdf->Cell(155,6,'SGST'. $tax,1,0,'R',0);
                    $pdf->SetFont('Arial','',8.5);
                    $pdf->Cell(35,6,number_format($sgst_value,2),1,1,'R',0);   
                }
            }
            else{
                $tax_value = "";
                if(!empty($overall_tax)){
                    $tax_value = $overall_tax;
                }
                $pdf->SetX(10);
                $pdf->SetFont('Arial','B',8.5);
                $pdf->Cell(155,6,'IGST',1,0,'R',0);
                $pdf->SetFont('Arial','',8.5);
                $pdf->Cell(35,6,$igst_value,1,1,'R',0);
            }

            if(!empty($round_off)){
                $pdf->SetX(10);
                $pdf->SetFont('Arial','B',8.5);
                $pdf->Cell(155,6,'Round Off',1,0,'R',0);
                $pdf->SetFont('Arial','',8.5);
                $pdf->Cell(35,6,$obj->numberFormat($round_off,2),1,1,'R',0);
            }

            if(!empty($bill_total)) {
                $pdf->SetX(10);
                $pdf->SetFont('Arial','B',8.5);
                $pdf->Cell(155,6.5,'Total',1,0,'R',0);
                $pdf->SetFont('Arial','',8.5);
                $pdf->Cell(35,6.5,$obj->numberFormat($bill_total,2),1,1,'R',0);
            }
        } elseif($tax_type == '1'){
            if(!empty($total_quantity)){
                $pdf->SetX(10);
                $pdf->SetFont('Arial','B',8.5);
                $pdf->Cell(100,6.5,'Total Qty',1,0,'R',0);
                $pdf->SetFont('Arial','',8.5);
                $pdf->Cell(20,6.5,$total_quantity,1,0,'C',0);
            }


            if(!empty($sub_total)) {
                $pdf->SetX(10);
                $pdf->SetFont('Arial','B',8.5);
                $pdf->Cell(160,6.5,'Sub Total',1,0,'R',0);
                $pdf->SetFont('Arial','',8.5);
                $pdf->Cell(30,6.5,$obj->numberFormat($sub_total,2),1,1,'R',0);
            }

            if(!empty($discount_value)){
                $pdf->SetX(10);
                $pdf->SetFont('Arial','B',8.5);
                $pdf->Cell(160,6,$discount_name. " (" .$discount. ")",1,0,'R',0);
                $pdf->SetFont('Arial','',8.5);
                $pdf->Cell(30,6,$discount_value,1,1,'R',0);

                $pdf->SetX(10);
                $pdf->SetFont('Arial','B',8.5);
                $pdf->Cell(160,6,'Discounted Total',1,0,'R',0);
                $pdf->SetFont('Arial','',8.5);
                $pdf->Cell(30,6,$obj->numberFormat($discounted_total,2),1,1,'R',0);
            }

            if(!empty($extra_charges_value)){
                $pdf->SetX(10);
                $pdf->SetFont('Arial','B',8.5);
                $pdf->Cell(160,6,$extra_charges_name. " (" .$extra_charges. ")",1,0,'R',0);
                $pdf->SetFont('Arial','',8.5);
                $pdf->Cell(30,6,$extra_charges_value,1,1,'R',0);

                $pdf->SetX(10);
                $pdf->SetFont('Arial','B',8.5);
                $pdf->Cell(160,6,'Charges Total',1,0,'R',0);
                $pdf->SetFont('Arial','',8.5);
                $pdf->Cell(30,6,$obj->numberFormat($extra_charges_total,2),1,1,'R',0);
            }

            if($company_state == $party_state){
                $tax_value = ""; $tax = "";
                if(!empty($overall_tax)){
                    $tax_value = str_replace('%','',$overall_tax);
                    $tax = $tax_value / 2;
                    $tax = ' ('.$tax.'%)';
                }
                if(!empty($gst_option)){
                    $pdf->SetX(10);
                    $pdf->SetFont('Arial','B',8.5);
                    $pdf->Cell(160,6,'CGST'. $tax,1,0,'R',0);
                    $pdf->SetFont('Arial','',8.5);
                    $pdf->Cell(30,6,number_format($cgst_value,2),1,1,'R',0);   
                    $pdf->SetX(10);
                    $pdf->SetFont('Arial','B',8.5);
                    $pdf->Cell(160,6,'SGST'. $tax,1,0,'R',0);
                    $pdf->SetFont('Arial','',8.5);
                    $pdf->Cell(30,6,number_format($sgst_value,2),1,1,'R',0);   
                }
            }
            else{
                $tax_value = "";
                if(!empty($overall_tax)){
                    $tax_value = $overall_tax;
                }
                $pdf->SetX(10);
                $pdf->SetFont('Arial','B',8.5);
                $pdf->Cell(160,6,'IGST',1,0,'R',0);
                $pdf->SetFont('Arial','',8.5);
                $pdf->Cell(30,6,$igst_value,1,1,'R',0);
            }

            if(!empty($round_off)){
                $pdf->SetX(10);
                $pdf->SetFont('Arial','B',8.5);
                $pdf->Cell(160,6,'Round Off',1,0,'R',0);
                $pdf->SetFont('Arial','',8.5);
                $pdf->Cell(30,6,$obj->numberFormat($round_off,2),1,1,'R',0);
            }

            if(!empty($bill_total)) {
                $pdf->SetX(10);
                $pdf->SetFont('Arial','B',8.5);
                $pdf->Cell(160,6.5,'Total',1,0,'R',0);
                $pdf->SetFont('Arial','',8.5);
                $pdf->Cell(30,6.5,$obj->numberFormat($bill_total,2),1,1,'R',0);
            }
        } else {
            if(!empty($total_quantity)){
                $pdf->SetX(10);
                $pdf->SetFont('Arial','B',8.5);
                $pdf->Cell(110,6.5,'Total Qty',1,0,'R',0);
                $pdf->SetFont('Arial','',8.5);
                $pdf->Cell(25,6.5,$total_quantity,1,0,'C',0);
            }


            if(!empty($sub_total)) {
                $pdf->SetX(10);
                $pdf->SetFont('Arial','B',8.5);
                $pdf->Cell(160,6.5,'Sub Total',1,0,'R',0);
                $pdf->SetFont('Arial','',8.5);
                $pdf->Cell(30,6.5,$obj->numberFormat($sub_total,2),1,1,'R',0);
            }

            if(!empty($discount_value)){
                $pdf->SetX(10);
                $pdf->SetFont('Arial','B',8.5);
                $pdf->Cell(160,6,$discount_name. " (" .$discount. ")",1,0,'R',0);
                $pdf->SetFont('Arial','',8.5);
                $pdf->Cell(30,6,$discount_value,1,1,'R',0);

                $pdf->SetX(10);
                $pdf->SetFont('Arial','B',8.5);
                $pdf->Cell(160,6,'Discounted Total',1,0,'R',0);
                $pdf->SetFont('Arial','',8.5);
                $pdf->Cell(30,6,$obj->numberFormat($discounted_total,2),1,1,'R',0);
            }

            if(!empty($extra_charges_value)){
                $pdf->SetX(10);
                $pdf->SetFont('Arial','B',8.5);
                $pdf->Cell(160,6,$extra_charges_name. " (" .$extra_charges. ")",1,0,'R',0);
                $pdf->SetFont('Arial','',8.5);
                $pdf->Cell(30,6,$extra_charges_value,1,1,'R',0);

                $pdf->SetX(10);
                $pdf->SetFont('Arial','B',8.5);
                $pdf->Cell(160,6,'Charges Total',1,0,'R',0);
                $pdf->SetFont('Arial','',8.5);
                $pdf->Cell(30,6,$obj->numberFormat($extra_charges_total,2),1,1,'R',0);
            }

            if($gst_option == '1'){
                if($company_state == $party_state){
                    $tax_value = ""; $tax = "";
                    if(!empty($overall_tax)){
                        $tax_value = str_replace('%','',$overall_tax);
                        $tax = $tax_value / 2;
                        $tax = ' ('.$tax.'%)';
                    }
                    
                    $pdf->SetX(10);
                    $pdf->SetFont('Arial','B',8.5);
                    $pdf->Cell(160,6,'CGST'. $tax,1,0,'R',0);
                    $pdf->SetFont('Arial','',8.5);
                    $pdf->Cell(30,6,number_format($cgst_value,2),1,1,'R',0);   
                    $pdf->SetX(10);
                    $pdf->SetFont('Arial','B',8.5);
                    $pdf->Cell(160,6,'SGST'. $tax,1,0,'R',0);
                    $pdf->SetFont('Arial','',8.5);
                    $pdf->Cell(30,6,number_format($sgst_value,2),1,1,'R',0); 
                }
                else{
                    $tax_value = "";
                    if(!empty($overall_tax)){
                        $tax_value = $overall_tax;
                    }
                    $pdf->SetX(10);
                    $pdf->SetFont('Arial','B',8.5);
                    $pdf->Cell(160,6,'IGST',1,0,'R',0);
                    $pdf->SetFont('Arial','',8.5);
                    $pdf->Cell(30,6,$igst_value,1,1,'R',0);
                }
            }
            

            if(!empty($round_off)){
                $pdf->SetX(10);
                $pdf->SetFont('Arial','B',8.5);
                $pdf->Cell(160,6,'Round Off',1,0,'R',0);
                $pdf->SetFont('Arial','',8.5);
                $pdf->Cell(30,6,$obj->numberFormat($round_off,2),1,1,'R',0);
            }

            if(!empty($bill_total)) {
                $pdf->SetX(10);
                $pdf->SetFont('Arial','B',8.5);
                $pdf->Cell(160,6.5,'Total',1,0,'R',0);
                $pdf->SetFont('Arial','',8.5);
                $pdf->Cell(30,6.5,$obj->numberFormat($bill_total,2),1,1,'R',0);
            }
        }
            

        $y3=$pdf->getY();
        $pdf->SetFont('Arial','',8);
        $pdf->SetX(10);
        $pdf->Cell(40,5,'Amount Chargeable (in words)',0,0,'L',0);
        $pdf->SetX(10);
        $pdf->Cell(0,5,'E. & O.E',0,1,'R',0);
        $pdf->SetFont('Arial','B',8);
        $pdf->SetX(10);
        $pdf->Cell(150,5,getIndianCurrency($bill_total).' Only',0,1,'L',0);
        $y31=$pdf->GetY();
        $pdf->SetY($y3);
        $pdf->Cell(0,$y31-$y3,'',1,1,'L');
        
        $line_y = $pdf->GetY();

        $pdf->SetFont('Arial', 'BU', 8);
        $pdf->SetX(10);

        $pdf->SetY($line_y+2);
        $pdf->SetX(155);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->SetY($line_y);
        $pdf->SetFont('Arial','BU',9);
        $pdf->Cell(100,5,'Declaration', 0, 1, '');
        $pdf->SetY($line_y);
        $pdf->SetFont('Arial', 'B', 9);

        $pdf->SetX(160);
        $pdf->MultiCell(40, 5,html_entity_decode($company_name), 0, 'L', 0);
        $pdf->SetFont('Arial','',8);
        $pdf->SetY($line_y+5);
        $pdf->setX(13);
        $pdf->MultiCell(90,4,'* We declare that this bill shows the actual price of the goods described and that all particulars are true and correct. ', 0, 1, '');
        
        $pdf->setX(13);
        if(!empty($company_city) && $company_city!=$GLOBALS['null_value']){
            $pdf->MultiCell(90,6,'* Subject to '.strtoupper($company_city).' jurisdiction only', 0, 1, '');
        }else{
            $pdf->MultiCell(90,6,'* Subject to SIVAKASI jurisdiction only', 0, 1, '');
        }
        $pdf->Cell(190,2,'', 0, 1, 'C');
        $pdf->SetFont('Arial', '', 9);

        $pdf->SetY($line_y+15);
        $pdf->SetX(157);
        $pdf->Cell(90, 5, 'Authorized Signatory', 0, 1, 'L', 0);
        $end_y = $pdf->GetY();

        $pdf->SetFont('Arial', '', 7);
        $pdf->SetY(10);
        $pdf->SetX(10);
        $pdf->Cell(190, ($end_y-10), '', 1, 1, 'C');

        $pdf->SetY(-10);
        $pdf->Cell(190,3,'***This is a Computer Generated bill. Hence Digital Signature is not required.***',0,0,'C',0);
        
        
        $pdf->SetFont('Arial','I',7);
        $pdf->setY(-10);
        $pdf->SetX(10);
        $pdf->Cell(190,4,'Page No : '.$pdf->PageNo().' / {nb}',0,0,'R');


        
        $pdf->OutPut('', $estimate_number);

    }
?>
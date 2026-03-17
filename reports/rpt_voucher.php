<?php
    include("../include_user_check_and_files.php");
    include("../include/number2words.php");

    $view_voucher_id = "";
    if(isset($_REQUEST['view_voucher_id'])) {
        $view_voucher_id = $_REQUEST['view_voucher_id'];
    }
    $from = "";
    if(isset($_REQUEST['from'])) {
        $from = $_REQUEST['from'];
    }

    $voucher_list = array();
    $voucher_list = $obj->getAllRecords($GLOBALS['voucher_table'], 'voucher_id', $view_voucher_id);

    $voucher_number = ""; $voucher_date = ""; $party_id = ""; $party_name = "";$narration = ""; $amounts = array(); $payment_mode_names = array(); $bank_names = array(); $total_amount = 0; $deleted = 0; $company_id = "";

    if(!empty($voucher_list)) {
        foreach($voucher_list as $data) {
            $company_id = !empty($data['bill_company_id']) ? $data['bill_company_id'] : $GLOBALS['bill_company_id'];
            $voucher_number = !empty($data['voucher_number']) ? $data['voucher_number'] : "";
            $voucher_date = (!empty($data['voucher_date']) && $data['voucher_date'] != "0000-00-00") ? date('d-m-Y', strtotime($data['voucher_date'])) : "";
            $party_id = !empty($data['party_id']) ? $data['party_id'] : "";
            $party_name = !empty($data['party_name']) ? $obj->encode_decode('decrypt', $data['party_name']) : "";
            $narration = !empty($data['narration']) ? $obj->encode_decode('decrypt', $data['narration']) : "";
            
            if(!empty($data['amount'])) {
                $amounts = explode(',', $data['amount']);
                $amounts = array_reverse($amounts);
            }
            if(!empty($data['payment_mode_name'])) {
                $payment_mode_names = explode(',', $data['payment_mode_name']);
                $payment_mode_names = array_reverse($payment_mode_names);
            }
            if(!empty($data['bank_name'])) {
                $bank_names = explode(',', $data['bank_name']);
                $bank_names = array_reverse($bank_names);
            }
            $total_amount = !empty($data['total_amount']) ? $data['total_amount'] : 0;
            $deleted = !empty($data['deleted']) ? $data['deleted'] : 0;
        }
    }

    $company_name = ""; $company_city = ""; $company_district = ""; $company_state = ""; $company_mobile_number = ""; $company_gst_number = "";
    $company_data = $obj->getTableRecords($GLOBALS['company_table'], 'company_id', $company_id, '');
    if(!empty($company_data)) {
        foreach($company_data as $data) {
            $company_name = $obj->encode_decode('decrypt', $data['name']);
            $company_city = $obj->encode_decode('decrypt', $data['city']);
            $company_district = $obj->encode_decode('decrypt', $data['district']);
            $company_state = $obj->encode_decode('decrypt', $data['state']);
            $company_mobile_number = $obj->encode_decode('decrypt', $data['mobile_number']);
            $company_gst_number = $obj->encode_decode('decrypt', $data['gst_number']);
        }
    }

    $party_mobile_number = ""; $party_address = ""; $party_city = "";
    $party_data = $obj->getTableRecords($GLOBALS['party_table'], 'party_id', $party_id, '');
    if(!empty($party_data)) {
        foreach($party_data as $data) {
            $party_mobile_number = $obj->encode_decode('decrypt', $data['mobile_number']);
            $party_address = $obj->encode_decode('decrypt', $data['address']);
            $party_city = $obj->encode_decode('decrypt', $data['city']);
        }
    }

    require_once('../fpdf/AlphaPDF.php');
    $pdf = new AlphaPDF('L','mm','A5');
    $pdf->AliasNbPages(); 
    $pdf->AddPage();
    $pdf->SetAutoPageBreak(false);
    $pdf->SetTitle('Voucher');
    
    $pdf->SetY(10);
    $pdf->Cell(190,128,'',1,0,'C');
    
    if($deleted == '1') {
        if(file_exists('../include/images/cancelled.jpg')) {
            $pdf->SetAlpha(0.3);
            $pdf->Image('../include/images/cancelled.jpg',70,50,70,30);
            $pdf->SetAlpha(1);
        }
    }

    $pdf->SetFont('Arial','B',10);
    $pdf->SetY(5);
    $pdf->Cell(0,5,'Voucher',0,1,'C');
    
    $pdf->SetFont('Arial','B',12);
    $pdf->SetX(10);
    $pdf->Cell(190,6,$company_name,0,1,'C');
    $pdf->SetFont('Arial','B',8);
    $pdf->Cell(190,3,$company_city.', '.$company_district.' (Dist.)',0,1,'C');
    $pdf->Cell(190,3,$company_state,0,1,'C');
    $pdf->Cell(190,3,'Contact : '.$company_mobile_number,0,1,'C');
    $pdf->Cell(190,4,'GST IN : '.$company_gst_number,0,1,'C');

    $pdf->SetY(10);
    $pdf->SetX(10);
    $pdf->Cell(190,20,'',1,1,'C');
    $header_end_y = $pdf->GetY();

    $pdf->SetTextColor(0,100,0);
    $pdf->SetFont('Arial','B',9);
    $pdf->SetY($header_end_y);
    $pdf->SetX(12);
    $pdf->Cell(93,5,'To',0,1,'L');
    $pdf->SetTextColor(0,0,0);
    $pdf->SetFont('Arial','B',8);
    $pdf->SetX(20);
    if(!empty($party_name)){
        $pdf->Cell(85,4,'Mr/Mrs. '.$party_name.',',0,1,'L');
        if(!empty($party_city)) {
            $pdf->SetX(20);
            $pdf->Cell(85,4,$party_city.',',0,1,'L');
        }
        if(!empty($party_address)){
            $pdf->SetX(20);
            $pdf->Cell(85,4,$party_address.'.',0,1,'L');
        }
        $pdf->SetX(20);
        $pdf->Cell(85,4,'Contact : '.$party_mobile_number,0,1,'L');
    }
    
    $pdf->SetTextColor(0,100,0);
    $pdf->SetFont('Arial','B',9);
    $pdf->SetY($header_end_y+1);
    $pdf->SetX(110);
    $pdf->Cell(40,6,'Voucher No ',0,0,'L');
    $pdf->SetTextColor(0,0,0);
    $pdf->Cell(3,6,':',0,0,'L');
    $pdf->Cell(57,6,$voucher_number,0,1,'L');
    $pdf->SetTextColor(0,100,0);
    $pdf->SetX(110);
    $pdf->Cell(40,6,'Voucher Date ',0,0,'L');
    $pdf->SetTextColor(0,0,0);
    $pdf->Cell(3,6,':',0,0,'L');
    $pdf->Cell(57,6,$voucher_date,0,1,'L');

    $pdf->SetY($header_end_y);
    $pdf->SetX(10);
    $pdf->Cell(95,24,'',1,0,'C');
    $pdf->Cell(95,24,'',1,1,'C');
    $bill_end_y = $pdf->GetY();

    $pdf->SetTextColor(0,100,0);
    $pdf->SetFont('Arial','B',9);
    $pdf->SetY($bill_end_y);
    $pdf->SetX(12);
    $pdf->Cell(30,5,'Remarks ',0,0,'L');
    $pdf->SetTextColor(0,0,0);
    $pdf->SetFont('Arial','B',8);
    $pdf->SetX(42);
    $pdf->Cell(3,5,' : ',0,0,'L');
    $pdf->SetX(45);
    $pdf->MultiCell(155,5,$narration,0,'L');

    $pdf->SetY($bill_end_y);
    $pdf->SetX(10);
    $pdf->Cell(190,10,'',1,1,'C');
    $remarks_end_y = $pdf->GetY();

    $pdf->SetTextColor(0,100,0);
    $pdf->SetFont('Arial','B',9);
    $pdf->SetY($remarks_end_y);
    $pdf->SetX(12);
    $pdf->Cell(30,5,'Payment Mode ',0,0,'L');
    $pdf->SetTextColor(0,0,0);
    if(!empty($payment_mode_names)) {
        $temp_y = $remarks_end_y;
        for($i=0; $i < count($payment_mode_names); $i++) {
            $colon = ($i == 0) ? ' :  ' : ''; 
            $x_value = ($i == 0) ? 42 : 45;
            $pdf->SetFont('Arial','B',8);
            $pdf->SetY($temp_y);
            $pdf->SetX($x_value);
            $bank_text = !empty($bank_names[$i]) ? ' ('.$obj->encode_decode("decrypt", $bank_names[$i]).')' : '';
            $pdf->Cell(155,5,$colon.$payment_mode_names[$i].$bank_text.' - '.($obj->numberFormat($amounts[$i],2)),0,1,'L');
            $temp_y += 5;
        }
    }
    
    $pdf->SetY($remarks_end_y);
    $pdf->SetX(10);
    $pdf->Cell(190,47,'',1,1,'C');

    $pdf->SetFont('Arial','B',9);
    $pdf->SetY(89);
    $pdf->SetX(12);
    $pdf->Cell(30,5,'Total Amount ',0,0,'L');
    $pdf->SetTextColor(0,100,0);
    $pdf->Cell(158,5,' :  '.$obj->numberFormat($total_amount,2),0,1,'L');
    $pdf->SetTextColor(0,0,0);

    $pdf->SetY(87);
    $pdf->SetX(10);
    $pdf->Cell(190,9,'',1,1,'C');

    $pdf->SetFont('Arial','B',9);
    $pdf->SetY(98);
    $pdf->SetX(12);
    $pdf->Cell(30,5,'Amount in words ',0,0,'L');
    $pdf->SetX(42);
    $pdf->Cell(3,5,' : ',0,0,'L');
    $pdf->SetTextColor(0,100,0);
    $pdf->SetX(45);
    $pdf->MultiCell(155,5,getIndianCurrency($total_amount),0,'L');
    $pdf->SetTextColor(0,0,0);

    $pdf->SetY(96);
    $pdf->SetX(10);
    $pdf->Cell(190,14,'',1,1,'C');

    $pdf->SetFont('Arial','B',9);
    $pdf->SetY(130);
    $pdf->SetX(12);
    $pdf->Cell(93,5,'(Verified)',0,0,'L');
    $pdf->SetX(107);
    $pdf->Cell(90,5,' Authorized Signature',0,1,'R');

    $pdf->SetY(110);
    $pdf->SetX(10);
    $pdf->Cell(190,28,'',1,1,'C');

    $pdf_name = $voucher_number.".pdf";
    $pdf->Output('I', $pdf_name);
?>

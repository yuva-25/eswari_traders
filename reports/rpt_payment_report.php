<?php 
    include("../include_user_check_and_files.php");
    $to_date = ""; $from_date = "";$filter_party_type = ""; $filter_bill_type = ""; $filter_party_id = ""; $payment_mode_id = ""; $bank_id = "";
    $filter_customer_id =""; $filter_bill_type =""; $filter_party_type= ""; 

    if(isset($_REQUEST['filter_customer_id'])) {
        $filter_customer_id = $_REQUEST['filter_customer_id'];
    }

    if(isset($_REQUEST['from_date'])) {
        $from_date = $_REQUEST['from_date'];
    }
    
    if(isset($_REQUEST['to_date'])) {
        $to_date = $_REQUEST['to_date'];
    }

    $filter_payment_mode_id="";
    if(isset($_REQUEST['filter_payment_mode_id'])) {
        $filter_payment_mode_id = $_REQUEST['filter_payment_mode_id'];
    }

    $filter_bank_id="";
    if(isset($_REQUEST['filter_bank_id'])) {
        $filter_bank_id = $_REQUEST['filter_bank_id'];
    }

    $filter_bill_type="";
    if(isset($_REQUEST['filter_bill_type'])) {
        $filter_bill_type = $_REQUEST['filter_bill_type'];
    }

    $filter_party_type="";
    if(isset($_REQUEST['filter_party_type'])) {
        $filter_party_type = $_REQUEST['filter_party_type'];
    }

    $total_records_list = array();
    $total_records_list = $obj->getPaymentReportList($from_date,$to_date,$filter_bill_type,$filter_party_type,$filter_customer_id,$filter_payment_mode_id,$filter_bank_id);

    if(!empty($from_date)){
        $from_date_disp = date('d-m-Y', strtotime($from_date));
    } else {
        $from_date_disp = "-";
    }
    if(!empty($to_date)){
        $to_date_disp = date('d-m-Y', strtotime($to_date));
    } else {
        $to_date_disp = "-";
    }

    $date_display ="";
    if($from_date_disp == $to_date_disp){
        $date_display = '( '.$from_date_disp.' )';
    }else{
        $date_display = '('.$from_date_disp . ' to '. $to_date_disp . ')';
    }

    require_once('../fpdf/fpdf.php');

    $pdf = new FPDF('P','mm','A4');
	$pdf->AliasNbPages(); 
	$pdf->AddPage();
	$pdf->SetAutoPageBreak(false);
	$pdf->SetTitle('Payment Report');
    $pdf->SetFont('Arial','B',9);
	$pdf->SetY(10);
    $pdf->SetX(10);
    $file_name = "Payment Report";
    include("rpt_header.php");

    $pdf->SetFont('Arial','B',9);
    $pdf->SetX(10);
    $pdf->Cell(190,7,'Payment Report '.$date_display ,1,1,'C',0);
    
    $pdf->SetFont('Arial','B',8.5);
    $pdf->SetFillColor(211,211,211);
    $pdf->SetTextColor(0,0,0);
    $pdf->SetX(10);
    $pdf->Cell(10,8,'#',1,0,'C',1);
    $pdf->Cell(25,8,'Date / Bill No',1,0,'C',1);
    $pdf->Cell(20,8,'Bill Type',1,0,'C',1);
    $pdf->Cell(20,8,'Party Type',1,0,'C',1);
    $pdf->Cell(25,8,'Name',1,0,'C',1);
    $pdf->Cell(35,8,'Payment Mode',1,0,'C',1);
    $pdf->Cell(20,8,'Remarks',1,0,'C',1);
    $pdf->Cell(17,8,'Credit',1,0,'C',1);
    $pdf->Cell(18,8,'Debit',1,1,'C',1);

    $start_y = $pdf->GetY();
    $y_axis = $pdf->GetY();

    $pdf->SetFont('Arial','',8);
    $s_no = 1; $total_credit = 0; $total_debit = 0;

    if (!empty($total_records_list)) {
        foreach ($total_records_list as $data) {
            if($pdf->GetY() > 265){
                $pdf->SetFont('Arial','I',7);
                $pdf->SetY(-15);
                $pdf->SetX(10);
                $pdf->Cell(190,4,'Page No : '.$pdf->PageNo().' / {nb}',0,0,'R');
                $pdf->AddPage();
                include("rpt_header.php");
                $pdf->SetFont('Arial','B',9);
                $pdf->SetX(10);
                $pdf->Cell(190,7,'Payment Report '.$date_display ,1,1,'C',0);
                $pdf->SetFillColor(211,211,211);
                $pdf->SetX(10);
                $pdf->Cell(10,8,'#',1,0,'C',1);
                $pdf->Cell(25,8,'Date / Bill No',1,0,'C',1);
                $pdf->Cell(20,8,'Bill Type',1,0,'C',1);
                $pdf->Cell(20,8,'Party Type',1,0,'C',1);
                $pdf->Cell(25,8,'Name',1,0,'C',1);
                $pdf->Cell(35,8,'Payment Mode',1,0,'C',1);
                $pdf->Cell(20,8,'Remarks',1,0,'C',1);
                $pdf->Cell(17,8,'Credit',1,0,'C',1);
                $pdf->Cell(18,8,'Debit',1,1,'C',1);
                $start_y = $pdf->GetY();
            }

            $pdf->SetFont('Arial','',8);
            $pdf->SetY($start_y);
            $pdf->SetX(10);
            $pdf->Cell(10,6,$s_no,0,0,'C',0);

            $date_bill = date('d-m-Y', strtotime($data['bill_date']));
            if(!empty($data['bill_number'])) $date_bill .= "\n".$data['bill_number'];
            $pdf->SetX(20);
            $pdf->MultiCell(25, 4, $date_bill, 0, 'C', 0);
            $h1 = $pdf->GetY() - $start_y;

            $pdf->SetY($start_y);
            $pdf->SetX(45);
            $pdf->MultiCell(20, 6, $data['bill_type'], 0, 'C', 0);
            $h2 = $pdf->GetY() - $start_y;

            $pt = $data['party_type'];
            if($pt == '1') $pt_text = "Purchase";
            else if($pt == '2') $pt_text = "Sales";
            else if($pt == '3') $pt_text = "Both";
            else $pt_text = "-";
            
            $pdf->SetY($start_y);
            $pdf->SetX(65);
            $pdf->MultiCell(20, 6, $pt_text, 0, 'C', 0);
            $h3 = $pdf->GetY() - $start_y;

            $pdf->SetY($start_y);
            $pdf->SetX(85);
            $name = $obj->encode_decode('decrypt', $data['party_name']);
            $pdf->MultiCell(25, 4, $name, 0, 'C', 0);
            $h4 = $pdf->GetY() - $start_y;

            $pdf->SetY($start_y);
            $pdf->SetX(110);
            $pm = !empty($data['payment_mode_name']) ? $data['payment_mode_name'] : "-";
            $pdf->MultiCell(35, 4, $pm, 0, 'C', 0);
            $h5 = $pdf->GetY() - $start_y;

            $pdf->SetY($start_y);
            $pdf->SetX(145);
            $remarks = "-";
            if($data['bill_type'] == 'Receipt') {
                $remarks = $obj->getTableColumnValue($GLOBALS['receipt_table'], 'receipt_id', $data['bill_id'], 'narration');
            } else if($data['bill_type'] == 'Voucher') {
                $remarks = $obj->getTableColumnValue($GLOBALS['voucher_table'], 'voucher_id', $data['bill_id'], 'narration');
            }
            $remarks = $obj->encode_decode('decrypt', $remarks);
            $pdf->MultiCell(20, 4, (!empty($remarks) ? $remarks : "-"), 0, 'C', 0);
            $h6 = $pdf->GetY() - $start_y;

            $pdf->SetY($start_y);
            $pdf->SetX(165);
            $credit = !empty($data['credit']) ? $obj->numberFormat($data['credit'], 2) : "0.00";
            if(!empty($data['credit'])) $total_credit += $data['credit'];
            $pdf->MultiCell(17, 6, $credit, 0, 'R', 0);
            $h7 = $pdf->GetY() - $start_y;

            $pdf->SetY($start_y);
            $pdf->SetX(182);
            $debit = !empty($data['debit']) ? $obj->numberFormat($data['debit'], 2) : "0.00";
            if(!empty($data['debit'])) $total_debit += $data['debit'];
            $pdf->MultiCell(18, 6, $debit, 0, 'R', 0);
            $h8 = $pdf->GetY() - $start_y;

            $max_h = max($h1, $h2, $h3, $h4, $h5, $h6, $h7, $h8, 6);
            $pdf->SetY($start_y);
            $pdf->SetX(10);
            $pdf->Cell(10, $max_h, '', 1, 0, 'C');
            $pdf->Cell(25, $max_h, '', 1, 0, 'C');
            $pdf->Cell(20, $max_h, '', 1, 0, 'C');
            $pdf->Cell(20, $max_h, '', 1, 0, 'C');
            $pdf->Cell(25, $max_h, '', 1, 0, 'C');
            $pdf->Cell(35, $max_h, '', 1, 0, 'C');
            $pdf->Cell(20, $max_h, '', 1, 0, 'C');
            $pdf->Cell(17, $max_h, '', 1, 0, 'C');
            $pdf->Cell(18, $max_h, '', 1, 1, 'C');

            $start_y += $max_h;
            $s_no++;
        }
    } else {
        $pdf->Cell(190, 8, 'No Records Found', 1, 1, 'C');
    }

    $pdf->SetFont('Arial','B',8);
    $pdf->Cell(155, 8, 'Total', 1, 0, 'R');
    $pdf->Cell(17, 8, $obj->numberFormat($total_credit, 2), 1, 0, 'R');
    $pdf->Cell(18, 8, $obj->numberFormat($total_debit, 2), 1, 1, 'R');

    $pdf->Cell(155, 8, 'Pending Balance', 1, 0, 'R');
    $pending_credit = ($total_credit > $total_debit) ? ($total_credit - $total_debit) : 0;
    $pending_debit = ($total_debit > $total_credit) ? ($total_debit - $total_credit) : 0;
    $pdf->Cell(17, 8, $obj->numberFormat($pending_credit, 2), 1, 0, 'R');
    $pdf->Cell(18, 8, $obj->numberFormat($pending_debit, 2), 1, 1, 'R');

    $pdf->SetFont('Arial','I',7);
    $pdf->SetY(-15);
    $pdf->SetX(10);
    $pdf->Cell(190,3,'Page No : '.$pdf->PageNo().' / {nb}',0,0,'R');

    $pdf_name = "Payment_Report_".date('dmYHis').".pdf";
    $pdf->Output('I',$pdf_name);
?>

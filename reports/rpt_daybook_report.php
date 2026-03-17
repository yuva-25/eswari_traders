<?php 
    include("../include_user_check_and_files.php");
    $to_date = ""; $from_date = ""; $filter_party_id = ""; $filter_payment_mode_id = ""; $filter_bill_type = "";

    if(isset($_REQUEST['filter_party_id'])) {
        $filter_party_id = $_REQUEST['filter_party_id'];
    }

    if(isset($_REQUEST['from_date'])) {
        $from_date = $_REQUEST['from_date'];
    }
    
    if(isset($_REQUEST['to_date'])) {
        $to_date = $_REQUEST['to_date'];
    }

    if(isset($_REQUEST['filter_payment_mode_id'])) {
        $filter_payment_mode_id = $_REQUEST['filter_payment_mode_id'];
    }

    if(isset($_REQUEST['filter_bill_type'])) {
        $filter_bill_type = $_REQUEST['filter_bill_type'];
    }

    $total_records_list = array();
    $total_records_list = $obj->getDayBookReportList($GLOBALS['bill_company_id'], $from_date, $to_date, $filter_party_id, $filter_payment_mode_id, $filter_bill_type);

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
	$pdf->SetTitle('Daybook Report');
    $pdf->SetFont('Arial','B',9);
	$pdf->SetY(10);
    $pdf->SetX(10);
    $file_name = "Daybook Report";
    include("rpt_header.php");

    $pdf->SetFont('Arial','B',9);
    $pdf->SetX(10);
    $pdf->Cell(190,7,'Daybook Report '.$date_display ,1,1,'C',0);
    
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
                $pdf->Cell(190,7,'Daybook Report '.$date_display ,1,1,'C',0);
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
            }

            $current_y = $pdf->GetY();
            
            $pdf->SetFont('Arial','',8);

            $date_bill = date('d-m-Y', strtotime($data['bill_date']));
            if(!empty($data['bill_number']) && $data['bill_number'] != $GLOBALS['null_value']) {
                $date_bill .= "\n".$data['bill_number'];
            }
            
            $pt = !empty($data['party_type']) ? $data['party_type'] : "";
            if($pt == '1') $pt_text = "Purchase";
            else if($pt == '2') $pt_text = "Sales";
            else if($pt == '3') $pt_text = "Both";
            else $pt_text = "-";

            $name = !empty($data['party_name']) ? $obj->encode_decode('decrypt', $data['party_name']) : "-";
            $pm = !empty($data['payment_mode_name']) && $data['payment_mode_name'] != 'NULL' ? $data['payment_mode_name'] : "-";

            $remarks = "-";
            if($data['bill_type'] == 'Receipt') {
                $remarks_raw = $obj->getTableColumnValue($GLOBALS['receipt_table'], 'receipt_id', $data['bill_id'], 'narration');
                if(!empty($remarks_raw) && $remarks_raw != $GLOBALS['null_value']) $remarks = $obj->encode_decode('decrypt', $remarks_raw);
            } else if($data['bill_type'] == 'Voucher') {
                $remarks_raw = $obj->getTableColumnValue($GLOBALS['voucher_table'], 'voucher_id', $data['bill_id'], 'narration');
                if(!empty($remarks_raw) && $remarks_raw != $GLOBALS['null_value']) $remarks = $obj->encode_decode('decrypt', $remarks_raw);
            }

            $credit = !empty($data['credit']) ? $obj->numberFormat($data['credit'], 2) : "0.00";
            if(!empty($data['credit'])) $total_credit += $data['credit'];

            $debit = !empty($data['debit']) ? $obj->numberFormat($data['debit'], 2) : "0.00";
            if(!empty($data['debit'])) $total_debit += $data['debit'];

            // Calculate heights
            $pdf->SetX(20);
            $x_bill = $pdf->GetX();
            $w_bill = 25;
            
            $pdf->SetX(85);
            $x_name = $pdf->GetX();
            $w_name = 25;

            $pdf->SetX(110);
            $x_pm = $pdf->GetX();
            $w_pm = 35;

            $pdf->SetX(145);
            $x_rem = $pdf->GetX();
            $w_rem = 20;

            // MultiCells to find max height
            $pdf->SetXY($x_bill, $current_y);
            $pdf->MultiCell($w_bill, 4, $date_bill, 0, 'C', 0);
            $h1 = $pdf->GetY() - $current_y;

            $pdf->SetXY($x_name, $current_y);
            $pdf->MultiCell($w_name, 4, $name, 0, 'C', 0);
            $h2 = $pdf->GetY() - $current_y;

            $pdf->SetXY($x_pm, $current_y);
            $pdf->MultiCell($w_pm, 4, $pm, 0, 'C', 0);
            $h3 = $pdf->GetY() - $current_y;

            $pdf->SetXY($x_rem, $current_y);
            $pdf->MultiCell($w_rem, 4, $remarks, 0, 'C', 0);
            $h4 = $pdf->GetY() - $current_y;

            $max_h = max($h1, $h2, $h3, $h4, 6);

            // Draw full row
            $pdf->SetXY(10, $current_y);
            $pdf->Cell(10, $max_h, $s_no, 1, 0, 'C');
            $pdf->Cell(25, $max_h, '', 1, 0, 'C'); // Placeholder for MultiCell
            $pdf->Cell(20, $max_h, $data['bill_type'], 1, 0, 'C');
            $pdf->Cell(20, $max_h, $pt_text, 1, 0, 'C');
            $pdf->Cell(25, $max_h, '', 1, 0, 'C'); // Placeholder for MultiCell
            $pdf->Cell(35, $max_h, '', 1, 0, 'C'); // Placeholder for MultiCell
            $pdf->Cell(20, $max_h, '', 1, 0, 'C'); // Placeholder for MultiCell
            $pdf->Cell(17, $max_h, $credit, 1, 0, 'R');
            $pdf->Cell(18, $max_h, $debit, 1, 1, 'R');

            // Redraw MultiCells over borders
            $pdf->SetXY($x_bill, $current_y);
            $pdf->MultiCell($w_bill, 4, $date_bill, 0, 'C', 0);
            $pdf->SetXY($x_name, $current_y);
            $pdf->MultiCell($w_name, 4, $name, 0, 'C', 0);
            $pdf->SetXY($x_pm, $current_y);
            $pdf->MultiCell($w_pm, 4, $pm, 0, 'C', 0);
            $pdf->SetXY($x_rem, $current_y);
            $pdf->MultiCell($w_rem, 4, $remarks, 0, 'C', 0);

            $pdf->SetY($current_y + $max_h);
            $s_no++;
        }
        
        $pdf->SetFont('Arial','B',8);
        $pdf->Cell(155, 8, 'Total', 1, 0, 'R');
        $pdf->Cell(17, 8, $obj->numberFormat($total_credit, 2), 1, 0, 'R');
        $pdf->Cell(18, 8, $obj->numberFormat($total_debit, 2), 1, 1, 'R');

        $pdf->Cell(155, 8, 'Difference', 1, 0, 'R');
        $pending_credit = ($total_credit > $total_debit) ? ($total_credit - $total_debit) : 0;
        $pending_debit = ($total_debit > $total_credit) ? ($total_debit - $total_credit) : 0;
        $pdf->Cell(17, 8, $obj->numberFormat($pending_credit, 2), 1, 0, 'R');
        $pdf->Cell(18, 8, $obj->numberFormat($pending_debit, 2), 1, 1, 'R');

    } else {
        $pdf->Cell(190, 8, 'No Records Found', 1, 1, 'C');
    }

    $pdf->SetFont('Arial','I',7);
    $pdf->SetY(-15);
    $pdf->SetX(10);
    $pdf->Cell(190,3,'Page No : '.$pdf->PageNo().' / {nb}',0,0,'R');

    $pdf_name = "Daybook_Report_".date('dmYHis').".pdf";
    $pdf->Output('I',$pdf_name);
?>

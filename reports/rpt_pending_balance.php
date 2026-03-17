<?php 
    include("../include_user_check_and_files.php");

    $filter_party_id =""; 
    $to_date = date('Y-m-d');  $current_date = date('Y-m-d');
    $from_date = date('Y-m-d', strtotime('-30 days', strtotime($to_date)));

    if(isset($_REQUEST['from_date']) && !empty($_REQUEST['from_date'])) {
        $from_date = $_REQUEST['from_date'];
    }

    if(isset($_REQUEST['to_date']) && !empty($_REQUEST['to_date'])) {
        $to_date = $_REQUEST['to_date'];
    }

    $filter_customer_id ="";
    if(isset($_REQUEST['filter_customer_id'])) {
        $filter_customer_id = $_REQUEST['filter_customer_id'];
    }

    $filter_bill_type ="";
    if(isset($_REQUEST['bill_type'])) {
        $filter_bill_type = $_REQUEST['bill_type'];
    }

    $bill_company_id =$GLOBALS['bill_company_id'];

    $total_records_list =array();
    $total_records_list = $obj->customer_balance_report($bill_company_id,$filter_customer_id,$from_date,$to_date,$filter_bill_type);
    
    require_once('../fpdf/fpdf.php');
    $pdf = new FPDF('P','mm','A4');
    $pdf->AliasNbPages(); 
    $pdf->AddPage();
    $pdf->SetAutoPageBreak(false);
    $pdf->SetTitle('Pending Balance Report');
    $pdf->SetFont('Arial','B',10);

    $file_name="Pending Balance Report";
    include("rpt_header.php");
    $pdf->SetY($header_end);

    if(!empty($filter_customer_id)) { 
        // Single Customer Report
        $pdf->SetFont('Arial','B',9);
        $date_range = "( ".date('d-m-Y',strtotime($from_date))." to ".date('d-m-Y',strtotime($to_date))." )";
        $pdf->Cell(0,7,'Pending Payment Report - '.$date_range,0,1,'C',0);
        
        $customer_name_raw = $obj->getTableColumnValue($GLOBALS['party_table'], 'party_id', $filter_customer_id, 'party_name');
        $customer_name = $obj->encode_decode('decrypt', $customer_name_raw);
        $pdf->Cell(0,7,$customer_name,0,1,'C',0);

        $pdf->SetFont('Arial','B',8.5);
        $pdf->SetFillColor(230,230,230);
        $pdf->Cell(10,8,'S.No',1,0,'C',1);
        $pdf->Cell(20,8,'Date',1,0,'C',1);
        $pdf->Cell(20,8,'Bill No',1,0,'C',1);
        $pdf->Cell(25,8,'Bill Type',1,0,'C',1);
        $pdf->Cell(20,8,'Party Type',1,0,'C',1);
        $pdf->Cell(35,8,'Payment Mode',1,0,'C',1);
        $pdf->Cell(20,8,'Remarks',1,0,'C',1);
        $pdf->Cell(20,8,'Credit',1,0,'C',1);
        $pdf->Cell(20,8,'Debit',1,1,'C',1);

        $total_credit = 0; $total_debit = 0;
        
        // Opening Balance
        $opening_balance_list = $obj->getOpeningBalance($filter_customer_id,$from_date,$to_date,$bill_company_id);   
        $ob_debit = 0; $ob_credit = 0;
        if(!empty($opening_balance_list)) {
            foreach($opening_balance_list as $data) {
                if(!empty($data['debit'])) { $ob_debit += $data['debit']; }
                if(!empty($data['credit'])) { $ob_credit += $data['credit']; }
                if(!empty($data['opening_balance'])) {
                    if($data['opening_balance_type'] == 'Credit') { $ob_credit += $data['opening_balance']; }
                    if($data['opening_balance_type'] == 'Debit') { $ob_debit += $data['opening_balance']; }
                }
            }
        }
        
        if($ob_credit != $ob_debit){
            $ob_c = ($ob_credit > $ob_debit) ? ($ob_credit - $ob_debit) : 0;
            $ob_d = ($ob_debit > $ob_credit) ? ($ob_debit - $ob_credit) : 0;
            $pdf->SetFont('Arial','B',8);
            $pdf->Cell(150,8,'Opening Balance',1,0,'R',0);
            $pdf->Cell(20,8,($ob_c > 0 ? $obj->numberFormat($ob_c,2) : ''),1,0,'R',0);
            $pdf->Cell(20,8,($ob_d > 0 ? $obj->numberFormat($ob_d,2) : ''),1,1,'R',0);
            $total_credit += $ob_c;
            $total_debit += $ob_d;
        }

        $pdf->SetFont('Arial','',8);
        if(!empty($total_records_list)) {
            $index = 1;
            foreach ($total_records_list as $data) {
                if($pdf->GetY() > 270){
                    $pdf->AddPage();
                    include("rpt_header.php");
                    $pdf->SetY($header_end);
                    $pdf->SetFont('Arial','B',8.5);
                    $pdf->SetFillColor(230,230,230);
                    $pdf->Cell(10,8,'S.No',1,0,'C',1); $pdf->Cell(20,8,'Date',1,0,'C',1); $pdf->Cell(20,8,'Bill No',1,0,'C',1);
                    $pdf->Cell(25,8,'Bill Type',1,0,'C',1); $pdf->Cell(20,8,'Party Type',1,0,'C',1); $pdf->Cell(35,8,'Payment Mode',1,0,'C',1);
                    $pdf->Cell(20,8,'Remarks',1,0,'C',1); $pdf->Cell(20,8,'Credit',1,0,'C',1); $pdf->Cell(20,8,'Debit',1,1,'C',1);
                    $pdf->SetFont('Arial','',8);
                }
                
                $start_y = $pdf->GetY();
                $pdf->SetX(10);
                $pdf->Cell(10,6,$index,0,0,'C',0);
                $pdf->Cell(20,6,date('d-m-Y',strtotime($data['bill_date'])),0,0,'C',0);
                $pdf->Cell(20,6,(!empty($data['bill_number']) ? $data['bill_number'] : '-'),0,0,'C',0);
                $pdf->Cell(25,6,$data['bill_type'],0,0,'C',0);
                
                $pt = $data['party_type'];
                if($pt == '1') $pt_text = "Purchase";
                else if($pt == '2') $pt_text = "Sales";
                else if($pt == '3') $pt_text = "Both";
                else $pt_text = "-";
                $pdf->Cell(20,6,$pt_text,0,0,'C',0);
                
                $pm = !empty($data['payment_mode_name']) ? $data['payment_mode_name'] : "-";
                $pdf->SetX(105);
                $pdf->MultiCell(35,6,$pm,0,'C',0);
                $h1 = $pdf->GetY() - $start_y;
                
                $pdf->SetY($start_y);
                $pdf->SetX(140);
                $remarks = !empty($data['remarks']) ? $data['remarks'] : "-";
                $pdf->MultiCell(20,6,$remarks,0,'C',0);
                $h2 = $pdf->GetY() - $start_y;
                
                $pdf->SetY($start_y);
                $pdf->SetX(160);
                $c = !empty($data['credit']) ? $obj->numberFormat($data['credit'],2) : "";
                $pdf->Cell(20,6,$c,0,0,'R',0);
                if(!empty($data['credit'])) $total_credit += $data['credit'];
                
                $d = !empty($data['debit']) ? $obj->numberFormat($data['debit'],2) : "";
                $pdf->Cell(20,6,$d,0,1,'R',0);
                if(!empty($data['debit'])) $total_debit += $data['debit'];
                
                $max_h = max($h1, $h2, 6);
                $pdf->SetY($start_y);
                $pdf->SetX(10);
                $pdf->Cell(10,$max_h,'',1,0); $pdf->Cell(20,$max_h,'',1,0); $pdf->Cell(20,$max_h,'',1,0);
                $pdf->Cell(25,$max_h,'',1,0); $pdf->Cell(20,$max_h,'',1,0); $pdf->Cell(35,$max_h,'',1,0);
                $pdf->Cell(20,$max_h,'',1,0); $pdf->Cell(20,$max_h,'',1,0); $pdf->Cell(20,$max_h,'',1,1);
                
                $index++;
            }
        }
        
        $pdf->SetFont('Arial','B',8);
        $pdf->Cell(150,8,'Total',1,0,'R',0);
        $pdf->Cell(20,8,$obj->numberFormat($total_credit,2),1,0,'R',0);
        $pdf->Cell(20,8,$obj->numberFormat($total_debit,2),1,1,'R',0);
        
        $pdf->Cell(150,8,'Pending Balance',1,0,'R',0);
        $pen_c = ($total_credit > $total_debit) ? ($total_credit - $total_debit) : 0;
        $pen_d = ($total_debit > $total_credit) ? ($total_debit - $total_credit) : 0;
        $pdf->Cell(20,8,($pen_c > 0 ? $obj->numberFormat($pen_c,2)." Cr" : ""),1,0,'R',0);
        $pdf->Cell(20,8,($pen_d > 0 ? $obj->numberFormat($pen_d,2)." Dr" : ""),1,1,'R',0);

    } else {
        // Overall Report
        $pdf->SetFont('Arial','B',10);
        $pdf->Cell(0,10,'Overall Pending Payment Report - '.date('d-m-Y'),1,1,'C',0);
        
        $pdf->SetFont('Arial','B',9);
        $pdf->SetFillColor(230,230,230);
        $pdf->Cell(20,8,'S.No',1,0,'C',1);
        $pdf->Cell(110,8,'Party Name',1,0,'C',1);
        $pdf->Cell(30,8,'Debit',1,0,'C',1);
        $pdf->Cell(30,8,'Credit',1,1,'C',1);
        
        $pdf->SetFont('Arial','',9);
        if(!empty($total_records_list)) {
            $sno = 1;
            $g_credit = 0; $g_debit = 0;
            foreach($total_records_list as $data) {
                if(empty($data['balance'])) continue;
                
                if($pdf->GetY() > 270){
                    $pdf->AddPage();
                    include("rpt_header.php");
                    $pdf->SetY($header_end);
                    $pdf->SetFont('Arial','B',9);
                    $pdf->SetFillColor(230,230,230);
                    $pdf->Cell(20,8,'S.No',1,0,'C',1); $pdf->Cell(110,8,'Party Name',1,0,'C',1); $pdf->Cell(30,8,'Debit',1,0,'C',1); $pdf->Cell(30,8,'Credit',1,1,'C',1);
                    $pdf->SetFont('Arial','',9);
                }
                
                $pdf->Cell(20,8,$sno++,1,0,'C',0);
                $name = $obj->encode_decode('decrypt',$data['party_name']);
                if(!empty($data['party_mobile_number'])) $name .= " (".$obj->encode_decode('decrypt',$data['party_mobile_number']).")";
                $pdf->Cell(110,8,$name,1,0,'L',0);
                
                $d = ($data['balance'] < 0) ? abs($data['balance']) : 0;
                $c = ($data['balance'] > 0) ? $data['balance'] : 0;
                
                $pdf->SetTextColor(255,0,0);
                $pdf->Cell(30,8,($d > 0 ? $obj->numberFormat($d,2) : ''),1,0,'R',0);
                $pdf->SetTextColor(0,128,0);
                $pdf->Cell(30,8,($c > 0 ? $obj->numberFormat($c,2) : ''),1,1,'R',0);
                $pdf->SetTextColor(0,0,0);
                
                $g_debit += $d;
                $g_credit += $c;
            }
            
            $pdf->SetFont('Arial','B',9);
            $pdf->Cell(130,8,'Grand Total',1,0,'R',0);
            $pdf->Cell(30,8,$obj->numberFormat($g_debit,2),1,0,'R',0);
            $pdf->Cell(30,8,$obj->numberFormat($g_credit,2),1,1,'R',0);
            
            $pdf->Cell(130,8,'Balance',1,0,'R',0);
            $bal = $g_credit - $g_debit;
            $pdf->Cell(30,8,($bal < 0 ? $obj->numberFormat(abs($bal),2)." Dr" : ""),1,0,'R',0);
            $pdf->Cell(30,8,($bal > 0 ? $obj->numberFormat($bal,2)." Cr" : ""),1,1,'R',0);
        } else {
            $pdf->Cell(190,8,'No Records Found',1,1,'C',0);
        }
    }

    $pdf->SetFont('Arial','I',7);
    $pdf->SetY(-15);
    $pdf->Cell(0,10,'Page '.$pdf->PageNo().'/{nb}',0,0,'C');

    $pdf_name = "Pending_Balance_Report_".date('dmYHis').".pdf";
    $pdf->Output('I',$pdf_name);
?>

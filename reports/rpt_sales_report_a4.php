<?php
    include("../include_user_check_and_files.php");
    include("../include/number2words.php");

    $filter_party_id = "";
    if(isset($_REQUEST['filter_party_id'])) {
        $filter_party_id = filter_input(INPUT_GET, 'filter_party_id', FILTER_SANITIZE_SPECIAL_CHARS);
    }

    $from_date = "";
    if(isset($_REQUEST['from_date'])) {
        $from_date = filter_input(INPUT_GET, 'from_date', FILTER_SANITIZE_SPECIAL_CHARS);
    }
    
    $to_date = "";
    if(isset($_REQUEST['to_date'])) {
        $to_date = filter_input(INPUT_GET, 'to_date', FILTER_SANITIZE_SPECIAL_CHARS);
    }

    $view_type = "";
    if(isset($_REQUEST['view_type'])){
       $view_type = filter_input(INPUT_GET, 'view_type', FILTER_SANITIZE_SPECIAL_CHARS);
    }
    
    $cancel_bill_btn = "";
    if(isset($_REQUEST['cancel_bill_btn'])){
       $cancel_bill_btn = filter_input(INPUT_GET, 'cancel_bill_btn', FILTER_SANITIZE_SPECIAL_CHARS);
    }

    $pdf_download_name = "Sales Report PDF -"." (".$from_date ." to ".$to_date .")";

    $total_records_list = array();
    $total_records_list = $obj->getSalesBillReport($GLOBALS['bill_company_id'],$filter_party_id,$from_date, $to_date,$view_type,$cancel_bill_btn);
    
    $from_date = date('d-m-Y',strtotime($from_date));
    $to_date = date('d-m-Y',strtotime($to_date));

    require_once('../fpdf/fpdf.php');
    $pdf = new FPDF('P','mm','A4');
    $pdf->AliasNbPages(); 
    $pdf->AddPage();
    $pdf->SetAutoPageBreak(false);
    $yaxis = $pdf->GetY();

    $file_name="Sales Report";
    include("rpt_header.php");
    
    $pdf->SetY($header_end);
           
    $pdf->SetFont('Arial','B',10);
    $pdf->Cell(0,7.5,'Sales Report ('.$from_date.' - '.$to_date.')',0,1,'C',0);

    $current_y = $pdf->GetY();
    $box_y = $pdf->GetY();

    $pdf->SetY($yaxis);
    $pdf->SetX(10);

    $pdf->Cell(190, ($current_y - $yaxis), '', 1, 1, 'L', 0);
    $pdf->SetFont('Arial','B',9);
    $pdf->SetY($box_y);
    $pdf->SetFillColor(101,114,122);
    $pdf->SetTextColor(255,255,255);
    $pdf->SetX(10);
    $pdf->Cell(10,8,'S.No.',1,0,'C',1);
    $pdf->Cell(35,8,'Bill Number',1,0,'C',1);
    $pdf->Cell(35,8,'Date',1,0,'C',1);
    $pdf->Cell(80,8,'Party Name',1,0,'C',1);
    $pdf->Cell(30,8,'Amount',1,1,'C',1);
    $pdf->SetTextColor(0,0,0);
    $pdf->SetFont('Arial','',8);
    $y_axis = $pdf->GetY();

    $footer_height = 0;
    $footer_height = 10;

    $index = 0;
    $product_count = 0; $quantity = ""; $grand_amount = 0;$total_quantity =0;

    if(!empty($total_records_list)) {    
        foreach($total_records_list as $key => $data) {
            if($pdf->GetY()>265){
                $closing_balance = $grand_amount;
                $closing_quantity = $total_quantity;
                $pdf->SetFont('Arial','B',8);
                $pdf->Cell(140,8,'Closing Balance',1,0,'R',0);
                $pdf->Cell(20,8,$closing_quantity,1,0,'C',0);
                $pdf->Cell(30,8,$obj->numberFormat($closing_balance,2),1,1,'R',0);
                
                $pdf->SetFont('Arial','I',7);
                $pdf->SetY(-15);
                $pdf->SetX(10);
                $pdf->Cell(190,6,'Page No : '.$pdf->PageNo().' / {nb}',0,0,'R');
                
                $pdf->AddPage();
                $pdf->SetAutoPageBreak(false);
                $yaxis = $pdf->GetY();

                $file_name="Sales Report";
                include("rpt_header.php");
                
                $pdf->SetY($header_end);
                    
                $pdf->SetFont('Arial','B',10);
                $pdf->Cell(0,7.5,'Sales Report - ('.$from_date.' - '.$to_date.')',0,1,'C',0);
                $current_y = $pdf->GetY();
                $box_y = $pdf->GetY();


                $pdf->SetY($yaxis);
                $pdf->SetX(10);

                $pdf->Cell(190, ($current_y - $yaxis), '', 1, 1, 'L', 0);
                $pdf->SetFont('Arial','B',10);
                $pdf->SetFillColor(101,114,122);
                $pdf->SetTextColor(255,255,255);
                $pdf->SetX(10);
                $pdf->Cell(10,8,'S.No.',1,0,'C',1);
                $pdf->Cell(35,8,'Bill Number',1,0,'C',1);
                $pdf->Cell(35,8,'Date',1,0,'C',1);
                $pdf->Cell(80,8,'Party Name',1,0,'C',1);
                $pdf->Cell(30,8,'Amount',1,1,'C',1);
                $pdf->SetTextColor(0,0,0);
                $pdf->SetFont('Arial','B',8);
                $pdf->Cell(140,8,'Opening Balance',1,0,'R',0);
                $pdf->Cell(20,8,$closing_quantity,1,0,'C',0);
                $pdf->Cell(30,8,$obj->numberFormat($closing_balance,2),1,1,'R',0);
                $pdf->SetFont('Arial','',8);
            }            

            $index = $key + 1;

            $start_y = $pdf->GetY();                

            $pdf->SetX(10);
            $pdf->Cell(10,7,$index,0,0,'C',0);

            if(!empty($data['bill_number'])) {
                if ($data['cancelled'] == '1') {
                    $pdf->SetX(20);
                    $pdf->MultiCell(35,4,$data['bill_number'],0,'C',0);
                }else{
                    $pdf->SetX(20);
                    $pdf->MultiCell(35,7,$data['bill_number'],0,'C',0); 
                }
            }
            
            if ($data['cancelled'] == '1') {
                $pdf->SetTextColor(255,0,0);
                $pdf->SetX(20);
                $pdf->Cell(35,4,'Cancelled',0,1,'C',0);   
            }
            $pdf->SetTextColor(0,0,0);
            $no_end = $pdf->GetY();

            $pdf->SetY($start_y);

            if(!empty($data['bill_date'])) {
                $pdf->SetX(55);
                $pdf->MultiCell(35,7,date('d-m-Y',strtotime($data['bill_date'])),0,'C',0);
            }
            $date_end = $pdf->GetY();

            $pdf->SetY($start_y);   
            
            if(!empty($data['party_id'])) {
                $customer_name =$obj->getTableColumnValue($GLOBALS['party_table'],'party_id',$data['party_id'],'name_mobile_city');
                
                $pdf->SetX(90);
                $pdf->MultiCell(80,7,($obj->encode_decode('decrypt',$customer_name)),0,'C',0);
                
            }
            
            $qty_end =$pdf->GetY();
            $pdf->SetY($start_y); 

            if(!empty($data['amount'])) { 
                $pdf->SetX(150);
                $pdf->MultiCell(50,7,$obj->numberFormat($data['amount'], 2),0,'R',0);
                if($data['cancelled'] == '0'){
                    $grand_amount += $data['amount'];
                }
            }
            $amt_end =$pdf->GetY();

            $max_y = max(array($date_end,$amt_end,$qty_end,$no_end));
            $pdf->SetY($start_y);                            
            $pdf->SetX(10);
            $pdf->Cell(10,($max_y-$start_y),'',1,0,'C',0);
            $pdf->Cell(35,($max_y-$start_y),'',1,0,'C',0);
            $pdf->Cell(35,($max_y-$start_y),'',1,0,'C',0);
            $pdf->Cell(80,($max_y-$start_y),'',1,0,'C',0);
            $pdf->Cell(30,($max_y-$start_y),'',1,1,'C',0);
        }   
    }

    $end_y = $pdf->GetY();
    if(($footer_height+$end_y) >= 270){
        $y = $pdf->GetY();
        $pdf->SetY($y_axis);
        $pdf->SetX(10);
        $pdf->Cell(10,(277 - $y_axis),'',1,0,'C',0);
        $pdf->Cell(35,(277 - $y_axis),'',1,0,'C',0);
        $pdf->Cell(35,(277 - $y_axis),'',1,0,'C',0);
        $pdf->Cell(80,(277 - $y_axis),'',1,0,'C',0);
        $pdf->Cell(30,(277 - $y_axis),'',1,1,'C',0);


        $pdf->SetFont('Arial','B',9);
        $next_page = $pdf->PageNo()+1;
        $pdf->SetFont('Arial','I',7);
        $pdf->SetY(-15);
        $pdf->SetX(10);
        $pdf->Cell(190,4,'Page No : '.$pdf->PageNo().' / {nb}',0,0,'R');

        $pdf->AddPage();
        $file_name="Sales Report";
        include("rpt_header.php");
        
        $pdf->SetY($header_end);
        $pdf->SetFont('Arial','B',10);
        $pdf->Cell(0,7.5,'Sales Report ('.$from_date.' - '.$to_date.')',0,1,'C',0);

        $current_y = $pdf->GetY();
        $box_y = $pdf->GetY();

        $pdf->SetY($yaxis);
        $pdf->SetX(10);
        $pdf->Cell(190, ($current_y - $yaxis), '', 1, 1, 'L', 0);
        $pdf->SetFont('Arial','B',9);
        $pdf->SetY($box_y);
        $pdf->SetFillColor(101,114,122);
        $pdf->SetTextColor(255,255,255);
        $pdf->SetX(10);
        $pdf->Cell(10,8,'S.No.',1,0,'C',1);
        $pdf->Cell(35,8,'Bill Number',1,0,'C',1);
        $pdf->Cell(35,8,'Date',1,0,'C',1);
        $pdf->Cell(80,8,'Party Name',1,0,'C',1);
        $pdf->Cell(30,8,'Amount',1,1,'C',1);
        $pdf->SetTextColor(0,0,0);
        $pdf->SetFont('Arial','',8);
        $y_axis = $pdf->GetY();


        $content_height = 280 - $footer_height;
        $pdf->SetY($y_axis);
        $pdf->SetX(10);
        $pdf->Cell(10,($content_height - $y_axis),'',1,0,'C',0);
        $pdf->Cell(35,($content_height - $y_axis),'',1,0,'C',0);
        $pdf->Cell(35,($content_height - $y_axis),'',1,0,'C',0);
        $pdf->Cell(80,($content_height - $y_axis),'',1,0,'C',0);
        $pdf->Cell(30,($content_height - $y_axis),'',1,1,'C',0);

        $pdf->SetY($content_height);

    } else {
        $content_height = 280 - $footer_height;
        $pdf->SetY($y_axis);
        $pdf->SetX(10);
        $pdf->Cell(10,($content_height - $y_axis),'',1,0,'C',0);
        $pdf->Cell(35,($content_height - $y_axis),'',1,0,'C',0);
        $pdf->Cell(35,($content_height - $y_axis),'',1,0,'C',0);
        $pdf->Cell(80,($content_height - $y_axis),'',1,0,'C',0);
        $pdf->Cell(30,($content_height - $y_axis),'',1,1,'C',0);
        
    }

    $pdf->SetFont('Arial','B',9);
    $pdf->SetX(10);
    $pdf->Cell(160,8,'Total',1,0,'R',0);
    $pdf->Cell(30,8,$obj->numberFormat($grand_amount,2),1,1,'R',0);


    $pdf->SetFont('Arial','I',7);
    $pdf->SetY(-15);
    $pdf->SetX(10);
    $pdf->Cell(190,6,'Page No : '.$pdf->PageNo().' / {nb}',0,0,'R');

    $pdf->Output('',$pdf_download_name . '.pdf');

?>
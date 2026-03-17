<?php 
    include("../include_user_check_and_files.php");
    include("../include/number2words.php");

    $to_date = "";$from_date = "";$filter_product_id="";$filter_party_id=""; $filter_unit_id = ""; $filter_size_id = ""; $from = "";
    $from_date = date('Y-m-d', strtotime('-30 days')); $to_date = date("Y-m-d"); 

    if(isset($_REQUEST['filter_party_id'])) {
        $filter_party_id = $_REQUEST['filter_party_id'];
    }
    if(isset($_REQUEST['from_date'])) {
        $from_date = $_REQUEST['from_date'];
    }
    if(isset($_REQUEST['to_date'])) {
        $to_date = $_REQUEST['to_date'];
    }

    if(isset($_REQUEST['filter_product_id'])) {
        $filter_product_id = $_REQUEST['filter_product_id'];
    }

    if(isset($_REQUEST['filter_unit_id'])) {
        $filter_unit_id = $_REQUEST['filter_unit_id'];
    }

    if(isset($_REQUEST['filter_size_id'])) {
        $filter_size_id = $_REQUEST['filter_size_id'];
    }

    if(isset($_REQUEST['from'])) {
        $from = $_REQUEST['from'];
    }

    $pdf_download_name = "Sales Report PDF -"." (".$from_date ." to ".$to_date .")";

    $total_records_list = array();
    if(empty($filter_product_id)) {
        $total_records_list = $obj->getSalesStockReportList($filter_party_id,$filter_product_id);
    }
    else if(!empty($filter_product_id)) {
        $total_records_list = $obj->getSalesDetailStockReportList($from_date, $to_date,$filter_party_id,$filter_product_id,$filter_size_id,$filter_unit_id);
    }

    require_once('../fpdf/AlphaPDF.php');
    $pdf = new AlphaPDF('P','mm','A4');
    $pdf->AliasNbPages(); 
    $pdf->AddPage();
    $pdf->SetAutoPageBreak(false);

    $file_name="Sales Stock Report";
    include("rpt_header.php");
    $pdf->SetY($header_end);
    $bill_to_y = $pdf->GetY();

    $s_no = 1; $footer_height = 15; $height = 0; $l = 0; 
    $pdf->SetFont('Arial','B',9);

    if(empty($filter_product_id)){
        $total_pages = array(1);
        $page_number = 1;
        $last_count = 0;
        
        if(!empty($from_date)) {
            $from_date = date('d-m-Y', strtotime($from_date));
        }
        if(!empty($to_date)) {
            $to_date = date('d-m-Y', strtotime($to_date));
        }
        $pdf->SetY($bill_to_y);
        $pdf->SetX(10);
        $pdf->Cell(190,7,'Sales Stock Report',1,1,'C',0);
        $pdf->SetFillColor(101,114,122);
        $pdf->SetTextColor(255,255,255);
        $pdf->SetX(10);
        $pdf->Cell(20,8,'#',1,0,'C',1);
        $pdf->Cell(90,8,'Product Name',1,0,'C',1);
        $pdf->Cell(80,8,'Sales Stock',1,1,'C',1);
        $pdf->SetTextColor(0,0,0);
        $pdf->SetFont('Arial','',8);
        $y_axis=$pdf->GetY();

        $s_no = "1"; $total_stock = 0; $content_height = 0;
        if(!empty($total_stock)){
            $height -= 15;
            $footer_height += 15;
        }
        if(!empty($total_records_list)) {       
            foreach($total_records_list as $key => $data) {
                $inward_unit = 0; $outward_unit = 0;  
                $outward_unit = $obj->getOutwardQty('', '','',$data['product_id'],''); 
                if($pdf->GetY() > 270){
                    $y = $pdf->GetY();
                    $pdf->SetY($y_axis);
                    $pdf->SetX(10);
                    $pdf->Cell(20,277-$y_axis,'',1,0,'C',0);
                    $pdf->Cell(90,277-$y_axis,'',1,0,'C',0);
                    $pdf->Cell(80,277-$y_axis,'',1,1,'C',0);

                    $pdf->SetFont('Arial','I',7);
                    $pdf->SetY(-15);
                    $pdf->SetX(10);
                    $pdf->Cell(190,6,'Page No : '.$pdf->PageNo().' / {nb}',0,0,'R');
                    $pdf->AddPage();
                    $pdf->SetAutoPageBreak(false);
                    $page_number += 1;
                    $total_pages[] = $page_number;
                    $last_count = $l+1;

                    $file_name="Sales Stock Report";
                    include("rpt_header.php");
                    
                    $pdf->SetY($header_end);

                    $bill_to_y = $pdf->GetY();
                    $pdf->SetY($bill_to_y);
                    $pdf->SetX(10);
                    $pdf->Cell(190,7,'Sales Stock Report',1,1,'C',1);
                    $pdf->SetFillColor(101,114,122);
                    $pdf->SetTextColor(255,255,255);
                    $pdf->SetX(10);
                    $pdf->Cell(20,8,'#',1,0,'C',1);
                    $pdf->Cell(90,8,'Product Name',1,0,'C',1);
                    $pdf->Cell(80,8,'Sales Stock',1,1,'C',1);
                    $pdf->SetTextColor(0,0,0);
                    $pdf->SetFont('Arial','',7);

                    $y_axis=$pdf->GetY();
                }
                $pdf->SetX(10);
                $pdf->Cell(20,6,$s_no,1,0,'C',0);
                if(!empty($data['product_id']) && $data['product_id'] != $GLOBALS['null_value']) {
                    $product_name = "";
                    $product_name = $obj->getTableColumnValue($GLOBALS['product_table'], 'product_id', $data['product_id'], 'product_name');
                    $product_name = $obj->encode_decode('decrypt', $product_name);
                    $pdf->Cell(90,6,$product_name,1,0,'C',0);
                } else{
                    $pdf->Cell(90,6,' - ',1,0,'C',0);
                }

                if(!empty($outward_unit)){
                    $pdf->Cell(80,6,$outward_unit,1,1,'C',0);
                    $total_stock += $outward_unit;
                }else{
                    $pdf->Cell(80,6,'0',1,1,'C',0);
                } 
                $s_no++;
            }
        }
        $end_y = $pdf->GetY();
        $last_page_count = $s_no - $last_count;
        if(($footer_height+$end_y) >= 270){
            $y = $pdf->GetY();
            $pdf->SetY($y_axis);
            $pdf->SetX(10);
            $pdf->Cell(20,270-$y_axis,'',1,0,'C',0);
            $pdf->Cell(90,270-$y_axis,'',1,0,'C',0);
            $pdf->Cell(80,270-$y_axis,'',1,1,'C',0);
    
            $pdf->SetFont('Arial','I',7);
            $pdf->SetY(-15);
            $pdf->SetX(10);
            $pdf->Cell(190,6,'Page No : '.$pdf->PageNo().' / {nb}',0,0,'R');
            $pdf->AddPage();
            $pdf->SetAutoPageBreak(false);

            $file_name="Current Stock Report";
            include("rpt_header.php");
            
            $pdf->SetY($header_end);
            $bill_to_y = $pdf->GetY();

            $pdf->SetFont('Arial','B',8);
            $pdf->SetY($bill_to_y);
            $pdf->SetX(10);
            $pdf->Cell(190,7,'Current Stock Report - ( '.$from_date .' - '.$to_date.' )',1,1,'C',0);
            $pdf->SetX(10);
            $pdf->Cell(20,8,'#',1,0,'C',0);
            $pdf->Cell(90,8,'Product Name',1,0,'C',0);
            $pdf->Cell(80,8,'Current Stock',1,1,'C',0);
            $pdf->SetFont('Arial','',7);
            
            $y_axis=$pdf->GetY();

            $content_height = 280 - $footer_height;
            $pdf->SetY($y_axis);
            $pdf->SetX(10);
            $pdf->Cell(20,($content_height-$y_axis),'',1,0);
            $pdf->Cell(90,($content_height-$y_axis),'',1,0);
            $pdf->Cell(80,($content_height-$y_axis),'',1,1);
            $pdf->SetY($content_height);
        } 
        else {
            
            $content_height = 280 - $footer_height;
            $pdf->SetY($y_axis);
            $pdf->SetX(10);
            $pdf->Cell(20,($content_height-$y_axis),'',1,0);
            $pdf->Cell(90,($content_height-$y_axis),'',1,0);
            $pdf->Cell(80,($content_height-$y_axis),'',1,1);
        }
        $pdf->SetFont('Arial','B',9.5);
        $pdf->SetX(10);
        $pdf->Cell(110,8,'Total Stock',1,0,'R',0);
        if(!empty($total_stock)){
            $pdf->SetX(120);
            $pdf->Cell(80,8,$total_stock,1,1,'C',0);
        } else {
            $pdf->SetX(120);
            $pdf->Cell(80,8,'  ',1,1,'C',0);
        }
    }else{
        $total_pages = array(1);
        $page_number = 1;
        $last_count = 0;
        $inward_unit = 0; $outward_unit = 0; $inward_sub_unit = 0; $outward_sub_unit = 0;
        $outward_unit = $obj->getOutwardQty('', $filter_unit_id,$filter_size_id,$filter_product_id,$filter_party_id);
        $display_outward_total = 0;
        $display_outward_total += $outward_unit;
        if(!empty($filter_product_id)){
            $unit_name = ""; $product_name = "";
            $unit_name = $obj->getTableColumnValue($GLOBALS['product_table'], 'product_id',$filter_product_id, 'unit_name');
            $unit_name = $obj->encode_decode('decrypt', $unit_name);
            $product_name = $obj->getTableColumnValue($GLOBALS['product_table'], 'product_id',$filter_product_id, 'product_name');
            $product_name = $obj->encode_decode('decrypt', $product_name);
        }
        $pdf->SetY($bill_to_y);
        $pdf->SetX(10);
        $pdf->Cell(190,7, $product_name. ' ( stock : '.$display_outward_total. " ". $unit_name . ')',1,1,'C',0);
        $product_start_y = $pdf->GetY();
        $pdf->SetFont('Arial','B',9);
        $pdf->SetFillColor(101,114,122);
        $pdf->SetTextColor(255,255,255);
        $pdf->SetX(10);
        $pdf->Cell(10, 8, '#', 1, 0, 'C', 1);
        $pdf->Cell(25, 8, 'Date', 1, 0, 'C', 1);
        $pdf->Cell(25, 8, 'Type ', 1, 0, 'C', 1);
        $pdf->Cell(55, 8, 'Party', 1, 0, 'C', 1);
        $pdf->Cell(25, 8, 'Unit', 1, 0, 'C', 1);
        $pdf->Cell(25, 8, 'Size',1, 0,'C', 1);
        $pdf->Cell(25, 8, 'Outward', 1, 1, 'C', 1);
        $pdf->SetTextColor(0,0,0);
        $pdf->SetFont('Arial','',8);
        $start_y = $pdf->GetY();
        $y_axis = $pdf->GetY();
        $total_inward = 0; $total_outward = 0; $s_no='1'; $content_height = 0;
        if(!empty($total_inward) || !empty($total_outward)){
            $height -= 15;
            $footer_height += 15;
        }    
        if(!empty($total_records_list)) {        
            $total_inward = 0; $total_outward = 0;
            foreach($total_records_list as $data) {
                if($pdf->GetY() > 260){
                    $y = $pdf->GetY();
                    $pdf->SetFont('Arial','I',7);
                    $pdf->SetY(-15);
                    $pdf->SetX(10);
                    $pdf->Cell(190,6,'Page No : '.$pdf->PageNo().' / {nb}',0,0,'R');
                    $pdf->AddPage();
                    $pdf->SetAutoPageBreak(false);
                    $page_number += 1;
                    $total_pages[] = $page_number;
                    $last_count = $l+1;
                    $file_name="Sales Stock Report";
                    include("rpt_header.php"); 
                    $pdf->SetY($header_end);
                    $bill_to_y = $pdf->GetY();
                    $pdf->SetY($bill_to_y);
                    $pdf->SetX(10);
                    $pdf->SetFont('Arial','B',9);
                    $pdf->Cell(190,7, $product_name. ' ( stock : '.$display_outward_total. " ". $unit_name . ')',1,1,'C',0);
                    $product_start_y = $pdf->GetY();
                    $pdf->SetFont('Arial','B',9);
                    $pdf->SetFillColor(101,114,122);
                    $pdf->SetTextColor(255,255,255);
                    $pdf->SetX(10);
                    $pdf->Cell(10, 8, '#', 1, 0, 'C', 1);
                    $pdf->Cell(25, 8, 'Date', 1, 0, 'C', 1);
                    $pdf->Cell(25, 8, 'Type ', 1, 0, 'C', 1);
                    $pdf->Cell(55, 8, 'Party', 1, 0, 'C', 1);
                    $pdf->Cell(25, 8, 'Unit', 1, 0, 'C', 1);
                    $pdf->Cell(25, 8, 'Size',1, 0,'C', 1);
                    $pdf->Cell(25, 8, 'Outward', 1, 1, 'C', 1);
                    $pdf->SetTextColor(0,0,0);
                    $pdf->SetFont('Arial','',8);
                    $start_y = $pdf->GetY();
                    $y_axis=$pdf->GetY();
                }
                $date_y = ""; $type_y = "";$party_y = ""; $unit_y = ""; $size_y = "";  $outward_y = "";  $y_array = array(); $max_y = ""; 
                $product_y =  $pdf->GetY();
                $pdf->SetX(10);
                $pdf->MultiCell(10, 7, $s_no, 0, 'C', 0);

                if(!empty($data['stock_date']) && $data['stock_date'] != $GLOBALS['null_value']) {
                    $pdf->SetY($start_y);
                    $pdf->SetX(20);
                    $pdf->MultiCell(25, 7,date('d-m-Y', strtotime($data['stock_date'])), 0, 'C', 0);
                }
                else{
                    $pdf->SetY($start_y);
                    $pdf->SetX(20);
                    $pdf->MultiCell(25, 7,'-', 0, 'C', 0);
                }
                $date_y = $pdf->GetY();

                if(!empty($data['stock_type']) && $data['stock_type'] != $GLOBALS['null_value']) {
                    $pdf->SetY($start_y);
                    $pdf->SetX(45);
                    $pdf->MultiCell(25, 7,$data['stock_type'], 0, 'C', 0);
                }
                else{
                    $pdf->SetY($start_y);
                    $pdf->SetX(45);
                    $pdf->MultiCell(25, 7, '-', 0, 'C', 0);
                }
                $type_y = $pdf->GetY();

                $pdf->SetY($start_y);
                $pdf->SetX(70);
                if(!empty($data['party_id']) && $data['party_id'] != $GLOBALS['null_value']) {
                    $party_name = ""; 
                    $party_name = $obj->getTableColumnValue($GLOBALS['party_table'], 'party_id',$data['party_id'], 'name_mobile_city');
                    $pdf->MultiCell(55, 7, $obj->encode_decode('decrypt',$party_name), 0,  'C', 0);
                }
                else {
                    $pdf->MultiCell(55, 7, '-', 0,  'C', 0);
                }
                $party_y = $pdf->GetY();

                $pdf->SetY($start_y);
                $pdf->SetX(125);
                if(!empty($data['unit_name']) && $data['unit_name'] != $GLOBALS['null_value']) {
                    $pdf->MultiCell(25, 7, $obj->encode_decode('decrypt',$data['unit_name']), 0,  'C', 0);
                }
                else {
                    $pdf->MultiCell(25, 7, '-', 0,  'C', 0);
                }
                $unit_y = $pdf->GetY();

                $pdf->SetY($start_y);
                $pdf->SetX(150);
                if(!empty($data['size_name']) && $data['size_name'] != $GLOBALS['null_value']) {
                    $pdf->MultiCell(25, 7, $obj->encode_decode('decrypt',$data['size_name']), 0,  'C', 0);
                }
                else {
                    $pdf->MultiCell(25, 7, '-', 0,  'C', 0);
                }
                $size_y = $pdf->GetY();

                $pdf->SetY($start_y);
                $pdf->SetX(175);
                if(!empty($data['outward_unit']) && $data['outward_unit'] != $GLOBALS['null_value']) {
                    $pdf->MultiCell(25, 7, $data['outward_unit'], 0,  'C', 0);
                    $total_outward += $data['outward_unit'];
                }
                else {
                    $pdf->MultiCell(25, 7, '-', 0,  'C', 0);
                }
                $outward_y = $pdf->GetY();

                $max_y = max(array($date_y,$type_y,$unit_y,$size_y,$party_y,$outward_y));
                $end_y = $max_y - $start_y;
                $pdf->SetY($start_y);
                $pdf->SetX(10);                
                $pdf->Cell(10,$end_y,'',1,0,'C');
                $pdf->Cell(25,$end_y,'',1,0,'C');
                $pdf->Cell(25,$end_y,'',1,0,'C');
                $pdf->Cell(55,$end_y,'',1,0,'C');
                $pdf->Cell(25,$end_y,'',1,0,'C');
                $pdf->Cell(25,$end_y,'',1,0,'C');
                $pdf->Cell(25,$end_y,'',1,1,'C');

                $s_no++;
                $start_y += $end_y;

            }
        }
        $end_y = $pdf->GetY();
        $last_page_count = $s_no - $last_count;
        if(($footer_height+$end_y) >= 270){

            $y = $pdf->GetY();
            $pdf->SetY($y_axis);
            $pdf->SetX(10);
            $pdf->Cell(10,270 - $y_axis,'',1,0,'C');
            $pdf->Cell(25,270 - $y_axis,'',1,0,'C');
            $pdf->Cell(25,270 - $y_axis,'',1,0,'C');
            $pdf->Cell(55,270 - $y_axis,'',1,0,'C');
            $pdf->Cell(25,270 - $y_axis,'',1,0,'C');
            $pdf->Cell(25,270 - $y_axis,'',1,0,'C');
            $pdf->Cell(25,270 - $y_axis,'',1,1,'C');
            
            $pdf->SetFont('Arial','I',7);
            $pdf->SetY(-15);
            $pdf->SetX(10);
            $pdf->Cell(190,6,'Page No : '.$pdf->PageNo().' / {nb}',0,0,'R');
            $pdf->AddPage();
            $pdf->SetAutoPageBreak(false);

            $file_name="Sales Stock Report";
            include("rpt_header.php");
            
            $pdf->SetY($header_end);
            $bill_to_y = $pdf->GetY();

            $pdf->SetFont('Arial','B',8);
            $pdf->SetY($bill_to_y);
            $pdf->SetX(10);
            $pdf->Cell(190,7, $product_name. ' ( stock : '.$display_outward_total. " ". $unit_name . ')',1,1,'C',0);
            $product_start_y = $pdf->GetY();
            $pdf->SetFont('Arial','B',9);
            $pdf->SetFillColor(101,114,122);
            $pdf->SetTextColor(255,255,255);
            $pdf->SetX(10);
            $pdf->Cell(10, 8, '#', 1, 0, 'C', 1);
            $pdf->Cell(25, 8, 'Date', 1, 0, 'C', 1);
            $pdf->Cell(25, 8, 'Type ', 1, 0, 'C', 1);
            $pdf->Cell(55, 8, 'Party', 1, 0, 'C', 1);
            $pdf->Cell(25, 8, 'Unit', 1, 0, 'C', 1);
            $pdf->Cell(25, 8, 'Size',1, 0,'C', 1);
            $pdf->Cell(25, 8, 'Outward', 1, 1, 'C', 1);
            $pdf->SetTextColor(0,0,0);
            $pdf->SetFont('Arial','',8);
            $y_axis = $pdf->GetY();

            $content_height = 270 - $footer_height;
            $pdf->SetY($y_axis);
            $pdf->SetX(10);
            $pdf->Cell(10,($content_height - $y_axis),'',1,0,'C');
            $pdf->Cell(25,($content_height - $y_axis),'',1,0,'C');
            $pdf->Cell(25,($content_height - $y_axis),'',1,0,'C');
            $pdf->Cell(55,($content_height - $y_axis),'',1,0,'C');
            $pdf->Cell(25,($content_height - $y_axis),'',1,0,'C');
            $pdf->Cell(25,($content_height - $y_axis),'',1,0,'C');
            $pdf->Cell(25,($content_height - $y_axis),'',1,1,'C');
            $pdf->SetY($content_height);
        } 
        else {
            $content_height = 270 - $footer_height;
            $pdf->SetY($y_axis);
            $pdf->SetX(10);                
             $pdf->Cell(10,($content_height - $y_axis),'',1,0,'C');
            $pdf->Cell(25,($content_height - $y_axis),'',1,0,'C');
            $pdf->Cell(25,($content_height - $y_axis),'',1,0,'C');
            $pdf->Cell(55,($content_height - $y_axis),'',1,0,'C');
            $pdf->Cell(25,($content_height - $y_axis),'',1,0,'C');
            $pdf->Cell(25,($content_height - $y_axis),'',1,0,'C');
            $pdf->Cell(25,($content_height - $y_axis),'',1,1,'C');
        }
        $pdf->SetFont('Arial','B',9);
        $row_y = $pdf->GetY();
        $pdf->SetX(10);
        $pdf->Cell(165,8,'Total Stock',1,0,'R',0);
        if(!empty($total_outward)){
            $pdf->Cell(25,8,$total_outward,1,1,'R',0);
        }
        else{
            $pdf->Cell(25,8,' 0 ',1,1,'C',0);
        }



    }


    $pdf->SetFont('Arial','I',7);
    $pdf->SetY(-15);
    $pdf->SetX(10);
    $pdf->Cell(190,6,'Page No : '.$pdf->PageNo().' / {nb}',0,0,'R');

    $pdf_name = "Sales Stock Report (".$from_date." to ".$to_date.").pdf";
    $pdf->Output($from, $pdf_name);
?>
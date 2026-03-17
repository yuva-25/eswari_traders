<?php
    include("../include_user_check_and_files.php");
    include("../include/number2words.php");

    $view_order_form_id = ""; 
    if (isset($_REQUEST['view_order_form_id'])) {
        $view_order_form_id = $_REQUEST['view_order_form_id'];
    }else {
        header("Location: ../order_form.php");
        exit;
    }  
    

    $order_form_date = date('d-m-Y'); $bill_number = ""; $party_id = ""; $godown_type = "";  $product_count = 0; $gst_option = 2; $tax_option = 1;$tax_type = 2;$party_state = ""; $company_state = "";
    $company_state = $obj->getTableColumnValue($GLOBALS['company_table'], 'company_id', $GLOBALS['bill_company_id'], 'state');

  $product_ids = array(); $unit_ids = array(); $size_ids = array(); $quantity = array(); $rates = array(); $amounts = array(); $party_id = ""; $admin = 0; $notes = "";   $descriptions = array(); $hsn_codes = array();
    $order_form_number = ""; $party_name = ""; $cancelled = 0; $party_details = array(); $bill_total = 0; $sub_total = 0; $product_names = $unit_names = $size_name = array();
    if(!empty($view_order_form_id)){
            $order_form_list = array();
            $order_form_list = $obj->getTableRecords($GLOBALS['order_form_table'], 'order_form_id', $view_order_form_id,'');
            if(!empty($order_form_list)) {
                foreach($order_form_list as $data) {
                    if(!empty($data['order_form_date'])) {
                        $order_form_date = date('Y-m-d', strtotime($data['order_form_date']));
                    }
                    if(!empty($data['order_form_number']) && $data['order_form_number'] != $GLOBALS['null_value']) {
                        $order_form_number = $data['order_form_number'];
                    }
                    if(!empty($data['party_id']) && $data['party_id'] != $GLOBALS['null_value']) {
                        $party_id = $data['party_id'];
                    }
                    if(!empty($data['notes']) && $data['notes'] != $GLOBALS['null_value']) {
                        $notes = $obj->encode_decode('decrypt',$data['notes']);
                    }
                    if(!empty($data['description']) && $data['description'] != $GLOBALS['null_value']) {
                        $description = explode(',',$data['description']);
                    }
                    if(!empty($data['quantity']) && $data['quantity'] != $GLOBALS['null_value']) {
                        $quantity = explode(',',$data['quantity']);
                    }
                    if(!empty($data['unit_id']) && $data['unit_id'] != $GLOBALS['null_value']) {
                        $unit_ids = explode(',',$data['unit_id']);
                    }
                    if(!empty($data['hsn_code']) && $data['hsn_code'] != $GLOBALS['null_value']) {
                        $hsn_codes = explode(',',$data['hsn_code']);
                    }
                    if(!empty($data['product_id']) && $data['product_id'] != $GLOBALS['null_value']) {
                        $product_ids = explode(',',$data['product_id']);
                    }
                    if(!empty($data['product_name']) && $data['product_name'] != $GLOBALS['null_value']) {
                        $product_names = explode(',',$data['product_name']);
                    }
                    if(!empty($data['size_id']) && $data['size_id'] != $GLOBALS['null_value']) {
                        $size_ids = explode(',',$data['size_id']);
                    }
                     if(!empty($data['rate']) && $data['rate'] != $GLOBALS['null_value']) {
                        $rates = explode(',',$data['rate']);
                    }
                    if(!empty($data['amount']) && $data['amount'] != $GLOBALS['null_value']) {
                        $amounts = explode(',',$data['amount']);
                    }
                    if(!empty($data['party_details']) && $data['party_details'] != $GLOBALS['null_value']) {
                        $party_details = $data['party_details'];
                        $party_detail = $obj->encode_decode('decrypt',$party_details);
                        $party_details = explode("<br>",$party_detail);
                    }
                    if(!empty($data['unit_name']) && $data['unit_name'] != $GLOBALS['null_value']) {
                        $unit_names = explode(',',$data['unit_name']);
                    }
                    if(!empty($data['size_name']) && $data['size_name'] != $GLOBALS['null_value']) {
                        $size_names = explode(',',$data['size_name']);
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
        $pdf->SetTitle('Order Form');
        $pdf->SetFont('Arial', 'B', 10);
        $height = 0;
        $display = '';
        $y2 = $pdf->GetY();
        $y = $pdf->GetY();
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->SetY(11);

        $file_name = 'Order Form';
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
        $pdf->Cell(80,8,'Order Form No.       :  ',0,0,'L',0);

        $pdf->SetFont('Arial','',9);
        $pdf->SetX(153);
        $pdf->Cell(40,8,$order_form_number,0,1,'L',0);

        $pdf->SetFont('Arial','B',10);
        $pdf->SetX(113);
        $pdf->Cell(30,8,'Dated                        : ',0,0,'L',0);

        $pdf->SetFont('Arial','',9);
        $pdf->SetX(153);
        $pdf->Cell(40,8,date('d-m-Y',strtotime($order_form_date)),0,1,'L',0);
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
    
        $pdf->Cell(10,8,'S.No',1,0,'C',1);
        $pdf->Cell(90,8,'Product Name',1,0,'C',1);
        $pdf->Cell(30,8,'Unit',1,0,'C',1);
        $pdf->Cell(30,8,'Size',1,0,'C',1);
        $pdf->Cell(30,8,'QTY',1,1,'C',1);  
       
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


        if(!empty($view_order_form_id) && !empty($product_ids)) { 
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
                    $file_name = 'Order Form';
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
                    $pdf->Cell(80,8,'Order Form No.       :  ',0,0,'L',0);

                    $pdf->SetFont('Arial','',9);
                    $pdf->SetX(153);
                    $pdf->Cell(40,8,$order_form_number,0,1,'L',0);

                    $pdf->SetFont('Arial','B',10);
                    $pdf->SetX(113);
                    $pdf->Cell(30,8,'Dated                        : ',0,0,'L',0);

                    $pdf->SetFont('Arial','',9);
                    $pdf->SetX(153);
                    $pdf->Cell(40,8,date('d-m-Y',strtotime($order_form_date)),0,1,'L',0);
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
                
                    $pdf->Cell(10,8,'S.No',1,0,'C',1);
                    $pdf->Cell(90,8,'Product Name',1,0,'C',1);
                    $pdf->Cell(30,8,'Unit',1,0,'C',1);
                    $pdf->Cell(30,8,'Size',1,0,'C',1);
                    $pdf->Cell(30,8,'QTY',1,1,'C',1);
       
                    
                        
                    $pdf->SetFont('Arial','',8);
                    $pdf->SetTextColor(0,0,0);
                    $y_axis = $pdf->GetY();
                    $start_y = $pdf->GetY();


                }
                $y = $pdf->GetY();
                $pdf->SetFont('Arial','',9);
                if(!empty($description[$p])){
                    $description[$p] = $obj->encode_decode('decrypt', $description[$p]);
                }
                if(!empty($product_names[$p])){
                    $product_names[$p] = $obj->encode_decode('decrypt', $product_names[$p]);
                }
                if(!empty($unit_names[$p])){
                    $unit_names[$p] = $obj->encode_decode('decrypt', $unit_names[$p]);
                }
                 if(!empty($size_names[$p])){
                    $size_names[$p] = $obj->encode_decode('decrypt', $size_names[$p]);
                }

                $pdf->SetY($start_y);
                $pdf->SetX(10);
                $pdf->Cell(10, 7, $s_no, 0, 0, 'C', 0);

                $pdf->SetY($start_y);
                $pdf->SetX(20);
                if(!empty($product_names)){
                    $pdf->MultiCell(90, 7, html_entity_decode($product_names[$p]), 0, 'L');
                }else{
                    $pdf->MultiCell(90, 7, " - ", 0, 'L');
                }

                if(!empty($hsn_codes[$p]) || !empty($description[$p])){
                    $pdf->SetTextColor(128, 128, 128);
                    $pdf->SetFont('Arial', 'I', 8);
                    if(!empty($hsn_codes[$p])){
                        $pdf->SetX(20);
                        $pdf->MultiCell(90, 3,"HSN Code : ".$hsn_codes[$p], 0, 'L');
                    }
                    if(!empty($description[$p])){
                        $pdf->SetX(20);
                        $pdf->MultiCell(90, 3,"Description : ".$description[$p], 0, 'L');
                    }
                    $pdf->SetTextColor(0, 0, 0);
                    $pdf->SetFont('Arial', '', 8);
                }
                $product_names_y = $pdf->GetY() - $start_y;

                $pdf->SetY($start_y);
                $pdf->SetX(110);
                if(!empty($unit_names[$p])){
                    $pdf->MultiCell(30, 7,  $unit_names[$p], 0, 'C');
                }else{
                    $pdf->MultiCell(30, 7,  '-', 0, 'C');
                }
                $unit_names_y = $pdf->GetY() - $start_y;

                
                $pdf->SetY($start_y);
                $pdf->SetX(140);
                if(!empty($size_names[$p])){
                    $pdf->MultiCell(30, 7,  $size_names[$p], 0, 'C');
                }else{
                    $pdf->MultiCell(30, 7,  '-', 0, 'C');
                }
                $size_name_y = $pdf->GetY() - $start_y;
                
                $pdf->SetY($start_y);
                $pdf->SetX(170);
                if(!empty($quantity[$p])){
                    $pdf->MultiCell(30, 7,$quantity[$p], 0, 'R');
                    $total_quantity += $quantity[$p];
                } else {
                    $pdf->MultiCell(30, 7,'-', 0, 'C');
                }
                $quantity_y = $pdf->GetY() - $start_y;


                $y_array = array($product_names_y,$unit_names_y, $size_name_y,$quantity_y);
                $product_max = max($y_array);
                // echo $product_max;

                $pdf->SetY($start_y);
                $pdf->SetX(10);
                $pdf->Cell(10,$product_max,'',1,0,'C');
                $pdf->Cell(90,$product_max,'',1,0,'C');
                $pdf->Cell(30,$product_max,'',1,0,'C');
                $pdf->Cell(30,$product_max,'',1,0,'C');
                $pdf->Cell(30,$product_max,'',1,1,'C');

                $start_y += $product_max;
                $s_no++;
                
            }            
        }

        $end_y = $pdf->GetY();
        $last_page_count = $s_no - $last_count;
        if (($footer_height + $end_y) > 270) { 
            $y = $pdf->GetY();
            $pdf->SetY($y_axis);
            $pdf->SetX(10);
            $pdf->Cell(10,(280 - $y_axis),'',1,0,'C',0);
            $pdf->Cell(90,(280 - $y_axis),'',1,0,'C',0);
            $pdf->Cell(30,(280 - $y_axis),'',1,0,'C',0);
            $pdf->Cell(30,(280 - $y_axis),'',1,0,'C',0);
            $pdf->Cell(30,(280 - $y_axis),'',1,1,'C',0);    
            $pdf->SetFont('Arial','I',7);
            $pdf->SetY(-15);
            $pdf->SetX(10);
            $pdf->Cell(190,4,'Page No : '.$pdf->PageNo().' / {nb}',0,0,'R');
            $pdf->AddPage();
            $pdf->SetAutoPageBreak(false);
            $pdf->SetTitle('Order Form');
            $pdf->SetFont('Arial', 'B', 10);
            $pdf->SetFont('Arial', 'BI', 10);
            $height = 0;
            $display = '';
            $y2 = $pdf->GetY();
            $y = $pdf->GetY();
            $pdf->SetFont('Arial', 'B', 12);
            $pdf->SetY(11);
            $file_name = 'Order Form';
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
            $pdf->Cell(80,8,'Order Form No.       :  ',0,0,'L',0);

            $pdf->SetFont('Arial','',9);
            $pdf->SetX(153);
            $pdf->Cell(40,8,$order_form_number,0,1,'L',0);

            $pdf->SetFont('Arial','B',10);
            $pdf->SetX(113);
            $pdf->Cell(30,8,'Dated                        : ',0,0,'L',0);

            $pdf->SetFont('Arial','',9);
            $pdf->SetX(153);
            $pdf->Cell(40,8,date('d-m-Y',strtotime($order_form_date)),0,1,'L',0);
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
            $pdf->Cell(10,8,'S.No',1,0,'C',1);
            $pdf->Cell(90,8,'Product Name',1,0,'C',1);
            $pdf->Cell(30,8,'Unit',1,0,'C',1);
            $pdf->Cell(30,8,'Size',1,0,'C',1);
            $pdf->Cell(30,8,'QTY',1,1,'C',1);  
                
            $pdf->SetFont('Arial','',8);
            $pdf->SetTextColor(0,0,0);
            $y_axis = $pdf->GetY();
            $content_height = 270 - $footer_height;
            $pdf->SetY($y_axis);
            $pdf->SetX(10);
            $pdf->Cell(10,($content_height - $y_axis),'',1,0,'C',0);
            $pdf->Cell(90,($content_height - $y_axis),'',1,0,'C',0);
            $pdf->Cell(30,($content_height - $y_axis),'',1,0,'C',0);
            $pdf->Cell(30,($content_height - $y_axis),'',1,0,'C',0);
            $pdf->Cell(30,($content_height - $y_axis),'',1,1,'C',0);
                
        }else{
            $content_height = 270 - $footer_height;
            $pdf->SetY($y_axis);
            $pdf->SetX(10);
            $pdf->Cell(10,($content_height - $y_axis),'',1,0,'C',0);
            $pdf->Cell(90,($content_height - $y_axis),'',1,0,'C',0);
            $pdf->Cell(30,($content_height - $y_axis),'',1,0,'C',0);
            $pdf->Cell(30,($content_height - $y_axis),'',1,0,'C',0);
            $pdf->Cell(30,($content_height - $y_axis),'',1,1,'C',0);
                
        }


        
        if(!empty($total_quantity)){
            $pdf->SetX(10);
            $pdf->SetFont('Arial','B',8.5);
            $pdf->Cell(160,6.5,'Total Qty',1,0,'R',0);
            $pdf->SetFont('Arial','',8.5);
            $pdf->Cell(30,6.5,$total_quantity,1,1,'R',0);
        }
        
        
        
        $line_y = $pdf->GetY();
        $pdf->Line(10, $line_y, 200, $line_y);

        $pdf->SetFont('Arial', 'BU', 8);
        $pdf->SetX(10);

        $pdf->SetY($line_y);
        $pdf->SetX(155);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->SetY($line_y+2);
        $pdf->SetX(160);
        $pdf->Cell(90, 5,$company_name, 0, 1, 'L', 0);
        $pdf->SetFont('Arial', '', 9);

        $pdf->SetY($line_y+17);
        $pdf->SetX(155);
        $pdf->Cell(90, 5, 'Authorized Signatory', 0, 1, 'L', 0);

        $pdf->SetFont('Arial', 'B', 9);
        $pdf->SetY($line_y);
        $pdf->SetX(10);
        if(!empty($notes)){
            $pdf->MultiCell(120,5,'Notes : '.$notes,0,'L');
        }

        $pdf->SetFont('Arial', '', 7);
        $pdf->SetY(10);
        $pdf->SetX(10);
        $pdf->Cell(190, 270, '', 1, 0, 'C');
    
        
        $pdf->SetFont('Arial','I',7);
        $pdf->setY(-16);
        $pdf->SetX(10);
        $pdf->Cell(190,4,'Page No : '.$pdf->PageNo().' / {nb}',0,0,'R');


        
        $pdf->OutPut('', $order_form_number);

    }
?>
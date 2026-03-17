<?php
    $pdf->SetTitle($file_name);
 
    $pdf->SetFont('Arial','B',9);
    
    $company_logo = "";
    $company_logo = $obj->getTableColumnValue($GLOBALS['company_table'],'primary_company','1','logo');
    
    $company_list = array(); $company_details = "";
    $company_list = $obj->getTableRecords($GLOBALS['company_table'], 'company_id', $GLOBALS['bill_company_id']);

    if(!empty($company_list)){
        foreach($company_list as $data){
            
            if(!empty($data['company_details'])){
                $company_list = $data['company_details'];
            }
        }
    }
    // $company_list = $obj->getTableColumnValue($GLOBALS['company_table'], 'primary_company', '1', 'company_details');
    if(!empty($company_list)){
        $company_details =html_entity_decode($obj->encode_decode('decrypt',$company_list));
        $company_details = explode("$$$", $company_details);
    }
    $bill_company_id = $GLOBALS['bill_company_id'];
    
    $pdf->SetY(10);
    $pdf->SetX(10);
    $pdf->SetFont('Arial','B',9);


    $pdf->Cell(130,7,$file_name,1,1,'C',0);
    $y = $pdf->GetY(); 
    $pdf->SetFont('Arial','B',7);
    
    $pdf->SetY($y);
    $pdf->SetX(10);

    if (!empty($company_details)) {
        for ($i = 0; $i < count($company_details); $i++) {
            $company_details[$i] = trim($company_details[$i]);
            if (!empty($company_details[$i]) && $company_details[$i] != $GLOBALS['null_value']) {
                
                $company_details[$i] = str_replace("<br>"," ",$company_details[$i]);
                if ($i === 0) {  // Corrected comparison
                    $pdf->SetFont('Arial', 'B', 10);
                    $pdf->MultiCell(130, 6, html_entity_decode($company_details[$i]), 0, 'C');
                    $rt = $pdf->gety();
                } else {
                    $pdf->SetFont('Arial', '', 7);
                    // $pdf->sety($rt);
                    $pdf->SetX(10);
                    $pdf->MultiCell(130, 4, html_entity_decode($company_details[$i]), 0, 'C');
                    $end_y =$pdf->GetY();
                }
            }
        }
    }

    if(!empty($company_logo)) {
        if(file_exists('../include/images/upload/'.$company_logo)){
            $pdf->Image('../include/images/upload/'.$company_logo,15,25,27,10);
        }
    }

    $pdf->SetY(10);
    $pdf->SetX(10);
    $pdf->Cell(130,($end_y - 10),'',1,1,'C');
    $header_end = $pdf->GetY();

    $pdf->SetY($header_end);

         

?>
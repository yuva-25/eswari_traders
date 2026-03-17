<?php
    $pdf->SetTitle($file_name);
 
    $pdf->SetFont('Arial','B',9);
    
    $company_logo = "";
    $company_logo = $obj->getTableColumnValue($GLOBALS['company_table'],'company_id', $GLOBALS['bill_company_id'],'watermark');

    if(!empty($company_logo)) {
        $pdf->SetAlpha(0.2);
        if(!empty($company_logo)){
            if(file_exists('../include/images/upload/'.$company_logo)){
                $pdf->Image('../include/images/upload/'.$company_logo,35,95,70,35);
            }
        }
        
        $pdf->SetAlpha(1);
    }

?>
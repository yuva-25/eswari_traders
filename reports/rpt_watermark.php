<?php
    $pdf->SetTitle($file_name);
 
    $pdf->SetFont('Arial','B',9);
    
    $company_watermark = "";
    $company_watermark = $obj->getTableColumnValue($GLOBALS['company_table'],'company_id',$GLOBALS['bill_company_id'],'watermark');


    if(!empty($company_watermark)) {
        $pdf->SetAlpha(0.2);
        if(!empty($company_watermark)){
            if(file_exists('../include/images/upload/'.$company_watermark)){
                $pdf->Image('../include/images/upload/'.$company_watermark,62,100,85,85);
            }
        }
        
        $pdf->SetAlpha(1);
    }

?>
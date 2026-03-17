<?php
    $pdf->SetTitle($file_name);
 
    if(file_exists('../include/images/cancelled.jpg')) {
        $pdf->SetAlpha(0.3);
        $pdf->Image('../include/images/cancelled.jpg',35,95,70,35);
        $pdf->SetAlpha(1);
    }

?>
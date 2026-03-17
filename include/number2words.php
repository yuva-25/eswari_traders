<?php
function getIndianCurrency(float $amount)
{
    $no = floor($amount);
    $decimal = (int) round(($amount - $no) * 100); // ✅ Proper integer conversion

    $digits_length = strlen($no);
    $i = 0;
    $str = array();

    $words = array(
        0 => '', 1 => 'One', 2 => 'Two',
        3 => 'Three', 4 => 'Four', 5 => 'Five', 6 => 'Six',
        7 => 'Seven', 8 => 'Eight', 9 => 'Nine',
        10 => 'Ten', 11 => 'Eleven', 12 => 'Twelve',
        13 => 'Thirteen', 14 => 'Fourteen', 15 => 'Fifteen',
        16 => 'Sixteen', 17 => 'Seventeen', 18 => 'Eighteen',
        19 => 'Nineteen', 20 => 'Twenty', 30 => 'Thirty',
        40 => 'Forty', 50 => 'Fifty', 60 => 'Sixty',
        70 => 'Seventy', 80 => 'Eighty', 90 => 'Ninety'
    );

    $digits = array('', 'Hundred', 'Thousand', 'Lakh', 'Crore');

    while ($i < $digits_length) {
        $divider = ($i == 2) ? 10 : 100;
        $number_part = floor($no % $divider);
        $no = floor($no / $divider);
        $i += ($divider == 10) ? 1 : 2;

        if ($number_part) {
            $counter = count($str);
            $plural = ($counter && $number_part > 9) ? 's' : '';
            $hundred = ($counter == 1 && !empty($str[0])) ? ' and ' : '';

            if ($number_part < 21) {
                $str[] = $words[$number_part] . " " . $digits[$counter] . $plural . " " . $hundred;
            } else {
                $str[] = $words[floor($number_part / 10) * 10] . " " .
                         $words[$number_part % 10] . " " .
                         $digits[$counter] . $plural . " " . $hundred;
            }
        } else {
            $str[] = null;
        }
    }

    $rupees = implode('', array_reverse($str));
    $rupees = trim($rupees);

    // ✅ Correct Paise Handling
    if ($decimal > 0) {
        if ($decimal < 21) {
            $paise = " and " . $words[$decimal] . " Paise";
        } else {
            $paise = " and " .
                     $words[floor($decimal / 10) * 10] . " " .
                     $words[$decimal % 10] .
                     " Paise";
        }
    } else {
        $paise = "";
    }

    return ($rupees ? $rupees . " Only" : "") . $paise;
}
?>
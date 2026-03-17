<?php
include("include_files.php");
?>

<script type="text/javascript" src="include/js/xlsx.full.min.js"></script>
<table id="tbl_product_list" class="data-table table nowrap tablefont"
    style="margin: auto; width: 900px;display:none;">
    <thead class="thead-dark">
        <tr>
            <th style="text-align: center; width: 50px;">S.No</th>
            <th style="text-align: center; width: 125px;">Product Name</th>
            <th style="text-align: center; width: 125px;">Unit Name</th>
            <th style="text-align: center; width: 125px;">Size Name</th>
            <th style="text-align: center; width: 125px;">HSN code</th>
            <th style="text-align: center; width: 125px;">Product Tax in %</th>
            <th style="text-align: center; width: 125px;">Description</th>

        </tr>
    </thead>

    <tbody>
        <?php
        $product_id = "";
        if (isset($_REQUEST['product_id'])) {
            $product_id = $_REQUEST['product_id'];
        }

        if(!empty($product_id) && $product_id!=$GLOBALS['null_value']){
            $total_records_list = array();
            $total_records_list = $obj->getTableRecords($GLOBALS['product_table'], 'product_id', $product_id, 'DESC');
        }else{
            $total_records_list = array();
            $total_records_list = $obj->getTableRecords($GLOBALS['product_table'], '', '', 'DESC');
        }
        if (!empty($total_records_list)) {
            foreach ($total_records_list as $key => $data) {
                $index = $key + 1; ?>
                <tr>
                    <td class="ribbon-header" style="cursor:default;"> <?php
                        echo $index; ?>
                    </td>
                    <td> <?php
                        if (!empty($data['product_name']) && $data['product_name'] != $GLOBALS['null_value']) {
                            echo $obj->encode_decode("decrypt", $data['product_name']);
                        } else {
                            echo "-";
                        }  ?>
                    </td>                   
                    <td> <?php
                        if (!empty($data['unit_name']) && $data['unit_name'] != $GLOBALS['null_value']) {
                            echo $obj->encode_decode('decrypt', $data['unit_name']);
                        } else {
                            echo "-";
                        }  ?>
                    </td>
                     <td> <?php
                        if (!empty($data['size_name']) && $data['size_name'] != $GLOBALS['null_value']) {
                            echo $obj->encode_decode('decrypt', $data['size_name']);
                        } else {
                            echo "-";
                        }  ?>
                    </td>
                    <td> <?php
                        if (!empty($data['hsn_code']) && $data['hsn_code'] != $GLOBALS['null_value']) {
                            echo $data['hsn_code'];
                        }  else {
                            echo "-";
                        } ?>
                    </td>
                    <td> <?php
                        if (!empty($data['product_tax']) && $data['product_tax'] != $GLOBALS['null_value']) {
                            $tax = str_replace('%', '', $data['product_tax']);
                            echo $tax;
                        } else {
                            echo '-';
                        }

                        ?>
                    </td>  
                    <td> <?php
                        if (!empty($data['description']) && $data['description'] != $GLOBALS['null_value']) {
                            $description = $obj->encode_decode('decrypt', $data['description']);
						    $description  = htmlentities($description, ENT_QUOTES);
                            echo $description;
                        } else {
                            echo '-';
                        }

                        ?>
                    </td>                     
                </tr>
            <?php }
        } ?>
    </tbody>
</table>

<script>
    ExportToExcel();
    function ExportToExcel(type, fn, dl) {
        var elt = document.getElementById('tbl_product_list');
        var wb = XLSX.utils.table_to_book(elt, { sheet: "sheet1" });
        if (dl) {
            XLSX.write(wb, { bookType: type, bookSST: true, type: 'base64' });
        } else {
            XLSX.writeFile(wb, fn || ('product_list.' + (type || 'xlsx')));
        }
        window.open("product.php", "_self");
    }
</script>
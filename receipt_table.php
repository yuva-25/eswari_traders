<?php
    $table_id = isset($table_id) ? $table_id : "table-active";
?>
<div class="table-responsive">
    <table class="table nowrap cursor smallfnt w-100 table-bordered datatable fw-bold" id="<?php echo $table_id; ?>">
        <thead class="bg-dark smallfnt">
            <tr style="white-space:pre;">
                <th>Sno</th>
                <th>Date</th>
                <th>Receipt Number</th>
                <th>Party Name</th>
                <th>Amount</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
    <input type="hidden" name="cancelled" value="<?php echo $cancelled; ?>">
</div>

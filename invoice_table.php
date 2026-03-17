<input type="hidden"  name="cancelled" value="<?php echo $cancelled; ?>">
<div class="table-responsive" style="height:800px; overflow-y:scroll!important;">
    <table id="<?php echo $table_id; ?>" class="datatable table nowrap border cursor text-center smallfnt table-bordered display table-hover">
        <thead style="background-color:#4e5154;color:white">
            <tr>
                <th style="min-width:75px;">S.No</th>
                <th style="min-width:100px;">Created Datetime</th>
                <th style="min-width:100px;">Updated Datetime</th>
                <th style="min-width:100px;">Bill Date</th>
                <th style="min-width:100px;">Bill No</th>
                <th style="min-width:200px;">Party Details</th>
                <th style="min-width:75px;">Total Amount</th>
                <th style="min-width:75px;">Action</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
</div>

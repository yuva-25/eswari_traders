<button type="button" class="d-none delete_modal_button btn btn-primary" data-bs-toggle="modal" data-bs-target="#DeleteModal">button</button>

<!-- The Modal -->
<div class="modal fade" id="DeleteModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title h5">Delete</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        Are you sure want to delete?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger yes"onClick="Javascript:confirm_delete_modal(this);" >Delete</button>
      </div>
    </div>
  </div>
</div>
<button type="button" data-toggle="modal" data-target="#AcknowledgementModal" class="d-none acknowledgement_modal_button"></button>
<!-- The Modal -->
<div class="modal fade" id="AcknowledgementModal" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Invocie Acknowledgement</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                Modal body..
            </div>
        </div>
    </div>
</div>
<button type="button" data-toggle="modal" data-target="#clearancemodal" class="d-none clearance_modal_button"></button>
<div class="modal fade" id="clearancemodal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title h5">Parcel Receiving Person Details</h1>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            </div>
            <div class="modal-footer">
                <button class="btn btn-dark btnwidth submit_button" type="button" onClick="Javascript:SaveModalContent('clearance_form', 'clearance_entry_changes.php', 'clearance_entry.php');">Submit</button>
            </div>
        </div>
    </div>
</div>
<button type="button" data-toggle="modal" data-target="#ReceiptDeleteModal" class="d-none receipt_delete_modal_button"></button>
<!-- The Modal -->
<div class="modal fade" id="ReceiptDeleteModal" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
        <!-- Modal Header -->
        <div class="modal-header">
            <h4 class="modal-title"></h4>
            <button type="button" class="close d-none" data-dismiss="modal">&times;</button>
        </div>
        <!-- Modal body -->
        <div class="modal-body">
            Modal body..
        </div>
        <!-- Modal footer -->
        <div class="modal-footer">
            <button type="button" class="btn btn-success yes" onClick="Javascript:confirm_receipt_delete_modal(this);">Yes</button>
            <button type="button" class="btn btn-danger no" onClick="Javascript:cancel_delete_modal(this);">No</button>
        </div>
        </div>
    </div>
</div>
<button type="button" data-toggle="modal" data-target="#PreviewUpdateModal" class="d-none preview_modal_button"></button>
<!-- The Modal -->
<div class="modal fade" id="PreviewUpdateModal" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Preview Receipt</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                Modal body..
            </div>
        </div>
    </div>
</div>
<button type="button" data-toggle="modal" data-target="#RemarksUpdateModal" class="d-none remarks_modal_button"></button>
<!-- The Modal -->
<div class="modal fade" id="RemarksUpdateModal" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Delete Receipt</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                Modal body..
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success yes" onClick="Javascript:confirm_delete_receipt_modal(this);">Submit</button>
            </div>
        </div>
    </div>
</div>
<button type="button" data-bs-toggle="modal" data-bs-target="#CustomGroupModal" class="d-none custom_group_modal_button"></button>
<!-- The Modal -->
<div class="modal fade" id="CustomGroupModal" data-bs-keyboard="false" data-bs-backdrop="static">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Custom Group</h4>
                <button type="button" class="close" data-bs-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
            </div>
        </div>
    </div>
</div>
<button type="button" data-bs-toggle="modal" data-bs-target="#CustomCategoryModal" class="d-none custom_category_modal_button"></button>
<!-- The Modal -->
<div class="modal fade" id="CustomCategoryModal" data-bs-keyboard="false" data-bs-backdrop="static">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Custom Category</h4>
                <button type="button" class="close" data-bs-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
            </div>
        </div>
    </div>
</div>
<button type="button" data-bs-toggle="modal" data-bs-target="#CustomMemberModal" class="d-none custom_member_modal_button"></button>
<!-- The Modal -->
<div class="modal fade" id="CustomMemberModal" data-bs-keyboard="false" data-bs-backdrop="static">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Custom Member</h4>
                <button type="button" class="close" data-bs-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
            </div>
        </div>
    </div>
</div>

<button type="button" data-bs-toggle="modal" data-bs-target="#ViewDetailsModal" class="d-none details_modal_button"></button>
<!-- The Modal -->
<div class="modal fade" id="ViewDetailsModal" data-bs-keyboard="false" data-bs-backdrop="static">
    <div class="modal-dialog ">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title text-center"></h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                Modal body..
            </div>
        </div>
    </div>
</div>


<button type="button" data-bs-toggle="modal" data-bs-target="#PendingDetailsModal" class="d-none pending_modal_button"></button>
<!-- The Modal -->
<div class="modal modal-lg fade" id="PendingDetailsModal" data-bs-keyboard="false" data-bs-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title text-center"></h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                Modal body..
            </div>
        </div>
    </div>
</div>

<button type="button" data-bs-toggle="modal" data-bs-target="#ChitDetailsModal" class="d-none chit_details_modal_button"></button>
<!-- The Modal -->
<div class="modal modal-lg fade" id="ChitDetailsModal" data-bs-keyboard="false" data-bs-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title text-center"></h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                Modal body..
            </div>
        </div>
    </div>
</div>

<button type="button" data-bs-toggle="modal" data-bs-target="#MemberChitDetailsModal" class="d-none chit_details_modal_button"></button>
<!-- The Modal -->
<div class="modal modal-lg fade" id="MemberChitDetailsModal" data-bs-keyboard="false" data-bs-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title text-center"></h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                Modal body..
            </div>
        </div>
    </div>
</div>


<button type="button" data-bs-toggle="modal" data-bs-target="#CustomProductModal" class="d-none custom_product_modal_button"></button>
<!-- The Modal -->
<div class="modal fade" id="CustomProductModal" data-bs-keyboard="false" data-bs-backdrop="static">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Custom Product</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
            </div>
        </div>
    </div>
</div>

<button type="button" data-bs-toggle="modal" data-bs-target="#ProductUploadModal" class="d-none product_upload_modal_button"></button>
<?php                             
$current_file = pathinfo($_SERVER['PHP_SELF'], PATHINFO_FILENAME);                             
?>
<div class="modal fade" id="ProductUploadModal" data-bs-keyboard="false" data-bs-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content" style="height:150px !important;">
        
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title" id="product_modal_header"></h4>
                <button type="button" class="btn-close close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true"></span>
                </button>
            </div>
        
            <!-- Modal body -->
            <div class="modal-body text-center">
                <button type="button" class="btn btn-success" onClick="Javascript:UploadExcel('1','<?php echo $current_file ?>');">New</button>
                 
                <button type="button" class="btn btn-success" onClick="Javascript:UploadExcel('2','<?php echo $current_file ?>');">Overwrite</button>
            </div>                                    
        </div>
    </div>
</div>



<button type="button" data-bs-toggle="modal" data-bs-target="#CustomPartyModal" class="d-none custom_party_modal_button"></button>
<!-- The Modal -->
<div class="modal fade" id="CustomPartyModal" data-bs-keyboard="false" data-bs-backdrop="static">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Custom Party</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
            </div>
        </div>
    </div>
</div>
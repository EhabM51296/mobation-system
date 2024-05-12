<div id="sales" class="page">
    <div class="flex flex-column gap-10">
        <button data-id="add-sales-modal" data-type = "add" class="get-products open-modal flex items-center gap-5 text-md bg-active">
            <p class="">Add Sale</p>
            <img src="<?php echo ICONS_PATH; ?>/add.svg" width="30" />
        </button>
        <div>
            <div class="table-card">
                <div>
                    <h3>Sales Data</h3>
                </div>
                <table id="sales-table">
                    <thead>
                        <tr>
                            <th data-name="actions">Actions</th>
                            <th data-name="clientName" data-orderable data-filter>Client Name</th>
                            <th data-name="employeeName" data-orderable data-filter>Employee Name</th>
                            <th data-name="total_amount">Invoice Amount</th>
                            <th data-name="discount_amount">Discount Amount</th>
                            <th data-name="amount_after_discount">Amount After Discount</th>
                            <th data-name="amount_paid">Amount Paid</th>
                            <th data-name="createdat">Creation Date</th>
                            <th data-name="updatedat">Update Date</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php require (PAGES_PATH."/sales/addForm.php"); ?>
<?php require (PAGES_PATH."/sales/editForm.php"); ?>

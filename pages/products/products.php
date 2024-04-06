<div id="products" class="page">
    <div class="flex flex-column gap-10">
        <button data-id="add-products-modal" class="open-modal flex items-center gap-5 text-md bg-active">
            <p class="">Add Product</p>
            <img src="<?php echo ICONS_PATH; ?>/add.svg" width="30" />
        </button>
        <div>
            <div class="table-card">
                <div>
                    <h3>Products Data</h3>
                </div>
                <table id="products-table">
                    <thead>
                        <tr>
                            <th data-name="actions">Actions</th>
                            <th data-name="name" data-orderable data-filter>Name</th>
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
<?php require (PAGES_PATH."/products/addForm.php"); ?>
<?php require (PAGES_PATH."/products/editForm.php"); ?>
<?php require (PAGES_PATH."/products/addBatchForm.php"); ?>
<?php require (PAGES_PATH."/products/editBatchForm.php"); ?>

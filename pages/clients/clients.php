<div id="clients" class="page">
    <div class="flex flex-column gap-10">
        <button data-id="add-clients-modal" class="open-modal flex items-center gap-5 text-md bg-active">
            <p class="">Add Client</p>
            <img src="<?php echo ICONS_PATH; ?>/add.svg" width="30" />
        </button>
        <div>
            <div class="table-card">
                <div>
                    <h3>Clients Data</h3>
                </div>
                <table id="clients-table">
                    <thead>
                        <tr>
                            <th data-name="actions">Actions</th>
                            <th data-name="name" data-orderable data-filter>Name</th>
                            <th data-name="phone">Phone</th>
                            <th data-name="location">Location</th>
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
<?php require (PAGES_PATH."/clients/addForm.php"); ?>
<?php require (PAGES_PATH."/clients/editForm.php"); ?>

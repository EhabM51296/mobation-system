<div id="employees" class="page">
    <div class="flex flex-column gap-10">
        <button data-id="add-employees-modal" class="open-modal flex items-center gap-5 text-md bg-active">
            <p class="">Add Employee</p>
            <img src="<?php echo ICONS_PATH; ?>/add.svg" width="30" />
        </button>
        <div>
            <div class="table-card">
                <div>
                    <h3>Employees Data</h3>
                </div>
                <table id="employees-table">
                    <thead>
                        <tr>
                            <th data-name="actions">Actions</th>
                            <th data-name="picture" data-image>Picture</th>
                            <th data-name="name" data-orderable data-filter>Name</th>
                            <th data-name="dob" data-orderable data-filter>Date of birth</th>
                            <th data-name="location" data-orderable data-filter>Location</th>
                            <th data-name="salary" data-orderable data-filter>Salary</th>
                            <th data-name="password">Password</th>
                            <th data-name="token_key">Access Token</th>
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
<?php require (PAGES_PATH."/employees/addForm.php"); ?>
<?php require (PAGES_PATH."/employees/editForm.php"); ?>

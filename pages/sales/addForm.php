<div class="d-none modal-container" id="add-sales-modal">
    <div class="modal">
        <div class="form-box">
            <div class="flex gap-10 flex-column">
                <div>
                    <h2>Add a sale</h2>
                </div>
                <div>
                    <form data-obj = "sales" id="add-sales-form" data-key="add-client" method="post"
                        action="<?php echo BACKEND_PATH; ?>/models/sales/sales.php">
                        <div class="flex flex-column gap-20">
                            <div class="col-2-container w-full flex flex-wrap justify-between">
                                <div>
                                    <input type="text" placeholder="Name" id="add-client-name" name="name"
                                        class="form-input validate-input data-to-send" data-validate="required"
                                        data-required="Name is required" />
                                    <div class="validation-message" id="validation-message-add-client-name">
                                    </div>
                                </div>
                            </div>
                            <div class="w-full flex gap-20 justify-end">
                                <button class="bg-active" type="submit">Add</button>
                                <button class="bg-danger close-modal" type="button">Cancel</button></div>
                        </div>


                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
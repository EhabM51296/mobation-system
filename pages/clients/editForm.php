<div class="d-none modal-container" id="edit-clients-modal">
    <div class="modal">
        <div class="form-box">
            <div class="flex gap-10 flex-column">
                <div>
                    <h2>Edit client</h2>
                </div>
                <div>
                    <form data-obj = "clients" data-id = "" id="edit-clients-form" data-key="edit-client" method="post"
                        action="<?php echo BACKEND_PATH; ?>/models/clients/clients.php">
                        <div class="flex flex-column gap-20">
                            <div class="w-full flex flex-wrap gap-10 justify-between">
                                <div>
                                    <input type="text" placeholder="Name" id="edit-client-name" name="name"
                                        class="form-input data-to-send validate-input" data-validate="required"
                                        data-required="Name is required" />
                                    <div class="validation-message" id="validation-message-edit-client-name">
                                    </div>
                                </div>
                                <div>
                                    <input type="text" placeholder="Phone" id="edit-client-phone" name="phone"
                                        class="form-input data-to-send" />
                                </div>
                                <div>
                                    <input type="text" placeholder="Location" id="edit-client-location"
                                        name="location" class="form-input data-to-send" />
                                </div>
                            </div>
                            <div class="w-full flex gap-20 justify-end">
                                <button class="bg-active" type="submit">Edit</button>
                                <button class="bg-danger close-modal" type="button">Cancel</button></div>
                        </div>


                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
<div class="d-none modal-container" id="add-batch-modal">
    <div class="modal">
        <div class="form-box">
            <div class="flex gap-10 flex-column">
                <div class="flex justify-between">
                    <h2>Add Batch</h2>
                </div>
                <!-- Add Batch -->
                <div>
                    <form data-obj="batch" id="add-batch-form" data-key="add-batch" method="post"
                        action="<?php echo BACKEND_PATH; ?>/models/products/products.php">
                        <div class="flex flex-column gap-20">
                            <div class="col-2-container w-full flex flex-wrap justify-between">
                                <div>
                                    <input type="text" placeholder="Name" id="add-batch-name" name="name"
                                        class="form-input validate-input data-to-send" data-validate="required"
                                        data-required="Name is required" />
                                    <div class="validation-message" id="validation-message-add-batch-name">
                                    </div>
                                </div>
                                <div>
                                    <input type="number" placeholder="Count" id="add-batch-count" name="count"
                                        class="form-input validate-input data-to-send" data-validate="positiveInteger"
                                        data-positiveInteger="Count must be a positive integer" />
                                    <div class="validation-message" id="validation-message-add-batch-count">
                                    </div>
                                </div>
                                <div>
                                    <input type="number" placeholder="Price per item" id="add-batch-price" name="price"
                                        class="form-input validate-input data-to-send" data-validate="positiveNumber"
                                        data-positiveNumber="Price must be a positive number" step="0.1" />
                                    <div class="validation-message" id="validation-message-add-batch-price">
                                    </div>
                                </div>
                                <div>
                                    <input type="date" placeholder="Expiry Date" id="add-batch-expiryDate"
                                        name="expiry_date" class="form-input validate-input data-to-send"
                                        data-validate="required" data-required="Expiry date is required" />
                                    <div class="validation-message" id="validation-message-add-batch-expiryDate">
                                    </div>
                                </div>
                                <div>
                                    <input type="hidden" placeholder="prodid" id="add-batch-prodid" name="prodid"
                                        class="form-input validate-input data-to-send" data-validate="required"
                                        data-required="prodid is required" />
                                    <div class="validation-message" id="validation-message-add-batch-prodid">
                                    </div>
                                </div>
                            </div>
                            <div class="w-full flex gap-20 justify-end">
                                <button class="bg-active" type="submit">Add</button>
                                <button class="bg-danger close-modal" type="button">Cancel</button>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>
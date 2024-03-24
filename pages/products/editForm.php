<div class="d-none modal-container" id="edit-products-modal">
    <div class="modal">
        <div class="form-box">
            <div class="flex gap-10 flex-column">
                <div>
                    <h2>Edit product</h2>
                </div>
                <div>
                    <form data-obj = "products" data-id = "" id="edit-products-form" data-key="edit-product" method="post"
                        action="<?php echo BACKEND_PATH; ?>/models/products/products.php">
                        <div class="flex flex-column gap-20">
                            <div class="w-full flex flex-wrap gap-10 justify-between">
                                <div>
                                    <input type="text" placeholder="Name" id="edit-product-name" name="name"
                                        class="form-input data-to-send validate-input" data-validate="required"
                                        data-required="Name is required" />
                                    <div class="validation-message" id="validation-message-edit-product-name">
                                    </div>
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
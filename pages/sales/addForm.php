<div class="d-none modal-container" id="add-sales-modal">
    <div class="modal">
        <div class="form-box full-box">
            <div class="flex gap-10 flex-column">
                <div>
                    <h2>Add a sale</h2>
                </div>
                <div>
                    <form data-obj="sales" id="add-sales-form" data-key="add-sales" method="post"
                        action="<?php echo BACKEND_PATH; ?>/models/sales/sales.php">
                        <div class="flex flex-column gap-20">
                            <div class="col-2-container w-full flex flex-wrap justify-between">
                                <?php echo generateDropdownComponent("add-sales-client-dropdown", "clients", "Clients", "clients/clients.php?dropdown=all", [], true, 'Choose a client', false); ?>
                                <div>
                                    <input type="number" placeholder="Amount Paid" id="add-sales-amountPaid"
                                        name="amount_paid" class="form-input validate-input data-to-send"
                                        data-validate="positiveNumber"
                                        data-positiveNumber="Amount paid is required and must be positive" />
                                    <div class="validation-message" id="validation-message-add-sales-amountPaid">
                                    </div>
                                </div>
                                <div>
                                    <input type="number" placeholder="Discount Amount in %"
                                        id="add-sales-discountAmount" name="discount_amount"
                                        class="form-input validate-input data-to-send discount-input" data-validate="percentage"
                                        data-percentage="Discount amount must be between 0 and 100" step="0.01" />
                                    <div class="validation-message" id="validation-message-add-sales-discountAmount">
                                    </div>
                                </div>
                            </div>
                            <!-- Products Selected -->
                            <div>
                                <div class="flex gap-5 flex-wrap" id="add-sales-products-selected-container">

                                </div>
                                <input type="hidden" class="form-input validate-input data-to-send"
                                    data-validate="required" data-required="Choose at least one product"
                                    id="add-sales-products-selected" name="products"/>
                                <div class="validation-message text-center" id="validation-message-add-sales-products-selected">
                                </div>
                            </div>
                            <div>
                                <p>Total amount: <span class="add-total-amount">0</span></p>
                            </div>
                            <div class="w-full flex gap-20 justify-end">
                                <button class="bg-active" type="submit">Add</button>
                                <button class="bg-danger close-modal" type="button">Cancel</button>
                            </div>
                        </div>
                    </form>
                </div>
                <!-- Products Forms -->
                <div class="flex flex-column gap-10">
                    <h3>Add/Edit Product to sales</h3>
                    <div class="grid-2 products-list-container-add">
                        <!-- get all products -->
                       
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="d-none modal-container" id="add-employees-modal">
    <div class="modal">
        <div class="form-box">
            <div class="flex gap-10 flex-column">
                <div>
                    <h2>Add an employee</h2>
                </div>
                <div>
                    <form  enctype="multipart/form-data" data-obj="employees" id="add-employees-form" data-key="add-employee" method="post"
                        action="<?php echo BACKEND_PATH; ?>/models/employees/employees.php">
                        <div class="flex flex-column gap-20">
                            <div class="col-2-container w-full flex flex-wrap justify-between">
                                <div>
                                    <input type="text" placeholder="Name" id="add-employee-name" name="name"
                                        class="form-input validate-input data-to-send" data-validate="required"
                                        data-required="Name is required" />
                                    <div class="validation-message" id="validation-message-add-employee-name">
                                    </div>
                                </div>
                                <div>
                                    <div class="relative">
                                        <input type="password" placeholder="Password" id="add-employee-password"
                                            name="password" class="form-input data-to-send validate-input"
                                            data-validate="password"
                                            data-password="Password must have at least one letter, one digit, one special character, and a minimum length of 8 characters" />
                                        <button type="button" class="show-hide-password"><img
                                                src="<?php echo ICONS_PATH; ?>/hiddenPassword.svg"
                                                class="hide-password" />
                                            <img src="<?php echo ICONS_PATH; ?>/visiblePassword.svg"
                                                class="show-password" />
                                        </button>
                                    </div>
                                    <div class="validation-message" id="validation-message-add-employee-password">
                                    </div>
                                </div>
                                <div>
                                    <input type="date" placeholder="Date of birth" id="add-employee-dob" name="dob"
                                        class="form-input data-to-send" />
                                </div>
                                <div>
                                    <input type="text" placeholder="Location" id="add-employee-location" name="location"
                                        class="form-input data-to-send" />
                                </div>
                                <div>
                                    <input type="number" placeholder="Salary" id="add-employee-salary" name="salary"
                                        class="form-input validate-input data-to-send" data-validate="positiveNumber"
                                        data-positiveNumber="Salary must be a positive number" step="0.1" />
                                    <div class="validation-message" id="validation-message-add-employee-salary">
                                    </div>
                                </div>
                                <div class="flex flex-column gap-10 items-center">
                                    <div>
                                        <img src="./assets/images/noProfile.jpg" class="file-preview" id = "add-employee-picture-preview" data-default-src = "./assets/images/noProfile.jpg"/>
                                    </div>
                                    <div class="relative">
                                        <input type="file" placeholder="Picture" id="add-employee-picture"
                                            name="picture"
                                            data-preview
                                            class="form-input data-to-send custom-file-input" />
                                        <button type="button" class="custom-file-input-controller bg-active text-white">
                                            Add Image
                                        </button>
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
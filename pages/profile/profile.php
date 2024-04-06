<div id="profile" class="page">
    <div class="flex flex-column gap-40">
        <!-- edit information -->
        <div class="flex flex-column gap-20">
            <p>Edit Information</p>
            <div>
                <form id="edit-profile-form" data-key="edit-profile" method="post"
                    action="<?php echo BACKEND_PATH; ?>/models/profile/profile.php">
                    <div class="flex flex-column gap-20 w-max-200px">
                        <div>
                            <input type="text" placeholder="Name" id="edit-profile-name" name="name"
                                class="form-input data-to-send validate-input username-input" data-validate="required"
                                data-required="Name is required" value="<?php echo $_SESSION['user']['name']; ?>" />
                            <div class="validation-message" id="validation-message-edit-profile-name">
                            </div>
                        </div>
                        <div>
                            <input type="text" placeholder="Name" id="edit-profile-email" name="email"
                                class="form-input data-to-send validate-input useremail-input"
                                data-validate="required email" data-required="Email is required"
                                data-email="Invalid email format" value="<?php echo $_SESSION['user']['email']; ?>" />
                            <div class="validation-message" id="validation-message-edit-profile-email">
                            </div>
                        </div>
                        <div>
                            <button class="bg-active" type="submit">Edit</button>
                        </div>
                    </div>


                </form>
            </div>
        </div>
        <!-- Change password -->
        <div class="flex flex-column gap-20">
            <p>Change Password</p>
            <div>
                <form id="change-password-form" data-key="change-password" method="post"
                    action="<?php echo BACKEND_PATH; ?>/models/profile/profile.php">
                    <div class="flex flex-column gap-20 w-max-200px">
                        <div>
                            <div class="relative">
                                <input type="password" placeholder="Current Password" id="change-current-password"
                                    name="currentPassword" class="form-input data-to-send validate-input"
                                    data-validate="requiredAllowedSpace"
                                    data-requiredAllowedSpace="Current password is required" />
                                <button type="button" class="show-hide-password"><img
                                        src="<?php echo ICONS_PATH; ?>/hiddenPassword.svg" class="hide-password" />
                                    <img src="<?php echo ICONS_PATH; ?>/visiblePassword.svg" class="show-password" />
                                </button>
                            </div>

                            <div class="validation-message" id="validation-message-change-current-password">
                            </div>
                        </div>
                        <div>
                            <div class="relative">
                                <input type="password" placeholder="New Password" id="change-new-password"
                                    name="newPassword" class="form-input data-to-send validate-input"
                                    data-validate="password"
                                    data-password="Password must have at least one letter, one digit, one special character, and a minimum length of 8 characters" />
                                <button type="button" class="show-hide-password"><img
                                        src="<?php echo ICONS_PATH; ?>/hiddenPassword.svg" class="hide-password" />
                                    <img src="<?php echo ICONS_PATH; ?>/visiblePassword.svg" class="show-password" />
                                </button>
                            </div>
                            <div class="validation-message" id="validation-message-change-new-password">
                            </div>
                        </div>
                        <div>
                            <button class="bg-active" type="submit">Change Password</button>
                        </div>
                    </div>


                </form>
            </div>
        </div>
    </div>

</div>
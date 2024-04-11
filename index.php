<?php
require_once './constants/constants.php';
require (BACKEND_PATH . "/auth/auth.php");
$res = login("hosam@mobation.com", "123456Ehab!");
if (!$res)
    die("failed to login");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Name</title>
    <link href="<?php echo STYLE_PATH; ?>/index.css" rel="stylesheet" />
    <link href="<?php echo STYLE_PATH; ?>/classes.css" rel="stylesheet" />
    <link href="<?php echo SCRIPT_PATH; ?>/datatables/datatables.min.css" rel="stylesheet" />
    <link href="<?php echo STYLE_PATH; ?>/tables.css" rel="stylesheet" />
</head>

<body>
    <?php require (COMPONENTS_PATH . "/messageModal.php"); ?>
    <?php require (COMPONENTS_PATH . "/dropDown.php"); ?>
    <?php require (COMPONENTS_PATH . "/deleteModal.php"); ?>
    <div class="flex">
        <?php require (COMPONENTS_PATH . "/sidebar.php"); ?>
        <div class="system-content">
            <div class="content">
                <?php require (COMPONENTS_PATH . "/header.php"); ?>
                <?php require (COMPONENTS_PATH . "/pages.php"); ?>
            </div>
        </div>
    </div>
</body>
<script src="<?php echo SCRIPT_PATH; ?>/jquery.min.js"></script>
<script src="<?php echo SCRIPT_PATH; ?>/script.js"></script>
<script src="<?php echo SCRIPT_PATH; ?>/validation.js"></script>
<script src="<?php echo SCRIPT_PATH; ?>/datatables/datatables.min.js"></script>
<script src="<?php echo SCRIPT_PATH; ?>/tables.js"></script>
<script src="<?php echo SCRIPT_PATH; ?>/action.js"></script>

</html>
<head>
    <link href="./css/sidebar.css" rel="stylesheet" />
</head>
<?php
$sidebarItems = array(
    array("icon" => "employees.html", "text" => "Employees", "key" => "employees"),
    // array("icon" => "inventory.html", "text" => "Inventory", "key" => "inventory"),
    array("icon" => "clients.html", "text" => "Clients", "key" => "clients"),
    array("icon" => "products.html", "text" => "Products", "key" => "products"),
    // array("icon" => "batch.html", "text" => "Products Batch", "key" => "batch"),
    array("icon" => "sales.html", "text" => "Sales", "key" => "sales"),
    array("icon" => "profile.html", "text" => "Profile", "key" => "profile"),
    array("icon" => "settings.html", "text" => "Settings", "key" => "settings"),
    
);
?>
<div class="sidebar show" id="sidebar">
    <aside class="flex flex-column gap-30 w-full h-full">
        <div class="flex w-full items-center justify-between">
            <div>
                <img src="<?php echo IMAGES_PATH; ?>/logo.svg" alt="logo" width="100" />
            </div>
            <div class="relative">
                <button type="button" class="sidebar-toggle"><img src="<?php echo ICONS_PATH; ?>/open-hide-sidebar.svg"
                        width="20" /></button>
            </div>
        </div>
        <div class="flex flex-column gap-10">
            <?php for($i = 0; $i < count($sidebarItems); $i++): ?>
            <button type="button" class="sidebar-item" data-page="<?php echo $sidebarItems[$i]['key']; ?>">
                <div><?php require(ICONS_PATH . "/" .$sidebarItems[$i]['icon']) ?></div>
                <div><?php echo $sidebarItems[$i]['text']; ?></div>
            </button>
            <?php endfor; ?>
        </div>
    </aside>
</div>
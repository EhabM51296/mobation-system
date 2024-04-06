<head>
    <link href="./css/header.css" rel="stylesheet" />
</head>

<header class="flex w-full items-center justify-between">
    <div><h1 class="page-name">Dashboard</h1></div>
    <div class="flex gap-20 items-center">
        <div class="flex gap-10 items-center">
            <div><img src="<?php echo ICONS_PATH; ?>/user.svg" class="profile-image" alt="user-image"/></div>
            <div><h6 class="username"><?php echo $_SESSION['user']['name']; ?></h6></div>
        </div>
        <button><img src="<?php echo ICONS_PATH; ?>/logout.svg" width="25"/></button>
    </div>
</header>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="../node_modules/bootstrap/dist/css/bootstrap.css">
    <link rel="stylesheet" href="../fontawesome-free-5.13.0-web/css/all.css">
    <link rel="stylesheet" href="css/main.css">

    <script src="../node_modules/jquery/dist/jquery.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

    <link rel="icon" href="" type="x/ico">
    <title>Food Shop</title>

    <?php require_once ("../includes/include.php"); ?>
</head>
<body>

<header>
    <div class="leftNavSection d-lg-none d-flex bg-secondary">
        <?php if (isset($_SESSION["userInfo"])){ ?>
            <a href="../logout.php" class="px-3 py-2 mr-auto">خروج</a>
        <?php } ?>
    </div>

    <nav class="navbar navbar-expand-lg navbar-dark my-bg-dark">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarContent" aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <a class="navbar-brand ml-lg-4" href="<?php echo DOMAIN ; ?>"><img alt="logo" src="../images/bg_images/logo.png" class="img-fluid"/></a>

        <div class="collapse navbar-collapse" id="navbarContent">
            <ul class="navbar-nav ml-auto text-right">
                <li class="nav-item"><a class="nav-link" href="<?php echo DOMAIN."admin/" ; ?>">داشبورد</a></li>
                <li class="nav-item"><a class="nav-link" href="<?php echo DOMAIN ; ?>">صفحه اصلی سایت</a></li>
                <li class="nav-item"><a class="nav-link" href="./admin_users.php">کاربران</a></li>
                <li class="nav-item"><a class="nav-link" href="./admin_orders.php">سفارش ها</a></li>
                <li class="nav-item"><a class="nav-link" href="./admin_foods.php">غذاها</a></li>
                <li class="nav-item"><a class="nav-link" href="./admin_categories.php">دسته بندی ها</a></li>
            </ul>
        </div>

        <div class="d-none d-lg-inline-block mr-auto">
            <a class="nav-link logOutLink" href="../logout.php">خروج</a>
        </div>
    </nav>
</header>

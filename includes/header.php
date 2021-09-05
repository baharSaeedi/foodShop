<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="node_modules/bootstrap/dist/css/bootstrap.css">

    <link rel="stylesheet" href="fontawesome-free-5.13.0-web/css/all.css">
    <link rel="stylesheet" href="css/main.css">

    <script src="node_modules/jquery/dist/jquery.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

    <link rel="icon" href="" type="x/ico">
    <title>Food Shop</title>

    <?php require_once ("includes/include.php");
    if(isset($_SESSION["userInfo"]) && count($_SESSION["cart"])<=0)
    {
        $userFoods=Cart::getRecordsByUserId($_SESSION["userInfo"]["id"]);
    }
    ?>
</head>
<body>

<header>
    <div class="leftNavSection d-lg-none d-flex bg-secondary p-2">
        <div class="p-2">
            <?php if (isset($_SESSION["userInfo"])){ ?>
                <a href="./userPanel.php" class="mx-2">پنل کاربری</a>
            <?php }else{ ?>
                <a href="./login.php" class="mx-2">ورود</a>
            <?php } ?>
        </div>
        <div class="p-2">
            <?php if (isset($_SESSION["userInfo"])){ ?>
                <a href="./logout.php" class="mx-2">خروج</a>
            <?php }else{ ?>
                <a href="./signup.php" class="mx-2">ثبت نام</a>
            <?php } ?>
        </div>
        <div class="basket ml-3 p-2 mr-auto">
            <a href="./basket.php" class=""><i class="fa fa-shopping-cart"></i><span class="badge badge-danger orderCounts"><?php echo count($_SESSION["cart"]);?></span></a>
        </div>
    </div>

    <nav class="navbar navbar-expand-lg navbar-dark my-bg-dark">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarContent" aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <a class="navbar-brand ml-lg-4" href="<?php echo DOMAIN ; ?>"><img alt="logo" src="images/bg_images/logo.png" class="img-fluid"/></a>

        <div class="collapse navbar-collapse" id="navbarContent">
            <ul class="navbar-nav ml-auto text-right">
                <li class="nav-item active"><a class="nav-link" href="<?php echo DOMAIN ?>">صفحه اصلی</a></li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-right" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        دسته بندی
                    </a>
                    <div class="dropdown-menu text-right" aria-labelledby="navbarDropdown">
                        <?php if ($cats = Category::getAllCategories()){
                        foreach ($cats as $cat){
                            if ($cat->ord==0){?>
                            <a class="dropdown-item <?php if($cat->sub_cat==1) echo 'dropdown-toggle'; ?> "  href="./?cat=<?php echo $cat->id; ?>#products"><?php echo $cat->category_name; ?></a>
                                <?php if($cat->sub_cat==1) { ?>
                                    <ul class="dropdown  text-dark text-right" aria-labelledby="navbarDropdown<?php echo $cat->id; ?>">
                                        <?php foreach ($cats as $subCat) {
                                            if ($subCat->ord==$cat->id) { ?>
                                                <li class="dropdown-item  pr-4"><a class="text-dark " href="./?cat=<?php echo $subCat->id; ?>#products"><?php echo $subCat->category_name; ?></a></li>
                                            <?php }} ?>
                                    </ul>
                                <?php } ?>
                        <?php } } } ?>
                    </div>
                </li>
                <li class="nav-item"><a class="nav-link" href="./contactUs.php">تماس با ما</a></li>
            </ul>
        </div>

        <div class="d-none d-lg-inline-block">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <?php if (isset($_SESSION["userInfo"])){ ?>
                    <a class="nav-link" href="./userPanel.php">پنل کاربری</a>
                    <?php }else{ ?>
                    <a class="nav-link" href="./login.php">ورود</a>
                    <?php } ?>
                </li>
                <li class="nav-item">
                    <?php if (isset($_SESSION["userInfo"])){ ?>
                        <a class="nav-link" href="./logout.php">خروج</a>
                    <?php }else{ ?>
                        <a class="nav-link" href="./signup.php">ثبت نام</a>
                    <?php } ?>
                </li>
                <li class="nav-item basket mx-3 pt-1"><a href="./basket.php" class="nav-link"><i class="fa fa-shopping-cart"></i><span class="badge badge-danger orderCounts"><?php echo count($_SESSION["cart"]) ?></span></a>
                </li>
            </ul>
        </div>
    </nav>
</header>
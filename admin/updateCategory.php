<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="../node_modules/bootstrap/dist/css/bootstrap.css">
    <link rel="stylesheet" href="../fontawesome-free-5.13.0-web/css/all.css">
    <link rel="stylesheet" href="css/addCat_styles.css">

    <script src="../node_modules/jquery/dist/jquery.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

    <link rel="icon" href="" type="x/ico">
    <title>Food Shop</title>

    <?php require_once ("../includes/include.php"); ?>
    <?php
    $msg = "";
    $msgErr = false;
    $msgSuccess = false;
    $arrayMessage = array();

    if(isset($_POST["validation"]) and !empty($_POST["validation"])){
        $_POST["catName"] = trim($_POST["catName"]);
        $_POST["order"] = trim($_POST["order"]);


        if(!empty($_POST["catName"]) and ($_POST["order"] != "") and strlen($_POST["catName"]) <= 100 and is_numeric($_POST["order"])) {

            if (isset($_GET["id"]) and !empty($_GET["id"]) and is_numeric($_GET["id"])){
                $queryUpdate = Category::updateCategory($_GET["id"],$_POST["catName"],$_POST["order"]);

                if ($queryUpdate) {
                    $msgSuccess = true;
                    $msg = "دسته بندی موردنظر آپدیت شد.";
                }
                else{
                    $msgErr = true;
                    $msg = "عملیات با خطا مواجه شده است.";
                }
            }
            else {
                $msgErr = true;
                $msg = "عملیات با خطا مواجه شده است.";
            }
        }

        else{
            if(empty($_POST["catName"])){
                $arrayMessage[] = "لطفا نام دسته بندی را وارد نمایید.";
            }
            if(($_POST["order"] == "")){
                $arrayMessage[] = "لطفا مرتبه را وارد نمایید.";
            }
            if(!empty($_POST["catName"]) && strlen($_POST["catName"]) > 100){
                $arrayMessage[] = "نام دسته بندی نباید از 100 کاراکتر بیشتر باشد.";
            }
            if(($_POST["order"] != "") && !is_numeric($_POST["order"])){
                $arrayMessage[] = "مرتبه باید عددی باشد.";
            }
        }
    }

    ?>
</head>
<body>

<div class="col-lg-8 mx-auto">
    <div class="card">
        <div class="card-header my-bg-dark">
            <div class="text-center"><img alt="logo" class="img-fluid" src="../images/bg_images/logo.png"></div>
        </div>

        <div class="card-body">
            <form action="" method="post" novalidate id="addCatForm">
                <fieldset>
                    <legend>آپدیت دسته بندی</legend>
                    <hr>

                    <?php if(count($arrayMessage)): ?>
                        <?php foreach ($arrayMessage as $error)  : ?>
                            <div class="alert alert-warning">
                                <span class="close float-left" data-dismiss="alert">&times;</span>
                                <p class="text-right"><?php echo $error; ?></p>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                    <?php  if($msgErr) : ?>
                        <script>
                            swal({title:"خطا",text:'<?php echo $msg ?>',icon:"error" , button:"بستن",timer:4000})
                        </script>
                    <?php endif; ?>

                    <?php  if($msgSuccess) : ?>
                        <script>
                            swal({title:"عملیات موفق",text:'<?php echo $msg ?>',icon:"success" , button:"بستن",timer:4000}).then(function (){ window.location = "<?php echo DOMAIN . "admin/admin_categories.php"; ?>" });
                        </script>
                    <?php endif; ?>

                    <?php $category = Category::getCategoryById($_GET["id"]); ?>
                    <div class="form-group">
                        <label for="catName">نام</label>
                        <input type="text" class="form-control" id="catName" name="catName" value="<?php if (isset($_GET["id"]) and !empty($_GET["id"]) and is_numeric($_GET["id"])) echo $category->category_name; ?>">
                    </div>
                    <div class="form-group">
                        <label for="order">مرتبه</label>
                        <input type="text" class="form-control" id="order" name="order" value="<?php if (isset($_GET["id"]) and !empty($_GET["id"]) and is_numeric($_GET["id"])) echo $category->ord; ?>">
                    </div>

                    <div class="form-group">
                        <input name="addCat-btn" type="submit" class="btn btn-dark" value="ثبت"/>
                        <a href="./admin_categories.php" class="btn btn-secondary">لغو</a>
                    </div>

                    <input type="hidden" class="validation" name="validation" value="">

                </fieldset>
            </form>
        </div>
    </div>

</div>


<script src="../node_modules/bootstrap/dist/js/bootstrap.js"></script>
<script src="js/validation_addCat.js"></script>
</body>
</html>


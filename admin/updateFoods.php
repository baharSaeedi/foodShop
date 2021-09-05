<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="../node_modules/bootstrap/dist/css/bootstrap.css">
    <link rel="stylesheet" href="../fontawesome-free-5.13.0-web/css/all.css">
    <link rel="stylesheet" href="css/addImage_styles.css">

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
        $_POST["title"] = trim($_POST["title"]);
        $_POST["price"] = trim($_POST["price"]);
        $_POST["category"] = trim($_POST["category"]);

        if(!empty($_POST["title"]) and !empty($_POST["price"]) and strlen($_POST["title"]) <= 100 and is_numeric($_POST["price"]) and !empty($_POST["category"])) {

            if (isset($_GET["id"]) and !empty($_GET["id"]) and is_numeric($_GET["id"])){
                $queryUpdate = Foods::updateFood($_GET["id"],$_POST["title"],$_POST["price"],$_POST["category"]);

                if ($queryUpdate) {
                    $msgSuccess = true;
                    $msg = "غذای موردنظر آپدیت شد.";
                }
                else{
                    $msgErr = true;
                    $msg = "عملیات با خطا مواجه شده است.";
                }
            }
            else{
                $msgErr = true;
                $msg = "عملیات با خطا مواجه شده است.";
            }
        }

        else{
            if(empty($_POST["title"])){
                $arrayMessage[] = "لطفا عنوان عکس را وارد نمایید.";
            }
            if(empty($_POST["price"])){
                $arrayMessage[] = "لطفا قیمت را وارد نمایید.";
            }
            if(empty($_POST["category"])){
                $arrayMessage[] = "لطفا دسته بندی را وارد نمایید.";
            }
            if(!empty($_POST["title"]) && strlen($_POST["title"]) > 100){
                $arrayMessage[] = "عنوان نباید از 100 کاراکتر بیشتر باشد.";
            }
            if(!empty($_POST["price"]) && !is_numeric($_POST["price"])){
                $arrayMessage[] = "لطفا قیمت را به صورت صحیح وارد نمایید.";
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
            <form action="" method="post" novalidate id="updateImageForm">
                <fieldset>
                    <legend>آپدیت غذا</legend>
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
                            swal({title:"عملیات موفق",text:'<?php echo $msg ?>',icon:"success" , button:"بستن",timer:4000}).then(function (){ window.location = "<?php echo DOMAIN . "admin/admin_foods.php"; ?>" });
                        </script>
                    <?php endif; ?>

                    <?php $food = Foods::getFoodById($_GET["id"]); ?>
                    <div class="form-group">
                        <label for="title">عنوان غذا</label>
                        <input type="text" class="form-control" id="title" name="title" value="<?php if (isset($_GET["id"]) and !empty($_GET["id"]) and is_numeric($_GET["id"])) echo $food->title; ?>">
                    </div>
                    <div class="form-group">
                        <label for="price">قیمت (تومان)</label>
                        <input type="text" class="form-control" id="price" name="price" value="<?php if (isset($_GET["id"]) and !empty($_GET["id"]) and is_numeric($_GET["id"])) echo $food->price; ?>">
                    </div>
                    <div class="form-group">
                        <label for="categry" class="">دسته بندی</label>
                        <select name="category" id="category" class="form-control">
                            <option disabled>دسته بندی موردنظر را انتخاب کنید.</option>
                            <?php
                            if ($cats = Category::getAllCategories()){
                                foreach ($cats as $cat){ ?>
                                    <option value="<?php echo $cat->id; ?>" class=""><?php echo $cat->category_name; ?></option>
                                <?php  } } ?>
                        </select>
                    </div>

                    <script>
                        $("select[name='category']  option").each(function (indexOption,elementOption) {
                            if($(elementOption).attr("value") === <?php echo $food->cat_id;  ?>){
                                $(elementOption).attr("selected","selected");
                            }
                        });
                    </script>

                    <div class="form-group">
                        <input name="addImage-btn" type="submit" class="btn btn-dark" value="ثبت"/>
                        <a href="admin_foods.php" class="btn btn-secondary">لغو</a>
                    </div>

                    <input type="hidden" class="validation" name="validation" value="">

                </fieldset>
            </form>
        </div>
    </div>

</div>


<script src="../node_modules/bootstrap/dist/js/bootstrap.js"></script>
<script src="js/validation_updateImage.js"></script>
</body>
</html>



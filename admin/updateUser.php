<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="../node_modules/bootstrap/dist/css/bootstrap.css">
    <link rel="stylesheet" href="../fontawesome-free-5.13.0-web/css/all.css">
    <link rel="stylesheet" href="css/addUser_styles.css">

    <script src="../node_modules/jquery/dist/jquery.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

    <link rel="icon" href="" type="x/ico">
    <title>Food Shop</title>

    <?php require_once ("../includes/include.php"); ?>
    <?php
    $queryUpdate = null ;
    $msgErr = false;
    $msgSuccess = false;
    $arrayMessage = array();

    if(isset($_POST["validation"]) and !empty($_POST["validation"])){
        $_POST["first_name"] = trim($_POST["first_name"]);
        $_POST["last_name"] = trim($_POST["last_name"]);
        $_POST["mobile"] = trim($_POST["mobile"]);
        $_POST["status"] = trim($_POST["status"]);


        if(!empty($_POST["first_name"]) and !empty($_POST["last_name"]) and ($_POST["status"] != "") and !empty($_POST["mobile"]) and strlen($_POST["first_name"]) <= 100 and strlen($_POST["last_name"]) <= 100 and strlen($_POST["mobile"]) == 11 and substr($_POST["mobile"],0,2) == "09" and is_numeric($_POST["mobile"])) {

            if (isset($_GET["id"]) and !empty($_GET["id"]) and is_numeric($_GET["id"])){

                $queryUpdate = User::updateUser($_GET["id"],$_POST["first_name"],$_POST["last_name"],$_POST["status"],$_POST["mobile"]);

                if ($queryUpdate) {
                    $msgSuccess = true;
                    $msg = "کاربر موردنظر آپدیت شد.";
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
            if(empty($_POST["first_name"])){
                $arrayMessage[] = "لطفا نام را وارد نمایید.";
            }
            if(empty($_POST["last_name"])){
                $arrayMessage[] = "لطفا نام خانوادگی را وارد نمایید.";
            }
            if(empty($_POST["mobile"])){
                $arrayMessage[] = "لطفا تلفن همراه را وارد نمایید.";
            }
            if($_POST["status"] != ""){
                $arrayMessage[] = "لطفا وضعیت را وارد نمایید.";
            }
            if(!empty($_POST["first_name"]) && strlen($_POST["first_name"]) > 100){
                $arrayMessage[] = "نام نباید از 100 کاراکتر بیشتر باشد.";
            }
            if(!empty($_POST["last_name"]) && strlen($_POST["last_name"]) > 100){
                $arrayMessage[] = "نام خانوادگی نباید از 100 کاراکتر بیشتر باشد.";
            }
            if(!empty($_POST["mobile"]) && (strlen($_POST["mobile"]) != 11 || substr($_POST["mobile"],0,2) != "09" || !is_numeric($_POST["mobile"]))){
                $arrayMessage[] = "فرمت شماره همراه صحیح نمی باشد.";
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
            <form action="" method="post" novalidate id="updateUserForm">
                <fieldset>
                    <legend>آپدیت کاربر</legend>
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
                            swal({title:"عملیات موفق",text:'<?php echo $msg ?>',icon:"success" , button:"بستن",timer:4000}).then(function (){ window.location = "<?php echo DOMAIN . "admin/admin_users.php"; ?>" });
                        </script>
                    <?php endif; ?>

                    <?php $user = User::getUserById($_GET["id"]); ?>
                    <div class="form-group">
                        <label for="first_name">نام</label>
                        <input type="text" class="form-control" id="first_name" name="first_name" value="<?php if (isset($_GET["id"]) and !empty($_GET["id"]) and is_numeric($_GET["id"])) echo $user->first_name; ?>">
                    </div>
                    <div class="form-group">
                        <label for="last_name">نام خانوادگی</label>
                        <input type="text" class="form-control" id="last_name" name="last_name" value="<?php if (isset($_GET["id"]) and !empty($_GET["id"]) and is_numeric($_GET["id"])) echo $user->last_name; ?>">
                    </div>
                    <div class="form-group">
                        <label for="mobile">شماره همراه</label>
                        <input type="tel" class="form-control" id="mobile" name="mobile" value="<?php if (isset($_GET["id"]) and !empty($_GET["id"]) and is_numeric($_GET["id"])) echo $user->mobile; ?>">
                    </div>

                    <div class="form-group">
                        <label for="status" class="">وضعیت</label>
                        <select name="status" id="status" class="form-control">
                            <option disabled>وضعیت موردنظر را انتخاب کنید.</option>
                            <option value="0" class="">غیرفعال</option>
                            <option value="1" class="">فعال</option>
                        </select>
                    </div>

                    <script>
                        $("select[name='status']  option").each(function (indexOption,elementOption) {
                            if($(elementOption).attr("value") === <?php echo $user->status;  ?>){
                                $(elementOption).attr("selected","selected");
                            }
                        });
                    </script>

                    <div class="form-group">
                        <input name="updateUser-btn" type="submit" class="btn btn-dark" value="ثبت"/>
                        <a href="./admin_users.php" class="btn btn-secondary">لغو</a>
                    </div>

                    <input type="hidden" class="validation" name="validation" value="">

                </fieldset>
            </form>
        </div>
    </div>

</div>


<script src="../node_modules/bootstrap/dist/js/bootstrap.js"></script>
<script src="js/validation_updateUser.js"></script>
</body>
</html>



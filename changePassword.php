<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="node_modules/bootstrap/dist/css/bootstrap.css">
    <link rel="stylesheet" href="fontawesome-free-5.13.0-web/css/all.css">
    <link rel="stylesheet" href="css/changePass_styles.css">

    <script src="node_modules/jquery/dist/jquery.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

    <link rel="icon" href="" type="x/ico">
    <title>Food Shop</title>

    <?php require_once "includes/include.php"; ?>
    <?php
    $msg = "";
    $msgErr = false;
    $msgSuccess = false;
    $arrayMessage = array();
    $updatePassword = null;
    $userId = null;

    if(isset($_POST["validation"]) and !empty($_POST["validation"])){
        if(isset($_GET["resetPassKey"]) and !empty($_GET["resetPassKey"])){
            $isSameResetPassKey = User::isSameResetPassKey($_GET["resetPassKey"]);

            if($isSameResetPassKey){
                $_POST["password"] = trim($_POST["password"]);
                $_POST["repeatPassword"] = trim($_POST["repeatPassword"]);

                if (!empty($_POST["password"]) and !empty($_POST["repeatPassword"]) and strlen($_POST["password"]) >= 6 and strlen($_POST["repeatPassword"]) >= 6 and $_POST["password"] == $_POST["repeatPassword"]) {

                    $updatePassword = User::updatePassword($_POST["password"],$_GET["resetPassKey"]);
                    if ($updatePassword){
                        $userId = User::getUserId($_GET["resetPassKey"]);
                        User::insertPassResetReq($userId,$_POST["password"]);
                        User::clearResetPassKey($_GET["resetPassKey"]);

                        $msgSuccess = true;
                        $msg = "رمز عبور شما با موفقیت تغییر یافت.";

                    }
                    else{
                        $msgErr = true;
                        $msg = "عملیات تغییر رمزعبور با خطا مواجه شده است.";
                    }

                }
                else{
                    if(empty($_POST["password"])){
                        $arrayMessage[] = "لطفا رمز عبور را وارد نمایید.";
                    }
                    if(empty($_POST["repeatPassword"])){
                        $arrayMessage[] = "لطفا تکرار رمز عبور را وارد نمایید.";
                    }
                    if(!empty($_POST["password"]) && strlen($_POST["password"]) < 6){
                        $arrayMessage[] = "رمز عبور نباید کمتر از 6 کاراکتر باشد.";
                    }
                    if(!empty($_POST["repeatPassword"]) && strlen($_POST["repeatPassword"]) < 6){
                        $arrayMessage[] = "تکرار رمز عبور نباید کمتر از 6 کاراکتر باشد.";
                    }
                    if($_POST["password"] != $_POST["repeatPassword"]){
                        $arrayMessage[] = "رمز عبور و تکرار رمز عبور یکسان نمی باشد.";
                    }
                }
            }
            else{
                $msgErr = true;
                $msg = "عملیات تغییر رمزعبور با خطا مواجه شده است.";
            }
        }
        else{
            $msgErr = true;
            $msg = "عملیات تغییر رمزعبور با خطا مواجه شده است.";
        }
    }

    ?>
</head>
<body>

<div class="col-lg-8 mx-auto">
    <div class="card">
        <div class="card-header my-bg-dark">
            <div class="text-center"><img alt="logo" class="img-fluid" src="images/bg_images/logo.png"></div>
        </div>

        <div class="card-body">
            <form action="" method="post" novalidate id="changePassForm">
                <fieldset>
                    <legend>بازیابی رمز عبور</legend>
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
                            swal({title:"عملیات موفق",text:'<?php echo $msg ?>',icon:"success" , button:"بستن",timer:4000}).then(function (){ window.location = "<?php echo DOMAIN; ?>" });
                        </script>
                    <?php endif; ?>

                    <div class="form-group">
                        <label for="newPass">رمزعبور جدید</label>
                        <input type="password" class="form-control" id="newPass" name="password">
                    </div>
                    <div class="form-group">
                        <label for="repeatNewPass">تکرار رمزعبور جدید</label>
                        <input type="password" class="form-control" id="repeatNewPass" name="repeatPassword">
                    </div>

                    <div class="form-group">
                        <input name="changePass-btn" type="submit" class="btn btn-dark" value="تغییر رمزعبور"/>
                        <a href="<?php echo DOMAIN; ?>" class="btn btn-secondary">لغو</a>
                    </div>

                    <input type="hidden" class="validation" name="validation" value="">

                </fieldset>
            </form>
        </div>
    </div>

</div>


<script src="node_modules/bootstrap/dist/js/bootstrap.js"></script>
<script src="js/validation_changePass.js"></script>
</body>
</html>
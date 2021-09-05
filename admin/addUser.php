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
    $queryInsert = null ;
    $queryExist = null ;
    $msgErr = false;
    $msgSuccess = false;
    $arrayMessage = array();
    $isActivationExist = null;

    if(isset($_GET["activationKey"]) and !empty($_GET["activationKey"])){
        $isActivationExist = User::isSameActivationKey($_GET["activationKey"]);
        if($isActivationExist){
            User::activateUser($_GET["activationKey"]);
            User::loginUserAfterSignUp($_GET["activationKey"]);
            User::clearActivationKey();

            $msgSuccess = true;
            $msg = "حساب کاربری شما با موفقیت فعال شد.";
        }
        else{
            $msgErr = true;
            $msg = "عملیات فعال سازی حساب کاربری شما با خطا مواجه شده است.";
        }
    }

    if(isset($_POST["validation"]) and !empty($_POST["validation"])){
        $_POST["first_name"] = trim($_POST["first_name"]);
        $_POST["last_name"] = trim($_POST["last_name"]);
        $_POST["email"] = trim($_POST["email"]);
        $_POST["mobile"] = trim($_POST["mobile"]);
        $_POST["password"] = trim($_POST["password"]);
        $_POST["repeatPassword"] = trim($_POST["repeatPassword"]);



        if(!empty($_POST["first_name"]) and !empty($_POST["last_name"]) and !empty($_POST["email"]) and !empty($_POST["mobile"]) and !empty($_POST["password"]) and !empty($_POST["repeatPassword"])  and strlen($_POST["first_name"]) <= 100 and strlen($_POST["last_name"]) <= 100 and filter_var($_POST["email"], FILTER_VALIDATE_EMAIL) and strlen($_POST["password"]) >= 6 and strlen($_POST["repeatPassword"]) >= 6 and $_POST["password"] == $_POST["repeatPassword"] and strlen($_POST["mobile"]) == 11 and substr($_POST["mobile"],0,2) == "09" and is_numeric($_POST["mobile"])) {

            $queryExist = User::isUserExist($_POST["email"]);
            if ($queryExist) {
                $msgErr = true;
                $msg = "کاربری با این آدرس ایمیل قبلا ثبت نام کرده است.";
            } else {
                $currentTime =  microtime(true);
                $token = md5($_POST["email"] . $currentTime);
                $activationKey = $token ;

                $queryInsert = User::InsertUser($_POST["first_name"],$_POST["last_name"],$_POST["email"],$_POST["password"],$_POST["mobile"],$activationKey);

                if ($queryInsert) {
                    $msgSuccess = true;
                    $msg = "ایمیل فعال سازی حساب کاربری برای کاربر ارسال خواهد شد.";

                    $mail_subject = "لینک فعال سازی حساب کاربری";
                    $mail_body = '
                         <section style="width: 40%;padding: 50px;margin: auto;background-color:#fccafa ;box-shadow: 1px 1.5px 8px #b7b7b7;border-radius: 4px;direction: rtl;font-family: Tahoma;">
       <h1 style="color: #5e006e;text-align: center;padding: 0;margin: 0;padding-bottom: 25px;font-weight: 200;">لینک فعال سازی حساب کاربری</h1>
       <hr color="silver" size="0.5" style="width: 70%">   
          <center><a href="' .DOMAIN.'admin/addUser.php?activationKey='.$activationKey. '" style="display: inline-block;padding: 18px 20px;text-decoration: none;border: 1px solid;text-align: center;border-radius: 5px;color: #f3b5fa;background-color: #a95cb8;font-size: 18px;border-right:2px solid #32033b;border-bottom: 5px solid #32033b;margin-top: 30px">فعال سازی حساب کاربری</a></center>
   <p style="text-align: center;color: #640202;margin: 25px 0;"><small>درصورت ارسال اشتباه ایمیل آن را نادیده بگیرید</small></p></section>';
                    User::sendMail($_POST["email"],$mail_subject,$mail_body);
                }
                else{
                    $msgErr = true;
                    $msg = "عملیات با خطا مواجه شده است.";
                }
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
            if(empty($_POST["email"])){
                $arrayMessage[] = "لطفا ایمیل را وارد نمایید.";
            }
            if(empty($_POST["password"])){
                $arrayMessage[] = "لطفا رمز عبور را وارد نمایید.";
            }
            if(empty($_POST["repeatPassword"])){
                $arrayMessage[] = "لطفا تکرار رمز عبور را وارد نمایید.";
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
            if (!empty($_POST["email"]) && !filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
                $arrayMessage[] = "فرمت ایمیل صحیح نمی باشد.";
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

    ?>
</head>
<body>

<div class="col-lg-8 mx-auto">
    <div class="card">
        <div class="card-header bg-dark">
            <div class="text-center"><img alt="logo" class="img-fluid" src="../images/bg_images/logo.png"></div>
        </div>

        <div class="card-body">
            <form action="" method="post" novalidate id="addUserForm">
                <fieldset>
                    <legend>افزودن کاربر</legend>
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

                    <div class="form-group">
                        <label for="first_name">نام</label>
                        <input type="text" class="form-control" id="first_name" name="first_name" value="">
                    </div>
                    <div class="form-group">
                        <label for="last_name">نام خانوادگی</label>
                        <input type="text" class="form-control" id="last_name" name="last_name" value="">
                    </div>
                    <div class="form-group">
                        <label for="mobile">شماره همراه</label>
                        <input type="tel" class="form-control" id="mobile" name="mobile" value="">
                    </div>
                    <div class="form-group">
                        <label for="email">ایمیل</label>
                        <input type="email" class="form-control" id="email" name="email" value="">
                    </div>
                    <div class="form-group">
                        <label for="password">رمز عبور</label>
                        <input type="password" class="form-control" id="password" name="password">
                    </div>
                    <div class="form-group">
                        <label for="repeatPassword">تکرار رمز عبور</label>
                        <input type="password" class="form-control" id="repeatPassword" name="repeatPassword">
                    </div>

                    <div class="form-group">
                        <input name="addUser-btn" type="submit" class="btn btn-dark" value="ثبت"/>
                        <a href="./admin_users.php" class="btn btn-secondary">لغو</a>
                    </div>

                    <input type="hidden" class="validation" name="validation" value="">

                </fieldset>
            </form>
        </div>
    </div>

</div>


<script src="../node_modules/bootstrap/dist/js/bootstrap.js"></script>
<script src="js/validation_addUser.js"></script>
</body>
</html>


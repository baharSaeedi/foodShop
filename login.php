<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="node_modules/bootstrap/dist/css/bootstrap.css">
    <link rel="stylesheet" href="fontawesome-free-5.13.0-web/css/all.css">
    <link rel="stylesheet" href="css/login_styles.css">

    <script src="node_modules/jquery/dist/jquery.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

    <link rel="icon" href="" type="x/ico">
    <title>Food Shop</title>

    <?php require_once "includes/include.php"; ?>
    <?php
    $msgErr = false;
    $msgSuccess = false;
    $msg = "";
    $arrayMessage = array();
    $doLogin = null;

    if(isset($_POST["validation"]) and !empty($_POST["validation"])){
        $_POST["email"] = trim($_POST["email"]);
        $_POST["password"] = trim($_POST["password"]);

        if (!empty($_POST["email"]) and !empty($_POST["password"]) and filter_var($_POST["email"], FILTER_VALIDATE_EMAIL) and strlen($_POST["password"]) >= 6){

            $secretKey = "6LdWWaEaAAAAAMHQv9IC7GnTeWogz86U2ZvqJ3Lk";
            $responseKey = $_POST["g-recaptcha-response"];
            $userIp = $_SERVER["REMOTE_ADDR"];

            $url = "https://www.google.com/recaptcha/api/siteverify?secret=$secretKey&response=$responseKey&remoteip=$userIp";
            $response = file_get_contents($url);
            $response = json_decode($response);

            if(!$response->success){
                $msgErr = true;
                $msg = "اعتبارسنجی captcha ناموفق بود.";
            }
            else{
                $doLogin = User::doLogin($_POST["email"],$_POST["password"]);
                if ($doLogin){
                    if (isset($_POST["rememberMe"]) and !empty($_POST["rememberMe"])) {
                        setcookie ("email",$_POST["email"],time()+ REMEMBER_TIME_COOKIE);
                        setcookie ("password",$_POST["password"],time()+ REMEMBER_TIME_COOKIE);
                    }
                    else{
                        setcookie ("email","", time() - 3600);
                        setcookie ("password","", time() - 3600);
                        unset($_COOKIE["email"]);
                        unset($_COOKIE["password"]);
                    }

                    $msgSuccess = true;
                    $msg = "با موفقیت وارد شدید.";

                }else{
                    $msgErr = true;
                    $msg = "ایمیل و رمز عبور معتبر نمی باشد.";
                }
            }

        }else{
            if(empty($_POST["email"])){
                $arrayMessage[] = "لطفا ایمیل را وارد نمایید.";
            }
            if(empty($_POST["password"])){
                $arrayMessage[] = "لطفا رمز عبور را وارد نمایید.";
            }
            if (!empty($_POST["email"]) && !filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
                $arrayMessage[] = "فرمت ایمیل صحیح نمی باشد.";
            }
            if(!empty($_POST["password"]) && strlen($_POST["password"]) < 6){
                $arrayMessage[] = "رمز عبور نباید کمتر از 6 کاراکتر باشد.";
            }
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
            <form action="" method="post" novalidate id="loginForm">
                <fieldset>
                    <legend>ورود به سایت</legend>
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
                            swal({title:"خطا",text:'<?php echo $msg ?>',icon:"error" , button:"بستن",timer:4000});
                        </script>
                    <?php endif; ?>

                    <?php  if($msgSuccess) : ?>
                        <script>
                            swal({title:"عملیات موفق",text:'<?php echo $msg ?>',icon:"success" , button:"بستن",timer:4000}).then(function (){
                                <?php if (isset($_SESSION["userInfo"])){
                                    if($_SESSION["userInfo"]["role"] == 2){ ?>
                                window.location = "<?php echo DOMAIN; ?>"
                            <?php }
                                    elseif ($_SESSION["userInfo"]["role"] == 1){ ?>
                                window.location = "<?php echo DOMAIN . "admin/"; ?>"
                                <?php } } else { ?>
                                    window.location = "<?php echo DOMAIN; ?>"
                                <?php } ?>
                            });
                        </script>
                    <?php endif; ?>

                    <div class="form-group">
                        <label for="email">ایمیل</label>
                        <input type="email" class="form-control" name="email" id="email" value="<?php if(isset($_COOKIE["email"])) { echo $_COOKIE["email"]; } ?>">
                    </div>
                    <div class="form-group">
                        <label for="password">رمز عبور</label>
                        <input type="password" class="form-control" name="password" id="password" value="<?php if(isset($_COOKIE["password"])) { echo $_COOKIE["password"]; } ?>">
                    </div>

                    <div class="form-group form-check">
                        <input type="checkbox" class="form-check-input" id="check" name="rememberMe" <?php if(isset($_COOKIE["password"]) and isset($_COOKIE["email"])): ?> checked="checked" <?php endif; ?>>
                        <label class="form-check-label mr-4" for="check">مرا به خاطر بسپار</label>
                    </div>

                    <div class="form-group">
                        <div class="g-recaptcha" data-sitekey="6LdWWaEaAAAAAIpXG37I7ZqUd85YnpBPRrndFkP3"></div>
                    </div>

                    <div class="form-group">
                        <input name="login-btn" type="submit" class="btn btn-dark my-btn" value="ورود"  />
                        <a href="<?php echo DOMAIN; ?>" class="btn btn-secondary">لغو</a>
                    </div>

                    <div class="d-flex justify-content-between">
                        <p>عضویت ندارید؟<a href="./signup.php"> ثبت نام نمایید </a></p>
                        <a href="./resetPassword.php">رمز عبور خود را فراموش کرده اید؟</a>
                    </div>

                </fieldset>

                <input type="hidden" class="validation" name="validation" value="">

            </form>
        </div>
    </div>

</div>


<script src="https://www.google.com/recaptcha/api.js?hl=fa"></script>
<script src="node_modules/bootstrap/dist/js/bootstrap.js"></script>
<script src="js/validation_login.js"></script>
</body>
</html>
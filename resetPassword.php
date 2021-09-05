<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="node_modules/bootstrap/dist/css/bootstrap.css">
    <link rel="stylesheet" href="fontawesome-free-5.13.0-web/css/all.css">
    <link rel="stylesheet" href="css/resetPass_styles.css">

    <script src="node_modules/jquery/dist/jquery.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

    <link rel="icon" href="" type="x/ico">
    <title>Food Shop</title>

    <?php require_once "includes/include.php"; ?>
    <?php
    $msg = "";
    $msgErr = false ;
    $msgSuccess = false;
    $arrayMessage = array();
    $isUserExist = null ;
    $updateResetPassKey = null;
    $isSameResetPassKey = null;

    if(isset($_POST["validation"]) and !empty($_POST["validation"])){
        $_POST["email"] = trim($_POST["email"]);

        if (!empty($_POST["email"]) and filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
            $isUserExist = User::isUserExist($_POST["email"]);
            if ($isUserExist) {
                $currentTime =  microtime(true);
                $token = md5($_POST["email"] . $currentTime);
                $resetPassKey = $token ;

                $updateResetPassKey = User::updateResetPassKey($resetPassKey,$_POST["email"]);

                if ($updateResetPassKey){
                    $msgSuccess = true;
                    $msg = "ایمیل بازیابی برای شما ارسال خواهد شد.";

                    $mail_subject = "لینک بازیابی رمز عبور";
                    $mail_body = '
                         <section style="width: 40%;padding: 50px;margin: auto;background-color:#fccafa ;box-shadow: 1px 1.5px 8px #b7b7b7;direction: rtl;font-family: Tahoma;border-radius: 2.5px;">
       <h1 style="color: #5e006e;text-align: center;padding: 0;margin: 0;padding-bottom: 25px;font-weight: 200;">لینک بازیابی رمز عبور</h1>
       <hr color="silver" size="0.5" style="width: 70%">   
          <center><a href="' .DOMAIN.'changePassword.php?resetPassKey='.$resetPassKey.'" style="display: inline-block;padding: 18px 20px;text-decoration: none;border: 1px solid;text-align: center;border-radius: 5px;color: #f3b5fa;background-color: #a95cb8;font-size: 18px;border-right:2px solid #32033b;border-bottom: 5px solid #32033b;margin-top: 30px">بازیابی رمز عبور</a></center>
   <p style="text-align: center;color: #640202;margin: 25px 0;"><small>درصورت ارسال اشتباه ایمیل آن را نادیده بگیرید</small></p></section>';

                    User::sendMail($_POST["email"],$mail_subject,$mail_body);
                }
                else{
                    $msgErr = true;
                    $msg = "عملیات با خطا مواجه شده است.";
                }

            }
            else{
                $msgErr = true;
                $msg = "ایمیل معتبر نمی باشد.";
            }
        }
        else{
            if(empty($_POST["email"])){
                $arrayMessage[] = "لطفا ایمیل را وارد نمایید.";
            }
            if (!empty($_POST["email"]) && !filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
                $arrayMessage[] = "فرمت ایمیل صحیح نمی باشد.";
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
            <form action="" method="post" novalidate id="resetPassForm">
                <fieldset>
                    <legend>درخواست بازیابی رمز عبور</legend>
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
                            swal({title:"عملیات موفق",text:'<?php echo $msg ?>',icon:"success" , button:"بستن",timer:4000}).then(function (){ window.location = "<?php echo DOMAIN; ?>" });
                        </script>
                    <?php endif; ?>

                    <div class="form-group">
                        <label for="email">ایمیل</label>
                        <input type="email" class="form-control" id="email" name="email">
                    </div>

                    <div class="form-group">
                        <input name="resetPass-btn" type="submit" class="btn btn-dark" value="ادامه" />
                        <a href="<?php echo DOMAIN; ?>" class="btn btn-secondary">لغو</a>
                    </div>

                </fieldset>

                <input type="hidden" class="validation" name="validation" value="">

            </form>
        </div>
    </div>

</div>


<script src="https://www.google.com/recaptcha/api.js?hl=fa"></script>
<script src="node_modules/bootstrap/dist/js/bootstrap.js"></script>
<script src="js/validation_resetPass.js"></script>
</body>
</html>
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

        if(!empty($_POST["title"]) and !empty($_POST["price"]) and strlen($_POST["title"]) <= 100 and is_numeric($_POST["price"]) and !empty($_POST["category"]) and isset($_FILES["imageFile"]) and !empty($_FILES["imageFile"])) {

            $path_to_image_directory = "images/product_images/";
            $image_name =  $_FILES["imageFile"]["name"];

            $uploadDir_main = substr(__DIR__,0,strpos(__DIR__,"admin")) . $path_to_image_directory ;

            $uploadFilePath_main = $uploadDir_main . $image_name ;


            $path_main = $path_to_image_directory . $image_name ;


            if(file_exists($uploadFilePath_main)){
                $name = rand(11,99) . "_" . $image_name ;
                $uploadFilePath_main = $uploadDir_main . $name;


                $path_main = $path_to_image_directory . $image_name ;

            }
            $allowedFileType = array("image/jpeg", "image/png", "image/jpg");
            if (in_array($_FILES["imageFile"]["type"], $allowedFileType)) {
                if (move_uploaded_file($_FILES["imageFile"]["tmp_name"], $uploadFilePath_main)) {


                            $subCat=Category::getCategoryParentById($_POST["category"]);
                            $queryInsert = Foods::InsertFood($_POST["title"],$_POST["price"],$_POST["category"],$path_main,$subCat);

                            if ($queryInsert) {
                                $msgSuccess = true;
                                $msg = "?????????? ?????????????? ???????????? ????.";
                            }
                            else{
                                $msgErr = true;
                                $msg = "???????????? ???? ?????? ?????????? ?????? ??????.";
                            }



                }
                else {
                    $msgErr = true;
                    $msg = "???????????? ???? ?????? ?????????? ?????? ??????.";
                }
            }
            else {
                $arrayMessage[] = "???????? ???????? ?????????????? ???????? ?????? ????????.";
            }
        }

        else{
            if(empty($_POST["title"])){
                $arrayMessage[] = "???????? ?????????? ?????? ???? ???????? ????????????.";
            }
            if(empty($_POST["price"])){
                $arrayMessage[] = "???????? ???????? ???? ???????? ????????????.";
            }
            if(empty($_POST["category"])){
                $arrayMessage[] = "???????? ???????? ???????? ???? ???????? ????????????.";
            }
            if(empty($_FILES["imageFile"])){
                $arrayMessage[] = "???????? ???????? ?????????? ???? ???????? ????????????.";
            }
            if(!empty($_POST["title"]) && strlen($_POST["title"]) > 100){
                $arrayMessage[] = "?????????? ?????????? ???? 100 ?????????????? ?????????? ????????.";
            }
            if(!empty($_POST["price"]) && !is_numeric($_POST["price"])){
                $arrayMessage[] = "???????? ???????? ???? ???? ???????? ???????? ???????? ????????????.";
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
            <form action="" method="post" novalidate id="addImageForm" enctype="multipart/form-data">
                <fieldset>
                    <legend>???????????? ??????</legend>
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
                            swal({title:"??????",text:'<?php echo $msg ?>',icon:"error" , button:"????????",timer:4000})
                        </script>
                    <?php endif; ?>

                    <?php  if($msgSuccess) : ?>
                        <script>
                            swal({title:"???????????? ????????",text:'<?php echo $msg ?>',icon:"success" , button:"????????",timer:4000}).then(function (){ window.location = "<?php echo DOMAIN . "admin/admin_foods.php"; ?>" });
                        </script>
                    <?php endif; ?>

                    <div class="form-group">
                        <label for="title">?????? ??????</label>
                        <input type="text" class="form-control" id="title" name="title">
                    </div>
                    <div class="form-group">
                        <label for="price">???????? (??????????)</label>
                        <input type="text" class="form-control" id="price" name="price">
                    </div>
                    <div class="form-group">
                        <label for="categry" class="">???????? ????????</label>
                        <select name="category" id="category" class="form-control">
                            <option selected disabled>???????? ???????? ?????????????? ???? ???????????? ????????.</option>
                            <?php
                            if ($cats = Category::getAllCategories()){
                                foreach ($cats as $cat){ ?>
                                    <option value="<?php echo $cat->id; ?>" class=""><?php echo $cat->category_name; ?></option>
                            <?php  } } ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="imageFile">??????????</label>
                        <input type="file" class="form-control-file" id="imageFile" name="imageFile">
                    </div>

                    <div class="form-group">
                        <input name="addImage-btn" type="submit" class="btn btn-dark" value="??????"/>
                        <a href="admin_foods.php" class="btn btn-secondary">??????</a>
                    </div>

                    <input type="hidden" class="validation" name="validation" value="">

                </fieldset>
            </form>
        </div>
    </div>

</div>


<script src="../node_modules/bootstrap/dist/js/bootstrap.js"></script>
<script src="js/validation_addImage.js"></script>
</body>
</html>


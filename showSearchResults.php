<?php require_once "includes/include.php"; ?>


<?php
$msgSuccess = false;
$msgErr = false;
$msg = "";
$isRecordExist = null;
$insertIntoCart = null;

if (isset($_GET["fid"])) {
    $foodId = $_GET["fid"];
    if (isset($_SESSION["userInfo"])) {
        $userId = $_SESSION["userInfo"]["id"];
        $userStatus = $_SESSION["userInfo"]["status"];
        if ($userStatus == 1) {
            foreach ($_SESSION["cart"] as $key => $value)
            {
                if ($value["fid"]==$foodId) {
                    $_SESSION["cart"][$key]["count"]++;
                    Cart::updateCart($userId,$foodId,1);
                    $isRecordExist=true;
                    $msgSuccess = true;
                    $msg = "محصول موردنظر به سبد خرید شما مجددا افزوده شد.";
                }
            }
            if ($isRecordExist!=true) {
                Cart::InsertIntoCart($userId,$foodId,1);
                $msgSuccess = true;
                $msg = "محصول موردنظر به سبد خرید شما افزوده شد.";
            }
        } else {
            $msgErr = true;
            $msg = "برای خرید از سایت ابتدا باید حساب کاربری خود را فعال کنید.";
        }
    } else {
        $msgErr = true;
        $msg = "برای خرید از سایت ابتدا باید وارد شوید.";
    }
}
?>

<?php
if ($Foods = Foods::getSearchResults($_POST["search"])){ ?>
    <div class="row">

        <?php  if($msgErr) : ?>
            <script>
                swal({title:"خطا",text:'<?php echo $msg ?>',icon:"error" , button:"بستن",timer:4000});
            </script>
        <?php endif; ?>

        <?php  if($msgSuccess) : ?>
            <script>
                swal({title:"عملیات موفق",text:'<?php echo $msg ?>',icon:"success" , button:"بستن",timer:4000});
            </script>
        <?php endif; ?>

        <?php foreach ($Foods as $Food){ ?>
            <article class="col-xl-4 col-lg-4 col-md-6 col-12 px-3 py-5">
                <div class="imgBox text-center p-3">
                    <a class="" href="./showPost.php?post=<?php echo $Food->id; ?>"><img class="img-fluid" src="<?php echo $Food->image_path; ?>" alt="<?php echo $Food->title; ?>"></a>


                    <div class="imgInfo d-flex justify-content-between my-2 px-2">
                        <strong><a class="imgTitle" href="./showPost.php?post=<?php echo $Food->id; ?>"><?php echo $Food->title; ?></a></strong>
                        <p>
                            <a href="./?cat=<?php echo $Food->cat_id; ?>" class="imgCat badge badge-secondary py-2"><?php echo Category::getCategoryById($Food->cat_id)->category_name; ?></a>
                            <?php if($Food->subCat_id>0) : ?><a href="./?cat=<?php echo $Food->subCat_id; ?>" class="imgCat badge badge-secondary py-2"><?php echo Category::getCategoryById($Food->subCat_id)->category_name; ?></a><?php endif; ?>
                        </p>
                    </div>

                    <div class="imgPrice px-2 text-right">
                        <p><?php echo $Food->price; ?> تومان</p>
                    </div>

                    <p class="text-left"><a href="./?fid=<?php echo $Food->id; ?>" class="btn btn-sm addToBasket " name="addToCart"><i class="fa fa-shopping-cart"></i></a></p>

                </div>
            </article>
        <?php } ?>
    </div>

<?php } else { ?>
    <div class="text-center py-5"><p class="msg"><strong>تاکنون هیچ محصولی برای این دسته بندی در سایت ثبت نشده است.</strong></p></div>
<?php } ?>





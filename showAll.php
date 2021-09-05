<?php require_once "includes/include.php"; ?>

<?php
$msgSuccess = false;
$msgErr = false;
$msg = "";
$isRecordExist = false;
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
if (isset($_GET["section"]) and !empty($_GET["section"]) and is_numeric($_GET["section"])) {
    $section = $_GET["section"];
}
else {
    $section = 1;
}

$start = ($section - 1) * MAX_PAGE_POST ;
if ($foods = Foods::getAllFoods(MAX_PAGE_POST,$start)){ ?>
    <div class="row">

        <?php  if($msgErr) : ?>
            <script>
                swal({title:"خطا",text:'<?php echo $msg ?>',icon:"error" , button:"بستن",timer:4000}).then(function (){ window.location = window.location.pathname });
            </script>
        <?php endif; ?>

        <?php  if($msgSuccess) : ?>
            <script>
                swal({title:"عملیات موفق",text:'<?php echo $msg ?>',icon:"success" , button:"بستن",timer:4000}).then(function (){ window.location = window.location.pathname });
            </script>
        <?php endif; ?>



    <?php foreach ($foods as $food){ ?>
        <article class="col-xl-4 col-lg-4 col-md-6 col-12 px-3 py-4">
            <div class="imgBox text-center p-3">
                <a class="" href="./showPost.php?post=<?php echo $food->id; ?>"><img class="img-fluid" src="<?php echo $food->image_path; ?>" alt="<?php echo $food->title; ?>"></a>


                <div class="imgInfo d-flex justify-content-between my-2 px-2">
                    <strong><a class="imgTitle text-nowrap" href="./showPost.php?post=<?php echo $food->id; ?>"><?php echo $food->title; ?></a></strong>
                    <p class="text-nowrap">
                        <a href="./?cat=<?php echo $food->cat_id; ?>" class="imgCat badge badge-secondary py-2"><?php echo Category::getCategoryById($food->cat_id)->category_name; ?></a>
                        <?php if($food->subCat_id>0) : ?><a href="./?cat=<?php echo $food->subCat_id; ?>" class="imgCat badge badge-secondary py-2"><?php echo Category::getCategoryById($food->subCat_id)->category_name; ?></a><?php endif; ?>
                    </p>
                </div>

                <div class="imgPrice px-2 text-right">
                    <p><?php echo $food->price; ?> تومان</p>
                </div>
                <p class="text-left"><a href="./?fid=<?php echo $food->id; ?>" class="btn btn-sm addToBasket " name="addToCart"><i class="fa fa-shopping-cart"></i></a></p>

            </div>
        </article>

    <?php } ?>
    </div>
    <?php
    $totalFoods = count(Foods::getAllFoods());
    $totalSections = ceil($totalFoods / MAX_PAGE_POST);
    ?>

    <div class="row">
        <section class="pageBlock m-auto">
            <ul class="pagination mt-5 mb-4">

                <?php for ($i=1;$i<=$totalSections;$i++){
                    if ($i == $section)
                        $class = "active";
                    else
                        $class = "";
                    echo "<li class='page-item $class'><a class='page-link' href='./?section=$i#products'>$i</a></li>" ;
                }
                ?>

            </ul>
        </section>
    </div>

<?php } else { ?>
    <div class="text-center py-5"><p class="msg"><strong>تاکنون هیچ محصولی در سایت ثبت نشده است.</strong></p></div>
<?php } ?>
<?php require_once "includes/include.php"; ?>
<?php require_once "includes/header.php"; ?>

<?php
if (isset($_GET["post"]) and !empty($_GET["post"]) and is_numeric($_GET["post"])){
    $foodId = $_GET["post"];
}
?>

<?php
$msgSuccess = false;
$msgErr = false;
$msg = "";
$isRecordExist = null;
$insertIntoCart = null;

if (isset($_POST["addToCart"])){
    if (!empty($_POST["quantity"])){
        $newQuantity = $_POST["quantity"];
        if (isset($_SESSION["userInfo"])){
            $userId = $_SESSION["userInfo"]["id"];
            $userStatus = $_SESSION["userInfo"]["status"];
            if($userStatus == 1){
                $isRecordExist = Cart::isRecordExist($userId,$foodId);
                if ($isRecordExist){
                    $quantity = $isRecordExist->quantity;
                    $id = $isRecordExist->id;
                    Cart::updateCart($id,$quantity,$newQuantity);

                    $msgSuccess = true;
                    $msg = "محصول موردنظر به سبد خرید شما افزوده شد.";
                }
                else{
                    $insertIntoCart = Cart::InsertIntoCart($userId,$foodId,$newQuantity);
                    if ($insertIntoCart){
                        $msgSuccess = true;
                        $msg = "محصول موردنظر به سبد خرید شما افزوده شد."; ?>

                        <script>
                            var orderCounts = 0;
                            orderCounts = parseInt($(".orderCounts").text());
                            $(".orderCounts").text(orderCounts + 1);
                        </script>

                    <?php
                    }
                    else{
                        $msgErr = true;
                        $msg = "عملیات ناموفق.";
                    }
                }
            }
            else{
                $msgErr = true;
                $msg = "برای خرید از سایت ابتدا باید حساب کاربری خود را فعال کنید.";
            }
        }
        else{
            $msgErr = true;
            $msg = "برای خرید از سایت ابتدا باید وارد شوید.";
        }
    }
    else{
        $msgErr = true;
        $msg = "تعداد موردنظر را وارد نمایید.";
    }

}
?>


<section class="container-fluid">
    
    <?php  if($msgErr) : ?>
        <script>
            swal({title:"خطا",text:'<?php echo $msg ?>',icon:"error" , button:"بستن",timer:4000}).then(function (){ window.location = window.location.pathname + "?post=" + <?php echo $imageId; ?>  });
        </script>
    <?php endif; ?>

    <?php  if($msgSuccess) : ?>
        <script>
            swal({title:"عملیات موفق",text:'<?php echo $msg ?>',icon:"success" , button:"بستن",timer:4000}).then(function (){ window.location = window.location.pathname + "?post=" + <?php echo $imageId; ?> });
        </script>
    <?php endif; ?>

    <?php $food = Foods::getFoodById($foodId); ?>
    <div class="row ">
        <div class="col-md-4 col-12 p-5 text-center showPostImage">
            <img class="img-fluid mt-5 " src="<?php echo $food->image_path; ?>" alt="<?php echo $food->title; ?>">
        </div>
        <div class="col-md-8 col-12 p-5 text-right showPostContent">
            <h3 class="my-5 "><?php echo $food->title; ?></h3>
            <p><strong>قیمت :</strong> <?php echo $food->price; ?> تومان</p>
            <p>
                <strong>دسته بندی های مرتبط : </strong>
                <a href="./?cat=<?php echo $food->subCat_id; ?>" class="badge badge-dark ml-1 p-1 px-2"><?php echo Category::getCategoryById($food->subCat_id)->category_name; ?></a>
                <a href="./?cat=<?php echo $food->cat_id; ?>" class="badge badge-dark ml-1 p-1 px-2"><?php echo Category::getCategoryById($food->cat_id)->category_name; ?></a>
            </p>
            <div class="mt-5 text-right">
                <button class="btn btn-sm btn-dark plus-btn"><i class="fa fa-plus"></i></button>
                <input type="text" name="quantity" class="quantity py-1" value="1" form="quantityForm" readonly>
                <button class="btn btn-sm btn-dark minus-btn"><i class="fa fa-minus"></i></button>
                <form action="" method="post" id="quantityForm" class="d-inline-block">
                    <button type="submit" class="btn btn-sm btn-dark addToBasket mx-3 my-1 px-2" name="addToCart"><i class="fa fa-shopping-cart"></i> افزودن به سبد خرید </button>
                </form>
            </div>
        </div>

    </div>
</section>


<?php require_once "includes/footer.php"; ?>






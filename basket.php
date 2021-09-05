<?php require_once "includes/include.php"; ?>
<?php require_once "includes/header.php"; ?>

<?php
$msg = "";
$msgErr = false;
$msgSuccess = false;
if (isset($_POST["plus"]) and !empty($_POST["plus"])){
    Cart::updateCart($_SESSION["userInfo"]["id"],$_POST["plus"],1);
    foreach ($_SESSION["cart"] as $key => $value)
    {
        if ($value["fid"]==$_POST["plus"]) {
            $_SESSION["cart"][$key]["count"]++;
            $response= $_SESSION["cart"][$key]["count"];
        }
    }

}
else if (isset($_POST["minus"]) and !empty($_POST["minus"])){
    Cart::updateCart($_SESSION["userInfo"]["id"],$_POST["minus"],-1);
    foreach ($_SESSION["cart"] as $key => $value)
    {
        if ($value["fid"]==$_POST["minus"]) {
            $_SESSION["cart"][$key]["count"]--;
            $response= $_SESSION["cart"][$key]["count"];
        }
    }

}
else if (isset($_POST["del-food"]) and !empty($_POST["del-food"])){
    foreach ($_SESSION["cart"] as $key => $value)
    {
        if ($value["fid"]==$_POST["del-food"]) {
            unset($_SESSION["cart"][$key]);
            $delete_cart = Cart::deleteRecord($value["id"]);
            if ($delete_cart){
                $msgSuccess = true;
                $msg = "محصول موردنظر از سبد خرید شما حذف شد.";
            }
            else{
                $msgErr = true;
                $msg = "عملیات ناموفق.";
            }
        }
    }
}
?>


<section class="container-fluid text-right">
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

        <div class="col-12  px-5 py-4 basketContent">
            <?php
            if (isset($_SESSION["userInfo"])){
                $userId = $_SESSION["userInfo"]["id"];
                $counter = 1;
                $sum = 0;
                if ($records = $_SESSION["cart"]){ ?>

                    <div class="table-responsive">
                        <form action="#" method="post" class="basketForm">
                            <input type="hidden" name="">
                            <table class="table table-hover table-striped basketTable">
                                <thead>
                                <tr>
                                    <th class="text-center">ردیف</th>
                                    <th class="text-center">تصویر</th>
                                    <th class="text-center">غذا</th>
                                    <th class="text-center">قیمت واحد (تومان)</th>
                                    <th class="text-center">تعداد</th>
                                    <th class="text-center">قیمت کل (تومان)</th>
                                    <th class="text-center">حذف</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($records as $record):
                                    $foodId = $record["fid"];
                                    $food = Foods::getFoodById($foodId);
                                    ?>
                                    <tr>
                                        <td class="text-center id"><?php echo $counter; ?><input type="hidden" name="id" value="<?php echo $record["fid"]; ?>"></td>
                                        <td class="text-center"><a href="./showPost.php?post=<?php echo $foodId; ?>"><img src="<?php echo $food->image_path; ?>" class="img-fluid" alt="<?php echo $food->title; ?>"></a></td>
                                        <td class="text-center"><?php echo $food->title; ?></td>
                                        <td class="text-center price"><?php echo $food->price; ?></td>
                                        <td class="text-center">
                                            <button class="btn btn-sm btn-dark plusBtn" name="plusBtn"><i class="fa fa-plus"></i></button>
                                            <input type="text" class="quantity py-1" name="quantity" readonly value="<?php echo $record["count"]; ?>">
                                            <button class="btn btn-sm btn-dark minusBtn" name="minusBtn"><i class="fa fa-minus"></i></button>
                                        </td>
                                        <td class="text-center totalPrice"><?php echo $totalPrice = ($record["count"])*($food->price); ?></td>
                                        <td class="text-center"><a href="#" class="text-danger del-food"><i class="fa fa-trash-alt"></i></a></td>
                                    </tr>
                                    <?php
                                    $sum += $totalPrice;
                                    $counter++;
                                endforeach;
                                ?>
                                </tbody>
                            </table>
                            <input type="hidden" name="del-food" value="">
                            <input type="hidden" name="plus" value="">
                            <input type="hidden" name="minus" value="">
                        </form>
                    </div>

                    <div class="d-flex justify-content-between col-12 mb-1 px-3 py-1 priceBox">
                        <p class="mx-1"><strong>مبلغ کل قابل پرداخت :</strong></p>
                        <p class="mx-1"><span class="sumOfPrice"><?php echo $sum; ?></span> تومان</p>
                    </div>

                    <div class="text-right mt-2">
                        <form action="pay.php" method="post" class="payForm">
                            <div class="form-group">
                                <input type="text" class="form-control" name="address" placeholder="ادرس خود را وارد کنید" style="background: transparent;border-radius: 5px;border: 1px solid #FFBF2D">
                                <span><small class="error text-danger mr-2 d-none"></small></span>
                            </div>
                            <input type="hidden" name="sum" class="sum" value="<?php echo $sum; ?>">
                            <button class="btn payBtn" name="paySubmit">ثبت سفارش</button>
                        </form>
                    </div>

                <?php } else { ?>
                    <div class="text-center pt-5"><p class="msg"><strong>سبد خرید شما خالی است.</strong></p></div>
                <?php } } else { ?>
                <div class="text-center pt-5"><p class="msg"><strong>برای مشاهده سبد خرید ابتدا باید وارد شوید.</strong></p></div>
            <?php } ?>
        </div>
    </div>
</section>



<?php require_once "includes/footer.php"; ?>
<script>
    $(".payBtn").click(function (e) {
        e.preventDefault()
        if ($("form [name='address']").val() == "") {
            $("form [name='address']").addClass("is-invalid");
            $(".error").removeClass("d-none")
            $(".error").text("آدرس خود را وارد کنید")
        }
        else
        {
            $('.payForm')[0].submit(function (event) {
                $(".error").text("")
                $(".error").addClass("d-none")
                event.preventDefault();
            });
        }
    })
</script>

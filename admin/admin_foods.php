<?php require_once ("../includes/include.php"); ?>
<?php require_once ("admin_includes/admin_header.php"); ?>

<?php
$msg = "";
$msgErr = false;
$msgSuccess = false;

if (isset($_POST["del-food"]) and !empty($_POST["del-food"])){
    $delete_food= Foods::deleteFood($_POST["del-food"]);
    if ($delete_food){
        $msgSuccess = true;
        $msg = "محصول موردنظر حذف شد.";
    }
    else{
        $msgErr = true;
        $msg = "عملیات ناموفق.";
    }
}

$dellFoods = null;
if (isset($_POST["dell-foods"]) and !empty($_POST["dell-foods"])){
    if (!empty($_POST["checkbox"])){
        $dellFoods = Foods::dellFoods();
        if ($dellFoods){
            $msgSuccess = true;
            $msg = "محصولات های موردنظر با موفقیت حذف شدند.";
        }
        else {
            $msgErr = true;
            $msg = "عملیات ناموفق.";
        }
    }
    else{
        $msgErr = true;
        $msg = "گزینه ای انتخاب نشده است." ;
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

        <div class="col-12 px-5 py-4 imageContent">
            <h2 class="mb-4 text-light">غذاها</h2>
            <hr>

            <form action="" method="post" class="foodForm">
                <a href="addFoods.php" class="btn btn-sm btn-primary mb-3 ml-1">افزودن<i class="fa fa-plus mx-1"></i></a>
                <button name="dell-Foods-btn" class="btn btn-sm btn-danger mb-3 dellFoodsBtn">حذف<i class="fa fa-times mx-1"></i></button>
                <input type="hidden" name="dell-foods" class="dellFoods" value="">
            <?php
            if ($foods = Foods::getAllFoods()){
                $counter = 1; ?>
                    <div class="table-responsive">
                        <table class="table table-hover table-striped imageTable">
                            <thead>
                            <tr>
                                <th class="text-center"><input type="checkbox" name="check-all" class="check-all"></th>
                                <th class="text-center">#</th>
                                <th class="text-center">آیدی</th>
                                <th class="text-center">دسته بندی</th>
                                <th class="text-center">عنوان</th>
                                <th class="text-center">تصویر</th>
                                <th class="text-center">قیمت (تومان)</th>
                                <th class="text-center">تاریخ ثبت</th>
                                <th class="text-center">ویرایش</th>
                                <th class="text-center">حذف</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($foods as $food): ?>
                                <tr>
                                    <td class="text-center"><input type="checkbox" name="checkbox[]" class="checkbox" value="<?php echo $food->id; ?>"></td>
                                    <td class="text-center"><?php echo $counter; ?></td>
                                    <td class="text-center"><?php echo $food->id; ?></td>
                                    <td class="text-center"><?php echo Category::getCategoryById($food->cat_id)->category_name; ?></td>
                                    <td class="text-center"><?php echo $food->title; ?></td>
                                    <td class="text-center"><img src="<?php echo "../".$food->image_path; ?>" class="img-fluid" alt="<?php echo $food->title; ?>"></td>

                                    <td class="text-center"><?php echo $food->price; ?></td>
                                    <td class="text-center"><?php echo dateToJalali($food->create_date); ?></td>
                                    <td class="text-center">
                                        <a href="updateFoods.php?id=<?php echo $food->id; ?>" class="text-primary"><i class="fa fa-edit"></i></a>
                                    </td>
                                    <td class="text-center">
                                        <a href="#" class="text-warning del-food"><i class="fa fa-trash-alt"></i></a>
                                    </td>
                                </tr>
                            <?php
                            $counter++;
                            endforeach;
                            ?>
                            </tbody>
                        </table>
                        <input type="hidden" name="del-food" value="">
                    </div>
                </form>
            <?php } else { ?>
                <div class="text-center pt-5"><p class="msg"><strong>تاکنون هیچ محصولی در سایت ثبت نشده است.</strong></p></div>
            <?php } ?>
    </div>
    </div>
</section>


<script src="../node_modules/jquery/dist/jquery.js"></script>
<script src="../node_modules/bootstrap/dist/js/bootstrap.js"></script>
<script src="js/main.js"></script>
</body>
</html>
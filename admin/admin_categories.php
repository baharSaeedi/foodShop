<?php require_once ("../includes/include.php"); ?>
<?php require_once ("admin_includes/admin_header.php"); ?>

<?php
$msg = "";
$msgErr = false;
$msgSuccess = false;

if (isset($_POST["del-cat"]) and !empty($_POST["del-cat"])){
    $delete_cat = Category::deleteCategory($_POST["del-cat"]);
    if ($delete_cat){
        $msgSuccess = true;
        $msg = "دسته بندی موردنظر حذف شد.";
    }
    else{
        $msgErr = true;
        $msg = "عملیات ناموفق.";
    }
}

$dellCats = null;
if (isset($_POST["dell-cats"]) and !empty($_POST["dell-cats"])){
    if (!empty($_POST["checkbox"])){
        $dellCats = Category::dellCategories();
        if ($dellCats){
            $msgSuccess = true;
            $msg = "دسته بندی های موردنظر با موفقیت حذف شدند.";
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

        <div class="col-12  px-5 py-4 catContent">
            <h2 class="mb-4 text-light">دسته بندی ها</h2>
            <form action="" method="post" class="catForm">
                <a href="./addCategory.php" class="btn btn-sm btn-primary mb-3 ml-1">افزودن<i class="fa fa-plus mx-1"></i></a>
                <button name="dell-cats-btn" class="btn btn-sm btn-danger mb-3 dellCatsBtn">حذف<i class="fa fa-times mx-1"></i></button>
                <input type="hidden" name="dell-cats" class="dellCats" value="">
                <?php
                if ($cats = Category::getAllCategories()){
                    $counter = 1; ?>

                <div class="table-responsive">
                    <table class="table table-hover table-striped catTable">
                        <thead>
                        <tr>
                            <th class="text-center"><input type="checkbox" name="check-all" class="check-all"></th>
                            <th class="text-center">#</th>
                            <th class="text-center">آیدی</th>
                            <th class="text-center">نام</th>
                            <th class="text-center">مرتبه</th>
                            <th class="text-center">ویرایش</th>
                            <th class="text-center">حذف</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($cats as $cat): ?>
                        <tr>
                            <td class="text-center"><input type="checkbox" name="checkbox[]" class="checkbox" value="<?php echo $cat->id; ?>"></td>
                            <td class="text-center"><?php echo $counter; ?></td>
                            <td class="text-center"><?php echo $cat->id; ?></td>
                            <td class="text-center"><?php echo $cat->category_name; ?></td>
                            <td class="text-center"><?php echo $cat->ord; ?></td>
                            <td class="text-center">
                                <a href="./updateCategory.php?id=<?php echo $cat->id; ?>" class="text-primary"><i class="fa fa-edit"></i></a>
                            </td>
                            <td class="text-center">
                                <a href="#" class="text-warning del-cat"><i class="fa fa-trash-alt"></i></a>
                            </td>
                        </tr>
                        <?php
                        $counter++;
                        endforeach;
                        ?>
                        </tbody>
                    </table>
                    <input type="hidden" name="del-cat" value="">
                </div>
            </form>
        <?php } else { ?>
            <div class="text-center pt-5"><p class="msg"><strong>تاکنون هیچ دسته بندی ای در سایت ثبت نشده است.</strong></p></div>
        <?php } ?>
        </div>
    </div>
</section>


<script src="../node_modules/jquery/dist/jquery.js"></script>
<script src="../node_modules/bootstrap/dist/js/bootstrap.js"></script>
<script src="js/main.js"></script>
</body>
</html>
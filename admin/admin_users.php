<?php require_once ("../includes/include.php"); ?>
<?php require_once ("admin_includes/admin_header.php"); ?>

<?php
$msg = "";
$msgErr = false;
$msgSuccess = false;

if (isset($_POST["del-user"]) and !empty($_POST["del-user"])){
    $delete_user = User::deleteUser($_POST["del-user"]);
    if ($delete_user){
        $msgSuccess = true;
        $msg = "کاربر موردنظر حذف شد.";
    }
    else{
        $msgErr = true;
        $msg = "عملیات ناموفق.";
    }
}

$dellUsers = null;
if (isset($_POST["dell-users"]) and !empty($_POST["dell-users"])){
    if (!empty($_POST["checkbox"])){
        $dellUsers = User::dellUsers();
        if ($dellUsers){
            $msgSuccess = true;
            $msg = "کاربران موردنظر با موفقیت حذف شدند.";
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

        <div class="col-12 px-5 py-4 userContent">
            <h2 class="mb-4 text-light">کاربران</h2>
            <hr>
            <form action="" method="post" class="userForm">
                <a href="./addUser.php" class="btn btn-sm btn-primary mb-3 ml-1">افزودن<i class="fa fa-plus mx-1"></i></a>
                <button name="dell-users-btn" class="btn btn-sm btn-danger mb-3 dellUsersBtn">حذف<i class="fa fa-times mx-1"></i></button>
                <input type="hidden" name="dell-users" class="dellUsers" value="">
                <?php
                if ($users = User::getAllUsers()){
                    $counter = 1; ?>

                <div class="table-responsive">
                    <table class="table table-hover table-striped userTable">
                        <thead>
                        <tr>
                            <th class="text-center"><input type="checkbox" class="check-all" name="check-all"></th>
                            <th class="text-center">#</th>
                            <th class="text-center">آیدی</th>
                            <th class="text-center">نام</th>
                            <th class="text-center">نام خانوادگی</th>
                            <th class="text-center">ایمیل</th>
                            <th class="text-center">شماره همراه</th>
                            <th class="text-center">تاریخ عضویت</th>
                            <th class="text-center">نقش کاربری</th>
                            <th class="text-center">وضعیت</th>
                            <th class="text-center">ویرایش</th>
                            <th class="text-center">حذف</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($users as $user): ?>
                            <tr>
                                <td class="text-center"><input type="checkbox" name="checkbox[]" class="checkbox" value="<?php echo $user->id; ?>"></td>
                                <td class="text-center"><?php echo $counter; ?></td>
                                <td class="text-center"><?php echo $user->id; ?></td>
                                <td class="text-center"><?php echo $user->first_name; ?></td>
                                <td class="text-center"><?php echo $user->last_name; ?></td>
                                <td class="text-center"><?php echo $user->email; ?></td>
                                <td class="text-center"><?php echo $user->mobile; ?></td>
                                <td class="text-center"><?php echo dateToJalali($user->create_date); ?></td>
                                <td class="text-center">
                                    <?php
                                    switch ($user->role){
                                        case 1:
                                            echo '<span class="badge badge-primary py-2 px-3">مدیر</span>';
                                            break;
                                        case 2:
                                            echo '<span class="badge badge-warning py-2 px-3">کاربر عادی</span>';
                                            break;
                                    }
                                    ?>
                                </td>
                                <td class="text-center">
                                    <?php
                                    switch ($user->status){
                                        case 0:
                                            echo '<span class="badge badge-danger py-2 px-3">غیرفعال</span>';
                                            break;
                                        case 1:
                                            echo '<span class="badge badge-success py-2 px-3">فعال</span>';
                                            break;
                                    }
                                    ?>
                                </td>
                                <td class="text-center">
                                    <a href="./updateUser.php?id=<?php echo $user->id; ?>" class="text-primary"><i class="fa fa-edit"></i></a>
                                </td>
                                <td class="text-center">
                                    <a href="#" class="text-warning del-user"><i class="fa fa-trash-alt"></i></a>
                                </td>
                            </tr>

                        <?php
                        $counter++;
                        endforeach;
                        ?>
                        </tbody>
                    </table>
                    <input type="hidden" name="del-user" value="">
                </div>
            </form>
                <?php } else { ?>
                    <div class="text-center pt-5"><p class="msg"><strong>تاکنون کاربری در سایت ثبت نام نکرده است.</strong></p></div>
                <?php } ?>

    </div>
    </div>
</section>


<script src="../node_modules/jquery/dist/jquery.js"></script>
<script src="../node_modules/bootstrap/dist/js/bootstrap.js"></script>
<script src="js/main.js"></script>
</body>
</html>
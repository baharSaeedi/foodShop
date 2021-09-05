<?php require_once "includes/include.php"; ?>
<?php require_once "includes/header.php"; ?>

<section class="container-fluid text-right">
    <div class="row">
        <div class="col-12 bg-secondary px-5 py-4 panelContent">
            <nav>
                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                    <a class="nav-link active" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="true">مشخصات کاربر</a>
                    <a class="nav-link" id="nav-order-tab" data-toggle="tab" href="#nav-order" role="tab" aria-controls="nav-order" aria-selected="false">خریدهای ثبت شده</a>
                </div>
            </nav>
            <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade show active p-2 mt-3" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                    <p><strong>نام : </strong><?php if (isset($_SESSION["userInfo"])){ echo $_SESSION["userInfo"]["first_name"]; } ?></p>
                    <p><strong>نام خانوادگی : </strong><?php if (isset($_SESSION["userInfo"])){ echo $_SESSION["userInfo"]["last_name"]; } ?></p>
                    <p><strong>ایمیل : </strong><?php if (isset($_SESSION["userInfo"])){ echo $_SESSION["userInfo"]["email"]; } ?></p>
                    <p><strong>شماره همراه : </strong><?php if (isset($_SESSION["userInfo"])){ echo $_SESSION["userInfo"]["mobile"]; } ?></p>
                </div>
                <div class="tab-pane fade p-2 mt-3" id="nav-order" role="tabpanel" aria-labelledby="nav-order-tab">
                    <?php
                    if (isset($_SESSION["userInfo"])){
                        $userId = $_SESSION["userInfo"]["id"];
                        $counter = 1;
                        if ($records = Order::getAllOrdersByUserId($userId)){ ?>

                            <div class="table-responsive">
                                <table class="table table-hover table-striped panelTable">
                                    <thead>
                                    <tr>
                                        <th class="text-center">ردیف</th>
                                        <th class="text-center">شماره سفارش</th>
                                        <th class="text-center">تاریخ</th>
                                        <th class="text-center">آدرس</th>
                                        <th class="text-center">قیمت کل (تومان)</th>
                                        <th class="text-center">وضعیت</th>
                                        <th class="text-center">-</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach ($records as $record):
                                        ?>

                                        <tr>
                                            <td class="text-center"><?php echo $counter; ?></td>
                                            <td class="text-center"><?php echo $record->id ?></td>
                                            <td class="text-center"><?php echo dateToJalali($record->create_date); ?></td>
                                            <td class="text-center"><?php echo $record->address; ?></td>
                                            <td class="text-center"><?php echo $record->price; ?></td>
                                            <td class="text-center">
                                                <?php
                                                    switch ($record->status){
                                                        case 0 :
                                                            echo "در جریان ارسال";
                                                            break;
                                                        case 1 :
                                                            echo "تحویل داده شده";
                                                            break;
                                                        case 2 :
                                                            echo  "کنسل شده";
                                                            break;
                                                    }
                                                ?>
                                            </td>
                                            <td class="text-center"><a href="./showOrder?oid=<?php echo $record->id ?>"><i class="fa fa-eye"></i></a></td>
                                        </tr>

                                    <?php
                                    $counter++;
                                    endforeach;
                                    ?>
                                    </tbody>
                                </table>
                            </div>

                        <?php } else { ?>
                            <div class="text-center pt-5"><p class="msg"><strong>تاکنون هیچ خریدی برای شما ثبت نشده است.</strong></p></div>
                        <?php } } else { ?>
                        <div class="text-center pt-5"><p class="msg"><strong>برای مشاهده خریدهای ثبت شده ابتدا باید وارد شوید.</strong></p></div>
                        <?php } ?>
                </div>
            </div>
        </div>
    </div>
</section>


<?php require_once "includes/footer.php"; ?>






<?php require_once ("../includes/include.php"); ?>
<?php require_once ("admin_includes/admin_header.php"); ?>



<section class="container-fluid text-right">
    <div class="row">

        <div class="col-12  px-5 py-4 orderContent">
            <h2 class="mb-4 text-light">سفارش ها</h2>
            <hr>

                <?php
                    $counter = 1;
                    if ($records = Order::getAllOrders()){ ?>

                        <div class="table-responsive">
                            <table class="table table-hover table-striped orderTable">
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
                                        <td class="text-center"><a href="./admin_showOrder?oid=<?php echo $record->id ?>"><i class="fa fa-eye"></i></a></td>
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
                    <?php }  ?>
    </div>
    </div>
</section>


<script src="../node_modules/jquery/dist/jquery.js"></script>
<script src="../node_modules/bootstrap/dist/js/bootstrap.js"></script>
<script src="js/main.js"></script>
</body>
</html>
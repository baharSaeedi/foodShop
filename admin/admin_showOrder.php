<?php require_once ("../includes/include.php"); ?>
<?php require_once ("admin_includes/admin_header.php"); ?>

<?php
if (isset($_GET["cid"]))
{
    Order::updateOrder($_GET["cid"],2);
}
if (isset($_GET["sid"]))
{
    Order::updateOrder($_GET["sid"],1);
}
?>

<section class="container-fluid text-right text-light">
    <div class="row">
        <div class="col-12  px-5 py-4 orderContent">
            <?php
                $counter = 1;
                if ($record = Order::getOrderById($_GET["oid"])){
                    $user=User::getUserById($record->user_id);
                    $foods_id=explode(",",$record->foods_id);
                    $foods_count=explode(",",$record->foods_count);
                    ?>
                    <div class="table-responsive">
                        <h4 class="mt-2 mr-4">نام: <?php echo $user->first_name." ".$user->last_name; ?></h4>
                        <h4 class="mt-2 mr-4">شماره تلفن: <?php echo $user->mobile; ?></h4>
                        <h5 class="mt-2 mr-4">آدرس: <?php echo $record->address; ?></h5>
                        <h6 class="mt-3 mr-4">شماره سفارش: <?php echo dateToJalali($record->create_date); ?></h6>
                        <h6 class="mt-3 mr-4 text-danger">
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
                        </h6>
                        <table class="table table-hover table-striped orderTable">
                            <thead>
                            <tr>
                                <th class="text-center">ردیف</th>
                                <th class="text-center">تصویر</th>
                                <th class="text-center">نام غذا</th>
                                <th class="text-center">تعداد</th>
                                <th class="text-center">قیمت کل (تومان)</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($foods_id as $food_id) :
                                $food=Foods::getFoodById($food_id);
                                $count=$foods_count[$counter-1];
                                ?>

                                <tr>
                                    <td class="text-center"><?php echo $counter; ?></td>
                                    <td class="text-center"><img class="img-fluid w-25" src="<?php echo "../".$food->image_path ?>" alt=""></td>
                                    <td class="text-center"><?php echo $food->title; ?></td>
                                    <td class="text-center"><?php echo $count ?></td>
                                    <td class="text-center"><?php echo $count*($food->price) ?></td>
                                </tr>

                                <?php
                                $counter++;
                            endforeach;
                            ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-between col-12 mb-1 px-3 py-1 priceBox">
                        <p class="mx-1"><strong>مبلغ کل سفارش :</strong></p>
                        <p class="mx-1"><span class="sumOfPrice"><?php echo $record->price; ?></span> تومان</p>
                    </div>

                    <?php }  ?>
        </div>
    </div>
</section>



<script src="../node_modules/jquery/dist/jquery.js"></script>
<script src="../node_modules/bootstrap/dist/js/bootstrap.js"></script>
<script src="js/main.js"></script>
</body>
</html>

<?php
require_once "includes/include.php";
require_once "includes/header.php";

if (isset($_GET["cid"]))
{
    Order::updateOrder($_GET["cid"],2);
}
if (isset($_GET["sid"]))
{
    Order::updateOrder($_GET["sid"],1);
}
?>

<section class="container-fluid text-right">
    <div class="row">
        <div class="col-12 bg-secondary px-5 py-4 panelContent">
                <?php
    if (isset($_SESSION["userInfo"])){
        $userId = $_SESSION["userInfo"]["id"];
        $counter = 1;
        if ($record = Order::getOrderById($_GET["oid"])){
            $foods_id=explode(",",$record->foods_id);
            $foods_count=explode(",",$record->foods_count);
            ?>
            <div class="table-responsive">
                <h4 class="mt-3 mr-4">شماره سفارش: <?php echo dateToJalali($record->create_date); ?></h4>
                <h5 class="mt-2 mr-4">آدرس: <?php echo $record->address; ?></h5>
                <h6 class="mt-3 mr-4 text-light">
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
                <table class="table table-hover table-striped panelTable">
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
                            <td class="text-center"><img class="img-fluid" src="<?php echo $food->image_path ?>" alt=""></td>
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

            <?php if ($record->status==0) {?>
                <p class="text-left" >
                    <?php
                        $mysqldate = date( 'Y-m-d H:i:s' );
                        $phpdate = strtotime( $mysqldate );
                        $diff = ($phpdate - strtotime($record->create_date))/(60*60);
                        if ($diff < 3) :
                    ?>
                        <a href="?oid=<?php echo $record->id; ?>&cid=<?php echo $record->id; ?>" class="btn btn-warning mt-3">کنسل کردن سفارش</a>
                    <?php endif; ?>
                    <a href="?oid=<?php echo $record->id; ?>&sid=<?php echo $record->id; ?>" class="btn btn-success mt-3">سفارشم را تحویل گرفتم</a>
                </p>
        <?php }
        } else { ?>
            <div class="text-center pt-5"><p class="msg"><strong>تاکنون هیچ خریدی برای شما ثبت نشده است.</strong></p></div>
        <?php } } else { ?>
        <div class="text-center pt-5"><p class="msg"><strong>برای مشاهده خریدهای ثبت شده ابتدا باید وارد شوید.</strong></p></div>
    <?php } ?>
</div>
</div>
</section>


<?php require_once "includes/footer.php"; ?>

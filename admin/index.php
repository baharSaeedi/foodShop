<?php require_once ("../includes/include.php"); ?>
<?php require_once ("admin_includes/admin_header.php"); ?>


<section class="container-fluid text-right">
    <div class="row">
        <div class="col-12  px-5 py-4 mainContent">
           <h2 class="text-light">داشبورد</h2>
            <hr>
            <div class="row">
                <div class="col-lg-3 col-md-6 col-12">
                    <div class="box pt-3 pb-1 px-4 my-1">
                        <p class="d-flex justify-content-between numbers"><span>
                                <strong>
                                    <?php
                                    $images = Foods::getAllFoods();
                                    if ($images){
                                        echo count($images);
                                    }
                                    else{
                                        echo "0";
                                    }
                                    ?>
                                </strong>
                            </span><i class="fa fa-coffee"></i></p>
                        <p class="numbersText">تعداد غذاهای موجود در منو</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-12">
                    <div class="box pt-3 pb-1 px-4 my-1">
                        <p class="d-flex justify-content-between numbers"><span>
                                <strong>
                                    <?php
                                    $orders = Order::getAllOrders();
                                    if ($orders){
                                        echo count($orders);
                                    }
                                    else{
                                        echo "0";
                                    }
                                    ?>
                                </strong>
                            </span><i class="fa fa-shopping-cart"></i></p>
                        <p class="numbersText">تعداد سفارش های کاربران</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-12">
                    <div class="box pt-3 pb-1 px-4 my-1">
                        <p class="d-flex justify-content-between numbers"><span>
                                <strong>
                                    <?php
                                    $users = User::getAllUsers();
                                    if ($users){
                                        echo count($users);
                                    }
                                    else{
                                        echo "0";
                                    }
                                    ?>
                                </strong>
                            </span><i class="fa fa-users"></i></p>
                        <p class="numbersText" >تعداد کاربران سایت</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-12">
                    <div class="box pt-3 pb-1 px-4 my-1">
                        <p class="d-flex justify-content-between numbers"><span>
                                <strong>
                                    <?php
                                    $orders = Order::getAllOrders();
                                    if ($orders){
                                        $sum = 0 ;
                                        foreach ($orders as $order){
                                            if ($order->status==1)
                                            {
                                                $sum += $order->price;
                                            }
                                        }
                                        echo $sum;
                                    }
                                    else{
                                        echo "0";
                                    }
                                    ?>
                                </strong>
                            </span><i class="fa fa-money-bill-alt"></i></p>
                        <p class="numbersText">درآمدها</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>








<script src="../node_modules/jquery/dist/jquery.js"></script>
<script src="../node_modules/bootstrap/dist/js/bootstrap.js"></script>
<script src="js/main.js"></script>
</body>
</html>

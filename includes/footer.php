<?php require_once ("includes/include.php"); ?>

<footer>
    <div class="container-fluid footer my-bg-dark py-4">
        <div class="row">
            <div class="col-lg-3 col-12 firstCol text-center text-lg-right mt-lg-1 mt-4">
                <div class="text-center"><a href="<?php echo DOMAIN ; ?>"><img alt="logo" src="images/bg_images/logo-footer.png"  style="width: 100px" class="ml-5 img-fluid"/></a></div>
                <p class="mt-3">ما تیم فودشاپ هستیم: ذله‌کننده‌ی سرمایه‌گذارهای دست‌به‌عصا ، حامیان تمام‌عیار احمقانه‌ترین و جسورانه‌ترین ایده‌ها  و کَنه‌ی حل غیرممکن‌ترین مسئله‌ها . به دنیای فودشاپ خوش آمدید!
                </p>
                <ul class="socialMedia d-flex justify-content-center">
                    <li class="mx-2"><a href="#"><i class="fab fa-instagram"></i></a></li>
                    <li class="mx-2"><a href="#"><i class="fab fa-facebook-f"></i></a></li>
                    <li class="mx-2"><a href="#"><i class="fab fa-telegram"></i></a></li>
                    <li class="mx-2"><a href="#"><i class="fab fa-twitter"></i></a></li>
                </ul>
            </div>
            <div class="col-lg-3 col-12 secondCol text-center text-lg-right mt-lg-1 mt-4">
                <h4>تماس با ما</h4>
                <ul class="mt-3">
                    <li class="secondContent pr-3 pb-1"><a href="#"><i class="fa fa-phone-alt"></i> 021-48982200</a></li>
                    <li class="secondContent pr-3 pb-1"><a href="#"><i class="far fa-envelope"></i> foodshop@gmail.com</a></li>
                    <li class="secondContent pr-3 pb-1"><a href="#"><i class="fa fa-map-marker-alt"></i> تهران - میدان انقلاب</a></li>
                    <li class="sendMessage mt-3 px-3 mr-3">
                        <a href="./contactUs.php"><i class="fa fa-envelope"></i> با ما در تماس باشید</a>
                    </li>
                </ul>
            </div>
            <div class="col-lg-3 col-12 thirdCol text-center text-lg-right mt-lg-1 mt-4">
                <h4>دسته بندی غذاها</h4>
                <ul class="mt-3 pr-2">
                    <li><a href="<?php echo DOMAIN ?>">همه</a></li>
                    <?php if ($cats = Category::getAllCategories()){
                        foreach ($cats as $cat){ ?>
                            <li class="mt-1"><a href="./?cat=<?php echo $cat->id; ?>#products"><?php echo $cat->category_name; ?></a></li>
                        <?php } } ?>
                </ul>
            </div>
            <div class="col-lg-3 col-12 forthCol text-center text-lg-right mt-lg-1 mt-4">
                <h4>لوکیشن ما</h4>
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3240.038115872439!2d51.389772514577594!3d35.70067963651383!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3f8e011cdfe6b339%3A0x48848e52d60959af!2sDistrict%2011%2C%20Tehran%2C%20Tehran%20Province%2C%20Iran!5e0!3m2!1sen!2s!4v1630784150981!5m2!1sen!2s" width="250" height="250" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
            </div>
        </div>
    </div>
    <div class="container-fluid copyRight ">
        <div class="row">
            <div class="copyRightContent m-auto py-2"><p>کلیه حقوق این سایت متعلق به فروشگاه آنلاین <strong>فودشاپ</strong> می باشد.</p></div>
        </div>
    </div>
</footer>



<script src="node_modules/jquery/dist/jquery.js" ></script>
<script src="node_modules/bootstrap/dist/js/bootstrap.js"></script>
<script src="js/main.js"></script>



</body>
</html>

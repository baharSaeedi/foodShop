<?php require_once "includes/include.php"; ?>
<?php require_once "includes/header.php"; ?>

    <div class="banner-center pt-5">
        <img class="mb-0 mt-0 img-fluid" alt="title" style="width: 300px" src="images/bg_images/foodShop.png">
        <form class="d-flex justify-content-center" method="post" >
            <input class="form-control" type="search" placeholder="عنوان موردنظر را جست و جو کنید" aria-label="Search" name="search">
            <button class="btn btn-light mr-1" type="submit"><i class="fa fa-search"></i></button>
        </form>
    </div>


    <section id="products" class="container-fluid py-2 productsImg">
        <div class="title">
            <h1 class="display-4 my-4 text-center">منو غذاها</h1>
        </div>

            <?php
            if (isset($_GET["cat"]) and !empty($_GET["cat"]) and is_numeric($_GET["cat"]))
                require_once "showByCategory.php";
            elseif (isset($_POST["search"]) and !empty($_POST["search"])) {
                require_once "showSearchResults.php";
            } else
                require_once "showAll.php";
            ?>
    </section>

<div class="container-fluid py-5 bg-secondary">
    <h3 class="text-center text-light">پیشنهادات خریداران</h3>
    <div class="row">
        <?php $maxSell=Foods::getMaxSell();
        foreach ($maxSell as $food) : ?>
            <article class="col-xl-4 col-md-6 col-12 px-3 py-4">
                <div class="imgBox text-center p-3">
                    <a class="" href="./showPost.php?post=<?php echo $food->id; ?>"><img class="img-fluid" src="<?php echo $food->image_path; ?>" alt="<?php echo $food->title; ?>"></a>


                    <div class="imgInfo d-flex justify-content-between my-2 px-2">
                        <strong><a class="imgTitle text-nowrap" href="./showPost.php?post=<?php echo $food->id; ?>"><?php echo $food->title; ?></a></strong>
                        <p class="text-nowrap">
                            <a href="./?cat=<?php echo $food->cat_id; ?>" class="imgCat badge badge-secondary py-2"><?php echo Category::getCategoryById($food->cat_id)->category_name; ?></a>
                            <?php if($food->subCat_id>0) : ?><a href="./?cat=<?php echo $food->subCat_id; ?>" class="imgCat badge badge-secondary py-2"><?php echo Category::getCategoryById($food->subCat_id)->category_name; ?></a><?php endif; ?>
                        </p>
                    </div>

                    <div class="imgPrice px-2 text-right">
                        <p><?php echo $food->price; ?> تومان</p>
                    </div>
                    <p class="text-left"><a href="./?fid=<?php echo $food->id; ?>" class="btn btn-sm addToBasket " name="addToCart"><i class="fa fa-shopping-cart"></i></a></p>

                </div>
            </article>
        <?php endforeach; ?>
    </div>
</div>

<?php require_once "includes/footer.php"; ?>



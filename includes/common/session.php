<?php
if(!isset($_SESSION)) {
    session_start();
}

if(isset($_SESSION["userInfo"])){
    if(time() - $_SESSION["userInfo"]["expireTime"] >= 0){
        session_unset();
        session_destroy();

        header("Location:" . DOMAIN ."login.php");
    }
}
if(!isset($_SESSION['cart'])){
    $_SESSION['cart']=[];
}

?>

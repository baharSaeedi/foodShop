<?php require_once "includes/include.php"; ?>
<?php
if (isset($_SESSION["userInfo"])){
    session_unset();
    session_destroy();

    header("Location:" . DOMAIN );
}
else{
    header("Location:" . DOMAIN);
}

?>

<?php require_once "includes/include.php"; ?>
<?php require_once "includes/header.php"; ?>

<?php
$msg = "";
$msgErr = false;
$msgSuccess = false;

if (isset($_SESSION["userInfo"])){
    $userId = $_SESSION["userInfo"]["id"];
    if (isset($_POST["address"]) and  !empty($_POST["address"]) and !empty($_POST["sum"]) and isset($_POST["sum"]) ){
        $foods_id="";
        $foods_count="";
        foreach ($_SESSION["cart"] as $key => $value)
        {
            Cart::addToSell($value["fid"]);
            if ($foods_id==""){
                $foods_id=$foods_id.$value["fid"];
                $foods_count=$foods_count.$value["count"];
            }
            else{
                $foods_id=$foods_id.",".$value["fid"];
                $foods_count=$foods_count.",".$value["count"];
            }
            Cart::deleteRecord($value["id"]);
            unset($_SESSION["cart"][$key]);
        }
        $id = Order::insertIntoOrders($userId,$foods_id,$foods_count,$_POST["sum"],$_POST["address"]);
        ?>
        <script>
            swal({title:"عملیات موفق",text:'<?php echo $msg ?>',icon:"success" , button:"بستن",timer:4000}).then(function (){ window.location ='<?php echo DOMAIN; ?>'; });
        </script>
<?php
    }
}
?>





<?php require_once "includes/footer.php"; ?>







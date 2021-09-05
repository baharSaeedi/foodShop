<?php
require_once "Table.class.php";
class Order extends Table{
    protected $data = array(
        "id" => 0,
        "user_id" => 0,
        "foods_id" => "",
        "foods_count" => 0,
        "price" => 0,
        "address" => "",
        "create_date" => 0,
        "status" => 0
    );

    public static function getAllOrders(){
        $conn = self::connect();
        $query = "SELECT * FROM " .TBL_ORDERS. "  ORDER BY `status` ASC";
        $result = $conn->query($query);
        if ($result->num_rows){
            $orders = array();
            foreach ($result->fetch_all(MYSQLI_ASSOC) as $row){
                array_push($orders,new Order($row));
            }
            $ret = $orders;
        }
        else
            $ret = false;
        self::disconnect($conn);
        return $ret;
    }


    public static function getAllOrdersByUserId($userId){
        $conn = self::connect();
        $query = "SELECT * FROM " .TBL_ORDERS. " WHERE `user_id`= N'". $userId ."' ORDER BY `create_date` DESC";
        $result = $conn->query($query);
        if ($result->num_rows){
            $orders = array();
            foreach ($result->fetch_all(MYSQLI_ASSOC) as $row){
                array_push($orders,new Order($row));
            }
            $ret = $orders;
        }
        else
            $ret = false;
        self::disconnect($conn);
        return $ret;
    }

    public static function getOrderById($id){
        $conn = self::connect();
        $query = "SELECT * FROM " .TBL_ORDERS. " WHERE `id`= N'". $id ."' ";
        $result = $conn->query($query);
        if ($result->num_rows){
            $row = $result->fetch_assoc();
            $ret = new Order($row);
        }
        else
            $ret = false;
        self::disconnect($conn);
        return $ret;
    }

    public static function insertIntoOrders($userId,$foods_id,$foods_count,$price,$address){
        $conn = self::connect();
        $userId = sanitize($userId);
        $address=sanitize($address);

        $query = ("INSERT INTO " .TBL_ORDERS. " (`user_id`,`foods_id`,`foods_count`,`address`,`price`) VALUES (N'".$userId."',N'".$foods_id."',N'".$foods_count."',N'".$address."',N'".$price."')");
        $result = $conn->query($query);
        if ($result){
            $id = $conn->insert_id;
        }
        else
            $id = false;
        self::disconnect($conn);
        return $id ;
    }

    public static function updateOrder($id,$status){
        $conn = self::connect();
        $id = sanitize($id);
        $status = sanitize($status);

        $query = ("UPDATE " .TBL_ORDERS. " SET `status`= N'". $status ."' WHERE `id`= N'". $id ."' LIMIT 1");
        $result = $conn->query($query);
        self::disconnect($conn);
        return $result ;
    }




}

?>
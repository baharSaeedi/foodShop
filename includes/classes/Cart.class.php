<?php
require_once "Table.class.php";
class Cart extends Table{
    protected $data = array(
        "id" => 0,
        "uid" => 0,
        "fid" => 0,
        "count" => 0,
    );

    public static function getAllRecords(){
        $conn = self::connect();
        $query = "SELECT * FROM " .TBL_CART. " WHERE `order_id` IS NOT NULL ORDER BY `id`";
        $result = $conn->query($query);
        if ($result->num_rows){
            $records = array();
            foreach ($result->fetch_all(MYSQLI_ASSOC) as $row){
                array_push($records,new Cart($row));
            }
            $ret = $records;
        }
        else
            $ret = false;
        self::disconnect($conn);
        return $ret;
    }






    public static function updateCart($userId,$foodId,$count){
        $conn = self::connect();
        $userId = sanitize($userId);
        $foodId = sanitize($foodId);
        $query = ("UPDATE " .TBL_CART. " SET `count`= `count`+".$count." WHERE `uid`= N'". $userId ."' and `fid`=N'".$foodId."' LIMIT 1");
        $result = $conn->query($query);
        self::disconnect($conn);
        return $result ;
    }

    public static function InsertIntoCart($userId,$foodId,$count=1){
        $conn = self::connect();
        $userId = sanitize($userId);
        $foodId = sanitize($foodId);

        $query = ("INSERT INTO " .TBL_CART. " (`uid`,`fid`,`count`) VALUES (N'".$userId."',N'".$foodId."',N'".$count."')");
        $result = $conn->query($query);
        $cartSession = array(
            'signInKey' => true,
            'id' => $conn->insert_id,
            'fid' => $foodId,
            'count' => $count
        );
        $_SESSION["cart"][] = $cartSession;
        self::disconnect($conn);
        return $result ;
    }

    public static function getRecordsByUserId($userId){
        $conn = self::connect();
        $query = "SELECT * FROM " .TBL_CART. " WHERE `uid`= N'". $userId ."' ";
        $result = $conn->query($query);
        if ($result->num_rows){
            $records = array();
            foreach ($result->fetch_all(MYSQLI_ASSOC) as $row){
                array_push($records,new Cart($row));
                $cartSession = array(
                    'signInKey' => true,
                    'id' => $row["id"],
                    'fid' => $row["fid"],
                    'count' => $row["count"]
                );
                $_SESSION["cart"][] = $cartSession;
            }
            $ret = $records;
        }
        else
            $ret = false;
        self::disconnect($conn);
        return $ret;
    }


    public static function deleteRecord($id){
        $conn = self::connect();
        $query = "DELETE FROM " .TBL_CART. " WHERE `id`= N'". $id ."' ";
        $result = $conn->query($query);
        self::disconnect($conn);
        return $result ;
    }


    public static function addToSell($fid){
        $conn = self::connect();
        $query = "INSERT INTO " .TBL_MAX. " (`food_id`) VALUES (N'".$fid."')";
        $result = $conn->query($query);
        self::disconnect($conn);
        return $result ;
    }

}

?>
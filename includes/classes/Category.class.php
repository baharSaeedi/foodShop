<?php
require_once "Table.class.php";
class Category extends Table{
    protected $data = array(
        "id" => 0,
        "category_name" => "",
        "ord" => 0,
        "sub_cat" => 0
    );

    public static function getAllCategories(){
        $conn = self::connect();
        $query = "SELECT * FROM " .TBL_CATS. " ORDER BY `id`";
        $result = $conn->query($query);
        if ($result->num_rows){
            $cats = array();
            foreach ($result->fetch_all(MYSQLI_ASSOC) as $row){
                array_push($cats,new Category($row));
            }
            $ret = $cats;
        }
        else
            $ret = false;
        self::disconnect($conn);
        return $ret;
    }

    public static function getCategoryById($id){
        $conn = self::connect();
        $query = "SELECT * FROM " .TBL_CATS. " WHERE `id`= N'". $id ."' ";
        $result = $conn->query($query);
        if ($result->num_rows){
            $row = $result->fetch_assoc();
            $ret = new Category($row);
        }
        else
            $ret = false;
        self::disconnect($conn);
        return $ret;
    }

    public static function getCategoryParentById($id){
        $conn = self::connect();
        $query = "SELECT `ord` FROM " .TBL_CATS. " WHERE `id`= N'". $id ."' ";
        $result = $conn->query($query);
        if ($result->num_rows){
            $row = $result->fetch_assoc();
            $ret = $row["ord"];
        }
        else
            $ret = false;
        self::disconnect($conn);
        return $ret;
    }

    public static function deleteCategory($id){
        $conn = self::connect();
        $query = "DELETE FROM " .TBL_CATS. " WHERE `id`= N'". $id ."' ";
        $result = $conn->query($query);
        self::disconnect($conn);
        return $result ;
    }

    public static function dellCategories(){
        if (isset($_POST["checkbox"])){
            $conn = self::connect();
            $countCheck = count($_POST["checkbox"]);
            $check = $_POST["checkbox"];

            for ($i=0 ; $i<$countCheck ; $i++){
                $checked = $check[$i];
                $query = "DELETE FROM " .TBL_CATS. " WHERE `id`= N'". $checked ."' ";
                $result = $conn->query($query);
            }
            self::disconnect($conn);
            return $result ;
        }
    }

    public static function InsertCategory($catName,$order){
        $conn = self::connect();
        $catName = sanitize($catName);
        $order = sanitize($order);

        $query = ("INSERT INTO " .TBL_CATS. " (`category_name`,`ord`) VALUES (N'".$catName."',N'".$order."')");
        $result = $conn->query($query);
        self::disconnect($conn);
        return $result ;
    }

    public static function updateCategory($id,$catName,$order){
        $conn = self::connect();
        $id = sanitize($id);
        $catName = sanitize($catName);
        $order = sanitize($order);

        $query = ("UPDATE " .TBL_CATS. " SET `category_name`= N'". $catName ."' , `ord`= N'". $order ."' WHERE `id`= N'". $id ."' LIMIT 1");
        $result = $conn->query($query);
        self::disconnect($conn);
        return $result ;
    }

}

?>
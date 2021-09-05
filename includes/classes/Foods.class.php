<?php
require_once "Table.class.php";
class Foods extends Table{
    protected $data = array(
        "id" => 0,
        "cat_id" => 0,
        "subCat_id" => 0,
        "title" => "",
        "image_path" => "",
        "price" => 0,
        "create_date" => 0
    );

    public static function getAllFoods($limit = 0 , $start = 0){
        $conn = self::connect();
        $limiter = $limit > 0 ? "LIMIT $start , $limit" : "" ;

        $query = "SELECT * FROM " .TBL_FOODS. ' ORDER BY `create_date` ASC '. $limiter .' ';
        $result = $conn->query($query);
        if ($result->num_rows){
            $foods = array();
            foreach ($result->fetch_all(MYSQLI_ASSOC) as $row){
                array_push($foods,new Foods($row));
            }
            $ret = $foods;
        }
        else
            $ret = false;
        self::disconnect($conn);
        return $ret;
    }

    public static function getAllFoodsByCatId($limit = 0 , $start = 0 , $catId){
        $conn = self::connect();
        $limiter = $limit > 0 ? "LIMIT $start , $limit" : "" ;

        $query = "SELECT * FROM " .TBL_FOODS. " WHERE `cat_id`= N'". $catId."' or `subCat_id`= N'". $catId."'  ORDER BY `create_date` DESC ". $limiter ." ";
        $result = $conn->query($query);
        if ($result->num_rows){
            $foods = array();
            foreach ($result->fetch_all(MYSQLI_ASSOC) as $row){
                array_push($foods,new Foods($row));
            }
            $ret = $foods;
        }
        else
            $ret = false;
        self::disconnect($conn);
        return $ret;
    }

    public static function getSearchResults($search_val){
        $conn = self::connect();
        $query = "SELECT * FROM " .TBL_FOODS. " WHERE `title` like N'%".$search_val. "%'  ORDER BY `create_date` DESC ";
        $result = $conn->query($query);
        if ($result->num_rows){
            $foods = array();
            foreach ($result->fetch_all(MYSQLI_ASSOC) as $row){
                array_push($foods,new Foods($row));
            }
            $ret = $foods;
        }
        else
            $ret = false;
        self::disconnect($conn);
        return $ret;
    }

    public static function getFoodById($id){
        $conn = self::connect();
        $query = "SELECT * FROM " .TBL_FOODS. " WHERE `id`= N'". $id ."' ";
        $result = $conn->query($query);
        if ($result->num_rows){
            $row = $result->fetch_assoc();
            $ret = new Foods($row);
        }
        else
            $ret = false;
        self::disconnect($conn);
        return $ret;
    }

    public static function deleteFood($id){
        $conn = self::connect();
        $query = "DELETE FROM " .TBL_FOODS. " WHERE `id`= N'". $id ."' ";
        $result = $conn->query($query);
        self::disconnect($conn);
        return $result ;
    }

    public static function dellFoods(){
        if (isset($_POST["checkbox"])){
            $conn = self::connect();
            $countCheck = count($_POST["checkbox"]);
            $check = $_POST["checkbox"];

            for ($i=0 ; $i<$countCheck ; $i++){
                $checked = $check[$i];
                $query = "DELETE FROM " .TBL_FOODS. " WHERE `id`= N'". $checked ."' ";
                $result = $conn->query($query);
            }
            self::disconnect($conn);
            return $result ;
        }
    }

    public static function InsertFood($title,$price,$catId,$image_path,$subCat){
        $conn = self::connect();
        $title = sanitize($title);
        $price = sanitize($price);
        $catId = sanitize($catId);
        $subCat = sanitize($subCat);
        $image_path = sanitize($image_path);

        $query = ("INSERT INTO " .TBL_FOODS. " (`title`,`price`,`cat_id`,`subCat_id`,`image_path`) VALUES (N'".$title."',N'".$price."',N'".$catId."',N'".$subCat."',N'".$image_path."')");
        $result = $conn->query($query);
        self::disconnect($conn);
        return $result ;
    }

    public static function updateFood($id,$title,$price,$category){
        $conn = self::connect();
        $id = sanitize($id);
        $title = sanitize($title);
        $price = sanitize($price);
        $category = sanitize($category);

        $query = ("UPDATE " .TBL_FOODS. " SET `title`= N'". $title ."' , `price`= N'". $price ."' , `cat_id`= N'". $category ."' WHERE `id`= N'". $id ."' LIMIT 1");
        $result = $conn->query($query);
        self::disconnect($conn);
        return $result ;
    }


    public static function getMaxSell(){
        $conn = self::connect();
        $query = " SELECT COUNT(id) count , food_id FROM ".TBL_MAX." GROUP BY food_id order by count DESC LIMIT 6";
        $result = $conn->query($query);
        if ($result->num_rows){
            $foods = array();
            foreach ($result->fetch_all(MYSQLI_ASSOC) as $row){
                array_push($foods,self::getFoodById($row["food_id"]));
            }
            $ret = $foods;
        }
        else
        {
            $ret = false;
        }
        self::disconnect($conn);
        return $ret ;
    }


}


?>

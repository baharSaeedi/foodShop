<?php
require_once "Table.class.php";
class User extends Table{
    protected $data = array(
      "id" => 0 ,
      "role" => 0 ,
      "first_name" => "" ,
      "last_name" => "" ,
      "email" => "" ,
      "password" => "" ,
      "mobile" => "" ,
      "create_date" => 0 ,
      "activationKey" => "" ,
      "status" => 0 ,
      "resetPassKey" => ""
    );

    public static function getAllUsers(){
        $conn = self::connect();
        $query = ("SELECT * FROM " .TBL_USERS. " ORDER BY `id`");
        $result = $conn->query($query);
        if ($result->num_rows){
            $users = array();
            foreach ($result->fetch_all(MYSQLI_ASSOC) as $row){
                array_push($users,new User($row));
            }
            $ret = $users;
        }
        else
            $ret = false;
        self::disconnect($conn);
        return $ret;
    }

    public static function getUserById($id){
        $conn = self::connect();
        $query = "SELECT * FROM " .TBL_USERS. " WHERE `id`= N'". $id ."' ";
        $result = $conn->query($query);
        if ($result->num_rows){
            $row = $result->fetch_assoc();
            $ret = new User($row);
        }
        else
            $ret = false;
        self::disconnect($conn);
        return $ret;
    }

    public static function InsertUser($first_name,$last_name,$email,$password,$mobile,$activationKey){
        $conn = self::connect();
        $first_name = sanitize($first_name);
        $last_name = sanitize($last_name);
        $email = sanitize($email);
        $password = sanitize($password);
        $password = hashpass($password);
        $mobile = sanitize($mobile);
        $activationKey = sanitize($activationKey);

        $query = ("INSERT INTO " .TBL_USERS. " (`first_name`,`last_name`,`email`,`password`,`mobile`,`activationKey`) VALUES (N'".$first_name."',N'".$last_name."',N'".$email."',N'".$password."',N'".$mobile."',N'".$activationKey."')");
        $result = $conn->query($query);
        self::disconnect($conn);
        return $result ;
    }

    public static function isUserExist($email){
        $conn = self::connect();
        $email = sanitize($email);

        $query = ("SELECT `email` FROM " .TBL_USERS. " WHERE `email` = N'". $email ."'");
        $result = $conn->query($query);
        if($result->num_rows){
            $ret = $result;
        }
        else
            $ret = false;
        self::disconnect($conn);
        return $ret ;
    }

    public static function isSameActivationKey($activationKey){
        $conn = self::connect();
        $activationKey = sanitize($activationKey);

        $query = ("SELECT `activationKey` FROM " .TBL_USERS. " WHERE `activationKey`= N'". $activationKey ."'");
        $result = $conn->query($query);
        if($result->num_rows){
            $ret = $result;
        }
        else
            $ret = false;
        self::disconnect($conn);
        return $ret ;
    }

    public static function activateUser($activationKey){
        $conn = self::connect();
        $activationKey = sanitize($activationKey);

        $query = ("UPDATE " .TBL_USERS. " SET `status` = 1 WHERE `activationKey`= N'". $activationKey ."'");
        $result = $conn->query($query);
        self::disconnect($conn);
        return $result;
    }

    public static function clearActivationKey(){
        $conn = self::connect();
        $query = ("UPDATE " .TBL_USERS. " SET `activationKey` = null WHERE `status`= 1 ");
        $result = $conn->query($query);
        self::disconnect($conn);
        return $result;
    }

    public static function sendMail($current_user_email,$mail_subject,$mail_body){
        $current_user_email = sanitize($current_user_email);
        $mail = new PHPMailer(true);

        try{
            $mail->SMTPDebug = 2 ;
            $mail->IsSMTP() ;
            $mail->Host = "smtp.gmail.com";
            $mail->SMTPAuth = true ;
            $mail->Username = "email.address@gmail.com";
            $mail->Password = "123456";
            $mail->SMTPSecure = "ssl";
            $mail->Port = 465;
            $mail->IsHTML(true);
            $mail->CharSet = "utf-8";
            $mail->FromName = "از طرف فودشاپ";
            $mail->ContentType = "text/html;charset='utf-8'";

            $mail->Subject = $mail_subject;
            $mail->Body =$mail_body;

            $mail->AddAddress($current_user_email,"cue");
            $mail->Send();
        }
        catch (Exception $err){
            echo "<div class='alert alert-warning col-6 mx-auto text-center'>ایمیل ارسال نشد<br> ".$mail->ErrorInfo." </div>";
        }
        $mail->SmtpClose();
        return $mail;
    }

    public static function doLogin($email,$password){
        $conn = self::connect();
        $email = sanitize($email);
        $password = sanitize($password);
        $password = hashpass($password);

        $query = ("SELECT `id`,`role`,`first_name`,`last_name`,`email`,`password`,`mobile`,`create_date`,`status` FROM " .TBL_USERS. " WHERE `email`= N'". $email ."' AND `password`= N'". $password ."' ");
        $result = $conn->query($query);
        if($result->num_rows){
            $row = $result->fetch_assoc();
            $userSession = array(
                'signInKey' => true,
                'id' => $row["id"],
                'role' => $row["role"],
                'first_name' => $row["first_name"],
                'last_name' => $row["last_name"],
                'email' => $row["email"],
                'password' => $row["password"],
                'mobile' => $row["mobile"],
                'create_date' => $row["create_date"],
                'status' => $row["status"] ,
                'expireTime' => time() + REMEMBER_TIME_SESSION
            );
            $_SESSION["userInfo"] = $userSession;
            $ret = $result;
        }
        else
            $ret = false;
        self::disconnect($conn);
        return $ret ;
    }

    public static function updateResetPassKey($resetPassKey,$email){
        $conn = self::connect();
        $resetPassKey = sanitize($resetPassKey);
        $email = sanitize($email);

        $query = ("UPDATE " .TBL_USERS. " SET `resetPassKey`= N'". $resetPassKey ."' WHERE `email`= N'". $email ."' LIMIT 1");
        $result = $conn->query($query);
        self::disconnect($conn);
        return $result ;
    }

    public static function isSameResetPassKey($resetPassKey){
        $conn = self::connect();
        $resetPassKey = sanitize($resetPassKey);

        $query = ("SELECT `resetPassKey` FROM " .TBL_USERS. " WHERE `resetPassKey`= N'". $resetPassKey ."'");
        $result = $conn->query($query);
        if($result->num_rows){
            $ret = $result;
        }
        else
            $ret = false;
        self::disconnect($conn);
        return $ret ;
    }

    public static function getUserEmail($resetPassKey){
        $conn = self::connect();
        $resetPassKey = sanitize($resetPassKey);

        $query = ("SELECT `email` FROM " .TBL_USERS. " WHERE `resetPassKey`= N'". $resetPassKey ."'");
        $result = $conn->query($query);
        if($result->num_rows){
            $ret = $result->fetch_assoc();
            $ret = $ret["email"];
        }
        else
            $ret = false;
        self::disconnect($conn);
        return $ret ;

    }

    public static function updatePassword($password,$resetPassKey){
        $conn = self::connect();
        $hashLessPass = $password;
        $resetPassKey = sanitize($resetPassKey);
        $password = sanitize($password);
        $password = hashpass($password);
        $userEmail = self::getUserEmail($resetPassKey);

        $query = ("UPDATE " .TBL_USERS. " SET `password`= N'". $password ."' WHERE `resetPassKey`= N'". $resetPassKey ."' LIMIT 1");
        $result = $conn->query($query);
        if (isset($_SESSION["userInfo"])){
            $_SESSION["userInfo"]["password"] = $password;
        }
        if (isset($_COOKIE["password"]) and isset($_COOKIE["email"])){
            setcookie("password",$hashLessPass,time()+ REMEMBER_TIME_COOKIE);
            setcookie("email",$userEmail,time()+ REMEMBER_TIME_COOKIE);
        }

        self::disconnect($conn);
        return $result ;
    }

    public static function clearResetPassKey($resetPassKey){
        $conn = self::connect();
        $resetPassKey = sanitize($resetPassKey);
        $query = ("UPDATE " .TBL_USERS. " SET `resetPassKey` = null WHERE `resetPassKey`= N'". $resetPassKey ."'");
        $result = $conn->query($query);
        self::disconnect($conn);
        return $result;
    }

    public static function getUserId($resetPassKey){
        $conn = self::connect();
        $resetPassKey = sanitize($resetPassKey);

        $query = ("SELECT `id` FROM " .TBL_USERS. " WHERE `resetPassKey`= N'". $resetPassKey ."'");
        $result = $conn->query($query);
        if($result->num_rows){
            $ret = $result->fetch_assoc();
            $ret = $ret["id"];
        }
        else
            $ret = false;
        self::disconnect($conn);
        return $ret ;

    }

    public static function insertPassResetReq($uid,$newPass){
        $conn = self::connect();
        $newPass = sanitize($newPass);
        $newPass = hashpass($newPass);

        $query = ("INSERT INTO " .TBL_PASS_RESET. " (`uid`,`hash_new_pass`) VALUES (N'".$uid."',N'".$newPass."')");
        $result = $conn->query($query);
        self::disconnect($conn);
        return $result ;
    }

    public static function loginUserAfterSignUp($activationKey){
        $conn = self::connect();
        $activationKey = sanitize($activationKey);

        $query = ("SELECT `id`,`role`,`first_name`,`last_name`,`email`,`password`,`mobile`,`create_date`,`status` FROM " .TBL_USERS. " WHERE `activationKey`= N'". $activationKey ."' ");
        $result = $conn->query($query);
        if($result->num_rows){
            $row = $result->fetch_assoc();
            $userSession = array(
                'signInKey' => true,
                'id' => $row["id"],
                'role' => $row["role"],
                'first_name' => $row["first_name"],
                'last_name' => $row["last_name"],
                'email' => $row["email"],
                'password' => $row["password"],
                'mobile' => $row["mobile"],
                'create_date' => $row["create_date"],
                'status' => $row["status"] ,
                'expireTime' => time() + REMEMBER_TIME_SESSION
            );
            $_SESSION["userInfo"] = $userSession;
            $ret = $result;
        }
        else
            $ret = false;
        self::disconnect($conn);
        return $ret ;
    }

    public static function deleteUser($id){
        $conn = self::connect();
        $query = "DELETE FROM " .TBL_USERS. " WHERE `id`= N'". $id ."' ";
        $result = $conn->query($query);
        self::disconnect($conn);
        return $result ;
    }

    public static function dellUsers(){
        if (isset($_POST["checkbox"])){
            $conn = self::connect();
            $countCheck = count($_POST["checkbox"]);
            $check = $_POST["checkbox"];

            for ($i=0 ; $i<$countCheck ; $i++){
                $checked = $check[$i];
                $query = "DELETE FROM " .TBL_USERS. " WHERE `id`= N'". $checked ."' ";
                $result = $conn->query($query);
            }
            self::disconnect($conn);
            return $result ;
        }
    }

    public static function updateUser($id,$firstName,$lastName,$status,$mobile){
        $conn = self::connect();
        $id = sanitize($id);
        $firstName = sanitize($firstName);
        $lastName = sanitize($lastName);
        $status = sanitize($status);
        $mobile = sanitize($mobile);

        $query = ("UPDATE " .TBL_USERS. " SET `first_name`= N'". $firstName ."' , `last_name`= N'". $lastName ."' , `status`= N'". $status ."' , `mobile`= N'". $mobile ."' WHERE `id`= N'". $id ."' LIMIT 1");
        $result = $conn->query($query);
        self::disconnect($conn);
        return $result ;
    }


}
?>

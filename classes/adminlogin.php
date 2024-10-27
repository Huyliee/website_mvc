<?php 
include '../lib/session.php';
Session::checkLogin();
include '../lib/database.php';
include '../helpers/format.php';


?>




<?php 
 class adminlogin 
 {

    private $db;
    private $fm;

    public function __construct(){

        $this->db = new Database();
        $this->fm = new Format();

    }


    public function login_admin($admin_user,$admin_pass)
    {

        $admin_user = $this->fm->validation($admin_user);
        $admin_pass = $this->fm->validation($admin_pass);
        if(empty($admin_user) || empty($admin_pass)){
            $msg = "Username or Password must not be empty";
            return $msg;
        }
        $sql = "SELECT * FROM tbl_admin WHERE admin_user = :admin_user AND admin_pass = :admin_pass";
        $query = $this->db->link->prepare($sql);
        $query->bindValue(':admin_user', $admin_user);
        $query->bindValue(':admin_pass', $admin_pass);
        $query->execute();
        $result = $query->fetch(PDO::FETCH_OBJ);
        if($result){
            Session::set("login", true);
            Session::set("admin_user", $result->admin_user);
            Session::set("admin_id", $result->admin_id);
            Session::set("admin_name", $result->admin_name);
            header("Location:index.php");
        }else{
            $msg = "Username or Password not match";
            return $msg;
        }
    }
        



 }



?>

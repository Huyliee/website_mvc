<?php 
include '../lib/database.php';
include '../helpers/format.php';


?>




<?php 

class category 
{

    private $db;
    private $fm;

    public function __construct()
    {

        $this->db = new Database();
        $this->fm = new Format();

    }


    // public function insert_category($catName)
    // {
    //     $catName = $this->fm->validation($catName);
    //     $catName = $this->fm->validation($catName);
    //     if(empty($catName)){
    //         $msg = "Không được để trống ten danh mục";
    //         return $msg;
    //     }
    //     $this->db->link->beginTransaction();
    //     $sql = "INSERT INTO tbl_category(cat_name) VALUES(:catName)";
    //     $query = $this->db->link->prepare($sql);
    //     $query->bindValue(':catName', $catName);
    //     $result = $query->execute();
    //     if($result){
    //         $this->db->link->commit();
    //         $msg = "Thêm danh mục thành công";
    //         return $msg;
    //     }else{
    //         $this->db->link->rollBack();
    //         $msg = "Thêm danh mục thất bại";
    //         return $msg;
    //     }   
    // }   
    public function insert_category($catName)
{
    // Kiểm tra và xác thực dữ liệu đầu vào
    $catName = $this->fm->validation($catName);

    if (empty($catName)) {
        return "Không được để trống tên danh mục.";
    }

    // Kiểm tra độ dài của tên danh mục
    if (strlen($catName) > 255) { // Thay đổi độ dài theo yêu cầu của bạn
        return "Tên danh mục không được quá 255 ký tự.";
    }

    try {
        $this->db->link->beginTransaction();
        
        $sql = "INSERT INTO tbl_category(cat_name) VALUES(:catName)";
        $query = $this->db->link->prepare($sql);
        $query->bindValue(':catName', $catName);

        $result = $query->execute();

        if ($result) {
            $this->db->link->commit();
            return "Thêm danh mục thành công.";
        } else {
            throw new Exception("Thêm danh mục thất bại."); // Ném ngoại lệ nếu không thành công
        }
    } catch (Exception $e) {
        $this->db->link->rollBack(); // Hoàn tác nếu có lỗi
        return $e->getMessage(); // Trả về thông báo lỗi
    }
}



}



?>

<?php 

include '../config/config.php';

?>





<?php 

class Database{
   
    public $host = DB_HOST;
    public $user = DB_USER;
    public $pass = DB_PASS;
    public $db_name = DB_NAME;


    public $link;
    public $error;


    public function __construct(){
        $this->connectDB();
    }

    private function connectDB(){
        try{
            $this->link = new PDO("mysql:host=".$this->host.";dbname=".$this->db_name, $this->user, $this->pass);
            $this->link->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        } catch (PDOException $e){
            $this->error = "Connection failed: " . $e->getMessage();
           return $this->error;
        }
        
    }

    public function select($query){
        try{
            $stmt = $this->link->prepare($query);
            $stmt->execute();
            $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
            return $result;
        } catch (PDOException $e){
            $this->error = "Selection failed: " . $e->getMessage();
           return $this->error;
        }
    }

    public function insert($query){
        try{
            $stmt = $this->link->prepare($query);
            $stmt->execute();
            return true;
        } catch (PDOException $e){
            $this->error = "Insertion failed: " . $e->getMessage();
           return $this->error;
        }
    }

}
?>

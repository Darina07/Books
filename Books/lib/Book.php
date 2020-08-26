<?php
 
 include_once 'Session.php';
 include_once 'Database.php';
 include_once 'Upload.php';
 class Book {
 	private $db;
 	public function __construct(){
 		 $this->db = new Database();
 	}

   public function getBookData(){
      $sql = "SELECT * FROM books ORDER BY id DESC";
      $query = $this->db->pdo->prepare($sql);
      $query->execute();
      $result = $query->fetchAll();
      return $result;
   }


   public function getBookById($id){
      $sql = "SELECT * FROM books WHERE id= :id LIMIT 1";
      $query = $this->db->pdo->prepare($sql);
      $query->bindValue(':id' , $id);  
      $query->execute();
      $result = $query->fetch(PDO::FETCH_OBJ);
      return $result;
   }


   public function deleteBookData($id, $data)
   {
      $sql = "DELETE FROM books WHERE id=".$id;
      $count=$this->db->pdo->prepare($sql);

      if($count->execute()){
         $msg = "No of records deleted =". $count->rowCount();
      }
      else{
         $str='';
         $dbo->setAttribute(PDO::ATTR_EMULATE_PREPARES,false); 
         $a=$count->errorInfo();
         while (list ($key, $val) = each ($a)  ) {
            $str .= "<br>$key -> $val";
         }
         $msg .= " Not able to delete record  please contact Admin: Error Message :  $str";
      }
   }

   public function createBook($data){  
      $upload = new Upload();
   
      $name = $data['name'];
      $isbn = $data['isbn'];
      $description = $data['description'];
      $image = $upload->upload_file($_FILES['image']['name']);
            
      $image_allowed = ['image/jpg', 'image/png', 'image/jpeg'];
      $image_sent_type = $upload->is_allowed_type($_FILES['image']['type']);
      if(!in_array( $image_sent_type, $image_allowed)){
         $msg = "<div class='alert alert-danger'><strong> Error ! </strong> Image is not allowed type </div>";
         return $msg;
      }
                  
      if ($name == "" OR $isbn == "" OR $description == "" ){
         $msg = "<div class='alert alert-danger'><strong> Error ! </strong>  Fineld must not be empty </div>";
         return $msg;
      }
   
   
      if(isset($_FILES['image'])){

         $upload = new Upload();

         $upload->file_name_1 = $_FILES['image']['name'];
         $upload->file_source_location = $_FILES['image']['tmp_name'];
         $upload->file_size_1 = $_FILES['image']['size'];
         $upload->file_target_location = "uploads/" . $upload->file_name_1;

         $file_upload_status = move_uploaded_file($upload->file_source_location, $upload->file_target_location);           
      
      };
               
      $sql = "INSERT INTO books(name, isbn, description, image) VALUES(:name, :isbn, :description, :image)";
      $query = $this->db->pdo->prepare($sql);
      $query->bindValue(':name' , $name);
      $query->bindValue(':isbn' , $isbn);
      $query->bindValue(':description' , $description);
      $query->bindValue(':image' , $image);
      $result = $query->execute();
      if ($result) {
               $msg = "<div class='alert alert-success'><strong> Success ! </strong> Thanks you. The book is added.   </div>";
      return $msg;
      }else{
               $msg = "<div class='alert alert-danger'><strong> Error ! </strong> Sorry There has been problem insserting your Details.   </div>";
      return $msg;
      }
   }

   
   public function updateBookData($id, $data){
      $name = $data['name'];
      $isbn = $data['isbn'];
      $description = $data['description'];
            
      $upload_again = new Upload();
          
      if($_FILES['image']['name']){
         $image = $upload_again->upload_file($_FILES['image']['name']);
     
         $image_allowed = ['image/jpg', 'image/png', 'image/jpeg'];
         $image_sent_type = $upload_again->is_allowed_type($_FILES['image']['type']);
         if(!in_array( $image_sent_type, $image_allowed)){
            $msg = "<div class='alert alert-danger'><strong> Error ! </strong> Image is not allowed type </div>";
            return $msg;
         }
      }
      else{
         $image = $data['oimage'];       
      }
 
      if ($name == "" OR $isbn == "" OR $description == "" ){
         $msg = "<div class='alert alert-danger'><strong> Error ! </strong>  Fineld must not be empty </div>";
         return $msg;
      }

      if(isset($_FILES['nimage'])){
         $upload = new Upload();

         $upload_again->file_name_1 = $_FILES['image']['name'];
         $upload_again->file_source_location = $_FILES['image']['tmp_name'];
         $upload_again->file_size_1 = $_FILES['image']['size'];
         $upload_again->file_target_location = "uploads/" . $upload_again->file_name_1;
         $file_upload_status = move_uploaded_file($upload_again->file_source_location, $upload_again->file_target_location);           
      };

      $sql = "UPDATE books set
         name = :name,
         isbn  = :isbn, 
         description = :description,
         image = :image 
         WHERE id = :id";

      $query = $this->db->pdo->prepare($sql);
      $query->bindValue(':name' , $name);
      $query->bindValue(':isbn' , $isbn);
      $query->bindValue(':description' , $description);
      $query->bindValue(':image' , $image);
      $query->bindValue(':id' , $id);
      $result = $query->execute();
      if ($result) {
         $msg = "<div class='alert alert-success'><strong> Success ! </strong> Book data Updated Successfully   </div>";
         return $msg;
      }
      else{
         $msg = "<div class='alert alert-danger'><strong> Error ! </strong> Book data not Updated.   </div>";
         return $msg;
      }

   }


 }

?> 
<?php
 
 include_once 'Session.php';
 include_once 'Database.php';
 class UserBook {
 	private $db;
 	public function __construct(){
 		 $this->db = new Database();
 	}

   public function addCollection($users_id, $books_id){

      $sql = "INSERT INTO users_books(users_id, books_id) VALUES(:users_id, :books_id)";
      $query = $this->db->pdo->prepare($sql);
      $query->bindValue(':users_id' , $users_id);
      $query->bindValue(':books_id' , $books_id);
      
      $result = $query->execute();

      if($result){
         return 1;
      }
   }     


   public function removeBook($user_id, $book_id){
      $sql = "DELETE FROM users_books WHERE users_id=".$user_id." AND books_id=".$book_id;
         

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


   public function inUserCollection($user_id, $book_id){
      $sql = "SELECT users_id,books_id FROM users_books WHERE EXISTS (SELECT users_id, books_id FROM users_books WHERE users_id='".$user_id."' AND books_id='".$book_id."')";

      $query = $this->db->pdo->prepare($sql);
      $query->execute();
      $result = $query->fetch(PDO::PARAM_BOOL);
      //var_dump($result);
      if($result){
         return true;
      }
      return false;
     
   }
   


 }

?> 
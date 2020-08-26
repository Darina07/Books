<?php
 
 include_once 'Session.php';
 include 'Database.php';
 class User {
 	private $db;
 	public function __construct(){
 		 $this->db = new Database();
    }
    
   

   public function userRegistration($data){
      if($data['is_administrator']){
         $is_administrator = $data['is_administrator'];
      }
      else{
         $is_administrator = 0;
      }
            
      $first_name = $data['first_name'];
      $last_name = $data['last_name'];
      $active = $data['active'];
      $email = $data['email'];
      $password = md5($data['password']);
      $chk_email = $this->emailCheck($email); 

      if ($first_name == "" OR $last_name == "" OR $email == "" OR $password == ""){
         $msg = "<div class='alert alert-danger'><strong> Error ! </strong>  Fineld must not be empty </div>";
         return $msg;
      }
 

      if (filter_var($email, FILTER_VALIDATE_EMAIL) === false){
	      $msg = "<div class='alert alert-danger'><strong> Error ! </strong> Email Address is not vaild  </div>";
         return $msg;
      }

      if($chk_email == true){
         $msg = "<div class='alert alert-danger'><strong> Error ! </strong> The email already Exist   </div>";
         return $msg;
      }

      $sql = "INSERT INTO users(is_administrator, first_name, last_name, email, password, active, approved) VALUES(:is_administrator, :first_name, :last_name, :email, :password, :active, :approved)";
      $query = $this->db->pdo->prepare($sql);
      $query->bindValue(':is_administrator' , $is_administrator);
      $query->bindValue(':first_name' , $first_name);
      $query->bindValue(':last_name' , $last_name);
      $query->bindValue(':email' , $email);
      $query->bindValue(':password' , $password);
      $query->bindValue(':active' , $active);
      $query->bindValue(':approved' , 0);
      $result = $query->execute();
      
      if ($result) {
         $msg = "<div class='alert alert-success'><strong> Success ! </strong> Thanks you you have been Registered   </div>";
         return $msg;
      }
      else{
         $msg = "<div class='alert alert-danger'><strong> Error ! </strong> Sorry There has been problem insserting your Details.   </div>";
         return $msg;
      }
   }

   public function emailCheck($email){
      $sql = "SELECT email FROM users WHERE email = :email";
      $query = $this->db->pdo->prepare($sql);
      $query->bindValue(':email' , $email);
      $query->execute();
      if ($query->rowCount() > 0) {
         return true;
      }
      else {
         return false;
      }
   }


   public function approvedCheck($email){
      $sql = "SELECT approved FROM users WHERE email = :email";
      $query = $this->db->pdo->prepare($sql);
      $query->bindValue(':email' , $email);
      $query->execute();
      $result = $query->fetch(PDO::FETCH_OBJ);

      if($result->approved){
         return true;
      }
      else{
         return false;
      }                      
   }

         
   public function getLoginUser($email, $password){
      $sql = "SELECT * FROM users WHERE email = :email AND password = :password LIMIT 1";
      $query = $this->db->pdo->prepare($sql);
      $query->bindValue(':email' , $email);
      $query->bindValue(':password' , $password);
      $query->execute();
      $result = $query->fetch(PDO::FETCH_OBJ);
      return $result;
   }


   public function userLogin($data){
      $email = $data['email'];
      $password = md5($data['password']);
      $chk_email = $this->emailCheck($email); 
      $chk_approved = $this->approvedCheck($email); 

      if ($email == "" OR $password == ""){
         $msg = "<div class='alert alert-danger'><strong> Error ! </strong>  Fineld must not be empty </div>";
         return $msg;
      }
          
      if (filter_var($email, FILTER_VALIDATE_EMAIL) === false){
	      $msg = "<div class='alert alert-danger'><strong> Error ! </strong> Email Address is not vaild  </div>";
         return $msg;
      }

      if($chk_email == false){
         $msg = "<div class='alert alert-danger'><strong> Error ! </strong> The email Address not Exist   </div>";
         return $msg;
      }

      if($chk_approved == false){
         $msg = "<div class='alert alert-danger'><strong> Error ! </strong> Your registration is waiting for approval. Please, try again later.   </div>";
         return $msg;
      }

      $result = $this->getLoginUser($email, $password);
      if ($result) {
         Session::init();
         Session::set("login" , true);
         Session::set("id" , $result->id);
         Session::set("first_name" , $result->first_name);
         Session::set("last_name" , $result->last_name);
         Session::set("loginmsg" , "<div class='alert alert-success'><strong> Success ! </strong> your are loggedIn  </div>");
         header("Location: index.php");
      }
      else {
         $msg = "<div class='alert alert-danger'><strong> Error ! </strong> Data not founnd </div>";
         return $msg;
      }
   }
 
 
   public function getUserData(){
      $sql = "SELECT * FROM users WHERE approved=1 ORDER BY id DESC";
      $query = $this->db->pdo->prepare($sql);
      $query->execute();
      $result = $query->fetchAll();
      return $result;
   }

   public function getNotApprovedUserData(){
      $sql = "SELECT * FROM users WHERE approved<>1 ORDER BY id DESC";
      $query = $this->db->pdo->prepare($sql);
      $query->execute();
      $result = $query->fetchAll();
      return $result;
   }

       
   public function getUserById($id){
      $sql = "SELECT * FROM users WHERE id= :id LIMIT 1";
      $query = $this->db->pdo->prepare($sql);
      $query->bindValue(':id' , $id);     
      $query->execute();
      $result = $query->fetch(PDO::FETCH_OBJ);
      return $result;
   }


   public function updateUserData($id, $data){
      $first_name = $data['first_name'];
      $last_name = $data['last_name'];
      $email = $data['email'];
 
      if ($first_name == "" OR $last_name == "" OR $email == "" ){
         $msg = "<div class='alert alert-danger'><strong> Error ! </strong>  Fineld must not be empty </div>";
         return $msg;
      }

      $sql = "UPDATE users set
         first_name = :first_name,
         last_name  = :last_name, 
         email      = :email 
         WHERE id = :id";


      $query = $this->db->pdo->prepare($sql);
      $query->bindValue(':first_name' , $first_name);
      $query->bindValue(':last_name' , $last_name);
      $query->bindValue(':email' , $email);
      $query->bindValue(':id' , $id);
      $result = $query->execute();
      if ($result) {
         $msg = "<div class='alert alert-success'><strong> Success ! </strong> User data Updated Successfully   </div>";
         return $msg;
      }
      else{
         $msg = "<div class='alert alert-danger'><strong> Error ! </strong> User data not Updated.   </div>";
         return $msg;
      }

   }


   public function getBookDataCollection($user_id){      
      $sql = "SELECT * FROM books WHERE id IN (SELECT DISTINCT books_id FROM users_books WHERE users_id=" . $user_id. ") ORDER BY id DESC";
      $query = $this->db->pdo->prepare($sql);
      $query->execute();
      $result = $query->fetchAll();
      if(!$result){
         return 0;
      }
      return $result;   
   }

   public function makeAdministrator($user_id){
      $sql = "UPDATE users set is_administrator = :is_administrator WHERE id = :id";

      $query = $this->db->pdo->prepare($sql);
      $query->bindValue(':is_administrator' , 1);
      $query->bindValue(':id' , $user_id);
      $result = $query->execute();
      if ($result){
         return 1;
      }
    }

   public function approveUser($user_id){
      $sql = "UPDATE users set approved = :approved WHERE id = :id";

      $query = $this->db->pdo->prepare($sql);
      $query->bindValue(':approved' , 1);
      $query->bindValue(':id' , $user_id);
      $result = $query->execute();
      if ($result){
         return 1;
      }
   }

   public function is_administrator($logged_user_id){
      $sql = "SELECT `is_administrator` FROM users WHERE id=".$logged_user_id;
      $query = $this->db->pdo->prepare($sql);
       $query->execute();
       $result = $query->fetch();
       return $result['is_administrator'];
    }

}

?> 
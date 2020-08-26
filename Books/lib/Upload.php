<?php
 
 include_once 'Session.php';
 include_once 'Database.php';
 class Upload {
   private $db;
   const MAX_SIZE ="150000";
    
   public $uploadfile;
   public function __construct(){
      $this->db = new Database();
   }

  
   public $file_source_location ;
   public $file_target_location;
   public $file_name_1;
   public $file_size_1; 

   private static $file_name;
   private static $file_type;
   private static $file_size;
   private static $file_tmp;
   private static $file_errors;
   private static $allowed_types=array("image/jpg", "image/jpeg", "image/png", "image/gif");

   public static function upload_file($filenames)
      {
      if($_FILES['image']['error']==0)
         {
          self::$file_name = $filenames;
         }
         return self::$file_name;
      }
    
    public static function is_allowed_type($filetypes)
      {
    
      if($_FILES['image']['error']== 0 && in_array($filetypes , self::$allowed_types))
         {
          self::$file_type = $filetypes;
         }
    
      else
         {
          throw new Exception('File Type Is Not An Allowed Type Please Only Upload Files that are Allowed Types');
         }
         return self::$file_type;
      }
    
    public static function is_allowed_size($filesizes)
    {
       if($filesizes < self::MAX_SIZE)
       {
          self::$file_size = $filesizes;
       }
    
       elseif($filesizes > self::MAX_SIZE )
       {
          throw new Exception('Fatal Error Filesize is to large');
       }
    
       return self::$file_size;
    }
    
    
    public static function upload_error($fileerror)
    {
       if($_FILES['image']['error'] != 0)
       {
          trigger_error('Fatal File Upload Error Type:'. print_r($_FILES['error']));
       }
    }
    
   //  public static function file_uploaded($filetmpname)
   //  {
   //     if(is_uploaded_file($filetmpname))
   //     {
   //        self::$file_tmp = $filetmpname;
   //        move_uploaded_file(self::$file_name , "uploads/");
   //     }
   //     return self::$file_tmp;
   //  }
    
   


 }

?> 
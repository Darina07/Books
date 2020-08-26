
<?php include 'inc/header.php';
	  include 'lib/User.php';
	  include 'lib/Book.php';
	  include_once 'lib/Upload.php';
	  include_once 'protection.php';
; 
  Session::checkSession();
  $user = new User();
  $_POST = clean( $_POST, 'addslashes');
?>

<?php 
$logged_user_id = Session::get("id");
$is_administrator = $user->is_administrator($logged_user_id);


$deleteBook_text = '';
if (isset($_GET['id'])) {
	$book_id = (int)$_GET['id'];
}
   $book = new Book();
   // UPDATE
   if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update'])){
    	$updateBook = $book->updateBookData($book_id, $_POST);
	}
	
	// DELETE
	if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete'])){
		$deleteBook = $book->deleteBookData($book_id, $_POST);
		$deleteBook_text = 'The book is deleted.';
		//var_dump($deleteBook_text);
    }
?>



<div class="panel panel-default">
	<div class="panel-heading">
		<h2>Book  <span class="pull-right"><a class="btn btn-primary" href="index.php">Back </a></span></h2>
</div>


<div class="panel-body">
<?php
if($deleteBook_text){
	?>
	<div style="color:red"> <b><?php echo $deleteBook_text ?> </b></div>
	<?php
}
?>
	<div style="max-width: 600px; margin: 0 auto">
<?php   
if (isset($updateBook)){
	echo $updateBook;
}
?>




<?php   
  $bookdata = $book->getBookById($book_id);
  if ($bookdata) {


?>

	 <form action="" method="POST" enctype="multipart/form-data">
	 	<div class="form-group">
	 		<label for="name"> Name </label>
	 		<input type="text" id="name" name="name" class="form-control" value="<?php echo $bookdata->name; ?>" />
	 	</div>



	<div class="form-group">
	 		<label for="isbn"> ISBN </label>
	 		<input type="text" id="isbn" name="isbn" class="form-control" value="<?php echo $bookdata->isbn; ?>" />
	 	</div>



	<div class="form-group">
	 		<label for="description"> Description </label>
			 <textarea id="description" name="description" class="form-control" rows="4" cols="50">
			 	<?php echo $bookdata->description; ?>
			 </textarea>
	 	</div>

	<div class="form-group">
	 		<label for="image"> Image </label>
	 		<input type="file" id="image" name="image" class="form-control" value="<?php echo $bookdata->image; ?>" />

			 <img  src="uploads/<?php echo $bookdata->image; ?>" width="" height="80">
			 <?php
				if($bookdata->image){
			?>
			<input type="hidden"  name="oimage" id="oimage" class="form-control" value="<?php echo $bookdata->image; ?>"  />
			<?php
				}
			 ?>
	 	</div>


 

<?php   
 $sesId = Session::get("id");
 if ($sesId && $is_administrator){

?>
<button type="submit" name="update" class="btn btn-success"> Update </button>
<button type="submit" name="delete" class="btn btn-error"> Delete </button>
<?php   }  ?>

	</div>
	 </form>

	 <?php } ?>

</div>

 </div>

<?php include 'inc/footer.php'; ?>

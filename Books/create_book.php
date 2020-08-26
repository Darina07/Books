
<?php include 'inc/header.php'; 
   include 'lib/Book.php';
   include_once 'lib/Upload.php';
   include_once 'protection.php';
?>
<?php
	$book = new Book();
	$_POST = clean( $_POST, 'addslashes');

	
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_book'])){
    	$bookCreate = $book->createBook($_POST);
    }
?>


<div class="panel panel-default">
	<div class="panel-heading">
		<h2>Add New Book </h2>
</div>

<div class="panel-body">
	<div style="max-width: 600px; margin: 0 auto">

<?php
 if (isset($bookCreate)){
 	echo $bookCreate;
 }
?>



	 <form enctype="multipart/form-data" action="" method="POST">
	 	<div class="form-group">
	 		<label for="name"> Name </label>
	 		<input type="text" id="name" name="name" class="form-control"   />
	 	</div>



	<div class="form-group">
	 		<label for="isbn"> ISBN </label>
	 		<input type="text" id="isbn" name="isbn" class="form-control"  />
	 	</div>



	<div class="form-group">
	 		<label for="description"> Description </label>
	 		<textarea id="description" name="description" class="form-control">  </textarea>
	 	</div>



	 	<div class="form-group">
	 		<label for="image"> Image </label>
	 		<input type="file" id="image" name="image" class="form-control"  />
	 	</div>

	


<button type="submit" name="add_book" class="btn btn-success"> Submit </button>
	</div>
	 </form>

</div>

 </div>

<?php include 'inc/footer.php'; ?>

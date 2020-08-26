
<?php include 'inc/header.php'; 
	  include 'lib/User.php';
	  include 'lib/Book.php';
	  include 'lib/UserBook.php';
	  include_once 'protection.php';
      Session::checkSession();
	  $user = new User();
	  $userBook = new UserBook();

	  $_POST = clean( $_POST, 'addslashes');
?>

<?php
  $loginmsg = Session::get("loginmsg");
  if (isset($loginmsg)) {
  	echo $loginmsg;
  }
  Session::set("loginmsg" , NULL);

  $userId = Session::get("id");

  

  if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_GET['books_id']) && $_GET['users_id'] ){
	$_GET['books_id'] = (int)$_GET['books_id'];
	$_GET['users_id'] = (int)$_GET['users_id'];

	$book_added = $userBook->addCollection($_GET['users_id'], $_GET['books_id']);

	if($book_added){
		echo '<h4>The book was added in the collection</h4>';
	}
  }


  if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_GET['book_id'])){
	  $_GET['book_id'] = (int)$_GET['book_id'];
	  $book_removed = $userBook->removeBook($userId, $_GET['book_id']);
	 
  }
?>






 <div class="panel panel-default">
	<div class="panel-heading">
		<h2>My Book Collection </h2>
	</div>
	<div class="panel-body">
	<table class="table table-striped">
		
		<th width="20%"> Name </th>
		<th width="20%"> ISBN </th>
		<th width="20%"> Description </th>
		<th width="20%"> Image </th>
		<th width="10%"> Action </th>
		<th width="10%"> Remove from MyCollection </th>


<?php 
		$book = new Book();
		$user = new User();
        $bookdata = $user->getBookDataCollection($userId);
        if ($bookdata) {
        	$i = 0;
        	foreach ($bookdata as $sdata) {
        	    $i++;
    
?>
<tr>
		
		<td><?php echo $sdata['name'] ?>      </td>
		<td><?php echo $sdata['isbn'] ?></td>
		<td><?php echo $sdata['description'] ?></td>
		<td>
			<img src="uploads/<?php echo $sdata['image'] ?>" width="" height="80">
		</td>
        <td><a class="btn btn-primary" href="book.php?id=<?php echo $sdata['id']; ?>">View </a></td>
		<form action="collection.php?book_id=<?php echo $sdata['id']; ?>" method="POST">
		<td><button type="submit" name="add" class="btn btn-primary">REMOVE</button></td>
		</form>
		
</tr>

<?php     	}     } else { ?>

<tr>
	<td colspan="5"><h2> No books in my BookCollection</h2></td>
</tr>


<?php  }  ?>
 


	</table>

</div>

 </div>

<?php include 'inc/footer.php'; ?>

<?php include 'inc/header.php'; 
	  include 'lib/User.php';
	  include 'lib/Book.php';
	  include 'lib/UserBook.php';
	  include_once 'protection.php';
      Session::checkSession();
	  $user = new User();
	  
	  $_POST = clean( $_POST, 'addslashes');
?>

<?php
$logged_user_id = Session::get("id");
$is_administrator = $user->is_administrator($logged_user_id);
//var_dump($is_administrator);

  $loginmsg = Session::get("loginmsg");
  if (isset($loginmsg)) {
  	echo $loginmsg;
  }
  Session::set("loginmsg" , NULL);

?>


 <div class="panel panel-default">
	<div class="panel-heading">
		<h2>Book List 
  			<?php
			if($is_administrator){
			  ?>
			<span class="pull-right"><a href="/login/create_book.php"><button type="button" style="background-color: white; color: black; border: 2px solid #008CBA;">Add New Book</button></a></span>
			<?php
			}
			  ?>
		</h2>
	</div>
	<div class="panel-body">
	<table class="table table-striped">
		
		<th width="20%"> Name </th>
		<th width="20%"> ISBN </th>
		<th width="20%"> Description </th>
		<th width="20%"> Image </th>
		<th width="10%"> Action </th>
		<th width="10%"> Add to MyCollection </th>


<?php 
        $book = new Book();
        $bookdata = $book->getBookData();
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
		<?php
		$user_id = Session::get("id");
		$user_book = new UserBook();
		if($user_book->inUserCollection($user_id, $sdata['id'])){
			?>
			<td>In My Book Collection</td>
			<?php
		}
		else{
	
		?>
		<form action="collection.php?books_id=<?php echo $sdata['id']; ?>&users_id=<?php echo $user_id; ?>" method="POST">
		<td><button type="submit" name="add" class="btn btn-primary">ADD</button></td>
		</form>
		
</tr>

<?php     	}
				}     } else { ?>

<tr>
	<td colspan="5"><h2> No Book Data Found </h2></td>
</tr>


<?php  }  ?>
 


	</table>

</div>

 </div>

<?php include 'inc/footer.php'; ?>

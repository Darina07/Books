
<?php include 'inc/header.php';
	  include 'lib/User.php';
	  include_once 'protection.php';
; 
  Session::checkSession();

  $_POST = clean( $_POST, 'addslashes');
?>

<?php 
if (isset($_GET['id'])) {
	$userid = (int)$_GET['id'];
}
   $user = new User();
   if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update'])){
    	$updateusr = $user->updateUserData($userid, $_POST);
    }
?>



<div class="panel panel-default">
	<div class="panel-heading">
		<h2>User Profile  <span class="pull-right"><a class="btn btn-primary" href="users.php">Back </a></span></h2>
</div>


<div class="panel-body">
	<div style="max-width: 600px; margin: 0 auto">
<?php   
if (isset($updateusr)){
	echo $updateusr;
}
?>


<?php   
  $userdata = $user->getUserById($userid);
  if ($userdata) {


?>

	 <form action="" method="POST">
	 	<div class="form-group">
	 		<label for="first_name"> First Name </label>
	 		<input type="text" id="first_name" name="first_name" class="form-control" value="<?php echo $userdata->first_name; ?>" />
	 	</div>



	<div class="form-group">
	 		<label for="last_name"> Last Name </label>
	 		<input type="text" id="last_name" name="last_name" class="form-control" value="<?php echo $userdata->last_name; ?>" />
	 	</div>



	<div class="form-group">
	 		<label for="email"> Email Address </label>
	 		<input type="text" id="email" name="email" class="form-control" value="<?php echo $userdata->email; ?>" />
	 	</div>


 

<?php   
 $sesId = Session::get("id");
 if ($userid == $sesId){

?>
<button type="submit" name="update" class="btn btn-success"> Update </button>
<?php   }  ?>

	</div>
	 </form>

	 <?php } ?>

</div>

 </div>

<?php include 'inc/footer.php'; ?>

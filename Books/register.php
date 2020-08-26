
<?php include 'inc/header.php'; 
   include 'lib/User.php';
   include_once 'protection.php';
?>
<?php
	$_POST = clean( $_POST, 'addslashes');
	
    $user = new User();
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['register'])){
    	$usrRegi = $user->userRegistration($_POST);
    }
?>


<div class="panel panel-default">
	<div class="panel-heading">
		<h2>User Registration </h2>
</div>

<div class="panel-body">
	<div style="max-width: 600px; margin: 0 auto">

<?php
 if (isset($usrRegi)){
 	echo $usrRegi;
 }
?>



	 <form action="" method="POST">
	 	<div class="form-group">
	 		<label for="first_name"> Fist Name </label>
	 		<input type="text" id="first_name" name="first_name" class="form-control"   />
	 	</div>



	<div class="form-group">
	 		<label for="last_name"> Last Name </label>
	 		<input type="text" id="last_name" name="last_name" class="form-control"  />
	 	</div>



	<div class="form-group">
	 		<label for="email"> Email Address </label>
	 		<input type="text" id="email" name="email" class="form-control"   />
	 	</div>



	 	<div class="form-group">
	 		<label for="password"> Password </label>
	 		<input type="password" id="password" name="password" class="form-control"  />
	 	</div>

		 <div class="form-group">
	 		<label for="active"> Active </label>
	 		<input type="checkbox" id="active" name="active" value="1" class="form-control"   />
	 	</div>


<button type="submit" name="register" class="btn btn-success"> Submit </button>
	</div>
	 </form>

</div>

 </div>

<?php include 'inc/footer.php'; ?>

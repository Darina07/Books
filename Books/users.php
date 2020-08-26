
<?php include 'inc/header.php'; 
	  include 'lib/User.php';
	  include_once 'protection.php';
      Session::checkSession();
	  $user = new User();
	  
	  $_POST = clean( $_POST, 'addslashes');
?>

<?php
  $loginmsg = Session::get("loginmsg");
  if (isset($loginmsg)) {
  	echo $loginmsg;
  }
  Session::set("loginmsg" , NULL);



if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_GET['user_id'])){
	$_GET['user_id'] = (int)$_GET['user_id'];
	$user_approved = $user->approveUser($_GET['user_id']);
}

if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_GET['administrator_id'])){
	$_GET['administrator_id'] = (int)$_GET['administrator_id'];
	$user->makeAdministrator($_GET['administrator_id']);
}


?>


<div class="panel panel-default">
	<div class="panel-heading">
		<h2>User List <span class="pull-right">Welcome<strong> 

		 <?php   $first_name = Session::get("first_name");
		      if (isset($first_name)) {
		      	echo $first_name;
		      }
?></strong> 

		 </span></h2>
</div>

<div class="panel-body">
	<table class="table table-striped">
		
		<th width="20%"> Fisrt Name </th>
		<th width="20%"> Last Name </th>
		<th width="20%"> Email Address </th>
		<th width="20%"> Active </th>
		<th width="20%"> Action </th>
<?php
$logged_user_id = Session::get("id");
$is_administrator = $user->is_administrator($logged_user_id);
if($is_administrator ==1 ){
?>

		<th width="10%"> Mark as administrator </th>
	

<?php 
	}
        $user = new User();
        $userdata = $user->getUserData();
        if ($userdata) {
        	$i = 0;
        	foreach ($userdata as $sdata) {
        	    $i++;
    
?>
<tr>
		
		<td><?php echo $sdata['first_name'] ?>      </td>
		<td><?php echo $sdata['last_name'] ?></td>
		<td><?php echo $sdata['email'] ?></td>
		<td>
			<?php if($sdata['active']==1){
				echo 'YES';
			}else{
				echo 'NO';
			} ?>
		</td>
        <td><a class="btn btn-primary" href="profile.php?id=<?php echo $sdata['id']; ?>">View </a></td>
<?php
if($is_administrator ==1){
	$is_administrator_this = $user->is_administrator($sdata['id']);
	if($is_administrator_this==1){
		?>
	<th>Administrator</td>
		<?php
	}
	else{
		
?>
<form action="users.php?administrator_id=<?php echo $sdata['id']; ?>" method="POST">
		<td><button type="submit" name="delete" class="btn btn-error">MakeAdministrator</button></td>
		</form>
		<?php
	}
			}
		?>
		
</tr>

<?php     	}     } else { ?>

<tr>
	<td colspan="5"><h2> No user Data Found </h2></td>
</tr>


<?php  }  ?>
 


	</table>

</div>






<?php
$logged_user_id = Session::get("id");
$is_administrator = $user->is_administrator($logged_user_id);
if($is_administrator ==1 ){
?>

<div class="panel panel-default">
	<div class="panel-heading">
		<h3>Users Waiting for Approval </h3>
</div>

<div class="panel-body">
	<table class="table table-striped">
		
		<th width="20%"> Fisrt Name </th>
		<th width="20%"> Last Name </th>
		<th width="20%"> Email Address </th>
		<th width="20%"> Active </th>
		<th width="10%"> Action </th>
		<th width="10%"> Approve </th>
		


<?php 
        $user = new User();
        $userdata = $user->getNotApprovedUserData();
        if ($userdata) {
        	$i = 0;
        	foreach ($userdata as $sdata) {
        	    $i++;
    
?>
<tr>
		
		<td><?php echo $sdata['first_name'] ?>      </td>
		<td><?php echo $sdata['last_name'] ?></td>
		<td><?php echo $sdata['email'] ?></td>
		<td>
			<?php if($sdata['active']==1){
				echo 'YES';
			}else{
				echo 'NO';
			} ?>
		</td>
        <td><a class="btn btn-primary" href="profile.php?id=<?php echo $sdata['id']; ?>">View </a></td>

		<form action="users.php?user_id=<?php echo $sdata['id']; ?>" method="POST">
		<td><button class="btn btn-primary" type="submit">APPROVE </button></td>
		</form>
</tr>

<?php     	}     } else { ?>

<tr>
	<td colspan="5"><h2> No users waiting for approval. </h2></td>
</tr>


<?php  }  ?>
 


	</table>

</div>

<?php
}
?>
 
 </div>

<?php include 'inc/footer.php'; ?>

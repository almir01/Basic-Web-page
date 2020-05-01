
<?php  require "includes/head.php"; ?>

<body>
<?php require 'includes/connection.php'; ?>

<?php require 'includes/nav.php'; ?>



<?php

if (isset($_POST['submit'])) {
	
		$username = mysqli_real_escape_string($conn, $_POST['username']);
		$password = mysqli_real_escape_string($conn, $_POST['pass']);

		///prepare statement

		$sql = "SELECT username, password FROM users WHERE username = ?"; 

		if ($stmt = mysqli_prepare($conn, $sql)) { 

				//bind parameters
				mysqli_stmt_bind_param($stmt, 's', $username);

				//execute prepared statement
				if(mysqli_stmt_execute($stmt)) {

						//store result
						mysqli_stmt_store_result($stmt);

						//check if username exist , if yes verify password

						if (mysqli_stmt_num_rows($stmt) == 1) {
							
								//bind result variable
								mysqli_stmt_bind_result($stmt, $username, $hashed_password);

								if (mysqli_stmt_fetch($stmt)) {
										if (password_verify($password, $hashed_password)) {
											
											//password is correct , sstart a new session
											session_start();

											$_SESSION['username'] = $username;
											header("Location: index.php");

										}else {

										echo "Paasword is incorrect";
								
									}
								}
							//username does not exist	
						}else{

						echo 'Username is invalid';
					}
							mysqli_stmt_close($stmt);		
				}
				
				
		}

		mysqli_close($conn);
}



	if (isset($_SESSION['username'])) {
		header("Location: index.php");
	}else{
		echo'<div id="container">
		
		<form id="form1" action="login.php" method="POST">
			<div>
				<div>
					<label for="username">Username</label>
					<input type="text" name="username" placeholder="Your username" required>
				</div>
				<div>
					<label for="password">Password
					<input type="password" name="pass" placeholder="Your password" required>
				</div>
				<div>
					<label>
					<input type="submit" name="submit" id="sub" value="Login">
					</label>
				</div>
				<p class="bottom"> You dont have  an account? <a href="register.php"> <strong>Create account </strong><a>or go <a href="index.php"> <strong>Home </strong><a></p>
			</div>
		</form>';

	}
?>

<?php require 'includes/footer.php';
/*
<?php  require "includes/head.php"; ?>

<body>
	
	<?php require 'includes/nav.php'; ?>

	<div id="container">
		
		<form id="form1" action="includes/login.inc.php" method="POST">
			<div>
				<div>
					<label for="username">Username</label>
					<input type="text" name="username" placeholder="Your username" required>
				</div>
				<div>
					<label for="password">Password
					<input type="password" name="pass" placeholder="Your password" required>
				</div>
				<div>
					<label>
					<input type="submit" name="login" value="Login">
					</label>
				</div>
				<p class="bottom"> You dont have  an account? <a href="register.php"> <strong>Create account </strong><a>or go <a href="index.php"> <strong>Home </strong><a></p>
			</div>
		</form>




	</div>

<?php require "includes/footer.php" ?>

-->*/
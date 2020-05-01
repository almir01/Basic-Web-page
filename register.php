<?php  require "includes/head.php"; ?>
<?php include_once "includes/connection.php"; ?>

<body>
	
	<?php require 'includes/nav.php'; ?>

	<div id="container1">
		


<?php
//include  connection file

require_once 'includes/connection.php';

if(isset($_POST['login-submit'])) {
	//validate user
		$username = mysqli_real_escape_string($conn, $_POST['username']);
		$password = mysqli_real_escape_string($conn, $_POST['pass']);
		$passRepeat =mysqli_real_escape_string($conn, $_POST['pass2']);

		//Validate user
		if (empty(trim($username))) {
			echo "Please eneter a username";
		}else {
			//Prepare celect statement
			
			
				$sql = "SELECT id FROM users WHERE username = ?";

				if ($stmt= mysqli_prepare($conn, $sql)) {
					//Bind variables to the prepared statements as parameters
						mysqli_stmt_bind_param($stmt, 's', $username);

						//Attempt to execute prepared statement

						if(mysqli_stmt_execute($stmt)){
							//Store result
								mysqli_stmt_store_result($stmt);

								if (mysqli_stmt_num_rows($stmt) > 0) {

									echo 'This username is already taken';
									
								}else if (strlen(trim($password)) < 6 || $password !== $passRepeat) {
									echo 'Password must have  at least 6 characters or Password did not match';
									
								}else {

										$sql = "INSERT INTO users (username, password) VALUES (?, ?)";
									
									if ($stmt = mysqli_prepare($conn, $sql)) {
										//Bind  variable

											mysqli_stmt_bind_param($stmt, "ss", $username, $hashed_password);
											
											$hashed_password = password_hash($password, PASSWORD_DEFAULT);

												if (mysqli_stmt_execute($stmt))  {

													echo "Korisnik je registrovan";
												}else{
													echo "Error inserting data";
											}

										
									}

									mysqli_stmt_close($stmt);
								}
							
						}else {

								echo "Something went wrong";
							mysqli_stmt_close($stmt);
						}
						//Close statement
						
				}

				
		}
	

	mysqli_close($conn);

}

?>

<?php 
	
	if (isset($_SESSION['username'])) {
		header("Location: index.php");
	}else {
		echo'

<div id="container1">

	<form id="form1" action ="register.php"  method="POST">
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
				<label for="repeat-password">Password
					<input type="password" name="pass2" placeholder="Repeat password" required>
			</div>

			<div>
				<label>
					<input type="submit" name="login-submit" id="sub" value="Create account">
				</label>

				<p class="bottom"> Back to  <a href="login.php"> <strong>Login page </strong><a> or go
					<a href="index.php"> <strong> Home </strong><a></p>
			</div>

		</div>
	</form>

</div>';
}
?>

<?php require 'includes/footer.php' ?>
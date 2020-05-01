<?php  require "includes/head.php"; ?>

<?php require 'includes/nav.php'; ?>

<?php 

if (isset($_SESSION['username'])) {
 
echo '<nav>
				| <a href="index.php"><li>Go back</li></a> |
		</nav>';

?>


<?php require 'includes/footer.php';
	
	}else{

		header("Location: index.php");
	}






			

	
	

?>
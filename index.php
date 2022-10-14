<?php 

include 'config.php';

error_reporting(0);

session_start();

if (isset($_SESSION['username'])) {
    header("Location: index.php");
}


if (isset($_POST['submit'])) {
	$username = test_input($_POST['username']);
	$email = test_input(filter_var($_POST['email'], FILTER_VALIDATE_EMAIL));
	$password = test_input(md5($_POST['password']));
	$cpassword = test_input(md5($_POST['cpassword']));

	if ($password == $cpassword) {
		$sql = "SELECT * FROM users WHERE email='$email'";
		$result = mysqli_query($conn, $sql);
		if (!$result->num_rows > 0) {
			$sql = "INSERT INTO users (username, email, password)
					VALUES ('$username', '$email', '$password')";
			$result = mysqli_query($conn, $sql);
			if ($result) {
				echo "<script>alert('Wow! User Registration Completed.')</script>";
				$username = "";
				$email = "";
				$_POST['password'] = "";
				$_POST['cpassword'] = "";
				header("Location: index.php");
			} else {
				echo "<script>alert('Woops! Something Wrong Went.')</script>";
			}
		} else {
			echo "<script>alert('Woops! Email Already Exists.')</script>";
		}
		
	} else {
		echo "<script>alert('Password Not Matched.')</script>";
	}
}
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="wrapper">
        <h2>Registration</h2>
        <form action="" method="POST">
            <div class="input-box">
                <input type="text" placeholder="Enter Your Name" name="username" value="<?php echo $username; ?>" required>
            </div>
            <div class="input-box">
                <p><?php echo $emailErr ?></p>
                <input type="text" placeholder="Enter Your Email" name="email" value="<?php echo $email; ?>" required>
            </div>
            <div class="input-box">
                <input type="password" placeholder="Create Password" name="password" value="<?php echo $_POST['password']; ?>" required>
            </div>
            <div class="input-box">
                <input type="password" placeholder="Confirm Password" name="cpassword" value="<?php echo $_POST['cpassword']; ?>" required>
            </div>
            <div class="policy">
                <input type="checkbox" >
                <h3>I Accept all terms & Conditions</h3>
            </div>
            <div class="input-box button">
                <input type="submit" name="submit" value="Register Now">
            </div>
            <div class="text">
                <h3>Already have an Account? <a href="login.php">Login Now</a></h3>
            </div>
        </form>

    </div>
</body>
</html>
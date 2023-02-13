<?php

include './database/config.php';
error_reporting(0);

session_start();

if (isset($_SESSION['username'])) {
    header("Location: user_home.php");
}

if (isset($_POST['submit'])) {

    $username = $_POST['username'];
    $email = $_POST['email'];
	$password = md5($_POST['password']);
	$cpassword = md5($_POST['cpassword']);
	$p = $_POST['password'];
    $error = "";
    $cls="";

    if ($password == $cpassword) {
            if (strlen($p) > 5) {

                $query = "SELECT * FROM users WHERE username = '$username'";
                $query_run = mysqli_query($conn, $query);

                if (!$query_run->num_rows > 0) {
                    $query = "SELECT * FROM users WHERE username = '$username' AND email = '$email'";
                    $query_run = mysqli_query($conn, $query);

                    if(!$query_run->num_rows > 0){
                        $query2 = "INSERT INTO users(username,email,`password`)
                        VALUES ('$username', '$email', '$password')";
                        $query_run2 = mysqli_query($conn, $query2);

                        if ($query_run2) {
                            $_SESSION['username'] = $_POST['username'];
							mkdir("ide"."/".$username, 0777);
                            echo "<script> alert('Regestration Successfull.');
                            window.location.href='user_login.php';
                            </script>";
                            
                        } 
                        else {
                            $error = mysqli_error($conn);
                            $cls="danger";

                        }
                    }
                    else{
                        $error = "User Already Exists";
                        $cls="danger";

                    }

                } 
                else {
                    $error = "Username Already Exists";
                    $cls="danger";

                }
            } 
            else {
                $error =  "Password has to be minimum of 6 charecters";
                $cls="danger";

            }
    } 
    else {
        $error = 'Passwords did not Matched.';
        $cls="danger";

    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
	<title>Livecode - Online Code Compiler</title>

	<!-- Meta -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<!-- FontAwesome JS-->
	<script defer src="plugins/fontawesome/js/all.min.js"></script>

	<!-- App CSS -->
	<link id="theme-style" rel="stylesheet" href="css/portal.css">

</head>

<body class="app app-signup p-0">
	<div class="row g-0 app-auth-wrapper">
		<div class="col-12 col-md-7 col-lg-6 auth-main-col text-center p-5" style="margin-top:50px;">
			<div class="d-flex flex-column align-content-end">
				<div class="app-auth-body mx-auto">
					<h2 class="auth-heading text-center mb-4">Sign Up</h2>

					<div class="auth-form-container text-start mx-auto">
						<form class="auth-form auth-signup-form" action="" method="POST">
							<div class="alert alert-<?php echo $cls;?>" style="padding:10px;">
								<?php 
                                    if (isset($_POST['submit'])){
                                        echo $error;
                                    }
                                ?>
							</div>
							<div class="email mb-3">
								<label class="sr-only" for="username">Username</label>
								<input id="signup-name" name="username" type="text" class="form-control signup-name"
									placeholder="Username" required="required">
							</div>
							<div class="email mb-3">
								<label class="sr-only" for="email">Your Email</label>
								<input id="signup-email" name="email" type="email" class="form-control signup-email"
									placeholder="Email" required="required">
							</div>
							<div class="password mb-3">
								<label class="sr-only" for="password">Password</label>
								<input id="signup-password" name="password" type="password"
									class="form-control signup-password" placeholder="Password" required="required">
							</div>
							<div class="password mb-3">
								<label class="sr-only" for="cpassword">Confirm Password</label>
								<input id="signup-password" name="cpassword" type="password"
									class="form-control signup-password" placeholder="Confirm password"
									required="required">
							</div>
							<div class="extra mb-3">
								<div class="form-check">
									<input class="form-check-input" type="checkbox" value="" id="RememberPassword">
									<label class="form-check-label" for="RememberPassword">
										I agree to Portal's <a href="#" class="app-link">Terms of Service</a> and <a
											href="#" class="app-link">Privacy Policy</a>.
									</label>
								</div>
							</div>
							<!--//extra-->

							<div class="text-center">
								<button type="submit" name="submit" class="btn app-btn-primary w-100 theme-btn mx-auto">Sign
									Up</button>
							</div>
						</form>
						<!--//auth-form-->

						<div class="auth-option text-center pt-5">Already have an account? <a class="text-link"
								href="user_login.php">Log in</a></div>
					</div>
					<!--//auth-form-container-->



				</div>
				<!--//auth-body-->
			</div>
			<!--//flex-column-->
		</div>
		<!--//auth-main-col-->
		<div class="col-12 col-md-5 col-lg-6 h-100 auth-background-col">
			<div class="auth-background-holder">
			</div>
			<div class="auth-background-mask"></div>
			<div class="auth-background-overlay p-3 p-lg-5">
			</div>
			<!--//auth-background-overlay-->
		</div>
		<!--//auth-background-col-->

	</div>
	<!--//row-->


</body>

</html>
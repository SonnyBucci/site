<?php
session_start();
require_once "/var/www/skyysystems.com/public_html/assets/db.php";

if(isset($_SESSION['user_session']))
{
    header("Location: home.php");
}

if(isset($_POST['btn-signup']))
{
	$uname = strip_tags($_POST['txt_uname']);
	$umail = strip_tags($_POST['txt_umail']);
	$upass = strip_tags($_POST['txt_upass']);	
	
	if($uname=="")	{
		$error[] = "provide username !";	
	}
	else if($umail=="")	{
		$error[] = "provide email id !";	
	}
	else if(!filter_var($umail, FILTER_VALIDATE_EMAIL))	{
	    $error[] = 'Please enter a valid email address !';
	}
	else if($upass=="")	{
		$error[] = "provide password !";
	}
	else if(strlen($upass) < 6){
		$error[] = "Password must be atleast 6 characters";	
	}
	else
	{
		try
		{
			$query = $db->prepare("SELECT username, email FROM users WHERE username=? OR email=?");
			$query->execute([$uname,$umail]);
			$result = $query->fetch(PDO::FETCH_ASSOC);

			if($result['username']==$uname) {
				$error[] = "sorry username already taken !";
			}
			else if($result['email']==$umail) {
				$error[] = "sorry email id already taken !";
			}
			else
			{
				$new_password = password_hash($upass, PASSWORD_DEFAULT);
				$query = $db->prepare("INSERT INTO users(username,email,password) VALUES(:uname, :umail, :upass)");						
				$query->bindparam(":uname", $uname);
				$query->bindparam(":umail", $umail);
				$query->bindparam(":upass", $new_password);										  
				$query->execute();					

				if($query)
					header("Location: sign-up.php?joined");
			}
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();
		}
	}	
}

?>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Asia Direct ERP | Sign Up</title>
    <script src='/assets/jquery-3.3.1.min.js' language='javascript'></script>
    <script src="/assets/bootstrap/js/popper.min.js"></script>
    <script src="/assets/bootstrap/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="/assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="/assets/spunky.css">
</head>
<body>
	<div class="signin-form">
		<div class="container">
			<form method="post" class="form-signin">
				<h2 class="form-signin-heading">Sign up.</h2><hr />
				<?php
				if(isset($error))
				{
					foreach($error as $error)
						echo "<div class='alert alert-danger'> $error </div>";
				}else if(isset($_GET['joined']))
				{
					echo "<div class='alert alert-info'> Successfully registered: <a href='../index.php'>click here to login</a>  </div>";
				}
				?>
				<div class="form-group">
				<input type="text" class="form-control" name="txt_uname" placeholder="Enter Username" value="<?php if(isset($error)){echo $uname;}?>" />
				</div>
				<div class="form-group">
				<input type="text" class="form-control" name="txt_umail" placeholder="Enter E-Mail ID" value="<?php if(isset($error)){echo $umail;}?>" />
				</div>
				<div class="form-group">
					<input type="password" class="form-control" name="txt_upass" placeholder="Enter Password" />
				</div>
				
				<div class="form-group">
					<button type="submit" class="btn btn-primary" name="btn-signup">SIGN UP</button>
				</div>
				<label>Have an account? <a href="../index.php">Sign In</a></label>
			</form>
		</div>
	</div>
</body>
</html>
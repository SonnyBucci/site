<?php
session_start();
require_once "/var/www/skyysystems.com/public_html/assets/db.php";

if(isset($_SESSION['user_session']))
{
    header("Location: home.php");
}

if(isset($_POST['btn-login']))
{
	$uname = strip_tags($_POST['txt_uname_email']);
	$umail = strip_tags($_POST['txt_uname_email']);
    $upass = strip_tags($_POST['txt_password']);
    
    $query = $db->prepare("SELECT id, `password` FROM users WHERE username = ? OR email = ? ");
    $query->execute([$uname,$umail]);
    $result = $query->fetch(PDO::FETCH_ASSOC);
    if($query->rowCount() == 1)
    {
        if(password_verify($upass, $result['password']))
        {
            $_SESSION['user_session'] = $result['id']; //SETS user_session to user id
            header("Location: home.php");
        }
        else
        {
            $error = "Wrong Details !";
        }
    }
}
?>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Asia Direct ERP | Login</title>
    <script src='/assets/jquery-3.3.1.min.js' language='javascript'></script>
    <script src="/assets/bootstrap/js/popper.min.js"></script>
    <script src="/assets/bootstrap/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="/assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="/assets/spunky.css">
</head>
<body>
    <div class="signin-form">
        <div class="container">
            <form class="form-signin" method="post" id="login-form">
                <h2 class="form-signin-heading">Log In to Asia Direct ERP</h2><hr />
                <div id="error">
                    <?php
                        if(isset($error))
                            echo "<div class='alert alert-danger'> $error </div>";
                    ?>
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" name="txt_uname_email" placeholder="Username or E mail ID" required />
                    <span id="check-e"></span>
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" name="txt_password" placeholder="Your Password" />
                </div>
            
                <div class="form-group">
                    <button type="submit" name="btn-login" class="btn btn-primary">SIGN IN</button>
                </div> 
            </form>
        </div>
    </div>
</body>
</html>
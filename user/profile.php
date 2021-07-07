<?php
  $tab = "user";
  require_once "/var/www/skyysystems.com/public_html/assets/header.php";
  require_once "/var/www/skyysystems.com/public_html/assets/db.php";
  
  $id = $_SESSION['user_session'];
	$query = $db->prepare("SELECT * FROM users WHERE id=?");
	$query->execute([$id]);
  $result = $query->fetch(PDO::FETCH_ASSOC);
?>
  <div class="container-fluid" style="margin-top:40px;">
    <div class="container">
      <label class="h5">Welcome : <?php print($result['username']); ?></label>
        <hr />
        <h2><a href="/user/editProfile/editProfile.php">Edit Profile</a></h2>
        <p class="h4">Under Construction</p> 
    </div>
  </div>
</body>
</html>
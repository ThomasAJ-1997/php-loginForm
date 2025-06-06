<?php 
session_start();

if(!isset($_SESSION['account_loggedin'])) {
  header('location: login.php');
  exit;
}

$_SESSION['account_name'];

?>

<?php require 'includes/header.php'; ?>

<div class="login-box">
<div class="center">
<h1>Admin Page</h1>
<h3>Welcome <?= $_SESSION['account_name']; ?></h3>
  <a href="logout.php">Sign Out</a>
</div>  
</div>
    
<?php require 'includes/footer.php'; ?>
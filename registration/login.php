<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="style.css" />
    <link
      href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css"
      rel="stylesheet"
    />
</head>
<body>
<?php
require('config.php');
session_start();

if (isset($_POST['username']) && isset($_POST['password'])){
    $username = stripslashes($_REQUEST['username']);
    $username = mysqli_real_escape_string($conn, $username);
    $password = stripslashes($_REQUEST['password']);
    $password = mysqli_real_escape_string($conn, $password);
    
    $query = "SELECT * FROM `users` WHERE username='$username' and password='".hash('sha256', $password)."'";
    $result = mysqli_query($conn, $query) or die(mysql_error());

    if($row = mysqli_fetch_assoc($result)){
        $_SESSION['user_id'] = $row['id'];
        $_SESSION['username'] = $username;
        $_SESSION['role'] = $row['role'];
        header("Location: ../vue/dashboard.php");
    } else {
        $message = "Le nom d'utilisateur ou le mot de passe est incorrect.";
    }
}
?>
<form class="box" action="" method="post" name="login">
<i class='bx bx-run box-logo box-title'></i>
        <span class="logo_name">G-ESAC</span>
<h1 class="box-title">Connexion</h1>
<input type="text" class="box-input" name="username" placeholder="Nom d'utilisateur">
<input type="password" class="box-input" name="password" placeholder="Mot de passe">
<input type="submit" value="Connexion " name="submit" class="box-button">
<p class="box-register">Vous êtes nouveau ici? <a href="register.php">S'inscrire</a></p>
<?php if (! empty($message)) { ?>
    <p class="errorMessage"><?php echo $message; ?></p>
<?php } ?>
</form>
</body>
</html>
<?php

include 'config.php';


function add_user($conn, $name, $email, $raw_pass) {
   $password = md5($raw_pass);
   $sql = "INSERT INTO users (name, email, password, user_type)
           VALUES ('$name', '$email', '$password', 'user')";
   return mysqli_query($conn, $sql);
}

if(isset($_POST['submit'])){

   $name = mysqli_real_escape_string($conn, $_POST['name']);
   $email = mysqli_real_escape_string($conn, $_POST['email']);
   $raw_pass = $_POST['password'];
   $raw_cpass = $_POST['cpassword'];
   $pass = mysqli_real_escape_string($conn, md5($raw_pass));
   $cpass = mysqli_real_escape_string($conn, md5($raw_cpass));
   $user_type = 'user'; 

   
   if (!preg_match("/^[a-zA-Z\s]{3,}$/", $name)) {
      $message[] = 'Name must be at least 3 characters and contain only letters and spaces.';
   }

   if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $message[] = 'Invalid email format.';
   }

   if (!preg_match("/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{6,}$/", $raw_pass)) {
      $message[] = 'Password must be at least 6 characters long and contain both letters and numbers.';
   }

   if ($raw_pass !== $raw_cpass) {
      $message[] = 'Confirm password does not match.';
   }

   if (empty($message)) {
      $select_users = mysqli_query($conn, "SELECT * FROM `users` WHERE email = '$email'") or die('query failed');

      if(mysqli_num_rows($select_users) > 0){
         $message[] = 'User already exists!';
      }else{
         
         add_user($conn, $name, $email, $raw_pass);
         $message[] = 'Registered successfully!';
         header('location:login.php');
         exit;
      }
   }

}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Register</title>

   <!-- Font Awesome -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
   <!-- Custom CSS -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>

<?php
if(isset($message)){
   foreach($message as $msg){
      echo '
      <div class="message">
         <span>'.$msg.'</span>
         <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
      </div>
      ';
   }
}
?>
   
<div class="form-container">
   <form action="" method="post">
      <h3>Register Now</h3>
      <input type="text" name="name" placeholder="Enter your name" required class="box">
      <input type="email" name="email" placeholder="Enter your email" required class="box">
      <input type="password" name="password" placeholder="Enter your password" required class="box">
      <input type="password" name="cpassword" placeholder="Confirm your password" required class="box">
      <input type="hidden" name="user_type" value="user">
      <input type="submit" name="submit" value="Register Now" class="btn">
      <p>Already have an account? <a href="login.php">Login now</a></p>
   </form>
</div>

</body>
</html>

<?php
session_start();

include 'config.php'; // Include the file containing database connection code

$message = array(); // Initialize an empty array for messages

if(isset($_POST['submit'])){
   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING);
   $pass = md5($_POST['pass']);
   $pass = filter_var($pass, FILTER_SANITIZE_STRING);
   $cpass = md5($_POST['cpass']);
   $cpass = filter_var($cpass, FILTER_SANITIZE_STRING);

   // Check if email already exists
   $select = $conn->prepare("SELECT * FROM registerdetails WHERE email = ?");
   $select->execute([$email]);

   if($select->rowCount() > 0){
      $message[] = 'User email already exists!';
   } else {
      if($pass != $cpass){
         $message[] = 'Confirm password not matched!';
      } else {
         // Insert data into registrationdetails table
         $insert = $conn->prepare("INSERT INTO registerdetails (name, email, password) VALUES (?, ?, ?)");
         $insert->execute([$name, $email, $pass]);

         if($insert){
            // Redirect to login page after successful registration
            header('Location: login.php');
            exit();
         } else {
            $message[] = 'Registration failed. Please try again.';
         }
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

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="register.css">

   <script>
      function validateForm() {
         var email = document.getElementById("email").value;
         var password = document.getElementById("pass").value;
         var confirmPassword = document.getElementById("cpass").value;

         // Email validation
         var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
         if (!emailPattern.test(email)) {
            alert("Please enter a valid email address.");
            return false;
         }

         // Password validation
         
         var passwordPattern = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}$/;



         if (!passwordPattern.test(password)) {
            alert("Password must be at least 8 characters long and contain at least one digit, one uppercase letter, and one lowercase letter.");
            return false;
         }

         // Confirm Password validation
         if (password !== confirmPassword) {
            alert("Passwords do not match.");
            return false;
         }

         return true;
      }
   </script>

</head>
<body>

<?php
if(isset($message)){
   foreach($message as $message){
      echo '
      <div class="message">
         <span>'.$message.'</span>
         <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
      </div>
      ';
   }
}
?>
   
<section class="form-container">
   <form action="" enctype="multipart/form-data" method="POST" onsubmit="return validateForm()">
      <h3>Register Now</h3>
      <div class="form-group">
          <input type="text" name="name" id="name" class="box" placeholder="Enter your name" required>
      </div>
      <div class="form-group">
         <input type="email" name="email" id="email" class="box" placeholder="Enter your email" required>
      </div>
      <div class="form-group">
         <input type="password" name="pass" id="pass" class="box" placeholder="Enter your password" required>
      </div>
      <div class="form-group">
          <input type="password" name="cpass" id="cpass" class="box" placeholder="Confirm your password" required>
      </div>
      
      <input type="submit" value="Register Now" class="btn" name="submit"><br>
      <p>Already have an account? <a href="login.php">Login Now</a></p>
   </form>
</section>

</body>
</html>
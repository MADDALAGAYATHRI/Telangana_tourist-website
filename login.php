<?php
// Start session
session_start();

// Check if user is already logged in and the session is active
if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true){
    // Check if last activity time is set
    if(isset($_SESSION['last_activity'])){
        // Calculate the time difference between current time and last activity time
        $inactive_time = time() - $_SESSION['last_activity'];
        
        // If inactive time exceeds 30 seconds, destroy the session and redirect to login page
        if($inactive_time > 30){
            session_unset();    // Unset all session variables
            session_destroy();  // Destroy the session
            header('Location: login.php'); // Redirect to login page
            exit(); // Stop script execution
        }
    }
}

// Update last activity time
$_SESSION['last_activity'] = time();

@include 'config.php';

$message = ""; // Initialize an empty message variable

if(isset($_POST['submit'])){
   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING);
   $pass = md5($_POST['pass']);
   $pass = filter_var($pass, FILTER_SANITIZE_STRING);

   $sql = "SELECT * FROM registerdetails WHERE email = ? AND password = ?";
   $stmt = $conn->prepare($sql);
   $stmt->execute([$email, $pass]);
   $rowCount = $stmt->rowCount();  

   if($rowCount > 0){
      $_SESSION['loggedin'] = true; // Set the session variable to indicate successful login
      $_SESSION['email'] = $email; // Store email in session for later use
      $message = 'Login successful!';
      // Redirect to index.html
      header('Location: index.html');
      exit(); // Ensure that script execution stops after redirection
   } else {
      $message = 'Incorrect email or password!';
   }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Login</title>

   <!-- Font Awesome CDN link -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- Custom CSS file link -->
   <link rel="stylesheet" href="login.css">

   <!-- JavaScript to redirect to login page after 30 seconds of inactivity -->
   <script>
      setTimeout(function(){
         window.location.href = "login.php";
      }, 30000); // 30 seconds
   </script>
</head>
<body>

<?php if($message): ?>
<div class="message">
   <span><?php echo $message; ?></span>
   <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
</div>
<?php endif; ?>
   
<section class="form-container">
   <form action="" method="POST">
      <h3>Login now</h3>
      <div class="input-group">
         <input type="email" name="email" class="box" placeholder="Enter your email" required>
      </div>
      <div class="input-group">
         <input type="password" name="pass" class="box" id="password" placeholder="Enter your password" required>
         <i class="far fa-eye" id="togglePassword"></i>
      </div>
      <input type="submit" value="Login now" class="btn" name="submit">
      <p>Don't have an account? <a href="register.php">Register now</a></p>
   </form>
</section>

<script>
   // Function to toggle password visibility
   document.getElementById("togglePassword").addEventListener("click", function() {
      var passwordInput = document.getElementById("password");
      if (passwordInput.type === "password") {
         passwordInput.type = "text";
         this.classList.remove("far", "fa-eye");
         this.classList.add("far", "fa-eye-slash");
      } else {
         passwordInput.type = "password";
         this.classList.remove("far", "fa-eye-slash");
         this.classList.add("far", "fa-eye");
      }
   });
</script>

</body>
</html>

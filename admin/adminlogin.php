<?php
$serverName = "localhost";
$dbUsername = "root";
$dbPassword = "";
$dbName = "project";

$conn = mysqli_connect($serverName, $dbUsername, $dbPassword, $dbName);
?>

<!DOCTYPE html>
<html>
<head>
<title>Admin Login</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
<style>
/* Add your CSS styles here */
body {
    font-family: Arial, sans-serif;
    background-color: #f2f2f2;
}

.login-form {
    max-width: 350px;
    margin: 50px auto;
    padding: 20px;
    background: #fff;
    border-radius: 5px;
    box-shadow: 0px 0px 10px 0px rgba(0,0,0,0.1);
}

.back-button {
    display: block;
    margin-bottom: 20px;
    color: #333;
    text-decoration: none;
}

.back-button:hover {
    color: #555;
}

h2 {
    font-size: 24px;
    margin-bottom: 20px;
    text-align: center;
}

.input-field {
    position: relative;
    margin-bottom: 20px;
}

.input-field i {
    position: absolute;
    top: 50%;
    left: 15px;
    transform: translateY(-50%);
    color: #999;
}

.input-field input {
    width: calc(100% - 40px);
    padding: 10px 15px;
    padding-left: 40px;
    border: 1px solid #ddd;
    border-radius: 5px;
}

.input-field input:focus {
    outline: none;
    border-color: #6fbced;
}

button {
    width: 100%;
    padding: 10px 0;
    background: #6fbced;
    color: #fff;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

button:hover {
    background: #5ea8cd;
}

.extra {
    margin-top: 15px;
    text-align: center;
}

.extra a {
    color: #6fbced;
    text-decoration: none;
}

.extra a:hover {
    text-decoration: underline;
}
</style>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
</head>
<body>

<div class="login-form">
<a href="../index.html" class="back-button">Back to Home</a>

    <h2>Admin Login</h2>
    <form method="POST">
        <div class="input-field">
            <i class="bi bi-person-circle"></i>
            <input type="text" placeholder="Admin Username" name="AdminName">
        </div>
        <div class="input-field">
            <i class="bi bi-shield-lock"></i>
            <input type="password" placeholder="Password" name="AdminPassword">
        </div>
        
        <button type="submit" name="Signin">Sign In</button>

        <div class="extra">
            <a href="#">Forgot Password ?</a>
            <a href="#">Create an Account</a>
        </div>

    </form>
</div>
<?php
if(isset($_POST['Signin'])){

    $query = "SELECT * FROM `admin_login` WHERE `Admin_Name` = '$_POST[AdminName]'
    AND `Admin_Password` = '$_POST[AdminPassword]'";
    $result = mysqli_query($conn, $query);
    if(mysqli_num_rows($result) == 1){
        session_start();
        $_SESSION['AdminLoginId'] = $_POST['AdminName'];
        header("location: admindashboard.php");
    }
    else{
        echo "Incorrect";
    }
}

?>

</body>
</html>

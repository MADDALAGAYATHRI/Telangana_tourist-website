<?php
// Check if the class is already declared
if (!class_exists('Phppot\Member')) {
    require_once dirname(__FILE__) . '/Model/Member.php'; // Updated require_once statement
}

// Establish database connection
$mysqli = new mysqli("localhost", "root", "", "project");

// Check connection
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Initialize loginResult variable
$loginResult = '';

// Process login
if (!empty($_POST["login-btn"])) {
    $member = new Phppot\Member();
    $loginResult = $member->loginMember($_POST["username"], $_POST["login-password"]); // Assuming loginMember() method accepts username and password as parameters

    if ($loginResult === "Login successful!") {
        // Insert login details into the database
        $username = $_POST["username"];
        $password = $_POST["login-password"];
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT); // Hash the password before storing

        $insertQuery = "INSERT INTO login_details (username, password) VALUES ('$username', '$hashedPassword')";
        if ($mysqli->query($insertQuery) === TRUE) {
            echo "New record created successfully";
        } else {
            echo "Error: " . $insertQuery . "<br>" . $mysqli->error;
        }

        // Redirect to the desired page after successful login
        header("Location: index.html"); // Replace welcome.php with the actual URL of your welcome page
        exit();
    }
}

// Close database connection
$mysqli->close();
?>

<HTML>
<HEAD>
<TITLE>Login</TITLE>
<link href="assets/css/phppot-style.css" type="text/css" rel="stylesheet" />
<link href="assets/css/user-registration.css" type="text/css" rel="stylesheet" />
<script src="vendor/jquery/jquery-3.3.1.js" type="text/javascript"></script>
</HEAD>
<BODY>
    <div class="phppot-container">
        <div class="sign-up-container">
            <div class="login-signup">
                <a href="user-registration.php">Sign up</a>
            </div>
            <div class="signup-align">
                <form name="login" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" onsubmit="return loginValidation()">
                    <div class="signup-heading">Login</div>
                    <?php if (!empty($loginResult)): ?>
                        <div class="error-msg"><?php echo $loginResult; ?></div>
                    <?php endif; ?>
                    <div class="row">
                        <div class="inline-block">
                            <div class="form-label">
                                Username<span class="required error" id="username-info"></span>
                            </div>
                            <input class="input-box-330" type="text" name="username" id="username">
                        </div>
                    </div>
                    <div class="row">
                        <div class="inline-block">
                            <div class="form-label">
                                Password<span class="required error" id="login-password-info"></span>
                            </div>
                            <input class="input-box-330" type="password" name="login-password" id="login-password">
                        </div>
                    </div>
                    <div class="row">
                        <input class="btn" type="submit" name="login-btn" id="login-btn" value="Login">
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function loginValidation() {
            var valid = true;
            $("#username").removeClass("error-field");
            $("#login-password").removeClass("error-field");

            var UserName = $("#username").val();
            var Password = $('#login-password').val();

            $("#username-info").html("").hide();
            $("#login-password-info").html("").hide();

            if (UserName.trim() == "") {
                $("#username-info").html("required.").css("color", "#ee0000").show();
                $("#username").addClass("error-field");
                valid = false;
            }
            if (Password.trim() == "") {
                $("#login-password-info").html("required.").css("color", "#ee0000").show();
                $("#login-password").addClass("error-field");
                valid = false;
            }
            if (valid == false) {
                $('.error-field').first().focus();
            }
            return valid;
        }
    </script>
</BODY>
</HTML>

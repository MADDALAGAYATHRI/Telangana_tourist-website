
<?php
// clear all the session variables and redirect to index.html
session_start();
session_unset();
session_write_close();
$url = "http://localhost/project/index.html"; // Adjust the URL according to your file structure
header("Location: $url");
exit(); // Make sure to exit after redirection
?>

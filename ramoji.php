<?php
// Database connection
$conn = new mysqli('localhost', 'root', '', 'project');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$name = $_POST['name']; // Assuming you're getting this from a form submission
$email = $_POST['email'];
$tickets = $_POST['tickets'];
$date = $_POST['date'];
$time = $_POST['time'];
$adult_tickets = $_POST['adult_tickets'];
$children_tickets = $_POST['children_tickets'];

$sql = "INSERT INTO ramoji (name, email, tickets, date, time, adult_tickets, children_tickets)
        VALUES ('$name', '$email', '$tickets', '$date', '$time', '$adult_tickets', '$children_tickets')";

// Execute the statement
if ($conn->query($sql) === TRUE) {
    // Provide download link for PDF
    $ramoji_id = $conn->insert_id;
    echo '<div style="text-align: center; margin-top: 20px;">';
    echo '<p style="font-size: 18px; color: green;">Successfully registered.</p>';
    echo '<a href="downloadramoji.php?id=' . $ramoji_id . '" style="display: inline-block; padding: 10px 20px; background-color: #007bff; color: #fff; text-decoration: none; border-radius: 5px;">Download Ticket</a>';
    echo '</div>';
} else {
    // Display error message if insertion fails
    echo '<p style="font-size: 18px; color: red; text-align: center;">Error: ' . $conn->error . '</p>';
}

// Close connection
$conn->close();
?>

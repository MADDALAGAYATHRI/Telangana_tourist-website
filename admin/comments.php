<?php
$db = new PDO('mysql:host=localhost;dbname=project', 'root', '');

// Select user data and comments from visitors table
$sql = 'SELECT admin_users.username, visitors.name, visitors.email, visitors.phone, visitors.message, visitors.created_at
        FROM admin_users
        INNER JOIN visitors ON admin_users.username = visitors.username';
$stmt = $db->prepare($sql);
$stmt->execute();
$results = $stmt->fetchAll();

// Close the database connection
$db = null;
?>

<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="./css/adminviewusers.css">
</head>
<body>

<h1>User Database</h1>

<table>
  <thead>
    <tr>
      <th>User ID</th>
      <th>User Email</th>
      <th>User password</th>
      <th>Name</th>
      <th>Email</th>
      <th>Phone</th>
      <th>Message</th>
      <th>Created At</th>
    </tr>
  </thead>
  <tbody>
    <?php
    $serialNumber = 1; 
    foreach ($results as $row):
    ?>
    <tr>
      <td><?php echo $serialNumber; ?></td>
      <td><?php echo $row['username']; ?></td>
      <td><?php echo $row['password']; ?></td>
      <td><?php echo $row['name']; ?></td>
      <td><?php echo $row['email']; ?></td>
      <td><?php echo $row['phone']; ?></td>
      <td><?php echo $row['message']; ?></td>
      <td><?php echo $row['created_at']; ?></td>
    </tr>
    <?php
    $serialNumber++; 
    endforeach;
    ?>
  </tbody>
</table>

</body>
</html>

<?php
session_start();
?>

<!DOCTYPE html>
<html>
<head>
    <style>
        /* Resetting default margin and padding */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* Body styles */
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
        }

        /* Header styles */
        .header {
            background-color: #333;
            color: #fff;
            padding: 10px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo h1 {
            margin: 0;
        }

        .navigation ul {
            list-style-type: none;
        }

        .navigation li {
            display: inline;
            margin-right: 20px;
        }

        .navigation a {
            color: #fff;
            text-decoration: none;
        }

        /* Container styles */
        .container {
            display: flex;
            justify-content: space-between;
            padding: 20px;
        }

        /* Sidebar styles */
        .sidebar {
            width: 250px;
            background-color: #fff;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .sidebar .logo img {
            width: 100px;
            height: auto;
            margin-bottom: 20px;
        }

        .sidebar h2 {
            color: #333;
            margin-bottom: 20px;
        }

        .sidebar-menu {
            list-style-type: none;
        }

        .sidebar-menu li {
            margin-bottom: 10px;
        }

        .sidebar-menu a {
            color: #333;
            text-decoration: none;
        }

        /* Content styles */
        .content {
            flex: 1;
            background-color: #fff;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .dashboard-overview h2 {
            color: #333;
            margin-bottom: 20px;
        }

        .dashboard-overview p {
            color: #666;
        }

        .dashboard-container {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }

        .dashboard-widget {
            flex: 0 0 48%;
        }

        /* Footer styles */
        .sidebar-footer {
            margin-top: 20px;
            border-top: 1px solid #ccc;
            padding-top: 10px;
            color: #666;
        }

        .sidebar-footer a {
            color: #333;
            text-decoration: none;
        }
        /* Sidebar styles */
.sidebar {
    width: 250px;
    background-color: #fff;
    padding: 20px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

.sidebar .logo img {
    width: 100px;
    height: auto;
    margin-bottom: 20px;
}

.sidebar h2 {
    color: #333;
    margin-bottom: 20px;
}

.sidebar-menu {
    list-style-type: none;
}

.sidebar-menu li {
    margin-bottom: 10px;
}

.sidebar-menu a {
    color: #333;
    text-decoration: none;
}

/* Adjusted color for Welcome text */
.sidebar h2.welcome-text {
    color: #666;
    margin-bottom: 20px;
}

    </style>
    <link rel="stylesheet" type="text/css" href="./css/admindashboard.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <title>Admin Panel</title>
</head>
<body>
    <header class="header">
        <div class="logo">
            <h1>Admin Panel</h1>
        </div>
        <nav class="navigation">
            <ul class="nav-menu">
                <li><a href="adminviewusers.php">View Users</a></li>
                <li><a href="adminusers.php">View Admins</a></li>
                <li><a href="#">Settings</a></li>
            </ul>
        </nav>
    </header>

    <div class="container">
        <div class="sidebar">
            <div class="logo">
                <img src="silhouette.png" alt="Silhouette Image"><br><br>
            </div>
            <h2 style="color:black;">Welcome, <?php echo $_SESSION['AdminLoginId'];?></h2>
            <ul class="sidebar-menu">
                <li><a href="#"><i class="fa fa-home"></i> Dashboard</a></li>
                
                <li><a href="comments.php"><i class="fa fa-comments"></i> Visitors Feedback</a></li>
                <li><a href="adminaddplace.html"><i class="fa fa-pencil"></i> Update Journeys</a></li>
               
            </ul>
            <div class="sidebar-footer" style="color: #333;">
                
            <a href="adminlogout.php" style="color: red; display: inline-block; padding: 5px 10px; background-color: #fff; border: 1px solid red; border-radius: 5px;"><i class="fa fa-sign-out"></i> Logout</a>
    </div>
        </div>

        <div class="content">
            <div class="dashboard-overview">
                <h2>Dashboard Overview</h2>
                <p>Welcome to Admin Dashboard. Here, you can manage journeys, users, and settings of the website.</p>
            </div>

            <br>
            <div class="dashboard-container">
                

                <div class="dashboard-widget userGrowth-chart">
                    <h2>User Growth</h2>
                    <canvas id="userLineChart" width="400" height="200"></canvas>
                </div>
            </div>
        </div>
    </div>


    <script>
        var userPieData = {
            labels: ['Admins', 'Regular Users', 'Guests'],
            datasets: [{
                data: [30, 60, 10],
                backgroundColor: ['#36a2eb', '#ffcd56', '#ff6384']
            }]
        };

        var userLineData = {
            labels: ['2019', '2020', '2021', '2022', '2023'],
            datasets: [{
                label: 'Number of Users',
                data: [200, 400, 600, 800, 1000],
                borderColor: '#ff6384',
                fill: false
            }]
        };

        var userPieChart = new Chart(document.getElementById('userPieChart'), {
            type: 'pie',
            data: userPieData
        });

        var userLineChart = new Chart(document.getElementById('userLineChart'), {
            type: 'line',
            data: userLineData
        });
    </script>
</body>
</html>

<!--   sudo /opt/lampp/lampp start   -->
<!--  http://localhost/landscaping/dashboard.php -->
<!-- http://localhost/phpmyadmin -->

<?php
//Connect to the database
$servername = "localhost";
$username = "root"; 
$password = ""; 
$dbname = "Lee_lawn_care"; 
$conn = new mysqli($servername, $username, $password, $dbname);



//if error connecting
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


//Get customers to display on dashbaord 
$customers_query = "SELECT COUNT(*) AS total_customers FROM customers";
$customers_result = $conn->query($customers_query);
if (!$customers_result) {
    die("Query failed: " . $conn->error);
}
$customers_row = $customers_result->fetch_assoc();
$total_customers = $customers_row['total_customers'];

//get "active" projects to display on dashbaord
$projects_query = "SELECT COUNT(*) AS total_projects FROM services";
$projects_result = $conn->query($projects_query);
if (!$projects_result) {
    die("Query failed: " . $conn->error);
}
$projects_row = $projects_result->fetch_assoc();
$total_projects = $projects_row['total_projects'];

// Get all open porjects 
$revenue_query = "SELECT SUM(bill_amount) AS total_revenue FROM services";
$revenue_result = $conn->query($revenue_query);
if (!$revenue_result) {
    die("Query failed: " . $conn->error);
}
$revenue_row = $revenue_result->fetch_assoc();
$total_revenue = $revenue_row['total_revenue'] ? number_format($revenue_row['total_revenue'], 2) : '0.00'; // Format as currency


// Get sum of all open projects
$query = "SELECT service_date, SUM(bill_amount) AS amount_due 
          FROM services 
          GROUP BY service_date 
          ORDER BY service_date ASC"; 
$result = $conn->query($query);




// Prepare data for the chart
$labels = [];
$data = [];
while ($row = $result->fetch_assoc()) {
    $labels[] = $row['service_date'];
    $data[] = $row['amount_due'];
}

// Close the database connection
$conn->close();
?>








<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lee's Landscaping Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
    <script src="https://unpkg.com/@tailwindcss/browser@latest"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-gradient-to-br from-green-100 to-green-200 min-h-screen flex flex-col">

    <header class="bg-white/10 py-3 px-4 glass mb-6">
        <div class="flex items-center justify-between">
            <h1 class="text-xl font-semibold text-green-800">Lee's Landscaping</h1>
            <nav>
                <ul class="flex space-x-4">
                    <li>
                        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                            <input type="hidden" name="action" value="dashboard">
                            <button type="submit" class="nav-button">Dashboard</button>
                        </form>
                    </li>
                    <li>
                        <form action="customers.php" method="POST">
                            <input type="hidden" name="action" value="customers">
                            <button type="submit" class="nav-button">Add Customers</button>
                        </form>
                    </li>
                    <li>
                        <form action="view.php" method="POST">
                            <input type="hidden" name="action" value="billing">
                            <button type="submit" class="nav-button">View Customers</button>
                        </form>
                    </li>
                    <li>
                        <form action="services.php" method="POST">
                            <input type="hidden" name="action" value="billing">
                            <button type="submit" class="nav-button">Add Services</button>
                        </form>
                    </li>
                    <li>
                        <form action="view_services.php" method="POST">
                            <input type="hidden" name="action" value="billing">
                            <button type="submit" class="nav-button">View All services</button>
                        </form>
                    </li>
                    <li>
                        <form action="email.php" method="POST">
                            <input type="hidden" name="action" value="billing">
                            <button type="submit" class="nav-button">Email Invoices</button>
                        </form>
                    </li>
                </ul>
            </nav>
        </div>
    </header>

    <div class="flex flex-grow">
        <aside class="sidebar bg-white/10 glass p-4 mr-6">
            <h2 class="text-lg font-semibold text-green-800 mb-4">Menu</h2>
            <nav>
                <ul class="space-y-2">
                    <li>
                        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                            <input type="hidden" name="action" value="dashboard">
                            <button type="submit" class="menu-button">
                                Dashboard
                            </button>
                        </form>
                    </li>
                    <li>
                        <form id="customers-form" action="customers.php" method="POST">
                            <input type="hidden" name="action" value="customers">
                            <button type="submit" class="menu-button">
                                Add Customers
                            </button>
                        </form>
                    </li>
                    <li>
                        <form id="billing-form" action="view.php" method="POST">
                            <input type="hidden" name="action" value="billing">
                            <button type="submit" class="menu-button">
                                View Customers
                            </button>
                        </form>
                    </li>

                    <li>
                        <form id="billing-form" action="view.php" method="POST">
                            <input type="hidden" name="action" value="billing">
                            <button type="submit" class="menu-button">
                                Add services
                            </button>
                        </form>
                    </li>

                    <li>
                        <form id="billing-form" action="view_services.php" method="POST">
                            <input type="hidden" name="action" value="billing">
                            <button type="submit" class="menu-button">
                                View All Services
                            </button>
                        </form>
                    </li>
                </ul>
            </nav>
        </aside>

        <main class="content-area p-4">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mb-6">
                <div class="bg-white/10 glass p-4 rounded-md">
                    <h3 class="text-lg font-semibold text-green-800 mb-2">Total Revenue</h3>
                    <p class="text-xl font-bold text-green-900">$<?php echo $total_revenue; ?></p>
                </div>
                <div class="bg-white/10 glass p-4 rounded-md">
                    <h3 class="text-lg font-semibold text-green-800 mb-2">Total Customers</h3>
                    <p class="text-xl font-bold text-green-900"><?php echo $total_customers; ?></p>
                </div>
                <div class="bg-white/10 glass p-4 rounded-md">
                    <h3 class="text-lg font-semibold text-green-800 mb-2">Active Projects</h3>
                    <p class="text-xl font-bold text-green-900"><?php echo $total_projects; ?></p>
                </div>
            </div>

            <div class="bg-white/10 glass p-4 rounded-md mb-6">
                <h2 class="text-xl font-semibold text-green-800 mb-2">Revenue Overview</h2>
                <div class="h-48 w-full bg-green-100 rounded-md flex items-center justify-center text-green-600">
                    <canvas id="myChart" class="w-full h-full"></canvas>
                </div>
            </div>
        </main>
    </div>

    <footer class="bg-white/10 py-3 px-4 glass mt-6 text-center text-green-700">
        <p>&copy; 2024 Lee's Landscaping. All rights reserved.</p>
    </footer>

    <script>
        var ctx = document.getElementById('myChart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: <?php echo json_encode($labels); ?>,
                datasets: [{
                    label: 'Amount Due',
                    data: <?php echo json_encode($data); ?>,
                    borderColor: 'rgba(75, 192, 192, 1)',
                    tension: 0.1,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top',
                        labels: {
                            font: {
                                size: 12,
                            }
                        }
                    },
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            font: {
                                size: 12,
                            }
                        }
                    },
                    x: {
                        ticks: {
                            font: {
                                size: 12,
                            }
                        }
                    }
                }
            }
        });
    </script>
</body>
</html>

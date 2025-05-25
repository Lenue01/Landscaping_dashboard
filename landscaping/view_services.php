<?php

//database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "Lee_lawn_care";
$conn = new mysqli($servername, $username, $password, $dbname);




//Find all services
$sql = "SELECT id, customer_id, customer_L_Name, bill_amount, service_Date, amount_paid FROM services";
$result = $conn->query($sql);
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Services</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        .glass {
            background-color: rgba(56, 189, 248, 0.2);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(56, 189, 248, 0.3);
            border-radius: 1rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }
    </style>
</head>
<body class="bg-gradient-to-br from-green-100 to-green-200 min-h-screen p-6">
    <div class="max-w-5xl mx-auto glass p-8 rounded-xl shadow-lg">
        <h1 class="text-3xl font-semibold text-green-800 mb-6 text-center">Service Records</h1>
        <table class="min-w-full bg-white/60 text-green-900 shadow rounded overflow-hidden">
            <thead>
                <tr class="bg-green-200 text-left">
                    <th class="py-3 px-4">Customer ID</th>
                    <th class="py-3 px-4">Last Name</th>
                    <th class="py-3 px-4">Bill Amount</th>
                    <th class="py-3 px-4">Service Date</th>
                    <th class="py-3 px-4">Amount Paid</th>
                    <th class="py-3 px-4">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result && $result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr class="border-t border-green-300">
                            <td class="py-2 px-4"><?php echo $row['customer_id']; ?></td>
                            <td class="py-2 px-4"><?php echo $row['customer_L_Name']; ?></td>
                            <td class="py-2 px-4">$<?php echo number_format($row['bill_amount'], 2); ?></td>
                            <td class="py-2 px-4"><?php echo $row['service_Date']; ?></td>
                            <td class="py-2 px-4">$<?php echo number_format($row['amount_paid'], 2); ?></td>
                            <td class="py-2 px-4 space-x-2">
                                <a href="add_payment.php?id=<?php echo $row['id']; ?>" class="bg-yellow-400 hover:bg-yellow-500 text-white font-bold py-1 px-3 rounded">Add Payment</a>
                                <a href="delete_service.php?id=<?php echo $row['id']; ?>" class="bg-red-500 hover:bg-red-600 text-white font-bold py-1 px-3 rounded" onclick="return confirm('Are you sure you want to delete this service?');">Delete</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="text-center py-4 text-red-500">No services found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>

<?php
$conn->close();
?>
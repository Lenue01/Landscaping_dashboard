<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Service Entry</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
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
    <div class="max-w-3xl mx-auto glass p-8 rounded-xl shadow-lg">
        <h1 class="text-3xl font-semibold text-green-800 mb-6 text-center">Add Service Entry</h1>
        <form method="POST" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="customer_id" class="block text-green-700 text-sm font-bold mb-2">Customer ID:</label>
                    <input type="number" id="customer_id" name="customer_id" required class="shadow border rounded w-full py-2 px-3 bg-white/50 text-green-900 focus:outline-none focus:shadow-outline">
                </div>
                <div>
                    <label for="customer_L_Name" class="block text-green-700 text-sm font-bold mb-2">Last Name:</label>
                    <input type="text" id="customer_L_Name" name="customer_L_Name" required class="shadow border rounded w-full py-2 px-3 bg-white/50 text-green-900 focus:outline-none focus:shadow-outline">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="bill_amount" class="block text-green-700 text-sm font-bold mb-2">Bill Amount:</label>
                    <input type="number" step="0.01" id="bill_amount" name="bill_amount" required class="shadow border rounded w-full py-2 px-3 bg-white/50 text-green-900 focus:outline-none focus:shadow-outline">
                </div>
                <div>
                    <label for="amount_paid" class="block text-green-700 text-sm font-bold mb-2">Amount Paid:</label>
                    <input type="number" step="0.01" id="amount_paid" name="amount_paid" required class="shadow border rounded w-full py-2 px-3 bg-white/50 text-green-900 focus:outline-none focus:shadow-outline">
                </div>
            </div>

            <div>
                <label for="service_date" class="block text-green-700 text-sm font-bold mb-2">Service Date:</label>
                <input type="date" id="service_date" name="service_date" required class="shadow border rounded w-full py-2 px-3 bg-white/50 text-green-900 focus:outline-none focus:shadow-outline">
            </div>

            <button type="submit" name="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded w-full focus:outline-none focus:shadow-outline">
                Add Service
            </button>
        </form>

        
        
        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
            $conn = new mysqli("localhost", "root", "", "Lee_lawn_care");
            if ($conn->connect_error) {
                die("<p class='text-red-600 mt-4'>Connection failed: " . $conn->connect_error . "</p>");
            }

            $cid = $conn->real_escape_string($_POST['customer_id']);
            $lname = $conn->real_escape_string($_POST['customer_L_Name']);
            $bill = $conn->real_escape_string($_POST['bill_amount']);
            $date = $conn->real_escape_string($_POST['service_date']);
            $paid = $conn->real_escape_string($_POST['amount_paid']);



            $sql = "INSERT INTO services (customer_id, customer_L_Name, bill_amount, service_date, amount_paid)
                    VALUES ('$cid', '$lname', '$bill', '$date', '$paid')";

            if ($conn->query($sql) === TRUE) {
                echo "<p class='text-green-700 mt-6 font-medium'> Service entry added successfully.</p>";
                header("Location: dashboard.php");
                exit();
            } else {
                echo "<p class='text-red-600 mt-6'> Error: " . $conn->error . "</p>";
            }

            $conn->close();
        }
        ?>
    </div>
</body>
</html>
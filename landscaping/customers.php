<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "Lee_lawn_care";
$conn = new mysqli($servername, $username, $password, $dbname);




if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}



//Get data to add a customer 
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_customer'])) {
    $customer_F_Name = $_POST["customer_F_Name"];
    $customer_L_Name = $_POST["customer_L_Name"];
    $customer_Title = $_POST["customer_Title"];
    $customer_Phone = $_POST["customer_Phone"];
    $customer_Email = $_POST["customer_Email"];
    $street_Address = $_POST["street_Address"];
    $city = $_POST["city"];
    $state = $_POST["state"];
    $zip = $_POST["zip"];


    //insert into DB
    $sql = "INSERT INTO customers (customer_F_Name, customer_L_Name, customer_Title, customer_Phone, customer_Email, street_Address, city, state, zip)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssssss", $customer_F_Name, $customer_L_Name, $customer_Title, $customer_Phone, $customer_Email, $street_Address, $city, $state, $zip);


    //If added correctly
    if ($stmt->execute()) {
        echo "<script>alert('New customer added successfully'); window.location.href='add_customer.php';</script>";
        header("Location: dashboard.php");
        exit();


    //if error    
    } else {
        echo "<script>alert('Error: " . $conn->error . "');</script>";
    }

    $stmt->close();
}

//close this
$conn->close();
?>





<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Customer</title>
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
        <h1 class="text-3xl font-semibold text-green-800 mb-6 text-center">Add New Customer</h1>
        <form method="POST" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="customer_F_Name" class="block text-green-700 text-sm font-bold mb-2">First Name:</label>
                    <input type="text" id="customer_F_Name" name="customer_F_Name" required class="shadow border rounded w-full py-2 px-3 bg-white/50 text-green-900 focus:outline-none focus:shadow-outline">
                </div>
                <div>
                    <label for="customer_L_Name" class="block text-green-700 text-sm font-bold mb-2">Last Name:</label>
                    <input type="text" id="customer_L_Name" name="customer_L_Name" required class="shadow border rounded w-full py-2 px-3 bg-white/50 text-green-900 focus:outline-none focus:shadow-outline">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="customer_Title" class="block text-green-700 text-sm font-bold mb-2">Title:</label>
                    <select id="customer_Title" name="customer_Title" required class="shadow border rounded w-full py-2 px-3 bg-white/50 text-green-900 focus:outline-none focus:shadow-outline">
                        <option value="Mr.">Mr.</option>
                        <option value="Ms.">Ms.</option>
                        <option value="Mrs.">Mrs.</option>
                        <option value="Dr.">Dr.</option>
                    </select>
                </div>
                <div>
                    <label for="customer_Phone" class="block text-green-700 text-sm font-bold mb-2">Phone:</label>
                    <input type="tel" id="customer_Phone" name="customer_Phone" required class="shadow border rounded w-full py-2 px-3 bg-white/50 text-green-900 focus:outline-none focus:shadow-outline">
                </div>
            </div>

            <div>
                <label for="customer_Email" class="block text-green-700 text-sm font-bold mb-2">Email:</label>
                <input type="email" id="customer_Email" name="customer_Email" required class="shadow border rounded w-full py-2 px-3 bg-white/50 text-green-900 focus:outline-none focus:shadow-outline">
            </div>

            <div>
                <label for="street_Address" class="block text-green-700 text-sm font-bold mb-2">Street Address:</label>
                <input type="text" id="street_Address" name="street_Address" required class="shadow border rounded w-full py-2 px-3 bg-white/50 text-green-900 focus:outline-none focus:shadow-outline">
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label for="city" class="block text-green-700 text-sm font-bold mb-2">City:</label>
                    <input type="text" id="city" name="city" required class="shadow border rounded w-full py-2 px-3 bg-white/50 text-green-900 focus:outline-none focus:shadow-outline">
                </div>
                <div>
                    <label for="state" class="block text-green-700 text-sm font-bold mb-2">State:</label>
                    <input type="text" id="state" name="state" required class="shadow border rounded w-full py-2 px-3 bg-white/50 text-green-900 focus:outline-none focus:shadow-outline">
                </div>
                <div>
                    <label for="zip" class="block text-green-700 text-sm font-bold mb-2">Zip:</label>
                    <input type="text" id="zip" name="zip" required class="shadow border rounded w-full py-2 px-3 bg-white/50 text-green-900 focus:outline-none focus:shadow-outline">
                </div>
            </div>

            <button type="submit" name="add_customer" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded w-full focus:outline-none focus:shadow-outline">
                Add Customer
            </button>
        </form>
    </div>
</body>
</html>
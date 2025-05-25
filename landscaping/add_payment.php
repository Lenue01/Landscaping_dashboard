<?php
//database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "Lee_lawn_care";
$conn = new mysqli($servername, $username, $password, $dbname);



// Check 
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}




// Get service by ID
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = intval($_GET['id']);


    $sql = "SELECT id, customer_L_Name, bill_amount, amount_paid FROM services WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $service = $result->fetch_assoc();
} else {
    die("Invalid service ID.");
}

// Add Payment
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['payment'])) {
    $payment = floatval($_POST['payment']);
    $service_id = intval($_POST['id']);

    // Update amount_paid
    $update = $conn->prepare("UPDATE services SET amount_paid = amount_paid + ? WHERE id = ?");
    $update->bind_param("di", $payment, $service_id);

    if ($update->execute()) {
        header("Location: dashboard.php");  //go back to dashbaord after 
        exit();
    } else {
        echo "Error updating payment: " . $conn->error;
    }
}
?>






<!DOCTYPE html>
<html>
<head>
    <title>Add Payment</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-green-100 min-h-screen flex items-center justify-center">
    <div class="bg-white p-8 rounded shadow-lg max-w-md w-full">
        <h2 class="text-2xl font-bold text-green-700 mb-4">Add Payment for <?php echo htmlspecialchars($service['customer_L_Name']); ?></h2>
        <p><strong>Total Bill:</strong> $<?php echo number_format($service['bill_amount'], 2); ?></p>
        <p><strong>Already Paid:</strong> $<?php echo number_format($service['amount_paid'], 2); ?></p>
        <form method="POST" class="mt-4">
            <input type="hidden" name="id" value="<?php echo $service['id']; ?>">
            <label class="block mb-2 text-sm font-medium">Payment Amount</label>
            <input type="number" step="0.01" name="payment" required class="w-full p-2 border border-gray-300 rounded mb-4">
            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Submit Payment</button>
        </form>
    </div>
</body>
</html>
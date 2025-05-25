
<?php
$servername = "localhost";
$username = "root"; 
$password = ""; 
$dbname = "Lee_lawn_care"; 
$conn = new mysqli($servername, $username, $password, $dbname);




if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

//find unpaid services
$query = "
    SELECT s.id, s.customer_id, s.bill_amount, s.amount_paid, c.customer_Email, c.customer_F_Name, c.customer_L_Name
    FROM services s
    JOIN customers c ON s.customer_id = c.id
    WHERE s.amount_paid < s.bill_amount";

$result = $conn->query($query);


//I could not get it to send an email I tried downloading a few things but none would work 
//I even tried sending from my own personal email but i think gmails security wouldnt allow that
//so i did a simulated email send



echo "<h2>Email Sending:</h2>";

//iterate thru and send email to all customers with outstanding balance 
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $customer_id = $row['customer_id'];
        $customer_email = $row['customer_Email'];
        $customer_name = $row['customer_F_Name'] . " " . $row['customer_L_Name'];
        $amount_due = $row['bill_amount'] - $row['amount_paid'];
        echo "<hr>";
        echo "<h3>Recipient: $customer_name ($customer_email)</h3>";
        echo "<strong>Subject:</strong> Payment Reminder: Outstanding Balance<br>";
        echo "<strong>To:</strong> $customer_email<br>";
        echo "<strong>From:</strong> lenuehodges4937@gmail.com (Simulated)<br>";
        echo "<br>";
        echo "<pre style='border: 1px solid #ccc; padding: 10px; white-space: pre-wrap;'>";
        echo "<html>\n";
        echo "<head>\n";
        echo "    <title>Payment Reminder</title>\n";
        echo "</head>\n";
        echo "<body>\n";
        echo "    <p>Dear $customer_name,</p>\n";
        echo "    <p>This is a reminder that you have an outstanding balance of $$amount_due for your recent service.</p>\n";
        echo "    <p>Please make your payment at your earliest convenience. If you have any questions, feel free to contact us.</p>\n";
        echo "    <p>Thank you for choosing Lee's Landscaping!</p>\n";
        echo "</body>\n";
        echo "</html>\n";
        echo "</pre>";
    }
} else {
    echo "<p>No customers with unpaid balances found.</p>";
}




// Close the database connection
$conn->close();
?>
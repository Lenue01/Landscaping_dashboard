<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Customer List</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-green-100 min-h-screen p-6 font-sans">
    <div class="max-w-6xl mx-auto bg-white p-8 rounded shadow">
        <h1 class="text-3xl font-bold text-green-700 mb-6 text-center">Customer List</h1>

        <table class="min-w-full table-auto border-collapse border border-green-300">
            <thead>
                <tr class="bg-green-200 text-green-900">
                    <th class="border border-green-300 px-4 py-2">ID</th>
                    <th class="border border-green-300 px-4 py-2">Title</th>
                    <th class="border border-green-300 px-4 py-2">First Name</th>
                    <th class="border border-green-300 px-4 py-2">Last Name</th>
                    <th class="border border-green-300 px-4 py-2">Phone</th>
                    <th class="border border-green-300 px-4 py-2">Email</th>
                    <th class="border border-green-300 px-4 py-2">Address</th>
                    <th class="border border-green-300 px-4 py-2">City</th>
                    <th class="border border-green-300 px-4 py-2">State</th>
                    <th class="border border-green-300 px-4 py-2">Zip</th>
                </tr>
            </thead>
            <tbody class="text-green-800">
                <?php
                // Database connection details
                $servername = "localhost";
                $username = "root";
                $password = "";
                $dbname = "Lee_lawn_care";
                $conn = new mysqli($servername, $username, $password, $dbname);
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }



                $sql = "SELECT * FROM customers";
                $result = $conn->query($sql);



                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td class='border border-green-300 px-4 py-2'>" . $row["id"] . "</td>";
                        echo "<td class='border border-green-300 px-4 py-2'>" . $row["customer_Title"] . "</td>";
                        echo "<td class='border border-green-300 px-4 py-2'>" . $row["customer_F_Name"] . "</td>";
                        echo "<td class='border border-green-300 px-4 py-2'>" . $row["customer_L_Name"] . "</td>";
                        echo "<td class='border border-green-300 px-4 py-2'>" . $row["customer_Phone"] . "</td>";
                        echo "<td class='border border-green-300 px-4 py-2'>" . $row["customer_Email"] . "</td>";
                        echo "<td class='border border-green-300 px-4 py-2'>" . $row["street_Address"] . "</td>";
                        echo "<td class='border border-green-300 px-4 py-2'>" . $row["city"] . "</td>";
                        echo "<td class='border border-green-300 px-4 py-2'>" . $row["state"] . "</td>";
                        echo "<td class='border border-green-300 px-4 py-2'>" . $row["zip"] . "</td>";
                        echo "</tr>";
                    }
                
                
                
                } else {
                    echo "<tr><td colspan='10' class='text-center py-4'>No customers found.</td></tr>";
                }

                $conn->close();
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
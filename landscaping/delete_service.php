<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "Lee_lawn_care";
$conn = new mysqli($servername, $username, $password, $dbname);


//if error
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}




if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = intval($_GET['id']); // This ID is primary feild 

    // This deletes by service ID not the primry ID
    $sql = "DELETE FROM services WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        
        header("Location: dashboard.php"); //After delete redirect to dashbaord.php
        exit();
    } else {
        echo "Error deleting record: " . $conn->error;
    }

} else {
    echo "Invalid ID.";
}


//close conn
$conn->close();
?>
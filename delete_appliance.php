<?php
$mysqli = mysqli_connect("localhost", "root", "", "appliance_db"); // DB connection
if ($mysqli->connect_error) die("Connection failed: " . $mysqli->connect_error);

$message = ""; // Feedback message
$appliance = null; // Holds appliance details

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST['serial']) && !isset($_POST['confirm_delete'])) {
        // Search by Serial Number
        $serial = $_POST['serial'];
        
        $sql = "SELECT ApplianceType, Brand, ModelNumber, SerialNumber FROM Appliance WHERE SerialNumber = ?";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("s", $serial);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $appliance = $result->fetch_assoc(); // Appliance found
        } else {
            $message = "No appliance found with that serial number.";
        }
        $stmt->close();
    }

    if (isset($_POST['confirm_delete'])) {
        // Confirm and delete appliance
        $serial = $_POST['confirm_delete'];

        $sql = "DELETE FROM Appliance WHERE SerialNumber = ?";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("s", $serial);
        
        if ($stmt->execute()) {
            $message = "Appliance deleted successfully.";
        } else {
            $message = "Error: " . $stmt->error;
        }
        $stmt->close();
    }
}
$mysqli->close(); 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Delete Appliance</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="../style.css" rel="stylesheet">
</head>
<body class="container mt-5">
    <h2>Delete Appliance</h2>

    <!-- Search Form -->
    <?php if (!$appliance && empty($message)): ?>
        <form method="POST" action="">
            <div class="form-group">
                <label for="serial">Enter Serial Number:</label>
                <input type="text" class="form-control" name="serial" required>
            </div>
            <button type="submit" class="btn btn-danger">Find Appliance</button>
            <a href="../index.html" class="btn btn-secondary">Home</a>
        </form>

    <!-- Show appliance details with confirmation form -->
    <?php elseif ($appliance): ?>
        <div class="border p-3 mb-3 bg-light">
            <p><strong>Appliance:</strong> <?php echo htmlspecialchars($appliance['ApplianceType']); ?> (<?php echo htmlspecialchars($appliance['Brand']); ?> - <?php echo htmlspecialchars($appliance['ModelNumber']); ?>)</p>
            <p><strong>Serial Number:</strong> <?php echo htmlspecialchars($appliance['SerialNumber']); ?></p>
        </div>

        <!-- Confirm Deletion Form -->
        <form method="POST" action="">
            <!-- Hidden input carries serial number for deletion -->
            <input type="hidden" name="confirm_delete" value="<?php echo htmlspecialchars($appliance['SerialNumber']); ?>">
            <button type="submit" class="btn btn-danger">Confirm Deletion</button>
            <a href="" class="btn btn-secondary">Cancel</a>
        </form>
    <?php endif; ?>

    <!-- Message display after deletion or failed search -->
    <?php if (!empty($message)): ?>
        <div class="alert alert-info mt-3"><?php echo $message; ?></div>
        <a href="../index.html" class="btn btn-secondary">Home</a>
    <?php endif; ?>
</body>
</html>


<?php
// Connect to database
$mysqli = mysqli_connect("localhost", "root", "", "appliance_db");
if ($mysqli->connect_error) die("Connection failed: " . $mysqli->connect_error);

$message = "";
$editData = null;

// Handle form submission for updating appliance
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['SerialNumber'])) {
    $serial = $_POST['SerialNumber'];
    $type = $_POST['type'];
    $brand = $_POST['brand'];
    $model = $_POST['model'];
    $purchase = $_POST['purchase'];
    $warranty = $_POST['warranty'];
    $cost = $_POST['cost'];

    // Prepare and execute UPDATE query
    $sql = "UPDATE Appliance SET 
                ApplianceType = ?, 
                Brand = ?, 
                ModelNumber = ?, 
                PurchaseDate = ?, 
                WarrantyExpirationDate = ?, 
                CostOfAppliance = ?
            WHERE SerialNumber = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("sssssss", $type, $brand, $model, $purchase, $warranty, $cost, $serial);

    if ($stmt->execute()) {
        // Show success or no-change message
        if ($stmt->affected_rows > 0) {
            $message = "Appliance updated successfully!";
        } else {
            $message = "No changes made.";
        }
    } else {
        $message = "Error updating: " . $stmt->error;
    }
    $stmt->close();
}

// Fetch appliance data if serial number is given (GET request)
if (isset($_GET['serial'])) {
    $serial = trim($_GET['serial']);
    $sql = "SELECT * FROM Appliance WHERE SerialNumber = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("s", $serial);
    $stmt->execute();
    $result = $stmt->get_result();
    $editData = $result->fetch_assoc(); // fetch data into an associative array
    $stmt->close();
}

$mysqli->close(); 
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Update Appliance</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="../style.css" rel="stylesheet">
</head>
<body class="container mt-5">
    <h2>Update Appliance</h2>
    <!-- Show serial number input form if no appliance has been searched yet -->
    <?php if (!isset($editData) && !isset($_POST['SerialNumber'])): ?>
        <form method="GET">
            <div class="form-group">
                <label>Enter Serial Number to Edit:</label>
                <input type="text" name="serial" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-warning">Search</button>
            <a href="../index.html" class="btn btn-secondary">Home</a>
        </form>
    <!-- If appliance data is found, show editable form -->
    <?php elseif ($editData): ?>
        <form method="POST" class="card p-4">
            <!-- Hidden field to keep Serial Number -->
            <input type="hidden" name="SerialNumber" value="<?php echo $editData['SerialNumber']; ?>">

            <div class="form-group">
                <label>Appliance Type</label>
                <input type="text" name="type" class="form-control" value="<?php echo htmlspecialchars($editData['ApplianceType']); ?>" required>
            </div>

            <div class="form-group">
                <label>Brand</label>
                <input type="text" name="brand" class="form-control" value="<?php echo htmlspecialchars($editData['Brand']); ?>" required>
            </div>

            <div class="form-group">
                <label>Model Number</label>
                <input type="text" name="model" class="form-control" value="<?php echo htmlspecialchars($editData['ModelNumber']); ?>" required>
            </div>

            <div class="form-group">
                <label>Purchase Date</label>
                <input type="date" name="purchase" class="form-control" value="<?php echo $editData['PurchaseDate']; ?>" required>
            </div>

            <div class="form-group">
                <label>Warranty Expiration</label>
                <input type="date" name="warranty" class="form-control" value="<?php echo $editData['WarrantyExpirationDate']; ?>" required>
            </div>

            <div class="form-group">
                <label>Cost (€)</label>
                <input type="number" name="cost" step="0.01" class="form-control" value="<?php echo htmlspecialchars($editData['CostOfAppliance']); ?>" required>
            </div>

            <button type="submit" class="btn btn-primary">Update</button>
            <a href="update_appliance.php" class="btn btn-secondary">Cancel</a>
        </form>
    <?php endif; ?>

    <!-- Display message after update -->
    <?php if (!empty($message)): ?>
        <div class="alert alert-info mt-4"><?php echo $message; ?></div>
        <a href="update_appliance.php" class="btn btn-success">Update Another</a>
        <a href="../index.html" class="btn btn-secondary">Home</a>
    <?php endif; ?>
</body>
</html>

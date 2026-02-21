<?php
// Connect to the database
$mysqli = mysqli_connect("localhost", "root", "", "appliance_db");
if ($mysqli->connect_error) die("Connection failed: " . $mysqli->connect_error);

// Clean input
function validate_input($data) {
    return htmlspecialchars(trim($data));
}

// If form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $errors = [];

    // Get and clean form inputs
    $first_name      = validate_input($_POST['first_name'] ?? '');
    $last_name       = validate_input($_POST['last_name'] ?? '');
    $address         = validate_input($_POST['address'] ?? '');
    $mobile          = validate_input($_POST['mobile'] ?? '');
    $email           = validate_input($_POST['email'] ?? '');
    $eircode         = validate_input($_POST['eircode'] ?? '');
    $appliance_type  = validate_input($_POST['appliance_type'] ?? '');
    $brand           = validate_input($_POST['brand'] ?? '');
    $model_number    = validate_input($_POST['model_number'] ?? '');
    $serial_number   = validate_input($_POST['serial_number'] ?? '');
    $purchase_date   = validate_input($_POST['purchase_date'] ?? '');
    $warranty_date   = validate_input($_POST['warranty_date'] ?? '');
    $costOfAppliance = validate_input($_POST['costOfAppliance'] ?? '');

    // Validate required fields
    if (empty($first_name)) $errors[] = "First name is required.";
    if (empty($last_name)) $errors[] = "Last name is required.";
    if (empty($address)) $errors[] = "Address is required.";
    if (empty($mobile)) $errors[] = "Mobile is required.";
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Valid email is required.";
    if (empty($eircode)) $errors[] = "Eircode is required.";
    if (empty($appliance_type)) $errors[] = "Appliance type is required.";
    if (empty($brand)) $errors[] = "Brand is required.";
    if (empty($model_number)) $errors[] = "Model number is required.";
    if (empty($serial_number)) $errors[] = "Serial number is required.";
    if (empty($purchase_date)) $errors[] = "Purchase date is required.";
    if (empty($warranty_date)) $errors[] = "Warranty date is required.";
    if (empty($costOfAppliance) || !is_numeric($costOfAppliance)) $errors[] = "Valid cost is required.";
    if (strtotime($warranty_date) < strtotime($purchase_date)) $errors[] = "Warranty date must be after purchase date.";

    // Show errors
    if (!empty($errors)) {
        foreach ($errors as $e) echo "<p style='color:red;'>$e</p>";
        echo "<p><a href='add_appliance.html'>Go Back</a></p>";
        exit;
    }

    // Check for duplicate serial number
    $stmt = $mysqli->prepare("SELECT ApplianceID FROM Appliance WHERE SerialNumber = ?");
    $stmt->bind_param("s", $serial_number);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        echo  '<!DOCTYPE html><html lang="en"><head>
        <meta charset="UTF-8">
        <title>Search Results</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <link href="../style.css" rel="stylesheet">
    </head><body class="container mt-5">';
        echo "<div class='alert alert-success mt-4'>Appliance already exists.</div>";
        echo "<a href='add_appliance.html' class='btn btn-secondary'>Go Back</a>";
        exit;
    }
    $stmt->close();

    // Check if user already exists
    $stmt = $mysqli->prepare("SELECT UserID FROM User WHERE Email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        // User exists
        $stmt->bind_result($user_id);
        $stmt->fetch();
        $stmt->close();
    } else {
        // Insert new user
        $stmt = $mysqli->prepare("INSERT INTO User (FirstName, LastName, Address, Mobile, Email, Eircode)
                                  VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $first_name, $last_name, $address, $mobile, $email, $eircode);
        $stmt->execute();
        $user_id = $stmt->insert_id;
        $stmt->close();
    }

    // Insert new appliance
    $stmt = $mysqli->prepare("INSERT INTO Appliance (UserID, ApplianceType, Brand, ModelNumber, SerialNumber, PurchaseDate, WarrantyExpirationDate, CostOfAppliance)
                              VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("issssssd", $user_id, $appliance_type, $brand, $model_number, $serial_number, $purchase_date, $warranty_date, $costOfAppliance);
    $stmt->execute();
    $stmt->close();

    // Success message
    echo '<!DOCTYPE html><html lang="en"><head>
        <meta charset="UTF-8">
        <title>Search Results</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <link href="../style.css" rel="stylesheet">
    </head><body class="container mt-5">';

    echo "<div class='alert alert-success mt-4'>New appliance added successfully.</div>";
    echo "<a href='add_appliance.html' class='btn btn-success'>Add Another Appliance</a> ";
    echo "<a href='../index.html' class='btn btn-secondary'>Return to Home Page</a>";
    echo "</body></html>";
}
?>

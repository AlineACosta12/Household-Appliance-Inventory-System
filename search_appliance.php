<?php
// Connect to the database
$mysqli = mysqli_connect("localhost", "root", "", "appliance_db");
if ($mysqli->connect_error) die("Connection failed: " . $mysqli->connect_error);

// Initialize message variable
$message = "";

// Sanitize the search term from GET request
$search_term = htmlspecialchars(trim($_GET['search_term'] ?? ''));

// Prepare the SQL query to search by SerialNumber, Brand, or ModelNumber
$sql = "
SELECT A.*, U.FirstName, U.LastName, U.Email
FROM Appliance A
JOIN User U ON A.UserID = U.UserID
WHERE A.SerialNumber LIKE ? OR A.Brand LIKE ? OR A.ModelNumber LIKE ?
";

// Prepare and bind the search term using LIKE wildcard
$stmt = $mysqli->prepare($sql);
$like_term = '%' . $search_term . '%';
$stmt->bind_param("sss", $like_term, $like_term, $like_term);
$stmt->execute();
$result = $stmt->get_result();

// Begin HTML output
echo '<!DOCTYPE html><html lang="en"><head>
    <meta charset="UTF-8">
    <title>Search Results</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="../style.css" rel="stylesheet">
</head><body class="container mt-5">';

echo "<h2>Search Results for: <em>" . htmlspecialchars($search_term) . "</em></h2>";

// Display results if found
if ($result->num_rows > 0) {
    echo '<table class="table table-bordered mt-3">
            <thead class="thead-dark">
                <tr>
                    <th>Appliance Type</th>
                    <th>Brand</th>
                    <th>Model Number</th>
                    <th>Serial Number</th>
                    <th>Purchase Date</th>
                    <th>Warranty Expiration</th>
                    <th>Cost of Appliance</th>
                    <th>Owner</th>
                    <th>Email</th>
                </tr>
            </thead><tbody>';

    // Loop through results and output each row
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>{$row['ApplianceType']}</td>
                <td>{$row['Brand']}</td>
                <td>{$row['ModelNumber']}</td>
                <td>{$row['SerialNumber']}</td>
                <td>{$row['PurchaseDate']}</td>
                <td>{$row['WarrantyExpirationDate']}</td>
                <td>€{$row['CostOfAppliance']}</td>
                <td>{$row['FirstName']} {$row['LastName']}</td>
                <td>{$row['Email']}</td>
              </tr>";
    }

    echo "</tbody></table>";
} else {
    // Display a message if no results found
    echo "<p class='mt-3'>No appliances found matching your search.</p>";
}

// Navigation buttons
echo "<a href='search_appliance.html' class='btn btn-secondary'>Back to Search</a> ";
echo "<a href='../index.html' class='btn btn-primary'>Home</a>";

// Close HTML
echo "</body></html>";

// Close connections
$stmt->close();
$mysqli->close();
?>

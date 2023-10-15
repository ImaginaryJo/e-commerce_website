<?php
// Connect to database
require 'db_connect.php';
// Fetch data from the database
$sql = "SELECT productName, productType, productLanguage FROM products LIMIT 10";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Code Canvas Products</title>
    <style>
        table {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px 12px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h2 style="text-align:center;">Code Canvas Products</h2>
    <table>
        <thead>
            <tr>
                <th>Product Name</th>
                <th>Product Type</th>
                <th>Product Language</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['productName']); ?></td>
                    <td><?php echo htmlspecialchars($row['productType']); ?></td>
                    <td><?php echo htmlspecialchars($row['productLanguage']); ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
    <?php $conn->close(); ?>
</body>
</html>

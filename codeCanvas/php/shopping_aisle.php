<?php
// Include database connection
require 'database_connection/db_config.php';
require 'database_connection/db_connect.php';

// Fetch all unique product types
$sqlTypes = "SELECT DISTINCT productType FROM products";
$resultTypes = $conn->query($sqlTypes);

// Fetch products based on filter
$productTypeFilter = isset($_POST['productType']) ? $_POST['productType'] : '';
$sql = "SELECT productName, productImage, productCode, productDescription, productPrice, productType FROM products";
if (!empty($productTypeFilter)) {
    $sql .= " WHERE productType = '$productTypeFilter'";
}
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Code Canvas Products</title>
    <!-- Include Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .description {
            display: -webkit-box;
            -webkit-line-clamp: 3; /* Number of lines to show before truncating */
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        .read-more {
            cursor: pointer;
            color: blue;
            text-decoration: underline;
        }
    </style>
</head>
<body>
<div class="container mt-5">
    <!-- Product Type Filter -->
    <form method="post" action="">
        <select name="productType" onchange="this.form.submit()">
            <option value="">All Types</option>
            <?php while ($type = $resultTypes->fetch_assoc()): ?>
                <option value="<?php echo $type['productType']; ?>" <?php if($productTypeFilter == $type['productType']) echo 'selected'; ?>><?php echo $type['productType']; ?></option>
            <?php endwhile; ?>
        </select>
    </form>

    <div class="row mt-3">
        <?php while ($row = $result->fetch_assoc()): ?>
            <div class="col-md-4">
                <div class="card">
                  <img src="../<?php echo htmlspecialchars($row['productImage']); ?>" class="card-img-top" alt="...">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo htmlspecialchars($row['productName']); ?></h5>
                        <div class="description"><?php echo htmlspecialchars($row['productDescription']); ?></div>
                        <?php if (strlen($row['productDescription']) > 150): ?>
                            <span class="read-more">Read More</span>
                        <?php endif; ?>
                        <p><strong>Code:</strong> <?php echo htmlspecialchars($row['productCode']); ?></p>
                        <p><strong>Price:</strong> $<?php echo htmlspecialchars($row['productPrice']); ?></p>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const readMoreEls = document.querySelectorAll('.read-more');

        readMoreEls.forEach(el => {
            el.addEventListener('click', function() {
                const description = this.previousElementSibling;
                if (description.style.display === '-webkit-box') {
                    description.style.display = 'block';
                    this.textContent = 'Read Less';
                } else {
                    description.style.display = '-webkit-box';
                    this.textContent = 'Read More';
                }
            });
        });
    });
</script>

</body>
</html>

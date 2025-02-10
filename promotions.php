<?php
// Get parameters from URL
$promoId = isset($_GET['promo-id']) ? $_GET['promo-id'] : 'N/A';
$designName = isset($_GET['design']) ? $_GET['design']: 'N/A';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Promotion Details</title>
</head>
<body>
    <h1>Promotion Details</h1>
    <p><strong>Promotion ID:</strong> <?= htmlspecialchars($promoId) ?></p>
    <p><strong>Design:</strong> <?= htmlspecialchars($designName) ?></p>
</body>
</html>

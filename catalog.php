<?php
$host = 'localhost';
$dbname = 'vehicles';
$user = 'logan';
$pass = 'logan';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$dbname;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
    throw new PDOException($e->getMessage(), (int)$e->getCode());
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['make']) && isset($_POST['model']) && isset($_POST['bodytype'])) {
        // Insert new entry
        $make = htmlspecialchars($_POST['make']);
        $model = htmlspecialchars($_POST['model']);
        $bodytype = htmlspecialchars($_POST['bodytype']);

        
        $insert_sql = 'INSERT INTO vehicles (make, model, bodytype) VALUES (:make, :model, :bodytype)';
        $stmt_insert = $pdo->prepare($insert_sql);
        $stmt_insert->execute(['make' => $make, 'model' => $model, 'bodytype' => $bodytype]);
    } elseif (isset($_POST['delete_id'])) {
        // Delete an entry
        $delete_id = (int) $_POST['delete_id'];
        
        $delete_sql = 'DELETE FROM vehicles WHERE id = :id';
        $stmt_delete = $pdo->prepare($delete_sql);
        $stmt_delete->execute(['id' => $delete_id]);
    }
}

// Get all vehicles for the catalog
$sql = 'SELECT id, make, model, year, mileage, cost FROM vehicles';
$stmt = $pdo->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Catalog - EZimports</title>
    <link rel="stylesheet" href="styles.css">
    
</head>
<body>
    <header>
        <h1>EZimports Inventory</h1>
        <nav><p></p>
            <a href="index.html">Home</a> |
            <a href="catalog.php">Catalogue</a> | 
            <a href="about.html">About</a>
            </p></nav>
    </header>
    <div class="container">
        <h1>Vehicle Catalog</h1>
        <div class="vehicle-grid">
            <?php while ($row = $stmt->fetch()): ?>
            <div class="vehicle-card">
                <div class="vehicle-image">
                    <!-- Placeholder for car image -->
                    <img src="gtr.jpg" alt="Vehicle Image" style="width:100%; height:100%; object-fit:cover;">
                </div>
                <div class="vehicle-details">
                    <h3><?php echo htmlspecialchars($row['make'] . ' ' . $row['model']); ?></h3>
                    <p><strong>Year:</strong> <?php echo htmlspecialchars($row['year']); ?></p>
                    <p><strong>Mileage:</strong> <?php echo htmlspecialchars($row['mileage']); ?> miles</p>
                    <p><strong>Cost:</strong> $<?php echo htmlspecialchars($row['cost']); ?></p>
                </div>
                <div class="vehicle-actions">
                    <form action="catalog.php" method="post" style="display:inline;">
                        <input type="hidden" name="delete_id" value="<?php echo $row['id']; ?>">
                        <button type="submit" class="btn">Mark as Sold</button>
                    </form>
                </div>
            </div>
            <?php endwhile; ?>
        </div>
    </div>
</body>
</html>

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

// Handle deletion of a vehicle
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete_id'])) {
    $delete_id = (int) $_POST['delete_id'];
    if ($delete_id > 0) {
        $delete_sql = 'DELETE FROM vehicles WHERE id = :id';
        $stmt_delete = $pdo->prepare($delete_sql);
        if ($stmt_delete->execute(['id' => $delete_id])) {
            header('Location: catalog.php');
            exit();
        } else {
            echo "<script>alert('Failed to delete vehicle');</script>";
        }
    }
}

// Handle adding a new vehicle
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_vehicle'])) {
    if (
        isset($_POST['year'], $_POST['make'], $_POST['model'], $_POST['bodytype'], $_POST['cost'], $_POST['mileage'], $_POST['image_url'])
    ) {
        $year = htmlspecialchars($_POST['year']);
        $make = htmlspecialchars($_POST['make']);
        $model = htmlspecialchars($_POST['model']);
        $bodytype = htmlspecialchars($_POST['bodytype']);
        $cost = htmlspecialchars($_POST['cost']);
        $mileage = htmlspecialchars($_POST['mileage']);
        $image_url = htmlspecialchars($_POST['image_url']);

        $insert_sql = 'INSERT INTO vehicles (year, make, model, bodytype, cost, mileage, image_url) VALUES (:year, :make, :model, :bodytype, :cost, :mileage, :image_url)';
        $stmt = $pdo->prepare($insert_sql);
        $stmt->execute([
            'year' => $year,
            'make' => $make,
            'model' => $model,
            'bodytype' => $bodytype,
            'cost' => $cost,
            'mileage' => $mileage,
            'image_url' => $image_url
        ]);
        header('Location: catalog.php');
        exit;
    }
}

// Fetch vehicles for the catalog
$sql = 'SELECT id, make, model, year, mileage, cost, image_url FROM vehicles';
$stmt = $pdo->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Catalog - EZimports</title>
    <link rel="icon" type="image/x-icon" href="favicon.ico">
    <link rel="stylesheet" href="styles.css">
    <style>
        .vehicle-image img {
            cursor: pointer;
            transition: transform 0.2s ease;
        }
        .vehicle-image img:hover {
            transform: scale(1.05);
        }
        .image-modal {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 1000;
            background: rgba(0, 0, 0, 0.8);
            padding: 10px;
            border-radius: 10px;
        }
        .image-modal img {
            max-width: 90%;
            max-height: 90%;
            display: block;
            margin: auto;
        }
        .image-modal-close {
            position: absolute;
            top: 10px;
            right: 10px;
            font-size: 24px;
            color: white;
            cursor: pointer;
            background: none;
            border: none;
        }
        .image-modal-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 999;
        }
    </style>
</head>
<body>
    <header>
        <h1>EZimports Inventory</h1>
        <nav>
            <a href="index.html">Home</a> |
            <a href="catalog.php">Catalogue</a> | 
            <a href="requests.php">Requests</a> | 
            <a href="about.html">About</a>
        </nav>
    </header>
    
    <div class="container">
        <!-- Add Vehicle Button -->
<button class="btn" id="openPopupBtn">Add Vehicle</button>

<!-- Popup Overlay -->
<div class="popup-overlay" id="popupOverlay"></div>

<!-- Popup Window -->
<div class="popup-window" id="popupContainer">
    <button class="popup-close-btn btn" id="closePopupBtn">&times;</button>
    <h2>Add a New Vehicle</h2>
    <form method="POST" action="catalog.php" class="popup-form">
        <input type="hidden" name="add_vehicle" value="1">

        <div class="form-group">
            <label for="year">Year</label>
            <input type="text" name="year" id="year" placeholder="Year" required>
        </div>
        <div class="form-group">
            <label for="make">Make</label>
            <input type="text" name="make" id="make" placeholder="Make" required>
        </div>
        <div class="form-group">
            <label for="model">Model</label>
            <input type="text" name="model" id="model" placeholder="Model" required>
        </div>
        <div class="form-group">
            <label for="bodytype">Body Type</label>
            <input type="text" name="bodytype" id="bodytype" placeholder="Body Type" required>
        </div>
        <div class="form-group">
            <label for="mileage">Mileage</label>
            <input type="text" name="mileage" id="mileage" placeholder="Mileage" required>
        </div>
        <div class="form-group">
            <label for="cost">Cost</label>
            <input type="text" name="cost" id="cost" placeholder="Cost" required>
        </div>
        <div class="form-group">
            <label for="image_url">Image URL</label>
            <input type="text" name="image_url" id="image_url" placeholder="Image URL" required>
        </div>
        <button type="submit" class="btn">Submit</button>
    </form>
</div>


        <h1>Vehicle Catalog</h1>
        <div class="vehicle-grid">
            <?php while ($row = $stmt->fetch()): ?>
            <div class="vehicle-card">
                <div class="vehicle-image">
                    <img src="<?php echo htmlspecialchars($row['image_url']); ?>" alt="Vehicle Image" 
                         style="width:100%; height:100%; object-fit:cover;" 
                         onclick="showImageModal('<?php echo htmlspecialchars($row['image_url']); ?>')">
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

    <footer class="footer">
        <p>© 2024 EZImports. All rights reserved.</p>
    </footer>

    <div class="image-modal-overlay" id="imageModalOverlay"></div>
    <div class="image-modal" id="imageModal">
        <button class="image-modal-close" id="imageModalClose">&times;</button>
        <img id="modalImage" src="" alt="Enlarg">

<script>const openPopupBtn = document.getElementById('openPopupBtn');
const popupContainer = document.getElementById('popupContainer');
const popupOverlay = document.getElementById('popupOverlay');
const closePopupBtn = document.getElementById('closePopupBtn');

openPopupBtn.addEventListener('click', () => {
    popupContainer.style.display = 'block';
    popupOverlay.style.display = 'block';
});

closePopupBtn.addEventListener('click', () => {
    popupContainer.style.display = 'none';
    popupOverlay.style.display = 'none';
});

popupOverlay.addEventListener('click', () => {
    popupContainer.style.display = 'none';
    popupOverlay.style.display = 'none';
});
</script>

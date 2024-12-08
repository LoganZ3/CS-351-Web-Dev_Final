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

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_vehicle'])) {
    // Check if all required fields are set
    if (
        isset($_POST['year']) &&
        isset($_POST['make']) &&
        isset($_POST['model']) &&
        isset($_POST['bodytype']) &&
        isset($_POST['cost']) &&
        isset($_POST['mileage'])
    ) {
        // Sanitize input
        $year = htmlspecialchars($_POST['year']);
        $make = htmlspecialchars($_POST['make']);
        $model = htmlspecialchars($_POST['model']);
        $bodytype = htmlspecialchars($_POST['bodytype']);
        $cost = htmlspecialchars($_POST['cost']);
        $mileage = htmlspecialchars($_POST['mileage']);

        // Insert new entry into the database
        $insert_sql = 'INSERT INTO vehicles (year, make, model, bodytype, cost, mileage) VALUES (:year, :make, :model, :bodytype, :cost, :mileage)';
        $stmt = $pdo->prepare($insert_sql);
        $stmt->execute([
            'year' => $year,
            'make' => $make,
            'model' => $model,
            'bodytype' => $bodytype,
            'cost' => $cost,
            'mileage' => $mileage
        ]);

        // Redirect to avoid form resubmission
        header('Location: catalog.php');
        exit;
    }
}

// Fetch vehicles for the catalog
$sql = 'SELECT id, make, model, year, mileage, cost FROM vehicles';
$stmt = $pdo->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Catalog - EZimports</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        /* Styling for the button */
        .open-popup-btn {
            margin: 10px 0;
            padding: 10px 20px;
            background-color: #007BFF;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        /* Popup container styling */
        .popup-container {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
            z-index: 1000;
        }

        /* Close button for popup */
        .popup-close-btn {
            position: absolute;
            top: 10px;
            right: 10px;
            background: none;
            border: none;
            font-size: 18px;
            cursor: pointer;
        }

        /* Overlay to dim background when popup is open */
        .popup-overlay {
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
            <a href="about.html">About</a>
        </nav>
    </header>
    
    <div class="container">
        <!-- Add Vehicle Button -->
        <button class="open-popup-btn" id="openPopupBtn">Add Vehicle</button>

        <!-- Popup Overlay -->
        <div class="popup-overlay" id="popupOverlay"></div>

        <!-- Popup Container -->
        <div class="popup-container" id="popupContainer">
            <button class="popup-close-btn" id="closePopupBtn">&times;</button>
            <h3>Add a New Vehicle</h3>
            <form method="POST" action="catalog.php">
                <input type="hidden" name="add_vehicle" value="1">
                <input type="text" name="year" placeholder="Year" required><br>
                <input type="text" name="make" placeholder="Make" required><br>
                <input type="text" name="model" placeholder="Model" required><br>
                <input type="text" name="bodytype" placeholder="Body Type" required><br>
                <input type="text" name="mileage" placeholder="Mileage" required><br>
                <input type="text" name="cost" placeholder="Cost" required><br>
                <button type="submit">Submit</button>
            </form>
        </div>

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

    <script>
        // JavaScript for opening and closing the popup
        const openPopupBtn = document.getElementById('openPopupBtn');
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
</body>
</html>

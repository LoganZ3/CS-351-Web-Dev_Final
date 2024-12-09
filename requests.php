<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $host = 'localhost';
    $db = 'vehicles';
    $user = 'logan';
    $password = 'logan'; // Use your AMMPS password

    // Collect form data
    $year = $_POST['year'];
    $make = $_POST['make'];
    $model = $_POST['model'];
    $ownership = $_POST['ownership'];
    $price = isset($_POST['price']) ? $_POST['price'] : null;
    $vehiclecondition = $_POST['vehiclecondition'];
    $port = $_POST['port'];

    try {
        // Establish a connection to the database
        $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Prepare the SQL query
        $stmt = $pdo->prepare("
            INSERT INTO requests (year, make, model, ownership, price, vehiclecondition, port)
            VALUES (:year, :make, :model, :ownership, :price, :vehiclecondition, :port)
        ");

        // Bind the form data to the SQL query
        $stmt->bindParam(':year', $year);
        $stmt->bindParam(':make', $make);
        $stmt->bindParam(':model', $model);
        $stmt->bindParam(':ownership', $ownership);
        $stmt->bindParam(':price', $price, PDO::PARAM_INT);
        $stmt->bindParam(':vehiclecondition', $vehiclecondition);
        $stmt->bindParam(':port', $port);

        // Execute the query
        $stmt->execute();

        // Confirm successful submission
        echo "<script>alert('Request submitted successfully!');</script>";
    } catch (PDOException $e) {
        // Handle database errors
        echo "<script>alert('Failed to submit request: " . $e->getMessage() . "');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vehicle Request</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        .hidden {
            display: none;
        }
    </style>
</head>
<body>
    <header>
        <h1>EZImports - Request a Vehicle Import</h1>
    </header>
    <main>
        <div class="form-container">
            <h2>Request a Vehicle</h2>
            <form method="POST" action="requests.php">
                <label for="year">Year:</label>
                <input type="text" id="year" name="year" placeholder="Enter year" required>

                <label for="make">Make:</label>
                <input type="text" id="make" name="make" placeholder="Enter make" required>

                <label for="model">Model:</label>
                <input type="text" id="model" name="model" placeholder="Enter model" required>

                <label>Do you already own the vehicle?</label>
                <div class="radio-group">
                    <label><input type="radio" name="ownership" value="yes" onclick="togglePriceField(false)"> Yes</label>
                    <label><input type="radio" name="ownership" value="no" onclick="togglePriceField(true)"> No</label>
                </div>

                <div id="priceField" class="hidden">
                    <label for="price">Desired Price ($):</label>
                    <input type="number" id="price" name="price" min="1000" max="100000" step="1000" placeholder="Enter price">
                    <p class="fine-print">*Price may fluctuate within $5000 of the entered value.</p>
                </div>

                <label for="vehiclecondition">Desired condition of Vehicle:</label>
                <select id="vehiclecondition" name="vehiclecondition" required>
                    <option value="Excellent">Excellent</option>
                    <option value="Very Good">Very Good</option>
                    <option value="Good">Good</option>
                    <option value="Bad">Bad</option>
                </select>
                <p class="fine-print">*Condition will heavily impact availability and wait time for specific vehicles.</p>

                <label for="port">Desired Port:</label>
                <select id="port" name="port" required>
                    <option value="Los Angeles">Los Angeles</option>
                    <option value="New York">New York</option>
                    <option value="Houston">Houston</option>
                    <option value="Savannah">Savannah</option>
                    <option value="Seattle">Seattle</option>
                </select>

                <button type="submit" class="btn" style="margin-top: 10px;">Submit Request</button>
            </form>
        </div>
    </main>
    <footer class="footer">
        <p>© 2024 EZImports. All rights reserved.</p>
    </footer>

    <script>
        function togglePriceField(show) {
            const priceField = document.getElementById('priceField');
            priceField.style.display = show ? 'block' : 'none';
        }

        // Initialize the page state based on the "Do you already own the vehicle?" selection
        document.addEventListener('DOMContentLoaded', () => {
            const ownershipRadios = document.getElementsByName('ownership');
            for (const radio of ownershipRadios) {
                if (radio.checked && radio.value === 'no') {
                    togglePriceField(true);
                    break;
                }
            }
        });
    </script>
</body>
</html>

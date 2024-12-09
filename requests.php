<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vehicle Request - EZimports</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        /* Simple styling for toggling input visibility */
        .hidden {
            display: none;
        }
    </style>
</head>
<body>
    <header>
        <h1>Request a Vehicle</h1>
        <nav>
            <a href="index.html">Home</a> |
            <a href="catalog.php">Catalogue</a> |
            <a href="about.html">About</a>
        </nav>
    </header>
    <main>
        <form method="POST" action="requests.php">
            <div>
                <label for="year">Year:</label>
                <input type="number" name="year" id="year" placeholder="e.g., 1999" required>
            </div>
            <div>
                <label for="make">Make:</label>
                <input type="text" name="make" id="make" placeholder="e.g., Toyota" required>
            </div>
            <div>
                <label for="model">Model:</label>
                <input type="text" name="model" id="model" placeholder="e.g., Supra" required>
            </div>
            <div>
                <label for="mileage_toggle">Specify Mileage Range?</label>
                <input type="checkbox" id="mileage_toggle">
            </div>
            <div id="mileage_range" class="hidden">
                <label for="mileage_min">Mileage Range:</label>
                <input type="number" name="mileage_min" placeholder="Min mileage">
                <input type="number" name="mileage_max" placeholder="Max mileage">
            </div>
            <div>
                <label for="price_toggle">Specify Price Range?</label>
                <input type="checkbox" id="price_toggle">
            </div>
            <div id="price_range" class="hidden">
                <label for="price_min">Price Range:</label>
                <input type="number" name="price_min" placeholder="Min price">
                <input type="number" name="price_max" placeholder="Max price">
            </div>
            <div>
                <button type="submit">Submit Request</button>
            </div>
        </form>
    </main>
    <script>
        // Toggle visibility for mileage range
        document.getElementById('mileage_toggle').addEventListener('change', function() {
            document.getElementById('mileage_range').classList.toggle('hidden', !this.checked);
        });
        // Toggle visibility for price range
        document.getElementById('price_toggle').addEventListener('change', function() {
            document.getElementById('price_range').classList.toggle('hidden', !this.checked);
        });
    </script>
</body>
</html>

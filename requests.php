<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vehicle Request</title>
    <link rel="stylesheet" href="styles.css">
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
                    <label><input type="radio" name="ownership" value="yes" onclick="toggleRangeFields(false)"> Yes</label>
                    <label><input type="radio" name="ownership" value="no" onclick="toggleRangeFields(true)"> No</label>
                </div>

                <div class="range-container">
                    <label for="mileageRange">Mileage Range (miles):</label>
                    <div class="dual-slider">
                        <input type="number" id="mileageMin" name="mileageMin" min="0" max="300000" step="1000" value="50000" 
                            oninput="updateSlider('mileage')">
                        <input type="range" id="mileageRange" name="mileageRange" min="0" max="300000" step="1000" 
                            value="50000" oninput="updateInputs('mileage')">
                        <input type="number" id="mileageMax" name="mileageMax" min="0" max="300000" step="1000" value="150000" 
                            oninput="updateSlider('mileage')">
                    </div>

                    <label for="priceRange">Price Range ($):</label>
                    <div class="dual-slider">
                        <input type="number" id="priceMin" name="priceMin" min="1000" max="100000" step="1000" value="10000" 
                            oninput="updateSlider('price')">
                        <input type="range" id="priceRange" name="priceRange" min="1000" max="100000" step="1000" 
                            value="10000" oninput="updateInputs('price')">
                        <input type="number" id="priceMax" name="priceMax" min="1000" max="100000" step="1000" value="50000" 
                            oninput="updateSlider('price')">
                    </div>
                </div>


                <label for="port">Desired Port:</label>
                <select id="port" name="port">
                    <option value="Los Angeles">Los Angeles</option>
                    <option value="New York">New York</option>
                    <option value="Houston">Houston</option>
                    <option value="Savannah">Savannah</option>
                    <option value="Seattle">Seattle</option>
                </select>

                <button type="submit" class="btn">Submit Request</button>
            </form>
        </div>
    </main>
    <footer>
        <p >© 2024 EZImports. All rights reserved.</p>
    </footer>

    <script>
        function toggleRangeFields(show) {
            const rangeFields = document.getElementById('rangeFields');
            rangeFields.style.display = show ? 'block' : 'none';
        }

        function updateSlider(type) {
    const minInput = document.getElementById(`${type}Min`);
    const maxInput = document.getElementById(`${type}Max`);
    const rangeInput = document.getElementById(`${type}Range`);

    // Sync slider values with input boxes
    rangeInput.value = Math.max(minInput.value, Math.min(maxInput.value, rangeInput.value));
}

function updateInputs(type) {
    const rangeInput = document.getElementById(`${type}Range`);
    const minInput = document.getElementById(`${type}Min`);
    const maxInput = document.getElementById(`${type}Max`);

    // Update inputs based on slider
    const rangeValue = parseInt(rangeInput.value, 10);
    if (rangeValue < parseInt(maxInput.value, 10)) {
        minInput.value = rangeValue;
    } else {
        maxInput.value = rangeValue;
    }
}

    </script>
</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vehicle Request</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f9f9f9;
        }

        .form-container {
            max-width: 600px;
            margin: 0 auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        }

        .form-container h2 {
            margin-bottom: 20px;
        }

        .form-container label {
            display: block;
            margin-top: 15px;
            font-weight: bold;
        }

        .form-container input[type="text"], 
        .form-container input[type="number"] {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }

        .radio-group {
            display: flex;
            gap: 20px;
            margin-top: 10px;
        }

        .range-container {
            display: none;
            margin-top: 15px;
        }

        .range-input {
            display: flex;
            gap: 10px;
            align-items: center;
        }

        .range-slider {
            width: 100%;
        }
    </style>
</head>
<body>
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

            <div class="range-container" id="rangeFields">
                <label for="mileage">Mileage Range:</label>
                <div class="range-input">
                    <input type="range" id="mileageMin" name="mileageMin" min="0" max="300000" step="1000" value="50000" class="range-slider" 
                           oninput="updateRangeValues('mileageMin', 'mileageMax', 'mileageRange')">
                    <input type="range" id="mileageMax" name="mileageMax" min="0" max="300000" step="1000" value="150000" class="range-slider"
                           oninput="updateRangeValues('mileageMin', 'mileageMax', 'mileageRange')">
                </div>
                <p id="mileageRange">50,000 - 150,000 miles</p>

                <label for="price">Price Range:</label>
                <div class="range-input">
                    <input type="range" id="priceMin" name="priceMin" min="1000" max="100000" step="1000" value="10000" class="range-slider"
                           oninput="updateRangeValues('priceMin', 'priceMax', 'priceRange')">
                    <input type="range" id="priceMax" name="priceMax" min="1000" max="100000" step="1000" value="50000" class="range-slider"
                           oninput="updateRangeValues('priceMin', 'priceMax', 'priceRange')">
                </div>
                <p id="priceRange">$10,000 - $50,000</p>
            </div>

            <button type="submit" style="margin-top: 20px; padding: 10px 20px; background-color: #007BFF; color: white; border: none; border-radius: 5px; cursor: pointer;">
                Submit Request
            </button>
        </form>
    </div>

    <script>
        function toggleRangeFields(show) {
            const rangeFields = document.getElementById('rangeFields');
            rangeFields.style.display = show ? 'block' : 'none';
        }

        function updateRangeValues(minId, maxId, displayId) {
            const minVal = document.getElementById(minId).value;
            const maxVal = document.getElementById(maxId).value;
            document.getElementById(displayId).textContent = 
                `${minId.includes('mileage') ? parseInt(minVal).toLocaleString() + ' - ' + parseInt(maxVal).toLocaleString() + ' miles' : 
                '$' + parseInt(minVal).toLocaleString() + ' - $' + parseInt(maxVal).toLocaleString()}`;
        }
    </script>
</body>
</html>

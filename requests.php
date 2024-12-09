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
                    <label><input type="radio" name="ownership" value="yes"> Yes</label>
                    <label><input type="radio" name="ownership" value="no"> No</label>
                </div>

                <label for="price">Desired Price ($):</label>
                <p class="fine-print" style="font-size: smaller;">*Price may fluctuate within $5000 of the entered value.</p>
                <input type="number" id="price" name="price" min="1000" max="1000000" step="1000" placeholder="Enter price" required>

                <label for="condition">Desired Condition of Vehicle:</label>
                <select id="condition" name="condition" required>
                    <option value="Excellent">Excellent</option>
                    <option value="Very Good">Very Good</option>
                    <option value="Good">Good</option>
                    <option value="Bad">Bad</option>
                </select>
                <p class="fine-print" style="font-size: smaller;">*Condition will heavily impact availability and wait time for specific vehicles.</p>

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
</body>
</html>

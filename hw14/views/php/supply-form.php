<?php
session_start();

// Verify that the user is authenticated and has the correct role
if (!isset($_SESSION['user']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'administrator') {
    header('Location: ../../index.php?error=no_session');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Supply Registration | Fábula Dental</title>
    
    <link rel="stylesheet" href="../css/forms.css">
</head>

<body>

    <header>
        <h1>Fábula Dental</h1>
    </header>

    <main class="form-container">
        <div class="form-card">
            <h2>Register New Supply</h2>

            <form id="supplyForm" action="../../controllers/supply-controller.php" method="POST" class="form-grid">

                <input type="hidden" name="action" value="create">

                <div class="input-group full-width">
                    <label for="supplyName">Product / Medication Name</label>
                    <input type="text" id="supplyName" name="supplyName" placeholder="e.g. 3M Composite Resin" required>
                </div>

                <div class="input-group">
                    <label for="quantity">Initial Quantity</label>
                    <input type="number" id="quantity" name="quantity" min="1" step="1" placeholder="e.g. 10" required>
                </div>

                <div class="input-group">
                    <label for="unitCost">Unit Cost ($)</label>
                    <input type="number" id="unitCost" name="unitCost" min="0.01" step="0.01" placeholder="e.g. 5.50" required>
                </div>

                <div class="input-group">
                    <label for="orderDate">Order Date</label>
                    <input type="date" id="orderDate" name="orderDate" required>
                </div>

                <div class="input-group">
                    <label for="expirationDate">Expiration Date</label>
                    <input type="date" id="expirationDate" name="expirationDate" required>
                </div>

                <div class="input-group full-width">
                    <button type="submit" class="btn btn-primary">Save to Inventory</button>
                </div>

                <div class="full-width actions-row">
                    <a href="supply-list.php" class="btn btn-secondary">View Inventory</a>
                    <a href="administrator.php" class="btn btn-secondary">Back to Dashboard</a>
                </div>

            </form>
        </div>
    </main>

    <script src="../js/supply-validation.js"></script>
</body>

</html>

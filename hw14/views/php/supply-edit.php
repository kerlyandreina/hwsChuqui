<?php
session_start();

// Verify active session
if (!isset($_SESSION['user']) || !isset($_SESSION['role'])) {
    header('Location: ../../index.php?error=no_session');
    exit;
}

require_once '../../dbCredentials.php';
require_once '../../models/Supply.php';

$id = $_GET['id'] ?? null;

if (!$id) {
    header('Location: supply-list.php');
    exit;
}

$supply = Supply::find($id);

if (!$supply) {
    header('Location: supply-list.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Supply | Fábula Dental</title>
    
    <link rel="stylesheet" href="../css/forms.css">
</head>

<body>

    <header>
        <h1>Fábula Dental</h1>
    </header>

    <main class="form-container">
        <div class="form-card">
            <h2>Edit Supply</h2>

            <form id="supplyForm" action="../../controllers/supply-controller.php" method="POST" class="form-grid">

                <input type="hidden" name="action" value="update">
                <input type="hidden" name="id" value="<?= htmlspecialchars($supply->id) ?>">

                <div class="input-group full-width">
                    <label for="supplyName">Product / Medication Name</label>
                    <input type="text" id="supplyName" name="supplyName" value="<?= htmlspecialchars($supply->supplyName) ?>" required>
                </div>

                <div class="input-group">
                    <label for="quantity">Initial Quantity</label>
                    <input type="number" id="quantity" name="quantity" min="1" step="1" value="<?= htmlspecialchars($supply->quantity) ?>" required>
                </div>

                <div class="input-group">
                    <label for="unitCost">Unit Cost ($)</label>
                    <input type="number" id="unitCost" name="unitCost" min="0.01" step="0.01" value="<?= htmlspecialchars($supply->unitCost) ?>" required>
                </div>

                <div class="input-group">
                    <label for="orderDate">Order Date</label>
                    <input type="date" id="orderDate" name="orderDate" value="<?= htmlspecialchars($supply->orderDate) ?>" required>
                </div>

                <div class="input-group">
                    <label for="expirationDate">Expiration Date</label>
                    <input type="date" id="expirationDate" name="expirationDate" value="<?= htmlspecialchars($supply->expirationDate) ?>" required>
                </div>

                <div class="input-group full-width">
                    <button type="submit" class="btn btn-primary">Update Changes</button>
                </div>

                <div class="full-width actions-row">
                    <a href="supply-list.php" class="btn btn-secondary">Cancel</a>
                </div>

            </form>
        </div>
    </main>

    <script src="../js/supply-validation.js"></script>
</body>

</html>
<?php
session_start();

// Verify active session
if (!isset($_SESSION['user']) || !isset($_SESSION['role'])) {
    header('Location: ../../index.php?error=no_session');
    exit;
}

require_once '../../dbCredentials.php';
require_once '../../models/Supply.php';

$supplies = Supply::orderBy('created_at', 'desc')->get();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Supply Inventory | Fábula Dental</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/user-views.css">
    <link rel="stylesheet" href="../css/forms.css">
</head>

<body class="bg-light">
    <header class="bg-primary">
        <h1 class="text-white m-0">General Inventory - Fábula Dental</h1>
    </header>

    <main class="form-container">
        <div class="form-card w-100" style="max-width: 1200px;">
            <h2 class="text-primary fw-bold text-center mb-4">Supply List</h2>
            <div class="table-wrap">
                <table class="records-table w-100">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Quantity</th>
                            <th>Unit Cost ($)</th>
                            <th>Order Date</th>
                            <th>Expiration Date</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($supplies->isEmpty()): ?>
                            <tr>
                                <td colspan="7" class="text-center text-muted py-4">No supplies registered.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($supplies as $item): ?>
                                <tr>
                                    <td><?= htmlspecialchars($item->supplyName) ?></td>
                                    <td><?= htmlspecialchars($item->quantity) ?></td>
                                    <td>$<?= number_format($item->unitCost, 2) ?></td>
                                    <td><?= date('m/d/Y', strtotime($item->orderDate)) ?></td>
                                    <td><?= date('m/d/Y', strtotime($item->expirationDate)) ?></td>
                                    <td class="text-center">
                                        <?php if ($item->status === 'Current'): ?>
                                            <span class="badge bg-success">Current</span>
                                        <?php elseif ($item->status === 'NextExpiration'): ?>
                                            <span class="badge bg-warning text-dark">Expiring Soon</span>
                                        <?php elseif ($item->status === 'Expired'): ?>
                                            <span class="badge bg-danger">Expired</span>
                                        <?php else: ?>
                                            <span class="badge bg-secondary">Unknown</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <div class="d-flex gap-2 justify-content-center">
                                            <a href="supply-edit.php?id=<?= $item->id ?>" class="btn btn-warning btn-sm">Edit</a>
                                            
                                            <form action="../../controllers/supply-controller.php" method="POST" class="delete-form m-0">
                                                <input type="hidden" name="action" value="delete">
                                                <input type="hidden" name="id" value="<?= $item->id ?>">
                                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            <div class="actions-row mt-4">
                <a href="supply-form.php" class="btn btn-secondary">Register New</a>
                <a href="administrator.php" class="btn btn-primary">Back to Dashboard</a>
            </div>
        </div>
    </main>

    <script src="../js/supply-list.js"></script>
</body>

</html>
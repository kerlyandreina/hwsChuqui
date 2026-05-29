<?php
session_start();

// Verify active session
if (!isset($_SESSION['user']) || !isset($_SESSION['role'])) {
    header('Location: ../../index.php?error=no_session');
    exit;
}

require_once '../../dbCredentials.php';
require_once '../../models/Payment.php';

$payments = Payment::orderBy('created_at', 'desc')->get();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment History | Fábula Dental</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../css/user-views.css">
    <link rel="stylesheet" href="../css/forms.css">
</head>

<body class="bg-light">
    <header class="bg-primary">
        <h1 class="text-white m-0">Revenue Control - Fábula Dental</h1>
    </header>

    <main class="container my-5 form-container">
        <div class="form-card w-100" style="max-width: 1200px;">
            <h2 class="text-primary fw-bold text-center mb-4">Payment Records</h2>

            <div class="table-wrap">
                <table class="records-table w-100">
                    <thead>
                        <tr>
                            <th>Patient (ID)</th>
                            <th>Amount ($)</th>
                            <th>Date</th>
                            <th>Type</th>
                            <th>Method</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($payments->isEmpty()): ?>
                            <tr>
                                <td colspan="7" class="text-center py-4 text-muted">No transactions registered.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($payments as $item): ?>
                                <tr>
                                    <td><?= htmlspecialchars($item->patientID) ?></td>
                                    <td>$<?= number_format($item->amount, 2) ?></td>
                                    <td><?= date('m/d/Y', strtotime($item->date)) ?></td>
                                    <td>
                                        <?php if ($item->paymentType === 'Deposit'): ?>
                                            Deposit
                                        <?php elseif ($item->paymentType === 'Final'): ?>
                                            Final
                                        <?php else: ?>
                                            <?= htmlspecialchars($item->paymentType) ?>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if ($item->paymentMethod === 'Cash'): ?>
                                            Cash
                                        <?php elseif ($item->paymentMethod === 'Card'): ?>
                                            Card
                                        <?php elseif ($item->paymentMethod === 'Transfer'): ?>
                                            Transfer
                                        <?php else: ?>
                                            <?= htmlspecialchars($item->paymentMethod) ?>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-center">
                                        <?php if ($item->status === 'Completed'): ?>
                                            <span class="badge bg-success">Completed</span>
                                        <?php elseif ($item->status === 'Partial'): ?>
                                            <span class="badge bg-warning text-dark">Partial</span>
                                        <?php else: ?>
                                            <span class="badge bg-secondary">Pending</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <div class="d-flex gap-2 justify-content-center">
                                            <a href="payment-edit.php?id=<?= $item->id ?>" class="btn btn-warning btn-sm">Edit</a>
                                            <form action="../../controllers/payment-controller.php" method="POST" class="delete-form m-0">
                                                <input type="hidden" name="action" value="delete">
                                                <input type="hidden" name="id" value="<?= $item->id ?>">
                                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Delete this payment record?');">Delete</button>
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
                <a href="../html/payment-form.html" class="btn btn-secondary">Register Payment</a>
                <a href="../php/receptionist.php" class="btn btn-primary">Back to Dashboard</a>
            </div>
        </div>
    </main>

</body>

</html>
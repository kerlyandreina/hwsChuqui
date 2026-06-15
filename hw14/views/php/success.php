<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Successful Registration | Fábula Dental</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/user-views.css">
    <link rel="stylesheet" href="../css/forms.css">
</head>

<body class="bg-light">

    <header class="bg-primary shadow-sm">
        <h1 class="text-white m-0">Fábula Dental</h1>
    </header>

    <main class="form-container">
        <div class="form-card shadow-sm text-center">
            <div class="mb-4">
                <i class="bi bi-check-circle-fill text-success fs-1"></i>
                <h2 class="text-success fw-bold mt-2">Registration Successful!</h2>
                <p class="text-muted">The record has been saved successfully to the database.</p>
            </div>

            <div class="actions-row d-flex justify-content-center gap-3 flex-wrap">
                <?php
                $type = $_GET['type'] ?? '';
                
                if ($type === 'patient') {
                    echo '<a href="../html/patient-form.html" class="btn btn-secondary">Add another patient</a>';
                    echo '<a href="./patient-list.php" class="btn btn-primary">View patients</a>';
                } elseif ($type === 'payment') {
                    echo '<a href="../html/payment-form.html" class="btn btn-secondary">Register another payment</a>';
                    echo '<a href="./payment-list.php" class="btn btn-primary">View payment history</a>';
                } elseif ($type === 'supply') {
                    echo '<a href="supply-form.php" class="btn btn-secondary">Add another supply</a>';
                    echo '<a href="./supply-list.php" class="btn btn-primary">View inventory</a>';
                }
                ?>
            </div>

            <hr class="my-4 opacity-25">

            <div class="d-grid gap-2 col-md-6 mx-auto">
                <a href="../../index.php" class="btn btn-outline-secondary">Back to Main Dashboard</a>
            </div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
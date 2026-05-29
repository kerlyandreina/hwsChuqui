<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Error | Fábula Dental</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
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
                <i class="bi bi-exclamation-triangle-fill text-danger fs-1"></i>
                <h2 class="text-danger fw-bold mt-2">Registration Error!</h2>
                <p class="text-muted">There was a problem trying to save the information to the database. Please check the data and try again.</p>
            </div>

            <div class="actions-row d-flex justify-content-center gap-3 flex-wrap">
                <?php
                $type = $_GET['type'] ?? '';
                
                if ($type === 'patient') {
                    echo '<a href="../html/patient-form.html" class="btn btn-primary">Back to form</a>';
                } elseif ($type === 'payment') {
                    echo '<a href="../html/payment-form.html" class="btn btn-primary">Back to form</a>';
                } elseif ($type === 'supply') {
                    echo '<a href="supply-form.php" class="btn btn-primary">Back to form</a>';
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
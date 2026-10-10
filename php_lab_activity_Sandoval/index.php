<?php
include('dbcon.php');

$message = '';
$alertType = '';

// Handle Form Submission (INSERT)
if (isset($_POST['save_user'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email    = mysqli_real_escape_string($conn, $_POST['email']);

    if (!empty($name) && !empty($email)) {
        $query = "INSERT INTO users (name, email) VALUES ('$name', '$email')";
        $query_run = mysqli_query($conn, $query);

        if ($query_run) {
            $message = "User added successfully!";
            $alertType = "success";
        } else {
            $message = "Failed to add user: " . mysqli_error($conn);
            $alertType = "danger";
        }
    } else {
        $message = "Please fill in all fields.";
        $alertType = "warning";
    }
}

// Check for status messages passed via GET (e.g., from update/delete operations)
if (isset($_GET['status'])) {
    if ($_GET['status'] == 'updated') {
        $message = "User updated successfully!";
        $alertType = "info";
    } elseif ($_GET['status'] == 'deleted') {
        $message = "User deleted successfully!";
        $alertType = "warning";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Display and Creation</title>
    <!-- Bootstrap 5 CSS CDN -->
    <link href="https://jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">

                <!-- Bootstrap Alert Notification -->
                <?php if (!empty($message)): ?>
                    <div class="alert alert-<?= $alertType; ?> alert-dismissible fade show" role="alert">
                        <?= $message; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <!-- User Creation Form Card -->
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Add New User</h5>
                    </div>
                    <div class="card-body">
                        <form action="" method="POST">
                            <div class="mb-3">
                                <label for="name" class="form-label">Full Name</label>
                                <input type="text" name="name" id="name" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email Address</label>
                                <input type="email" name="email" id="email" class="form-control" required>
                            </div>
                            <button type="submit" name="save_user" class="btn btn-primary">Save User</button>
                        </form>
                    </div>
                </div>

                <!-- User Display Table Card -->
                <div class="card shadow-sm">
                    <div class="card-header bg-dark text-white">
                        <h5 class="mb-0">Existing Users</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped align-middle">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Full Name</th>
                                        <th>Email Address</th>
                                        <th>Created At</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $fetch_query = "SELECT * FROM users ORDER BY id DESC";
                                    $result = mysqli_query($conn, $fetch_query);

                                    if (mysqli_num_rows($result) > 0) {
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            ?>
                                            <tr>
                                                <td><?= $row['id']; ?></td>
                                                <td><?= htmlspecialchars($row['name']); ?></td>
                                                <td><?= htmlspecialchars($row['email']); ?></td>
                                                <td><?= isset($row['created_at']) ? $row['created_at'] : 'N/A'; ?></td>
                                            </tr>
                                            <?php
                                        }
                                    } else {
                                        echo '<tr><td colspan="4" class="text-center">No users found.</td></tr>';
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"></script>
</body>
</html>

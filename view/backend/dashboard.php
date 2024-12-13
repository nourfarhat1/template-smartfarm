<?php
// Include the backend PHP logic
include '../Reclamation.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Reclamations - Dashboard</title>
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="main.css" rel="stylesheet">
</head>

<body class="contact-page">

<header id="header" class="header d-flex align-items-center position-relative">
    <!-- Your Header Code here -->
</header>

<main class="main">

    <!-- Page Title -->
    <div class="page-title dark-background" style="background-image: url(assets/img/page-title-bg.webp);">
        <div class="container position-relative">
            <h1>Reclamations</h1>
        </div>
    </div>

    <!-- Contact Section -->
    <section id="contact" class="contact section">
        <div class="container">

            <div class="row gy-5 gx-lg-5">

                <div class="col-lg-8">
                    <!-- Add Reclamation Form -->
                    <form action="reclamation_dashboard.php" method="post" role="form" class="php-email-form">
                        <div class="form-group mt-3">
                            <input type="text" name="subject" class="form-control" placeholder="Subject" required="">
                        </div>
                        <div class="form-group mt-3">
                            <textarea id="message" name="message" class="form-control" placeholder="Message" required=""></textarea>
                        </div>
                        <div class="text-center mt-4">
                            <button type="submit" name="add_reclamation" class="btn btn-primary">Send Reclamation</button>
                        </div>
                    </form>
                </div><!-- End Reclamation Form -->

            </div>

            <!-- Display Submitted Reclamations -->
            <h3 class="mt-5">Your Submitted Reclamations</h3>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Subject</th>
                        <th>Message</th>
                        <th>Submitted On</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($reclamations as $reclamation): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($reclamation['subject']); ?></td>
                            <td><?php echo htmlspecialchars($reclamation['message']); ?></td>
                            <td><?php echo htmlspecialchars($reclamation['created_at']); ?></td>
                            <td>
                                <!-- Update & Delete buttons -->
                                <a href="update_reclamation.php?id=<?php echo $reclamation['id']; ?>" class="btn btn-warning">
                                    <i class="bi bi-pencil"></i> Update
                                </a>
                                <a href="reclamation_dashboard.php?delete_id=<?php echo $reclamation['id']; ?>" class="btn btn-danger">
                                    <i class="bi bi-trash"></i> Delete
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

        </div>
    </section><!-- /Contact Section -->

</main>

<footer id="footer" class="footer dark-background">
    <!-- Footer code here -->
</footer>

<!-- Vendor JS Files -->
<script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

</body>
</html>

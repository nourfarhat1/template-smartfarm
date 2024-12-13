<?php
session_start(); // Start the session to access session variables

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to login page if the user is not logged in
    header('Location: login.php');
    exit();
}

// Get the user data from session
$user_id = $_SESSION['user_id'];
$email = $_SESSION['email'];
$role = $_SESSION['defintion'];

// You can now use these session variables for the logged-in user
echo "Welcome, $email! Your role is $role .";

?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reclamation List</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f4f4f4;
        }
    </style>
</head>
<body>
    <h1>Reclamation List</h1>
    <table>
    <thead>
    <tr>
        <th>ID</th>
        <th>User ID</th>
        <th>Description</th>
        <th>Status</th>
        <th>Date</th>
        <th>Actions</th>
    </tr>
</thead>
<tbody>
    <?php if (!empty($reclamations)) : ?>
        <?php foreach ($reclamations as $reclamation) : ?>
            <tr>
                <td><?= htmlspecialchars($reclamation['id']) ?></td>
                <td><?= htmlspecialchars($reclamation['id_user']) ?></td>
                <td><?= htmlspecialchars($reclamation['description']) ?></td>
                <td><?= htmlspecialchars($reclamation['status']) ?></td>
                <td><?= htmlspecialchars($reclamation['date']) ?></td>
                <td>
                    <!-- Delete Button -->
                    <form action="deleteReclamation.php" method="POST" style="display:inline;">
                        <input type="hidden" name="id" value="<?= htmlspecialchars($reclamation['id']) ?>">
                        <button type="submit">Delete</button>
                    </form>

                    <!-- Update Button -->
                    <form action="updateReclamation.php" method="GET" style="display:inline;">
                        <input type="hidden" name="id" value="<?= htmlspecialchars($reclamation['id']) ?>">
                        <button type="submit">Update</button>
                    </form>
                    <!-- Answer Button -->
                    <form action="awnser.php" method="GET" style="display:inline;">
                        <input type="hidden" name="id" value="<?= htmlspecialchars($reclamation['id']) ?>">
                        <button type="submit">Answer</button>
                    </form>
                    <!-- See Answer Button -->
                    <form action="affichereponse.php" method="GET" style="display:inline;">
                        <input type="hidden" name="id" value="<?= htmlspecialchars($reclamation['id']) ?>">
                        <button type="submit">See Answer</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    <?php else : ?>
        <tr>
            <td colspan="6">No reclamations found.</td>
        </tr>
    <?php endif; ?>
</tbody>
    </table>
</body>
</html>
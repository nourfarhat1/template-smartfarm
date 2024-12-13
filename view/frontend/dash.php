<?php
// Database connection
$host = "localhost";
$dbname = "smartf";
$username = "root";
$password = "";

try {
    $connection = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Handle Delete
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $sql = "DELETE FROM users WHERE id = :id";
    $stmt = $connection->prepare($sql);
    $stmt->bindParam(':id', $delete_id, PDO::PARAM_INT);
    $stmt->execute();
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

// Handle Create (Insert)
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['create_user'])) {
    $prenom = trim($_POST['prenom']);
    $nom = trim($_POST['nom']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $role = trim($_POST['role']);

    if (empty($prenom) || empty($nom) || empty($email) || empty($password) || empty($role)) {
        echo "All fields are required!";
    } else {
        // Hash password
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);

        // Insert into the database
        $sql = "INSERT INTO users (prenom, nom, email, password, role) VALUES (:prenom, :nom, :email, :password, :role)";
        $stmt = $connection->prepare($sql);
        $stmt->bindParam(':prenom', $prenom);
        $stmt->bindParam(':nom', $nom);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $hashed_password);
        $stmt->bindParam(':role', $role);

        if ($stmt->execute()) {
            header("Location: " . $_SERVER['PHP_SELF']);
            exit;
        } else {
            echo "Error creating user.";
        }
    }
}

// Handle Update (Edit)
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_user'])) {
    $id = $_POST['id'];
    $prenom = trim($_POST['prenom']);
    $nom = trim($_POST['nom']);
    $email = trim($_POST['email']);
    $role = trim($_POST['role']);
    $password = trim($_POST['password']);

    if (empty($prenom) || empty($nom) || empty($email) || empty($role)) {
        echo "All fields except password are required!";
    } else {
        if (!empty($password)) {
            $hashed_password = password_hash($password, PASSWORD_BCRYPT);
            $sql = "UPDATE users SET prenom = :prenom, nom = :nom, email = :email, role = :role, password = :password WHERE id = :id";
            $stmt = $connection->prepare($sql);
            $stmt->bindParam(':password', $hashed_password);
        } else {
            $sql = "UPDATE users SET prenom = :prenom, nom = :nom, email = :email, role = :role WHERE id = :id";
            $stmt = $connection->prepare($sql);
        }

        $stmt->bindParam(':prenom', $prenom);
        $stmt->bindParam(':nom', $nom);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':role', $role);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            header("Location: " . $_SERVER['PHP_SELF']);
            exit;
        } else {
            echo "Error updating user.";
        }
    }
}

// Fetch all users or search based on the query
$searchQuery = isset($_GET['search']) ? trim($_GET['search']) : '';
if (!empty($searchQuery)) {
    $sql = "SELECT * FROM users WHERE 
            prenom LIKE :search OR 
            nom LIKE :search OR 
            email LIKE :search OR 
            role LIKE :search";
    $stmt = $connection->prepare($sql);
    $likeQuery = '%' . $searchQuery . '%';
    $stmt->bindParam(':search', $likeQuery, PDO::PARAM_STR);
} else {
    $sql = "SELECT * FROM users";
    $stmt = $connection->prepare($sql);
}

$stmt->execute();
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch user statistics (e.g., number of users per role)
$sql = "SELECT role, COUNT(id) as count FROM users GROUP BY role";
$stmt = $connection->prepare($sql);
$stmt->execute();
$userStats = $stmt->fetchAll(PDO::FETCH_ASSOC);
$roles = [];
$counts = [];

foreach ($userStats as $stat) {
    $roles[] = $stat['role'];
    $counts[] = $stat['count'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - User Management</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> <!-- Chart.js Library -->
    <style>
    
        /* Global Styling */
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
        }

        h1, h2 {
            text-align: center;
            color: #333;
        }

        a {
            color: #007bff;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        /* Form Styling */
        form {
            background: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-bottom: 30px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
            color: #555;
        }

        input, select, button {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 1rem;
        }

        button {
            background-color: #4caf50;
            color: #fff;
            cursor: pointer;
            font-weight: bold;
            border: none;
        }

        button:hover {
            background-color: #45a049;
        }

        /* Table Styling */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background: #ffffff;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        table th, table td {
            padding: 15px;
            text-align: left;
        }

        table th {
            background-color: #007bff;
            color: #ffffff;
            font-weight: bold;
        }

        table td {
            border-bottom: 1px solid #ddd;
        }

        table tr:hover {
            background-color: #f1f1f1;
        }

        /* Modal Styling */
        #edit-modal {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 400px;
            background-color: #ffffff;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
            border-radius: 10px;
            padding: 20px;
            z-index: 10;
        }

        #edit-modal h2 {
            margin-bottom: 20px;
            text-align: center;
        }

        #edit-modal button {
            margin-top: 10px;
        }

        #edit-modal .form-group {
            margin-bottom: 15px;
        }

        /* Overlay Styling */
        .overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.6);
            z-index: 5;
        }

        .overlay.active,
        #edit-modal.active {
            display: block;
        }

        

        /* Add your custom styling here */
        .chart-container {
            width: 80%;
            margin: 30px auto;
            padding: 20px;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
    
    </style>
    
</head>
<body>

    <h1>Admin Dashboard - User Management</h1>

    <!-- Search Bar -->
    <form method="GET" action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>" style="margin-bottom: 20px;">
        <input type="text" name="search" placeholder="Search users by name or email" value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>" style="padding: 10px; width: 300px;">
        <button type="submit" style="padding: 10px;">Search</button>
    </form>

    <!-- Create User Form -->
    <h2>Create User</h2>
    <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="POST">
        <div class="form-group">
            <label for="prenom">First Name</label>
            <input type="text" name="prenom" id="prenom" required>
        </div>
        <div class="form-group">
            <label for="nom">Last Name</label>
            <input type="text" name="nom" id="nom" required>
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" required>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" name="password" id="password" required>
        </div>
        <div class="form-group">
            <label for="role">Role</label>
            <select name="role" id="role" required>
                <option value="Client">Client</option>
                <option value="Admin">Admin</option>
                <option value="AgriCulture">AgriCulture</option>
                <option value="Livreur">Livreur</option>
            </select>
        </div>
        <button type="submit" name="create_user">Create User</button>
    </form>

    <!-- Display Users List -->
    <h2>Users List</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>
                <tr>
                    <td><?= htmlspecialchars($user['id']) ?></td>
                    <td><?= htmlspecialchars($user['prenom']) ?></td>
                    <td><?= htmlspecialchars($user['nom']) ?></td>
                    <td><?= htmlspecialchars($user['email']) ?></td>
                    <td><?= htmlspecialchars($user['role']) ?></td>
                    <td>
                        <a href="javascript:void(0);" onclick="editUser(<?= $user['id'] ?>, '<?= htmlspecialchars($user['prenom']) ?>', '<?= htmlspecialchars($user['nom']) ?>', '<?= htmlspecialchars($user['email']) ?>', '<?= htmlspecialchars($user['role']) ?>')">Edit</a> | 
                        <a href="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>?delete_id=<?= $user['id'] ?>" onclick="return confirm('Are you sure you want to delete?')">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <!-- Edit User Modal -->
    <div id="edit-modal" style="display:none;">
        <h2>Edit User</h2>
        <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="POST">
            <input type="hidden" name="id" id="edit-id">
            <div class="form-group">
                <label for="edit-prenom">First Name</label>
                <input type="text" name="prenom" id="edit-prenom" required>
            </div>
            <div class="form-group">
                <label for="edit-nom">Last Name</label>
                <input type="text" name="nom" id="edit-nom" required>
            </div>
            <div class="form-group">
                <label for="edit-email">Email</label>
                <input type="email" name="email" id="edit-email" required>
            </div>
            <div class="form-group">
                <label for="edit-role">Role</label>
                <select name="role" id="edit-role" required>
                    <option value="Client">Client</option>
                    <option value="Admin">Admin</option>
                    <option value="AgriCulture">AgriCulture</option>
                    <option value="Livreur">Livreur</option>
                </select>
            </div>
            <div class="form-group">
                <label for="edit-password">Password (Leave blank to keep existing)</label>
                <input type="password" name="password" id="edit-password">
            </div>
            <button type="submit" name="update_user">Update User</button>
        </form>
        <button onclick="document.getElementById('edit-modal').style.display='none'">Close</button>
    </div>
    <div class="chart-container">
        <h2>User Statistics by Role</h2>
        <canvas id="userStatsChart"></canvas>
    </div>

    <script>
        function editUser(id, prenom, nom, email, role) {
            document.getElementById('edit-id').value = id;
            document.getElementById('edit-prenom').value = prenom;
            document.getElementById('edit-nom').value = nom;
            document.getElementById('edit-email').value = email;
            document.getElementById('edit-role').value = role;
            document.getElementById('edit-modal').style.display = 'block';
        }
        

        // Chart.js code to render the statistics chart
        var ctx = document.getElementById('userStatsChart').getContext('2d');
        var userStatsChart = new Chart(ctx, {
            type: 'bar',  // You can change this to 'pie' or 'line' if preferred
            data: {
                labels: <?php echo json_encode($roles); ?>,  // Labels from database (roles)
                datasets: [{
                    label: 'Number of Users',
                    data: <?php echo json_encode($counts); ?>,  // Counts from database
                    backgroundColor: '#4caf50',  // Set color for the bars
                    borderColor: '#45a049',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

    </script>
</body>
</html>

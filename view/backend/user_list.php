<!-- view/frontend/user_list.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User List</title>
</head>
<body>
    <h2>List of Users</h2>
    <?php
    // Include user model and fetch users
    require_once __DIR__ . '/../../model/user.php';
    
    // Create connection to database
    $conn = new mysqli('localhost', 'root', '', 'testdata');
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Query to fetch all users
    $sql = "SELECT * FROM agriculture_users UNION ALL SELECT * FROM livreur_users UNION ALL SELECT * FROM simple_users";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<table border='1'>
            <tr><th>ID</th><th>Name</th><th>Email</th><th>Role</th><th>Actions</th></tr>";
        
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                <td>{$row['id']}</td>
                <td>{$row['nom']} {$row['prenom']}</td>
                <td>{$row['email']}</td>
                <td>{$row['definition']}</td>
                <td>
                    <a href='update_user.php?id={$row['id']}'>Edit</a> |
                    <a href='delete_user.php?id={$row['id']}'>Delete</a>
                </td>
            </tr>";
        }
        echo "</table>";
    } else {
        echo "No users found!";
    }

    $conn->close();
    ?>
</body>
</html>

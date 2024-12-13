<!-- view/backend/listReclamations.php -->
<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Email</th>
            <th>Subject</th>
            <th>Gender</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($reclamations as $reclamation): ?>
            <tr>
                <td><?= $reclamation['id']; ?></td>
                <td><?= $reclamation['first_name']; ?></td>
                <td><?= $reclamation['last_name']; ?></td>
                <td><?= $reclamation['email']; ?></td>
                <td><?= $reclamation['subject']; ?></td>
                <td><?= $reclamation['gender']; ?></td>
                <td>
                    <a href="../frontend/updateReclamation.php?id=<?= $reclamation['id']; ?>">Edit</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>


<form action="../../controller/reclamationcontroller.php" method="POST">
    <input type="hidden" name="id" value="<?= $reclamation['id']; ?>">
    <label>First Name:</label>
    <input type="text" name="first_name" value="<?= $reclamation['first_name']; ?>" required><br>

    <label>Last Name:</label>
    <input type="text" name="last_name" value="<?= $reclamation['last_name']; ?>" required><br>

    <label>Email:</label>
    <input type="email" name="email" value="<?= $reclamation['email']; ?>" required><br>

    <label>Subject:</label>
    <input type="text" name="subject" value="<?= $reclamation['subject']; ?>" required><br>

    <label>Gender:</label>
    <select name="gender">
        <option value="male" <?= $reclamation['gender'] == 'male' ? 'selected' : ''; ?>>Male</option>
        <option value="female" <?= $reclamation['gender'] == 'female' ? 'selected' : ''; ?>>Female</option>
    </select><br>

    <button type="submit">Update</button>
</form>
